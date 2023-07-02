<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\OrderCart;
use backend\models\CourseSearch;
use backend\models\OrderCartSearch;
use backend\models\OrderCartProduct;
use yii\helpers\ArrayHelper;
/**
 * Sale controller
 */
class SaleController extends Controller
{
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $date_start    = date('Y-m-d', strtotime(' - 6 day', time()));
        $date_end      = date('Y-m-d');
        if( Yii::$app->request->isPost ){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post       = Yii::$app->request->post();
            return $this->getDataStatistic($post['type'], $post['date_start'],$post['date_end'],true);
        }
        $dataStatistic = $this->getDataStatistic('all', $date_start,$date_end);
        
        $searchModel = new OrderCartSearch();
        $searchModel->affliate_id = Yii::$app->user->identity->affliate_id ? Yii::$app->user->identity->affliate_id : -1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchCourseModel  = new CourseSearch();
        $dataProviderCourse  = $searchCourseModel->searchSale(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataStatistic' => $dataStatistic,
            'date_start' => $date_start,
            'date_end'   => $date_end,
            'dataProviderCourse' => $dataProviderCourse,
            'searchCourseModel' => $searchCourseModel
        ]);
    }

    private function getDataStatistic($type = 'all', $date_start = '', $date_end = '',$isAjax=false){
        
        $data = [
            'total_order'           => 0,
            'total_order_success'   => 0,
            'total_revenue'         => 0
        ];

        $affliate_id= Yii::$app->user->identity->affliate_id ? Yii::$app->user->identity->affliate_id : -1;
        $params     = [':affliate_id' => $affliate_id];
        
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
                WHERE create_date >= :date_start and create_date <= :date_end and A.affliate_id = :affliate_id
                UNION ALL
                SELECT count(A.id) as total, "order_success" as type FROM order_cart A
                WHERE A.status = 1 and create_date >= :date_start and create_date <= :date_end and A.affliate_id = :affliate_id
                UNION ALL
                SELECT SUM(A.price) as total, "order_price_success" as type FROM order_cart A
                WHERE A.status = 1 and create_date >= :date_start and create_date <= :date_end and A.affliate_id = :affliate_id                
            ';

            $resultSummary    = Yii::$app->db->CreateCommand($sql_statistic_summary, $params_summary)->queryAll();
            
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
                        case 'order_price_success':
                            $percent_revenue = Yii::$app->user->identity->commission_percentage;
                            $data['total_revenue'] = number_format(($row['total']/100)*$percent_revenue, 0, ',', ',');
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return $data;
    }

}
