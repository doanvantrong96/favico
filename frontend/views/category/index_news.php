<?php 
     use yii\helpers\Url;
     $url_abe = 'https://elearning.abe.edu.vn';

?>

<link rel="stylesheet" href="/css/news.css" />
<div class="container">
  <section class="section_news">
     <div class="group_content_news">
          <div class="top_news mb-2">
               <h1><?= $result_news['title'] ?></h1>
               <p class="fz-12 gray"><?= $result_news['source'] ?> - <?= $result_news['date_publish'] ?> - 0 COMMENT</p>
          </div>
          <div class="content_news">
               <?= $result_news['content'] ?>
          </div>
     </div>
     <div class="sidebar_news">
          <div class="title_sidebar">
               <img src="/images/page/icon-sidebar.svg" alt="">
               <p class="text-white font-weight-bold fz-20 ml-2">CÓ THỂ BẠN QUAN TÂM</p>
          </div>
          <div class="list_news_sidebar">
               <?php 
                    foreach($course_is_hot as $item) { 
                    if(!Yii::$app->user->isGuest)
                         $url_course = Url::to(['/course/course-overview','slug_course' => $item['slug']]);
                    else
                         $url_course = Url::to(['/course/index','slug_detail' => $item['slug']]);
               ?>
                    <a target="_blank" href="<?= $url_course ?>">
                         <img src="<?= $url_abe . $item['avatar'] ?>" alt="">
                         <span class="font-weight-bold mt-1"><?= $item['lecturer_name'] ?></span>
                         <p class="line_3"><?= $item['name'] ?></p>
                    </a>
               <?php } ?>
          </div>
     </div>
  </section>
  <section class="related_posts">
     <div class="box_share_news">
          <p>CHIA SẺ QUA</p>
          <div class="item_share">
               <a href="javascript::void(0)" class="position-relative">
                    <img src="/images/icon/fb.svg" alt="">
                    <iframe style="top:5px;left:-16px" class="share_fb" src="https://www.facebook.com/plugins/share_button.php?href=<?=  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>&layout=button&size=small&appId=1438665563271474&width=76&height=20" width="76" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
               </a>
               <a href="https://twitter.com/share?text=<?= $result_news['title'] ?>&url=<?= Url::to(['category/index-news','slug' => $result_news['slug'],'id' => $result_news['id']]) ?>" target="_blank">
                    <img src="/images/icon/inta.svg" alt="">
               </a>
               <!-- <a href="javascript::void(0)">
                    <img src="/images/icon/in.svg" alt="">
               </a>
               <a href="javascript::void(0)">
                    <img src="/images/icon/zl.svg" alt="">
               </a>
               <a href="javascript::void(0)">
                    <img src="/images/icon/mess.svg" alt="">
               </a>
               <a href="javascript::void(0)">
                    <img src="/images/icon/s.svg" alt="">
               </a> -->
             
          </div>
     </div>
     <?php if(!empty($result_related)) { ?>
          <div class="related_list">
               <p class="text-center mb-3">BÀI VIẾT LIÊN QUAN</p>
               <div class="group_related">
                    <?php foreach($result_related as $item) { ?>
                         <div class="item_related">
                              <a href="<?= Url::to(['category/index-news','slug' => $item['slug'],'id' => $item['id']]) ?>">
                                   <img class="w-100" src="<?= $url_abe . $item['image'] ?>" alt="">
                                   <p class="font-weight-bold mt-2"><?= $item['title'] ?></p>
                                   <span class="gray fz-12"><?= $item['date_publish'] ?></span>
                              </a>
                         </div>
                    <?php } ?>
               </div>  
          </div>
     <?php } ?>
  </section>
</div>