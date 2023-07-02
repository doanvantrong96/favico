<?php
use yii\helpers\Url;
use yii\web\View ;

$url_abe = 'https://elearning.abe.edu.vn';

?>
<link rel="stylesheet" href="/css/course.css" />
<link rel="stylesheet" href="/css/home.css" />

<script src="/js/jszip.js"></script>
<script src="/js/jszip-utils.js"></script>
<script src="/js/FileSaver.js"></script>
<script src="/js/jspdf.umd.js"></script>
<script src="/js/html2canvas.js"></script>

<script type="text/javascript" src="/js/toastr.js"></script>
<script type="text/javascript"  src="/js/course.js?v=1.0"></script>

<link rel="stylesheet" href="/css/default_skin.css" />
<link rel="stylesheet" href="/css/videojs-hls-player.css" />

<script>
  var id    = 3;
//   var _0x6c93=["\x76\x69\x64\x65\x6F","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x69\x64","\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x63\x6C\x61\x73\x73","\x76\x69\x64\x65\x6F\x2D\x6A\x73\x20\x76\x6A\x73\x2D\x64\x65\x66\x61\x75\x6C\x74\x2D\x73\x6B\x69\x6E\x20\x76\x6A\x73\x2D\x66\x6C\x75\x69\x64\x20\x76\x6A\x73\x2D\x31\x36\x2D\x39\x20\x76\x6A\x73\x2D\x62\x69\x67\x2D\x70\x6C\x61\x79\x2D\x63\x65\x6E\x74\x65\x72\x65\x64\x20\x75\x69\x2D\x6D\x69\x6E\x20\x75\x69\x2D\x73\x6D\x6F\x6F\x74\x68\x20\x76\x5F\x35\x65\x38\x34\x39\x34\x65\x37\x63\x63\x62\x33\x30\x2D\x64\x69\x6D\x65\x6E\x73\x69\x6F\x6E\x73\x20\x76\x6A\x73\x2D\x63\x6F\x6E\x74\x72\x6F\x6C\x73\x2D\x65\x6E\x61\x62\x6C\x65\x64\x20\x76\x6A\x73\x2D\x77\x6F\x72\x6B\x69\x6E\x67\x68\x6F\x76\x65\x72\x20\x76\x6A\x73\x2D\x76\x37\x20\x76\x6A\x73\x2D\x68\x6C\x73\x2D\x71\x75\x61\x6C\x69\x74\x79\x2D\x73\x65\x6C\x65\x63\x74\x6F\x72\x20\x76\x6A\x73\x2D\x68\x61\x73\x2D\x73\x74\x61\x72\x74\x65\x64\x20\x76\x6A\x73\x2D\x70\x61\x75\x73\x65\x64\x20\x76\x6A\x73\x2D\x75\x73\x65\x72\x2D\x69\x6E\x61\x63\x74\x69\x76\x65","\x73\x6F\x75\x72\x63\x65","\x73\x72\x63","\x2F\x75\x70\x6C\x6F\x61\x64\x73\x2F\x76\x69\x64\x65\x6F\x2D\x6C\x65\x73\x73\x6F\x6E\x2F","\x2F\x76\x69\x64\x65\x6F\x2E\x6D\x33\x75\x38","\x74\x79\x70\x65","\x61\x70\x70\x6C\x69\x63\x61\x74\x69\x6F\x6E\x2F\x78\x2D\x6D\x70\x65\x67\x55\x52\x4C","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x76\x69\x64\x65\x6F\x5F\x70\x6C\x61\x79\x65\x72","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64"];var video=document[_0x6c93[1]](_0x6c93[0]);video[_0x6c93[3]](_0x6c93[2],_0x6c93[0]);video[_0x6c93[3]](_0x6c93[4],_0x6c93[5]);var video_source=document[_0x6c93[1]](_0x6c93[6]);video_source[_0x6c93[3]](_0x6c93[7],_0x6c93[8]+ id+ _0x6c93[9]);video_source[_0x6c93[3]](_0x6c93[10],_0x6c93[11]);video[_0x6c93[12]](video_source);document[_0x6c93[14]](_0x6c93[13])[_0x6c93[12]](video)
</script>
<script src="/js/video.js"></script>
<script src="/js/videojs-http-streaming.js"></script>
<script src="/js/videojs-contrib-quality-levels.min.js"></script>
<script src="/js/videojs-hls-quality-selector.min.js"></script>
<script>
    var _0xb046=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x2F\x6A\x73\x2F\x63\x75\x73\x74\x6F\x6D\x2E\x6A\x73","\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x62\x6F\x64\x79"];var _script=document[_0xb046[1]](_0xb046[0]);_script[_0xb046[4]](_0xb046[2],_0xb046[3]);document[_0xb046[6]][_0xb046[5]](_script)
</script>

<div class="container container_user_course_detail">
     <section class="section_course">
          <div class="course_left">
               <div class="video_course position-relative">
                    <!-- <img class="thump_vd w-100" src="" alt="">
                    <img class="play_vd_course" src="/images/page/icon-play.svg" alt=""> -->
                  <?php /*  <video id="lesson_video" less-id="<?= $list_total_lesson_user[0]['id'] ?>" course-id="<?= $list_total_lesson_user[0]['course_id'] ?>" height="392" controlslist="nodownload" controls="controls" preload="none" muted playsinline poster="<?= $url_abe . $list_total_lesson_user[0]['avatar'] ?>" class="w-100 video_ video_main videojs-hls-player-wrapper">
                        <source id="source_video" src="<?= $url_abe . $list_total_lesson_user[0]['path_file'] ?>" type="video/mp4" />
                    </video>*/ ?>
                    <div class='videojs-hls-player-wrapper' id="video_player"></div>
                    <div class="document">
                         <h4>ĐỌC THÊM</h4>
                         <div class="list_document">
                            
                         </div>
                    </div>
               </div>
               <div class="tab_action_course">
                    <div class="tab_course">
                         <ul class="nav nav-pills ul_tab_course tab_doc">
                              <li class="nav-item">
                                   <a class="nav-link active" data-toggle="pill" href="#description">Mô tả</a>
                              </li>
                              <li class="nav-item">
                                   <a class="nav-link" data-toggle="pill" href="#documents">Đọc thêm</a>
                              </li>
                              <li class="nav-item">
                                   <a class="nav-link" data-toggle="pill" href="#files">Tài liệu</a>
                              </li>
                         </ul>
                         <div class="tab-content tab_content_course fz-15">
                              <div class="tab-pane container active" id="description">
                                   <p><?= $course_info['description'] ?></p>
                              </div>
                              <div class="tab-pane  container" id="documents">
                                
                              </div>
                              <div class="tab-pane  container" id="files">

                              </div>
                         </div>
                    </div>
                    <div class="action_course_user">
                         <a href="javascript::void(0)" class="position-relative">
                              <img src="/images/page/icon-share.svg" alt="">
                              <iframe style="top:10px" class="share_fb" src="https://www.facebook.com/plugins/share_button.php?href=<?= $url_abe .  Url::to(['/course/index','slug_detail' => $course_info['slug']]) ?>&layout=button&size=small&appId=1438665563271474&width=76&height=20" width="76" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                              <p>Chia Sẻ Bài Học</p>
                         </a>
                         <a href="<?= isset($study_guide[0]['file_link']) ? $url_abe . $study_guide[0]['file_link'] : '' ?>">
                              <img src="/images/page/icon-down.svg" alt="">
                              <p>Hướng Dẫn Lớp Học</p>
                         </a>
                         <a course-id="<?= $course_info['id'] ?>" id="reset_question" href="javascript:void(0)">
                              <img style="width:20px" src="/images/page/reset.png" alt="">
                              <p>Reset câu trả lời</p>
                         </a>
                    </div>

               </div>
          </div>
          <div class="course_right">
               <div class="tab_right_course">
                    <div class="nav_tab_course tab-pane active">
                         <div class="info_lect">
                              <img class="thump_lec" src="<?= $url_abe . $course_info['avatar_lecturer'] ?>" alt="">
                              <div>
                                   <span class="font-weight-bold"><?= $course_info['lecturer_name'] ?></span>
                                   <p><?= $course_info['lecturer_level'] ?></p>
                              </div>
                         </div>
                         <ul class="nav nav-pills ul_tab_course border-0 tab_cour_cus">
                              <li class="nav-item">
                                   <a class="nav-link active" data-toggle="pill" href="#tab_list_course">Tất cả bài học</a>
                              </li>
                              <li class="nav-item">
                                   <a class="nav-link" data-toggle="pill" href="#node_course">Ghi chú của tôi</a>
                              </li>
                         </ul>
                    </div>
                    <div class="tab-content">
                         <div class="list_course_group tab-pane active" id="tab_list_course">
                              <div class="list_course_des fz-15">
                                   <?php /*<p><?= $course_info['description'] ?></p>*/ ?>
                                   <span><?= $course_info['name'] ?></span>
                              </div>
                              <div class="list_course">
                                   <?php 
                                        $course_exer = '';
                                        if(!empty($list_total_lesson_user)){
                                             $i = 0;
                                             foreach($list_total_lesson_user as $lesson){
                                                  $i++;
                                                  if(isset($lesson['status']) && $lesson['status'] == 1){
                                                       $link_video = $url_abe . $lesson['link_video'];
                                                       $lock_vd = 'd-none';
                                                       $course_exer = $lesson['course_id'];
                                                  }
                                                  else{
                                                       $link_video = false;
                                                       $lock_vd = '';
                                                       $course_exer = '';
                                                  }
                                                  $active = '';
                                                  if(isset($_GET['position']) && $_GET['position'] == $lesson['id']){
                                                       $active = 'active_video';
                                                  }else if($i == 1)
                                                       $active = 'active_video';


                                                  if($lesson['duration'] < 3600)
                                                       $time = gmdate("i:s", $lesson['duration']);
                                                  else
                                                       $time = gmdate("H:i:s", $lesson['duration']);

                                                  $continue = isset($arr_continue[$lesson['id']]) ? $arr_continue[$lesson['id']] : 0;

                                   ?>
                                                  <div class="group_lesson position-relative">
                                                       <div class="item_course <?= $active ?>" id="item_lesson_<?= $lesson['id'] ?>" continue="<?= $continue ?>" less-id="<?= $lesson['id'] ?>" course-id="<?= $lesson['course_id'] ?>" data-url="<?= $link_video ?>">
                                                            <div class="position-relative">
                                                                 <div class="lock_lesson <?= $lock_vd ?>">
                                                                      <img src="/images/page/icon-lock.svg" alt="">
                                                                 </div>
                                                                 <img class="thumb_list_cour" src="<?=  $url_abe . $lesson['avatar'] ?>" alt="">
                                                                 <span class="time_video"><?= $time ?></span>
                                                            </div>
                                                            <div class="tit_cour">
                                                                 <p class="fz-14 font-weight-bold"><?= $lesson['name'] ?></p>
                                                                 <span class="fz-15">Quiz: <span class="blue quiz_<?= $lesson['id'] ?>"><?= isset($check_quiz[$lesson['id']]) ? $check_quiz[$lesson['id']]['total_answer_correct'] .'/'. $check_quiz[$lesson['id']]['total_answer'] : '' ?></span></span>
                                                            </div>
                                                       </div>
                                                  </div>
                                   <?php }}  ?>
                                                  <?php 
                                                       $quiz_end = '';
                                                       $click = 0;//khoa 
                                                       if($check_bt_end){
                                                            $course_exer = $course_exer;
                                                            $check_exer_end = 'd-none';
                                                       }
                                                       else{
                                                            $course_exer = '';
                                                            $click = 1; //mo khoa, khong click
                                                            $check_exer_end = '';
                                                       }

                                                       $certificate = '';
                                                       $date_format = '';
                                                       if(!empty($check_user_course)){ 
                                                            $quiz_end = $check_user_course[0]['total_answer_correct'] . '/' . $check_user_course[0]['total_answer'];
                                                            $click = 1; //mo khoa, khong click
                                                            $course_exer = '';
                                                            $course_exer = $check_user_course[0]['course_id'];
                                                            $certificate = $check_user_course[0]['certificate'];
                                                            
                                                            $date = date_create($check_user_course[0]['create_date']);
                                                            $date_format = date_format($date,'\N\g\à\y d \t\h\á\n\g m \n\ă\m Y');
                                                       }
                                                   
                                                  ?>
                                                  <div class="group_lesson position-relative">
                                                       <div class="item_course_emd" id="exercise_end" get-qa="<?= $click ?>" less-id="" course-id="<?= $course_exer ?>" data-url="" exr="<?= $certificate ?>">
                                                            <div class="position-relative">
                                                                 <div class="lock_lesson <?= isset($check_exer_end) ? $check_exer_end : '' ?>">
                                                                      <img src="/images/page/icon-lock.svg" alt="">
                                                                 </div>
                                                                 <img class="thumb_list_cour" src="/images/page/chungchi.png" alt="">
                                                            </div>
                                                            <div class="tit_cour">
                                                                 <p class="fz-14 font-weight-bold">Bài tập của khóa học</p>
                                                                 <span class="fz-15">Quiz: <span class="blue"><?= $quiz_end ?></span></span>
                                                            </div>
                                                       </div>
                                                  </div>
                              </div>
                         </div>
                         <div class="node_course tab-pane fade" id="node_course">
                              <div class="title_node">
                                   <div class="position-relative">
                                        <span class="checkbox_cus_show"></span>
                                        <input type="checkbox" id="check_show_all">
                                        <label>Hiển thị tất cả ghi chú</label>
                                   </div>
                                   <img src="/images/page/!.svg" alt="">
                              </div>
                              <div class="list_node">
                                   <form id="form_node" action="">
                                        <?php 
                                   
                                             $y = 0;
                                             foreach($list_total_lesson_user as $item){ 
                                                  $y++;
                                        ?>
                                             <div class="item_node item_node_<?= $item['id'] ?>" id-less="<?= $item['id'] ?>">
                                                  <div class="top_item_node">
                                                       <p>Bài <?= $y ?></p>
                                                       <p class="p_view">Đang xem</p>
                                                  </div>
                                                  <div class="content_item_node">
                                                       <span class="font-weight-bold text-dark fz-14"><?= $item['name'] ?></span>
                                                       <textarea name="node_<?= $item['id'] ?>" placeholder="Nhập ghi chú của bạn" name="" id="" cols="30" rows="10"><?= isset($list_node[$item['id']]) ? $list_node[$item['id']] : '' ?></textarea>
                                                  </div>
                                             </div>
                                        <?php } ?>
                                        <button type="button" class="udpate_node">Cập nhật</button>
                                   </form>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
     <?php if(!empty($course_info_kh)) { ?>
          <section class="course_top">
               <h2 class="mb-2">Các khóa học liên quan</h2>
               <div class="course_top_list">
                    <?php 
                         foreach($course_info_kh as  $item){ 
                              if($item['total_duration'] < 3600)
                                   $time = gmdate("i:s", $item['total_duration']);
                              else
                                   $time = gmdate("H:i:s", $item['total_duration']);
                         
                    ?>
                         <div class="item_course_top">
                             <a href="<?= Url::to(['course/course-overview', 'slug_course' => $item['slug']]) ?>">
                                   <div class="position-relative">
                                        <img class="thumb_lq" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                        <span class="time_video"><?= $time ?></span>
                                   </div>
                                   <p class="mt-1 font-weight-bold"><?= $item['name'] ?></p>
                             </a>
                         </div>
                    <?php } ?>
               </div>
          </section>
     <?php } ?>

</div>
<?php if(!empty($check_user_course)){  ?>
     <div class="modal fade" id="modal_chungchi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal_info" role="document">
               <div class="modal-content">
               <div class="modal-header align-items-center mt-3">
                    <button type="button" class="close close_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><img src="/images/page/close-modal.svg" alt=""></span>
               </div>
               <div class="modal-body">
                    <div class="result_exr">
                         <img src="/images/page/icon-active-bang.svg" alt="">
                         <div class="position-relative item_pdf">
                              <img class="chungchi" style="width:355px" class="mt-3" src="" alt="">
                              <span class="user_name"><?= Yii::$app->user->identity->fullname ?></span>
                              <span class="date_cc"><?= isset($date_format) ? $date_format : '' ?></span>
                         </div>
                         <div class="cer pb-5">
                              <button class="down_cer font-weight-bold">Tải chứng nhận</button>
                         </div>
                    </div>
               </div>
               </div>
          </div>
     </div>
<?php } ?>