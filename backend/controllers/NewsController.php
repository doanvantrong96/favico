<?php

namespace backend\controllers;

use Yii;
use backend\models\News;
use backend\models\NewsSearch;
use backend\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;
use yii\helpers\ArrayHelper;
use backend\models\ActionLog;
/**
 * MedicalController implements the CRUD actions for Medical model.
 */
class NewsController extends Controller
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
        $searchModel = new NewsSearch();
        if( !isset($_GET['NewsSearch']) && !isset($_GET['NewsSearch']['date_start']) ){
            $searchModel->date_start = date('Y-m-d',strtotime('- 30 day',time()));
            $searchModel->date_end   = date('Y-m-d');
        }
        if( isset($_GET['date_start']) )
            $searchModel->date_start = trim($_GET['date_start']);
        if( isset($_GET['date_end']) )
            $searchModel->date_end = trim($_GET['date_end']);

        $searchModel->tab = 'all';
        $params         = Yii::$app->request->queryParams;
        $dataProvider   = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model              = new News;
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
            if( isset($_POST['save_draft']) ){
                $model->status = News::DRAFT;
                $title_msg      = 'Lưu nháp';
            }else if( isset($_POST['save_published']) ){
                $model->status = News::PUBLISHED;
                $model->date_publish = date('Y-m-d H:i:s');
                $model->user_publish  = Yii::$app->user->identity->id;
                $model->date_approved_publish = date('Y-m-d H:i:s');
                $title_msg      = 'Đăng';
            }else if( isset($_POST['save_published']) ){
                $model->status = News::HIDE;
                $title_msg      = 'Ẩn';
            }
            
            if( $model->save(false) ){
                
                ActionLog::insertLog(ActionLog::MODULE_NEWS, $model, ActionLog::TYPE_CREATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);

                Yii::$app->session->setFlash('success', $title_msg. ' bài <b>' . $model->title . '</b> thành công');
               
                return $this->redirect(['index']);
            }
        }else{
            $model->status = News::DRAFT;
        }
        return $this->render('create', [
            'model' => $model,
            'all_category' => []
        ]);
    }

    public function actionUpdate($id)
    {
      
        $model              = $this->findModel($id);
        if( !$model->isOwner() )
            return $this->redirect(['index']);

        $modelOld = $model->getAttributes();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ( $model->load(Yii::$app->request->post()) ){
            if( mb_strlen($model->description) > 300 && $model->status != News::PUBLISHED ){
                $model->description = mb_substr($model->description,0,300, "utf-8");
            }
            
            if(!$model->slug)
                $model->slug    = CommonController::LocDau($model->title);
            $title_msg      = 'Cập nhật';
            $redirectIndex  = false;
            if( isset($_POST['save_draft']) ){
                $model->status = News::DRAFT;
                $title_msg      = 'Lưu nháp';
            }else if( isset($_POST['save_published']) && $model->status != News::PUBLISHED  ){
                $model->status = News::PUBLISHED;
                $model->date_publish = date('Y-m-d H:i:s');
                $model->user_publish  = Yii::$app->user->identity->id;
                $model->date_approved_publish = date('Y-m-d H:i:s');
                $title_msg      = 'Đăng';
            }else if( isset($_POST['save_hide']) ){
                $model->status = News::HIDE;
                $title_msg      = 'Ẩn';
            }
            if( !isset($_POST['News']['category_id']) || empty($_POST['News']['category_id']) )
                $model->category_id = '';

            if( $model->save(false) ){

                ActionLog::insertLog(ActionLog::MODULE_NEWS, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);

                Yii::$app->session->setFlash('success', $title_msg .' bài <b>' . $model->title . '</b> thành công');
                if( $redirectIndex )
                    return $this->redirect(['index']);
                return $this->refresh();
            }
        }
        $all_category           = [];
        $all_tag                = [];
        $related_news           = [];
        if(!empty($model->category_id)){
            $cat_selected       = array_values(array_filter(explode(';', $model->category_id)));
            $all_category       = ArrayHelper::map(Category::find()->where(['status'=>1,'is_delete'=>0])->andWhere(['in','id',$cat_selected])->all(), 'id', 'name');
            $model->category_id  = $cat_selected; 
        }
        if(!empty($model->related_news)){
            $related_news_id    = array_values(array_filter(explode(';', $model->related_news)));
            $related_news       = ArrayHelper::map(News::find()->where(['status'=>1,'is_delete'=>0])->andWhere(['in','id',$related_news_id])->all(), 'id', 'title');
            $model->related_news= $related_news_id; 
        }
        return $this->render('update', [
            'model' => $model,
            'all_category' => $all_category,
            'related_news' => $related_news,
            'all_tag'      => $all_tag
        ]);
    }

    /**
     * Deletes an existing Medical model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
   
    public function actionDelete($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if( $model ){
            $model->is_delete = 1;
            $model->save(false);

            ActionLog::insertLog(ActionLog::MODULE_NEWS, $model, ActionLog::TYPE_DELETE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
            
            return [
                'errorCode' => 0,
                'message'   => "Xoá bài <b>" . $model->title . "</b> thành công",
                'data'      => ['id' => $id]
            ];
        
        }else{
            return [
                'errorCode' => 1,
                'message'   => "Lỗi! Bài viết không tồn tại"
            ];
        }

        
    }

    public function actionHide($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if( $model ){
            $model->status = News::HIDE;
            $model->save(false);

            ActionLog::insertLog(ActionLog::MODULE_NEWS, $model, ActionLog::TYPE_DELETE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
            
            return [
                'errorCode' => 0,
                'message'   => "Ẩn bài <b>" . $model->title . "</b> thành công",
                'data'      => ['id' => $id]
            ];
        
        }else{
            return [
                'errorCode' => 1,
                'message'   => "Lỗi! Bài viết không tồn tại"
            ];
        }

        
    }

    
    private function validateBeforeAction($model, $status = ''){
        if( empty($model->image) && $status != News::PUBLISHED ){
            $txt_action = '';
            if( $status == News::PUBLISHED ){
                $txt_action = 'đăng';
            }
            return [
                'errorCode' => 1,
                'message'   => "Lỗi! Bài viết chưa có hình ảnh không thể " . $txt_action,
            ];
        }

        return null;
    }

    /**
     * Xuất bản bài viết
     */
    public function actionPublished($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model      = $this->findModel($id);
        $modelOld   = $model->getAttributes();
        if( $model && in_array($model->status, [News::DRAFT, News::HIDE]) ){
            $resultValidate      = $this->validateBeforeAction($model, News::PUBLISHED);
            if( $resultValidate )
                return $resultValidate;
            $slug_post           = $model->slug;
            $model->status       = News::PUBLISHED;
            $model->date_publish = date('Y-m-d H:i:s');
            $model->user_publish  = Yii::$app->user->identity->id;
            $model->date_approved_publish = date('Y-m-d H:i:s');
            // if( $model->date_schedule_publish ){
            //     $model->date_publish = $model->date_schedule_publish;
            // }
            $model->save(false);

            ActionLog::insertLog(ActionLog::MODULE_NEWS, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);
            
            return [
                'errorCode' => 0,
                'message'   => "Đăng bài <b>" . $model->title . "</b> thành công",
                'data'      => ['id' => $id]
            ];
        }else{
            return [
                'errorCode' => 1,
                'message'   => $model ? "Lỗi! Đăng bài <b>" . $model->title . "</b> không thành công" : "Lỗi! Bài viết không tồn tại"
            ];
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
    /**
     * Finds the Medical model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Medical the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
