
<?php
use yii\helpers\Url;
use yii\web\View ;
?>
<section class="banner_home slideshow">
   <div class="banner_home_gr slider">
      <?php 
         if(!empty($result_banner)){ 
         foreach($result_banner as $row) {
         ?>
      <div class="item">
         <img src="<?= $row['image'] ?>" alt="">
      </div>
      <?php }} ?>
   </div>
</section>

<section class="partner">
   <div class="container">
      <div class="partner_group">
      <?php 
         if(!empty($result_partner)){ 
         foreach($result_partner as $row) {
      ?>
            <img src="<?= $row['image'] ?>" alt="">
      <?php }} ?>
      </div>
      <!-- <img src="/images/page/partner.png" alt=""> -->
   </div>
</section>

<section class="introduce bg_gray">
   <div class="elementor-section elementor-top-section elementor-element elementor-element-15e41dd6 elementor-section-full_width nt-section section-padding elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="15e41dd6" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
      <div class="elementor-container elementor-column-gap-no">
         <div class="elementor-row">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-766b9302" data-id="766b9302" data-element_type="column">
               <div class="elementor-column-wrap elementor-element-populated">
                  <div class="elementor-widget-wrap">
                     <div class="elementor-section elementor-inner-section elementor-element elementor-element-17e9c59d elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="17e9c59d" data-element_type="section">
                        <div class="elementor-container elementor-column-gap-no">
                           <div class="elementor-row">
                              <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-3e3a0b56" data-id="3e3a0b56" data-element_type="column">
                                 <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                       <div class="elementor-element elementor-element-7ef93fa1 elementor-widget elementor-widget-image" data-id="7ef93fa1" data-element_type="widget" data-widget_type="image.default">
                                          <div class="elementor-widget-container">
                                             <div class="elementor-image flex-center gap-20">
                                                <div class="bd-logo"></div>
                                                <img data-lazyloaded="1" src="/images/page/logo-green.svg">
                                                <div class="bd-logo"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="elementor-element elementor-element-72e24671 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="72e24671" data-element_type="widget" data-widget_type="heading.default">
                                          <div class="elementor-widget-container">
                                             <p class="elementor-heading-title elementor-size-default">CHÀO MỪNG ĐẾN VỚI PHAVICO</p>
                                          </div>
                                       </div>
                                       <div class="elementor-element elementor-element-1191b8c1 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="1191b8c1" data-element_type="widget" data-widget_type="heading.default">
                                          <div class="elementor-widget-container">
                                             <h3 class="elementor-heading-title elementor-size-default">Giới Thiệu Về Chúng Tôi</h3>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="elementor-section elementor-inner-section elementor-element elementor-element-6c22f2bb elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="6c22f2bb" data-element_type="section">
                        <div class="elementor-container elementor-column-gap-default">
                           <div class="elementor-row">

                              <?php 
                                 if(!empty($result_about)) {
                                    foreach($result_about as $row) {
                              ?>

                              <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-742bbd6" data-id="742bbd6" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                 <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-background-overlay"></div>
                                    <div class="elementor-widget-wrap">
                                       <div class="elementor-element elementor-element-623cca6 elementor-widget elementor-widget-agrikon-services-item" data-id="623cca6" data-element_type="widget" data-widget_type="agrikon-services-item.default">
                                          <div class="elementor-widget-container">
                                             <div class="service-two__card">
                                                <div class="service-two__card-image">
                                                   <img data-lazyloaded="1" src="<?= $row['image'] ?>" class="s-img entered litespeed-loaded" alt="">
                                                </div>
                                                <div class="service-two__card-content">
                                                   <div class="service-two__card-icon">
                                                      <img src="<?= $row['avatar'] ?>" alt="">
                                                   </div>
                                                   <h3 class="title"><a href="javascript:;" target="_blank"><?= $row['title'] ?></a></h3>
                                                   <div class="content_about_home">
                                                      <?= $row['content'] ?>
                                                      <!-- <ul class="text-left ul_cont">
                                                         <li>Trung thực & chính trực</li>
                                                         <li>Làm việc chăm chỉ & liên tục trau dồi bản thân</li>
                                                         <li>Chuyên nghiệp trong mọi hành xử.</li>
                                                         <li>Khuyến khích sự sáng tạo & năng lực cá nhân.</li>
                                                         <li>Lợi nhuận xuất phát từ những lợi ích hướng tới cộng đồng..</li>
                                                      </ul> -->
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <?php }} ?>


                              <!-- <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-f911da4" data-id="f911da4" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                 <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-background-overlay"></div>
                                    <div class="elementor-widget-wrap">
                                       <div class="elementor-element elementor-element-da6e410 elementor-widget elementor-widget-agrikon-services-item" data-id="da6e410" data-element_type="widget" data-widget_type="agrikon-services-item.default">
                                          <div class="elementor-widget-container">
                                             <div class="service-two__card">
                                                <div class="service-two__card-image">
                                                   <img data-lazyloaded="1" src="/images/page/gt2.png" class="s-img entered litespeed-loaded" alt="">
                                                </div>
                                                <div class="service-two__card-content">
                                                   <div class="service-two__card-icon">
                                                      <img src="/images/page/p2.svg" alt="">
                                                   </div>
                                                   <h3 class="title"><a href="https://ninetheme.com/themes/agrikon/home-shop/#0" target="_blank">Tầm Nhìn</a></h3>
                                                   <ul class="text-left ul_cont">
                                                      <li> Kiến tạo vị thế là một doanh nghiệp sản xuất & cung ứng những sản phẩm - giải pháp - dịch vụ trong ngành thức ăn chăn nuôi Top 1 Việt Nam</li>
                                                      <li>Định vị thương hiệu là một doanh nghiệp mạnh - uy tín trong & ngoài nước, phụng sự xã hội vì một cộng đồng nông nghiệp Việt Nam thịnh vượng.</li>
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-dcacfbb" data-id="dcacfbb" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                 <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-background-overlay"></div>
                                    <div class="elementor-widget-wrap">
                                       <div class="elementor-element elementor-element-b0cdc9a elementor-widget elementor-widget-agrikon-services-item" data-id="b0cdc9a" data-element_type="widget" data-widget_type="agrikon-services-item.default">
                                          <div class="elementor-widget-container">
                                             <div class="service-two__card">
                                                <div class="service-two__card-image">
                                                   <img data-lazyloaded="1" src="/images/page/gt3.png" class="s-img entered litespeed-loaded" alt="">
                                                </div>
                                                <div class="service-two__card-content">
                                                   <div class="service-two__card-icon">
                                                      <img src="/images/page/p3.svg" alt="">
                                                   </div>
                                                   <h3 class="title"><a href="https://ninetheme.com/themes/agrikon/home-shop/#0" target="_blank">Sứ Mệnh</a></h3>
                                                   <ul class="text-left ul_cont">
                                                      <li>Trở thành nhà sản xuất top 1 Việt Nam về sản lượng - dẫn đầu về chất lượng trên nền tảng thương hiệu văn hóa.</li>
                                                      <li>Kiến tạo năng lực đầy đủ & toàn diện hoạt động trong chuỗi giá trị nông nghiệp Việt Nam, kết nối & hội nhập cùng khu vực.</li>
                                                      <li>Thúc đẩy việc thay đổi tư duy trong lĩnh vực sản xuất thức ăn chăn nuôi tại Viêt Nam – bền vững – khoa học – kinh tế.</li>
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>






<section  data-agrikon-parallax="{&quot;type&quot;:&quot;scroll&quot;,&quot;speed&quot;:&quot;0.6&quot;,&quot;imgsize&quot;:&quot;cover&quot;,&quot;imgsrc&quot;:&quot;/images/page/ta1.png&quot;,&quot;mobile&quot;:&quot;&quot;}" class="w-100-mb elementor-section elementor-top-section elementor-element elementor-element-829ce47 elementor-section-height-min-height elementor-section-stretched agrikon-parallax jarallax parallax-yes elementor-section-boxed elementor-section-height-default elementor-section-items-middle nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="829ce47" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}" style="z-index: 0; background-image: none; width: 1903px; left: 0px;">
   <div class="elementor-container elementor-column-gap-default">
      <div class="elementor-row">
         <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-fe1f65a" data-id="fe1f65a" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
               <div class="elementor-widget-wrap">
                  <div class="elementor-element elementor-element-198b509 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="198b509" data-element_type="widget" data-widget_type="heading.default">
                     <div class="elementor-widget-container">
                        <h2 class="elementor-heading-title elementor-size-default h2_paral"><a href="/">Thức ăn gia cầm</a></h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section  data-agrikon-parallax="{&quot;type&quot;:&quot;scroll&quot;,&quot;speed&quot;:&quot;0.6&quot;,&quot;imgsize&quot;:&quot;cover&quot;,&quot;imgsrc&quot;:&quot;/images/page/ta2.png&quot;,&quot;mobile&quot;:&quot;&quot;}" class="w-100-mb elementor-section elementor-top-section elementor-element elementor-element-fef4d01 elementor-section-height-min-height elementor-section-stretched agrikon-parallax jarallax parallax-yes elementor-section-boxed elementor-section-height-default elementor-section-items-middle nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="fef4d01" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}" style="z-index: 0; background-image: none; width: 1903px; left: 0px;">
   <div class="elementor-container elementor-column-gap-default">
      <div class="elementor-row">
         <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-e8d699f" data-id="e8d699f" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
               <div class="elementor-widget-wrap">
                  <div class="elementor-element elementor-element-b086d94 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="b086d94" data-element_type="widget" data-widget_type="heading.default">
                     <div class="elementor-widget-container">
                        <h2 class="elementor-heading-title elementor-size-default h2_paral"><a href="/">Thức ăn gia súc</a></h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section  data-agrikon-parallax="{&quot;type&quot;:&quot;scroll&quot;,&quot;speed&quot;:&quot;0.6&quot;,&quot;imgsize&quot;:&quot;cover&quot;,&quot;imgsrc&quot;:&quot;/images/page/ta3.png&quot;,&quot;mobile&quot;:&quot;&quot;}" class="w-100-mb elementor-section elementor-top-section elementor-element elementor-element-cdd42d8 elementor-section-height-min-height elementor-section-stretched agrikon-parallax jarallax parallax-yes elementor-section-boxed elementor-section-height-default elementor-section-items-middle nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="cdd42d8" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}" style="z-index: 0; background-image: none; width: 1903px; left: 0px;">
   <div class="elementor-container elementor-column-gap-default">
      <div class="elementor-row">
         <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a70a710" data-id="a70a710" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
               <div class="elementor-widget-wrap">
                  <div class="elementor-element elementor-element-60fab01 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="60fab01" data-element_type="widget" data-widget_type="heading.default">
                     <div class="elementor-widget-container">
                        <h2 class="elementor-heading-title elementor-size-default h2_paral"><a href="/">Thức ăn hải sản</a></h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section data-agrikon-parallax="{&quot;type&quot;:&quot;scroll&quot;,&quot;speed&quot;:&quot;0.6&quot;,&quot;imgsize&quot;:&quot;cover&quot;,&quot;imgsrc&quot;:&quot;https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/bg10.jpg&quot;,&quot;mobile&quot;:&quot;&quot;}" class="elementor-section elementor-top-section elementor-element elementor-element-829ce47 elementor-section-height-min-height elementor-section-stretched agrikon-parallax jarallax parallax-yes elementor-section-boxed elementor-section-height-default elementor-section-items-middle nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="829ce47" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}" style="z-index: 0; background-image: none; width: 390px; left: 0px;"><div class="elementor-container elementor-column-gap-default"><div class="elementor-row"><div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-fe1f65a" data-id="fe1f65a" data-element_type="column"><div class="elementor-column-wrap elementor-element-populated"><div class="elementor-widget-wrap"><div class="elementor-element elementor-element-198b509 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="198b509" data-element_type="widget" data-widget_type="heading.default"><div class="elementor-widget-container"><h2 class="elementor-heading-title elementor-size-default"><a href="https://ninetheme.com/themes/agrikon/shop/">Vegetables</a></h2></div></div></div></div></div></div></div><div id="jarallax-container-0" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; z-index: -100;"><img src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/bg10.jpg" style="object-fit: cover; object-position: 50% 50%; max-width: none; position: absolute; top: 0px; left: 0px; width: 390px; height: 481.6px; overflow: hidden; pointer-events: none; transform-style: preserve-3d; backface-visibility: hidden; will-change: transform, opacity; margin-top: 181.2px; transform: translate3d(0px, -229.425px, 0px);"></div></section>

<section class="introduce">
   <div class="elementor-section prod_gr elementor-top-section elementor-element elementor-element-15e41dd6 elementor-section-full_width nt-section section-padding elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="15e41dd6" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
      <div class="elementor-container elementor-column-gap-no">
         <div class="elementor-row">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-766b9302" data-id="766b9302" data-element_type="column">
               <div class="elementor-column-wrap elementor-element-populated">
                  <div class="elementor-widget-wrap">
                     <div class="elementor-section elementor-inner-section elementor-element elementor-element-17e9c59d elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="17e9c59d" data-element_type="section">
                        <div class="elementor-container elementor-column-gap-no">
                           <div class="elementor-row">
                              <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-3e3a0b56" data-id="3e3a0b56" data-element_type="column">
                                 <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                       <div class="elementor-element elementor-element-7ef93fa1 elementor-widget elementor-widget-image" data-id="7ef93fa1" data-element_type="widget" data-widget_type="image.default">
                                          <div class="elementor-widget-container">
                                             <div class="elementor-image flex-center gap-20">
                                                <div class="bd-logo"></div>
                                                <img data-lazyloaded="1" src="/images/page/logo-green.svg">
                                                <div class="bd-logo"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="elementor-element elementor-element-72e24671 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="72e24671" data-element_type="widget" data-widget_type="heading.default">
                                          <div class="elementor-widget-container">
                                             <p class="elementor-heading-title elementor-size-default">Hệ Thống Sản Phẩm</p>
                                          </div>
                                       </div>
                                       <div class="elementor-element elementor-element-1191b8c1 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="1191b8c1" data-element_type="widget" data-widget_type="heading.default">
                                          <div class="elementor-widget-container">
                                             <h3 class="elementor-heading-title elementor-size-default">Mang các dòng sản phẩm tốt nhất cho trang trại của bạn.</h3>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="list_product_home container">
                        <?php 
                           if(!empty($product_most)) {
                              foreach($product_most as $row) {
                        ?>
                           <div class="item_product_home text-center">
                              <div class="thumb_prod">
                                 <img src="<?= $row['image'] ?>" alt="">
                              </div>
                              <div class="more_prod">
                                 <p><?= $row['title'] ?></p>
                                 <a href="<?= Url::to(['/product/detail','slug' => $row['slug'],'id' => $row['id']]) ?>" class="flex-center">Xem tiếp</a>
                              </div>
                           </div>
                        <?php }} ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="media">
   <div class="container">
      <h2>Truyền Thông Phavico</h2>
      <div class="media_grid">
         <div class="media_left">
            <a href="<?= Url::to(['/news/detail','slug' => $post[0]['slug'],'id' => $post[0]['id']]) ?>">
               <img src="/images/page/media1.png" alt="">
               <span><?= $post[0]['title'] ?></span>
               <p class="line_2"><?= $post[0]['description'] ?></p>
            </a>
         </div>
         <div class="media_right">
            <?php 
               unset($post[0]);
               foreach($post as $row) {
            ?>
               <a href="<?= Url::to(['/news/detail','slug' => $row['slug'],'id' => $row['id']]) ?>">
                  <img src="<?= $row['image'] ?>" alt="">
                  <p><?= $row['title'] ?></p>
               </a>
            <?php } ?>
         </div>
      </div>
   </div>
</section>

<section class="map">
   <div class="container">
      <div class="map_gr">
         <div class="map_left position-relative">
            <img src="/images/page/map.png" alt="">
            <div class="item_map map_1">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_2">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_3">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_4">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_5">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_6">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_7">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_8">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_9">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_10">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
            <div class="item_map map_11">
               <img src="/images/icon/ic-map.svg" alt="">
            </div>
         </div>
         <div class="map_right">
            <h4>MẠNG LƯỚI PHÂN BỐ</h4>
            <p class="mb-5">Phavico hiện nay đã được phân bố & bao phủ khắp <br> các tỉnh thành trên toàn quốc!</p>
            <div class="grid_map_right">
               <img src="/images/page/icon-map2.png" alt="">
               <div class="text_map_right">
                  <span>VĂN PHÒNG ĐẠI DIỆN:</span>
                  <p>Địa chỉ: TT 12-04, Khu 31ha, Thị trấn Trâu Quỳ, Gia Lâm, Hà Nội</p>
               </div>
            </div>
            <div class="grid_map_right">
               <img src="/images/page/icon-map1.png" alt="">
               <div class="text_map_right">
                  <span>NHÀ MÁY SẢN XUẤT:</span>
                  <p class="mb-2">Nhà máy 1: An Lạc, Trưng Trắc, Văn Lâm, Hưng Yên</p>
                  <p>Nhà máy 2: Km7, Quốc lộ 39, thị trấn Yên Mỹ, H. Yên Mỹ, Hưng Yên</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="tech">
   <div class="elementor-section elementor-top-section elementor-element elementor-element-15e41dd6 elementor-section-full_width nt-section section-padding elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="15e41dd6" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
      <div class="elementor-container elementor-column-gap-no">
         <div class="elementor-row">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-766b9302" data-id="766b9302" data-element_type="column">
               <div class="elementor-column-wrap elementor-element-populated">
                  <div class="elementor-widget-wrap">
                     <div class="elementor-section elementor-inner-section elementor-element elementor-element-17e9c59d elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="17e9c59d" data-element_type="section">
                        <div class="elementor-container elementor-column-gap-no">
                           <div class="elementor-row">
                              <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-3e3a0b56" data-id="3e3a0b56" data-element_type="column">
                                 <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                       <div class="elementor-element elementor-element-7ef93fa1 elementor-widget elementor-widget-image" data-id="7ef93fa1" data-element_type="widget" data-widget_type="image.default">
                                          <div class="elementor-widget-container">
                                             <div class="elementor-image flex-center gap-20">
                                                <div class="bd-logo"></div>
                                                <img data-lazyloaded="1" src="/images/page/logo.svg">
                                                <div class="bd-logo"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="elementor-element elementor-element-1191b8c1 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="1191b8c1" data-element_type="widget" data-widget_type="heading.default">
                                          <div class="elementor-widget-container">
                                             <h3 class="elementor-heading-title elementor-size-default text-white">Góc Kỹ Thuật</h3>
                                          </div>
                                       </div>
                                       <div class="elementor-element elementor-element-72e24671 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="72e24671" data-element_type="widget" data-widget_type="heading.default">
                                          <div class="elementor-widget-container">
                                             <p class="elementor-heading-title elementor-size-default text-white text-lett text-lh">Liên hệ với chúng tôi để được tư vấn các kỹ thuật trong chăn <br> nuôi từ các chuyên gia đầu ngành nhiều kinh nghiệm.</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="list_tech_home container">
                        <?php 
                           if(!empty($result_technical)) {
                              foreach($result_technical as $row) {
                        
                        ?>
                           <div class="item_tech">
                              <img src="<?= $row['image'] ?>" alt="">
                              <span><?= $row['title'] ?></span>
                              <p><?= $row['content'] ?></p>
                           </div>
                        <?php }} ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="customer">
   <div class="container">
      <div class="cus_title">
         <h4>CHIA SẺ KHÁCH HÀNG</h4>
         <p>Lắng nghe khách hàng của chúng tôi</p>
      </div>
      <div class="list_cus">
         <?php 
            if(!empty($comment)) {
               foreach($comment as $row) {
         ?>
            <div>
               <div class="item_cus container">
                  <img src="<?= $row['avatar'] ?>" alt="">
                  <div class="right_cus">
                     <img src="/images/page/icon-text.png" alt="">
                     <p><?= $row['content'] ?></p>
                     <span> <i></i><?= $row['author'] ?></span>
                  </div>
               </div>
            </div>
         <?php }} ?>
      </div>
   </div>
</section>