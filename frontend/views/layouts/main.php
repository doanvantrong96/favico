<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use backend\models\CourseCategory;
use backend\models\OrderCart;
use backend\models\OrderCartProduct;

AppAsset::register($this);

if(Yii::$app->user->identity) {
    $session = Yii::$app->session;
    $data_cart = $session->get('info_course_cart');
    $check_cart = 0;
    if(!empty($data_cart)){
        $check_cart = count($data_cart);
    }
}

//list chuyen muc
$data_category = CourseCategory::find()
->where(['status' => 1,'is_delete' => 0])
->asArray()
->all();

//affilicate
if(isset($_GET['aff'])){
    $cookies = Yii::$app->response->cookies;
    $cookies->add(new \yii\web\Cookie([
        'name' => 'aff',
        'value' => $_GET['aff'],
    ]));

    $cookies = Yii::$app->request->cookies;
    // $cookies->getValue('aff', $_GET['aff']);
}

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;

$check_menu = $controller .'/'.$action;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style class="vjs-styles-defaults">
            .video-js {
                width: 300px;
                height: 150px;
            }
            .vjs-fluid {
                padding-top: 56.25%;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
        <link rel="stylesheet" id="wp-bootstrap-starter-fontawesome-cdn-css" href="/css/fontawesome.min.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/css/all.min.css" crossorigin="anonymous" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="icon" type="image/png" href="/images/page/logo-fv.svg" sizes="50x50">
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:type" content="website" />
        <link rel="stylesheet" href="/css/azuremediaplayer.min.css" />
        <script src="/resoure/sdk.js" async="" crossorigin="anonymous"></script>
        <script>
            (function (html) {
                html.className = html.className.replace(/\bno-js\b/, "js");
            })(document.documentElement);
        </script>

        <script type="text/javascript" async="" defer="" src="/js/piwik.js"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());
        </script>
        <link rel="stylesheet" href="/css/styles.css" />
        <!-- <link rel="stylesheet" href="/css/styles.78c05ae853e3fdc5414f.css" /> -->
        <link rel="stylesheet" href="/css/main.css" />
        <!-- <link rel="stylesheet" href="/css/main.ed7f3fbe4b65d1e2777b.css" /> -->
        <?php
        // $this->registerMetaTag(Yii::$app->params['og_title'], 'og_title'); 
        // $this->registerMetaTag(Yii::$app->params['og_description'], 'og_description'); 
        // $this->registerMetaTag(Yii::$app->params['og_fb'], 'og_fb'); ?>

        <!-- Google / Search Engine Tags -->
        <html prefix="og: http://ogp.me/ns#">
        <meta itemprop="name" content="website abe">
        
        <!-- Facebook Meta Tags -->
        <!-- <meta property="og:url" content="https://elearning.abe.edu.vn"> -->
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?= Html::encode($this->title) ?>">
        <meta property="og:description" content="">
        <!-- <meta property="og:image" prefix="og: http://ogp.me/ns#" content="https://elearning.abe.edu.vn/images/page/logo.png" /> -->
        
        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="">
        <meta name="twitter:title" content="<?= Html::encode($this->title) ?>">
        <meta name="twitter:description" content="">
        <meta name="twitter:image" content="https://elearning.abe.edu.vn/images/page/logo.png">


        <title><?= Html::encode($this->title) ?></title>
        <?php $this->
        head() ?>
        <style>
            @import url(https://fonts.googleapis.com/css?family=Lato:600, 500, 400, 300&display=swap);
        </style>

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0&appId=1438665563271474&autoLogAppEvents=1" nonce="NvknslKE"></script>

        <!--Start of Tawk.to Script New-->
            <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/63fa203531ebfa0fe7ef489d/1gq4grko2';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
            </script>
        <!--End of Tawk.to Script-->

        <!-- Messenger Chat Plugin Code --> 
        <!-- <div id="fb-root"></div> <div id="fb-customer-chat" class="fb-customerchat"></div> <script> var chatbox = document.getElementById('fb-customer-chat'); chatbox.setAttribute("page_id", "PAGE-ID"); chatbox.setAttribute("attribution", "biz_inbox"); </script> <script> window.fbAsyncInit = function() { FB.init({ xfbml : true, version : 'API-VERSION' }); }; (function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js'; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk')); </script>  -->
            
        <!-- Google analytics (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-GNSZR91JYF"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-GNSZR91JYF');
        </script>

        <!-- google console -->
        <meta name="google-site-verification" content="FVlFTqz1IswBaovc_sbB6PEvICkpGxmt35msFsDpvNw" />
        <?php $this->registerCsrfMetaTags() ?>
    </head>
    <?php $this->beginBody() ?>
    <div class="app padding-top">
        <div id="fb-customer-chat"></div>
        <nav class="main-nav <?= Yii::$app->user->identity ? 'top-nav' : '' ?>">
            <button class="menu-toggle"><i class="fal fa-bars"></i></button>
            <?php if(!Yii::$app->user->isGuest) { ?>
                <li class="nav-item cart_item_mb d-block d-lg-none">
                    <a href="<?= Url::to(['/site/payment']) ?>" class="position-relative">
                        <img src="/images/page/Cart.svg" alt="">
                        <b class="count_cart"><?= $check_cart ?></b>
                    </a>
                </li>
            <?php } ?>
            <div class="container container_nav <?= Yii::$app->user->identity ? 'container_user_index' : '' ?>">
                <div class="d-flex align-items-center">
                    <div class="logo-wrapper">
                        <a class="nav-link" href="/"><img src="/images/page/logo.svg" alt="" /></a>
                    </div>
                    <div class="menu_list">
                        <ul class="menu">
                            <li>
                                <a class="nav-link <?= ($check_menu == 'site/index') ? 'active' : '' ?>" href="/">Trang Chủ</a>
                            </li>
                            <?php if(Yii::$app->user->identity) { ?>
                                <li>
                                    <a class="nav-link <?= ($check_menu == 'site/my-progress') ? 'active' : '' ?>" href="<?= Url::to(['/site/my-progress']) ?>">Tiến trình học tập</a>
                                </li>
                                <li>
                                    <a class="nav-link <?= ($check_menu == 'lecturers/index') ? 'active' : '' ?>" href="<?= Url::to(['/lecturers/index']) ?>">Chuyên gia</a>
                                </li>
                                <li>
                                    <a class="nav-link <?= ($check_menu == 'category/index') ? 'active' : '' ?>" href="<?= Url::to(['/category/index']) ?>"> <i class="far fa-search text-white"></i> Thư viện</a>
                                </li>
                            <?php }else{?>
                                <li>
                                    <a class="nav-link <?= ($check_menu == 'category/index') ? 'active' : '' ?>" href="<?= Url::to(['/category/index']) ?>">Danh mục</a>
                                </li>
                                <li>
                                    <a class="nav-link <?= ($check_menu == 'site/about') ? 'active' : '' ?>" href="<?= Url::to(['/site/about']) ?>">Về ABE Academy</a>
                                </li>
                                <li>
                                    <a class="nav-link <?= ($check_menu == 'lecturers/index') ? 'active' : '' ?>" href="<?= Url::to(['/lecturers/index']) ?>">Chuyên gia</a>
                                </li>
                                <li class="ml -lg-auto position-relative">
                                     <div class="search-panel">
                                         <div class="input-wrapper">
                                             <input type="text" id="input-search" autocomplete="off" placeholder="Tìm Kiếm" value="" />
                                             <!-- <button class="btn btn-clear" style="display: none;"><i class="fal fa-times"></i></button> -->
                                             <i class="far fa-search"></i>
                                         </div>
                                         <div class="search-results" style="display: none;">
                                             <ul class="course-list"></ul>
                                         </div>
                                         <div class="result_search_default">
                                             <ul class="list_search_default">
                                                 <?php foreach($data_category as $item) { ?>
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
                                 </li>
                            <?php } ?>  
                        </ul>
                    </div>
                    <div class="ml-auto">
                        <ul class="menu d-lg-flex align-items-center">
                            <li class="li_menu_mb ml -lg-auto position-relative">
                                <div class="search-panel">
                                    <div class="input-wrapper">
                                        <input type="text" id="input-search" autocomplete="off" placeholder="Tìm Kiếm" value="" />
                                        <!-- <button class="btn btn-clear" style="display: none;"><i class="fal fa-times"></i></button> -->
                                        <i class="far fa-search"></i>
                                    </div>
                                    <div class="search-results" style="display: none;">
                                        <ul class="course-list"></ul>
                                    </div>
                                    <div class="result_search_default">
                                        <ul class="list_search_default">
                                            <?php foreach($data_category as $item) { ?>
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
                            </li>

                            <?php if( !Yii::$app->user->identity ){ ?>
                                <li class="nav-item d-flex li_sign">
                                    <button type="button" id="btnSignUp" data-url="<?= Url::to(['site/signup']);?>" class="text-uppercase btn btn-outline-white btn-open-modal">Đăng ký</button>
                                    <button type="button" id="btnLogin" data-url="<?= Url::to(['site/login']);?>" class="text-uppercase btn btn-outline-white btn-open-modal"> <img src="/images/page/icon-login.svg" alt=""> Đăng Nhập</button>
                                </li>
                            <?php }else{
                           $avatar = '/images/page/icon-user.svg';
                           if( Yii::$app->user->identity->fb_id != '' ) $avatar = Yii::$app->user->identity->avatar; ?>
                                <li class="nav-item d-none d-lg-block">
                                    <a href="<?= Url::to(['site/payment']) ?>" class="position-relative">
                                        <img src="/images/page/Cart.svg" alt="">
                                        <b class="count_cart"><?= $check_cart ?></b>
                                    </a>
                                </li>
                                <li class="nav-item d-none d-lg-block"><a href="javascript:void(0)" ><?= Yii::$app->user->identity->fullname ?></a></li>
                                <li class="dropdown nav-item d-none d-lg-block">
                                    <a aria-haspopup="true" href="javascript:;" class="user-name position-relative nav-user dropdown-toggle nav-link" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-image" style="width: 32px;"><img src="<?= $avatar ?>" alt="profile" /></div>
                                            <i class="fas fa-chevron-down ml-2"></i>
                                        </div>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right drop_user">
                                        <button type="button" tabindex="0" role="menuitem" class="dropdown-item">
                                            <a class="w-100 d-inline-block" href="<?= Url::to(['site/info-user']);?>">Thông tin tài khoản</a>
                                        </button>
                                        <button type="button" tabindex="0" role="menuitem" class="dropdown-item">
                                            <a class="w-100 d-inline-block" href="<?= Url::to(['user/change-password']);?>">Đổi mật khẩu</a>
                                        </button>
                                        <button type="button" tabindex="0" role="menuitem" class="dropdown-item">
                                            <a href="<?= Url::to(['site/logout']);?>" class="dropdown-link">Đăng xuất</a>
                                        </button>
                                    </div>
                                </li>
                                <li class="d-flex d-lg-none align-items-center gap-10">
                                    <div class="profile-image" style="width: 32px;"><img src="<?= $avatar ?>" alt="profile" /></div>
                                    <a href="javascript:void(0)"><?= Yii::$app->user->identity->email ?></a>
                                </li>
                            <?php } ?>

                            <li class="li_menu_mb">
                              <a href="/">Trang Chủ</a>
                           </li>
                           <li class="li_menu_mb">
                              <a href="<?= Url::to('/category/index') ?>">Danh mục</a>
                           </li>
                           <li class="li_menu_mb">
                              <a href="<?= Url::to(['/site/about']) ?>">Về ABE Academy</a>
                           </li>
                           <li class="li_menu_mb">
                              <a href="<?= Url::to('/lecturers/index') ?>">Chuyên gia</a>
                           </li>
                           <?php if( Yii::$app->user->identity ){ ?>
                                <li class="li_menu_mb">
                                    <a href="<?= Url::to('/site/my-progress') ?>">Tiến trình học tập</a>
                                </li>
                                <li class="li_menu_mb">
                                    <a href="<?= Url::to('/site/info-user') ?>">Thông tin tài khoản</a>
                                </li>
                                <li class="li_menu_mb">
                                    <a href="<?= Url::to('/user/change-password') ?>">Đổi mật khẩu</a>
                                </li>
                                <li class="li_menu_mb">
                                    <a class="rs_password" href="<?= Url::to('/site/my-progress') ?>">Quên mật khẩu</a>
                                </li>
                                                                <li class="li_menu_mb">
                                    <a class="logout_mb" href="<?= Url::to('/site/logout') ?>">Đăng xuất</a>
                                </li>
                           <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div id="main_content">
            <?= $content ?>
        </div>
        <footer>
            <!-- Messenger Plugin chat Code -->
            <div id="fb-root"></div>
            <!-- Your Plugin chat code -->
            <div id="fb-customer-chat" class="fb-customerchat">
            </div>
            <script>
            var chatbox = document.getElementById('fb-customer-chat');
            chatbox.setAttribute("page_id", "107528065172234");
            chatbox.setAttribute("attribution", "biz_inbox");
            </script>
            <!-- Your SDK code -->
            <script>
            window.fbAsyncInit = function() {
                FB.init({
                xfbml            : true,
                version          : 'v16.0'
                });
            };
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="main-footer text-center text-lg-left">
                <div class="container">
                    <div class="grid_ft">
                       <div class="lg_footer">
                           <!-- <span class="title_ft">Viện nghiên cứu phát triển kinh tế Châu Á -Thái Bình Dương</span> -->
                           <img class="logo_ft" src="/images/page/logo.svg" alt="logo">
                           <p class="mt-2">
                                VIỆN NGHIÊN CỨU PHÁT TRIỂN KINH TẾ CHÂU Á - THÁI BÌNH DƯƠNG <br>
                                Số đăng ký: B-06/2023/ĐK-KH&CN <br>
                                Cấp ngày: 11/01/2023<br>
                                Nơi cấp: Sở Khoa học và Công nghệ thành phố Hà Nội
                           </p>
                       </div>
                       <div class="div_address">
                           <span class="title_ft">LIÊN HỆ</span>
                           <p>Địa chỉ: <br> Ha Noi: NV 8.1 Green Park - 319 Vinh Hung, Thanh Tri, Hoang Mai <br> Singapore Office: 18 Sin Ming Lane, #07-01 Midview City</p>
                           <p>Hotline: <a href="tel:0834822266">083 482 2266</a></p>
                           <p style="word-break: break-all;"><a href="mailto:Welcome@elearning.abe.edu.vn">Email: Welcome@elearning.abe.edu.vn</a></p>
                       </div>
                       <div>
                           <span class="title_ft">TÌM HIỂU THÊM</span>
                           <ul class="ul_about">
                              <li>
                                 <a href="<?= Url::to(['site/about']) ?>">Về ABE Academy</a>
                              </li>
                              <li>
                                 <a href="<?=  Url::to(['category/index-news','slug' => 'dieu-khoan-su-dung-tai-khoan-abe-academy','id' => 18])?>">Điều khoản dịch vụ</a>
                              </li>
                              <li>
                                 <a href="https://elearning.abe.edu.vn/chinh-sach-bao-mat-thong-tin-19">Chính sách bảo mật</a>
                              </li>
                              <!-- <li>
                                 <a href="">Liên hệ với chúng tôi</a>
                              </li> -->
                           </ul>
                       </div>
                       <div>
                           <span class="title_ft d-none d-lg-block">MẠNG XÃ HỘI</span>
                           <ul class="ul_social">
                              <li>
                                 <a target="_blank" href="https://www.facebook.com/elearning.abe.edu.vn"><img src="/images/page/fb.svg" alt=""> <span class="d-none d-lg-contents">Facebook</span></a>
                              </li>
                              <li>
                                 <a target="_blank" href="https://www.youtube.com/@abeacademy"><img src="/images/page/yout.svg" alt=""> <span class="d-none d-lg-contents">Youtube</span></a>
                              </li>
                              <li>
                                 <a target="_blank" href="https://www.tiktok.com/@abeacademy"><img src="/images/page/tiktok.svg" alt=""> <span class="d-none d-lg-contents">Tiktok</span></a>
                              </li>
                              <!-- <li>
                                 <a target="_blank" href=""><img src="/images/page/inta.svg" alt=""> <span class="d-none d-lg-contents">Instagram</span></a>
                              </li> -->
                              <!-- <li>
                                 <a target="_blank" href=""><img src="/images/page/spor.svg" alt=""> <span class="d-none d-lg-contents">Spotify</span></a>
                              </li> -->
                           </ul>
                       </div>
                       <div>
                           <span class="title_ft d-none d-lg-block">TẢI XUỐNG</span>
                           <div class="gr_down_app">
                                <a href="javascript:void(0)" class="developing">
                                    <img class="w-100 mb-2" src="/images/page/icon-appstore.png" alt="">
                                </a>
                                <a href="javascript:void(0)" class="developing">
                                    <img class="w-100" src="/images/page/icon-google-play.png" alt="">
                                </a>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="columb_mb d-flex justify-content-between align-items-center mb-4">
                    <div class="text_bot_footer">
                        <p>© <?= date("Y") ?> ABE Academy</p>
                        <p>Secured with SSL</p>
                    </div>
                    <div>
                        <img style="width:130px" src="/images/page/bo-cong-thuong.png" alt="">
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div tabindex="-1" style="position: relative; z-index: 1050; display: block;">
		<div class="modal fade" id="modal" role="dialog" tabindex="-1" style="display: none;">
			<div class="modal-dialog modal-sm modal-auth modal-dialog-centered" role="document">
				<div class="modal-content">
					<p class="text-center"><img src="/images/icon-loadings.svg" /></p>
				</div>
			</div>
		</div>
    </div>
    <?= $this->render('script_after_body', ['params' => isset($this->params) ? $this->params : []]); ?>
    <?php if(Yii::$app->user->isGuest) { ?>
        <div class="sticky_bottom">
            <div class="container">
                <div class="sticky_bottom_content">
                    <p>Bắt đầu cuộc hành trình của bạn ngày hôm nay.</p>
                    <button type="button" id="btnSignUp" data-url="/dang-ky" class="text-uppercase btn btn-outline-white btn-open-modal">Đăng ký</button>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php $this->endBody() ?>
</html>
<div class="modal fade" id="modal_update_phone" role="dialog" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-sm modal-auth modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="signup" class="mb-3">
                <div class="form-group">
                    <label class="fz-18" for="">Vui lòng cập nhật số điện thoại</label>
                    <input placeholder="Số điện thoại" name="phone" id="phone_update" type="phone" class="form-control">
                </div>
                <button type="button" class="btnSubmitUpdatePhone btn btn-primary fz-18 mb-2">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
<input type="hidden" value="" id="course_dis" name="course_id" value=""/>
<script type="text/javascript">
    jQuery(function($){
        <?php if(Yii::$app->user->identity && Yii::$app->user->identity->phone == null) { ?>
            $(window).on('load', function() {
                $('#modal_update_phone').modal('show');
            });
        <?php } ?>
        $(document).on('click','.btnSubmitUpdatePhone',function(){
            var phone = $('#phone_update').val();
            $.ajax({
                type:'POST',
                url:"/site/updatephone",
                data:{phone:phone},
                success:function(res){
                    if(res == 1){
                        toastr['success']('Cập nhật thành công.');
                        location.reload();
                    }else{
                        toastr['warning']('Số điện thoại đã được sử dụng.');
                    }
                }
            });
        });
    	function stopVideo(modal) {
    		var currentIframe = modal.querySelector('.modal-content > iframe');
    		currentIframe.src = currentIframe.src;
    	}
    	$('.modal_click .col-inner > a.button').click(function(e){
    			e.preventDefault();
    			let url = $(this).attr('href').replace("watch?v=", "embed/");
    			$('.videomodal').attr('src',url);
    			$('.modal').modal('show');
    	});
    	$('.modal').on('hidden.bs.modal', function (e) {
    		$('.videomodal').attr('src','');
    	})
    	$('.dropdown-toggle').click(function(e){

    		if( screen.width > 790){
    			window.location.href = $(this).attr('href');
    		}else{
    			if( $(this).parent().find('.dropdown-menu').hasClass('active')){
    				$(this).parent().find('.dropdown-menu').removeClass('active');
    			}else{
    				console.log('1332')
    				$(this).parent().find('.dropdown-menu').addClass('active');
    			}
    		}

    	});
    	// $('a').click(function(e){
    	// 	if( $(this).attr('target').length == 0){
    	// 		e.preventDefault();
    	// 		let url = $(this).attr('href');
    	// 		endString = url.substr(url.length - 1,1);
    	// 		if(endString == '/' && url.lenth > 1){
    	// 			url = url.substr( 0,url.length - 1 );
    	// 		}
    	// 		window.location.href = url;
    	// 	}

    	// });
    	<?php
    		if(Yii::$app->session->getFlash('success')){
    			$success = Yii::$app->session->getFlash('success');
    			$title   = '';
    			$message = '';
    			if( is_array($success) ){
    				$title = $success['title'];
    				$message = $success['message'];
    			}else{
    				$title = $success;
    			}
    	?>
    		Swal.fire({
    			allowOutsideClick:false,
    			icon: 'success',
    			title: '<?= $title ?>',
    			html: '<?= $message ?>',
    			confirmButtonText:'Đóng'
    		});
    	<?php
    			Yii::$app->session->setFlash('success',null);
    		}
    		if(Yii::$app->session->getFlash('error')){
    	?>
    		Swal.fire({
    			allowOutsideClick:false,
    			icon: 'error',
    			title: 'Lỗi',
    			html : '<?= Yii::$app->session->getFlash('error') ?>',
    			confirmButtonText:'Đóng'
    		});
    	<?php
    			Yii::$app->session->setFlash('error',null);
    		}
    	?>
    	// $('.caret').click(function(e){
    	// 	console.log('catert');
    	// 	let flag = $(this).parent().attr('aria-expanded');
    	// 	$(this).parent().attr('aria-expanded',!flag);
    	// })
    })
</script>
<?php $this->endPage() ?>
