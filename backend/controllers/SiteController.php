<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Customer;
use backend\models\CourseSearch;
use backend\models\News;
use backend\models\Employee;
use backend\controllers\CommonController;
use DatePeriod;
use DateTime;
use DateInterval;
use finfo;
/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error','test'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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

    public function beforeAction($action) 
    { 
        if( !Yii::$app->user->isGuest && !Yii::$app->user->identity->is_admin && in_array(Yii::$app->user->identity->account_type, [Employee::TYPE_LECTURER, Employee::TYPE_SALE, Employee::TYPE_SALE_ADMIN]) ){

            $url_access = Yii::$app->request->url;
            if( $url_access == '/' || strpos($url_access, 'site/index') !== false ){
                $url_redirect = Yii::$app->user->identity->account_type == Employee::TYPE_LECTURER ? '/lecturer-report/index' : '/sale/index';
                if( Yii::$app->user->identity->account_type == Employee::TYPE_SALE_ADMIN ){
                    $url_redirect = '/sale-admin/index';
                }
                header('Location: ' . $url_redirect);
                exit();
            }
        }
        return parent::beforeAction($action); 
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
        if( Yii::$app->user->identity->is_admin || CommonController::checkRolePermission('view_dashboard') ){
            $date_start    = date('Y-m-01');
            $date_end      = date('Y-m-d');
            if( Yii::$app->request->isPost ){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $post       = Yii::$app->request->post();
                return $this->getDataStatistic($post['type'], $post['date_start'],$post['date_end'],true);
            }
            $dataStatistic = $this->getDataStatistic('all', $date_start,$date_end);

            return $this->render('index', [
                'dataStatistic' => $dataStatistic,
                'date_start' => $date_start,
                'date_end'   => $date_end
            ]);
        }else{
            return $this->render('index_default', [
            ]);
        }
    }

    private function getDataStatistic($type = 'all', $date_start = '', $date_end = '', $isAjax=false){
        
        $data = [
            'total_revenue'      => 0,
            'total_course_sell'  => 0,
            'total_user_register'=> 0,
            'total_user_lock'    => 0,
        ];


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
                SELECT count(id) as total, "course_sell" as type from course WHERE is_delete = 0 and status = 1 and price > 0
                UNION ALL
                SELECT SUM(A.price) as total, "order_price_success" as type FROM order_cart A
                WHERE A.status = 1 and create_date >= :date_start and create_date <= :date_end
                UNION ALL
                SELECT count(A.id) as total, "user_reg" as type FROM users A
                WHERE A.create_date >= :date_start and A.create_date <= :date_end
                UNION ALL
                SELECT count(A.id) as total, "user_lock" as type FROM users A
                WHERE A.date_banned >= :date_start and A.date_banned <= :date_end and A.status <> 1
                
            ';

            $resultSummary    = Yii::$app->db->CreateCommand($sql_statistic_summary, $params_summary)->queryAll();
            if( !empty($resultSummary) ){
                foreach($resultSummary as $row){
                    $type_summary = $row['type'];
                    switch($type_summary){
                        case 'course_sell':
                            $data['total_course_sell'] = $row['total'];
                            break;
                        case 'order_price_success':
                            $data['total_revenue'] = number_format($row['total'], 0, ',', ',');
                            break;
                        case 'user_reg':
                            $data['total_user_register'] = $row['total'];
                            break;
                        case 'user_lock':
                            $data['total_user_lock'] = $row['total'];
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        return $data;
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'login';
        $model = new LoginForm();
        $model->login_backend = 1;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Yii::$app->user->identity->save();
            if( Yii::$app->user->identity->lecturer_id ){
                return $this->redirect(['/lecturer-report/index']);
            }else if( Yii::$app->user->identity->account_type == Employee::TYPE_SALE_ADMIN ){
                return $this->redirect(['/sale-admin/index']);
            }
            if( isset($_GET['return']) && !empty($_GET['return']) )
                return $this->redirect($_GET['return']);
            return $this->goBack();

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
