
<?php
use frontend\controllers\PaymentsController;
use yii\helpers\Url;
use yii\web\View ;

$this->title = 'Thanh toán';
$url_abe = 'https://elearning.abe.edu.vn';
?>
<link rel="stylesheet" href="/css/home.css" />

<div class="container container_payment">
   <div class="text-center tit_pay">
      <h2>THANH TOÁN</h2>
   </div>
   <div class="row">
      <div class="col-lg-6">
         <div class="order_pay">
            <p class="fz-20 font-weight-bold mb-5">Đơn hàng của bạn</p>
            <div class="list_order">
               <?php 
                  $total_price = 0;
                  $id_course = '';
                  $string_course = '';
                  if(!empty($list_course_cart)) {
                     foreach($list_course_cart as $key => $item) {
                        $string_course .= $item['name'] . ' ,';
                        $id_course .= ';'. $key .';';
                        if($item['promotional_price'] != 0){
                           $price_khuyenmai = $item['promotional_price'];
                           $price = $item['price'];
                        }else{
                           $price_khuyenmai = $item['price'];
                           $price = 0;
                        }
                        $total_price = $total_price + $price_khuyenmai;
               ?>
                     <div class="item_order">
                        <img class="img_order" class="w-100" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                        <div class="des_order">
                           <div class="des_child">
                              <div>
                                 <p class="font-weight-bold"><?= $item['name_lecturer'] ?></p>
                                 <span><?= $item['name'] ?></span>
                              </div>
                              <div class="text-right">
                                 <p class="font-weight-bold">Giá: <?= number_format($price_khuyenmai,0,'','.') ?>Đ</p>
                                 <span class="line_th"><?= number_format($price,0,'','.') ?>đ</span>
                              </div>
                           </div>
                           <span class="remove_cart" id-cart="<?= $key ?>">Xóa</span>
                        </div>
                     </div>
               <?php }}  ?>
            </div>
            <div class="code_discount">
               <input type="text" id="code" placeholder="Mã giảm giá (nếu có)">
               <button id="send_code">Áp dụng</button>
               <div class="result_discount">
                  <span>Mã giảm giá: <b id="code_gg"></b></span>
                  <span class="sp_disc">0</span>
               </div>
            </div>
            <div class="total_order">
               <p class="fz-14">Tổng cộng</p>
               <span id="total_mon" class="font-weight-bold fz-18"><?= number_format($total_price,0,'','.') ?>Đ</span>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="box_payment">
            <p class="fz-20 font-weight-bold mb-5">Đơn hàng của bạn</p>
            <div class="type_payment">
               <div class="type_child">
                  <div class="position-relative radio_payment">
                     <input type="radio" name="payment" class="radio_payment" value ="1">
                     <i></i>
                  </div>
                  <img src="/images/page/icon-nh.svg" alt="">
                  <p>Chuyển khoản qua ngân hàng</p>
               </div>
               <div class="type_child">
                  <div class="position-relative radio_payment">
                     <input type="radio" name="payment" class="radio_payment" value ="2">
                     <i></i>
                  </div>
                  <img src="/images/page/icon-vnpay.svg" alt="">
                  <p>Thanh toán bằng VNPAY</p>
               </div>
            </div>
            <div class="group_button_pay">
               <button class="submit_payment">Thanh toán</button>
            </div>
         </div>
      </div>
   </div>
</div>

<form name="payment" id="ib_payment" method="post" action="/payment/VnpayCreatePayment">
    <input type="hidden" id="type_payment" name="type_payment" value="vnpay" />
</form>
<form id="contact-form" method="post" name="cForm">  
   <input type="hidden" id="name" name="Họ tên" value ="<?= Yii::$app->user->identity->fullname ?>">
   <input type="hidden" id="phone" name="Số điện thoại" value ="<?= Yii::$app->user->identity->phone ?>">
   <input type="hidden" id="email" name="Email" value ="<?= Yii::$app->user->identity->email ?>">
   <input type="hidden" id="content" name="Nội dung" value ="Mua khóa học: <?= rtrim($string_course, ",") ?>">
</form>