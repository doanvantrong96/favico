<?php

namespace backend\controllers;

use Yii;
use backend\models\CommunityStory;
use backend\models\CommunityStorySearch; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;
use backend\models\ActionLog;

class CommunityStoryController extends Controller
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
     * Lists all CategoryTags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel    = new CommunityStorySearch();
        $dataProvider   = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    /**
     * Displays a single CategoryTags model.
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
     * Creates a new CategoryTags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CommunityStory();
       
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {            
            if( $model->save() ){
                ActionLog::insertLog(ActionLog::MODULE_COMMUNITYSTORY, $model, ActionLog::TYPE_CREATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
                
                Yii::$app->session->setFlash('success', "Thêm mới thành công");
            }
            else
                Yii::$app->session->setFlash('success', "Lỗi!");
                
            return $this->redirect(['index']);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing CategoryTags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $modelOld      = $model->getAttributes();
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save(false);

            ActionLog::insertLog(ActionLog::MODULE_COMMUNITYSTORY, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);

            Yii::$app->session->setFlash('success', "Cập nhật thành công");
            return $this->redirect(['index']);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CategoryTags model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionApproved($id)
    {
        $model      = CommunityStory::findOne($id);
        
        if( $model && $model->status == CommunityStory::STATUS_PENDING ){
            $modelOld           = $model->getAttributes();
            $model->status      = CommunityStory::STATUS_APPROVED;
            $model->is_active   = CommunityStory::ACTIVE;
            $model->save(false);
            ActionLog::insertLog(ActionLog::MODULE_COMMUNITYSTORY, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);
            Yii::$app->session->setFlash('success', "Duyệt câu chuyện thành công");
        }else{
            Yii::$app->session->setFlash('error', "Duyệt không thành công. Nguyên do: Câu chuyện không tồn tại hoặc trạng thái không hợp lệ");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionReject($id)
    {
        $model      = CommunityStory::findOne($id);
        
        if( $model && $model->status == CommunityStory::STATUS_PENDING ){
            $modelOld           = $model->getAttributes();
            $model->status      = CommunityStory::STATUS_REJECT;
            $model->is_active   = CommunityStory::INACTIVE;
            $model->save(false);
            ActionLog::insertLog(ActionLog::MODULE_COMMUNITYSTORY, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);
            Yii::$app->session->setFlash('success', "Từ chối duyệt câu chuyện thành công");
        }else{
            Yii::$app->session->setFlash('error', "Từ chối duyệt không thành công. Nguyên do: Câu chuyện không tồn tại hoặc trạng thái không hợp lệ");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionShow($id)
    {
        $model      = CommunityStory::findOne($id);
        
        if( $model && $model->status == CommunityStory::STATUS_APPROVED ){
            $modelOld           = $model->getAttributes();
            $model->is_active   = CommunityStory::ACTIVE;
            $model->save(false);
            ActionLog::insertLog(ActionLog::MODULE_COMMUNITYSTORY, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);
            Yii::$app->session->setFlash('success', "Hiển thị câu chuyện thành công");
        }else{
            Yii::$app->session->setFlash('error', "Hiển thị không thành công. Nguyên do: Câu chuyện không tồn tại hoặc trạng thái không hợp lệ");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionHide($id)
    {
        $model      = CommunityStory::findOne($id);
        
        if( $model && $model->status == CommunityStory::STATUS_APPROVED){
            $modelOld   = $model->getAttributes();
            $model->is_active   = CommunityStory::INACTIVE;
            $model->save(false);
            ActionLog::insertLog(ActionLog::MODULE_COMMUNITYSTORY, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);
            Yii::$app->session->setFlash('success', "Ẩn câu chuyện thành công");
        }else{
            Yii::$app->session->setFlash('error', "Ẩn không thành công. Nguyên do: Câu chuyện không tồn tại hoặc trạng thái không hợp lệ");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionDelete($id)
    {
        $model      = CommunityStory::findOne($id);
        
        if( $model ){
            $modelOld   = $model->getAttributes();
            $model->is_delete = 1;
            $model->save(false);
            ActionLog::insertLog(ActionLog::MODULE_COMMUNITYSTORY, $model, ActionLog::TYPE_DELETE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld);
            Yii::$app->session->setFlash('success', "Xoá câu chuyện thành công");
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /**
     * Finds the CategoryTags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryTags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommunityStory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
