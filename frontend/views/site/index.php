
<?php
use yii\helpers\Url;
use yii\web\View ;

$url_abe = 'https://elearning.abe.edu.vn';
?>
<link rel="stylesheet" href="/css/home.css" />

<div class="slider_home">
   <?php 
      if(!empty($banner)) {
      foreach($banner as $val){
   ?>
      <div class="item_bn_home">
         <img src="<?= $url_abe . $val['image'] ?>" alt="">
      </div>
   <?php }} ?>
	<!-- <div>
		<img src="/images/page/imb-slide-home.png" alt="">
	</div> -->
</div>
<div class="main_page">
   <div class="container">
      <section class="contact_home text-center">
         <h4>CHÍNH HỌC MỞ TƯƠNG LAI</h4>
         <p>Nhập email để nhận thông tin, tài liệu và những ưu đãi hấp dẫn dành riêng cho bạn</p>
         <form action="<?= Url::to('site/save-email-offer');?>">
            <input type="text" placeholder="Email của bạn" name="email" class="email_offer">
            <button type="button" id="send_mail">Gửi</button>
         </form>
         <div class="line_gr"></div>
      </section>
      
      <section class="inspired text-center">
         <?php 
            if(!empty($course_hot_big)){
         ?>
               <div class="text_ins">
                  <h2>KHÓA HỌC ĐƯỢC QUAN TÂM NHẤT</h2>
                  <p><?= $course_hot_big['description'] ?></p>
               </div>
               <div class="inspired_content position-relative">
                  <img class="w-100" src="<?= $url_abe . $course_hot_big['avatar'] ?>" alt="">
                  <div class="ins_info">
                     <span><?= $course_hot_big['lecturer_name'] ?></span>
                     <div class="line_ins"></div>
                     <p><?= $course_hot_big['name'] ?></p>
                     <a href="<?= Url::to(['/course/index','slug_detail' => $course_hot_big['slug']]) ?>"><i class="fas fa-caret-right"></i> Xem Trailer</a>
                  </div>
               </div>

         <?php } ?>
      </section>

      <section class="partner text-center mt-4">
         <h2>ĐỐI TÁC TIÊU BIỂU</h2>
         <div class="logo_par">
            <?php 
               if(!empty($partner)){
                  foreach($partner as $item){
            ?>
                     <img src="<?= $url_abe . $item['image'] ?>" alt="">

            <?php }} ?>
         </div>
      </section>

      <section class="featured_course overlay_left_right">
         <h2>Khóa học nổi bật</h2>
         <div class="slider_cour">
            <?php 
               if(!empty($course_is_hot)){ 
                  foreach($course_is_hot as $item){
                     $time = $item['total_duration'];
                     $hours = floor($time / 3600);
                     $minutes = floor(($time / 60) % 60);
                     $seconds = $time % 60;
                     if($hours > 0)
                          $result = $hours.'giờ '.$minutes.'phút ';
                     else
                          $result = $minutes.' phút';
            ?>
                     <div class="slider_cour_child position-relative">
                        <a href="<?= Url::to(['/course/index','slug_detail' => $item['slug']]) ?>">
                           <img class="radius_10" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                           <div class="content_sl_cour">
                              <span class="sp_cour">Mới</span>
                              <div class="content_bt_cour tran_x0">
                                 <h6><?= $item['lecturer_name'] ?></h6>
                                 <div class="line_ins mt-2 mb-1"></div>
                                 <p class="font-weight-bold line_2"><?= $item['name'] ?></p>
                                 <span><?= $result ?></span>
                              </div>
                           </div>
                        </a>
                     </div>

            <?php }} ?>
         </div>
         <div class="mc-carousel__peek--before" style="background: linear-gradient(to right, rgb(0, 0, 0) 0px, rgb(0, 0, 0) 16px, rgba(0, 0, 0, 0) 100%) center center no-repeat;"></div>
         <div class="mc-carousel__peek--after" style="background: linear-gradient(to left, rgb(0, 0, 0) 0px, rgb(0, 0, 0) 16px, rgba(0, 0, 0, 0) 100%) center center no-repeat;"></div>
      </section>

      <section class="coming_course overlay_left_right">
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
         <div class="mc-carousel__peek--before" style="background: linear-gradient(to right, rgb(0, 0, 0) 0px, rgb(0, 0, 0) 16px, rgba(0, 0, 0, 0) 100%) center center no-repeat;"></div>
         <div class="mc-carousel__peek--after" style="background: linear-gradient(to left, rgb(0, 0, 0) 0px, rgb(0, 0, 0) 16px, rgba(0, 0, 0, 0) 100%) center center no-repeat;"></div>
      </section>

      <section class="coming_course overlay_left_right">
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
         <div class="mc-carousel__peek--before" style="background: linear-gradient(to right, rgb(0, 0, 0) 0px, rgb(0, 0, 0) 16px, rgba(0, 0, 0, 0) 100%) center center no-repeat;"></div>
         <div class="mc-carousel__peek--after" style="background: linear-gradient(to left, rgb(0, 0, 0) 0px, rgb(0, 0, 0) 16px, rgba(0, 0, 0, 0) 100%) center center no-repeat;"></div>
      </section>

      <section class="story">
         <div class="title_story text-center w-50">
            <h2>Học viên nói gì về ABE</h2>
         </div>
         <div class="slider_story">
            <?php
               if(!empty($result_story)) {
                  foreach($result_story as $story) {
            ?>
                     <div>
                        <div class="group_sl_story">
                           <div class="text_story">
                              <img src="/images/home/“.svg" alt="">
                              <img class="img_story_mb d-lg-none d-block" src="<?= $url_abe . $story['image'] ?>" alt="">
                              <p class="fz-20"><?= $story['content'] ?></p>
                              <div class="line_ins"></div>
                              <span><?= $story['address'] ?></span>
                           </div>
                           <div class="img_story">
                              <img class="radius_10" src="<?= $url_abe . $story['image'] ?>" alt="">
                           </div>
                        </div>
                     </div>
            <?php }} ?>
         </div>
      </section>

      <?php echo $this->render('/template/question_answer',['arr_ques' => $arr_ques]) ?>
      
   </div>
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