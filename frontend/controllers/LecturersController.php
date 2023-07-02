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
use backend\models\Lecturer;
use backend\models\Category;
use backend\models\CourseCategory;
use backend\models\FrequentlyQuestionsGroup;
use backend\models\FrequentlyQuestions;



/**
 * Lecturers controller
 */
class LecturersController extends Controller
{
     public function actionIndex(){
          $this->view->title = 'Danh sách chuyên gia - ABE Academy';
          Yii::$app->view->registerMetaTag([
              'name' => 'description',
              'content' => 'Chuyên gia hướng dẫn tốt nhất Việt Nam: Nguyễn Tất Thịnh, Nguyên Hoàng Phương ….'
          ]);
          Yii::$app->view->registerMetaTag([
               'property' => 'og:image',
               'prefix' => 'og: http://ogp.me/ns#',
               'content' => '/uploads/images/lecturer/1673708794-1673505972-nguyen-hoang-phuong.jpg'
           ]);
          Yii::$app->view->registerMetaTag([
               'property' => 'og:url',
               'prefix' => 'og: http://ogp.me/ns#',
               'content' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
           ]);
          //data giảng viên
          $result_lecturer = Lecturer::find()->where(['status' => 1,'is_delete' => 0])->orderBy(['position' => SORT_ASC])->asArray()->all();
      
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

          return $this->render('index',[
               'result_lecturer'        => $result_lecturer,
               'arr_ques'               => $arr_ques,
          ]);
     }
     public function actionDetail($slug){
          //giảng viên
          $lecturer = Lecturer::find()->where(['status' => 1,'is_delete' => 0,'slug' => $slug])->asArray()->one();
          $des_seo = $lecturer['description'];
          $this->view->title = $lecturer['name'] . ' ' . $lecturer['office'];
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
               'content' => 'https://elearning.abe.edu.vn/' . $lecturer['avatar']
           ]);
          Yii::$app->view->registerMetaTag([
               'property' => 'og:url',
               'prefix' => 'og: http://ogp.me/ns#',
               'content' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
           ]);
          $list_category_course = CourseCategory::find()->select(['id','slug','name'])->where(['status' => 1,'is_delete' => 0])->asArray()->all();
          $arr_category = [];
          foreach($list_category_course as $item){
               $arr_category[$item['id']] = $item['name'];
          }
         
          //lớp học của giảng viên
          $course_lecturer = Course::find()
          ->where(['status' => 1,'is_delete' => 0,'lecturer_id' => $lecturer['id']])
          ->asArray()
          ->all();
        
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
          return $this->render('detail',[
               'lecturer'          => $lecturer,
               'course_lecturer'   => $course_lecturer,
               'arr_ques'          => $arr_ques,
               'arr_category'      => $arr_category,
          ]);
     }
     public function actionCategory(){
       
          return $this->render('category',[
               
          ]);
     }
     public function actionFormatDate($time){
          $hours = floor($time / 3600);
          $minutes = floor(($time / 60) % 60);
          $seconds = $time % 60;
          if($hours > 0)
               $result = $hours.'h '.$minutes.'p '.$seconds.'g';
          else
               $result = $minutes.'p '.$seconds.'g';
         return $result;
     }
}
