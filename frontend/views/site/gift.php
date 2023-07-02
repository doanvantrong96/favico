<?php
use yii\helpers\Url;
use yii\web\View ;

$this->title = 'Quà tặng Yoga | yogalunathai.com';
// $this->registerJsFile('/js/script.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$domain = Yii::$app->params['domain'];
?>
<style>
    .listcourse .col.large-4.small-12 > .col-inner {
    border: 1px solid #ff277f;
    border-radius: 20px;
    overflow: hidden;
}
.img_avatar {
    width: 460px;
    height: 320px;
}
.box-image img {
    object-fit: cover;
    height: auto;
    height: 209px;
    border-top-right-radius: 20px;
    border-top-left-radius: 20px;
}
.box-text-inner h2{
    height: 160px;
}

.wrap {
    background: #f5f5f5;
}
h1 {
    text-align: center;
    margin-bottom: 0;
}
.listcourse  .col.large-4.small-12 > .col-inner:hover {
    box-shadow: 0px 0px 0px 1px #ff277f;
    border: 1px solid #ff277f;
    transition: all linear 0.1s;
}
.listcourse .col.large-4.small-12 > .col-inner:hover .title h4, .listcourse  .col.large-4.small-12 > .col-inner:hover .title p {
    color: #ff277f;
}
.title-page{
    text-align: center;
    margin-bottom: 40px;
    margin-top: 40px
}
.is-divider{
    display: inline-block;
}
.col-inner.text-right {
    font-size: 16px;
    font-weight: bold;
}
[data-text-color="primary"] {
    color: #ff277f !important;
}
.section-bg.bg-loaded {
    display: block !important;
}
a {
    color: #333;
    text-decoration: none !important;
}

.box-text h4{
  height: 40px;
  text-transform: uppercase;
}
.title p{
    text-transform: capitalize;
    font-size: 14px;
    height: 80px;
}
span.price {
    text-decoration: line-through;
    margin-right: 10px;
}
#section_930852144, #section_2083591997, #section_787350242 {
    background-color: #ff277f;
}
#section_930852144 .section-bg-overlay, #section_2083591997 .section-bg-overlay, #section_787350242 .section-bg-overlay {
    background-color: rgba(93,0,0,.64);
}
</style>
<div class="container">
    <div class="section-content relative">
        <div class="row align-center" id="row-533081487">
            <div class="col medium-10 small-12 large-10">
                <div class="col-inner text-center">
                <h2 style="text-align: center;"><span style="color: #d00000; font-size: 150%;">ABOUT US</span></h2>
                    <p style="text-align: left;"><span style="color: #d00000; font-size: 110%;">Yoga Luna Thái là nơi bạn có thể tìm thấy sự cân bằng giữa cơ thể & tâm trí. 
Tăng cường năng lượng giải tỏa những áp lực & stress trong cuộc sống.
Hệ thống Học Viện Quốc Tế Yoga Luna Thái được sáng lập bởi Giảng Viên Luna Thái - Cô gái Vàng Yoga Việt Nam - Ban giám khảo của Liên Đoàn Yoga Châu Á và Quốc Tế.
</span></p>
                    <p style="text-align: left;"><span style="color: #d00000; font-size: 110%;">Được thành lập từ năm 2011 , Học Viện Quốc tế Yoga Luna Thái đã xây dựng và phát triển gần 20 cơ sở trên Toàn Quốc & được UNESCO trao tặng “Thương Hiệu Chăm Sóc Sức Khỏe Chất Lượng Vàng”.</span></p>
                    <p style="text-align: left;"><span style="font-size: 110%; color: #d00000;">Hãy cùng thư giãn, tận hưởng & trải nghiệm Yoga mỗi ngày với Yoga Luna Thái để hướng tới sức khỏe – sự bình an nhé . </span></p>
                </div>
            </div>
        </div>
        <div class="row" id="row-1345735506">
            <div class="col medium-4 small-12 large-4">
                <div class="col-inner">
                    <div class="gap-element clearfix" style="display:block; height:auto; padding-top:50px"></div>
                    <div class="icon-box featured-box icon-box-right text-right">
                        <div class="icon-box-img" style="width: 85px">
                            <div class="icon">
                                <div class="icon-inner"> <img width="132" height="131"
                                        src="https://yogalunathai.com/wp-content/uploads/2019/09/icon1.png"
                                        data-src="https://yogalunathai.com/wp-content/uploads/2019/09/icon1.png"
                                        class="attachment-medium size-medium lazy-load-active" alt=""></div>
                            </div>
                        </div>
                        <div class="icon-box-text last-reset">
                            <h3 style="text-align: center;">Cân bằng cơ thể và</h3>
                            <h3 style="text-align: center;">tâm trí</h3>
                        </div>
                    </div><!-- .icon-box -->
                    <div class="gap-element clearfix" style="display:block; height:auto; padding-top:50px"></div>
                    <div class="icon-box featured-box icon-box-right text-right">
                        <div class="icon-box-img" style="width: 85px">
                            <div class="icon">
                                <div class="icon-inner"> <img width="132" height="131"
                                        src="https://yogalunathai.com/wp-content/uploads/2019/09/icon2.png"
                                        data-src="https://yogalunathai.com/wp-content/uploads/2019/09/icon2.png"
                                        class="attachment-medium size-medium lazy-load-active" alt=""></div>
                            </div>
                        </div>
                        <div class="icon-box-text last-reset">
                            <h3 style="text-align: center;">Cải thiện hệ hô hấp</h3>
                            <h3 style="text-align: center;">và nội tiết</h3>
                        </div>
                    </div><!-- .icon-box -->
                    <div class="gap-element clearfix" style="display:block; height:auto; padding-top:50px"></div>
                    <div class="icon-box featured-box icon-box-right text-right">
                        <div class="icon-box-img" style="width: 85px">
                            <div class="icon">
                                <div class="icon-inner"> <img width="132" height="131"
                                        src="https://yogalunathai.com/wp-content/uploads/2019/09/icon3.png"
                                        data-src="https://yogalunathai.com/wp-content/uploads/2019/09/icon3.png"
                                        class="attachment-medium size-medium lazy-load-active" alt=""></div>
                            </div>
                        </div>
                        <div class="icon-box-text last-reset">
                            <h3 style="text-align: center;">Giảm thiểu căng thẳng – stress</h3>
                        </div>
                    </div><!-- .icon-box -->
                </div>
            </div>
            <div class="col medium-4 small-12 large-4">
                <div class="col-inner">
                    <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_750506946">
                        <div class="img-inner dark"> <img width="851" height="1024"
                                src="https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-851x1024.png"
                                data-src="https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-851x1024.png"
                                class="attachment-large size-large lazy-load-active" alt=""
                                srcset="https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-851x1024.png 851w, https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-249x300.png 249w, https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-768x924.png 768w, https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên.png 1080w"
                                data-srcset="https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-851x1024.png 851w, https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-249x300.png 249w, https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên-768x924.png 768w, https://yogalunathai.com/wp-content/uploads/2019/09/Thiết-kế-không-tên.png 1080w"
                                sizes="(max-width: 851px) 100vw, 851px"></div>
                    </div>
                </div>
            </div>
            <div class="col medium-4 small-12 large-4">
                <div class="col-inner text-left">
                    <div class="gap-element clearfix" style="display:block; height:auto; padding-top:50px"></div>
                    <div class="icon-box featured-box icon-box-left text-left">
                        <div class="icon-box-img" style="width: 85px">
                            <div class="icon">
                                <div class="icon-inner"> <img width="132" height="131"
                                        src="https://yogalunathai.com/wp-content/uploads/2019/09/icon4.png"
                                        data-src="https://yogalunathai.com/wp-content/uploads/2019/09/icon4.png"
                                        class="attachment-medium size-medium lazy-load-active" alt=""></div>
                            </div>
                        </div>
                        <div class="icon-box-text last-reset">
                            <h3 style="text-align: center;">Vóc dáng thon gọn,</h3>
                            <h3 style="text-align: center;">săn chắc</h3>
                        </div>
                    </div><!-- .icon-box -->
                    <div class="gap-element clearfix" style="display:block; height:auto; padding-top:50px"></div>
                    <div class="icon-box featured-box icon-box-left text-left">
                        <div class="icon-box-img" style="width: 85px">
                            <div class="icon">
                                <div class="icon-inner"> <img width="132" height="131"
                                        src="https://yogalunathai.com/wp-content/uploads/2019/09/icon5.png"
                                        data-src="https://yogalunathai.com/wp-content/uploads/2019/09/icon5.png"
                                        class="attachment-medium size-medium lazy-load-active" alt=""></div>
                            </div>
                        </div>
                        <div class="icon-box-text last-reset">
                            <h3 style="text-align: center;">Cơ thể khỏe mạnh,</h3>
                            <h3 style="text-align: center;">dẻo dai</h3>
                        </div>
                    </div><!-- .icon-box -->
                    <div class="gap-element clearfix" style="display:block; height:auto; padding-top:50px"></div>
                    <div class="icon-box featured-box icon-box-left text-left">
                        <div class="icon-box-img" style="width: 85px">
                            <div class="icon">
                                <div class="icon-inner"> <img width="132" height="131"
                                        src="https://yogalunathai.com/wp-content/uploads/2019/09/icon6.png"
                                        data-src="https://yogalunathai.com/wp-content/uploads/2019/09/icon6.png"
                                        class="attachment-medium size-medium lazy-load-active" alt=""></div>
                            </div>
                        </div>
                        <div class="icon-box-text last-reset">
                            <h3 style="text-align: center;">Thêm yêu bản thân,</h3>
                            <h3 style="text-align: center;">đẩy lùi bệnh tật</h3>
                        </div>
                    </div><!-- .icon-box -->
                </div>
            </div>
        </div>
    </div><!-- .section-content -->
    <section class="section" id="section_930852144">
                    <div class="bg section-bg fill bg-fill  bg-loaded">
                        <div class="section-bg-overlay absolute fill"></div>
                        <div class="is-border" style="border-color:rgb(235, 235, 235);border-width:1px 0px 0px 0px;">
                        </div>
                    </div><!-- .section-bg -->
                    <div class="section-content relative">
                        <div class="row row-large align-middle align-center" id="row-924529027">
                            <div class="col medium-6 small-12 large-6">
                                <div class="col-inner text-center dark">
                                <h2 style="text-align: center;"> Luna Thái </h2>
                                    <p style="text-align: left;">Tên thật là Trần Lan Anh – được mệnh danh là Cô gái Vàng Yoga Việt Nam </p>
                                    <p style="text-align: left;">– Là người đạt Huy chương Vàng giải Yoga Quốc tế được tổ chức tại Ấn Độ năm 2016 <br>-	Giám khảo Yoga Quốc tế , đã từng chấm thi các giải Yoga Quốc tế tại nước ngoài . <br>-	Được vinh danh là Giám khảo Yoga Xuất sắc tại Ấn Độ năm 2017 , tại Malaysia năm 2018 , và tại Thái Lan năm 2019 ..
                                    <br>-	Là Đại sứ của DNXH Love Your Body Việt Nam và YSG design <br>-	Với các chứng chỉ :
                                    <br><span style="     margin-left: 20px; ">  + Yoga Alliance Cirtificate 200 hour – USA </span>  
                                    <br> <span style="     margin-left: 20px; ">   + Yoga Alliance Cirtificate 300 hour – USA </span> 
                                    <br><span style="     margin-left: 20px; ">    + Yoga Alliance Cirtificate 500 hour – USA </span> 
                                    <br> <span style="     margin-left: 20px; ">   + Yacep Yoga Alliance Cirtificate - USA .</span> 
                                    <br> <span style="     margin-left: 20px; ">   + Asian Yoga Referee Cirtificate </span> 
                                    <br>  <span style="     margin-left: 20px; ">  + Viet Nam Yoga Federation </span> 
                                    <br>  <span style="     margin-left: 20px; ">  + India Yoga Federation </span> 
                                    <br>   <span style="     margin-left: 20px; "> + Meditation Mind Global Training </span> 
                                    <br>-	Người sáng lập hệ thống Học Viện Quốc Tế Yoga Luna Thái với gần 20 cơ sở trên toàn Quốc  đã đào tạo hàng nghìn Giáo viên Yoga và hàng triệu học viên trực tiếp và gián tiếp trên mọi miền VN và ngoài VN . 
                                    <br>-	Người sáng lập Group “Nghiện Yoga” trên hơn 30.000 thành viên . 
                                    <br>-	Là gương mặt quen thuộc trên các kênh truyền hình uy tín . 
                                    <br>-	Người truyền cảm hứng – động lực về lối sống khỏe , sống tích cực trên các trang báo chí như : Dân trí , VN express , 24h.com.vn , Eva.vn , Vietnamnet.vn , tienphong.vn , Soha , Zingnews.vn ,baomoi.com, afamily , ... 
                                    <br>Sở hữu FB cá nhân gần 300.000 người Follow , kênh Youtube với hơn 60.000 Follow và Tiktok gần 200.000 Follow chia sẻ các bài tập nâng cao sức khỏe hàng ngày .
                                </p>
                                </div>
                            </div>
                            <div class="col medium-6 small-12 large-6" data-animate="flipInY" data-animated="true">
                                <div class="col-inner text-left box-shadow-2 box-shadow-5-hover" style="background-color:rgb(255, 255, 255);padding:15px 15px 15px 15px;">
                                    <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1506708495">
                                        <div class="img-inner dark"> <img width="1020" height="680" src="https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-1024x683.jpg" data-src="https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-1024x683.jpg" class="attachment-large size-large lazy-load-active" alt="" srcset="https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-1024x683.jpg 1024w, https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-300x200.jpg 300w, https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-768x512.jpg 768w" data-srcset="https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-1024x683.jpg 1024w, https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-300x200.jpg 300w, https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-768x512.jpg 768w" sizes="(max-width: 1020px) 100vw, 1020px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .section-content -->
                </section>
    <div class="title-page">
        <h1>Luna Thái gửi tặng bạn các khoá học miễn phí</h1>
        
        <div class="text-center">
            <div class="is-divider divider clearfix" style="margin-top:0rem;margin-bottom:0rem;max-width:300px;height:2px;background-color:rgb(255, 30, 137);">
            </div>
        </div>
    </div>
    
    
    <div class="row listcourse">
        <?php foreach( $Courses as $course) {?>
        <div class="col medium-4 small-12 large-4">
            <div class="col-inner" style="background-color:rgb(255, 255, 255);">
                <div class="box has-hover   has-hover box-text-bottom">
                <a href="<?= Url::to(['product/detail', 'slug' => $course['slug']]);?>">
                    <div class="box-image">
                        <div class="image-zoom">
                            <img width="558" height="348" src="<?= $domain . $course['avatar']?>" class="attachment-large size-large img_avatar" alt=""/>											</div>
                        </div><!-- box-image -->
                    <div class="box-text text-center">
                        <div class="box-text-inner">
                        <div class="title">
                            <h4>Khoá học <?= $course['name'] ?></h4>
                            <p> <?= $course['level'] ?></p>
                        </div>
                            
                            <div class="is-divider divider clearfix" style="max-width:100%;height:1px;background-color:rgb(255, 30, 137);"></div><!-- .divider -->
                            <div class="row row-collapse" id="row-1930899539">
                                <div class="col medium-1 large-1">
                                    <div class="col-inner">
                                        <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1037959971">
                                            <div class="img-inner dark">
                                                <img width="520" height="360" src="/resoure/icon-14.png" class="attachment-large size-large" alt="" />						
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col medium-4 large-4">
                                    <div class="col-inner text-left">
                                        <p>HLV Luna thái</p>
                                    </div>
                                </div>
                                <div class="col medium-7 large-7">
                                    <div class="col-inner text-right">
                                        <p>
                                            <span class='price'><?= $course['price'] > 0 ? number_format($course['price']).'đ' : '' ?></span>
                                            <span class="pricesale" data-text-color="primary"><?= $course['promotional_price'] > 0 ? number_format($course['promotional_price']).'đ' : 'miễn phí' ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- box-text-inner -->
                    </div><!-- box-text -->
                    </a>
                </div><!-- .box  -->
            </div>
        </div>
        <?php }?>
    </div>
</div>