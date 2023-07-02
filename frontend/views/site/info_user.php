
<?php
use yii\helpers\Url;
use yii\web\View ;

$this->title = 'Cài đặt';
?>
<link rel="stylesheet" href="/css/home.css" />

<div class="container">
   <div class="text-center mt-5 mb-4">
      <h2>Cài đặt</h2>
   </div>
   <section class="info_user">
      <div class="info_left">
         <p class="title_info">Tài khoản</p>
         <div class="group-info">
            <div class="d-flex justify-content-between">
               <label for="">Họ và tên</label>
               <span class="update_ip">Chỉnh sửa</span>
            </div>
            <input type="text" nam="name" id="name" value="<?= $info_user['fullname'] ?>" disabled>
         </div>
         <div class="group-info">
            <div class="d-flex justify-content-between">
               <label for="">Số điện thoại</label>
            </div>
            <input type="text" id="phone" value="<?= $info_user['phone'] ?>" disabled>
         </div>
         <div class="group-info">
            <div class="d-flex justify-content-between">
               <label for="">E-mail</label>
               <span class="update_ip">Chỉnh sửa</span>
            </div>
            <input type="text" id="email" value="<?= $info_user['email'] ?>" disabled>
         </div>
         <div class="group-info text-center">
            <button class="save_info">Lưu chỉnh sửa</button>
         </div>
         <div class="group-info text-center">
            <a class="link_fb" href=""><img class="mr-2" src="/images/page/icon-fb.svg" alt="">Liên kết Facbook của bạn</a>
            <p class="gray">Chúng tôi sẽ không bao giờ đăng thay mặt bạn.</p>
         </div>
      </div>
      <div class="info_right">
         <div class="right_info_child">
            <p class="title_info">Thiết bị</p>
            <span class="gray">Bạn hiện có thể phát trực tiếp từ 1 thiết bị.</span>
            <?php if(!empty($user_login)) { ?>
               <?php foreach($user_login as $item) { ?>
                  <span class="gray w-100 d-block"><?= $item['os'] .': ' . $item['browser'] ?></span>
               <?php } ?>
            <?php } ?>
         </div>
         <!-- <div class="right_info_child">
            <p class="title_info">Phương thức thanh toán</p>
            <span class="gray">Không có thẻ được lưu trữ</span>
         </div>
         <div class="right_info_child">
            <p class="title_info">Tư cách thành viên</p>
            <span class="gray">Thành Viên Cá Nhân Kể Từ Ngày 19 Tháng 11 Năm 2022</span>
         </div> -->
      </div>
   </section>
   <section class="process">
      <h2>Tiến trình của tôi</h2>
      <div class="top_process d-flex justify-content-between align-items-center">
         <div class="parameter">
            <div>
               <span><?= count($user_course) ?></span>
               <p>Các khóa học đã xem</p>
            </div>
            <div>
               <span><?= count($lesson_active) ?></span>
               <p>Bài đã xem</p>
            </div>
            <div>
               <span><?= round($phantramdaxem)?>%</span>
               <p>Danh mục đã xem</p>
            </div>
         </div>
         <div class="view_lh">
            <a href="<?= Url::to(['/site/my-progress']) ?>">Xem các lớp học của tôi</a>
         </div>
      </div>
      <div class="process_bot">
         <div class="d-flex justify-content-between text-dark my-3">
            <p>LOẠI</p>
            <p>BÀI ĐÃ XEM</p>
         </div>
         <?php 
            foreach($user_course as $item) { 
               $view = array_count_values(array_column($lesson_active, 'course_id'))[$item['course_id']];
               $phantramdaxem = ($view/$item['total_lessons'])*100;
              
         ?>
            <div class="process_child text-dark mb-3">
               <div class="d-flex justify-content-between mb-2">
                  <p><?= $item['name'] ?></p>
                  <p><?= $view ?>/<?= $item['total_lessons'] ?></p>
               </div>
               <div class="position-relative line_process">
                  <span class="active_process" style="width:<?= $phantramdaxem .'%' ?>"></span>
               </div>
            </div>
         <?php } ?>
      </div>
   </section>
</div>
