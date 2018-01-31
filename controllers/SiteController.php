<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $bank_demat_details = (new Yii\db\Query())
            ->select('*')
            ->from('bank_demat')
            ->all();

        $enable_disable_module = (new Yii\db\Query())
            ->select('*')
            ->from('module')
            ->all();

        $module_check = array();
        foreach ($enable_disable_module as $item){
            $module_check[$item['name']] = $item['active'];
        }

        $unPaidBills = (new Yii\db\Query())
            ->select('*')
            ->from('bill')
            ->where('is_paid=:ip',[':ip'=>0])
            ->andWhere('billing_date <= DATE_ADD(NOW(), INTERVAL -3 MONTH)')
            ->all();

        return $this->render('index',[
            'bank_demat' => $bank_demat_details,
            'module_check' => $module_check,
            'unPaidBills' => $unPaidBills
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = "login";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /*
     * Update module visibility
     * */
    public function actionUpdateModule(){
        $customer_module = $_POST['customer_module'];
        $product_module = $_POST['product_module'];
        $price_module = $_POST['price_module'];
        $challan_module = $_POST['challan_module'];
        $bill_module = $_POST['bill_module'];
        $bankdetails_module = $_POST['bankdetails_module'];
        $sharemarket_ticker_module = $_POST['sharemarket_ticker_module'];
        $sharemarket_graph_module = $_POST['sharemarket_graph_module'];

        $query = "update module set active = ".$customer_module." where name = 'Customers'";
        Yii::$app->db->createCommand($query)->execute();

        $query = "update module set active = ".$product_module." where name = 'Products'";
        Yii::$app->db->createCommand($query)->execute();

        $query = "update module set active = ".$price_module." where name = 'Price'";
        Yii::$app->db->createCommand($query)->execute();

        $query = "update module set active = ".$challan_module." where name = 'Challans'";
        Yii::$app->db->createCommand($query)->execute();

        $query = "update module set active = ".$bill_module." where name = 'Bills'";
        Yii::$app->db->createCommand($query)->execute();

        $query = "update module set active = ".$bankdetails_module." where name = 'Bankdetails'";
        Yii::$app->db->createCommand($query)->execute();

        $query = "update module set active = ".$sharemarket_ticker_module." where name = 'Sharemarket-Ticker'";
        Yii::$app->db->createCommand($query)->execute();

        $query = "update module set active = ".$sharemarket_graph_module." where name = 'Sharemarket-Graph'";
        Yii::$app->db->createCommand($query)->execute();
    }
}
