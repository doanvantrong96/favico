<?php 
$url_abe = 'https://elearning.abe.edu.vn';
use yii\helpers\Url;

?>
<link rel="stylesheet" href="/css/home.css" />
<link rel="stylesheet" href="/css/course.css" />
<script type="text/javascript"  src="/js/course.js"></script>

<div class="top_course position-relative">
     <img class="w-100 avatar_cour" src="<?= $url_abe . $course_info['avatar'] ?>" alt="">
     <div class="info_lear">
          <div class="d-flex group_info_lear">
               <h4><?= $course_info['lecturer_name'] ?></h4>
               <div class="line_ins"></div>
               <span class="  font-weight-bold"><?= $course_info['name'] ?></span>
               <?php /*<p><?= $course_info['description'] ?></p>*/ ?>
               <div class="action_course">
                    <div class="action_button mt-4">
                         <a class="scroll_video" href="javascript::void(0)">
                              <img src="/images/page/action-1.svg" alt="">
                              <p>Tóm Tắt</p>
                         </a>
                         <a href="javascript::void(0)" class="position-relative">
                              <img src="/images/page/action-2.svg" alt="">
                              <iframe style="top:10px" class="share_fb" src="https://www.facebook.com/plugins/share_button.php?href=<?=  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>&layout=button&size=small&appId=1438665563271474&width=76&height=20" width="76" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                              <p>Chia sẻ</p>
                         </a>
                         <a href="">
                              <img src="/images/page/action-3.svg" alt="">
                              <?php 
                                   $price = $course_info['promotional_price'] != 0 ? $course_info['promotional_price'] : $course_info['price'];
                              ?>
                              <p><?=  number_format($price,0,'','.') ?>đ</p>
                         </a>
                    </div>
                    <div class="text-center group_reg mt-4">
                         <?php if(Yii::$app->user->identity) { ?>
                              <a href="javascript::void(0)" class="buy_now d-inline-block mb-3" id-course="<?= $course_info['id'] ?>" class="btn-open-modal font-weight-bold mb-3 d-inline-block">Đăng ký ngay</a>
                         <?php }else{ ?>
                              <a href="javascript::void(0)" id="btnLogin" data-url="/dang-nhap" class="btn-open-modal font-weight-bold mb-3 d-inline-block">Đăng ký ngay</a>
                         <?php } ?>
                    </div>
               </div>
          </div>
     </div>
</div>
<div class="container">
     <div class="list_title">
          <a class="active" href="#info_course">Thông tin khóa học</a>
          <a href="#related_courses">Khóa học liên quan</a>
          <a href="#question">Câu hỏi thường gặp</a>
     </div>
     <section class="center_course" id="info_course">
          <div class="info_course">
               <h2>Giới thiệu về lớp học này</h2>
               <div class="group_info_course">
                    <div class="info_course_left">
                         <div class="position-relative">
                              <video id="trailer_course" height="392" controlslist="nodownload" controls="controls" preload="none" muted playsinline poster="<?= $url_abe . $course_info['avatar'] ?>" class="w-100 video_ video_main">
                                   <source id="source_video" src="<?= $url_abe . $course_info['trailer'] ?>" type="video/mp4" />
                              </video>
                              <!-- <img class="thump_vd w-100" src="/images/page/info-course.png" alt="">
                              <img class="play_vd_course" src="/images/page/icon-play.svg" alt=""> -->
                         </div>
                         <p class="fz-15 mt-3 mb-4"><?= $course_info['description'] ?></p>
                         <div class="fz-15">
                              <?php 
                                   $time = $course_info['total_duration'];
                                   $hours = floor($time / 3600);
                                   $minutes = floor(($time / 60) % 60);
                                   if($hours > 0)
                                        $result = $hours.' giờ '.$minutes.' phút';
                                   else
                                        $result = $minutes.' phút';
                              ?>
                              <p>Chuyên gia: <strong><?= $course_info['lecturer_name'] ?></strong></p>
                              <p>Thời lượng lớp học: <strong><?= $course_info['total_lessons'] ?> bài học video (<?= $result ?>)</strong></p>
                              <p>Danh mục: <strong><?= $name_cat ?></strong></p>
                         </div>
                    </div>
                    <?php if(!empty($list_all_lesson)) { ?>
                         <div class="info_course_right">
                              <!-- <a class="text_top_right fz-15" href=""><i class="fas fa-play-circle"></i> Đoạn giới thiệu lớp học</a>
                              <p class="fz-15 mt-3 mb-2 font-weight-bold">Đoạn giới thiệu lớp học</p> -->
                              <div class="group_info_right">
                                   <?php foreach($list_all_lesson as $item) { ?>
                                        <div class="question_child">
                                             <div class="question_tit">
                                                  <p class="font-weight-bold"><?= $item['name'] ?></p>
                                                  <i class="fas fa-angle-down"></i>
                                             </div>
                                             <div class="answer_h">
                                                  <p><?= $item['description'] ?></p>
                                             </div>
                                        </div>
                                   <?php } ?>
                              </div>
                         </div>
                    <?php } ?>
               </div>
          </div>
     </section>

     <section id="related_courses">
          <h2>Các khóa học khác</h2>
          <div class="slider_related">
               <?php
                    if(!empty($course_info_kh)){
                         foreach($course_info_kh as $item){
               ?>
                              <div class="slide_child_related">
                                   <a class="d-flex flex-column" href="<?= Url::to(['/course/index','slug_detail' => $item['slug']]) ?>">
                                        <img src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                        <span class="fz-15 font-weight-bold mt-2"><?= $item['lecturer_name'] ?></span>
                                        <p class="fz-15"><?= $item['name'] ?></p>
                                   </a>
                              </div>
               <?php }} ?>
          </div>
     </section>

     <?php echo $this->render('/template/question_answer',['arr_ques' => $arr_ques]) ?>
    
</div>