<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use yii\helpers\Url;

$url_abe = 'https://elearning.abe.edu.vn';
?>

<link rel="stylesheet" href="/css/home.css" />
<div class="container">
     <section class="lecturers">
          <div class="text-center">
               <h2>DANH SÁCH CHUYÊN GIA</h2>
          </div>
          <ul class="list_lecturers">
               <?php  
                  if(!empty($result_lecturer)){
                     foreach($result_lecturer as $lec){
               ?>
                        <li>
                              <div class="slider_cour_child position-relative">
                                    <a href="<?= Url::to(['lecturers/detail','slug' => $lec['slug']]) ?>">
                                        <img class="radius_10" src="<?= $url_abe . $lec['avatar'] ?>" alt="">
                                        <div class="content_sl_cour">
                                             <div class="content_bt_cour">
                                                       <h6><?= $lec['name'] ?></h6>
                                                       <div class="line_ins mt-2 mb-1"></div>
                                                       <p class="font-weight-bold line_2"><?= $lec['office'] ?></p>
                                                       <?php /*<span><?= $lec['level'] ?></span>*/?>
                                                       <a class="detail_lec" href="<?= Url::to(['lecturers/detail','slug' => $lec['slug']]) ?>">Xem thông tin <?= !empty($lec['level']) ? $lec['level'] : 'người hướng dẫn' ?></a>
                                             </div>
                                        </div>
                                    </a>
                              </div>
                        </li>
               <?php }} ?>
          </ul>
     </section>

     <?php echo $this->render('/template/question_answer',['arr_ques' => $arr_ques]) ?>
    
</div>