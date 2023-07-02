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
        
        $model = new Course();
        $condition = ['status'=>1];
        $category  = null;
        $template_view = 'listcourse';
        if( $slug ){
            $category = CourseCategory::find()->where(['slug'=>$slug,'is_delete'=>0])->one();
            if( $category ){
                $template_view = 'listcourse_cate';
                $condition['category_id'] = $category->id;
                $Course = $model->find()->where($condition)->all();
            }else{
                return $this->redirect(['index']);
            }
        }else{
            $Course = [];
            $listCategory    = CourseCategory::find()->where(['is_delete'=>0])->andWhere(['>','total_course',0])->orderBy(['last_time_add_course'=>SORT_DESC])->all();
            if( !empty($listCategory) ){
                foreach($listCategory as $cate){
                    $course  = Course::find()->where(['category_id'=>$cate->id,'status'=>1])->orderBy(['create_date'=>SORT_DESC])->limit(3)->all();
                    $Course[] = [
                        'cate' => $cate,
                        'course' => $course
                    ];
                }
            }
        }
        $listCoach = CoachCourse::getListCoach();
        return $this->render($template_view,[
            'listCoach' => $listCoach,
            'Courses'=>$Course,
            'category'=>$category
            // 'Sections'=>$Sections,
            // 'Lessions'=>$Lessions
        ]);
        
       
    }
    public function actionPayment($id){
        $Course       = Course::findOne(['id'=>$id]);
        return $this->redirect('http://' . $_SERVER['SERVER_NAME'] . '/payment/check-out?amount='.$Course->promotional_price.'&bankID=&course_id='.$Course->id);
    }
    public function actionDetail($slug,$slug_lesson=''){
        
        $isCourseOnline= true;
        $Course       = Course::findOne(['slug'=>$slug,'status'=>1]);
        
        if( $Course ){
            $model_lession = new CourseLesson();
            $model_section = new CourseSection();
            $id       = $Course['id'];
            $Sections = $model_section->find()->where(['course_id'=>$id])->all();
            $Lessions = $model_lession->find()->where(['course_id'=>$id])->orderBy(['sort'=>SORT_ASC,'id'=>SORT_ASC])->all();
            $isset_Course = false;//Đã Mua khoá học
            if( !Yii::$app->user->isGuest ){
                $user_id = Yii::$app->user->id;
                $model_userCourse =  new UserCourse();
                // $check_isset =  $model_userCourse->findOne(['course_id'=>4,'user_id'=>1]);
                $check_isset =  $model_userCourse->findOne(['course_id'=>$id,'user_id'=>$user_id]);
                $isset_Course = $check_isset ? true : false;
            }
            $Coach    = CoachCourse::findOne($Course->coach_id);
            return $this->render('index',[
                'Coach' => $Coach,
                'Course'=>$Course,
                'Sections'=>$Sections,
                'Lessions'=>$Lessions,
                'isset_Course' => $isset_Course,
                'slug_lesson' => $slug_lesson
            ]);
        }else{
            return $this->redirect('/');
        }
    }

    public function actionVideo($id = null)
    {
        if($id){
            $model = new Course();
            $model_lession = new CourseLesson();
            $model_section = new CourseSection();
            $Course = $model->find()->where(['id'=>$id])->one();
            $Sections = $model_section->find()->where(['course_id'=>$id])->all();
            $Lessions = $model_lession->find()->where(['course_id'=>$id])->orderBy(['sort'=>SORT_ASC,'id'=>SORT_ASC])->all();
            // var_dump($Lessions);die;
            $isset_Course = false;
            if( !Yii::$app->user->isGuest ){
                $user_id = Yii::$app->user->id;
                $model_userCourse =  new UserCourse();
                // $check_isset =  $model_userCourse->findOne(['course_id'=>4,'user_id'=>1]);
                $check_isset =  $model_userCourse->findOne(['course_id'=>$id,'user_id'=>$user_id]);
                $isset_Course = $check_isset ? true : false;
            }
            
            return $this->render('video',[
                'Course'=>$Course,
                'Sections'=>$Sections,
                'Lessions'=>$Lessions,
                'isset_Course'=>$isset_Course
            ]);
        }
        // $model = new Order();
       
        
       
    }

    public function actionCheckLesson()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if($id){
            $model_lession      = CourseLesson::findOne($id);
            $status             = 0;
            $isLogin            = !Yii::$app->user->isGuest;
            if( !$model_lession )
                return [
                    'status' => 0,
                    'title'  => '',
                    'short_desc' => '',
                    'desc'   => '',
                    'isLogin'=> $isLogin
                ];
            if(  $model_lession->is_prevew == 1 )
                $status = 1;
            else{
                if( $isLogin ){
                    $user_id            = Yii::$app->user->id;
                    if( $model_lession ){
                        $check_isset        = UserCourse::findOne(['course_id'=>$model_lession->course_id,'user_id'=>$user_id]);
                        $status             = $check_isset ? 1 : 0;
                    }
                }
            }
            $dataRating     = explode('/',$model_lession->rating);
            $star           = isset($dataRating[2]) ? $dataRating[2] : 0;
            return [
                'status' => $status,
                'title'  => $model_lession->name,
                'short_desc' => $model_lession->short_description,
                'desc'   => $model_lession->description,
                'star'   => $star,
                'isLogin'=> $isLogin,
                'userInfo' => $isLogin ? Yii::$app->user->identity->fullname . ' ' . Yii::$app->user->identity->phone : ''
            ];
        }else
            return [
                'status' => 0,
                'title'  => '',
                'short_desc' => '',
                'desc'   => '',
                'image'  => '',
                'isLogin'=> !Yii::$app->user->isGuest
            ];
       
    }
    
    public function actionBlockContent(){
        $Course       = Course::findOne(['id'=>$_GET['id'],'status'=>1]);
        return $this->renderAjax('block_content',[
            'Course'  => $Course
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
