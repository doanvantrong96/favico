<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Order;
use backend\models\Invoice;
use backend\models\Detailinvoice;
use yii\data\ArrayDataProvider;



class CustomerController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','history','delete','invoice','detailinvoice','confirm'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        // $searchModel = new OrderController();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $data =  $model->findAllCartOrder();
        // $dataProvider = new \yii\data\ArrayDataProvider([
        //     'allModels' => $data,
        //     'pagination' => false,
        // ]);
        return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHistory(){
        // echo '123';die;
        
        $history = Order::find()->where('userid = '.Yii::$app->user->identity->id)->all();
        // var_dump($history );die;
        $dataProvider =  new ArrayDataProvider([
            'allModels' => $history,
            'pagination' => false,
        ]);
        return $this->render('history',[
            'dataProvider'=>$dataProvider
        ]);
    }
    public function actionInvoice(){
        $invoice = new Invoice();
        $data = $invoice->getCustomerInvoice(Yii::$app->user->identity->username);
        // var_dump($data);die;
        $dataProvider =  new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
        ]);
        return $this->render('invoice',[
            'dataProvider'=>$dataProvider
        ]);
    }
    public function actionDetailinvoice($id){
        $dataProduct =  Detailinvoice::find()->where('invoice_id = '.$id)->asArray()->all();
        // var_dump($data);die;
        $dataProvider =  new ArrayDataProvider([
            'allModels' => $dataProduct,
            'pagination' => false,
        ]);
        return $this->renderAjax('detailinvoice',[
            'dataProvider'=>$dataProvider
        ]);
    }
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 3;
        $model->update();
        return $this->redirect(['customer/history']);
    }
    public function actionConfirm($id)
    {
        $model = new Invoice();
        $model = Invoice::findOne($id);
        $model->status = 2;
        $model->update();
        return $this->redirect(['customer/invoice']);
    }
    
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Yêu cầu không tồn tại.');
    }
    
    
}
