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
use backend\models\News;
use backend\models\FrequentlyQuestionsGroup;

use backend\models\Category;
use backend\models\Lecturer;
use backend\models\FrequentlyQuestions;

/**
 * Category controller
 */
class CategoryController extends Controller
{
     //trang chuyên mục lớp học
     public function actionIndex($slug = null){
          if(Yii::$app->user->identity)
               $view = 'index_user';
          else
               $view = 'index';
          
          $this->view->title = 'Danh mục khoá học - ABE Academy';
          Yii::$app->view->registerMetaTag([
              'name' => 'description',
              'content' => 'Các khoá học trực tuyến được tạo cho sinh viên ở mọi cấp độ kỹ năng'
          ]);
          Yii::$app->view->registerMetaTag([
               'property' => 'image',
               'content' => 'https://elearning.abe.edu.vn/images/page/logo.png'
           ]);
         
          $cat_course = Category::find()
          ->where(['status' => 1,'is_delete' => 0])
          ->asArray()
          ->all();
          $cat_course[] = [
               'name' => 'Sắp diễn ra',
               'slug' => 'sap-dien-ra',
          ];
       
          $data_course = Course::find()
          ->select(['A.id','A.name','A.slug','A.avatar','A.description','A.total_duration','B.name AS lecturer_name'])
          ->where(['A.status' => 1,'A.is_delete' => 0])
          ->from(Course::tableName() . ' A')
          ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
          ->asArray()
          ->all();
        
          if($slug && $slug != 'sap-dien-ra'){
               $cat_get_id = Category::find()->where(['status' => 1,'is_delete' => 0,'slug' => $slug])->asArray()->one();
              
               $des_seo = 'Các khoá học trực tuyến được tạo cho sinh viên ở mọi cấp độ kỹ năng';
               if(!empty($cat_get_id['except']))
                    $des_seo = $cat_get_id['except'];

               $this->view->title = $cat_get_id['name'] . ' - ABE Academy';
               Yii::$app->view->registerMetaTag([
                   'name' => 'description',
                   'content' => $des_seo
               ]);
               Yii::$app->view->registerMetaTag([
                    'property' => 'image',
                    'content' => 'https://elearning.abe.edu.vn/images/page/logo.png'
                ]);
               $id_cat = $cat_get_id['id'];

               $data_course = Course::find()
               ->select(['A.id','A.name','A.slug','A.avatar','A.description','A.total_duration','B.name AS lecturer_name'])
               ->where(['like', 'A.category_id', $id_cat])->from(Course::tableName() . ' A')
               ->andWhere(['not in','is_coming',1])
               ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
               ->asArray()
               ->all();
          }
          if($slug == 'sap-dien-ra'){
               $data_course = Course::find()
               ->select(['A.id','A.name','A.slug','A.avatar','A.description','A.total_duration','B.name AS lecturer_name'])
               ->where(['A.is_coming' => 1,'A.is_delete' => 0])
               ->from(Course::tableName() . ' A')
               ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
               ->asArray()
               ->all();
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
          
          //chuyên mục của khóa học
          $course_category = CourseCategory::find()
          ->where(['status' => 1,'is_delete' => 0])
          ->asArray()
          ->orderBy(['position' => SORT_ASC])
          ->all();
        
          $course_category[] = [
               'name' => 'Sắp diễn ra',
               'slug' => 'sap-dien-ra',
               'image' => '',
          ];
          return $this->render($view,[
               'cat_course'        => $cat_course,
               'data_course'       => $data_course,
               'arr_ques'          => $arr_ques,
               'course_category'   => $course_category,
          ]);
     }

     //trang blog
     public function actionBlog(){
          $this->view->title = 'Blog';
          $result_news = News::find()->where(['status' => 1,'is_delete' => 0])->orderBy(['id' => SORT_DESC])->asArray()->all();
          echo '<pre>';
          print_r($result_news);
          echo '</pre>';
          die;
          return $this->render('blog',[

          ]);
     }
     //trang bai viet
     public function actionIndexNews($slug,$id){
          $result_news = News::find()->where(['slug' => $slug,'id' => $id,'status' => 1,'is_delete' => 0])->orderBy(['id' => SORT_DESC])->asArray()->one();
          $result_related = [];
          if(!empty($result_news['related_news'])){
               $postID = array_values(array_filter(explode(";", $result_news['related_news'])));
               //bai viet lien quan
               $result_related = News::find()
               ->andWhere(['status' => 1,'is_delete' => 0])
               ->andWhere(['in','id',$postID])
               ->orderBy(['id' => SORT_DESC])
               ->asArray()
               ->all();
          }

          $this->view->params['log'] = [
               'enable'        => true,
               'type'          => \backend\components\ProcessLogView::TYPE_NEWS,
               'id'            => $result_news['id']
           ];
          //có thể bạn quan tâm
          // $result_new_hot = News::find()
          // ->where(['status' => 1, 'is_delete' => 0,'is_hot' => 1])
          // ->andWhere(['not in','id',$id])
          // ->asArray()
          // ->all();

          //khóa học nổi bật
          $course_is_hot = Course::find()->select(['A.id','A.slug','A.name','A.avatar','A.total_duration','A.description','B.name AS lecturer_name'])
          ->where(['A.status' => 1,'A.is_delete' => 0,'A.is_hot' => 1])
          ->from(Course::tableName() . ' A')
          ->innerJoin(Lecturer::tableName() . ' B', 'A.lecturer_id = B.id')
          ->asArray()
          ->all();
          return $this->render('index_news',[
               'result_news'       => $result_news,
               'result_related'    => $result_related,
               // 'result_new_hot'    => $result_new_hot,
               'course_is_hot'     => $course_is_hot,
          ]);
     }
}
