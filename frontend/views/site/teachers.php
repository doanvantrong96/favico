<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->registerCssFile("/css/autop.css");
$this->title = 'Về chúng tôi | Đội ngũ giáo viên';
// $this->params['breadcrumbs'][] = $this->title;
?>
<link href="/css/autop.css" rel="stylesheet">
<style>
    #row-346494560 .col-inner {
        padding-top: 10px;
    }

.section.dark {
    padding-top: 30px;
    padding-bottom: 30px;
    background-color: #fff;
}
#banner-773239033 .bg.bg-loaded {
    background-image: url(https://yogalunathai.com/wp-content/uploads/2019/10/64205963_1672213289590121_1229726618054819840_n.jpg);
}
#banner-773239033,#banner-1405190248,#banner-1857843049,#banner-633566190,#banner-660395394,#banner-1405190249 {
    padding-top: 500px;
}
#banner-1405190248 .bg.bg-loaded {
    background-image: url(https://yogalunathai.com/wp-content/uploads/2019/09/45668738_1500190540125731_6050619136260702208_n.jpg);
}
#banner-1405190249 .bg.bg-loaded {
    background-image: url(https://yogalunathai.com/wp-content/uploads/2020/01/IMG_2445-1024x683.jpg);
}
#banner-1857843049 .bg.bg-loaded {
    background-image: url(https://yogalunathai.com/wp-content/uploads/2019/10/175789d13c3ad864812b.jpg);
}
#banner-1616803503, {
    padding-top: 500px;
    background-color: rgb(255, 255, 255);
}
#banner-1616803503 .bg.bg-loaded {
    background-image: url(https://yogalunathai.com/wp-content/uploads/2019/09/DSC_6414_1-1024x683.jpg);
}
#banner-633566190 .bg.bg-loaded {
    background-image: url(https://yogalunathai.com/wp-content/uploads/2019/11/Untitled-1.jpg);
}
#banner-660395394 .bg.bg-loaded {
    background-image: url(/resoure/Luna-Thai-Banner-1.jpg);
}
.text-inner.text-center{
    text-align: center;
}
#banner-1616803503 .container{
    display: block;
}
.section-title strong {
    display: block;
    -ms-flex: 1;
    flex: 1;
    height: 2px;
    opacity: .1;
    background-color: currentColor;
}
/* .col-inner .banner .container {
    border: 2px solid #fff;
    display: none;
} */
h4.section-title.section-title-center {
    margin-bottom: 20px;
}
#section_1780651417 {
    padding-top: 30px;
    padding-bottom: 30px;
    background-color: #c1c1c1;
}
.featured-title .page-title-inner {
    padding-bottom: 0px;
}
#page-header-1941125347 .featured-title .page-title-inner {
    padding-bottom: 20px;
}
#section_1780651417 .section-bg-overlay {
    background-color: rgba(255,255,255,.85);
}
.section-title-center span, .section-title-bold-center span{
    border-bottom: 0px;
}
#text-box-2054965153 {
    width: 60%;
}
#text-box-560576024 .dark h3,#text-box-560576024 .dark p{
    color:#555
}
.col-inner .banner .container:before,.overlay{
    opacity:1;
    background:none;
    background-color:unset;
}
span.section-title-main {
    /* margin-top: 20px; */
}
.lazy-load {
    background-color:#fff;
}
div#row-762301420 img {
    max-width: 240px;
    height: auto;
}
blockquote {
    border-left: 2px solid #ff277f;
    box-shadow: unset;
}
div#row-1327526685 {
    margin-top: 40px;
}
.page-header-wrapper {
    margin-bottom: 10px;
}
@media (min-width: 550px){
    #text-box-2054965153 {
        width: 40%;
    }   
}
#text-box-560576025{
    left: 0;
}
#text-box-560576025 .dark h3, #text-box-560576025 .dark p{
    color: #ff277f;
    font-weight: bold;
}
form#form-contact {
    box-shadow: 0 0 40px -10px #000;
    padding: 30px 20px;
    border-radius: 10px;
}
.box_register a {
    text-align: center;
    padding: 20px 40px;
    border: none;
    border-radius: 10px;
}
.box_register {
    text-align: center;
    font-size: 16px;
}
.btn-primary:hover{
    border-color: #ff277f;
}
.banner h2, .banner h3, .banner h1{
    line-height: 1.3;
}
</style>
<style>
    .section-bg.bg-loaded {
    display: block !important;
}
body {
    color: #888b9a;
}
pre, blockquote, form, figure, p, dl, ul, ol {
    margin-bottom: 1.3em;
}
#section_930852144,#section_2083591997,#section_787350242{
    background-color: #ff277f;
}
#section_930852144 .section-bg-overlay,#section_2083591997 .section-bg-overlay,#section_787350242 .section-bg-overlay{
    background-color: rgba(93,0,0,.64);
}
</style>
<div id="content" class="content-area page-wrapper" role="main">
    <div class="row row-main">
        <div class="large-12 col">
            <div class="col-inner">
                <h2>ĐỘI NGŨ GIÁO VIÊN</h2>
                <p><span style="font-size: 110%;">Luna Thái Yoga Center ngoài là một trong những trung tâm đào tạo giáo
                        viên yoga chuyên nghiệp &amp; tốt nhất hiện nay. Luna Thái Yoga Center còn là nơi khởi nguồn
                        &amp; quy tụ của rất nhiều giáo viên yoga chất lượng, uy tín &amp; nhiệt huyết. Những giảng viên
                        ưu tú sẽ giúp bạn có một cái nhìn chính xác &amp; hiệu quả tốt nhất trong quá trình tập luyện
                        yoga.</span></p>
                <p><span style="font-size: 110%;">Cùng tìm hiểu qua một số giảng viên tại Luna Thái Yoga Center
                        nhé:</span></p>
                <?php for($i = 1; $i<11;$i++){ ?>
                        <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1012219800">
                    <div class="img-inner dark"><img width="720" height="540"
                            src="https://yogalunathai.com/wp-content/uploads/2020/01/gv<?=$i?>.png"
                            data-src="https://yogalunathai.com/wp-content/uploads/2020/01/gv<?=$i?>.png"
                            class="attachment-large size-large lazy-load-active" alt=""
                            srcset="https://yogalunathai.com/wp-content/uploads/2020/01/gv<?=$i?>.png 720w"
                            data-srcset="https://yogalunathai.com/wp-content/uploads/2020/01/gv<?=$i?>.png 720w"
                            sizes="(max-width: 720px) 100vw, 720px"></div>
                </div>
                <?php } ?>
                <p>&nbsp;</p>
                <p><span style="font-size: 120%;">Luyện tập yoga đều đặn mỗi ngày &amp; kết hợp với chế độ ăn uống khoa
                        học, điều độ sẽ giúp cho bạn có một thể chất, tinh thần minh mẫn khỏe mạnh &amp; một làn da tươi
                        sáng. Cùng tập luyện với Luna Thái mỗi ngày để có cơ thể dẻo dai &amp; cân đối cũng như trẻ hóa
                        cơ thể như ý các bạn nhé ^^</span></p>
                <p><span style="font-size: 120%;">Nếu các bạn yêu thích Yoga và muốn gắn bó với Yoga , đừng ngần ngại
                        liên hệ để Luna Thái có thể giải đáp những thắc mắc cùng lộ trình học cho các bạn nhé:</span>
                </p>
                <p><span style="font-size: 120%;">Yoga Luna Thái</span><br><span style="font-size: 120%;">Hotline :
                        0985060558</span></p>
            </div>
            <div id="page-header-988845982" class="page-header-wrapper">
    <div class="page-title dark featured-title">
        <div class="page-title-inner container align-center text-center flex-row-col medium-flex-wrap">
            <div class="title-wrapper flex-col">
                <h1 class="entry-title mb-0">Đăng ký tham gia ngay cùng Luna Thái</h1>
            </div>
            <div class="title-content flex-col">&nbsp;</div>
        </div> 
    </div> 
</div> 

  
<div class="row row-large align-middle align-center" id="row-195348760">
    <div class="col medium-6 small-12 large-6">
        <div class="col-inner box-shadow-2 box-shadow-5-hover"
            style="background-color:rgb(255, 255, 255);padding:15px 15px 15px 15px;">
            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_870986783">
                <div class="img-inner dark"> <img width="1020" height="680" src="/resoure/Luna-Thai-Banner-1.jpg"></div>
            </div>
        </div>
    </div>
    <div class="col medium-6 small-12 large-6">
        <!-- <div class="col-inner box-shadow-2 box-shadow-5-hover"> -->
            <div class="box_register">
                <p>Đăng ký học tại các cơ sở của Luna Thái để được hướng dẫn trực tiếp về Yoga</p>
                <a class="btn btn-primary register primary button is-shade box-shadow-3 box-shadow-5-hover" name="signup-button">Đăng ký miễn phí</a>
                <div class="section-title section-title-center">
                    <strong></strong>
                    <span>Hoặc</span>
                    <strong></strong>
                </div>
                <p>Tham gia tập Online tại nhà cùng Luna Thái</p>
                <a class="btn btn-primary primary button is-shade box-shadow-3 box-shadow-5-hover" href="/product/index">Tham gia ngay</a>
            </div>
            
        <!-- </div> -->
    </div>
   
</div>
        </div><!-- .large-12 -->
    </div><!-- .row -->
</div>
<div id = "registerModal"class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="row row-large align-middle align-center">
        <div class="col medium-6 small-12 large-6">
                <div class="col-inner box-shadow-2 box-shadow-5-hover"
                    style="background-color:rgb(255, 255, 255);padding:15px 15px 15px 15px;">
                    <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_870986783">
                        <div class="img-inner dark"> <img width="1020" height="680" src="https://yogalunathai.com/wp-content/uploads/2019/09/DSC_3624-1024x683.jpg"></div>
                    </div>
                    <p>Giảng viên Luna Thái (tên thật là Trần Lan Anh), là VĐV đầu tiên của đội tuyển Việt Nam đạt HCV tại giải Vô địch thế giới tổ chức tại Ấn Độ.</p>
                    <p>Là Giám khảo Liên đoàn Yoga Châu Á và Quốc tế.</p>
                    <p>Bằng Alliance 500h Mỹ</p>
                </div>
            </div>
                <div class="col medium-6 small-12 large-6">
                    <div class="col-inner text-center">
                        <?= $this->render('/layouts/_box_form',[
                            'model'=>$model,
                            'source' => 'Đội ngũ giáo viên'
                        ]) ?>
                    </div>
            </div>  
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    jQuery(function($){
        $('.register').click(function(e){
                e.preventDefault();
                $('#registerModal').modal('show');
        });
    });
</script>