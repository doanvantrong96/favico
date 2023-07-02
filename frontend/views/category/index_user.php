<?php 
use yii\helpers\Url;
$url_abe = 'https://elearning.abe.edu.vn';

?>
<link rel="stylesheet" href="/css/home.css" />
<link rel="stylesheet" href="/css/category.css" />
<link rel="stylesheet" href="/css/course.css" />

<div class="container container_user_index">
     <div class="search_cat position-relative">
          <div class="search-panel search-pane_cat">
               <div class="input-wrapper">
               <i class="far fa-search text-white"></i>
               <input type="text" id="input-search" autocomplete="off" placeholder="Tìm chuyên gia, lớp học, chủ đề" value="" />
               </div>
               <div class="search-results" style="display: none;">
               <ul class="course-list"></ul>
               </div>
               <div class="result_search_default">
               <ul class="list_search_default list_search_default_cat">
                    <?php foreach($cat_course as $item) { ?>
                    <li>
                         <a href="<?= Url::to(['/category/index','slug' => $item['slug']]) ?>"> 
                              <p><?= $item['name'] ?></p>
                              <i class="fas fa-chevron-right"></i>
                         </a>
                    </li>
                    <?php } ?>
               </ul>
               </div>
          </div>
     </div>
     <section class="type_cat">
          <h2>Danh mục</h2>
          <div class=" list_type_cat">
               <?php 
                    foreach($course_category as $item) { 
                         if(isset($_GET['slug']) && $_GET['slug'] == $item['slug'])
                              $active = 'active';          
                         else 
                              $active = '';
               ?>
                    <div>
                         <a class="<?= $active ?>" href="<?= Url::to(['category/index','slug' => $item['slug']]) ?>">
                              <img src="<?= $url_abe . $item['image'] ?>" alt="">
                              <p><?= $item['name'] ?></p>
                         </a>
                    </div>
               <?php } ?>
          </div>
     </section>
     <section class="section_cat">
          <div class="cat_content_user">
               <!-- <div class="cat_sidebar">
                    <h2 class="fz-24 mb-0">BỘ LỌC</h2>
                    <div class="cat_list_bar">
                         <div class="show_hide_filter">
                              <p class="fz-18 font-weight-bold">Định dạng</p>
                              <i class="fas fa-angle-up"></i>
                         </div>
                         <div class="content_filter active">
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                         </div>
                    </div>
                    <div class="cat_list_bar">
                         <div class="show_hide_filter">
                              <p class="fz-18 font-weight-bold">Nội dung của tôi</p>
                              <i class="fas fa-angle-down"></i>
                         </div>
                         <div class="content_filter">
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                         </div>
                    </div>
                    <div class="cat_list_bar">
                         <div class="show_hide_filter">
                              <p class="fz-18 font-weight-bold">Thời lượng</p>
                              <i class="fas fa-angle-down"></i>
                         </div>
                         <div class="content_filter">
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                              <div class="position-relative d-flex align-items-center">
                                   <span class="checkbox_cus_show"></span>
                                   <input type="checkbox" class="ip_checkbox">
                                   <p>Các lớp học</p>
                              </div>
                         </div>
                    </div>
               </div> -->
               <?php if(!empty($data_course)) { ?>
                    <div class="cat_list_user">
                         <?php foreach($data_course as $item) { ?>
                              <div class="item_cat_user">
                                   <a href="<?= Url::to(['course/course-overview','slug_course' => $item['slug']]) ?>">
                                        <div class="overflow-hidden">
                                             <img class="w-100" src="<?= $url_abe . $item['avatar'] ?>" alt="">
                                        </div>
                                        <span class="fz-14 my-2 d-block"><?= $item['name'] ?></span>
                                        <h4 class="fz-18"><?= $item['lecturer_name'] ?></h4>
                                        <p class="line_2"><?= $item['description'] ?></p>
                                   </a>
                              </div>
                         <?php }
                         ?>
                    </div>
               <?php } ?>
          </div>
     </section>
</div>