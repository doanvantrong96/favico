<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\OrderCart;
use backend\models\OrderCartSearch;
use backend\models\OrderCartProduct;
use yii\helpers\ArrayHelper;
use backend\models\Util;
use yii\widgets\ActiveForm;
use backend\models\Employee;
use mdm\admin\models\Assignment;
use backend\models\searchs\Assignment as AssignmentSearch;
use backend\models\ActionLog;
/**
 * SaleAdmin controller
 */
class SaleAdminController extends Controller
{
    public $userClassName;
    public $idField = 'id';
    public $usernameField = 'username';
    public $fullnameField;
    public $searchClass;
    public $extraColumns = [];
    public $listSaleChild = [];
    
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ? : 'mdm\admin\models\User';
        }

        $this->listSaleChild = Employee::find()->where(['sale_admin_id' => Yii::$app->user->identity->id])->all();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $resultSale    = $this->listSaleChild;
        $date_start    = date('Y-m-d', strtotime(' - 6 day', time()));
        $date_end      = date('Y-m-d');
        if( Yii::$app->request->isPost ){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post       = Yii::$app->request->post();
            return $this->getDataStatistic($post['type'], $post['date_start'],$post['date_end'], $resultSale);
        }
        $dataStatistic = $this->getDataStatistic('all', $date_start, $date_end, $resultSale);
        
        $listSale   = [];
        if( !empty($resultSale) ){
            foreach($resultSale as $sale){
                $listSale[$sale->affliate_id] = $sale->fullname ? $sale->fullname : $sale->username;
            }
        }
        $searchModel = new OrderCartSearch();
        $searchModel->affliate_id = array_keys($listSale);
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataStatistic' => $dataStatistic,
            'date_start' => $date_start,
            'date_end'   => $date_end,
            'listSale'   => $listSale
        ]);
    }

    public function actionCommissionDetail(){
        $listSale   = [];
        $resultSale    = $this->listSaleChild;
        if( !empty($resultSale) ){
            foreach($resultSale as $sale){
                $listSale[$sale->affliate_id] = $sale->fullname ? $sale->fullname : $sale->username;
            }
        }
        $params = Yii::$app->request->queryParams;
        $searchModel = new OrderCartSearch;
        $searchModel->affliate_id = array_keys($listSale);
        if( isset($params['OrderCartSearch']) && isset($params['OrderCartSearch']['affliate_id']) && !$params['OrderCartSearch']['affliate_id']){
            $params['OrderCartSearch']['affliate_id'] = $searchModel->affliate_id;
        }
        $dataProvider= $searchModel->searchSaleAdmin($params);
        
        return $this->renderAjax('transaction/commission_by_sale', [
            'dataProvider' => $dataProvider,
            'model'     => $searchModel,
            'listSale'  => $listSale
        ]);
    }

    private function getDataStatistic($type = 'all', $date_start = '', $date_end = '', $listSale = []){
        
        $data = [
            'total_order'           => 0,
            'total_order_success'   => 0,
            'total_revenue'         => 0
        ];

        $affliate_id= [-1];
        if( !empty($listSale) ){
            foreach($listSale as $sale){
                $affliate_id[] = $sale->affliate_id;
            }
        }
        $params     = [];
        
        if( $date_start != '' ){
            $params[':date_start'] = $date_start;
        }
        
        if( $date_end != '' ){
            $params[':date_end'] = $date_end;
        }

        if( $type == 'all' || $type == 'summary' ){
            $params_summary = $params;
            if( isset($params_summary[':date_end']) )
                $params_summary[':date_end'] .= ' 23:59:59';
            $sql_statistic_summary  = '
                SELECT count(A.id) as total, "all_order" as type FROM order_cart A
                WHERE A.create_date >= :date_start and A.create_date <= :date_end and A.affliate_id IN (' . implode(',', $affliate_id) . ')
                UNION ALL
                SELECT count(A.id) as total, "order_success" as type FROM order_cart A
                WHERE A.status = 1 and A.create_date >= :date_start and A.create_date <= :date_end and A.affliate_id IN (' . implode(',', $affliate_id) . ')
            ';

            $resultSummary    = Yii::$app->db->CreateCommand($sql_statistic_summary, $params_summary)->queryAll();
            
            $sql_statistic_price = '
                SELECT SUM(A.price) as total_price, A.affliate_id, B.commission_percentage FROM order_cart A
                LEFT JOIN employee B ON A.affliate_id = B.affliate_id
                WHERE A.status = 1 and A.create_date >= :date_start and A.create_date <= :date_end and A.affliate_id IN (' . implode(',', $affliate_id) . ') 
                GROUP BY A.affliate_id     
            ';

            $resultSummaryPrice    = Yii::$app->db->CreateCommand($sql_statistic_price, $params_summary)->queryAll();

            if( !empty($resultSummary) ){
                foreach($resultSummary as $row){
                    $type_summary = $row['type'];
                    $row['total'] = $row['total'] > 0 ? $row['total'] : 0;
                    switch($type_summary){
                        case 'all_order':
                            $data['total_order'] += $row['total'];
                            break;
                        case 'order_success':
                            $data['total_order_success'] += $row['total'];
                            break;
                        default:
                            break;
                    }
                }
            }

            if( !empty($resultSummaryPrice) ){
                foreach($resultSummaryPrice as $row){

                    $commission_percentage_sale = $row['commission_percentage'];
                    $commission_percentage_sale_admin = Yii::$app->user->identity->commission_percentage;
                    $commission_percentage_remain = $commission_percentage_sale_admin - $commission_percentage_sale;

                    $data['total_revenue'] += ($row['total_price']/100)*$commission_percentage_remain;
                }

                $data['total_revenue'] = number_format($data['total_revenue'], 0, ',', ',');
            }
        }
        return $data;
    }

    public function actionListSale(){
        $params                     = $_REQUEST;
        $searchModel                = new AssignmentSearch;
        $searchModel->username      = isset($params['Assignment']) ? $params['Assignment']['username'] : '';
        $searchModel->is_active     = isset($params['Assignment']) ? $params['Assignment']['is_active'] : null;
        $searchModel->account_type  = Employee::TYPE_SALE_ADMIN;
        
        $dataProvider               = $searchModel->search(Yii::$app->getRequest()->getQueryParams(), $this->userClassName, $this->usernameField);

        
        return $this->render('sale/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreateSale(){
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
            if( !Yii::$app->user->identity->is_admin && isset($params['User']['is_admin']) )
                unset($params['User']['is_admin']);
            if( isset($params['Userinfo']) )
                $params['User'] = $params['Userinfo'];
            
            foreach($params['User'] as $column=>$value){
                $model->$column = $value;
            }
            
            $model->password = md5(md5($model->password));
            $model->create_date = time();
            $model->ip          = $_SERVER['REMOTE_ADDR'];
            $model->account_type= Employee::TYPE_SALE;
            $model->sale_admin_id = Yii::$app->user->identity->id;
            
            if( $model->account_type == Employee::TYPE_SALE ){
                $model->affliate_id = rand(100000,999999);
            }
            $model->save(false);
            
            $roles = ['Role Sale'];
            if( !empty($roles) ){
                $modelAssignment  = new Assignment($model->id);
                $modelAssignment->assign($roles);

                $Util               = new Util();
                $objLog             = new \stdClass();
                $objLog->data       = ['userid' => $model->id, 'role' => $roles ];
                
                $objLog->adminid    = trim(Yii::$app->user->identity->id);
                $objLog->adminname  = trim(Yii::$app->user->identity->username);
                
                $Util->writeLog('assignpermission',json_encode($objLog));

                $params['User']['id']= $model->id;
                $objLog->data       = $params['User'];
                $Util->writeLog('createuser',json_encode($objLog));

                foreach($model->userRole as $role=>$typechecked){
                    if( $typechecked == 'checked' && !in_array($role, $roles) )
                        $model->userRole[$role] = 'unchecked';
                    else if( in_array($role, $roles) )
                        $model->userRole[$role] = 'checked';
                }
            }

            $arrAttr['role']     = isset($roles) ? $roles : '';

            Yii::$app->session->setFlash('success', "Thêm tài khoản sale thành công");
            return $this->redirect('/sale-admin/list-sale');
        }  
        return $this->render('sale/create', [
            'model' => $model
        ]);
    }

    public function actionUpdateSale($id){
        $params = $_REQUEST;
        $model  = $this->findModelUpdate($id);
        
        if( $model == null || $model->sale_admin_id != Yii::$app->user->identity->id ){
            throw new \yii\web\HttpException(404, 'Không tìm thấy tài khoản sale nào');
            die;
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if( isset($params['User']) || isset($params['Userinfo']) ){
            if( !Yii::$app->user->identity->is_admin && isset($params['User']['is_admin']) )
                unset($params['User']['is_admin']);
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

            $model->save(false);

            $Util               = new Util();
            $objLog             = new \stdClass();
            $objLog->data       = $params['User'];
            
            $objLog->adminid    = trim(Yii::$app->user->identity->id);
            $objLog->adminname  = trim(Yii::$app->user->identity->username);
            
            $Util->writeLog('updateuser',json_encode($objLog));
            
            $arrAttr['role']     = isset($params['roles']) ? $params['roles'] : [];
            
            Yii::$app->session->setFlash('success', "Cập nhật tài khoản sale thành công");
        }  

        return $this->render('sale/update', [
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
                    if( $model == null || $model->sale_admin_id != Yii::$app->user->identity->id ){
                        return ['status'=>false,'msg'=>'Có lỗi! Không thể cấp lại mật khẩu'];
                        die;
                    }
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

        return $this->renderAjax('sale/_form_reset_password');

    }

    public function actionChangeStatusSale()
    {
        $listUserID     = Yii::$app->getRequest()->post('data', []);
        foreach($listUserID as $id){
            $model  = $this->findModelUpdate($id);
           
            if( $model != null && $model->sale_admin_id == Yii::$app->user->identity->id ){
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

    protected function findModelUpdate($id)
    {
        $class = $this->userClassName;
        return $class::findByID($id);
    }
}
