<?php

namespace backend\controllers;

use Yii;
use backend\models\Course;
use backend\models\News;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;
use yii\data\ActiveDataProvider;
use yii\data\CArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\imagine\Image;
use backend\controllers\CommonController;
use backend\models\ActionLog;

class ConfigController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CategoryTags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request    = Yii::$app->request;
        if ( $request->isPost ) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post       = Yii::$app->request->post();

            $course_hot_big = isset($post['course_hot_big']) ? $post['course_hot_big'] : "";
            $course_hot     = isset($post['course_hot']) ? $post['course_hot'] : [];
            $post_hot       = isset($post['post_hot']) ? $post['post_hot'] : [];
            $course_hot_pos = isset($post['course_hot_pos']) ? $post['course_hot_pos'] : [];
            $post_hot_pos   = isset($post['news_hot_pos']) ? $post['news_hot_pos'] : [];
            

            Course::updateHot(1, $course_hot_big);
            Course::updateHot(2, $course_hot, $course_hot_pos);
            News::updateHot($post_hot, $post_hot_pos);
            return [
                'errorCode' => 0,
                'message'   => 'Lưu cấu hình thành công'
            ];
        }
        return $this->render('index', [
            
        ]);
    }

    public function actionSearchCourse(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arrReturn  = [
            'total_count' => 0,
            'incomplete_results' => false,
            'items' => []
        ];
        $request    = $_REQUEST;
        $q          = isset($request['q']) ? $request['q'] : "";
        $ids_igrs   = isset($request['ids_igrs']) && !empty($request['ids_igrs']) ? $request['ids_igrs'] : [];
        $page       = isset($request['page']) ? $request['page'] : 1;
        $limit      = 30;
        $offset     = ($page - 1) * $limit;
        if( !empty($q) ){
            $query  = Course::find()->select('A.id,A.name')->from(Course::tableName() . ' A')->where(['like', 'A.name', $q])->andWhere(['A.status'=> 1,'A.is_delete'=>0]);
            
            if( !empty($ids_igrs) ){
                if( !is_array($ids_igrs) )
                    $ids_igrs = [$ids_igrs];
                $query->andWhere(['not in', 'A.id', $ids_igrs ]);
            }
            $arrReturn['total_count']   = $query->count();
            $arrReturn['items']         = $query->limit($limit)->offset($offset)->asArray()->all();
        }
        return $arrReturn;
    }

    public function actionSearchNews(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arrReturn  = [
            'total_count' => 0,
            'incomplete_results' => false,
            'items' => []
        ];
        $request    = $_REQUEST;
        $q          = isset($request['q']) ? $request['q'] : "";
        $ids_igrs   = isset($request['ids_igrs']) && !empty($request['ids_igrs']) ? $request['ids_igrs'] : [];
        $page       = isset($request['page']) ? $request['page'] : 1;
        $limit      = 30;
        $offset     = ($page - 1) * $limit;
        if( !empty($q) ){
            $query  = News::find()->select('A.id,A.title as name')->from(News::tableName() . ' A')->where(['like', 'A.title', $q])->andWhere(['A.status'=> NEWS::PUBLISHED,'A.is_delete'=>0]);
            
            if( !empty($ids_igrs) ){
                if( !is_array($ids_igrs) )
                    $ids_igrs = [$ids_igrs];
                $query->andWhere(['not in', 'A.id', $ids_igrs ]);
            }
            $arrReturn['total_count']   = $query->count();
            $arrReturn['items']         = $query->limit($limit)->offset($offset)->asArray()->all();
        }
        return $arrReturn;
    }
}
