
<?php
use yii\helpers\Url;
use yii\web\View ;
$url_abe = 'https://elearning.abe.edu.vn';

?>
<link rel="stylesheet" href="/css/home.css" />
<link rel="stylesheet" href="/css/course.css" />

<script src="/js/jszip.js"></script>
<script src="/js/jszip-utils.js"></script>
<script src="/js/FileSaver.js"></script>
<script src="/js/jspdf.umd.js"></script>
<script src="/js/html2canvas.js"></script>
<script type="text/javascript"  src="/js/course.js?v=1.0"></script>

<div class="container container_user_index">
            <section class="continue_lesson lesson_progress">
                        <h2 class="fz-30 lh-30">Tiếp tục xem</h2>
                        <p class="mb-4 gray">Bạn đang làm rất tốt. Hãy tiếp tục với bài học mà bạn đang theo dõi trước đó.</p>
                        <div class="slider_continue_lesson">
                              <?php
                              if(!empty($result_continue)) {
                                    foreach($result_continue as $item){
                                          if($item['duration'] < 3600)
                                                $time = gmdate("i:s", $item['duration']);
                                          else
                                                $time = gmdate("H:i:s", $item['duration']);
            
                                          //check thời gian đã xem
                                          $phantramdaxem = ($item['time']/$item['duration'])*100;
                              ?>
                                          <div>
                                                <a href="<?= Url::to(['/course/index','slug_detail' => $item['slug_course'],'position' => $item['id']]) ?>">
                                                <div class="thumb_lesson position-relative radius_10">
                                                      <img class="w-100 radius_10" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                                      <span><?= $time ?></span>
                                                      <div class="time_continue" style="width:<?= $phantramdaxem ?>%"></div>
                                                      <div class="time_continue_def" style="width:100%"></div>
                                                </div>
                                                <div class="mt-2">
                                                      <span class="font-weight-bold"><?= $item['name_lecturer'] ?></span>
                                                      <p class="fz-15 line_2"><?= $item['name'] .' • Tập '. $item['sort'] .' của '. $item['total_lessons']  ?></p>
                                                </div>
                                                </a>
                                          </div>
                              <?php }} ?>
                        </div>
            </section>
      <section class="my_node">
            <h2 class="fz-30 lh-30">Ghi chú của tôi</h2>
            <p class="mb-4 gray">Xem lại các ghi chú của bạn.  Ghi nhớ những nội dung quan trọng và rút ra bài học dành cho riêng bạn.</p>
            <div class="my_node_list">
                  <?php 
                        if(!empty($arr_node)) {
                              $y = 0;
                              foreach($arr_node as $item) { 
                                    $y++;       
                  ?>
                        <div class="item_my_node">
                              <img class="avatar_note" src="<?= $url_abe . $item[0]['lecturer_avatar'] ?>" alt="">
                              <span class="font-weight-bold text-center heigth_name_lec line_2"><?= $item[0]['lecturer_name'] ?></span>
                              <p class="p_mynode"><?= $item[0]['name_course'] ?></p>

                              <button type="button" data-toggle="modal" data-target="#modal_node_<?= $y ?>" class="font-weight-bold text-white view_node">Xem ghi chú</button>
                              <!-- Modal -->
                              <div class="modal fade" id="modal_node_<?= $y ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered dialog_node" role="document">
                                    <div class="modal-content">
                                          <div class="modal-body modal_ct_node">
                                                <h2>Ghi chú của tôi</h2>
                                                <div class="top_show_node">
                                                      <img class="avatar_note" src="<?= $url_abe . $item[0]['avatar_lesson'] ?>" alt="">
                                                      <div>
                                                            <span class="font-weight-bold"><?= $item[0]['lecturer_name'] ?></span>
                                                            <p><?= $item[0]['name_course'] ?></p>
                                                      </div>
                                                </div>
                                                <?php 
                                                      foreach($item as $val) { 
                                                ?>
                                                <div class="list_node fz-14">
                                                      <div class="top_list_node">
                                                      <p class="gray"><?= $val['name'] ?></p>
                                                      <a class="gray" href="<?= Url::to(['/course/index','slug_detail' => $val['slug_course'],'position' => $val['lesson_id']]) ?>"><i class="fas fa-caret-right mr-2 "></i>Xem bài học</a>
                                                      </div>
                                                      <div>
                                                      <textarea  name="" id="" cols="30" rows="10"><?= $val['note'] ?></textarea>
                                                      </div>
                                                </div>
                                                <?php  } ?>
                                          </div>
                                          <div class="modal-footer">
                                                <button type="button" class="btn btn-default close_modal_node" data-dismiss="modal"><i class="far fa-times-circle fz-30 text-dark"></i></button>
                                          </div>
                                    </div>
                                    </div>
                              </div>
                              
                        </div>
                  <?php }} ?>
            </div>
      </section>
   <section class="continue_lesson">
         <h2 class="fz-30 lh-30 mb-4">Khóa học yêu thích</h2>
         <div class="slider_continue_lesson">
            <?php 
                  foreach($FavoriteCourse as $item) { 
                        if($item['total_duration'] < 3600)
                              $time = gmdate("i:s", $item['total_duration']);
                        else
                              $time = gmdate("H:i:s", $item['total_duration']);      
            ?>
                  <div>
                        <a href="<?= Url::to(['/course/course-overview','slug_course' => $item['slug_course']]) ?>">
                           <div class="thumb_lesson position-relative radius_10">
                                 <img class="w-100 radius_10" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                 <span><?= $time ?></span>
                           </div>
                           <div class="mt-2">
                                 <span class="font-weight-bold"><?= $item['name_lecturer'] ?></span>
                                 <p class="fz-15"><?= $item['name_course'] ?></p>
                           </div>
                        </a>
                  </div>
            <?php } ?>
         </div>
   </section>

   <section class="continue_lesson">
         <h2 class="fz-30 lh-30 mb-4">Khóa học đã mua</h2>
         <div class="slider_continue_lesson">
            <?php 
                  foreach($my_course as $item) {
                        if($item['total_duration'] < 3600)
                              $time = gmdate("i:s", $item['total_duration']);
                        else
                              $time = gmdate("H:i:s", $item['total_duration']);
            ?>
                  <div>
                        <a href="<?= Url::to(['/course/course-overview','slug_course' => $item['slug_course']]) ?>">
                           <div class="thumb_lesson position-relative radius_10">
                                 <img class="w-100 radius_10" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                 <span><?= $time ?></span>
                           </div>
                           <div class="mt-2">
                                 <span class="font-weight-bold"><?= $item['name_lecturer'] ?></span>
                                 <p class="fz-15"><?= $item['name_course'] ?></p>
                           </div>
                        </a>
                  </div>
            <?php } ?>
         </div>
   </section>

   <section class="continue_lesson">
         <h2 class="fz-30 lh-30">Khóa học đã hoàn thành</h2>
         <p class="mb-4 gray">Chúc mừng bạn. Hãy áp dụng những kiến thức và kỹ năng đã học vào thực tiễn.</p>
         <div class="slider_continue_lesson">
            <?php 
                  foreach($course_active as $item) { 
                        if($item['total_duration'] < 3600)
                              $time = gmdate("i:s", $item['total_duration']);
                        else
                              $time = gmdate("H:i:s", $item['total_duration']);   
            ?>
                  <div>
                        <a href="<?= Url::to(['/course/course-overview','slug_course' => $item['slug_course']]) ?>">
                           <div class="thumb_lesson position-relative radius_10">
                                 <img class="w-100 radius_10" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                 <span><?= $time ?></span>
                           </div>
                           <div class="mt-2">
                                 <span class="font-weight-bold"><?= $item['name_lecturer'] ?></span>
                                 <p class="fz-15"><?= $item['name_course'] ?></p>
                           </div>
                        </a>
                  </div>
            <?php } ?>
         </div>
   </section>
   <section class="section_chungchi">
            <h2 class="fz-30 lh-30 mb-4">Chứng nhận của tôi</h2>
            <div class="list_chungchi_group">
                  <div class="list_chungchi">
                        <?php 
                              foreach($course_active as $item) { 
                                    $date = date_create($item['create_date']);
                                    $date_format = date_format($date,'\N\g\à\y d \t\h\á\n\g m \n\ă\m Y');
                        ?>
                                    <div>
                                          <img class="w-100 img_chungchi" data-toggle="modal" data-target="#modal_chungchi_<?= $item['course_id'] ?>" src="https://elearning.abe.edu.vn<?= $item['certificate'] ?>" alt="">
                                    </div>
                        <?php } ?>
                  </div>
                  <?php 
                        foreach($course_active as $item) { 
                              $date = date_create($item['create_date']);
                              $date_format = date_format($date,'\N\g\à\y d \t\h\á\n\g m \n\ă\m Y');
                  ?>
                        <div class="modal fade" id="modal_chungchi_<?= $item['course_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                                                            <span class="date_cc"><?= $date_format ?></span>
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
            </div>
       
   </section>
</div>