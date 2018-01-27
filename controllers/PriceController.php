<?php

namespace app\controllers;

use app\models\Customers;
use app\models\Products;
use Yii;
use app\Models\Price;
use app\models\PriceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PriceController implements the CRUD actions for Price model.
 */
class PriceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Price models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Price model.
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
     * Creates a new Price model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Price();

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

        if ($model->load(Yii::$app->request->post())) {
            $customer_id = $_POST['Price']['customer_id'];
            $customerName = Customers::findOne($customer_id)->name;

            $model->customer_name = $customerName;
            $model->modified_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'customers' => $customers,
                'products' => $products
            ]);
        }
    }

    /**
     * Updates an existing Price model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
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

        if ($model->load(Yii::$app->request->post())) {
            $customer_id = $_POST['Price']['customer_id'];
            $customerName = Customers::findOne($customer_id)->name;

            $model->customer_name = $customerName;
            $model->modified_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'customers' => $customers,
                'products' => $products
            ]);
        }
    }

    /**
     * Deletes an existing Price model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /*
     * Get price of the selected product and customer
     * */
    public function actionGetPrice(){
        $product_id = $_POST['product_id'];
        $customer_id = $_POST['customer_id'];

        $product = Products::findOne($product_id);
        $customer = Customers::findOne($customer_id);

        $prdtCustMapp = Price::find()
            ->where('customer_id=:cid',[':cid'=>$customer_id])
            ->andWhere('customer_name=:nm',[':nm'=>$customer->name])
            ->andWhere('product_name=:pnm',[':pnm'=>$product->name])
            ->one();

        if(isset($prdtCustMapp)){
            print $prdtCustMapp->price;
        } else {
            print $product->base_price;
        }
    }

    /**
     * Finds the Price model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Price the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Price::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
