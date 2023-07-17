<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\News;
use backend\models\Category;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Site controller
 */
class NewsController extends Controller
{
    public function actionIndex($slug){
        $category = Category::findOne(['slug' => $slug]);
        $this->view->title = $category['name'];
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Công ty CP thức ăn chăn nuôi Phavico'
        ]);
        $limit = 9;
        $post = News::find()
        ->where(['like','category_id',";$category->id;"])
        ->andWhere(['status' => 1,'is_delete' => 0])
        ->limit($limit)
        ->all();

        return $this->render('index',[
            'category'      => $category,
            'post'      => $post,
        ]);
    }

    public function actionMoreNew(){
        if(isset($_POST['page']) && isset($_POST['category_id'])){
            $category_id = $_POST['category_id'];
            $limit = 9;
            $page = $_POST['page'];
            $offset = $page * $limit;

            $post_more = News::find()
            ->where(['like','category_id',";$category_id;"])
            ->andWhere(['status' => 1,'is_delete' => 0])
            ->limit($limit)
            ->offset($offset)
            ->all();
            $result_more_offset = News::find()
            ->select(['id'])
            ->where(['like','category_id',";$category_id;"])
            ->andWhere(['status' => 1,'is_delete' => 0])
            ->limit($limit)
            ->offset($offset + $limit)
            ->one();
            $arr_res = [];
            $response = '';
            if(!empty($post_more)){
                foreach($post_more as $row){
                    $response .= '<div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="blog-card">
                                        <div class="blog-card__image">
                                            <img
                                                data-lazyloaded="1"
                                                src="'. $row['image'] .'"
                                            />
                                            <a href="/"></a>
                                        </div>
                                        <div class="blog-card__content">
                                            <div class="blog-card__date"><a href="/"> '. date('d/m', strtotime($row['date_publish'])) .'</a></div>
                                            <h3 class="title"><a href="'. Url::to(['/news/detail','id' => $row['id']]) .'">'. $row['title'] .'</a></h3>
                                            <a class="btn_read" href="'. Url::to(['/news/detail','id' => $row['id']]) .'">Đọc ngay</a>
                                        </div>
                                    </div>
                                </div>';
                }
            }
            $arr_res['data'] = $response;
            $arr_res['check_more'] = !empty($result_more_offset) ? true : false;
            echo json_encode($arr_res);
            exit;

        }
    }
    public function actionDetail($id){
        $post = News::find()
        ->where(['id' => $id,'status' => 1,'is_delete' => 0])
        ->one();
        $arr_tag = array_filter(explode(';', $post->category_id));
        //get tag
        $tag = Category::find()
        ->where(['in','id',$arr_tag])
        // ->asArray()
        ->all();
       
        //bai viet lien quan
        $post_lq = News::find()
        ->where(['like','category_id',"$post->category_id"])
        ->andWhere(['status' => 1,'is_delete' => 0])
        ->andWhere(['<>','id', $post->category_id])
        ->limit(6)
        ->all();
        
        return $this->render('detail',[
            'new'=>$post,
            'post_lq'   => $post_lq,
            'tag'       => $tag,
            // 'news_more'=>$new_more
            // 'Sections'=>$Sections,
            // 'Lessions'=>$Lessions
        ]);
    }

    //tuyển dụng
    public function actionRecruitment()
    {

        return $this->render('recruitment', [
        ]);
    }

    public function actionDetailRecruitment(){
        $this->view->title = 'Tuyển dụng';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => ''
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'image',
        ]);
        return $this->render('detail_recruitment');
    }
}