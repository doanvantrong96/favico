<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Comment;
use backend\models\UserCourse;
use backend\models\Course;
use frontend\models\CommentChild;
use common\models\Users;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CommentController extends Controller {

    public function actionCreate(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if( !Yii::$app->user->identity ){
            return ['status'=>false,'login'=>true,'message'=>"Bạn chưa đăng nhập"];
        }else{
            $request  = $_REQUEST;
            if( !empty($request['comment']) && !empty($request['id']) ){
                //Check đã mua khoá học chưa?
                $user_id = Yii::$app->user->id;
                $model_userCourse =  new UserCourse();
                $check_isset =  $model_userCourse->findOne(['course_id'=>$request['id'],'user_id'=>$user_id]);
                if(!$check_isset){
                    $Course  = Course::findOne($request['id']);
                    // $url_buy = Url::to(['payment/check-out','amount'=>$Course->promotional_price > 0 ? $Course->promotional_price : $Course->price ,'bankID'=>'','course_id'=>$Course->id]);
                    $url_buy = Url::to(['site/terms']) . '#thanh-toan';
                    return ['status'=>false,'needBuy'=>true,'message'=>"Vui lòng mua khoá học để sử dụng chức năng Bình luận. <a style='text-decoration: underline;color:#fff' href='$url_buy'>Mua ngay</a>"];
                }
                $username = !empty(Yii::$app->user->identity->fullname) ? Yii::$app->user->identity->fullname : Yii::$app->user->identity->username;
                $isCommentChild   = false;
                if( $request['parent_id'] <= 0 ){
                    $modelComment = new Comment;
                    $modelComment->user_id = Yii::$app->user->identity->id;
                    $modelComment->username= $username;
                    $modelComment->obj_id  = $request['id'];
                    $modelComment->type_comment = $request['type'];
                    $modelComment->comment = strip_tags($request['comment']);
                    $modelComment->save(false);
                }else{
                    $isCommentChild = true;
                    $modelComment          = new CommentChild;
                    $modelComment->user_id = Yii::$app->user->identity->id;
                    $modelComment->username= $username;
                    $modelComment->parent_id  = $request['parent_id'];
                    $modelComment->comment = strip_tags($request['comment']);
                    $modelComment->save(false);
                }
                return ['status' => true, 'item' => $this->renderAjax('item',[
                    'isCommentChild' => $isCommentChild,
                    'modelComment'   => $modelComment
                ])];
            }
            else
                return ['status'=>false,'message'=>"Vui lòng nhập nội dung bình luận"];
        }
    }
    public function actionListComment(){
        $request                = $_REQUEST;
        $dataCommentParent      = Comment::find()->where(['type_comment'=>$request['type'],'status'=>1,'obj_id'=>$request['id']])->orderBy([ 'id' => SORT_DESC ])->all();
        $dataCommentChild       = [];
        $dataUserComment        = [];
        if( !empty($dataCommentParent) ){
            $listParentId       = array_values(ArrayHelper::map($dataCommentParent,'id','id'));
            $listUserComment    = ArrayHelper::map($dataCommentParent,'user_id','user_id');
            $resultChild        = CommentChild::find()->where(['status'=>1])->andWhere(['in','parent_id',$listParentId])->orderBy([ 'id' => SORT_DESC ])->all();
            if( !empty($resultChild) ){
                foreach($resultChild as $row){
                    $dataCommentChild[$row['parent_id']][] = $row;
                    $listUserComment[$row['user_id']] = $row['user_id'];
                }
            }
            $listUserComment    = array_values($listUserComment);
            $resultUser         = Users::find()->where(['in','id',$listUserComment])->all();
            foreach($resultUser as $rows){
                if( $rows->fb_id != '' )
                    $dataUserComment[$rows['id']] = '<img src="https://graph.facebook.com/' . $rows->fb_id . '/picture?type=normal" width="39" height="39" style="border-radius:50%" />';
                else
                    $dataUserComment[$rows['id']] = '<i class="icon-user-comment"></i>';
            }
        }
        return $this->renderAjax('data_comment',[
            'dataCommentParent' => $dataCommentParent,
            'dataCommentChild'  => $dataCommentChild,
            'dataUserComment'   => $dataUserComment
        ]);
    }
}