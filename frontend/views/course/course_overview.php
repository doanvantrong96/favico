<?php
use yii\helpers\Url;
use yii\web\View ;
$url_abe = 'https://elearning.abe.edu.vn';

?>
<link rel="stylesheet" href="/css/home.css" />
<link rel="stylesheet" href="/css/course.css" />
<script type="text/javascript"  src="/js/course.js"></script>

<div class="banner_top_user">
     <div class="left_b_us">
          <div class="text_top_us text-center">
               <h2 class="text-uppercase"><?= $info_course['name_lecturer'] ?></h2>
               <div class="line_ins"></div>
               <p class="fz-20 mb-2"><?= $info_course['name'] ?></p>
               <span class="line_3_mb"><?= $info_course['description'] ?></span>
          </div>
          <div class="action_us">
               <?php if(!$isset_check) { ?>
                    <div class="div_price_over mb-5">
                         <img src="/images/page/action-3.svg" alt="">
                         <p class="fz-24"><?= $info_course['promotional_price'] > 0 ? number_format($info_course['promotional_price'],0,'','.') : number_format($info_course['price'],0,'','.') ?>đ</p>
                         <span style="text-decoration: line-through;"><?= $info_course['promotional_price'] > 0 ? number_format($info_course['price'],0,'','.') .'đ' : '' ?></span>
                    </div>
                    <div class="buy_now_box">
                         <a href="javascript:void(0)" class="view_course buy_now" id-course="<?= $info_course['id'] ?>"><i class="fas fa-caret-right fz-26 mr-2"></i>Mua ngay</a>
                         <a href="javascript::voi(0)" class="plus_button btn_us" cour-id="<?= $info_course['id'] ?>">
                              <?php if(!empty($favotite)) { ?>
                                   <img src="/images/page/done.png" alt="">
                              <?php }else{ ?>
                                   <img src="/images/page/Layer_3.svg" alt="">
                              <?php } ?>
                         </a>
                         <a href="javascript::voi(0)" id="add_cart" id-course="<?= $info_course['id'] ?>" class="btn_us"><img src="/images/page/Cart.svg" alt=""></a>
                    </div>
               <?php }else{ ?>
                    <div class="buy_now_box">
                         <a href="<?= Url::to(['/course/index','slug_detail' => $info_course['slug']]) ?>" id="continue_course" class="view_course" id-course="<?= $info_course['id'] ?>"><i class="fas fa-caret-right fz-26 mr-2"></i>Tiếp tục</a>
                         <a href="javascript:void(0)" title="Yêu thích" class="plus_button btn_us">
                              <?php if(!empty($favotite)) { ?>
                                   <img src="/images/page/done.png" alt="">
                              <?php }else{ ?>
                                   <img src="/images/page/Layer_3.svg" alt="">
                              <?php } ?>
                         </a>
                    </div>
               <?php } ?>
          </div>
     </div>
     <div class="banner_right_user">
          <video id="trailer_index" controls loop autoplay muted height="600" controlslist="nodownload" controls="controls" preload="none"  poster="<?= $url_abe . $info_course['avatar'] ?>" class="w-100 video_ video_main">
               <source id="source_video" src="<?= $url_abe . $info_course['trailer'] ?>" type="video/mp4" />
          </video>
     </div>
     <!-- <div class="banner_right_user">
          <img src="<?= $url_abe . $info_course['avatar'] ?>" alt="">
     </div> -->
</div>
<div class="container">
     <?php if(!empty($data_lesson)) { ?>
          <div class="list_overview d-flex flex-column">
               <?php foreach($data_lesson as $item) { ?>
                    <a href="<?= Url::to(['/course/index','slug_detail' => $info_course['slug'],'position' => $item['id']]) ?>" class="item_over">
                         <div class="position-relative">
                              <img class="thumb_list_cour" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                              <span class="time_video"><?= gmdate("H:i:s", $item['duration']) ?></span>
                         </div>
                         <div class="des_over">
                              <span class="fz-20 mb-3 font-weight-bold d-block"><?= $item['name'] ?></span>
                              <p class="line_2"><?= $item['description'] ?></p>
                         </div>
                    </a>
               <?php } ?>
          </div>
     <?php } ?>
     <?php 
          if($isset_check) { 
               $study_guide = json_decode($info_course['study_guide'], true);          
               $link_file = '';
               if(isset($study_guide[0]['file_link']))
                    $link_file = $url_abe . $study_guide[0]['file_link'];

     ?>
          <div class="book_bottom">
               <img class="avt_book" class="w-100" src="<?= $url_abe . $info_course['avatar'] ?>" alt="">
               <div>
                    <span class="fz-24 font-weight-bold mb-2 mt-5 d-block"><?= $info_course['name'] ?></span>
                    <p><?= $info_course['description'] ?></p>
                    <a href="<?= $link_file ?>"><img class="mr-2" src="/images/page/icon-down.svg" alt="">Tải về hướng dẫn</a>
               </div>
          </div>
     <?php } ?>
</div>
