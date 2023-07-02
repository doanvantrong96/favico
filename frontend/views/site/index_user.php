<?php
use yii\helpers\Url;
use yii\web\View ;

$url_abe = 'https://elearning.abe.edu.vn';

?>
<link rel="stylesheet" href="/css/home.css" />
<link rel="stylesheet" href="/css/videojs-hls-player.css" />

<script src="/js/video.js"></script>
<script src="/js/videojs-http-streaming.js"></script>
<script src="/js/videojs-contrib-quality-levels.min.js"></script>
<script src="/js/videojs-hls-quality-selector.min.js"></script>

<div class="box_top_userindex">
     <?php if(!empty($course_is_hot)) { ?>
          <div class="slide_video_index_us">
               <?php foreach($course_is_hot as $item) { ?>
                    <div>
                         <div class="item_sl_vd">
                              <div class="left_b_us">
                                   <div class="text_top_us text-center">
                                        <h2 class="text-uppercase"><?= $item['lecturer_name'] ?></h2>
                                        <div class="line_ins"></div>
                                        <p class="fz-20"><?= $item['name'] ?></p>
                                   </div>
                                   <div class="action_us">
                                   <div class="buy_now_box">
                                        <?php if(!in_array($item['id'], $list_id_course_user)) { ?>
                                                  <a href="javascript::void(0)" id-course="<?= $item['id'] ?>" class="view_course buy_now"><i class="fas fa-caret-right fz-26 mr-2"></i>Mua ngay</a>
                                                  <a href="javascript::void(0)" id="add_cart" class="add_cart btn_us" id-course="<?= $item['id'] ?>"><img src="/images/page/Cart.svg" alt=""></a>
                                             <?php }else{ ?>
                                                  <a href="<?= Url::to(['/course/index','slug_detail' => $item['slug']]) ?>" class="view_course"><i class="fas fa-caret-right fz-26 mr-2"></i>Xem ngay</a>
                                             <?php } ?>
                                             <a href="javascript::void(0)" cour-id="<?= $item['id'] ?>" class="plus_button btn_us">
                                                  <?php if((isset($list_fa[$item['id']]))) { ?>
                                                       <img src="/images/page/done.png" alt="">
                                                  <?php }else{ ?>
                                                       <img src="/images/page/Layer_3.svg" alt="">
                                                  <?php } ?>
                                             </a>
                                             <a href="javascript:void(0)" class="share_button btn_us position-relative">
                                                  <img src="/images/page/action-2.svg" alt="">
                                                  <iframe class="share_fb" src="https://www.facebook.com/plugins/share_button.php?href=<?= $url_abe . Url::to(['/course/index','slug_detail' => $item['slug']]) ?>&layout=button&size=small&appId=1438665563271474&width=76&height=20" width="76" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                                             </a>
                                   </div>
                                   </div>
                              </div>
                              <div class="banner_right_user">
                                   <?php 
                                        $useragent=$_SERVER['HTTP_USER_AGENT'];
                                        if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
                                        {
                                    ?>
                                        <video class="video-js vjs-default-skin trailer_index d-none d-lg-block" width="640px" height="590px"
                                             controls preload="none" autoplay muted loop playsinline poster=''
                                             data-setup='{ "aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>
                                             <source src="<?= $url_abe . $item['trailer'] ?>" type='video/mp4' />
                                        </video>
                                   <?php }else{ ?>
                                        <video class="trailer_index d-block d-lg-none" width="100%" height="100%"
                                             controls preload="none" autoplay muted loop playsinline poster=''>
                                             <source src="<?= $url_abe . $item['trailer'] ?>" type='video/mp4' />
                                        </video>
                                   <?php } ?>
                              </div>
                         </div>
                    </div>
               <?php } ?>
          </div>
     <?php } ?>
</div>
<div class="container container_user_index">
     <?php if(!empty($result_continue)) { ?>
          <section class="continue_lesson continue_section">
               <h2 class="fz-30">Tiếp tục xem</h2>
               <div class="slider_continue_lesson">
                    <?php
                         $i = 0;
                         foreach($result_continue as $item){
                              $i++;
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
                    <?php } ?>
               </div>
          </section>
     <?php } ?>
     <?php if(!empty($course_lesson_all)) { ?>
          <section class="invitation_abe">
               <h2 class="fz-30">Khóa học mới</h2>
               <div class="slider_continue_lesson">
                         <?php
                              foreach($course_lesson_all as $item){
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
                                        <span class="font-weight-bold fz-16"><?= $item['name_lecturer'] ?></span>
                                        <p class="fz-14 line_2"><?= $item['name'] ?></p>
                                        <p class="fz-14 line_3 grays"><?= $item['description'] ?></p>
                                   </div>
                              </a>
                         </div>
                    <?php } ?>
               </div>
          </section>
     <?php } ?>

     <section class="coming_course">
          <h2>Khoá học sắp diễn ra <a class="see_more_cour" href="<?= Url::to(['/category/index','slug' => 'sap-dien-ra']) ?>">Xem thêm</a></h2>
         <div class="slider_comming">
            <?php 
               if(!empty($course_is_coming)) { 
                  foreach($course_is_coming as $com) {   
            ?>
                     <div class="slider_coming_child position-relative">
                        <a href="<?= Url::to(['/course/index','slug_detail' => $com['slug']]) ?>">
                           <img class="radius_10" src="<?= $url_abe . $com['avatar'] ?>" alt="">
                           <div class="content_sl_cour">
                              <span class="sp_cour">UPCOMING</span>
                              <div class="content_bt_cour tran_x0 text_sl_index text-left pl-3">
                                 <h6><?= $com['lecturer_name'] ?></h6>
                                 <p><?= $com['name'] ?></p>
                              </div>
                           </div>
                        </a>
                     </div>
            <?php }} ?>
         </div>
      </section>

      <section class="coming_course">
         <h2>Sự kiện nổi bật</h2>
         <div class="slider_comming">
            <?php
               if(!empty($result_new_hot)){ 
                  foreach($result_new_hot as $new){
            ?>
                     <div class="slider_coming_child position-relative">
                        <a href="<?= Url::to(['category/index-news','slug' => $new['slug'],'id' => $new['id']]) ?>">
                           <img class="radius_10" src="<?= $url_abe . $new['image'] ?>" alt="">
                           <div class="content_sl_cour">
                              <div class="content_bt_cour tran_x0 text_sl_index text-left pl-3">
                                 <h6 class="line_2 title_post_index"><?= $new['title'] ?></h6>
                              </div>
                           </div>
                        </a>
                     </div>

            <?php }} ?>
         </div>
      </section>

     <section class="membership">
          <h2>Quyền thành viên</h2>
          <div class="memvership_group">
               <div class="member_left">
                    <div class="w-50">
                         <p>HỌC VIÊN <strong>ƯU TÚ</strong></p>
                         <span>Cho đi càng nhiều, chiến thắng càng lớn <br> Chia sẻ trải nghiệm của bạn cho người khác</span>
                         <a href="<?= Url::to(['site/my-story']) ?>">Chia sẻ ngay</a>
                    </div>
                    <div class="w-50">
                         <img class="w-100" src="/images/page/story-index.png" alt="">
                    </div>
               </div>
               <div class="member_right">
                    <span class="font-weight-bold text-dark">DÀNH CHO BẠN</span>
                    <div class="line_ins"></div>
                    <p class="font-weight-bold text-dark">Bạn đã sẵn sàng học những điều mới chưa? Đây là những lớp học bạn không muốn bỏ qua</p>
                    <a class="font-weight-bold" href="<?= Url::to(['category/index']) ?>">Khám phá ngay </a>
               </div>
          </div>
          <div class="sear_home">
               <img src="/images/home/sear-home.svg" alt="">
               <span class="font-weight-bold">Tìm kiếm thêm?</span>
               <p class="fz-20">Mở rộng tâm trí của bạn. Xem hàng nghìn bài học từ những người giỏi nhất thế giới.</p>
               <a class="fz-20 font-weight-bold" href="<?= Url::to(['category/index']) ?>">Đi tới thư viện</a>
          </div>
     </section>
</div>
<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<!-- Modal -->
<div class="modal fade" id="warning_mobi" tabindex="-1" role="dialog" aria-labelledby="warning_mobi" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background:unset">
      <div class="modal-body text-center">
        <img class="w-100" src="/images/page/thumnnail.png" alt="">
        <p class="text-white mt-3 fz-14">Sử dụng máy tính truy cập website để có trải nghiệm học tập tốt nhất trên nền tàng ABE Academy</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_close_warning" data-dismiss="modal">Tôi đã hiểu</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
