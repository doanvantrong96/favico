<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\OrderCart;
use frontend\models\UserCourse;
use frontend\models\Course;
use backend\models\OrderCartProduct;

class PaymentsController extends Controller {

    private $url_api        = 'https://pay.vnpay.vn/vpcpay.html'; //beta -> 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
    private $vnpay_hash_secret = 'RMYQWHEFDPQLMHRUTDCOJZCYAOBQRTLF'; //beta -> 'OUWWEVCRTLODQONNXDWZLSNILPTAWGKF';
    private $merchant_id    = 'ABEEDU01'; //beta -> 'IMCE0001';
    private $version        = '2.1.0';
    private $paycomd        = 'pay';
    private $return_url     = 'https://elearning.abe.edu.vn/payments/VnpayReturn';
    private $listErrorCode  = [
        '00'=>'Giao dịch thành công',
        '01' => 'Giao dịch đã tồn tại' ,
        '02' => 'Merchant không hợp lệ' ,
        '03' => 'Dữ liệu gửi sang không đúng định dạng' ,
        '04' => 'Khởi tạo GD không thành công do',
        '08' => 'Hệ thống Ngân hàng đang bảo trì. Xin quý khách tạm thời không thực hiện giao dịch bằng thẻ/tài khoản của Ngân hàng này',
        '05' => 'Quý khách nhập sai mật khẩu thanh toán quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch', 
        '06' => 'Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.', 
        '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).', 
        '12' => 'Thẻ/Tài khoản của khách hàng bị khóa.', 
        '09' => 'Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.', 
        '10' => 'Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần', 
        '11' => 'Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.', 
        '24' => 'Khách hàng hủy giao dịch', 
        '51' => 'Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.', 
        '65' => 'Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.', 
        '75' => 'Ngân hàng thanh toán đang bảo trì', 
        '99' => 'Lỗi giao dịch hệ thống'
    ];
    /*
    * Function xử lý dữ liệu để bắt đầu gửi thanh toán qua VNPAY
    */
   
    public function actionVnpayCreatePayment(){
        $request     = $_POST;
        if( !isset($request['type_payment']) || $request['type_payment'] != 'vnpay'){
           echo 'Có lỗi vui lòng thử lại sau!';    
           die;
        }
        else if(  !Yii::$app->user->identity ){
            echo 'Bạn chưa đăng nhập';
            die;
        }
        $session = Yii::$app->session;
        $list_course_cart = $session->get('info_course_cart');
        
        $gift_code = '';
        $amount = 0;
        $id_course_vnpay = '';
        if(!empty($list_course_cart)){
            foreach($list_course_cart as $key => $val){
                $id_course_vnpay .= $key . ',';
                if(isset($val['code']))
                    $gift_code = $val['code'];

                if(isset($val['price_new']))
                    $amount = $amount + $val['price_new'];
                else if(!empty($val['promotional_price']))
                    $amount = $amount + $val['promotional_price'];
                else
                    $amount = $amount + $val['price'];
            }
        }
        $id_course_vnpay = rtrim($id_course_vnpay, ",");
        //Kiểm tra khoá học có tồn tại không? Nếu tồn tại check giá
        // $modelCourse      = Course::findOne($request['course_id']);
        // if( !$modelCourse || ( $modelCourse->price <= 0 && $modelCourse->promotional_price <= 0 ) ||  ($modelCourse->promotional_price > 0 && $modelCourse->promotional_price != $amount) || ($modelCourse->promotional_price <= 0 && $modelCourse->price > 0 && $modelCourse->price != $amount)){
        //     echo 'Thông tin khoá học không hợp lệ!!';
        //     die;
        // }



        $bankId         = isset($request['bankID']) ? $request['bankID'] : '';
        $ipAddr         = $_SERVER['REMOTE_ADDR'];

		$return_url     = $this->return_url;
		
        $createdate     = date('YmdHis');

        $vnp_Url        = $this->url_api;
        $vnp_Returnurl  = $this->return_url;
        $vnp_TmnCode    = $this->merchant_id;//Mã website tại VNPAY 
        $vnp_HashSecret = $this->vnpay_hash_secret; //Chuỗi bí mật

        $vnp_TxnRef     = time() . "_" . rand(100,999);//Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo  = 'Thanh toan mua khoa hoc #' . $id_course_vnpay;
        $vnp_OrderType  = 'orhter';
        $vnp_Amount     = (int)$amount * 100;
        $vnp_Locale     = 'vi';
        $vnp_IpAddr     = $_SERVER['REMOTE_ADDR'];
        $inputData      = array(
            "vnp_Version"       => $this->version,
            "vnp_TmnCode"       => $vnp_TmnCode,
            "vnp_Amount"        => $vnp_Amount,
            "vnp_Command"       => $this->paycomd,
            "vnp_CreateDate"    => date('YmdHis'),
            "vnp_CurrCode"      => "VND",
            "vnp_BankCode"      => $bankId,
            "vnp_IpAddr"        => $vnp_IpAddr,
            "vnp_Locale"        => $vnp_Locale,   
            "vnp_OrderInfo"     => $vnp_OrderInfo,
            "vnp_OrderType"     => $vnp_OrderType,
            "vnp_ReturnUrl"     => $vnp_Returnurl,
            "vnp_TxnRef"        => $vnp_TxnRef,    
        );

        $affliate_id = 0;
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('aff'))
            $affliate_id = $cookies['aff']->value;
        else 
            $affliate_id = 0;
    
        $order_cart               = new OrderCart;
        $order_cart->user_id      = Yii::$app->user->identity->id;
        $order_cart->price        = $amount;
        $order_cart->type         = 2;
        $order_cart->status       = 0;//Pending
        $order_cart->order_id     = $vnp_TxnRef;
        $order_cart->gift_code    = $gift_code;
        $order_cart->affliate_id  = $affliate_id;
        $order_cart->save(false);

        foreach($list_course_cart as $key => $item){
            $model_cart_product = new OrderCartProduct();
            $model_cart_product->order_cart_id = $order_cart->id;
            $model_cart_product->course_id = $key;
            $model_cart_product->price = $item['price'];
            $model_cart_product->price_discount = $item['promotional_price'];
            $model_cart_product->save(false);
        }

        if( $bankId == '' )
            unset($inputData['vnp_BankCode']);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
       
        return $this->redirect($vnp_Url);   
    }
    
    /*
    * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
    * Các bước thực hiện:
    * Kiểm tra checksum 
    * Tìm giao dịch trong database
    * Kiểm tra tình trạng của giao dịch trước khi cập nhật
    * Cập nhật kết quả vào Database
    * Trả kết quả ghi nhận lại cho VNPAY
    */
    public function actionVnpayIpn(){
        $inputData = array();
        $returnData = array();
        
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $vnp_HashSecret = $this->vnpay_hash_secret;
        $vnpTranId      = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode   = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount     = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi

        $secureHash     = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $Status         = 0;
        $orderId        = $inputData['vnp_TxnRef'];
        $order = OrderCart::findOne(['order_id' => $orderId]);
        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);  
              
                // $returnData['order'] = $order;
                if ($order != NULL) {
                    if($order['price'] == $vnp_Amount){ //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền 
                        //lấy thông tin các khóa học user mua
                        $order_cart_product = OrderCartProduct::find()->where(['order_cart_id' => $order['id']])->asArray()->all();
                        $list_id_course = array_column($order_cart_product,'course_id');

                        if ( $order->status == 0) {
                            $errorCode  = 'Giao dịch thành công';
                            if ($inputData['vnp_ResponseCode'] == '00') {
                                $Status = 1;
                            } else {
                                $Status = 2;
                                if( isset($this->listErrorCode[$inputData['vnp_ResponseCode']]) ){
                                    $errorCode = $this->listErrorCode[$inputData['vnp_ResponseCode']];
                                }else
                                    $errorCode = 'Giao dịch thất bại';
                            }
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            $order->status = $Status;
                            $order->note   = $errorCode;
                            $order->tranid_vnpay = $inputData['vnp_TransactionNo'];
                            if( $order->save(false) ){
                                if( $Status == 1 ){
                                    
                                    foreach($list_id_course as $val){
                                        $modelUserCourse = new UserCourse;
                                        $modelUserCourse->course_id = $val;
                                        $modelUserCourse->user_id = $order->user_id;
                                        $modelUserCourse->save(false);
                                    }
                                }
                            }
                            //Trả kết quả về cho VNPAY: Website TMĐT ghi nhận yêu cầu thành công                
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        }else{
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Giao dịch đã tồn tại';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'Số tiền không hợp lệ';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Giao dịch không tồn tại';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chữ ký không hợp lệ';
            }
        } catch (Exception $e) {
            $order->status = $Status;
            $order->note   = 'Giao dịch không thành công';
            $order->tranid_vnpay = $inputData['vnp_TransactionNo'];
            $order->save(false);

            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Lỗi giao dịch hệ thống';
        }
        echo json_encode($returnData);
        exit;
        // return $this->render('response',[
        //     'returnData'   => $returnData,
        // ]);
    }

    public function actionVnpayReturn(){
        $data       = $_REQUEST;
        $this->layout = 'payment';
        $this->view->title ='Kết quả giao dịch mua khoá học';
    
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_HashSecret = $this->vnpay_hash_secret;
        $vnpTranId      = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode   = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $secureHash     = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $Status         = 0;
        $orderId        = $inputData['vnp_TxnRef'];
        $order          = null;
        $returnData['Bank'] = $vnp_BankCode;

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $returnData['Message'] = 'Giao dịch thành công';

                $session = Yii::$app->session;
                $list_course_cart = $session->get('info_course_cart');

                $course_name = '';
                $money_int = 0;
                foreach($list_course_cart as $item){
                    $course_name .= $item['name'] . ' ,';

                    if(isset($item['price_new']))
                        $price = $item['price_new'];
                    else if($item['promotional_price'] != 0)
                        $price = $item['promotional_price'];
                    else
                        $price = $item['price'];
                    
                    $money_int = $money_int + $price;
                }
                $money_text = PaymentsController::VndText($money_int);

                Yii::$app
                ->mail
                ->compose()
                ->setFrom(['support@abe.edu.vn' => 'ABE Academy'])
                ->setTo(Yii::$app->user->identity->email)
                ->setSubject('Thanh toán khóa học thành công')
                ->setHtmlBody('<div style="padding:15px 20px;border: 1px solid #707070;margin: 0px auto;max-width: 800px;font-size: 16px;font-family: roboto;">
                                    <h1 style="font-size:24px;margin-bottom:10px">EMAIL XÁC NHẬN THANH TOÁN</h1>
                                    <h4>Xác nhận thanh toán học phí – Khóa học '. rtrim($course_name, ",") .'”</h4>
                                    <p style="margin-bottom:10px">Kính thưa Quý học viên '. Yii::$app->user->identity->fullname .'</p>
                                    <p style="margin-bottom:10px">Viện Nghiên cứu phát triển kinh tế châu Á – Thái Bình Dương (ABE Academy) chúc mừng Quý học viên đã đăng ký thành công khóa học E-learning tại nền tảng đào tạo trực tuyến <a href="http://elearning.abe.edu.vn/">elearning.abe.edu.vn</a></p>
                                    <p style="margin-bottom:10px">Bằng thư điện tử này, chúng tôi xác nhận đã nhận được khoản học phí với chi tiết như sau:</p>
                                    <table style="border: 1px solid;margin:10px 0" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td style="border: 1px solid;padding: 10px;">Khóa học</td>
                                            <td style="border: 1px solid;padding: 10px;">"'. rtrim($course_name, ",") .'”</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid;padding: 10px;">Học viên đăng ký</td>
                                            <td style="border: 1px solid;padding: 10px;">'. Yii::$app->user->identity->fullname .'</td>
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
                                            <td style="border: 1px solid;padding: 10px;">Thanh toán qua VNPAY</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <p style="margin-bottom:10px">Trường hợp cần trao đổi thêm, Quý học viên vui lòng liên hệ Hotline/Zalo: <a href="tel:+0834822266">083 482 2266</a> hoặc Email: <a href="mailto:support@abe.edu.vn">support@abe.edu.vn</a></p>
                                    <p style="margin-bottom:10px">Xin cảm ơn Quý học viên. Chúc Quý học viên phát triển thành công cùng ABE Academy!</p>
                                    <p style="margin-bottom:10px">Trân trọng,</p>
                                    <p>ABE Academy</p>
                                </div>')
                ->send();

                unset($session['info_course_cart']);
            } 
            else {
                $returnData['Message'] = 'Giao dịch không thành công';
                }
        } else {
            $returnData['Message'] = 'Chữ ký không hợp lệ';
        }
        
        return $this->render('response',[
            'returnData'   => $returnData,
        ]);
    }

    public function actionMail(){
        $fullname    = 'Ngoc Han';
        $body_mail = '
            <table style="background:#f5f6f7" width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" style="width:700px;margin:auto;margin-top:50px;border-radius:7px">
                                <tbody>
                                    <tr>
                                        <td style="border-top-left-radius:6px;border-top-right-radius:6px;height:80px;background:#2b3636;background-size:300px;background-position:100%;background-repeat:no-repeat;line-height:55px;padding-top:40px;text-align:center;color:#ffffff;display:block!important;margin:0 auto!important;clear:both!important">
                                            <img src="https://yogalunathai.com/resoure/Luna-Thai-Banner-1.jpg" height="64" width="64" style="max-width:100%;border-radius:50%;padding:5px" class="CToWUd">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background:#fff;border-bottom-left-radius:6px;border-bottom-right-radius:6px;padding-bottom:40px;margin:0 auto!important;clear:both!important">
                                            <div style="background:#2b3636;color:#ffffff;padding:0px 60px 40px;text-align:center;margin-bottom:40px">
            
                                                <h1 style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,&quot;Lucida Grande&quot;,sans-serif;margin-bottom:15px;color:#47505e;margin:0px 0 10px;line-height:1.2;font-weight:200;line-height:45px;font-weight:bold;margin-bottom:30px;font-size:28px;line-height:40px;margin-bottom:10px;font-weight:400;color:#ffffff;padding-left:40px;padding-right:40px;padding-top:40px;padding-top:0px">Chào mừng ' . $fullname . '!</h1>
            
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;color:#ffffff;opacity:0.8;padding-left:40px;padding-right:40px;margin-bottom:0;padding-bottom:0">Glad to have you on board.</p>
            
                                            </div>
                                            <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px">Vui lòng xác nhận tài khoản của bạn bằng cách ấn vào nút bên dưới:</p>
            
            
            
                                            <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;text-align:center;padding-left:40px;padding-right:40px"><a href="#" style="word-wrap:break-word;color:#09a59a;text-decoration:none;background-color:#09a59a;border:solid #09a59a;line-height:2;max-width:100%;font-size:14px;padding:8px 40px 8px 40px;margin-top:30px;margin-bottom:30px;font-weight:600;display:inline-block;border-radius:30px;margin-left:auto;margin-right:auto;text-align:center;color:#fff!important" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://email.m.teachable.com/c/eJxVUMtOhTAQ_RrYQfqAUhYsTG6MC13pTYwbUtoBGmmLfUT9e1uji5tMMmfOmbeaFgZirPXUA-4WhRDFfGAzxmTBQnZAaS_5SHvFqg7ps8GoQQ0muMEja0GSVtsI3oqjNUIf9T4hplaCBikW4Ej2XBBCYGVolYsiQKA-pj3Gs6J3FbnPFoJrIwi5i-WAVjpTOJDJQwYdoWQcM0gBfMheOrtqb0TUzlb0Jpyje4dMXl4-7PU1xoenx09xff6Kb5fgK8JSNHNwyUvIOSso58VcdoZ_0YDSyWQRCv1HSmFOobfS92aYtiH6JAsO9W_B7EGCPuOs1dQhjhHnDNd-slv6Bivsrpzd8JDfuJX0cuoPtLd_Hg&amp;source=gmail&amp;ust=1584465387106000&amp;usg=AFQjCNG_pDRikJcZ3c3OhhsKI6TEIIvF7A">Xác nhận Email</a></p>
            
            
            
                                            <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px">Sau khi xác nhận, bạn sẽ có quyền truy cập vào yogalunathai.com bằng tài khoản mới.</p>
            
            
            
                                            <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px;margin-bottom:0;padding-bottom:0">Thân mến,<br>yogalunathai</p>
            
            
            
                                        </td>
            
                                    </tr>
            
                                </tbody>
                            </table>
                            <div style="padding-top:30px;padding-bottom:55px;width:100%;text-align:center;clear:both!important">
            
                            <p style="font-weight:normal;padding:0;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;font-size:12px;color:#666;margin-top:0px">© yogalunathai</p>
            
                            </div>
            
                    <br>
            
                </td>
            
                </tr>
            
                </tbody>
            </table>
        ';
        $compose = Yii::$app->mail->compose();
        $compose->setFrom(['account@cogaivangyoga.vn' => 'yogalunathai.com'])->setSubject('Xác nhận Tài khoản của Bạn')->setHtmlBody($body_mail);
        $compose->setTo('ngochan9296@gmail.com');
        $r = $compose->send();
    }

    public function VndText($amount)
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

}