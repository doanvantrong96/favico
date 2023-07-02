<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\Course;
use backend\models\CoachCourse;
use common\models\Users;
use frontend\models\ChangePassword;

class UserController extends Controller {
    public function actionMycourse()
    {   
        if (!Yii::$app->user->identity) {
            return $this->goHome();
        }
        $model = new  Course();
        $id  = Yii::$app->user->identity->id;
        $connection = Yii::$app->db;
        $sql = "SELECT course.*,user_course.create_date as date_buy FROM `course` LEFT JOIN `user_course` ON user_course.course_id = course.id WHERE user_course.user_id =".$id;
        $Course = $connection->createCommand($sql)->queryAll(); 
        $listCoach = CoachCourse::getListCoach();
        return $this->render('mycourse',[
            'listCoach' => $listCoach,
            'Courses'=>$Course,
        ]);     
    }
    public function actionIndex(){
        if (!Yii::$app->user->identity) {
            return $this->goHome();
        }
        $id = Yii::$app->user->id;
        $model = Users::findOne(['id'=>$id]);
        // var_dump(Yii::$app->request->post());die;
        if ( $model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $params = Yii::$app->request->post();
            $model->fullname = $params['Users']['fullname'];
            $model->phone = $params['Users']['phone'];
            $model->email = $params['Users']['email'];
            $msgError = '';
            if( trim($model->fullname) === "" ){
                $msgError = 'Họ tên không được để trống';
            }
            if( $msgError == '' && !empty($model->phone) ){
                if(!preg_match('/^[0-9]{10}+$/', $model->phone)){
                    $msgError = 'Số điện thoại không đúng định dạng';
                }else{
                    $checkPhone = Users::findOne(['phone'=>$model->phone]);
                    if( $checkPhone && $checkPhone->id != $model->id ){
                        $msgError = 'Số điện thoại đã được sử dụng';
                    }
                }
            }
            if( $msgError == '' && !empty($model->email) ){
                $checkEmail = Users::findOne(['email'=>$model->email]);
                if( $checkEmail && $checkEmail->id != $model->id ){
                    $msgError = 'Email đã được sử dụng';
                }
                
            }
            if( $msgError ){
                Yii::$app->session->setFlash('error', $msgError);
            }else{
                $model->save(false);
                Yii::$app->session->setFlash('success', 'Cập nhật thông tin thành công');
                $session = Yii::$app->session;
                if ($session->get('url_access') ) {
                    $dataUrlAccess = $session->get('url_access');
                    
                    Yii::$app->session->remove('url_access');
                    header('Location: ' . $dataUrlAccess);
                    exit();
                }
            }
        }
        
        return $this->render('account',[
            'model'=>$model,
        ]);
    }
    public function actionChangePassword(){
        
        if (!Yii::$app->user->identity) {
            return $this->goHome();
        }
        $model      = new ChangePassword;
        if( Yii::$app->user->identity->password != '' )
            $model->scenario = 'has_password';
        if ( $model->load(Yii::$app->request->post()) && $model->updatePassword()) {
           
            Yii::$app->session->setFlash('success', 'Cập nhật mật khẩu thành công');
            header('Location: /user/change-password');
            exit();
        }
        return $this->render('change_password',[
            'model'=>$model,
        ]);
    }
}