<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\HistoryTransaction;
use frontend\models\UserCourse;
use frontend\models\Course;

class PaymentController extends Controller {

    private $url_api        = 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
    private $vnpay_hash_secret = 'TVBSWRMVUNPDAXHYNNSXBIFJXQIGICBJ';
    private $merchant_id    = '0JKL3QZZ';
    private $version        = '2.0.0';
    private $paycomd        = 'pay';
    private $return_url     = 'http://localhost/payment/response-payment';//'http://bmgedu.vn/payment/response-payment';
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
    public function actionCheckOut(){
        $request     = $_REQUEST;
        if( !isset($request['amount']) || $request['amount'] <= 0 || !isset($request['course_id']) || $request['course_id'] <= 0){
           echo 'Dữ liệu không hợp lệ!';
           die;
        }
        else if(  !Yii::$app->user->identity ){
            // $paramsUrl  = [];
            // foreach ($request as $key => $value) {
            //     $paramsUrl[] = $key . "=" . $value;
                
            // }
            // return $this->redirect(['site/login','return'=>'/payment/check-out?' . implode('&',$paramsUrl)]);
            echo 'Bạn chưa đăng nhập';
            die;    
        }
        $amount           = (int)$request['amount'];
        //Kiểm tra khoá học có tồn tại không? Nếu tồn tại check giá
        $modelCourse      = Course::findOne($request['course_id']);
        // var_dump($modelCourse);die;
        // if( !$modelCourse || ( $modelCourse->promotional_price > 0 && $modelCourse->promotional_price != $amount ) || ( $modelCourse->promotional_price <= 0 && $modelCourse->price != $amount ) ){
        if( !$modelCourse || ( $modelCourse->price <= 0 && $modelCourse->promotional_price <= 0 ) ||  ($modelCourse->promotional_price > 0 && $modelCourse->promotional_price != $amount) || ($modelCourse->promotional_price <= 0 && $modelCourse->price > 0 && $modelCourse->price != $amount)){
            echo 'Thông tin khoá học không hợp lệ!!';
            die;
        }

        $modelTransaction               = new HistoryTransaction;
        $modelTransaction->course_id    = $modelCourse->id;
        $modelTransaction->user_id      = Yii::$app->user->identity->id;
        $modelTransaction->price        = $amount;
        $modelTransaction->status       = 0;//Pending

        $modelTransaction->save(false);

        $cartid         = $modelTransaction->id;
        $bankId         = isset($request['bankID']) ? $request['bankID'] : '';
        $ipAddr         = $_SERVER['REMOTE_ADDR'];
		

		$return_url     = $this->return_url;
		
        $createdate     = date('YmdHis');
        $order_code     = $cartid . "-" . time() . "-" . rand(100,999);

        $vnp_Url        = $this->url_api;
        $vnp_Returnurl  = $this->return_url;
        $vnp_TmnCode    = $this->merchant_id;//Mã website tại VNPAY 
        $vnp_HashSecret = $this->vnpay_hash_secret; //Chuỗi bí mật

        $vnp_TxnRef     = $cartid . "-" . time() . "-" . rand(100,999);//Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo  = 'Thanh toan mua khoa hoc #' . $request['course_id'];
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
        if( $bankId == '' )
            unset($inputData['vnp_BankCode']);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256',$vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
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
    public function actionResponsePayment(){
        $data       = $_REQUEST;
        $this->layout = 'payment';
        $this->view->title ='Kết quả giao dịch mua khoá học';
        $inputData  = array();
        $returnData = array();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i          = 0;
        $hashData   = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        $vnp_HashSecret = $this->vnpay_hash_secret;
        $vnpTranId      = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode   = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $secureHash     = hash('sha256',$vnp_HashSecret . $hashData);
        $Status         = 0;
        $orderId        = $inputData['vnp_TxnRef'];
        $order          = null;
        $returnData['Bank'] = $vnp_BankCode;
        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);  
                $dataOrderId = explode('-', $orderId);

                $order = HistoryTransaction::findOne($dataOrderId[0]);
                $returnData['order'] = $order;
                if ($order != NULL) {
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
                                $modelUserCourse = new UserCourse;
                                $modelUserCourse->course_id = $order->course_id;
                                $modelUserCourse->user_id = $order->user_id;
                                if($modelUserCourse->save(false)){
                                    //Cộng lượt người học khoá học
                                    $modelCourse      = Course::findOne($order->course_id);
                                    $modelCourse->total_learn = $modelCourse->total_learn + 1;
                                    $modelCourse->save(false);
                                }
                            }
                        }
                        //Trả kết quả về cho VNPAY: Website TMĐT ghi nhận yêu cầu thành công                
                        $returnData['RspCode'] = $inputData['vnp_ResponseCode'];
                        $returnData['Message'] = $errorCode;
                    } else {
                        $returnData['RspCode'] = '02';
                        $returnData['Message'] = 'Giao dịch đã tồn tại';
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
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Lỗi giao dịch hệ thống';
        }
        
        return $this->render('response',$returnData);
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

}