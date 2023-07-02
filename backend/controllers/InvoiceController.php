<?php

namespace backend\controllers;

use Yii;
use backend\models\Invoice;
use backend\models\Detailinvoice;
use backend\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                        'actions' => ['logout', 'index','update','create','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new InvoiceSearch();
        $dataProvider = $dataProvider->getInvoice();
        // echo '<pre>';
        // var_dump($dataProvider);
        // echo '<pre>';die;
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $dataProvider,
            'pagination' => false,
        ]);
        // $searchModel = new InvoiceSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();
        $params = $_REQUEST;
        if( isset($params['username']))
            $model->customername = $params['username'];
        if( isset($params['Invoice'])){
            $list_product = [];
            foreach($params['material_name'] as $key=>$row){
                $product['name'] = $row;
                $product['link'] = $params['material_link'][$key];
                $product['price'] = $params['material_price'][$key];
                $product['quantity'] = $params['material_quantity'][$key];
                $product['currency'] = $params['material_currency'][$key];
                $list_product[] = $product;
            }
            $model->username  = Yii::$app->user->identity->username;
            $model->customername = $params['Invoice']['customername'];
            $model->status = 1;
            $model->note = $params['Invoice']['note'];
            $model->save(false);
            $invoice_id = $model->id;
            foreach($list_product as $row){
                $newProduct = new Detailinvoice();
                $newProduct->invoice_id = $invoice_id;
                $newProduct->productname = $row['name'];
                $newProduct->image = $row['link'];
                $newProduct->status = 1;
                $newProduct->price = $row['price'];
                $newProduct->quantity = $row['quantity'];
                $newProduct->currency = $row['currency'];
                $newProduct->save(false);
            }
            Yii::$app->session->setFlash('success', 'Tạo đơn hàng thành công');
            return $this->redirect(['invoice/index']);
        }
            
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataProduct =  Detailinvoice::find()->where('invoice_id = '.$id)->asArray()->all();
        $items = [
            
            '1'=> 'Chờ xác nhận', 
            '2' => 'Đang vận chuyển',
            '3' => 'Đã huỷ', 
            '4' => 'Hàng về' , 
            '5' => 'Đã lấy hàng',
            '6' => 'Trả lại hàng'
        ];
        $modelProduct = new \yii\data\ArrayDataProvider([
            'allModels' => $dataProduct,
            'pagination' => false,
        ]);
        if ($model->load(Yii::$app->request->post()) ) {
            $model->update();
            // return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelProduct'=>$modelProduct,
            'items'=>$items
        ]);
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
