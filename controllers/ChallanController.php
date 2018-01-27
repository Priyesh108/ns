<?php

namespace app\controllers;

use app\models\ChallanProductMapping;
use app\models\Customers;
use app\models\Price;
use app\models\Products;
use app\models\ProductUnitMapping;
use Yii;
use app\models\Challans;
use app\models\ChallansSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChallanController implements the CRUD actions for Challans model.
 */
class ChallanController extends Controller
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
                        'actions' => ['index','create','view','update','delete','addToChallanProductMapping',
                            'deleteProductUnitMapping', 'challanProductMapping'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'addToChallanProductMapping' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Challans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChallansSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Challans model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $challan = Challans::findOne($id);

        $challanProducts = ChallanProductMapping::find()
            ->where('challan_number=:cn',[':cn'=>$challan->challan_number])
            ->all();

        $productUnits = array();
        foreach ($challanProducts as $cp){
            $productUnitsMapping = ProductUnitMapping::find()
                ->where('cp_id=:cp_id',[':cp_id'=>$cp->cp_id])
                ->all();
            $productUnits[$cp->cp_id] = array();

            foreach ($productUnitsMapping as $pm){
                $temp = array();
                $temp['base_unit'] = $pm->base_unit;
                $temp['multiplier_unit'] = $pm->multiplier_unit;
                $temp['total_units'] = $pm->total_units;
                array_push($productUnits[$cp->cp_id],$temp);
            }
        }

        return $this->render('view', [
            'model' => $challan,
            'productUnits' => $productUnits
        ]);
    }

    /**
     * Creates a new Challans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Challans();
        $challanProducts = [new ChallanProductMapping()];

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            $challanNumber = $_POST['Challans']['challan_number'];
            $customerId = $_POST['Challans']['customer_id'];
            $description = $_POST['Challans']['description'];
            $challanDate = date('Y-m-d H:i:s', strtotime($_POST['Challans']['challan_date']));
            $challan = Challans::find()
                ->where('challan_number=:cn',[':cn'=>$challanNumber])
                ->one();

            $this->updateTotalUnits($challanNumber);

            $challan->customer_id = $customerId;
            $challan->description = $description;
            $challan->challan_date = $challanDate;
            $challan->status = 1;
            $challan->amount = $this->getTotalAmount($challanNumber);
            $challan->update(false);

            $this->updatePriceDetails($challanNumber);

            return $this->redirect(['view', 'id' => $challan->c_id]);
        } else {
            //Delete all Pending challans
            $this->deletePendingChallans();

            //List of customers
            $customerList = Customers::find()->all();
            $customers = array();
            foreach($customerList as $customer) {
                $customers[$customer->customer_id] = $customer->name;
            }

            //Product List
            $productList = Products::find()->all();
            $products = array();
            foreach($productList as $product){
                $products[$product->product_id] = $product->name;
            }

            //Create a challan in pending state
            $highestChallanNumber = (new Yii\db\Query())
                ->select('max(challan_number) as challan_number')
                ->from('challans')
                ->one();
            if(isset($highestChallanNumber['challan_number']))
                $new_challan_number = $highestChallanNumber['challan_number'] + 1;
            else
                $new_challan_number = 1;

            $new_challan = new Challans();
            $new_challan->challan_number = $new_challan_number;
            $new_challan->status = 0;
            $new_challan->save(false);

            //challan product mapping
            $challanProducts = ChallanProductMapping::find()
                ->where(['challan_number'=>$new_challan->challan_number])
                ->all();

            //To find new Group Id
            $highNo = (new Yii\db\Query())
                ->select('max(group_number) as group_number')
                ->from('challan_product_mapping')
                ->where(['challan_number'=>$new_challan_number])
                ->one();
            if(isset($highNo['group_number']))
                $newGroupId = $highNo['group_number'] + 1;
            else
                $newGroupId = 1;
            //print('<pre>');print_r($new_challan);exit;

            return $this->render('create', [
                'model' => $new_challan,
                'challanProducts' => $challanProducts,
                'newGroupId' => $newGroupId,
                'customers' => $customers,
                'products' => $products
            ]);
        }
    }

    /**
     * Updates an existing Challans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $challanNumber = $_POST['Challans']['challan_number'];
            $customerId = $_POST['Challans']['customer_id'];
            $description = $_POST['Challans']['description'];
            $challanDate = date('Y-m-d H:i:s', strtotime($_POST['Challans']['challan_date']));
            $challan = Challans::find()
                ->where('challan_number=:cn',[':cn'=>$challanNumber])
                ->one();

            $this->updateTotalUnits($challanNumber);

            $challan->customer_id = $customerId;
            $challan->description = $description;
            $challan->challan_date = $challanDate;
            $challan->status = 1;
            $challan->amount = $this->getTotalAmount($challanNumber);
            $challan->update(false);

            $this->updatePriceDetails($challanNumber);

            return $this->redirect(['view', 'id' => $model->c_id]);
        } else {
            //List of customers
            $customerList = Customers::find()->all();
            $customers = array();
            foreach($customerList as $customer) {
                $customers[$customer->customer_id] = $customer->name;
            }

            //Product List
            $productList = Products::find()->all();
            $products = array();
            foreach($productList as $product){
                $products[$product->product_id] = $product->name;
            }

            //challan product mapping
            $challanProducts = ChallanProductMapping::find()
                ->where(['challan_number'=>$model->challan_number])
                ->all();

            //To find new Group Id
            $highNo = (new Yii\db\Query())
                ->select('max(group_number) as group_number')
                ->from('challan_product_mapping')
                ->where(['challan_number'=>$model->challan_number])
                ->one();
            if(isset($highNo['group_number']))
                $newGroupId = $highNo['group_number'] + 1;
            else
                $newGroupId = 1;

            return $this->render('update', [
                'model' => $model,
                'challanProducts' => $challanProducts,
                'newGroupId' => $newGroupId,
                'customers' => $customers,
                'products' => $products
            ]);
        }
    }

    /**
     * Deletes an existing Challans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $cid = $id;
        $challan = Challans::findOne($cid);
        $this->deleteChallan($challan->challan_number);
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Challans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Challans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Challans::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Adds to challanProductMapping table before adding any details
     * to ProductUnitMapping
     * */
    public function actionAddToChallanProductMapping(){
        $challanNumber = $_POST['challan'];
        $groupNumber = $_POST['groupNumber'];
        $productName = $_POST['productName'];
        $sellingPrice = $_POST['sellingPrice'];


        //Check whether product group is there or not in challan
        $challanProductMapping = ChallanProductMapping::find()->where(['challan_number'=>$challanNumber,'group_number'=>$groupNumber])->one();
        if(empty($challanProductMapping)){
            $challanProductMapping = new ChallanProductMapping();
            $challanProductMapping->challan_number = $challanNumber;
            $challanProductMapping->product_name = $productName;
            $challanProductMapping->group_number = $groupNumber;
            $challanProductMapping->selling_price = $sellingPrice;
            $challanProductMapping->save();
        }

        $challanMappingId = $challanProductMapping->cp_id;
        //Find all product units groups linked to the challan
        $productUnits = ProductUnitMapping::find()->where(['cp_id'=>$challanMappingId])->all();

        $modalHtml = '';
        $i = 1;
        if(!empty($productUnits)){
            foreach ($productUnits as $pu){
                $modalHtml .= '<tr class="modal-existing-fields" id="modal_tr_'.$pu->pu_id.'">
                                            <td>
                                                <div class="base_unit">
                                                    <input class="form-control unit-change" type="text"
                                                           name="productUnitMapping[base_unit]"
                                                           id="base_unit_'.$pu->pu_id.'"
                                                           value='.$pu['base_unit'].'>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="product_name">
                                                    <input class="form-control unit-change" type="text"
                                                   name="productUnitMapping[multiplier_unit]"
                                                   id="multiplier_unit_'.$pu->pu_id.'"
                                                   value='.$pu['multiplier_unit'].'>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="total">
                                                    <input class="form-control" type="text" disabled
                                                           name="productUnitMapping[total_units]"
                                                           id="total_units_'.$pu->pu_id.'"
                                                           value='.$pu['total_units'].'>
                                                </div>
                                            </td>
                                            <td>
                                                <button type=\'button\' class=\'btn btn-danger modal-btn-remove\'
                                                    id="modal_remove_btn_'.$pu->pu_id.'">
                                                    <span>-</span>
                                                </button>
                                            </td>
                                        </tr>';
                $i++;
            }
        }
        $modalHtml .= '<div class="cp_id" style="display:none">'.$challanMappingId.'</div>';
        return $modalHtml;
    }

    //To add product product units to specific challans
    public function actionAddToProductUnitMapping(){
        $base_unit = $_POST['base_unit'];
        $mul_unit = $_POST['mul_unit'];
        $total_units = $_POST['total_units'];
        $challan_number = $_POST['challan_number'];
        $group_number = $_POST['group_number'];

        $challan_product = ChallanProductMapping::find()
            ->where(['challan_number'=>$challan_number,'group_number'=>$group_number])
            ->one();

        //Remove all data and save it again
        ProductUnitMapping::deleteAll(['cp_id'=>$challan_product->cp_id]);
        foreach ($base_unit as $i=>$item){
            $product_unit = new ProductUnitMapping();
            $product_unit->cp_id = $challan_product->cp_id;
            $product_unit->base_unit = $base_unit[$i];
            $product_unit->multiplier_unit = $mul_unit[$i];
            $product_unit->total_units = $total_units[$i];
            $product_unit->save(false);
        }
    }

    //To delete Product Unit Mapping from DB
    public function actionDeleteProductUnitMapping(){
        $pu_id = $_POST['pu_id'];
        $pu = ProductUnitMapping::findOne($pu_id);
        if($pu->delete()){
            print("Data deleted successfully");
        }
    }

    //To delete Challan Product and all its product units from DB
    public function actionDeleteChallanProductMapping(){
        $challan_number = $_POST['challan_number'];
        $group_number = $_POST['group_number'];

        $cp = ChallanProductMapping::find()
            ->where('challan_number=:cnum',[':cnum'=>$challan_number])
            ->andWhere('group_number=:gnum',[':gnum'=>$group_number])
            ->one();

        if(isset($cp->cp_id)){
            //Delete Product Units
            ProductUnitMapping::deleteAll('cp_id=:cpId',[':cpId'=>$cp->cp_id]);

            //Delete Challan Product Mapping
            if($cp->delete()){
                print("Data deleted successfully");
            }
        } else {
            print("No Data found");
        }
    }

    //Delete all pending challan details
    public function deletePendingChallans(){

        $pendingChallans = Challans::find()
            ->where('status=:st',[':st'=>0])
            ->all();

        foreach($pendingChallans as $challan){

            $pendingChallanProducts = ChallanProductMapping::find()
                ->where('challan_number=:cn',[':cn'=>$challan->challan_number])
                ->all();

            foreach($pendingChallanProducts as $pcp){

                ProductUnitMapping::deleteAll('cp_id=:cpId',[':cpId'=>$pcp->cp_id]);
            }

            ChallanProductMapping::deleteAll('challan_number=:cn',[':cn'=>$challan->challan_number]);
        }

        Challans::deleteAll('status=:st',[':st'=>0]);
    }

    //Delete Specific challan depending upon Challan Number
    public function deleteChallan($challan_number){
        $pendingChallanProducts = ChallanProductMapping::find()
            ->where('challan_number=:cn',[':cn'=>$challan_number])
            ->all();

        foreach($pendingChallanProducts as $pcp){

            ProductUnitMapping::deleteAll('cp_id=:cpId',[':cpId'=>$pcp->cp_id]);
        }

        ChallanProductMapping::deleteAll('challan_number=:cn',[':cn'=>$challan_number]);

        Challans::deleteAll('challan_number=:cn',[':cn'=>$challan_number]);
    }

    //Calculate total challan amount
    public function getTotalAmount($challanNumber){
        $challanProducts = ChallanProductMapping::findAll(['challan_number'=>$challanNumber]);
        $finalAmount = 0;

        foreach ($challanProducts as $product){
            $totalUnits = (new Yii\db\Query())
                ->select('sum(total_units) as total_units')
                ->from('product_unit_mapping')
                ->where('cp_id=:cpId',[':cpId'=>$product->cp_id])
                ->one();

            $finalAmount = ($finalAmount) + ($totalUnits['total_units'] * $product->selling_price);
        }
        return $finalAmount;
    }

    //Update Total Units in ChallanProductMapping
    public function updateTotalUnits($challan_number){

        Yii::$app->getDb()
            ->createCommand('update product_unit_mapping pum, challan_product_mapping cpm, challans c 
                                  set pum.total_units = base_unit * multiplier_unit where pum.cp_id = cpm.cp_id and 
                                  cpm.challan_number ='. $challan_number)
            ->execute();

        $challan_products = ChallanProductMapping::find()
            ->where('challan_number=:cn',[':cn'=>$challan_number])
            ->all();

        foreach ($challan_products as $group){
            $total = 0;
            $product_group = ProductUnitMapping::find()
                ->where('cp_id=:cpId',[':cpId'=>$group->cp_id])
                ->all();

            foreach ($product_group as $record){
                $total += $record->total_units;
            }

            $group->total_units = $total;
            $group->amount = $total * $group->selling_price;
            $group->update(false);
        }
    }

    //Update price in the mapping
    public function updatePriceDetails($challan_number){
        $challan = Challans::find()
            ->where('challan_number=:cn',[':cn'=>$challan_number])
            ->one();

        $customer = Customers::findOne($challan->customer_id);

        $challanProducts = ChallanProductMapping::find()
            ->where('challan_number=:cn',[':cn'=>$challan_number])
            ->all();

        foreach ($challanProducts as $record){
            $product = Products::find()
                ->where('name=:nm',[':nm'=>$record->product_name])
                ->one();

            $prdtCustMapp = Price::find()
                ->where('customer_id=:cid',[':cid'=>$challan->customer_id])
                ->andWhere('customer_name=:nm',[':nm'=>$customer->name])
                ->andWhere('product_name=:pnm',[':pnm'=>$product->name])
                ->one();

            if(isset($prdtCustMapp)){
                //Update the record
                $prdtCustMapp->price = $record->selling_price;
                $prdtCustMapp->modified_at = date('Y-m-d H:i:s');
                $prdtCustMapp->referred_challan_no = $challan_number;
                $prdtCustMapp->save();
            } else {
                //Add new record
                $prdtCustMapp = new Price();
                $prdtCustMapp->customer_id = $challan->customer_id;
                $prdtCustMapp->customer_name = $customer->name;
                $prdtCustMapp->product_name = $product->name;
                $prdtCustMapp->price = $record->selling_price;
                $prdtCustMapp->referred_challan_no = $challan_number;
                $prdtCustMapp->modified_at = date('Y-m-d H:i:s');
                $prdtCustMapp->save();
            }
        }
    }
}
