<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\CourseOffline;
use frontend\models\Contact;

use backend\models\Course;
use backend\models\Lecturer;
use backend\models\FrequentlyQuestions;
use backend\models\CourseLesson;
use backend\models\CourseLessonActive;
use backend\models\CourseLessonQuestion;
use backend\models\CourseLessonAnswer;
use backend\models\CourseLessonResultCheck;
use backend\models\CourseLessonNote;
use backend\models\UserCourse;
use backend\models\Category;
use backend\models\ContinueLesson;
use backend\models\Province;
use backend\models\District;
use backend\models\DiplomaAddress;
use backend\models\FrequentlyQuestionsGroup;
use backend\models\FavoriteCourse;

/**
 * Course controller
 */
class CourseController extends Controller
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
    /**
     * Trang chi tiết khóa học
     */
    public function actionIndex($slug_detail = null)
    {
        //query data khóa học
        $course_info = Course::find()
        ->select(['A.id','A.name','A.total_lessons','A.study_guide','A.category_id','A.document','A.total_duration','A.trailer','A.slug','A.avatar','A.description','A.price','A.promotional_price','B.name AS lecturer_name','B.level AS lecturer_level','B.avatar AS avatar_lecturer'])
        ->where(['A.is_delete' => 0,'A.slug' => $slug_detail])
        ->from(Course::tableName() . ' A')
        ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
        ->asArray()
        ->one();
     
        $this->view->title = 'Chi tiết khóa học ' . $course_info['name'];

        $des_seo = $course_info['description'];
        if(!empty($des_seo)){
             if (strlen($des_seo) > 255)
                  $des_seo = substr($des_seo, 0, 252) . '...';
        }else{
             $des_seo = '';
        }

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $des_seo,
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => 'https://elearning.abe.edu.vn/' . $course_info['avatar']
        ]);
       Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
        ]);
       
        $this->view->params['log'] = [
            'enable'        => true,
            'type'          => \backend\components\ProcessLogView::TYPE_COURSE,
            'id'            => $course_info['id']
        ];
        $study_guide = [];
        $document = [];
        if(!empty($course_info['study_guide']))
            $study_guide = json_decode($course_info['study_guide'],true);
     
        if(!empty($course_info['document']))
            $document = json_decode($course_info['document']);
        $name_cat = '';
        if($course_info['category_id']){
            $exp_cat = array_filter(explode(';',$course_info['category_id']));
            $category_course = Category::find()
            ->where(['in','id',$exp_cat])
            ->asArray()
            ->all();

            if(!empty($category_course)) {
                foreach($category_course as $item) {
                    $name_cat .= ', ' . $item['name'] . ' ';
                }
                $name_cat		= substr( $name_cat , 1 );
            }
        }
        $list_all_lesson = CourseLesson::find()
        ->select(['name','description'])
        ->where(['course_id' => $course_info['id']])
        ->asArray()
        ->all();
     
        $view = 'course';

        $course_lesson = [];
        $list_total_lesson_user = [];
        $val_count_ques = [];
        $check_quiz = [];
        $arr_continue = [];
        $check_bt_end = false;
        $check_user_course = [];
        if(Yii::$app->user->identity){
            $id_user = Yii::$app->user->identity->id;
            $user_course = UserCourse::find()->where(['user_id' => $id_user,'course_id' => $course_info['id']])->all();
            if(!empty($user_course) || $course_info['price'] == 0){
                $view = 'course_user';
                // là bài học đầu tiên thì active 
                $lesson     = CourseLesson::find()->where(['course_id' => $course_info['id']])->orderBy(['sort'=>SORT_ASC])->one();
          
                if( $lesson ){
                    $checkExists  = CourseLessonActive::findOne(['lesson_id' => $lesson->id, 'user_id' => $id_user]);
                    if( !$checkExists ){
                        $lessonActive = new CourseLessonActive;
                        $lessonActive->lesson_id = $lesson->id;
                        $lessonActive->course_id = $course_info['id'];
                        $lessonActive->user_id   = $id_user;
                        $lessonActive->status    = 1;
                        $lessonActive->create_date  = date('Y-m-d H:i:s');
                        $lessonActive->save(false);
                    }
                }
                //lấy bài học user xem dở
                $continue_lesson = ContinueLesson::find()->select(['lesson_id','time'])->where(['user_id' => $id_user,'is_end' => 0])->asArray()->all();
                foreach($continue_lesson as $cont){
                    $arr_continue[$cont['lesson_id']] = $cont['time'];
                }
             
                //bài học đã active của user
                $course_lesson_active = CourseLesson::find()
                ->select(['A.id','A.name','A.avatar','A.duration','A.link_video','A.course_id','A.description','A.total_answer_correct_need','A.path_file','B.status'])
                ->from(CourseLesson::tableName() . ' A')
                ->innerJoin(CourseLessonActive::tableName() . ' B', 'A.id = B.lesson_id')
                ->where(['A.course_id' => $course_info['id'],'B.status' => 1, 'user_id' => $id_user])
                ->orderBy(['id' => SORT_ASC])
                ->asArray()->all();
                
                $list_lesson_active = [];
                if(!empty($course_lesson_active)){
                    foreach($course_lesson_active as $item){
                        $list_lesson_active[] = $item['id'];
                    }
                }
    
                //query bài học 
                $course_lesson_all = CourseLesson::find()
                ->andWhere(['course_id' => $course_info['id']])
                ->andWhere(['not in','id',$list_lesson_active])
                ->asArray()
                ->orderBy(['id' => SORT_ASC])
                ->all();
              
         
                $list_total_lesson_user = array_merge($course_lesson_all,$course_lesson_active);
            
                $list_sort_lesson = array();
                foreach ($list_total_lesson_user as $key => $row)
                {
                    $list_sort_lesson[$key] = $row['id'];
                }
             
                array_multisort($list_sort_lesson, SORT_ASC, $list_total_lesson_user);
              
                $list_id_less = array_column($list_total_lesson_user,'id');
                
                //query lưu kết quả kiểm tra theo bài học của user
                $result_check = CourseLessonResultCheck::find()
                ->select(['total_answer','total_answer_correct','lesson_id'])
                ->where(['in','lesson_id',$list_id_less])
                ->andWhere(['user_id' => $id_user])
                ->asArray()
                ->all();

                if(count($list_total_lesson_user ) == count($result_check ))
                    $check_bt_end = true;
                if($result_check){
                    foreach($result_check as $check){
                        $check_quiz[$check['lesson_id']] = [
                            'total_answer'  => $check['total_answer'],
                            'total_answer_correct'  => $check['total_answer_correct'],
                        ];
                    }
                }
                //query lấy tổng câu hỏi của bài học
                $total_question = CourseLessonQuestion::find()
                ->where(['status' => 1,'is_delete' => 0])
                ->andWhere(['in','lesson_id',$list_id_less])
                ->groupBy(['id', 'lesson_id'])
                ->asArray()
                ->all();
                $arr_column = array_column($total_question,'lesson_id');
                $val_count_ques = array_count_values($arr_column);
            }else{
                //chưa mua redirect về trang tổng quan khóa học
                $this->redirect(['/course/course-overview','slug_course' => $slug_detail]);
            }
            //check bai hoc cuoi cua user
            // $result_check_end = CourseLessonResultCheck::find()
            // ->where(['user_id' => $id_user, 'lesson_id' => 0, 'course_id' => $course_info['id']])
            // ->asArray()
            // ->one();
            //check user đã hoàn thành bài học cuối chưa
            $check_user_course = CourseLessonResultCheck::find()
            ->select(['A.id','A.create_date','A.user_id','A.course_id','A.total_answer_correct','A.total_answer','B.certificate'])
            ->from(CourseLessonResultCheck::tableName() . ' A')
            ->where(['A.lesson_id' => 0,'A.course_id' => $course_info['id'],'A.user_id' => Yii::$app->user->identity->id])
            ->innerJoin(Course::tableName() . ' B', 'A.course_id = B.id')
            ->asArray()
            ->all();
        }
      
        //các khóa học khác
        $course_id_first = explode(';', $course_info['category_id']);
        $course_info_kh = Course::find()->select(['A.id','A.category_id','A.total_duration','A.name','A.slug','A.avatar','A.description','A.price','B.name AS lecturer_name'])
        ->where(['A.status' => 1,'A.is_delete' => 0])
        ->andWhere(['not in','A.id', [$course_info['id']]])
        ->andWhere(['like','A.category_id', ';'. $course_id_first[1] .';'])
        ->from(Course::tableName() . ' A')
        ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
        ->asArray()
        ->all();
       
     
        //node bài học
        $result_note = CourseLessonNote::find()
        ->where(['user_id' => Yii::$app->user->identity])
        ->asArray()
        ->all();
        $list_node = [];
        foreach($result_note as $item){
            $list_node[$item['lesson_id']] = $item['note'];
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
    
        return $this->render($view,[
            'course_info'       => $course_info,
            'course_info_kh'    => $course_info_kh,
            'arr_ques'          => $arr_ques,
            'list_total_lesson_user'     => $list_total_lesson_user,
            'list_node'         => $list_node,
            'val_count_ques'    => $val_count_ques,
            'name_cat'          => $name_cat,
            'list_all_lesson'   => $list_all_lesson,
            'document'          => $document,
            'check_quiz'        => $check_quiz,
            'arr_continue'      => $arr_continue,
            'study_guide'       => $study_guide,
            // 'result_check_end'  => isset($result_check_end) ? $result_check_end : [],
            'check_bt_end'      => $check_bt_end,
            'check_user_course' => $check_user_course,
        ]);       
    }
    //trang tổng quan khóa học  
    public function actionCourseOverview($slug_course){
        $isset_check = false;
        //thông tin lớp học
        $info_course = Course::find()
        ->select(['A.id','A.name','A.avatar','A.study_guide','A.create_date','A.category_id','A.description','A.total_lessons','A.total_duration','A.price','A.promotional_price','A.trailer','A.slug','B.name AS name_lecturer'])
        ->from(Course::tableName() . ' A')
        ->where(['A.slug' => $slug_course,'A.is_delete' => 0])
        ->innerJoin(Lecturer::tableName() . ' B', 'B.id = A.lecturer_id')
        ->asArray()
        ->one();
        $this->view->title = 'Tổng quan lớp học ' . $info_course['name'];
        Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => $info_course['avatar']
        ]);
       Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
        ]);
      
        //list bài học của lớp học
        $data_lesson = CourseLesson::find()
        ->where(['course_id' => $info_course['id']])
        ->asArray()
        ->all();
        $redirect_detail_course = ['/course/index','slug_detail' => $info_course['slug']];
        if(isset($_GET['aff']))
            $redirect_detail_course = ['/course/index','slug_detail' => $info_course['slug'], 'aff' => $_GET['aff']];
        $favotite = [];
        if(!Yii::$app->user->isGuest){
            $user_id = Yii::$app->user->identity->id;
            //kiểm tra user đã mua khóa học chưa
            $user_course = UserCourse::find()->where(['course_id' => $info_course['id'],'user_id' => $user_id])->asArray()->one();
            $isset_check = ($user_course || $info_course['price'] == 0) ? true : false;
            //query khóa học yêu thích
            $favotite = FavoriteCourse::findOne(['user_id' => $user_id,'course_id' => $info_course['id']]);
        }else{
            return $this->redirect($redirect_detail_course);
        }


        return $this->render('course_overview',[
            'info_course'       => $info_course,
            'data_lesson'       => $data_lesson,
            'isset_check'       => $isset_check,
            'favotite'          => $favotite,
        ]);
    }

    //function lấy câu hỏi, câu trả lời cho bài học
    public function actionGetQuestionAnswer(){
        $item_doc = '';
        //bt khóa học
        if(isset($_POST['course_id']) && !isset($_POST['id_lesson'])){
            $course_id = $_POST['course_id'];
            $check_user_course = CourseLessonResultCheck::findOne(['lesson_id' => 0,'course_id' => $course_id,'user_id' => Yii::$app->user->identity->id]);
            if(!empty($check_user_course)){
                return 1;
            }
            $course = Course::findOne(['id' => $course_id]);
            // Tổng số câu hỏi cần làm ở bài tập lớn
            $total_todo_question = $course['total_todo_question'];
            // Số câu hỏi lấy ở mỗi học để tạo thành bài tập lớn. Ví dụ trường này có giá trị là 5 và khoá học này có 4 bài học thì lấy 5x4 = 20 -> Lấy được 20 câu hỏi cho bài tập lớn
            $questions_per_lesson = $course['questions_per_lesson'];

            //lấy list bài học của khóa học
            $lesson = CourseLesson::find()
            ->where(['course_id' => $course_id])
            ->asArray()
            ->all();
            $result_question_lesson = [];
            foreach($lesson as $less){
                //ramdom số câu hỏi lấy ở bài học để tạo thành bài tập lớn
                $result_question_lesson[] = CourseLessonQuestion::find()
                ->where(['lesson_id' => $less['id'],'status' => 1,'is_delete' => 0,'type' => 1])
                ->asArray()
                ->limit($questions_per_lesson)
                ->orderBy(['rand()' => SORT_DESC])
                ->all();
            }
            $arr_question_lesson_new = [];
            if(!empty($result_question_lesson)){
                foreach($result_question_lesson as $item){
                    $arr_question_lesson_new = array_merge($arr_question_lesson_new, $item);
                }
            }
         
            $limit_question_course = $total_todo_question - count($arr_question_lesson_new);
            //question của khóa học
            $result_question_course = CourseLessonQuestion::find()
            ->where(['course_id' => $course_id,'status' => 1,'is_delete' => 0,'type' => 2])
            ->asArray()
            ->limit($limit_question_course)
            ->all();
            $result_question = array_merge($result_question_course, $arr_question_lesson_new);
            // echo '<pre>';
            // print_r($result_question);
            // echo '</pre>';
            // die;
            $arr_lesson = [];
            if(!empty($result_question)){
                foreach($result_question as $item){
                    $arr_lesson[$item['id']] = [
                        'question_name' => $item['question_name'],
                        'course_id' => $item['course_id'],
                        'lesson_id' => $item['lesson_id'],
                        'answer' => CourseLessonAnswer::find()
                        ->where(['question_id' => $item['id'],'is_delete' => 0])
                        ->asArray()
                        ->all(),
                    ];
                }
            }

            $str_ques = '';
            $list_ques_ans = '';
            $i = 0;
            foreach($arr_lesson as $key => $val){
                $item_ans = '';
                $i++;
                if($i > 1)
                    $none = ' d-none';
                else
                    $none = '';

                $str_ques = '<div class="question_exr">
                                <span class="fz-20 font-weight-bold text-white">'. $val['question_name'] .'</span>
                            </div>';
                foreach($val['answer'] as $ans){
                    $item_ans .= '<div class="item_answer">
                                    <p>'. $ans['answer_name'] .'</p>
                                    <div class="position-relative">
                                        <input type="radio" name="'.$key.'" class="radio_answer answer_'.$key.'" value="'. $ans['position'] .'">
                                        <i></i>
                                    </div>
                                </div>';
                }
                $str_ans = '<div class="answer_exr">
                                '. $item_ans .'
                            </div>';

                $submit_qa = '<button type="button" class="btn_exr btn_next_qa" id-less="'. $key .'">Tiếp tục <i class="fas fa-arrow-right ml-2"></i></button>';
                $list_ques_ans .= '<div class="step_kt group_qa_'. $i . $none .'">' . $str_ques . $str_ans . $submit_qa . '</div>';
            }
            $total_exr = '<span class="curent_page">1</span>/' . '<span class="sp_total_page">'.$i.'</span>';
        
            $modal_bt = '<div class="bt_lesson">
                            <button type="button" class="btn btn-primary btn_show_exr" data-toggle="modal" data-target="#modal_exrcise">
                                Làm bài tập <i class="fas fa-arrow-right"></i>
                            </button>
                            <div class="modal fade" id="modal_exrcise" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal_content_exercise">
                                        <div class="modal-body body_exr">
                                                <form id="form_qa" class="group_step" action="">
                                                    '. $list_ques_ans .'
                                                    <div class="submit_exr">
                                                        
                                                        <span class="total_exr">'. $total_exr .'</span>
                                                    </div>
                                                </form>
                                        </div>
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-default exit_exr" data-dismiss="modal"><i class="far fa-times-circle fz-30 text-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
        $data['modal_bt'] = $modal_bt;
        $data['item_doc'] = $item_doc;
        echo json_encode($data);
        exit;
    }

    //function lấy câu hỏi, câu trả lời cho lớp học
    public function actionGetQuestionAnswerLesson(){
        $session = Yii::$app->session;
        $data_qa_false = $session->get('data_qa_false');
        $item_doc = '';
        $modal_bt = '';
      
        //bt bài học
        if(isset($_POST['id_lesson']) || !empty($data_qa_false)){
            // echo 222;die;
            if(!empty($data_qa_false)){
                $id_lesson = $data_qa_false['lesson_id'];
                $course_id = $data_qa_false['course_id'];
            }else{
                $id_lesson = $_POST['id_lesson'];
                $course_id = $_POST['course_id'];
            }
            $user_id = Yii::$app->user->identity->id;
    
            //lấy tài liệu đọc thêm
            $lesson_curren = CourseLesson::find()
            ->select(['id','name','course_id','path_file','document'])
            ->where(['course_id' => $course_id,'id' => $id_lesson])
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->one();
            
            if(!empty($lesson_curren['document'])){
                $doc = json_decode($lesson_curren['document'],true);
                foreach($doc as $val){
                    $item_doc .= '<div class="item_doc">
                                        <a href="'. $val['link'] .'" class="position-relative" target="_blank">
                                            <img class="w-100" src="https://elearning.abe.edu.vn/'. $val['img'] .'" alt="">
                                            <div class="text_doc">
                                                <p>'. $val['name'] .'</p>
                                            </div>
                                        </a>
                                    </div>';
                }
            }

            //check nếu đã hoàn thành khóa học
            if(!Yii::$app->user->isGuest){
                $course_check = CourseLessonActive::find()
                ->where(['course_id' => $course_id,'lesson_id' => 0,'user_id' => $user_id])
                ->all();
                $lesson_check = CourseLessonResultCheck::find()
                ->where(['lesson_id' => $id_lesson,'user_id' => $user_id])
                ->all();
             
                if(!empty($course_check) || !empty($lesson_check)){
                    return;
                }   
            }

            //bài học tiếp theo
            $lesson_final = CourseLesson::find()
            ->select(['id','name','course_id','path_file','link_video'])
            ->where(['course_id' => $course_id])
            ->andWhere(['>','id',$id_lesson])
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->one();
            
            if(!empty($lesson_final)){
                $active_check = CourseLessonActive::find()
                ->where(['user_id' => $user_id,'lesson_id' => $lesson_final['id']])
                ->asArray()
                ->one();
                
                if(empty($active_check)){
                    //bài kiểm tra của bài học
                    $result_question = CourseLessonQuestion::find()
                    ->where(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                    ->asArray()
                    ->all();
                    //nếu không có câu hỏi next bài tiếp theo
                    if(empty($result_question)){
                        
                        $model_active = new CourseLessonActive();
                        $model_active->lesson_id    = $lesson_final['id'];
                        $model_active->course_id    = $lesson_final['course_id'];
                        $model_active->user_id      = Yii::$app->user->identity->id;
                        $model_active->status       = 1;
                        $model_active->create_date  = date('Y-m-d H:i:s');
                        $model_active->save(false);
                        
                        $res['next'] = $lesson_final['id'];
                        $res['link_video'] = $lesson_final['link_video'];
                        echo json_encode($res);
                        exit;
                    }
                }else{
                    return;
                }
            }else{
                $result_question = CourseLessonQuestion::find()
                ->where(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                ->asArray()
                ->all();
            }

            
            if(!empty($data_qa_false)){
                //các câu hỏi trả lời sai
                $result_question = CourseLessonQuestion::find()
                ->andwhere(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                ->andwhere(['in','id',$data_qa_false['list_id']])
                ->asArray()
                ->all();
            }else{
                $result_question = CourseLessonQuestion::find()
                ->where(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                ->asArray()
                ->all();
            }
            $arr_lesson = [];
            if(!empty($result_question)){
                foreach($result_question as $item){
                    $arr_lesson[$item['id']] = [
                        'question_name' => $item['question_name'],
                        'course_id' => $item['course_id'],
                        'lesson_id' => $item['lesson_id'],
                        'answer' => CourseLessonAnswer::find()
                        ->where(['question_id' => $item['id'],'is_delete' => 0])
                        ->asArray()
                        ->all(),
                    ];
                }
            }

            $str_ques = '';
            $list_ques_ans = '';
            $i = 0;
            foreach($arr_lesson as $key => $val){
                $item_ans = '';
                $i++;
                if($i > 1)
                    $none = ' d-none';
                else
                    $none = '';

                $str_ques = '<div class="question_exr">
                                <span class="fz-20 font-weight-bold text-white">'. $val['question_name'] .'</span>
                            </div>';
                foreach($val['answer'] as $ans){
                    $item_ans .= '<div class="item_answer">
                                    <p>'. $ans['answer_name'] .'</p>
                                    <div class="position-relative">
                                        <input type="radio" name="'.$key.'" position="'. $i .'" class="radio_answer answer_'.$key.'" value="'. $ans['position'] .'">
                                        <i></i>
                                    </div>
                                </div>';
                }
                $str_ans = '<div class="answer_exr">
                                '. $item_ans .'
                            </div>';

                $submit_qa = '<button type="button" class="btn_exr btn_next_qa_lesson" id-less="'. $key .'">Tiếp tục <i class="fas fa-arrow-right ml-2"></i></button>';
                $list_ques_ans .= '<div class="step_kt group_qa_'. $i . $none .'">' . $str_ques . $str_ans . $submit_qa . '</div>';
            }
            $total_exr = '<span class="curent_page">1</span>/' . '<span class="sp_total_page">'.$i.'</span>';
        
            $modal_bt = '<div class="bt_lesson">
                            <button type="button" class="btn btn-primary btn_show_exr" data-toggle="modal" data-target="#modal_exrcise">
                                Làm bài tập <i class="fas fa-arrow-right"></i>
                            </button>
                            <div class="modal fade" id="modal_exrcise" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal_content_exercise">
                                        <div class="modal-body body_exr">
                                                <form id="form_qa" class="group_step" action="">
                                                    '. $list_ques_ans .'
                                                    <div class="submit_exr">
                                                        
                                                        <span class="total_exr">'. $total_exr .'</span>
                                                    </div>
                                                </form>
                                        </div>
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-default exit_exr" data-dismiss="modal"><i class="far fa-times-circle fz-30 text-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
    
        $data['modal_bt'] = $modal_bt;
        $data['item_doc'] = $item_doc;
        echo json_encode($data);
        exit;
    }
    //function lấy câu hỏi, câu trả lời cho bài học chưa hoàn thành bài tập
    public function actionGetQuestionAnswerLessonNext(){
        $session = Yii::$app->session;
        $data_qa_false = $session->get('data_qa_false');
        $item_doc = '';
        //bt bài học
        if(isset($_POST['course_id']) || !empty($data_qa_false)){
            $user_id = Yii::$app->user->identity->id;
            //lấy bài học chưa làm bài tập gần nhất
            $lesson_exercise = CourseLessonActive::find()
                ->where(['course_id' => $_POST['course_id'],'user_id' => $user_id])
                ->orderBy(['lesson_id' => SORT_DESC])
                ->one();


            if(!empty($data_qa_false)){
                $id_lesson = $data_qa_false['lesson_id'];
                $course_id = $data_qa_false['course_id'];
            }else{
                $id_lesson = $lesson_exercise['lesson_id'];
                $course_id = $_POST['course_id'];
            }
     
            //check nếu đã hoàn thành khóa học
            if(!Yii::$app->user->isGuest){
                $course_check = CourseLessonActive::find()
                ->where(['course_id' => $course_id,'lesson_id' => 0,'user_id' => $user_id])
                ->all();
                $lesson_check = CourseLessonResultCheck::find()
                ->where(['lesson_id' => $id_lesson,'user_id' => $user_id])
                ->all();
             
                if(!empty($course_check) || !empty($lesson_check)){
                    return;
                }   
            }

            //bài học tiếp theo
            $lesson_final = CourseLesson::find()
            ->select(['id','name','course_id','path_file','link_video'])
            ->where(['course_id' => $course_id])
            ->andWhere(['>','id',$id_lesson])
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->one();
            
            if(!empty($lesson_final)){
                $active_check = CourseLessonActive::find()
                ->where(['user_id' => $user_id,'lesson_id' => $lesson_final['id']])
                ->asArray()
                ->one();
                
                if(empty($active_check)){
                    //bài kiểm tra của bài học
                    $result_question = CourseLessonQuestion::find()
                    ->where(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                    ->asArray()
                    ->all();
                    //nếu không có câu hỏi next bài tiếp theo
                    if(empty($result_question)){
                        
                        $model_active = new CourseLessonActive();
                        $model_active->lesson_id    = $lesson_final['id'];
                        $model_active->course_id    = $lesson_final['course_id'];
                        $model_active->user_id      = Yii::$app->user->identity->id;
                        $model_active->status       = 1;
                        $model_active->create_date  = date('Y-m-d H:i:s');
                        $model_active->save(false);
                        
                        $res['next'] = $lesson_final['id'];
                        $res['link_video'] = $lesson_final['link_video'];
                        echo json_encode($res);
                        exit;
                    }
                }else{
                    return;
                }
            }else{
                $result_question = CourseLessonQuestion::find()
                ->where(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                ->asArray()
                ->all();
            }

            
            if(!empty($data_qa_false)){
                //các câu hỏi trả lời sai
                $result_question = CourseLessonQuestion::find()
                ->andwhere(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                ->andwhere(['in','id',$data_qa_false['list_id']])
                ->asArray()
                ->all();
            }else{
                $result_question = CourseLessonQuestion::find()
                ->where(['lesson_id' => $id_lesson,'status' => 1,'is_delete' => 0,'type' => 1])
                ->asArray()
                ->all();
            }
            $arr_lesson = [];
            if(!empty($result_question)){
                foreach($result_question as $item){
                    $arr_lesson[$item['id']] = [
                        'question_name' => $item['question_name'],
                        'course_id' => $item['course_id'],
                        'lesson_id' => $item['lesson_id'],
                        'answer' => CourseLessonAnswer::find()
                        ->where(['question_id' => $item['id'],'is_delete' => 0])
                        ->asArray()
                        ->all(),
                    ];
                }
            }

            $str_ques = '';
            $list_ques_ans = '';
            $i = 0;
            foreach($arr_lesson as $key => $val){
                $item_ans = '';
                $i++;
                if($i > 1)
                    $none = ' d-none';
                else
                    $none = '';

                $str_ques = '<div class="question_exr">
                                <span class="fz-20 font-weight-bold text-white">'. $val['question_name'] .'</span>
                            </div>';
                foreach($val['answer'] as $ans){
                    $item_ans .= '<div class="item_answer">
                                    <p>'. $ans['answer_name'] .'</p>
                                    <div class="position-relative">
                                        <input type="radio" name="'.$key.'" position="'. $i .'" class="radio_answer answer_'.$key.'" value="'. $ans['position'] .'">
                                        <i></i>
                                    </div>
                                </div>';
                }
                $str_ans = '<div class="answer_exr">
                                '. $item_ans .'
                            </div>';

                $submit_qa = '<button type="button" class="btn_exr btn_next_qa_lesson" id-less="'. $key .'">Tiếp tục <i class="fas fa-arrow-right ml-2"></i></button>';
                $list_ques_ans .= '<div class="step_kt group_qa_'. $i . $none .'">' . $str_ques . $str_ans . $submit_qa . '</div>';
            }
            $total_exr = '<span class="curent_page">1</span>/' . '<span class="sp_total_page">'.$i.'</span>';
        
            $modal_bt = '<div class="bt_lesson">
                            <button type="button" class="btn btn-primary btn_show_exr" data-toggle="modal" data-target="#modal_exrcise">
                                Làm bài tập <i class="fas fa-arrow-right"></i>
                            </button>
                            <div class="modal fade" id="modal_exrcise" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal_content_exercise">
                                        <div class="modal-body body_exr">
                                                <form id="form_qa" class="group_step" action="">
                                                    '. $list_ques_ans .'
                                                    <div class="submit_exr">
                                                        
                                                        <span class="total_exr">'. $total_exr .'</span>
                                                    </div>
                                                </form>
                                        </div>
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-default exit_exr" data-dismiss="modal"><i class="far fa-times-circle fz-30 text-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
    
        $data['modal_bt'] = $modal_bt;
        echo json_encode($data);
        exit;
    }

    //function kiểm tra câu trả lời của khóa học
    public function actionCheckResultQa(){
        if(isset($_POST['data'])){
            $user_id = Yii::$app->user->identity->id;
            $data = $_POST['data'];
            $total_question = $_POST['total_question'];
            $quiz = '';
            $lesson_id = 0;
            $show_exer = false;

            $list_answer = [
                1 => "A",
                2 => "B",
                3 => "C",
                4 => "D"
            ];
            if(!empty($data)){
                $list_result = [];
                $arr_result_false = [];
                $list_id_false = [];
                foreach($data as $val){
                    $data_answer = CourseLessonAnswer::find()
                    ->where(['question_id' => $val['name']])
                    ->asArray()
                    ->all();

                    foreach($data_answer as $ans){
                        if($ans['position'] == $val['value']){
                            //kiểm tra nếu đáp án đúng
                            if($ans['is_correct'] == 1){
                                $list_result[] = [
                                    'question_id' => $ans['question_id'],
                                    'user_id'   => Yii::$app->user->identity->id,
                                ];
                            }else{
                                $list_id_false[] = $ans['question_id'];
                                $arr_result_false[$ans['question_id']] = $list_answer[$ans['position']];
                            }
                        }
                    }
                }
             
                $cours_id = '';
             
                if(!empty($list_result)){
                    $result_question = CourseLessonQuestion::find()
                    ->where(['id' => $list_result[0]['question_id'],'status' => 1,'is_delete' => 0])
                    ->asArray()
                    ->one();
                 
                    if(!empty($result_question['course_id'])){
                        $course_id = $result_question['course_id'];
                    }else{
                        $result_lesson = CourseLesson::find()
                        ->where(['id' => $result_question['lesson_id']])
                        ->asArray()
                        ->one();
                        $course_id = $result_lesson['course_id'];
                    }
                   
                    $course_lesson = Course::find()
                    ->where(['id' => $course_id])
                    ->asArray()
                    ->one();
                    $is_final = true;
                    $cours_id = $course_lesson['id'];
                    $lesson_id = 0;
                 
                    // Tổng câu trả lời đúng tối thiểu để vượt qua bài học
                    $total_answer_correct_need = $course_lesson['total_answer_correct_need'];
                    $data_res['status'] = 0;
                    if(count($list_result) >= $total_answer_correct_need){
                        $result_active = CourseLessonActive::findOne(['user_id' => $user_id,'lesson_id' => 0,'course_id' => $course_lesson['id']]);
                        if(empty($result_active)){
                            $model_active = new CourseLessonActive();
                            $model_active->lesson_id    = 0;
                            $model_active->course_id    = $course_lesson['id'];
                            $model_active->user_id      = $user_id;
                            $model_active->status       = 1;
                            $model_active->create_date  = date('Y-m-d H:i:s');
                            $model_active->save(false);
                        }

                        $result_check = CourseLessonResultCheck::findOne(['user_id' => $user_id,'lesson_id' => 0,'course_id' => $course_lesson['id']]);
                        if(empty($result_check)){
                            $model_result_check = new CourseLessonResultCheck();
                            $model_result_check->lesson_id = 0;
                            $model_result_check->course_id = $course_lesson['id'];
                            $model_result_check->user_id = Yii::$app->user->identity->id;
                            $model_result_check->total_answer = $total_question;
                            $model_result_check->total_answer_correct = count($list_result);
                            $model_result_check->create_date = date('Y-m-d H:i:s');
                            $model_result_check->last_update = date('Y-m-d H:i:s');  
                            $model_result_check->save(false);
                        }
                        $province = Province::find()->select(['id','province_name'])->asArray()->all();

                        $option_province = '';
                        foreach($province as $item) { 
                            $option_province .= '<option value="'. $item['id'] .'">'. $item['province_name'] .'</option>';
                        }
                        $str_res = '<div class="result_exr">
                                            <img src="/images/page/icon-active-bang.svg" alt="">
                                            <span class="fz-20 text-dark mb-2">Chúc mừng Bạn đã hoàn thành khoá học</span>
                                            <div class="position-relative item_pdf">
                                                <img class="chungchi" style="width:355px" class="mt-3" src="https://elearning.abe.edu.vn/'. $course_lesson['certificate'] .'" alt="">
                                                <span class="user_name">'. Yii::$app->user->identity->fullname .'</span>
                                                <span class="date_cc">
                                                        '. date('\N\g\à\y d \t\h\á\n\g m \n\ă\m Y') .'
                                                </span>
                                            </div>
                                            <div class="cer">
                                                <button class="down_cer font-weight-bold">Tải chứng nhận</button>
                                                <button class="receive_cer font-weight-bold" data-toggle="modal" data-target="#modal_address">Nhận Bằng Cứng (10$)</button>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modal_address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog modal_info" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header align-items-center mt-3">
                                                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Thông tin của bạn để nhận bằng</h5>
                                                        <button type="button" class="close close_modal" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"><img src="/images/page/close-modal.svg" alt=""></span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form id="form_addess" method="POST">
                                                            <div class="form-group">
                                                                    <input type="text" name="name" id="name" required="" placeholder="Họ tên *">
                                                            </div>
                                                            <div class="form-group phone_mail">
                                                                    <input type="number" name="phone" id="phone" placeholder="Số điện thoại *">
                                                                    <input type="text" name="email" id="email" placeholder="Email (nếu có)">
                                                            </div>
                                                            <div class="form-group">
                                                                    <select name="" id="province">
                                                                        <option value="">Tỉnh/ Thành phố *</option>
                                                                        '. $option_province .'
                                                                    </select>
                                                            </div>
                                                            <div class="form-group">
                                                                    <select name="" id="district">
                                                                        <option value="">Quận/ Huyện * </option>
                                                                    </select>
                                                            </div>
                                                            <div class="form-group">
                                                                    <input type="text" name="address" id="address" placeholder="Địa chỉ cụ thể (Số nhà, tên đường...) *">
                                                            </div>
                                                            <button type="button" course-id="'.$course_lesson['id'].'" class="btn btn-primary submit_form_address">Gửi</button>
                                                    </form>
                                                    </div>
                                                    </div>
                                                </div>
                                        </div>
                                    ';
                        $data_res['status'] = 1;
                    }else{
                        $str_res = '<div class="result_exr">
                                        <img src="/images/page/done.svg" alt="">
                                        <span class="fz-20 text-white">Đúng '. count($list_result) .'/'. $total_question .' câu</span>
                                        <strong class="text-white fz-20">KHÔNG ĐẠT</strong>
                                        <button class="btn_exr remake">Làm lại</button>
                                    </div>';
                        $quiz = count($list_result) .'/'. $total_question;
                    }

                }else{
                    $str_res = '<div class="result_exr">
                                    <img src="/images/page/done.svg" alt="">
                                    <span class="fz-20 text-white">Đúng 0/'. $total_question .' câu</span>
                                    <strong class="text-white fz-20">KHÔNG ĐẠT</strong>
                                    <button class="btn_exr remake">Làm lại</button>
                                </div>';
                }
                $data_res['str_res'] =  $str_res;
                $data_res['quiz'] =  $quiz;
                $data_res['lesson_id'] =  $lesson_id;
                $data_res['cours_id'] =  $cours_id;
                $data_res['show_exer'] =  $show_exer;
                echo json_encode($data_res);
                exit;
            }
        }
    }
    //function kiểm tra câu trả lời của bài học
    public function actionCheckResultQaLesson(){
        if(isset($_POST['data'])){
            $user_id = Yii::$app->user->identity->id;
            $data = $_POST['data'];
            $total_question = $_POST['total_question'];
            $quiz = '';
            $lesson_id = 0;
            $cours_id = '';
            $show_exer = false;
            $session = Yii::$app->session;

            $list_answer = [
                1 => "A",
                2 => "B",
                3 => "C",
                4 => "D"
            ];
            if(!empty($data)){
                $list_result = [];
                $arr_result_false = [];
                $list_id_false = [];
                $position_false = [];
                $y = 0;
                foreach($data as $val){
                    $y++;
                    $data_answer = CourseLessonAnswer::find()
                    ->where(['question_id' => $val['name']])
                    ->asArray()
                    ->all();

                    foreach($data_answer as $ans){
                        if($ans['position'] == $val['value']){
                            //kiểm tra nếu đáp án đúng
                            if($ans['is_correct'] == 1){
                                $list_result[] = [
                                    'question_id' => $ans['question_id'],
                                    'user_id'   => Yii::$app->user->identity->id,
                                ];
                            }else{
                                $list_id_false[$ans['question_id']] = $ans['question_id'];
                                $position_false[$ans['question_id']] = $y;
                                $arr_result_false[$ans['question_id']] = $list_answer[$ans['position']];
                            }
                        }
                    }
                }
            
                $arr_res_qa_false = [];
                if(!empty($list_id_false)){
                    $data_answer_false = CourseLessonAnswer::find()
                    ->where(['in', 'question_id', $list_id_false])
                    ->andWhere(['is_correct' => 1])
                    ->asArray()
                    ->all();
                    
                    if(!empty($data_answer_false)){
                        foreach($data_answer_false as $val){
                            $arr_res_qa_false[$val['question_id']] = $arr_result_false[$val['question_id']] . ' đáp án đúng ' . $list_answer[$val['position']];
                        }

                    }
                    $result_question = CourseLessonQuestion::find()
                    ->where(['in','id',$list_id_false])
                    ->andWhere(['status' => 1,'is_delete' => 0])
                    ->asArray()
                    ->one();
                
                    if($result_question['lesson_id'] != 0){
                        $course_lesson = CourseLesson::find()
                        ->where(['id' => $result_question['lesson_id']])
                        ->asArray()
                        ->one();
                        $cours_id = $course_lesson['course_id'];
                        $lesson_id = $course_lesson['id'];
                    }
                }
                $text_res_qa_false = '';
                if(!empty($arr_res_qa_false)){
                    $k = 0;
                    foreach($arr_res_qa_false as $key => $item){
                        $k++;
                        $br = '';
                        if ($k % 2 == 0)
                            $br = '</br>';
                        $text_res_qa_false .= 'Câu '. $position_false[$key] . ' chọn ' . $item . '; '. $br .'';
                    }
                }
           
                if(!empty($list_result)){
                    $result_question = CourseLessonQuestion::find()
                    ->where(['id' => $list_result[0]['question_id'],'status' => 1,'is_delete' => 0])
                    ->asArray()
                    ->one();
                    
                    if($result_question['lesson_id'] != 0){
                        $course_lesson = CourseLesson::find()
                        ->where(['id' => $result_question['lesson_id']])
                        ->asArray()
                        ->one();
                        $cours_id = $course_lesson['course_id'];
                        $lesson_id = $course_lesson['id'];
                    }
                    
                    // Tổng câu trả lời đúng tối thiểu để vượt qua bài học
                    $total_answer_correct_need = $course_lesson['total_answer_correct_need'];
                    $data_res['status'] = 0;
                    // if(count($list_result) >= $total_answer_correct_need){
                    if(count($list_result) == $total_question){
                        $active_check = CourseLessonActive::find()->where(['lesson_id' => $result_question['lesson_id']])->one();
                        if(empty($active_check)){
                            $model_active = new CourseLessonActive();
                            $model_active->lesson_id    = $result_question['lesson_id'];
                            $model_active->course_id    = $course_lesson['course_id'];
                            $model_active->user_id      = Yii::$app->user->identity->id;
                            $model_active->status       = 1;
                            $model_active->create_date  = date('Y-m-d H:i:s');
                            $model_active->save(false);
                        }

                        $session = Yii::$app->session;
                        $data_qa_false = $session->get('data_qa_false');
                        if(isset($data_qa_false) && (isset($data_qa_false['total_answer']) && isset($data_qa_false['total_answer_correct']))){
                            $tt_answer = $data_qa_false['total_answer'];
                            $tt_answer_correct = $data_qa_false['total_answer_correct'];
                        }else{
                            $tt_answer = $total_question;
                            $tt_answer_correct = count($list_result);
                        }
                        unset($session['data_qa_false']);
                        $quiz = $tt_answer_correct .'/'. $tt_answer;

                        $model_result_check = new CourseLessonResultCheck();
                        $model_result_check->lesson_id = $result_question['lesson_id'];
                        $model_result_check->course_id = $course_lesson['course_id'];
                        $model_result_check->user_id = Yii::$app->user->identity->id;
                        $model_result_check->total_answer = $tt_answer;
                        $model_result_check->total_answer_correct = $tt_answer_correct;
                        $model_result_check->create_date = date('Y-m-d H:i:s');
                        $model_result_check->last_update = date('Y-m-d H:i:s');  
                        $model_result_check->save(false);

                        //kiểm tra xem có bài học tiếp theo không, không có thêm button làm bài tập lớn của khóa học
                        $lesson_end = CourseLesson::find()
                        ->select(['id','name','course_id','path_file','link_video'])
                        ->where(['course_id' => $course_lesson['course_id']])
                        ->andWhere(['>','id',$result_question['lesson_id']])
                        ->orderBy(['id' => SORT_ASC])
                        ->asArray()
                        ->one();
                        if(empty($lesson_end))
                            $show_exer = true;
                        

                        $str_res = '<div class="result_exr">
                                        <img src="/images/page/done.svg" alt="">
                                        <span class="fz-20 text-white">Đúng '. count($list_result) .'/'. $total_question .' câu</span>
                                        <strong class="text-white fz-20">ĐẠT</strong>
                                        <button class="btn_exr next_less">Tiếp theo</button>
                                    </div>';

                        $lesson_next = CourseLesson::find()
                        ->select(['id','name','course_id','link_video'])
                        ->where(['course_id' => $course_lesson['course_id']])
                        ->andWhere(['>','id',$course_lesson['id']])
                        ->orderBy(['id' => SORT_ASC])
                        ->asArray()
                        ->one();
                        if(!empty($lesson_next)){
                            $active_check = CourseLessonActive::find()
                            ->where(['user_id' => $user_id,'lesson_id' => $lesson_next['id']])
                            ->asArray()
                            ->one();
                            if(empty($active_check)){
                                $data_res['lesson_next'] = $lesson_next;
                                //bài kiểm tra của bài học
                                $model_active = new CourseLessonActive();
                                $model_active->lesson_id    = $lesson_next['id'];
                                $model_active->course_id    = $lesson_next['course_id'];
                                $model_active->user_id      = $user_id;
                                $model_active->status       = 1;
                                $model_active->create_date  = date('Y-m-d H:i:s');
                                $model_active->save(false);
                        
                                // $model_result_check = new CourseLessonResultCheck();
                                // // $model_result_check->lesson_id = $lesson_next['id'];
                                // $model_result_check->lesson_id = $result_question['lesson_id'];
                                // $model_result_check->course_id = $course_lesson['course_id'];
                                // $model_result_check->user_id = $user_id;
                                // $model_result_check->total_answer = $total_question;
                                // $model_result_check->total_answer_correct = count($list_result);
                                // $model_result_check->create_date = date('Y-m-d H:i:s');
                                // $model_result_check->last_update = date('Y-m-d H:i:s');  
                                // $model_result_check->save(false);
                            }
                        }
                    }else{
                        $str_res = '<div class="result_exr">
                                        <img src="/images/page/done.svg" alt="">
                                        <span class="fz-20 text-white">Đúng '. count($list_result) .'/'. $total_question .' câu</span>
                                        <strong class="text-white fz-20">KHÔNG ĐẠT</strong>
                                        <p class="text-white">'. $text_res_qa_false .'</p>
                                        <button class="btn_exr remake_lesson">Làm lại</button>
                                    </div>';

                        //tạo session các câu hỏi trả lời sai
                        $_SESSION['data_qa_false']['list_id'] = $list_id_false;
                        $_SESSION['data_qa_false']['course_id'] = $cours_id;
                        $_SESSION['data_qa_false']['lesson_id'] = $lesson_id;
                        $session = Yii::$app->session;
                        $data_qa_false = $session->get('data_qa_false');
                        if(!isset($data_qa_false['total_answer']) && !isset($data_qa_false['total_answer'])){
                            $_SESSION['data_qa_false']['total_answer'] = $total_question; //Tổng số câu hỏi
                            $_SESSION['data_qa_false']['total_answer_correct'] = count($list_result); //tổng số câu trả lời đúng
                        }
                        $quiz = count($list_result) .'/'. $total_question;
                    }

                }else{
                    //tạo session các câu hỏi trả lời sai
                    $_SESSION['data_qa_false']['list_id'] = $list_id_false;
                    $_SESSION['data_qa_false']['course_id'] = $cours_id;
                    $_SESSION['data_qa_false']['lesson_id'] = $lesson_id;
                    $session = Yii::$app->session;
                    $data_qa_false = $session->get('data_qa_false');
               
                    if(!isset($data_qa_false['total_answer']) && !isset($data_qa_false['total_answer'])){
                        $_SESSION['data_qa_false']['total_answer'] = $total_question; //Tổng số câu hỏi
                        $_SESSION['data_qa_false']['total_answer_correct'] = count($list_result); //tổng số câu trả lời đúng
                    }
                    $str_res = '<div class="result_exr">
                                    <img src="/images/page/done.svg" alt="">
                                    <span class="fz-20 text-white">Đúng 0/'. $total_question .' câu</span>
                                    <strong class="text-white fz-20">KHÔNG ĐẠT</strong>
                                    <p class="text-white">'. $text_res_qa_false .'</p>
                                    <button class="btn_exr remake_lesson">Làm lại</button>
                                </div>';
                }
                $data_res['str_res'] =  $str_res;
                $data_res['quiz'] =  $quiz;
                $data_res['lesson_id'] =  $lesson_id;
                $data_res['cours_id'] =  $cours_id;
                $data_res['show_exer'] =  $show_exer;
                echo json_encode($data_res);
                exit;
            }
        }
    }

    public function actionUpdateNote(){
        if(isset($_POST['form_data'])){
            $list_less_note = [];
           foreach($_POST['form_data'] as $item){
                $id_less = str_replace('node_','',$item['name']);
                $list_less_note[$id_less] = $item['value'];
           }
           if(!empty($list_less_note)){
            foreach($list_less_note as $key => $val){
                $check_note = CourseLessonNote::findOne(['lesson_id' => $key]);
             
                if(empty($check_note)){
                    $check_note = new CourseLessonNote();
                    $date_create = date('Y-m-d H:i:s');
                }else{
                    $date_create = $check_note['create_date'];
                }
               
                $check_note->lesson_id = $key;
                $check_note->user_id = Yii::$app->user->identity->id;
                $check_note->note = $val;
                $check_note->create_date = $date_create;
                $check_note->last_update = date('Y-m-d H:i:s');
                $check_note->save(false);
            }
            echo 1;
            die;
           }
        }
    }

    public function actionGetDescription(){
        if(isset($_POST['id_lesson'])){
            $result_lesson = CourseLesson::findOne(['id' => $_POST['id_lesson']]);

            $doc = json_decode($result_lesson->document,true);
            $arr_doc = '';
            $arr_tailieu = '';
            if(!empty($doc)){
                foreach($doc as $item){
                    if(!empty($item['file_link']))
                        $arr_tailieu .= '<a target="_blank" href="https://elearning.abe.edu.vn'. $item['file_link'] .'"><p>'. $item['name'] .'</p><p>Tải xuống</p></a>';
                    else
                        $arr_doc .= '<a target="_blank" href="'. $item['link'] .'">'. $item['name'] .'</a>';
                }
            }
          
            $data['des'] = $result_lesson->description;
            $data['doc'] = $arr_doc;
            $data['tailieu'] = $arr_tailieu;
            echo json_encode($data);
            exit;
        }
    }
    
    public function actionDetail($alias){
        $contact = new Contact();
        if ($contact->load(Yii::$app->request->post()) ) {
            // var_dump($_REQUEST);die;
            $contact->time = date("Y/m/d h:i:s");
            if($contact->save()){
                Yii::$app->session->setFlash('success', 'Cám ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ liên hệ lại với bạn sau ít phút.');
            } else {
                Yii::$app->session->setFlash('error', 'Đã có lỗi xảy ra, Vui lòng thử lại trong ít phút.');
            }
            return $this->refresh();
        }
        $model = new CourseOffline();
        var_dump($alias);die;
        $Course = $model->find()->where(['slug'=>$alias])->one();
        return $this->render('index',[
            'Course'=>$Course,
            'model'=>$contact
        ]);
    }
    public function actionVideo($id = null)
    {
        if($id){
            $model = new Course();
            $model_lession = new CourseLesson();
            $model_section = new CourseSection();
            $Course = $model->find()->where(['id'=>$id])->one();
            $Sections = $model_section->find()->where(['course_id'=>$id])->all();
            $Lessions = $model_lession->find()->where(['course_id'=>$id])->all();
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
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if($id){
            $model_lession      = CourseLesson::findOne($id);
            if( !$model_lession )
                return 0;
            if(  $model_lession->is_prevew == 1 )
                return 1;
            else{
                if( !Yii::$app->user->isGuest ){
                    $user_id            = Yii::$app->user->id;
                    if( $model_lession ){
                        $check_isset        =  UserCourse::findOne(['course_id'=>$model_lession->course_id,'user_id'=>$user_id]);
                        $isset_Course       = $check_isset ? 1 : 0;
                        return $isset_Course;
                    }else
                        return 0;
                    
                }else
                    return 0;
            }
        }else
            return 0;
       
    }

    public function actionResetQuestion(){
        if(isset($_POST)){
            $course_id = $_POST['course_id'];
            $user_id = Yii::$app->user->identity->id;
            $lesson = CourseLesson::find()->where(['course_id' => $course_id])->asArray()->all();
            $list_id_lesson = array_column($lesson,'id');
            CourseLessonActive::deleteAll(['user_id' => $user_id,'course_id' => $_POST['course_id']]);
            CourseLessonResultCheck::deleteAll(['user_id' => $user_id,'course_id' => $_POST['course_id']]);

            $session = Yii::$app->session;
            unset($session['data_qa_false']);

            return 1;
        }
    }

    public function actionSaveAddressUser(){
        if(isset($_POST)){
            $model = new DiplomaAddress();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->fullname;
            $model->course_id = $_POST['course_id'];
            $model->province_id = $_POST['province'];
            $model->district_id = $_POST['district'];
            $model->address = $_POST['address'];
            $model->email = $_POST['email'];
            $model->phone = $_POST['phone']; 
            $model->save(false);
            echo 1;die;
        }
    }
    public function actionGetDistrict(){
        if(isset($_POST['province'])){
            $result = District::find()->select(['id','district_name'])->where(['province_id' => $_POST['province']])->asArray()->all();
            $option = '<option value="">Chọn Quận/Huyện *</option>';
            foreach($result as $item){
                $option .= '<option value="'.$item['id'].'">'. $item['district_name'] .'</option>';
            }
            return $option;
        }
    }
    
}
