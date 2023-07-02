<?php

namespace backend\controllers;

use Yii;
use backend\models\Customer;
use backend\models\CustomerSearch;
use backend\models\UserCourse;
use backend\models\OrderCartSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserLogin;
use backend\models\ActionLog;
use backend\controllers\CommonController;
/**
 * CourseSectionController implements the CRUD actions for CourseSection model.
 */
class CustomerController extends Controller
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
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all CourseSection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset(Yii::$app->request->queryParams['_export'])) {
            $dataProvider->pagination->pageSize=0;
            $this->exportData($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    private function exportData($dataProvider){
        if( !empty($dataProvider->getModels()) ){
            $header = [
                'Họ tên',
                'Email',
                'SĐT',
                'Ngày đăng ký',
                'Trạng thái'
            ];
            $data       = [];
            foreach($dataProvider->getModels() as $row){
                $data[] = [
                    trim($row->fullname),
                    trim($row->email),
                    trim($row->phone),
                    date('H:i:s d/m/Y', strtotime($row->create_date)),
                    CommonController::getStatusNameUser($row->status)
                ];
            }
            $file_name  = 'Danh_sach_khach_hang_' . date('his') . '_' . date('dmY');
            CommonController::exportDataExcel($header, $data, $file_name);
        }
    }
    public function actionHistoryLogin($user_id){
        $resultLogin  = UserLogin::find()->where(['user_id'=>$user_id,'is_revoke'=>0])->orderBy(['time_login'=>SORT_DESC])->all();
        return $this->renderAjax('history_login',[
            'resultLogin' => $resultLogin
        ]);
    }
    public function actionHistoryOrder($user_id){
        $searchModel = new OrderCartSearch;
        $searchModel->user_id = $user_id;
        $dataProvider= $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setPagination(['pageSize' => 10]); 

        return $this->renderAjax('history_order',[
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
            'user_id'   => $user_id
        ]);

    }
    public function actionResetPassword(){
        if( isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['password_new']) && !empty($_POST['password_new']) && isset($_POST['password']) && !empty($_POST['password']) ){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $id                 = (int)$_POST['id'];
            $password_new       = $_POST['password_new'];
            $password           = $_POST['password'];
            if( empty($password_new) ){
                return ['status'=>false,'msg'=>'Mật khẩu mới không được trống'];
            }else if( md5(md5($password)) != Yii::$app->user->identity->password ){
                return ['status'=>false,'msg'=>'Mật khẩu tài khoản của bạn không chính xác'];
            }else{
                $transaction_db = Yii::$app->db->beginTransaction();
                try {
                    $model              = $this->findModel($id);
                    $model->password    = md5(md5($password_new));
                    $model->save(false);

                    ActionLog::insertLog(ActionLog::MODULE_USER, $model, ActionLog::TYPE_RESETPASS, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
                    $transaction_db->commit();
                    return ['status'=>true,'msg'=>'Cấp lại mật khẩu cho khách hàng ' . $model->fullname . ' thành công'];
                } catch (\Exception $e) {
                    $transaction_db->rollBack();
                    return ['status'=>false,'msg'=>'Có lỗi không thể cấp lại mật khẩu'];
                }
            }
        }

        return $this->renderAjax('_form_reset_password');

    }
    /**
     * Deletes an existing CourseSection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBanned($id)
    {
        $model = $this->findModel($id);
        if( $model ){
            $model->status = Customer::BANNED;
            $model->date_banned = date('Y-m-d H:i:s');
            $model->save(false);

            ActionLog::insertLog(ActionLog::MODULE_USER, $model, ActionLog::TYPE_BLOCK, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);

            Yii::$app->session->setFlash('success', 'Khoá tài khoản khách hàng thành công');
        }else{
            Yii::$app->session->setFlash('error', 'Thông tin khách hàng không tồn tại');
        }

        return $this->redirect(['index']);
    }
    public function actionUnbanned($id){
        $model = $this->findModel($id);
        if( $model ){
            $model->status = Customer::ACTIVE;
            $model->date_banned = NULL;
            $model->save(false);
            
            ActionLog::insertLog(ActionLog::MODULE_USER, $model, ActionLog::TYPE_UNBLOCK, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
            Yii::$app->session->setFlash('success', 'Mở khoá tài khoản khách hàng thành công');
        }else{
            Yii::$app->session->setFlash('error', 'Thông tin khách hàng không tồn tại');
        }

        return $this->redirect(['index']);
    }
    public function actionUnlock($id){
        $model = $this->findModel($id);
        if( $model ){
            $model->status = Customer::ACTIVE;
            $model->save(false);

            ActionLog::insertLog(ActionLog::MODULE_USER, $model, ActionLog::TYPE_UNLOCK, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
            UserLogin::updateAll(['status'=>1],['user_id'=>$model->id]);
            Yii::$app->session->setFlash('success', 'Mở khoá đăng nhập tài khoản khách hàng thành công');
        }else{
            Yii::$app->session->setFlash('error', 'Thông tin khách hàng không tồn tại');
        }

        return $this->redirect(['index']);
    }
    /**
     * Finds the CourseSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
