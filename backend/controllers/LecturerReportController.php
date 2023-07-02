<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Course;
use backend\models\CourseSearch;
use backend\models\CourseLesson;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
/**
 * Site controller
 */
class LecturerReportController extends Controller
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
            $category_id= isset($post['category_id']) ? $post['category_id'] : [];
            return $this->getDataStatistic($post['type'], $post['date_start'],$post['date_end'], $category_id,true);
        }
        $dataStatistic = $this->getDataStatistic('all', $date_start,$date_end);
        
        return $this->render('index', [
            'dataStatistic' => $dataStatistic,
            'date_start' => $date_start,
            'date_end'   => $date_end
        ]);
    }

    public function actionListCourse(){

        $searchModel = new CourseSearch();
        $searchModel->lecturer_id = Yii::$app->user->identity->lecturer_id ? Yii::$app->user->identity->lecturer_id : -1;
        if( isset($_GET['date_start']) )
            $searchModel->date_start = $_GET['date_start'];
        if( isset($_GET['date_end']) )
            $searchModel->date_end = $_GET['date_end'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('course/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewCourse($id)
    {
        return $this->render('course/view', [
            'model' => $this->findModelCourse($id),
        ]);
    }

    public function actionViewLesson($id)
    {
        return $this->render('course-lesson/view', [
            'model' => $this->findModelLesson($id),
        ]);
    }

    protected function findModelCourse($id)
    {
        if (($model = Course::findOne(['id' => $id, 'lecturer_id' => Yii::$app->user->identity->lecturer_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelLesson($id)
    {
        if (($model = CourseLesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getDataStatistic($type = 'all', $date_start = '', $date_end = '', $category_id = null,$isAjax=false){
        
        $data = [
            'total_course'      => 0,
            'total_view'        => 0,
            'total_register'    => 0,
            'total_study'       => 0,
            'chart'             => [
                'view_all'      => [
                    'labels'    => [],
                    'datasets'  => [
                        'course'=> [
                            'label' => 'Khoá học',
                            'backgroundColor' => 'rgb(54, 162, 235)',
                            'borderColor' => 'rgb(54, 162, 235)',
                            'data'  => [],
                        ],
                    ]
                ]
            ]
        ];

        $lecturer_id  = Yii::$app->user->identity->lecturer_id;

        $listCourseId = $lecturer_id > 0 ? ArrayHelper::map( Course::find()->where(['is_delete' => 0, 'lecturer_id' => $lecturer_id])->all() , 'id', 'id') : [0];

        $condition_course_viewed  = 'course_id IN (' . implode(',', $listCourseId) . ')';
        $params_course_viewed     = [];
        if( $date_start != '' ){
            $condition_course_viewed .= ' and date >= :date_start';
            $params_course_viewed[':date_start'] = $date_start;
        }
        
        if( $date_end != '' ){
            $condition_course_viewed .= ' and date <= :date_end';
            $params_course_viewed[':date_end'] = $date_end;
        }

        if( $type == 'all' || $type == 'summary' ){
            $params_summary = $params_course_viewed;
            if( isset($params_summary[':date_end']) )
                $params_summary[':date_end'] .= ' 23:59:59';
            $sql_statistic_summary  = '
                SELECT count(id) as total, "course_total" as type from course WHERE lecturer_id = ' . $lecturer_id . ' and create_date >= :date_start and create_date <= :date_end
                UNION ALL
                SELECT SUM(total_view) as total, "course_viewed" as type from course_viewed WHERE ' . $condition_course_viewed . '
                UNION ALL
                SELECT count(id) as total, "user_reg" as type FROM (
                    SELECT A.id FROM order_cart A
                    INNER JOIN order_cart_product B ON A.id = B.order_cart_id
                    WHERE B.course_id IN (' . implode(',', $listCourseId) . ') and A.status IN (0, 1) and create_date >= :date_start and create_date <= :date_end
                    GROUP BY A.id
                ) X
                UNION ALL
                SELECT count(id) as total, "user_study" as type FROM (
                    SELECT A.id FROM order_cart A
                    INNER JOIN order_cart_product B ON A.id = B.order_cart_id
                    WHERE B.course_id IN (' . implode(',', $listCourseId) . ') and A.status = 1 and create_date >= :date_start and create_date <= :date_end
                    GROUP BY A.id
                ) X
            ';

            $resultSummary    = Yii::$app->db->CreateCommand($sql_statistic_summary, $params_summary)->queryAll();
            if( !empty($resultSummary) ){
                foreach($resultSummary as $row){
                    $type_summary = $row['type'];
                    switch($type_summary){
                        case 'course_total':
                            $data['total_course'] += $row['total'];
                            break;
                        case 'course_viewed':
                            $data['total_view'] += $row['total'];
                            break;
                        case 'user_reg':
                            $data['total_register'] = $row['total'];
                            break;
                        case 'user_study':
                            $data['total_study'] = $row['total'];
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        $dataAllCourseViewed    = [];
        if( $type == 'all' || $type == 'view_all' ){
            $sql_statistic_course_view = "
                SELECT SUM(total_view) as total, date_format(date,'%d/%m') as date FROM course_viewed where " . $condition_course_viewed . " group by date
            ";
            $result_course_viewed  = Yii::$app->db->CreateCommand($sql_statistic_course_view, $params_course_viewed)->queryAll();
            
            if( !empty($result_course_viewed) ){
                foreach($result_course_viewed as $row){
                    $dataAllCourseViewed[$row['date']] = (int)$row['total'];
                }
            }

        }
        
        if( $type == 'all' || $type != 'summary' ){
            $date_end   = date('Y-m-d', strtotime(' + 1 day',strtotime($date_end)));
            $period = new \DatePeriod(
                new \DateTime($date_start),
                new \DateInterval('P1D'),
                new \DateTime($date_end)
            );
            foreach ($period as $key => $value) {
                $date = $value->format('d/m');

                $data['chart']['view_all']['labels'][] = $date;
                $data['chart']['view_all']['datasets']['course']['data'][] = array($date, (isset($dataAllCourseViewed[$date]) ? $dataAllCourseViewed[$date] : 0));

            }
            $data['chart']['view_all']['datasets'] = array_values($data['chart']['view_all']['datasets']);
        }
       
        return $data;
    }

}
