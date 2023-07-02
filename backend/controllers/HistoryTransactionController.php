<?php

namespace backend\controllers;

use Yii;
use backend\models\OrderCart;
use backend\models\OrderCartSearch;
use backend\models\ActionLog;
use backend\models\UserCourse;
use backend\models\OrderCartProduct;
use backend\models\Course;
use backend\models\Customer;
use backend\models\CourseLesson;
use backend\models\CourseLessonActive;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HistoryTransactionController implements the CRUD actions for HistoryTransaction model.
 */
class HistoryTransactionController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all HistoryTransaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderCartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HistoryTransaction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCancel($id){
        $model = $this->findModel($id);
        if( $model ){
            $model->status = OrderCart::STATUS_ADMIN_CANCEL;
            $model->last_update = date('Y-m-d H:i:s');
            $model->save(false);

            ActionLog::insertLog(ActionLog::MODULE_TRANSACTION, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);

            Yii::$app->session->setFlash('success', 'Huỷ giao dịch thành công');
        }else{
            Yii::$app->session->setFlash('error', 'Thông tin giao dịch không tồn tại');
        }

        return $this->redirect(['index']);
    }

    public function actionVerify($id){
        $model = $this->findModel($id);
        if( $model ){
            
            $transaction        = Yii::$app->db->beginTransaction();
            try{
                $model->status  = OrderCart::STATUS_SUCCESS;
                $model->last_update = date('Y-m-d H:i:s');
                $model->save(false);
                
                $totalExistAllCourse = 0;
                $course_name = '';
                $money_int   = $model->price;
                $money_text  = $this->VndText($money_int);
                $listProduct = OrderCartProduct::find()->where(['order_cart_id' => $model->id])->all();
                foreach($listProduct as $product){
                    $checkExist             = UserCourse::findOne(['user_id' => $model->user_id, 'course_id' => $product->course_id ]);
                    if( $checkExist ){
                        $totalExistAllCourse++;
                        continue;
                    }
                    $modelCourse            = Course::findOne($product->course_id);
                    
                    $course_name .= $modelCourse->name . ' ,';

                    $userCourse             = new UserCourse;
                    $userCourse->course_id  = $product->course_id;
                    $userCourse->user_id    = $model->user_id;
                    $userCourse->save(false);

                    $lesson     = CourseLesson::find()->where(['course_id' => $product->course_id])->orderBy(['sort'=>SORT_ASC])->one();
                    if( $lesson ){
                        $lessonActive = new CourseLessonActive;
                        $lessonActive->lesson_id = $lesson->id;
                        $lessonActive->course_id = $lesson->course_id;
                        $lessonActive->user_id   = $model->user_id;
                        $lessonActive->status    = 1;
                        $lessonActive->save(false);
                    }

                }
                if( $totalExistAllCourse == count($listProduct) ){
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Có lỗi! Không thể xác nhận giao dịch đã thanh toán. Nguyên do: Khách hàng đã mua các khoá học của đơn hàng này rồi!');
                }else{
                    $transaction->commit();
            
                    $modelCustomer = Customer::findOne($model->user_id);
                    //Send email to customer
                    if( !empty($modelCustomer->email) ){
                        Yii::$app
                        ->mail
                        ->compose()
                        ->setFrom(['support@abe.edu.vn' => 'ABE Academy'])
                        ->setTo($modelCustomer->email)
                        ->setSubject('Thanh toán khóa học thành công')
                        ->setHtmlBody('<div style="padding:15px 20px;border: 1px solid #707070;margin: 0px auto;max-width: 800px;font-size: 16px;font-family: roboto;">
                                        <h1 style="font-size:24px;margin-bottom:10px">EMAIL XÁC NHẬN THANH TOÁN</h1>
                                        <h4>Xác nhận thanh toán học phí – Khóa học '. rtrim($course_name, ",") .'”</h4>
                                        <p style="margin-bottom:10px">Kính thưa Quý học viên '. $modelCustomer->fullname .'</p>
                                        <p style="margin-bottom:10px">Viện Nghiên cứu phát triển kinh tế châu Á – Thái Bình Dương (ABE Academy) chúc mừng Quý học viên đã đăng ký thành công khóa học E-learning tại nền tảng đào tạo trực tuyến <a href="http://abe.edu.vn/">abe.edu.vn</a></p>
                                        <p style="margin-bottom:10px">Bằng thư điện tử này, chúng tôi xác nhận đã nhận được khoản học phí với chi tiết như sau:</p>
                                        <table style="border: 1px solid;margin:10px 0" width="100%" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="border: 1px solid;padding: 10px;">Khóa học</td>
                                                <td style="border: 1px solid;padding: 10px;">"'. rtrim($course_name, ",") .'”</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;padding: 10px;">Học viên đăng ký</td>
                                                <td style="border: 1px solid;padding: 10px;">'. $modelCustomer->fullname .'</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;padding: 10px;">Số tiền bằng số</td>
                                                <td style="border: 1px solid;padding: 10px;">'. number_format($money_int,0,'','.') .' đồng</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;padding: 10px;">Số tiền bằng chữ</td>
                                                <td style="border: 1px solid;padding: 10px;">'.$money_text.'</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;padding: 10px;">Ngày thanh toán</td>
                                                <td style="border: 1px solid;padding: 10px;">'. date('d-m-Y') .'</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid;padding: 10px;">Hình thức thanh toán</td>
                                                <td style="border: 1px solid;padding: 10px;">Thanh toán qua chuyển khoản</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <p style="margin-bottom:10px">Trường hợp cần trao đổi thêm, Quý học viên vui lòng liên hệ Hotline/Zalo: <a href="tel:+0834822266">083 482 2266</a> hoặc Email: <a href="mailto:support@abe.edu.vn">support@abe.edu.vn</a></p>
                                        <p style="margin-bottom:10px">Xin cảm ơn Quý học viên. Chúc Quý học viên phát triển thành công cùng ABE Academy!</p>
                                        <p style="margin-bottom:10px">Trân trọng,</p>
                                        <p>ABE Academy</p>
                                    </div>')
                            ->send();
                    }
                    ActionLog::insertLog(ActionLog::MODULE_TRANSACTION, $model, ActionLog::TYPE_UPDATE, Yii::$app->user->identity->getId(), ActionLog::SOURCE_BACKEND);
                    
                    Yii::$app->session->setFlash('success', 'Xác nhận giao dịch đã thanh toán thành công');
                }
            }
            catch(\Exception $e){
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Có lỗi! Không thể xác nhận giao dịch đã thanh toán');
            }
        }else{
            Yii::$app->session->setFlash('error', 'Thông tin giao dịch không tồn tại');
        }

        return $this->redirect(['index']);
    }
    
    private function VndText($amount)
    {
         if($amount <=0)
        {
            return;
        }
        $Text=array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $TextLuythua =array("","nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
        $textnumber = "";
        $length = strlen($amount);
       
        for ($i = 0; $i < $length; $i++)
        $unread[$i] = 0;
       
        for ($i = 0; $i < $length; $i++)
        {              
            $so = substr($amount, $length - $i -1 , 1);               
           
            if ( ($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)){
                for ($j = $i+1 ; $j < $length ; $j ++)
                {
                    $so1 = substr($amount,$length - $j -1, 1);
                    if ($so1 != 0)
                        break;
                }                      
                      
                if (intval(($j - $i )/3) > 0){
                    for ($k = $i ; $k <intval(($j-$i)/3)*3 + $i; $k++)
                        $unread[$k] =1;
                }
            }
        }
       
        for ($i = 0; $i < $length; $i++)
        {       
            $so = substr($amount,$length - $i -1, 1);      
            if ($unread[$i] ==1)
            continue;
           
            if ( ($i% 3 == 0) && ($i > 0))
            $textnumber = $TextLuythua[$i/3] ." ". $textnumber;    
           
            if ($i % 3 == 2 )
            $textnumber = 'trăm ' . $textnumber;
           
            if ($i % 3 == 1)
            $textnumber = 'mươi ' . $textnumber;
           
           
            $textnumber = $Text[$so] ." ". $textnumber;
        }
       
        //Phai de cac ham replace theo dung thu tu nhu the nay
        $textnumber = str_replace("không mươi", "lẻ", $textnumber);
        $textnumber = str_replace("lẻ không", "", $textnumber);
        $textnumber = str_replace("mươi không", "mươi", $textnumber);
        $textnumber = str_replace("một mươi", "mười", $textnumber);
        $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
        $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
        $textnumber = str_replace("mười năm", "mười lăm", $textnumber);
       
        return ucfirst($textnumber." đồng");
    }

    /**
     * Finds the HistoryTransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HistoryTransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderCart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
