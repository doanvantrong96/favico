<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use backend\models\CourseSection;
use backend\models\CourseCategory;
use backend\models\UserCourse;
use backend\models\News;
use backend\models\CoachCourse;
use backend\models\CourseOffline;
use frontend\models\Contact;
use yii\helpers\Url;

use backend\models\Course;
use backend\models\CourseLesson;
use backend\models\Lecturer;

/**
 * Site controller
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthFb'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function beforeAction($action)
    {
        if ( !Yii::$app->user->identity ) {
            $url_access = Yii::$app->request->url;
            if( strpos($url_access, 'chi-tiet-khoa-hoc') !== false )
                Yii::$app->session->set('url_access', $url_access);
        }
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($slug=null)
    {
        return $this->render('index',[
        ]);
    }

    public function actionDetail($slug=null)
    {
        return $this->render('detail',[
        ]);
    }
    

    public function actionSearch(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query  = strip_tags(Yii::$app->request->get('q'));
        $type   = Yii::$app->request->get('type');
        $arr_data = [];
        if( $type == 'all' ){ //tên giáo viên, khoá học, bài học
            $course  = Course::find()
            ->where(['status'=>1,'is_delete' => 0])
            ->andWhere(['like','name',$query])
            ->orderBy(['create_date'=>SORT_DESC])
            ->asArray()
            ->all();

            $lecturer = Lecturer::find()
            ->where(['status'=>1,'is_delete' => 0])   
            ->andWhere(['like','name',$query])
            ->asArray()
            ->all();

            $course_lesson = CourseLesson::find()
            ->select(['A.id','A.name','A.avatar','A.course_id','A.description','A.duration','A.link_video','B.slug AS slug_course'])
            ->from(CourseLesson::tableName() . ' A')
            ->innerJoin(Course::tableName() . ' B', 'B.id = A.course_id')
            ->where(['like','A.name',$query])
            ->asArray()
            ->orderBy(['id' => SORT_DESC])
            ->all();

            if(!empty($course)){
                foreach($course as $item){
                    $arr_data[] = [
                        'link'  => Url::to(['/course/course-overview','slug_course' => $item['slug']]),
                        'avatar' => 'https://elearning.abe.edu.vn' . $item['avatar'],
                        'name'  => $item['name'],
                        'description' => $item['description'],
                    ];
                }
            }
            if(!empty($lecturer)){
                foreach($lecturer as $item){
                    $arr_data[] = [
                        'link'  => Url::to(['/lecturers/detail','slug' => $item['slug']]),
                        'avatar' => 'https://elearning.abe.edu.vn' . $item['avatar'],
                        'name'  => $item['name'],
                        'description' => $item['level'],
                    ];
                }
            }
            if(!empty($course_lesson)){
                foreach($course_lesson as $item){
                    $arr_data[] = [
                        'link'  => Url::to(['/course/index','slug_detail' => $item['slug_course']]),
                        'avatar' => 'https://elearning.abe.edu.vn' . $item['avatar'],
                        'name'  => $item['name'],
                        'description' => $item['description'],
                    ];
                }
            }
        }
        return [
            'status' => 1,
            'data' => $arr_data
        ];
    }
    public function actionRating(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id     = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
        $star   = isset($_REQUEST['star']) ? (int)$_REQUEST['star'] : 0;
        $data   = [
            'status' => 0,
            'star'   => 0,
            'msg'    => ''
        ];
        if( !Yii::$app->user->isGuest ){
            if( $id > 0 && $star > 0 ){
                $model_lession      = CourseLesson::findOne($id);
                if( !empty($model_lession) ){
                    $user_id            = Yii::$app->user->id;
                    $check_isset        = UserCourse::findOne(['course_id'=>$model_lession->course_id,'user_id'=>$user_id]);
                    if( $model_lession->is_prevew == 1 || $check_isset ){
                        //10/50/5
                        $dataRating     = explode('/',$model_lession->rating);
                        $dataRating[0]  = $dataRating[0] + 1;
                        $dataRating[1]  = $dataRating[1] + $star;
                        $dataRating[2]  = round($dataRating[1]/$dataRating[0]);

                        $model_lession->rating = implode('/', $dataRating);
                        $model_lession->save(false);

                        $data['status'] = 1;
                        $data['star']   = $dataRating[2];
                        $data['msg']    = "Đánh giá thành công";
                    }
                }else{
                    $data['msg']    = "Thông tin không hợp lệ";
                }
            }else{
                $data['msg']    = "Thông tin không hợp lệ";
            }
        }else{
            $url_login      = Url::to(['site/login']);
            $data['msg']    = "Vui lòng đăng nhập để đánh giá. <a style='text-decoration: underline;color:#fff' href='$url_login'>Đăng nhập ngay</a>";
        }
        return $data;
    }
}
