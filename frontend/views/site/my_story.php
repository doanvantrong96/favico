
<?php
use yii\helpers\Url;
use yii\web\View ;
$url_abe = 'https://elearning.abe.edu.vn';
?>
<link rel="stylesheet" href="/css/home.css" />

<div class="container">
   <?php if(!Yii::$app->user->isGuest) { ?>
         <seciton class="top_story">
               <div class="text_left_story">
                  <h4>HỌC VIÊN <strong>ƯU TÚ</strong></h4>
                  <span class="fz-24 font-weight-bold mb-3 d-block">CHIA SẺ CÂU CHUYỆN CỦA TÔI</span>
                  <p class="fz-18">Mỗi câu chuyện, mỗi trải nghiệm của bạn đều là món quà quý giá đối với toàn bộ mọi người. Hãy lan tỏa và chia sẻ ngay câu chuyện của bạn với chúng tôi, những câu chuyện đó có thể được giới thiệu lên các trang mạng xã hội của ABE Academy hoặc website <a href="https://elearning.abe.edu.vn">elearning.abe.edu.vn</a>.</p>
               </div>
               <div>
                  <img class="w-100 radius_10" src="/images/page/story-index.png" alt="">
               </div>
         </seciton>
         <section class="section_form_story">
               <form class="form_story" action="" onsubmit="return false">
                     <div class="group-input">
                           <label for="">Trải nghiệm tuyệt với của bạn là gì?</label>
                           <textarea id="content_st" name="content" cols="30" rows="10" placeholder="Hãy cho chúng tôi biết bạn đã làm được những gì kể từ khi tham gia abe academy"></textarea>
                     </div>
                     <div class="group-input">
                           <label for="">Bạn được truyền cảm hứng bởi (những) người hướng dẫn nào</label>
                           <input type="text" name="expert_name" placeholder="Tên chuyên gia" id="expert_name">
                     </div>
                     <div class="group-input">
                           <label for="">Nơi bạn sinh sống</label>
                           <input type="text" name="address" placeholder="Quận, Thành phố" id="province">
                     </div>
                     <div class="group-input">
                        <input type="file" name="file_story" class="file_story"> 
                        <div class="content_file_upl">
                           <img src="/images/page/upload.svg" alt="">
                           <p>Upload media</p>
                           <span class="file_name">(Không có tệp nào được chọn)</span>
                        </div>
                     </div>
                     <div class="text-center">
                           <button class="submit_story">Gửi</button>
                     </div>
               </form>
               <div>
                     <h4>Làm thế nào để tôi chia sẻ:</h4>
                     <p>Bước 1: Điền tên của bạn và cho chúng tôi biết bạn đã đạt được những gì kể từ khi tham gia ABE Academy.</p>
                     <p>Bước 2: Cung cấp thông tin liên lạc của bạn và những khóa học tâm đắc nhất.</p>
                     <p>Bước 3: Tải lên hình ảnh, video, mp3 hoặc pdf về chiến thắng của bạn. Những thành viên được chọn có thể sẽ được giới thiệu trên các mạng xã hội của ABE Academy hoặc website </p>
               </div>
         </section>
   <?php } ?>
   <section class="section_library">
         <div class="title_library">
               <h2>CÂU CHUYỆN CỘNG ĐỒNG</h2>
               <p class="fz-18">Người thật, việc thật, câu chuyện có thật. Bạn sẽ thấy chính mình trong đó</p>
               <div class="line_ins"></div>
         </div>
         <div class="list_library_story">
               <?php
                  if(!empty($result_story)) {
                     $i = 0;
                     foreach($result_story as $item) {
                        $i++;
               ?>
                  <?php 
                  $pos = strpos($item['image'], '.mp4');
                     if($pos)
                     {
                  ?>
                     <video class="w-100 img_thumb_story" data-toggle="modal" data-target="#story_modal_<?= $i ?>" src="<?= $item['image'] ?>"></video>
                  <?php }else{ ?>
                     <img class="w-100 img_thumb_story" src="<?= $item['image'] ?>" alt="" data-toggle="modal" data-target="#story_modal_<?= $i ?>">
                  <?php } ?>
                  <div class="modal fade" id="story_modal_<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="title_story" aria-hidden="true">
                     <div class="modal-dialog dialog_story" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                           </div>
                           <div class="modal-body">
                           <div class="group_story_modal">
                              <div class="text_left_story">
                                    <p class="fz-18"><?= $item['content'] ?></p>
                                    <p class="fz-14 mt-4"><?= $item['fullname'] . ' ' . $item['address'] ?>  </p>
                              </div>
                              <div>
                                 <?php 
                                    $pos = strpos($item['image'], '.mp4');
                                       if($pos)
                                       {
                                    ?>
                                    <video class="w-100" controls>
                                       <source src="<?= $item['image'] ?>" type="video/mp4">
                                    </video>
                                    <?php  
                                       }else{ 
                                    ?>
                                       <img class="w-100 radius_10 img_modal_story" src="<?= $item['image'] ?>" alt="">
                                    <?php } ?>
                              </div>
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php }} ?>
         </div>
         <?php if(count($result_story) == 8) { ?>
            <div class="text-center mt-5 mb-5">
                  <a class="see_more" href="javascript:void(0)">Xem thêm</a>
            </div> 
         <?php } ?>
   </section>
   <?php echo $this->render('/template/question_answer',['arr_ques' => $arr_ques]) ?>
</div>