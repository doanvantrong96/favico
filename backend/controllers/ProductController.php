<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductTag;
use backend\models\ProductCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;
use yii\helpers\ArrayHelper;
use backend\models\ActionLog;
/**
 * MedicalController implements the CRUD actions for Medical model.
 */
class ProductController extends Controller
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
                    // 'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Medical models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        
        $params         = Yii::$app->request->queryParams;
        $dataProvider   = $searchModel->search($params);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Medical model.
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
     * Creates a new Medical model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model              = new Product;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ( $model->load(Yii::$app->request->post()) ){
            if( mb_strlen($model->description) > 300 ){
                $model->description = mb_substr($model->description,0,300, "utf-8");
            }
            if(!$model->slug)
                $model->slug    = CommonController::LocDau($model->title);
            $title_msg      = 'Thêm';
            
            if( $model->save(false) ){
                
                Yii::$app->session->setFlash('success', $title_msg. ' sản phẩm <b>' . $model->title . '</b> thành công');
               
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'all_category' => []
        ]);
    }

    public function actionUpdate($id)
    {
        $model              = $this->findModel($id);
                
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ( $model->load(Yii::$app->request->post()) ){
            if( mb_strlen($model->description) > 300 && $model->status != Product::PUBLISHED ){
                $model->description = mb_substr($model->description,0,300, "utf-8");
            }
            
            if(!$model->slug)
                $model->slug    = CommonController::LocDau($model->title);
            $title_msg      = 'Cập nhật';
            $redirectIndex  = false;
            
            if( !isset($_POST['Product']['tag_id']) || empty($_POST['Product']['tag_id']) )
                $model->tag_id = '';
                
            if( $model->save(false) ){
                Yii::$app->session->setFlash('success', $title_msg .' sản phẩm <b>' . $model->title . '</b> thành công');
                if( $redirectIndex )
                    return $this->redirect(['index']);
                return $this->refresh();
            }
        }
        $all_category           = [];
        $all_tag                = [];
        $related_product           = [];
        if(!empty($model->tag_id)){
            $cat_selected       = array_values(array_filter(explode(';', $model->tag_id)));
            $all_category       = ArrayHelper::map(ProductTag::find()->where(['status'=>1])->andWhere(['in','id',$cat_selected])->all(), 'id', 'name');
            $model->tag_id  = $cat_selected; 
        }
        if(!empty($model->related_product)){
            $related_news_id    = array_values(array_filter(explode(';', $model->related_product)));
            $related_product       = ArrayHelper::map(Product::find()->where(['status'=>1])->andWhere(['in','id',$related_news_id])->all(), 'id', 'title');
            $model->related_product= $related_news_id; 
        }
        return $this->render('update', [
            'model' => $model,
            'all_category' => $all_category,
            'related_product' => $related_product,
            'all_tag'      => $all_tag
        ]);
    }

    public function actionDelete($id)
    {
        $model = Product::findOne($id);
        if( $model ){
            $modelOld   = $model->getAttributes();
            $model->status = 0;
            $model->save(false);
            Yii::$app->session->setFlash('success', "Ẩn thành công");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
