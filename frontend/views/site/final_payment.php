
<?php
use yii\helpers\Url;
use yii\web\View ;

$this->title = 'Thanh toán bước 2';
$url_abe = 'https://elearning.abe.edu.vn';
?>
<link rel="stylesheet" href="/css/home.css" />

<div class="container">
     <section class="section_final_payment">
          <div class="status_top">
               <img src="/images/page/status_pay.svg" alt="">
               <p class="fz-20">Đơn hàng <?= isset($model_cart['id']) ? '#'. $model_cart['id'] : '' ?> đã được đưa vào trạng thái chờ xử lý</p>
          </div>
          <div class="final_payment">
               <div class="final_leff">
                    <div class="box_thank">
                         <ul>
                              <li>
                                   <p>Ngay sau khi hoàn tất việc thanh toán. Chúng tôi sẽ gửi email xác nhận thanh toán đến email của bạn.</p>
                              </li>
                              <li>
                                   <p>Tiến hành thanh toán ngay và hãy đảm bảo bạn chuyển khoản đúng số tài khoản của chúng tôi.</p>
                              </li>
                              <li>
                                   <p>Trong thời gian bổ sung thông tin đăng ký và hoàn tất thanh toán. ABE được miễn trừ trách nhiệm.</p>
                              </li>
                         </ul>
                         <div class="thank_child">
                              <img src="/images/page/icon_ng.svg" alt="">
                              <p>Cảm ơn bạn đã tin tưởng và mua khoá học trên nền tảng E-learning của ABE Academy. Chúc bạn ngày mới tốt lành.</p>
                         </div>
                    </div>
                    <div class="info_cart_final">
                         <div class="detail_cart_text">
                              <p class="fz-20 text-white">Chi tiết đơn hàng</p>
                         </div>
                         <table class="table table_cart">
                              <thead>
                              <tr>
                                   <th scope="col">Sản phẩm</th>
                                   <th scope="col">Giá</th>
                                   <th scope="col">Khuyến mãi</th>
                                   <th scope="col">Thành tiền</th>
                              </tr>
                              </thead>
                              <tbody>
                                   <?php 
                                        if(!empty($data_cart)) {
                                             $price_total_not_code = 0;
                                             $price_total = 0;
                                             $price_discount = 0;
                                             $km = 0;
                                             foreach($data_cart as $item) {
                                                  $price = !empty($item['promotional_price']) ? $item['promotional_price'] : $item['price'];
                                                  $price_total_not_code = $price_total_not_code + $price;

                                                  //số tiền giảm
                                                  $item_discount = (isset($item['number_price_dis']) && !empty($item['number_price_dis'])) ? $item['number_price_dis'] : 0;
                                                  $price_discount = $price_discount + $item_discount;

                                                  if(isset($item['price_new']))
                                                       $price_final = $item['price_new'];
                                                  else if(!empty($item['promotional_price']))
                                                       $price_final = $item['promotional_price'];
                                                  else
                                                       $price_final = $item['price'];

                                                       $km = $item['price'] - $price_final;

                                                  $price_total = $price_total + $price_final;
                                   ?>
                                                  <tr> 
                                                       <td><?= $item['name'] ?></th>
                                                       <td><?= number_format($item['price'],0,'','.') ?> ₫</td>
                                                       <td><?= number_format($km,0,'','.') ?> ₫</td>
                                                       <td><?= number_format($price_final,0,'','.') ?> ₫</td>
                                                  </tr>
                              <?php }} ?>
                              </tbody>
                         </table>
                    </div>
                  
                    <div class="info_bank">
                         <h2>Danh sách Ngân hàng</h2>
                         <div class="warning_bank">
                              <img src="/images/page/wain.svg" alt="">
                              <p>Đơn hàng chỉ được xử lý khi ABE nhận được tiền chuyển khoản của quý khách. Quý khách vui lòng chọn một trong các danh sách ngân hàng dưới đây: <br> Mọi thắc mắc xin vui lòng liên hệ hotline: 083 482 2266</p>
                         </div>
                         <div class="list_bank">
                              <div class="bank_child">
                                   <img class="logo_bank" src="/images/page/Logo-Vietcombank 1.png" alt="">
                                   <h4 class="fz-20 mb-2">Ngân hàng thương mại cổ phần Ngoại thương Việt Nam</h4>
                                   <p>Chi nhánh Thăng Long - PGD Nguyễn Văn Huyên</p>
                                   <p>Số tài khoản: <strong>1166118888</strong></p>
                                   <p>Chủ tài khoản: <strong>CÔNG TY CỔ PHẦN TẬP ĐOÀN IMCE TOÀN CẦU</strong></p>
                                   <p>Nội dung chuyển khoản: <strong>Thanh toan <?= isset($model_cart['id']) ? '#'. $model_cart['id'] : '' ?></strong></p>
                                   <button class="qr_code" data-toggle="modal" data-target="#qr_code_1"><img src="/images/page/qr-code.svg" alt="">QR CODE</button>
                              </div>
                              <!-- <div class="bank_child">
                                   <img class="logo_bank" src="/images/page/Logo-Vietcombank 1.png" alt="">
                                   <h4 class="fz-20 mb-2">Ngân hàng thương mại cổ phần Ngoại thương Việt Nam</h4>
                                   <p>Chi nhánh Thăng Long - Hà Nội</p>
                                   <p>Số tài khoản: <strong>024 3974 6666</strong></p>
                                   <p>Chủ tài khoản: <strong>CONG TY ABE</strong></p>
                                   <p>Nội dung chuyển khoản: <strong>Thanh toan 102930</strong></p>
                                   <button class="qr_code" data-toggle="modal" data-target="#qr_code_2"><img src="/images/page/qr-code.svg" alt="">QR CODE</button>
                              </div> -->
                         </div>
                    </div>
               </div>
               <div class="final_right">
                    <div class="total_money_right">
                         <div>
                              <p class="gray mb-2">Tổng cộng</p>
                              <span class="font-weight-bold"><?= number_format($price_total_not_code,0,'','.') ?> ₫</span>
                         </div>
                         <div>
                              <p class="gray mb-2">Giảm giá</p>
                              <span class="font-weight-bold"><?= number_format($price_discount,0,'','.') ?> ₫</span>
                         </div>
                         <div>
                              <p class="gray mb-2">Thành tiền</p>
                              <span class="font-weight-bold"><?= number_format($price_total,0,'','.') ?> ₫</span>
                         </div>
                    </div>
               </div>
          </div>
     </section>    
</div>

<!-- Modal -->
<div class="modal fade" id="qr_code_1" tabindex="-1" role="dialog" aria-labelledby="qr_code_1Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
     <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
          </button>
     </div>
      <div class="modal-body">
        <img class="im_qrcode" src="/images/page/qr-code.jpg" alt="">
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="qr_code_2" tabindex="-1" role="dialog" aria-labelledby="qr_code_2Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
     <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
          </button>
     </div>
      <div class="modal-body">
          <img class="im_qrcode" src="/images/page/qr_code.png" alt="">
      </div>
    </div>
  </div>
</div>