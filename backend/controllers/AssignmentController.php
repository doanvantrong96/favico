<?php

namespace backend\controllers;

use Yii;
use mdm\admin\models\Assignment;
// use mdm\admin\models\searchs\Assignment as AssignmentSearch;
use backend\models\searchs\Assignment as AssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use backend\models\Util;
use backend\models\Userinfo as UserStaff;
use backend\models\Employee;
use backend\models\ActionLog;

/**
 * AssignmentController implements the CRUD actions for Assignment model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AssignmentController extends Controller
{
    public $userClassName;
    public $idField = 'id';
    public $usernameField = 'username';
    public $fullnameField;
    public $searchClass;
    public $extraColumns = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ? : 'mdm\admin\models\User';
        }
    }

    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'assign' => ['post'],
    //                 'revoke' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params          = $_REQUEST;
        // var_dump($this->searchClass );die;
        if ($this->searchClass === null) {
            $searchModel = new AssignmentSearch;
            // $searchModel->type_account = isset($params['Assignment']) ? $params['Assignment']['type_account'] : 1;
            $searchModel->username     = isset($params['Assignment']) ? $params['Assignment']['username'] : '';
            $searchModel->is_active    = isset($params['Assignment']) ? $params['Assignment']['is_active'] : 1;
            $searchModel->account_type    = isset($params['Assignment']) ? $params['Assignment']['account_type'] : null;
            
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(), $this->userClassName, $this->usernameField);
        } else {
            $class = $this->searchClass;
            $searchModel = new $class;
            // $searchModel->type_account = $params[$class]['type_account'];
            
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
        }
        $listUser         = $dataProvider->getModels();
        $dataRole         = [];
        // if( $searchModel->type_account != 2){
            foreach($listUser as $user){
                $modelAssignment = new Assignment($user->id, $user);
                $dataRole[$user->id] = '';
                $resultRole     = $modelAssignment->getItems();
                if( count($resultRole['assigned']) > 0 ){
                    $dataRole[$user->id] = implode(', ', array_unique( array_keys($resultRole['assigned']) ) );
                }
            }
        // }else
        //     $dataRole   = ['Nhân viên'];
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'extraColumns' => $this->extraColumns,
            'dataRole'  => $dataRole
        ]);
    }

    /**
     * Displays a single Assignment model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModelUpdate($id);
        if(!$model->is_admin){
            $modelAssignment = $this->findModel($id);
            $resultRole = $modelAssignment->getItems();
            if( count($resultRole['assigned']) > 0 ){
                $model->userRole = implode(', ', array_unique( array_keys($resultRole['assigned']) ) );
            }
        }
        return $this->render('view', [
            'model' => $model,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'fullnameField' => $this->fullnameField,
        ]);
    }

    public function actionCreate(){
        $params = $_REQUEST;
        
        $model  = new $this->userClassName;
        

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $resultRole = Assignment::getItems(0);
        // $model->status      = 1;
        $model->userRole    = [];
        if( count($resultRole['available']) > 0 ){
            foreach($resultRole['available'] as $rolename=>$type){
                if( $type == 'role' ){
                    $model->userRole[$rolename] = 'unchecked';
                }
            }
        }
        if( isset($params['User']) || isset($params['Userinfo']) ){
            // if( !Yii::$app->user->identity->is_admin && isset($params['User']['is_admin']) )
            //     unset($params['User']['is_admin']);
            if( isset($params['Userinfo']) )
                $params['User'] = $params['Userinfo'];
            
            foreach($params['User'] as $column=>$value){
                $model->$column = $value;
            }
            $model->is_admin = 1;
            $model->password = md5(md5($model->password));
            $model->create_date = time();
            $model->ip          = $_SERVER['REMOTE_ADDR'];
            // $model->device_id   = 
            if( $model->account_type == Employee::TYPE_SALE ){
                $model->affliate_id = rand(100000,999999);
            }
            $model->save(false);
            
            if( !empty($params['roles']) ){
                $modelAssignment  = new Assignment($model->id);
                $modelAssignment->assign($params['roles']);

                $Util               = new Util();
                $objLog             = new \stdClass();
                $objLog->data       = ['userid' => $model->id, 'role' => $params['roles'] ];
                
                $objLog->adminid    = trim(Yii::$app->user->identity->id);
                $objLog->adminname  = trim(Yii::$app->user->identity->username);
                
                $Util->writeLog('assignpermission',json_encode($objLog));

                $params['User']['id']= $model->id;
                $objLog->data       = $params['User'];
                $Util->writeLog('createuser',json_encode($objLog));

                foreach($model->userRole as $role=>$typechecked){
                    if( $typechecked == 'checked' && !in_array($role, $params['roles']) )
                        $model->userRole[$role] = 'unchecked';
                    else if( in_array($role, $params['roles']) )
                        $model->userRole[$role] = 'checked';
                }
            }

            $arrAttr['role']     = isset($params['roles']) ? $params['roles'] : '';

            ActionLog::insertLog(ActionLog::MODULE_EMPLOYEE, $model, ActionLog::TYPE_CREATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, null, $arrAttr);

            Yii::$app->session->setFlash('success', "Thêm tài khoản nhân viên thành công");
            return $this->redirect('/assignment/index');
        }  
        return $this->render('create', [
            'model' => $model
        ]);
    }
    public function actionUpdate($id)
    {
        $params = $_REQUEST;
        $model  = $this->findModelUpdate($id);
        
        if( $model == null ){
            throw new \yii\web\HttpException(404, 'Không tìm thấy user nào');
            die;
        }
        $modelOld = $model->getAttributes();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $listRoleAccess = [];
        if($model != null){
            $resultRole = Assignment::getItems($id);
            $model->userRole = [];
            if( count($resultRole['assigned']) > 0 ){
                $model->userRole = array_fill_keys((array_unique( array_keys($resultRole['assigned']) )), 'checked');
                $listRoleAccess  = array_keys($model->userRole);
            }
            if( count($resultRole['available']) > 0 ){
                foreach($resultRole['available'] as $rolename=>$type){
                    if( $type == 'role' ){
                        $model->userRole[$rolename] = 'unchecked';
                    }
                }
            }
        }
        $modelOld['role'] = $listRoleAccess;
        if( isset($params['User']) || isset($params['Userinfo']) ){
            // if( !Yii::$app->user->identity->is_admin && isset($params['User']['is_admin']) )
            //     unset($params['User']['is_admin']);
            // if( Yii::$app->user->identity->is_admin && !isset($params['User']['is_admin']) )
            //     $params['User']['is_admin'] = 0;
            if( isset($params['Userinfo']) )
                $params['User'] = $params['Userinfo'];
            
            if( isset($params['User']['is_active']) ){
                if( $params['User']['is_active'] == 1 )
                    $params['User']['is_active'] = 1;
                else
                    $params['User']['is_active'] = 0;
            }else{
                $params['User']['is_active'] = 0;
            }
            foreach($params['User'] as $column=>$value){
                $model->$column = $value;
            }

            if( $model->account_type == Employee::TYPE_SALE && !$model->affliate_id  ){
                $model->affliate_id = rand(100000,999999);
            }
            
            $model->save(false);

            $Util               = new Util();
            $objLog             = new \stdClass();
            $objLog->data       = $params['User'];
            
            $objLog->adminid    = trim(Yii::$app->user->identity->id);
            $objLog->adminname  = trim(Yii::$app->user->identity->username);
            
            $Util->writeLog('updateuser',json_encode($objLog));
            
            if( !empty($params['roles']) ){
                $modelAssignment  = new Assignment($model->id);
                
                $listRoleRevoke = [];
                $listRoleAssign = [];
                if( count($resultRole['assigned']) <= 0 ){
                    $listRoleAssign = array_values($params['roles']);
                }else{
                    $listRoleAssign = array_diff( array_values($params['roles']), array_keys($resultRole['assigned']));
                }
                foreach($model->userRole as $role=>$typechecked){
                    if( $typechecked == 'checked' && !in_array($role, $params['roles']) ){
                        $listRoleRevoke[] = $role;
                        $model->userRole[$role] = 'unchecked';
                    }
                    else if( in_array($role, $params['roles']) )
                        $model->userRole[$role] = 'checked';
                }

                if( !empty($listRoleAssign) ){
                    $modelAssignment->assign($listRoleAssign);
                }
                if( !empty($listRoleRevoke) ){
                    $modelAssignment->revoke($listRoleRevoke);
                }
            }else{
                $model->userRole = array_fill_keys(array_keys($model->userRole), 'unchecked');
            }
            
            $arrAttr['role']     = isset($params['roles']) ? $params['roles'] : [];
            
            ActionLog::insertLog(ActionLog::MODULE_EMPLOYEE, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND, $modelOld, $arrAttr);

            Yii::$app->session->setFlash('success', "Cập nhật tài khoản thành công");
        }  

        return $this->render('update', [
            'model' => $model
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
                    $model              = $this->findModelUpdate($id);
                    $model->password    = md5(md5($password_new));
                    $model->save(false);

                    ActionLog::insertLog(ActionLog::MODULE_EMPLOYEE, $model, ActionLog::TYPE_RESETPASS, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
                    $transaction_db->commit();
                    return ['status'=>true,'msg'=>'Cấp lại mật khẩu cho tài khoản ' . ($model->fullname ? $model->fullname : $model->username) . ' thành công'];
                } catch (\Exception $e) {
                    $transaction_db->rollBack();
                    return ['status'=>false,'msg'=>'Có lỗi không thể cấp lại mật khẩu'];
                }
            }
        }

        return $this->renderAjax('_form_reset_password');

    }

    public function actionGetpermisstion()
    {
        $id    = $_POST['id'];
        $model = new Assignment($id);
        $listItem =  $model->getItems();
        if( isset($listItem['available']) && !empty($listItem['available']) ){
            $listItem['available'] = array_fill_keys(array_keys($listItem['available'], 'role'),'role');
        }
        Yii::$app->getResponse()->format = 'json';
        return $listItem;
    }

    public function actionChangestatus()
    {
        $listUserID     = Yii::$app->getRequest()->post('data', []);
        foreach($listUserID as $id){
            $model  = $this->findModelUpdate($id);
           
            if( $model != null ){
                $model->is_active = $model->is_active == 1 ? 0 : 1;
                $model->save(false);
            }
        }

        $Util               = new Util();
        $objLog             = new \stdClass();
        $objLog->data       = $listUserID;
        $objLog->type       = "";
        $objLog->adminid    = trim(Yii::$app->user->identity->id);
        $objLog->adminname  = trim(Yii::$app->user->identity->username);
        
        $Util->writeLog('lockeduser',json_encode($objLog));


        exit;
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->assign($items);
        $listItem =  $model->getItems();
        if( isset($listItem['available']) && !empty($listItem['available']) ){
            $listItem['available'] = array_fill_keys(array_keys($listItem['available'], 'role'),'role');
        }
        
        ActionLog::insertLog(ActionLog::MODULE_ASSIGN_ROLE, ['id'=>$id, 'role' => $items], ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);

        $Util               = new Util();
        $objLog             = new \stdClass();
        $objLog->data       = ['userid' => $id, 'role' => $items ];
        
        $objLog->adminid    = trim(Yii::$app->user->identity->id);
        $objLog->adminname  = trim(Yii::$app->user->identity->username);
        
        $Util->writeLog('assignpermission',json_encode($objLog));

        Yii::$app->getResponse()->format = 'json';

        return array_merge($listItem, ['success' => $success]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionRevoke($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->revoke($items);
        $listItem =  $model->getItems();
        if( isset($listItem['available']) && !empty($listItem['available']) ){
            $listItem['available'] = array_fill_keys(array_keys($listItem['available'], 'role'),'role');
        }

        ActionLog::insertLog(ActionLog::MODULE_REVOKE_ROLE, ['id'=>$id, 'role' => $items], ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);

        $Util               = new Util();
        $objLog             = new \stdClass();
        $objLog->data       = ['    ' => $id, 'role' => $items ];
        
        $objLog->adminid    = trim(Yii::$app->user->identity->id);
        $objLog->adminname  = trim(Yii::$app->user->identity->username);
        
        $Util->writeLog('revokepermission',json_encode($objLog));

        Yii::$app->getResponse()->format = 'json';
        return array_merge($listItem, ['success' => $success]);
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return new Assignment($id, $user);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelUpdate($id)
    {
        $class = $this->userClassName;
        return $class::findByID($id);
    }
}
