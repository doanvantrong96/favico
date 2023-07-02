<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\News;
use backend\models\CategoryTags;
use yii\data\Pagination;
/**
 * Site controller
 */
class NewsController extends Controller
{
    public function actionIndex($id = null){
        $this->layout = 'news';
        $model = new News();
        $categoty = new CategoryTags();
        $des = '';
        if( $id){
            $condition = ';'.$id.'%';
            $news = $model->find()->where(['status'=>2,'is_delete'=>0])->filterWhere(['like','categories',$condition,false])->orderBy(['id'=>SORT_DESC]);
            $name = $categoty->find()->where(['id'=>$id])->one();
            $title = $name->name;
            $des = $name->except;
        }else{
            $title = 'Tin tức';
            $news = $model->find()->where(['status'=>2,'is_delete'=>0])->orderBy(['id'=>SORT_DESC]);
        }
        $countQuery = clone $news;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(12);
        $allnews = $news->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',[
            'news'=>$allnews,
            'title'=> $title,
            'des' =>$des,
            'pages' => $pages,
            // 'Sections'=>$Sections,
            // 'Lessions'=>$Lessions
        ]);
    }
    public function actionDetail($slug){
        $this->layout = 'news';
        $model = new News();
        $new = $model->find()->where(['slug'=>$slug])->one();
        $new_more =  $model->find()->where(['<>','id',$new['id']])->orderBy(['id'=>SORT_DESC])->limit(5)->all();
        return $this->render('detail',[
            'new'=>$new,
            'news_more'=>$new_more
            // 'Sections'=>$Sections,
            // 'Lessions'=>$Lessions
        ]);
    }
}