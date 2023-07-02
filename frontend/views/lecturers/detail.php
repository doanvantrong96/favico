<?php 
use yii\helpers\Url;
use frontend\controllers\LecturersController;

$url_abe = 'https://elearning.abe.edu.vn';

?>

<link rel="stylesheet" href="/css/home.css" />
<div class="poster_lear position-relative">
     <?php if(!empty($lecturer['trailer'])) { ?>
          <video id="trailer_lecturer" autoplay muted height="600" controlslist="nodownload" controls="controls" preload="none" playsinline class="w-100 video_ video_main">
               <source id="source_video" src="<?= $url_abe . $lecturer['trailer'] ?>" type="video/mp4" />
          </video>
     <?php }else{ ?>
          <img class="w-100 avatar_lec" src="<?= $url_abe . $lecturer['cover'] ?>" alt="">
     <?php } ?>
     <div class="info_lear">
          <div class="d-flex group_info_lear">
               <h4><?= $lecturer['name'] ?></h4>
               <div class="line_ins"></div>
               <span class="fz-20 font-weight-bold mb-2"><?= $lecturer['office'] ?></span>
               <p class="fz-18 lh-30"><?= $lecturer['description'] ?></p>
          </div>
     </div>
</div>
<div class="container">
     <section class="lesson">
          <ul class="list_lesson">
               <?php 
                  if(!empty($course_lecturer)){
                     foreach($course_lecturer as $item){
                         $time = LecturersController::actionFormatDate($item['total_duration']);
                         $cat = array_filter(explode(';',$item['category_id']));
               ?>
                        <li>
                              <a href="<?= Url::to(['/course/course-overview','slug_course' => $item['slug']]) ?>">
                                    <img class="w-100" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                    <span class="fz-14 mt-2 d-block">Lớp học • <?= $time . ' • ' . $arr_category[$cat[1]] ?></span>
                                    <h4 class="fz-18 mt-2"><?= $lecturer['name'] ?></h4>
                                    <p class="line_3"><?= $item['name'] ?></p>
                              </a>
                        </li>
               <?php }} ?>
          </ul>
     </section>

     <?php echo $this->render('/template/question_answer',['arr_ques' => $arr_ques]) ?>

</div>