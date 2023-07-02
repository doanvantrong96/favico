
<?php 
use yii\helpers\Url;
$url_abe = 'https://elearning.abe.edu.vn';

?>
<link rel="stylesheet" href="/css/home.css" />
<link rel="stylesheet" href="/css/category.css" />
<div class="container">
     <!-- <div class="top_cat fz-20">
          <p>Nhận hơn 180 lớp trên 11 danh mục</p>
          <div class="d-flex align-items-center">
               <p>$15/tháng thanh toán hàng năm</p>
               <a href="">Đăng ký</a>
          </div>
     </div> -->
     <section class="section_cat">
          <h2>Danh Mục</h2>
          <div class="cat_content">
               <div class="cat_sidebar">
                    <div class="cat_list_child">
                              <a class="<?= empty($_GET['slug']) ? 'active' : ''  ?>" href="<?= Url::to(['category/index']) ?>">Tất cả</a>
                         <?php 
                              foreach($cat_course as $item) { 
                                   $check_active = '';
                                   if(isset($_GET['slug']) && $_GET['slug'] == $item['slug']){
                                        $check_active = 'active';
                                   }          
                         ?>
                              <a class="<?= $check_active ?>" href="<?= Url::to(['category/index','slug' => $item['slug']]) ?>"><?= $item['name'] ?></a>
                         <?php } ?>
                    </div>
               </div>
               <div class="cat_list">
                    <?php
                         if(!empty($data_course)){
                              foreach($data_course as $item){
                                   $time = $item['total_duration'];
                                   $hours = floor($time / 3600);
                                   $minutes = floor(($time / 60) % 60);
                                   $seconds = $time % 60;
                                   if($hours > 0)
                                        $duration = $hours.' giờ '.$minutes.' phút';
                                   else
                                        $duration = $minutes.' phút '.$seconds.' giây ';
                                 
                    ?>
                         <div class="d-none d-lg-block">
                              <div class="slider_cour_child position-relative">
                                   <img class="radius_10" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                   <div class="content_sl_cour">
                                        <div class="content_bt_cour">
                                             <h6><?= $item['lecturer_name'] ?></h6>
                                             <div class="line_ins mt-2 mb-1"></div>
                                             <p class="line_2"><?= $item['name'] ?></p>
                                             <span><?= $duration ?></span>
                                             <div class="button_cat">
                                                  <?php if(Yii::$app->user->identity) { ?>
                                                       <a class="detail_lec back_gr" href="<?= Url::to(['/course/course-overview','slug_course' => $item['slug']]) ?>"><i class="fas fa-info-circle mr-1"></i> Thông tin khóa học</a>
                                                  <?php }else{ ?>
                                                       <a class="detail_lec back_gr" href="<?= Url::to(['/course/index','slug_detail' => $item['slug']]) ?>"><i class="fas fa-info-circle mr-1"></i> Thông tin khóa học</a>
                                                  <?php } ?>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="d-blocl d-lg-none">
                              <div class="slider_cour_child position-relative">
                                   <a href="<?= Url::to(['/course/index','slug_detail' => $item['slug']]) ?>">
                                        <img class="radius_10" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                        <div class="content_sl_cour">
                                             <div class="content_bt_cour">
                                                  <h6><?= $item['lecturer_name'] ?></h6>
                                                  <div class="line_ins mt-2 mb-1"></div>
                                                  <p class="line_2"><?= $item['name'] ?></p>
                                                  <span><?= $duration ?></span>
                                             </div>
                                        </div>
                                   </a>
                              </div>
                         </div>
                    <?php }} ?>
               </div>
          </div>
     </section>
     
     <?php echo $this->render('/template/question_answer',['arr_ques' => $arr_ques]) ?>
</div>