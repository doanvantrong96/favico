<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Users;
use backend\models\Course;
use backend\models\CoachCourse;
use backend\models\CourseLesson;
use backend\models\CourseCategory;
use common\models\Order;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ForgotPassword;
use frontend\models\ContactForm;
use yii\data\ArrayDataProvider;
use backend\models\News;
use frontend\models\Contact;

use backend\models\Banner;
use backend\models\Lecturer;
use backend\models\Partner;
use backend\models\StudentStory;
use backend\models\FrequentlyQuestions;
use backend\models\OrderCart;
use backend\models\OrderCartProduct;
use backend\models\UserCourse;
use backend\models\CourseLessonActive;
use backend\models\CourseLessonNote;
use backend\models\FavoriteCourse;
use backend\models\ContinueLesson;
use backend\models\GiftCode;
use backend\models\UserRegisterEmail;
use backend\models\CommunityStory;
use backend\models\UserLogin;
use backend\models\FrequentlyQuestionsGroup;
use frontend\controllers\PaymentsController;


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
                'only' => ['logout'],
                'rules' => [
                    // [
                    //     'actions' => ['signup'],
                    //     'allow' => true,
                    //     'roles' => ['?'],
                    // ],
                    [
                        'actions' => ['logout','historyOrder'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
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
    public function oAuthFb($client)
    {
        try {
            $userAttributes = $client->getUserAttributes();
            if (is_array($userAttributes) && $userAttributes) {
                /*
                * Check có tài khoản hay chưa bằng fb_id
                */
                // $model = new UsersLoginForm();
                $fullname   = '';
                $email      = '';
                
                $email      = isset($userAttributes['email']) ? $userAttributes['email'] : '';
                $fullname   = $userAttributes['name'];
                $fb_id      = $userAttributes['id'];
                $app_access_token = "1637958006659754|NThZ9F49ZlHR_7WvYucvwFdel_8";
                $avatar      = "https://graph.facebook.com/". $fb_id ."/picture?type=large&access_token=" . $app_access_token;
                //Kiểm tra xem id fb đã tồn tại chưa: Nếu có thì login / Tạo tài khoản mới
                $checkExist = Users::findOne(['fb_id'=>$fb_id]);
                if( !$checkExist && !empty($email) ){
                    $checkExist = Users::findOne(['email'=>$email]);
                }

                if( $checkExist ){
                    $checkExist->fb_id = $fb_id;
                    $checkExist->save(false);
                    $user           = $checkExist;
                }else{
                    $user           = new Users();
                    $user->fullname = $fullname;
                    $user->email    = $email;
                    $user->fb_id    = $fb_id;
                    $user->avatar   = $avatar;
                    // $user->generateEmailVerificationToken();
                    $user->save(false);
                    // if( !empty($email) ){
                    //     SignupForm::sendEmail($user);
                    // }
                }
                Yii::$app->user->login($user, 3600 * 24 * 30 );
                return $this->goHome();
            } else {
                
            }
            return $this->goHome();
        } catch (\Exception $e) {
            var_dump($e);die;
        }
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->title = 'Viện nghiên cứu phát triển kinh tế Châu Á - Thái Bình Dương';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'ABE Academy cung cấp các khoá học trực tuyến được tạo cho sinh viên ở mọi cấp độ kỹ năng. Chuyên gia hướng dẫn tốt nhất Việt Nam.'
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => '/images/page/logo.png'
        ]);
       Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
        ]);
        //bài giảng nổi bật (1 bài)
        $course_hot_big = Course::find()
        ->select(['A.id','A.trailer','A.name','A.avatar','A.price','A.slug','A.description','B.name AS lecturer_name'])
        ->where(['A.status' => 1,'A.is_delete' => 0,'A.is_hot_big' => 1])->from(Course::tableName() . ' A')
        ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
        ->asArray()
        ->one();

        //khóa học nổi bật
        $course_is_hot = Course::find()->select(['A.id','A.trailer','A.price','A.slug','A.name','A.avatar','A.total_duration','A.description','B.name AS lecturer_name'])
        ->where(['A.status' => 1,'A.is_delete' => 0,'A.is_hot' => 1])
        ->from(Course::tableName() . ' A')
        ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
        ->asArray()
        ->orderBy(['A.hot_pos' => SORT_ASC])
        ->all();

        $isset_check = false;
        $course_lesson_all = [];
        $result_continue = [];
        $list_id_course_user = [];
        $list_fa = [];
        if(!Yii::$app->user->isGuest){
            $view = 'index_user';
            $user_id = Yii::$app->user->identity->id;
            
            $list_id_course = array_column($course_is_hot, 'id');
            $favotite = FavoriteCourse::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['in','course_id',$list_id_course])
            ->asArray()
            ->all();
            if(!empty($favotite)){
                foreach($favotite as $fa){
                    $list_fa[$fa['course_id']] = $fa['course_id'];
                }
            }
          
            //mới tham gia
            $course_lesson_all = Course::find()
            ->select(['A.id','A.name','A.avatar','A.description','A.total_duration','A.lecturer_id','A.slug AS slug_course','C.name AS name_lecturer'])
            ->from(Course::tableName() . ' A')
            ->where(['A.status' => 1,'A.is_delete' => 0])
            ->innerJoin(Lecturer::tableName() . ' C', 'A.lecturer_id = C.id')
            ->asArray()
            ->orderBy(['A.id' => SORT_DESC])
            ->all();
          
            //kiểm tra user đã mua khóa học chưa, lấy list bài học mới mua
            $user_course = UserCourse::find(['user_id' => $user_id])->asArray()->all();
            $list_course_user = array_column($user_course,'course_id');
            if(!empty($user_course)){
                //tiếp tục xem
                $continue = ContinueLesson::find()->where(['user_id' => $user_id,'is_end' => 0])->asArray()->all();
              
                $list_lesson_continue = array_column($continue,'lesson_id');
                $result_continue = CourseLesson::find()
                ->select(['A.id','A.sort','A.name','A.avatar','A.course_id','A.description','A.duration','A.link_video','B.slug AS slug_course','B.total_lessons','C.name AS name_lecturer','D.time'])
                ->from(CourseLesson::tableName() . ' A')
                ->innerJoin(Course::tableName() . ' B', 'B.id = A.course_id')
                ->where(['in','A.id',$list_lesson_continue])
                ->andWhere(['D.user_id' => $user_id])
                ->innerJoin(Lecturer::tableName() . ' C', 'B.lecturer_id = C.id')
                ->innerJoin(ContinueLesson::tableName() . ' D', 'D.lesson_id = A.id')
                ->asArray()
                ->orderBy(['id' => SORT_ASC])
                ->all();
                
                $course_lesson_asc = CourseLesson::find()
                ->select(['A.id','A.sort','A.name','A.avatar','A.course_id','A.description','A.duration','A.link_video','B.slug AS slug_course','B.total_lessons','C.name AS name_lecturer'])
                ->from(CourseLesson::tableName() . ' A')
                ->innerJoin(Course::tableName() . ' B', 'B.id = A.course_id')
                ->where(['in','A.course_id',$list_course_user])
                ->innerJoin(Lecturer::tableName() . ' C', 'B.lecturer_id = C.id')
                ->asArray()
                ->orderBy(['id' => SORT_ASC])
                ->all();
            }


            //kiểm tra user đã mua khóa học hot big chưa
            $list_id_course_hot = array_column($course_is_hot, 'id');
            // echo '<pre>';
            // print_r($list_id_course_hot);
            // echo '</pre>';
            // die;
            $user_course_big = UserCourse::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['in','course_id',$list_id_course_hot])
            ->asArray()
            ->all();
            if(!empty($user_course_big)){
                $list_id_course_user = array_column($user_course_big,'course_id');
            }
          
            // $isset_check = ($user_course_big || $course_hot_big['price'] == 0) ? true : false;
        }
        else
            $view = 'index';

        $banner = Banner::find()->where(['status' => 1, 'is_delete' => 0])->all();
    
        //đối tác
        $partner = Partner::find()->where(['status' => 1,'is_delete' => 0])->orderBy(['position' => SORT_ASC])->asArray()->all();
        

        $arr_slide_video_index = array_merge([$course_hot_big],$course_is_hot);
      
        //khóa học sắp diễn ra 
        $course_is_coming = Course::find()->select(['A.id','A.slug','A.name','A.avatar','A.description','A.time_coming','B.name AS lecturer_name'])
        ->where(['A.is_delete' => 0,'A.is_coming' => 1])
        ->from(Course::tableName() . ' A')
        ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
        ->orderBy(['time_coming' => SORT_DESC])
        ->asArray()
        ->all();

        //sự kiện nổi bật
        $news_query = News::find()
        ->select(['A.id','A.title','A.slug','A.description','A.image','A.create_at','A.hot_pos'])
        ->where(['A.status' => 1, 'A.is_delete' => 0,'A.is_hot' => 1])
        ->from(News::tableName() . ' A');
        $result_new_hot = $news_query->asArray()
        ->orderBy(['hot_pos' => SORT_ASC])
        ->all();
      
        //câu chuyện của học viên
        $result_story = StudentStory::find()->where(['status' => 1,'is_delete' => 0])->asArray()->all();

        //câu hỏi thường gặp
        $result_question = FrequentlyQuestions::find()
        ->select(['A.id','A.question','A.answer','B.name'])
        ->from(FrequentlyQuestions::tableName() . ' A')
        ->innerJoin(FrequentlyQuestionsGroup::tableName() . ' B', 'A.group_id = B.id')
        ->where(['A.status' => 1,'A.is_delete' => 0])
        ->orderBy(['B.position' => SORT_ASC])
        ->asArray()
        ->all();
        $arr_ques = [];
        if(!empty($result_question)){
            foreach($result_question as $ques){
                $arr_ques[$ques['name']][] = $ques;
            }
        }
        return $this->render($view,[
            'banner'                => $banner,
            'course_hot_big'        => $course_hot_big,
            'partner'               => $partner,
            'course_is_hot'         => $course_is_hot,
            'course_is_coming'      => $course_is_coming,
            'result_new_hot'        => $result_new_hot,
            'result_story'          => $result_story,
            'arr_ques'              => $arr_ques,
            'course_lesson_all'     => $course_lesson_all,
            'result_continue'       => $result_continue,
            'isset_check'           => $isset_check,
            'arr_slide_video_index' => $arr_slide_video_index,
            'list_id_course_user'   => $list_id_course_user,
            'list_fa'               => $list_fa,
        ]);
    }

    public function actionMyProgress(){
        $this->view->title = 'Tiến trình của tôi';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Tiến trình của tôi'
        ]);

        $user_id = Yii::$app->user->identity->id;
     
        //kiểm tra user đã mua khóa học chưa, lấy list bài học mới mua
        $course_lesson_all = [];
        $course_lesson_asc = [];
        $result_continue = [];
        $user_course = UserCourse::find(['user_id' => $user_id])->asArray()->all();
       
        if(!empty($user_course)){
            $list_course_user = array_column($user_course,'course_id');
            $course_lesson_all = CourseLesson::find()
            ->select(['A.id','A.name','A.avatar','A.course_id','A.description','A.duration','A.link_video','B.slug AS slug_course'])
            ->from(CourseLesson::tableName() . ' A')
            ->innerJoin(Course::tableName() . ' B', 'B.id = A.course_id')
            ->where(['in','A.course_id',$list_course_user])
            ->asArray()
            ->orderBy(['id' => SORT_DESC])
            ->all();

            //tiếp tục xem
            $continue = ContinueLesson::find()->where(['user_id' => $user_id,'is_end' => 0])->asArray()->all();
            $list_lesson_continue = array_column($continue,'lesson_id');
            $result_continue = CourseLesson::find()
            ->select(['A.id','A.sort','A.name','A.avatar','A.course_id','A.description','A.duration','A.link_video','B.slug AS slug_course','B.total_lessons','C.name AS name_lecturer','D.time'])
            ->from(CourseLesson::tableName() . ' A')
            ->innerJoin(Course::tableName() . ' B', 'B.id = A.course_id')
            ->where(['in','A.id',$list_lesson_continue])
            ->andWhere(['D.user_id' => $user_id])
            ->innerJoin(Lecturer::tableName() . ' C', 'B.lecturer_id = C.id')
            ->innerJoin(ContinueLesson::tableName() . ' D', 'D.lesson_id = A.id')
            ->asArray()
            ->orderBy(['id' => SORT_ASC])
            ->all();
        }
        //ghi chu
        $note = CourseLessonNote::find()
        ->select(['A.note','A.lesson_id','B.avatar AS avatar_lesson','B.name','B.description','C.name AS name_course','C.avatar AS avatar_course','C.slug AS slug_course','C.id AS course_id','D.name AS lecturer_name','D.avatar AS lecturer_avatar'])
        ->from(CourseLessonNote::tableName() . ' A')
        ->innerJoin(CourseLesson::tableName() . ' B','B.id = A.lesson_id')
        ->innerJoin(Course::tableName() . ' C','B.course_id = C.id')
        ->innerJoin(lecturer::tableName() . ' D','C.lecturer_id = D.id')
        ->where(['user_id' => $user_id])
        ->orderBy(['sort' => SORT_ASC])
        ->asArray()
        ->all();
       
        $arr_node = array();
        foreach ($note as $field) {
            if (isset($arr_node[$field['course_id']])) {
                $arr_node[$field['course_id']][] = $field;
            } else {
                $arr_node[$field['course_id']][] = $field;
                // $arr_node[$field['course_id']] = $field['name'];
            }
        }
        $arr_node = array_values($arr_node);
        

        //đánh dấu của tôi
        $FavoriteCourse = FavoriteCourse::find()
        ->select(['A.course_id','B.avatar','B.name AS name_course','B.total_duration','B.slug AS slug_course','C.name AS name_lecturer'])
        ->from(FavoriteCourse::tableName() . ' A')
        ->where(['user_id' => $user_id])
        ->innerJoin(Course::tableName() . ' B','B.id = A.course_id')
        ->innerJoin(Lecturer::tableName() . ' C','C.id = B.lecturer_id')
        ->asArray()
        ->all();

        //khóa học của tôi
        $my_course = UserCourse::find()
        ->select(['A.course_id','B.avatar','B.name AS name_course','B.total_duration','B.slug AS slug_course','C.name AS name_lecturer'])
        ->from(UserCourse::tableName() . ' A')
        ->where(['user_id' => $user_id])
        ->innerJoin(Course::tableName() . ' B','B.id = A.course_id')
        ->innerJoin(Lecturer::tableName() . ' C','C.id = B.lecturer_id')
        ->asArray()
        ->all();

        //các lớp học đã thành thạo
        $course_active = CourseLessonActive::find()
        ->select(['A.course_id','A.create_date','B.avatar','B.name AS name_course','B.certificate','B.total_duration','B.slug AS slug_course','C.name AS name_lecturer'])
        ->where(['A.user_id' => $user_id,'A.lesson_id' => 0])
        ->from(CourseLessonActive::tableName() . ' A')
        ->innerJoin(Course::tableName() . ' B','B.id = A.course_id')
        ->innerJoin(Lecturer::tableName() . ' C','C.id = B.lecturer_id')
        ->asArray()
        ->all();
        
        return $this->render('my_progress',[
            'course_lesson_all'     => $course_lesson_all,
            'course_lesson_asc'     => $course_lesson_asc,
            'note'                  => $note,
            'FavoriteCourse'        => $FavoriteCourse,
            'course_active'         => $course_active,
            'result_continue'       => $result_continue,
            'arr_node'              => $arr_node,
            'my_course'             => $my_course
        ]);
    }

    public function actionMyStory(){
        $result_story = CommunityStory::find()->where(['status' => 1,'is_delete' => 0])->limit(8)->asArray()->all();
       
        if(isset($_POST['page'])){
            $page = $_POST['page'];
            $offset = $page * 8;
            $result_story_more = CommunityStory::find()->where(['status' => 1,'is_delete' => 0])->limit(8)->offset($offset)->asArray()->all();
            $result_story_more_offset = CommunityStory::find()->where(['status' => 1,'is_delete' => 0])->limit(8)->offset($offset + 8)->asArray()->one();
           
            $html = '';
            if(!empty($result_story_more)){
                $i = $offset;
                foreach($result_story_more as $item){
                    $pos = strpos($item['image'], '.mp4');
                       if($pos)
                       {
                            $file = '<video class="w-100" controls>
                                    <source src="'. $item['image'] .'" type="video/mp4">
                                </video>';
                       }else{ 
                            $file = '<img class="w-100 radius_10 img_modal_story" src=" '. $item['image'] .'" alt="">';
                        }
                    $i++;
                    $html .= '<img class="w-100 img_thumb_story" src="'.$item['image'] .'" alt="" data-toggle="modal" data-target="#story_modal_'. $i .'">
                    <div class="modal fade" id="story_modal_'. $i .'" tabindex="-1" role="dialog" aria-labelledby="title_story" aria-hidden="true">
                       <div class="modal-dialog dialog_story" role="document">
                          <div class="modal-content">
                             <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                             </button>
                             </div>
                             <div class="modal-body">
                             <div class="group_story_modal">
                                <div class="text_left_story">
                                      <p class="fz-18">'. $item['content'] .'</p>
                                      <p class="fz-14 mt-4">'. $item['fullname'] . ' ' . $item['address'] .' </p>
                                </div>
                                <div>
                                      '. $file .'
                                </div>
                             </div>
                             </div>
                          </div>
                       </div>
                    </div>';
                }
            }
            $data['data'] = $html;
            $data['offset'] = $result_story_more_offset;
            echo json_encode($data);
            exit;
           
        }

        //câu hỏi thường gặp
        $result_question = FrequentlyQuestions::find()
        ->select(['A.id','A.question','A.answer','B.name'])
        ->from(FrequentlyQuestions::tableName() . ' A')
        ->innerJoin(FrequentlyQuestionsGroup::tableName() . ' B', 'A.group_id = B.id')
        ->where(['A.status' => 1,'A.is_delete' => 0])
        ->orderBy(['B.position' => SORT_ASC])
        ->asArray()    
        ->all();
        $arr_ques = [];
        if(!empty($result_question)){
            foreach($result_question as $ques){
                $arr_ques[$ques['name']][] = $ques;
            }
        }
        $this->view->title = 'Chia sẻ câu chuyện của tôi';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Chia sẻ câu chuyện của tôi'
        ]);
        return $this->render('my_story',[
            'result_story'  => $result_story,
            'arr_ques'      => $arr_ques,
        ]);
    }

    public function actionCreateStory(){
        if(!empty($_POST)){
            $address = $_POST['address'];
            $content = $_POST['content'];
            $expert_name = $_POST['expert_name'];
            $file_name = NULL;
            
            if (!empty($_FILES['images'])) {
                $file_name = $this->actionUploadFileAuthor($_FILES['images']);
            }
            $model = new CommunityStory();
            $model->user_id = Yii::$app->user->identity->id;
            $model->fullname = Yii::$app->user->identity->fullname;
            $model->email = Yii::$app->user->identity->email;
            $model->address = $address;
            $model->content = $content;
            $model->image = $file_name;
            $model->expert_name = $expert_name;
            $model->file_path = $file_name;
            $model->save(false);
            echo 1;
            exit;
        }
    }

    public function actionUploadFileAuthor($files)
    {
        if (!empty($files)) {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            // Create directory if it does not exist
            if (!is_dir("uploads/image-story/")) {
                mkdir("uploads/image-story/");
            }
            if (!is_dir("uploads/image-story/" . $year . "/")) {
                mkdir("uploads/image-story/" . $year . "/");
            }
            if (!is_dir("uploads/image-story/" . $year . "/" . $month . "/")) {
                mkdir("uploads/image-story/" . $year . "/" . $month . "/");
            }
            if (!is_dir("uploads/image-story/" . $year . "/" . $month . "/" . $day . "/")) {
                mkdir("uploads/image-story/" . $year . "/" . $month . "/" . $day . "/");
            }
            // foreach($files as $file) {
            for ($i = 0; $i < count($files['name']); $i++) {
                $temp = explode(".", $files["name"][$i]);
                $newfilename = date('H-i-s-') . rand() . '.' . end($temp);
                $link_img = "/uploads/image-story/" . $year . "/" . $month . "/" . $day . "/" . $newfilename;
                move_uploaded_file($files["tmp_name"][$i], "uploads/image-story/" . $year . "/" . $month . "/" . $day . "/" . $newfilename);

                return $link_img;
            }
        }
    }

    public function actionRemoveCart(){
        if(isset($_POST['id_cart'])){
            $id_cart = $_POST['id_cart'];
            $id_user = Yii::$app->user->identity->id;

            $session = Yii::$app->session;
            $list_course_cart = $session->get('info_course_cart');
            unset($_SESSION['info_course_cart'][$id_cart]);
            if(!empty($list_course_cart)){
                $list_course_cart = $session->get('info_course_cart');
                $total_res = array_column($list_course_cart,'price');
                $sum_res = array_sum($total_res);
                $format_sum = number_format($sum_res,0,'','.');

                return $format_sum;
            }
        }
    }

    public function actionCheckCode(){
        if(isset($_POST['code'])){
            $result_code = GiftCode::find()->where(['code' => $_POST['code']])->asArray()->all();
            $session = Yii::$app->session;
            $data = [];
            $arr_res = [];
            $dis_count = 0;
            $price_giam = 0;
            $total_price_giam = 0;
            $status = 0;
            if(!empty($result_code)){
                $discount = 0;
                $price_final = 0;
                $price_total = 0;
                foreach($result_code as $item){
                        $current = strtotime('today');
                        $start = strtotime($item['date_start']);
                        $end = strtotime($item['date_end']);

                        $list_course_id = $item['course_id'];
                        $ex_list_course = array_filter(explode(';',$list_course_id));
                        $list_course_disc = [];
                     
                        foreach($ex_list_course as $id_course){
                            $list_course_disc[$id_course] = $id_course;
                        }
                        $data_cart = $session->get('info_course_cart'); //list đơn hàng
                        // var_dump($current);
                        // var_dump($start);
                        // var_dump($end);die;
                    
                        if($current >= $start && $current < $end){ //con han su dung
                            foreach($data_cart as $key => $val){ 
                                $price = $val['promotional_price'] > 0 ? $val['promotional_price'] : $val['price'];
                                if(!empty($list_course_disc)){
                                    if(isset($list_course_disc[$key])){//nếu khóa học có trong danh sách giảm giá và chưa áp dụng mã giảm giá
                                        if($item['type_price'] == 3){//1: Số tiền / 2: Phần trăm số tiền tối đa / 3: Phần trăm tổng đơn hàng
                                            $price_final = $price*((100 - $item['price'])/100);
                                            $price_total = $price_total + ($price*((100 - $item['price'])/100));
                                        }else if($item['type_price'] == 1 || $item['type_price'] == 2){
                                            $price_final =   ($price - $item['price']);
                                            $price_total =  $price_total + ($price - $item['price']);
                                        }
    
                                        $price_giam = $price - $price_final;
                                        $total_price_giam = $total_price_giam + $price_giam;
    
                                        //update lại sesson đơn hàng
                                        $data_cart[$key] = [
                                            'price'     => $val['price'],
                                            'promotional_price'     => $val['promotional_price'],
                                            'name'     => $val['name'],
                                            'avatar'     => 'avatar',
                                            'name_lecturer'     => $val['name_lecturer'],
                                            'number_price_dis'  => $price_giam,
                                            'price_new' => $price_final,
                                            'code' => $_POST['code'],
                                        ];
                                        $status = 1;//áp dụng thành công
                                    }else{
                                        $status = 2;//mã giảm giá không áp dụng cho khóa học này
                                        $price_final = $price_final + $price;
                                        $price_total = $price_total + $price;
                                    }
                                }else{ //áp dụng toàn bộ khóa học
                                    if($item['type_price'] == 3){//1: Số tiền / 2: Phần trăm số tiền tối đa / 3: Phần trăm tổng đơn hàng
                                        $price_final = $price*((100 - $item['price'])/100);
                                        $price_total = $price_total + ($price*((100 - $item['price'])/100));
                                    }else if($item['type_price'] == 1 || $item['type_price'] == 2){
                                        $price_final =   ($price - $item['price']);
                                        $price_total =  $price_total + ($price - $item['price']);
                                    }

                                    $price_giam = $price - $price_final;
                                    $total_price_giam = $total_price_giam + $price_giam;

                                    //update lại sesson đơn hàng
                                    $data_cart[$key] = [
                                        'price'     => $val['price'],
                                        'promotional_price'     => $val['promotional_price'],
                                        'name'     => $val['name'],
                                        'avatar'     => 'avatar',
                                        'name_lecturer'     => $val['name_lecturer'],
                                        'number_price_dis'  => $price_giam,
                                        'price_new' => $price_final,
                                        'code' => $_POST['code'],
                                    ];
                                    $status = 1;//áp dụng thành công
                                }
                            }
                           
                        }
                }
                $_SESSION['info_course_cart'] = $data_cart;
              

                $arr_res = [
                    'dis_count' => number_format($price_total,0,'','.'),
                    'price_giam' => number_format($total_price_giam,0,'','.'),
                    'status' => $status,
                ];
            }
            echo json_encode($arr_res);
            exit;
            
        }
    }
    public function actionPayment(){
        $user_id = Yii::$app->user->identity->id;
        $result_cart = OrderCart::find()
        ->select(['A.id','A.user_id','A.price','A.status','A.create_date','B.course_id','B.price AS price_product','B.price_discount'])
        ->from(OrderCart::tableName() . ' A')
        ->where(['A.user_id' => $user_id,'status' => 0])
        ->innerJoin(OrderCartProduct::tableName() . ' B','B.order_cart_id = A.id')
        ->asArray()
        ->all();
        
        //lấy list khóa học
        $list_course_id = array_column($result_cart, 'course_id');
     
        $result_course = Course::find()
        ->select(['A.id','A.name','A.avatar','A.create_date','A.category_id','A.description','A.total_lessons','A.total_duration','A.price','A.promotional_price','A.trailer','A.slug','B.name AS name_lecturer'])
        ->from(Course::tableName() . ' A')
        ->andWhere(['in','A.id',$list_course_id])
        ->andWhere(['A.status' => 1,'A.is_delete' => 0])
        ->innerJoin(Lecturer::tableName() . ' B', 'B.id = A.lecturer_id')
        ->asArray()
        ->all();
    
        $arr_course = [];
        foreach($result_course as $cour){
            $arr_course[$cour['id']] = $cour;
        }


        $session = Yii::$app->session;
        $list_course_cart = $session->get('info_course_cart');
     
        return $this->render('payment',[
            'arr_course'    => $arr_course,
            'result_cart'   => $result_cart,
            'list_course_cart'  => $list_course_cart,
        ]);
    }

    public function actionFinalPayment(){
        $user_id = Yii::$app->user->identity->id;
        $session = Yii::$app->session;
        $data_cart = $session->get('info_course_cart');
        $discount_cart = $session->get('discount_cart');
        $number_price_dis = $session->get('number_price_dis');
        $model_cart = [];
        $gift_code = null;
        if(!empty($data_cart)){
            foreach($data_cart as $key => $item){
                if(isset($item['code']))
                    $gift_code = $item['code'];

                $check_cart = OrderCart::find()
                ->from(OrderCart::tableName() . ' A')
                ->where(['A.user_id' => $user_id,'B.course_id' => $key,'status' => 1])
                ->innerJoin(OrderCartProduct::tableName() . ' B','B.order_cart_id = A.id')
                ->asArray()
                ->one();

                $affliate_id = 0;
                $cookies = Yii::$app->request->cookies;
                if ($cookies->has('aff'))
                    $affliate_id = $cookies['aff']->value;
           
                if(isset($item['price_new']))
                    $price_final = $item['price_new'];
                else if(!empty($item['promotional_price']))
                    $price_final = $item['promotional_price'];
                else
                    $price_final = $item['price'];
                if(empty($check_cart)){
                    $model_cart = new OrderCart();
                    $model_cart->user_id = $user_id;
                    $model_cart->create_date = date('Y-m-d H:i:s');
                    $model_cart->last_update = date('Y-m-d H:i:s');
                    $model_cart->type = 1;
                    $model_cart->price = $price_final;
                    $model_cart->status = 0;
                    $model_cart->note = null;
                    $model_cart->gift_code = $gift_code;
                    $model_cart->tranid_vnpay = null;
                    $model_cart->affliate_id = $affliate_id;
                    $model_cart->save(false);
        
                    $model_cart_product = new OrderCartProduct();
                    $model_cart_product->order_cart_id = $model_cart->id;
                    $model_cart_product->course_id = $key;
                    $model_cart_product->price = $price_final;
                    $model_cart_product->price_discount = 0;
                    $model_cart_product->save(false);
                }
                unset($session['info_course_cart']);
            }
        }else{
            return $this->goHome();
        }
       
        return $this->render('final_payment',[
            'data_cart'     => $data_cart,
            'number_price_dis' => !empty($number_price_dis) ? $number_price_dis : 0,
            'discount_cart'     => !empty($discount_cart) ? $discount_cart : 0,
            'model_cart'    => $model_cart,
        ]);
    }

    public function actionAddToCart(){
        $session = Yii::$app->session;
        if(isset($_POST['id_course'])){
            $user_id = Yii::$app->user->identity->id;
            $course_id = $_POST['id_course'];

            //query lấy thông tin khóa học
            $course = Course::find()
            ->select(['A.id','A.name','A.avatar','A.create_date','A.category_id','A.description','A.total_duration','A.price','A.promotional_price','A.slug','B.name AS name_lecturer'])
            ->from(Course::tableName() . ' A')
            ->where(['A.is_delete' => 0,'A.id' => $course_id])
            ->innerJoin(Lecturer::tableName() . ' B', 'B.id = A.lecturer_id')
            ->asArray()
            ->one();
            
            $check_cart = $session->get('info_course_cart');
           
            if(isset($check_cart[$course_id])){
                echo 2;die;
            }else{
                $_SESSION['info_course_cart'][$course['id']]['price'] = $course['price'];
                $_SESSION['info_course_cart'][$course['id']]['promotional_price'] = $course['promotional_price'];
                $_SESSION['info_course_cart'][$course['id']]['name'] = $course['name'];
                $_SESSION['info_course_cart'][$course['id']]['avatar'] = $course['avatar'];
                $_SESSION['info_course_cart'][$course['id']]['name_lecturer'] = $course['name_lecturer'];
                // $session->destroy();
                echo 1;die;
            }
          
        }
    }
    public function actionLikeCourse(){
        if(isset($_POST['course_id'])){
            $course_id = $_POST['course_id'];
            $user_id = Yii::$app->user->identity->id;

            $favotite = FavoriteCourse::find()
            ->where(['user_id' => $user_id,'course_id' => $course_id])
            ->all();
            if($favotite){
                $favotite = FavoriteCourse::findOne(['user_id' => $user_id,'course_id' => $course_id]);
                $favotite->delete();
                echo 2;
                exit;
            }else{
                $model_favorite = new FavoriteCourse();
                $model_favorite->user_id = $user_id;
                $model_favorite->course_id = $course_id;
                $model_favorite->save(false);
                echo 1;
                exit;
            }
       
        }
    }
    public function actionInfoUser(){
        if(Yii::$app->user->identity){
            $info_user = Yii::$app->user->identity;
        }else{
            return $this->goHome();
        }
        //các khóa học đã xem
        $user_course = UserCourse::find()
        ->select(['A.id','A.course_id','B.name','B.slug','B.total_lessons'])
        ->where(['user_id' => $info_user['id']])
        ->from(UserCourse::tableName() . ' A','A.course_id = B.id')
        ->innerJoin(Course::tableName() . ' B', 'B.id = A.course_id')
        ->asArray()
        ->all();
        $user_login = UserLogin::find()->where(['user_id' => Yii::$app->user->identity->id])->asArray()->all();
       
        $list_id_course_user = array_column($user_course,'course_id');
    
        //bài đã xem
        $lesson_active = CourseLessonActive::find()
        ->where(['user_id' => $info_user['id']])
        ->andWhere(['not in', 'lesson_id', 0])
        ->asArray()
        ->all();
       
        //tổng số bài học
        $total_lesson = CourseLesson::find()
        ->where(['in','course_id',$list_id_course_user])
        ->asArray()
        ->all();
      
        if(count($lesson_active) > 0)
            $phantramdaxem = (count($lesson_active)/count($total_lesson))*100;
        else
            $phantramdaxem = 0;

        //danh sách bài đã xem theo danh mục
        $result_lesson_active = CourseLessonActive::find()
        ->where(['in','course_id',$list_id_course_user])
        ->andWhere(['user_id' => $info_user['id']])
        ->andWhere(['not in', 'lesson_id', 0])
        ->asArray()
        ->all();
      
        return $this->render('info_user',[
            'info_user'     => $info_user,
            'user_course'   => $user_course,
            'lesson_active' => $lesson_active,
            'phantramdaxem' => $phantramdaxem,
            'total_lesson'  => $total_lesson,
            'user_login'    => $user_login,
        ]);
    }

    public function actionUpdateInfoUser(){
        if(isset($_POST)){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $model = Users::findOne(Yii::$app->user->identity->id);
            if(!empty($model)){
                $model->fullname = $_POST['name'];
                $model->email = $_POST['email'];
                $model->save(false);
                echo 1;
                exit;
            }
        }
    }
    public function actionSaveEmailOffer(){
        if(isset($_POST['email'])){
            $check_isset = UserRegisterEmail::findOne(['email' => $_POST['email']]);
            if(!$check_isset){
                $model = new UserRegisterEmail();
                $model->email = $_POST['email'];
                if($model->save(false));
                return 1;
            }else{
                return 2;
            }
        }
    }
    public function actionAbout(){
        $this->view->title = 'ABE Academy';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'ABE Academy là tên viết tắt tiếng Anh của Viện nghiên cứu phát triển kinh tế Châu Á - Thái Bình Dương trực thuộc tập đoàn IMCE Global'
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'image',
            'content' => 'https://elearning.abe.edu.vn/images/about/anh-1/ntt.jpg'
        ]);
        return $this->render('about');
    }
    public function actionPlan(){
        return $this->render('plan');
    }
    // public function beforeAction($action)
    // {
    //     $referrer = Yii::$app->request->referrer ? Yii::$app->request->referrer : null;
    //     if ( !Yii::$app->user->identity && $referrer && strpos($referrer,'login') === false && strpos($referrer,'signup') === false) {
    //         $url_access = Yii::$app->request->referrer;

    //         Yii::$app->session->set('url_access', $url_access);
    //     }
    //     return parent::beforeAction($action);
    // }
    
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$model->validate()) {
                foreach($model->getErrors() as $row){
                    return [
                        'status' => 0,
                        'message' => $row['0']
                    ];
                    break;
                }
            }
            $user = Users::findOne(['email' => $model->username]);
            if($user['date_banned'] != null){
                $date_curren = strtotime(date("Y/m/d H:i:s"));
                $time_banner = strtotime($user['date_banned']);
                if($time_banner > $date_curren)
                    return [
                        'status' => 0,
                        'message' => 'Tài khoản của bạn đang bị khóa'
                    ];

            }

            if( $model->login() ){
                $resultCheck = $this->checkLogin();
                if( $resultCheck ){
                    return [
                        'status' => 1,
                        'message' => "Success"
                    ];
                }else{
                    return [
                        'status' => 0,
                        'message' => 'Đăng nhập không thành công! </br> Nguyên Nhân: Vượt quá số lượng thiết bị cho phép'
                    ];
                }
            }
            else
                return [
                    'status' => 0,
                    'message' => 'Thông tin đăng nhập không chính xác'
                ];
        } else {
            $model->password = '';

            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }
    }

    private function checkLogin(){
        if (!Yii::$app->user->isGuest) {
            $user       = Yii::$app->user->identity;
            $maxLogin   = 3;//Yii::$app->params['max_login'];
            $totalLoginPlace = UserLogin::find()->where(['user_id'=>$user->id,'status'=>0])->count();
            $user_login = UserLogin::find()->where(['user_id'=>$user->id,'status'=>0])->asArray()->all();
            $list_ip = array_column($user_login,'ip_address');
            $ip_current = $_SERVER['REMOTE_ADDR'];
            $modelUser  = Users::findOne(['id'=>$user->id]);
            if(in_array($ip_current,$list_ip)){
                return true;
            }
            //Check total login place with config params
            if( $totalLoginPlace < $maxLogin ){
                // $browser        = get_browser(null, true);
                $ip_address     = $_SERVER['REMOTE_ADDR'];
                $user_agent     = $_SERVER['HTTP_USER_AGENT'];
                $os             = NULL;//$browser['platform'];
                $browser_name   = NULL;//$browser['browser'];
                $version        = NULL;//str_replace('.0','',$browser['version']);
                // if( $version == 0 || strpos($user_agent,'coc_coc_browser') !== false ){
                //     $dataUg     = explode(' ', $user_agent);
                //     foreach($dataUg as $r){
                //         if( strpos($r,'coc_coc_browser') !== false ){
                //             $version = str_replace('coc_coc_browser/','', $r);
                //             break;
                //         }
                //     }
                // }
                $device         = NULL;//$browser['device_type'] == 'Desktop' ? 'PC' : 'Mobile';
                $checkIpExits   = UserLogin::find()->where(['user_id'=>$user->id,'user_agent'=>$user_agent, 'ip_address' => $ip_address, 'is_revoke'=>0])->one();
                if( !$checkIpExits ){
                    $model      = new UserLogin;
                    $model->user_id     = $user->id;
                    $model->time_login  = date('Y-m-d H:i:s');
                    $model->os          = $os;
                    $model->browser     = $browser_name;
                    $model->version     = $version;
                    $model->user_agent  = $user_agent;
                    $model->device      = $device;
                    $model->ip_address  = $ip_address;
                    $model->token       = md5($user_agent . $ip_address . $user->id);
                    $model->save(false);
                    $totalLoginPlace++;

                    Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'tklgusf',
                        'value' => $model->token,
                        'expire' => time() + 86400 * 30,
                    ]));
                    if( $totalLoginPlace == $maxLogin ){
                        //Send email warning
    
                    }
                }else{
                    if( $modelUser->status == 1 ){
                        $modelUser->time_login  = date('Y-m-d H:i:s');
                        $modelUser->ip_address  = $ip_address;
                        $modelUser->status = 0;
                        $modelUser->save(false);
                    }
                }
                
                return true;
            }else{
                //Lock account
                $modelUser->status = 3;
                $modelUser->save(false);

                Yii::$app->user->logout();

                Yii::$app->session->setFlash('error', 'Bạn đã đăng nhập đối đa 3 thiết bị. Vui lòng đăng xuất ở thiết bị khác trước khi đăng nhập.');

                return false;
            }
        }
        
        return true;
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $user       = Yii::$app->user->identity;
        $modelUser  = Users::findOne(['id'=>$user->id]);
        $ip_current = $_SERVER['REMOTE_ADDR']; 
        // $browser        = get_browser(null, true);
        $os             = NULL;//$browser['platform'];
        $browser_name   = NULL;//$browser['browser'];
        $user_login = UserLogin::find()->where(['user_id'=>$modelUser->id,'status'=>0,'browser' => $browser_name, 'os' => $os])->asArray()->all();
        if(!empty($user_login)){
            foreach($user_login as $item){
                $model = UserLogin::findOne($item['id']);
                $model->delete();
            }
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    /*
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) ) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$model->validate()) {
                foreach($model->getErrors() as $row){
                    return [
                        'status' => 0,
                        'message' => $row['0']
                    ];
                    break;
                }
            }
            if($model->signup()){
                // Yii::$app
                // ->mail
                // ->compose()
                // ->setFrom(['support@elearning.abe.edu.vn' => 'ABE Academy'])
                // ->setTo($model->email)
                // ->setSubject('Đăng ký tài khoản thành công')
                // ->setHtmlBody('<p>Chúc mừng bạn đã đăng ký tài khoản thành công</p>')
                // ->send();
                return [
                    'status' => 1,
                    'message' => "Success"
                ];
            }
            else
                return [
                    'status' => 0,
                    'message' => 'Có lỗi xảy ra. Vui lòng thử lại'
                ];
        }

        return $this->renderAjax('signup', [
            'model' => $model,
        ]);
    }
    /*
     * Update user up.
     *
     * @return mixed
     */
    public function actionUpdatephone()
    {
        $models = new SignupForm();
        if(isset($_POST['phone'])){
            $model = Users::findOne(['id' => Yii::$app->user->identity->id]);
            $model_check = Users::findOne(['phone' => $_POST['phone']]);
            if(empty($model_check)){
                $model->phone = $_POST['phone'];
                $model->save(false);
                return 1;
            }else{
                return 2;
            }
       
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotPassword();
        if ($model->load(Yii::$app->request->post()) ) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$model->validate()) {
                foreach($model->getErrors() as $row){
                    return [
                        'status' => 0,
                        'message' => $row['0']
                    ];
                    break;
                }
            }
            if( $model->forgot() )
                return [
                    'status' => 1,
                    'message'=> 'Yêu cầu khôi phục mật khẩu thành công. Mật khẩu mới đã được gửi vào email của bạn'
                ];
            else
                return [
                    'status' => 0,
                    'message' => 'Có lỗi xảy ra. Vui lòng thử lại'
                ];          
        }
        return $this->renderAjax('forgot_password', [
            'model' => $model,
        ]);
        
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        if(empty($token) || !Yii::$app->user->isGuest){
            return $this->goHome();
        }
        if(isset($_POST['password']) && !empty($_POST['password'])){
            $model = Users::find()
            ->where(['verification_token' => $token]) 
            ->one();
            $pass = $_POST['password'];
            $model->password = md5(md5($pass));
            $model->save(false);
            return $this->goHome();
        }
        return $this->render('resetPassword', [
        ]);
    }

    public function actionMailResetpass(){
            $session = Yii::$app->session;
            if (!$session->has('check_sendmail') && isset($_POST['email'])){
                $email = $_POST['email'];
                $user = Users::findOne(['email' => $email]);
                if(!empty($user)){
                    $host = 'https://' . $_SERVER['HTTP_HOST'];
                    $verification_token = $user['verification_token'];
                    Yii::$app
                        ->mail
                        ->compose()
                        ->setFrom(['support@elearning.abe.edu.vn' => 'ABE Academy'])
                        ->setTo($email)
                        ->setSubject('Reset Mật khẩu')
                        ->setHtmlBody('<div style="padding:15px 20px;border: 1px solid #707070;margin: 0px auto;max-width: 800px;font-size: 16px;font-family: roboto;text-align:left">
                                            <div style="background-color: #191c21;text-align: left;"><img style="width: 150px;" src="https://elearning.abe.edu.vn/images/page/logo.svg" alt=""></div>
                                            <h1 style="font-size:24px;margin-bottom:10px">THAY ĐỔI MẬT KHẨU</h1>
                                            <h4>Xin chào bạn</h4>
                                            <p style="margin-bottom:10px">Bạn đã yêu cầu phục hồi lại mật khẩu trên website <a href="http://elearning.abe.edu.vn/">elearning.abe.edu.vn</a>. Nếu bạn không có yêu cầu hoặc có sự nhầm lẫn nào thì bạn có thể bỏ qua email này.</p>
                                            <p style="margin-bottom:10px">Bấm vào nút bên dưới để xác nhận và nhập mật khẩu mới</p>
                                            <a style="margin-bottom:10px;margin-bottom: 10px;background: red;color: #fff;padding: 10px;display: inline-block;border-radius: 5px;text-transform: uppercase;" href="'. $host .'/khoi-phuc-mat-khau?token='. $verification_token .'">Đặt lại mật khẩu</a>
                                            <p style="font-weight:bold">ABE Academy</p>
                                        </div>')
                        ->send();
    
                        $session->set('check_sendmail', '1');
                        echo 1;die;
                }else{
                    echo 3;die;
                }
            }else{
                echo 2;die;
            }         
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        $model     = Users::findOne(['verification_token'=>$token]);
        if( $model ){
            $model->is_verify_account = 1;
            $model->verification_token= '';
            $model->date_verify_email = date('Y-m-d H:i:s');
            $model->save(false);

            Yii::$app->session->setFlash('success', 'Xác thực tài khoản thành công');
        }
        
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    public function actionRegisterfree(){
        if (!Yii::$app->user->isGuest) {
            $this->redirect('/product/index');
        }else{
            $this->redirect('/site/signup');
        }
    }

    public function actionTerms(){
        return $this->render('terms',[
        ]);
    }

    public function actionPrivacyPolicy(){
        return $this->render('privacy_policy');
    }
    public function actionRefund(){
        return $this->render('refund');
    }
    /**
    * Function xử lý push log lượt xem bài viết, chuyên mục
    */
    public function actionTracking(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if( $request->isPost ){
            $params_post = $request->post();
            $params      = $this->validateParamsLog($params_post);
            if( is_array($params) ){
                $params_push_queue = [
                    'id'            => (int)$params['tracking_id'],
                    'type'          => (int)$params['tracking_type'],
                    'date'          => date('Y-m-d H:i:s'),
                    'session_id'    => $params['session'],
                    'user_agent'    => $params['user_agent'],
                    'ip_address'    => $params['ip_address'],
                    'url'           => $params['url'],
                    'user_id'       => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : 0
                ];
                
                Yii::$app->queue->push(new \backend\components\ProcessLogView($params_push_queue));
            }
        }
        exit();
    }

    private function validateParamsLog($arrData){
        $ip_address        = \backend\controllers\CommonController::getAgentIp();
        $ipBlackList       = Yii::$app->params['ip_blacklist'];
        if( !in_array($_SERVER['REMOTE_ADDR'], $ipBlackList) && Yii::$app->getRequest()->validateCsrfToken() && isset($arrData['url']) && !empty($arrData['url']) && isset($arrData['data']) && !empty($arrData['data']) ){
            $str_params = \backend\controllers\CommonController::encryptDecrypt($arrData['data'], 'decrypt');
            if( strpos($str_params, '#_#') !== false ){
                $arrParams = explode('#_#', $str_params);
                $params    = ['url' => $arrData['url'], 'ip_address' => $ip_address];
                $time_expire = 0;
                if( count($arrParams) >= 6 ){
                    foreach($arrParams as $key=>$value){
                        switch($key){
                            case 0:
                                $params['session'] = $value;
                                break;
                            case 1:
                                $params['tracking_id'] = (int)$value;
                                break;
                            case 2:
                                $params['tracking_type'] = (int)$value;
                                break;
                            case 3:
                                if( !empty($value) && $value != 'NA' )
                                    $params['cate_id'] = $value;
                                break;
                            case 4:
                                $params['user_agent'] = $value;
                                break;
                            case 5:
                                $time_expire = (int)$value;
                                break;
                        }
                    }
                }
                $session_check = Yii::$app->session->getId();
                $time_current  = time();
                $listTypeValid = [ProcessLogView::TYPE_NEWS, ProcessLogView::TYPE_COURSE];
                $user_agent_check = $_SERVER['HTTP_USER_AGENT'];
                
                if( $time_expire >= $time_current && isset($params['tracking_id']) && !empty($params['tracking_id']) && isset($params['tracking_type']) && in_array($params['tracking_type'], $listTypeValid) && isset($params['user_agent']) && $params['user_agent'] == $user_agent_check && isset($params['session']) && $params['session'] == $session_check ){
                    return $params;
                }
            }
        }
        return false;
    }
}
