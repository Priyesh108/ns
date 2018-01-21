<?php

namespace app\controllers;

use app\models\BillChallanMapping;
use app\models\Challans;
use app\models\Customers;
use app\models\TaxMapping;
use Yii;
use app\models\Bill;
use app\models\BillSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BillController implements the CRUD actions for Bill model.
 */
class BillController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','view','update','delete'],
                'rules' => [
                    [
                        'actions' => ['index','create','view','update','delete','sync'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /*
     * Creates bill from Unmerged Challans
     * */
    public function actionSync(){

        $challans = Challans::find()
            ->where('is_billed=:ib',[':ib'=>0])
            ->all();

        $merged_array = array();
        foreach ($challans as $challan){

            /*
             * Status:
             * 0->Pending,
             * 1->Approved,
             * 2->Merged,
             * 3->Billed
             * */
            $to_be_merged = Challans::find()
                ->where('is_billed=:ib',[':ib'=>0])
                ->andWhere('is_merged=:im',[':im'=>0])
                ->andWhere('status=:s',[':s'=>1])
                ->andWhere('customer_id=:cid',[':cid'=>$challan->customer_id])
                ->all();

            //Reason for if: The loop goes only once for a customer
            if(sizeof($to_be_merged) > 0){
                $temp = array();
                foreach ($to_be_merged as $record){
                    array_push($temp, $record->challan_number);
                }
                $merged_array[$challan->customer_id] = $temp;
                $temp = null;

                //Update is_merged field for all challans
                Challans::updateAll([
                    'is_merged' => 1,
                    'status' => 2
                ],'is_billed=:ib and is_merged=:im and customer_id=:cid and status=:s',
                    [':ib'=>0, ':im'=>0, ':cid'=>$challan->customer_id, ':s'=>1]);
            }
        }

        foreach ($merged_array as $customer=>$chlns){
            //Add Pending Order i.e. all customer related details
            $billNumber = $this->addPendingOrder($customer);

            //For each challans, add them to bill-challan mapping
            $this->addToBillChallanMapping($billNumber, $chlns);

            //calculate orderTotal and other amounts
            $orderTotalQuery = (new Yii\db\Query())
                ->select('sum(amount) as amount')
                ->from('challan_product_mapping')
                ->where(['in','challan_number',$chlns])
                ->one();
            $orderTotal = $orderTotalQuery['amount'];

            //Update order with remaining details and update the status
            $this->calculateTotalAmt($orderTotal, $billNumber, $customer);

            //Update Challan Status
            foreach ($chlns as $record){
                $record = Challans::find()
                    ->where('challan_number=:cn',[':cn'=>$record])
                    ->one();
                $record->is_billed = 1;
                $record->status = 3;
                $record->billing_date = date('Y-m-d H:i:s');
                $record->modified_at = date('Y-m-d H:i:s');
                $record->update();
            }
        }
    }


    /**
     * Displays a single Bill model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bill();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //Create Challan specific bill directly from challan Index
    public function actionCreateChallanSpecificBill(){
        $challan_number = $_POST['challan_number'];
        $challan = Challans::find()
            ->where('challan_number=:cn',[':cn'=>$challan_number])
            ->one();

        $billNumber = $this->addPendingOrder($challan->customer_id);

        $billChallan = new BillChallanMapping();
        $billChallan->bill_no = $billNumber;
        $billChallan->challan_number = $challan_number;
        $billChallan->save();

        //calculate orderTotal and other amounts
        $orderTotalQuery = (new Yii\db\Query())
            ->select('sum(amount) as amount')
            ->from('challan_product_mapping')
            ->where(['in','challan_number',[$challan_number]])
            ->one();
        $orderTotal = $orderTotalQuery['amount'];

        //Update order with remaining details and update the status
        $this->calculateTotalAmt($orderTotal, $billNumber, $challan->customer_id);

        //Update the challan
        $challan->is_merged = 1;
        $challan->is_billed = 1;
        $challan->status = 3;
        $challan->billing_date = date('Y-m-d H:i:s');
        $challan->modified_at = date('Y-m-d H:i:s');
        $challan->update();
    }

    //Create a pending order
    public function addPendingOrder($customerID){
        $customer = Customers::findOne($customerID);

        $bill = new Bill();
        $bill->attributes = $customer->attributes;
        $bill->bill_no = Yii::$app->servicehelper->newBillNo();
        $bill->status = 0;
        $bill->company_name = $customer->name;
        $bill->owner_name = $customer->owner;
        $bill->mobile_number = $customer->mobile_1;
        $bill->CGST = null;
        $bill->SGST = null;
        $bill->IGST = null;
        $bill->save(false);

        return $bill->bill_no;
    }

    //Add challan to Bill-Challan mapping
    public function addToBillChallanMapping($bill_number, $challans){
        foreach ($challans as $record){
            $chBillMapping = new BillChallanMapping();
            $chBillMapping->bill_no = $bill_number;
            $chBillMapping->challan_number = $record;
            $chBillMapping->save();
        }
    }

    //Calculate other taxes and netAmount from orderTotal and bill number and save them
    public function calculateTotalAmt($orderTotal, $billNumber, $customerId){
        $customer = Customers::findOne($customerId);
        $bill = Bill::find()
            ->where('bill_no=:bn',[':bn'=>$billNumber])
            ->one();

        $bill->order_total = $orderTotal;
        $netTotal = $orderTotal;
        if($customer->CGST){
            $tax = TaxMapping::find()
                ->where('name=:nm',[':nm'=>'CGST'])
                ->one();

            $CGST = $orderTotal * $tax['value'] / 100;
            $bill->CGST = $CGST;
            $netTotal += $CGST;
        }
        if($customer->SGST){
            $tax = TaxMapping::find()
                ->where('name=:nm',[':nm'=>'SGST'])
                ->one();

            $SGST = $orderTotal * $tax['value'] / 100;
            $bill->SGST = $SGST;
            $netTotal += $SGST;
        }
        if($customer->IGST){
            $tax = TaxMapping::find()
                ->where('name=:nm',[':nm'=>'IGST'])
                ->one();

            $IGST = $orderTotal * $tax['value'] / 100;
            $bill->IGST = $IGST;
            $netTotal += $IGST;
        }
        if($customer->VAT){
            $tax = TaxMapping::find()
                ->where('name=:nm',[':nm'=>'VAT'])
                ->one();

            $VAT = $orderTotal * $tax['value'] / 100;
            $bill->extra_charges = $VAT;
            $netTotal += $VAT;
        }
        $bill->net_total = $netTotal;
        $bill->is_paid = 0;
        $bill->billing_date = date('Y-m-d H:i:s');
        $bill->status = 1;
        $bill->update();
    }
}
