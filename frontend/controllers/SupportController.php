<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Contact;

class SupportController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionBaochi()
    {
        return $this->render('index');
    }
    public function actionChinhsach()
    {
        return $this->render('chinhsach');
    }
    public function actionLienhe()
    {
        $model = new Contact();
        if ($model->load(Yii::$app->request->post()) ) {
            $model->time = date("Y/m/d h:i:s");
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Cám ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ liên hệ lại với bạn sau ít phút.');
            } else {
                Yii::$app->session->setFlash('error', 'Đã có lỗi xảy ra, Vui lòng thử lại trong ít phút.');
            }
            return $this->refresh();
        }
        return $this->render('lienhe',[
            'model'=>$model
        ]);
    }
   
    public function actionFb()
    {
        $this->redirect('https://www.facebook.com/yogalunathaicenter/');
    }
    public function actionInsta()
    {
        $this->redirect('https://www.instagram.com/lunathai.yoga/');
    }
    public function actionYoutube()
    {
        $this->redirect('https://www.youtube.com/channel/UC0Sp-Z3rZmzmYNjOpDGl9WQ?sub_confirmation=1');
    }
    public function actionGroup()
    {
        $this->redirect('https://www.facebook.com/groups/YogaLunaThai/');
    }
    public function actionListclass(){
        return $this->render('listclass');
    }
}