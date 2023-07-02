<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

if(Yii::$app->user->identity) {
    $session = Yii::$app->session;
    $data_cart = $session->get('info_course_cart');
    $check_cart = 0;
    if(!empty($data_cart)){
        $check_cart = count($data_cart);
    }
}



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
        <link data-optimized="2" rel="stylesheet" href="/css/layout.css">
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
    <div class="elementor-2700 elementor">
        <div id="fb-customer-chat"></div>
        <section class="elementor-section elementor-top-section elementor-element elementor-element-6ac7fd0 elementor-section-height-min-height elementor-hidden-tablet elementor-hidden-phone elementor-section-boxed elementor-section-height-default elementor-section-items-middle nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="6ac7fd0" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
            <div class="elementor-container elementor-column-gap-default">
            <div class="elementor-row align-items-center">
                <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-7d7708f" data-id="7d7708f" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                        <div class="elementor-element elementor-element-794a64d elementor-icon-list--layout-inline elementor-mobile-align-center elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="794a64d" data-element_type="widget" data-widget_type="icon-list.default">
                            <div class="elementor-widget-container">
                                <ul class="elementor-icon-list-items elementor-inline-items">
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                    <a href="/"><span class="elementor-icon-list-text">Trang chủ</span>
                                    </a>
                                    </li>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                    <a href="/about/"><span class="elementor-icon-list-text">Giới thiệu</span>
                                    </a>
                                    </li>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                    <a href="/services/"><span class="elementor-icon-list-text">Sản phẩm</span>
                                    </a>
                                    </li>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                    <a href="/shop/"><span class="elementor-icon-list-text">Tin tức</span>
                                    </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-0848b61" data-id="0848b61" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                        <div class="elementor-element elementor-element-94cc6fc agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="94cc6fc" data-element_type="widget" data-widget_type="heading.default">
                            <div class="elementor-widget-container">
                                <a href="">
                                    <img src="/images/page/logo.svg" alt="">
                                </a>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-e5c92af" data-id="e5c92af" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                        <div class="elementor-element elementor-element-23ae00a elementor-icon-list--layout-inline elementor-widget__width-auto elementor-mobile-align-center elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="23ae00a" data-element_type="widget" data-widget_type="icon-list.default">
                            <div class="elementor-widget-container">
                                <ul class="elementor-icon-list-items elementor-inline-items">
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                    <a href="/"><span class="elementor-icon-list-text">Tuyển dụng</span>
                                    </a>
                                    </li>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                    <a href="/"><span class="elementor-icon-list-text">Liên hệ</span>
                                    </a>
                                    </li>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                        <a class="hotline_header flex-center" href="/">
                                            <span class="elementor-icon-list-text text-center">GỌI NGAY <br> 02213 997 768</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <div id="main_content">
            <?= $content ?>
        </div>
        <footer class="agrikon-elementor-footer footer-739">
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
            <div data-elementor-type="section" data-elementor-id="739" class="elementor elementor-739">
                <div class="elementor-inner">
                    <div class="elementor-section-wrap">
                        <div class="elementor-section elementor-top-section elementor-element elementor-element-14526050 elementor-section-full_width nt-structure nt-structure-yes nt-section-ripped-top ripped-top-yes elementor-section-height-default elementor-section-height-default nt-section-ripped-bottom ripped-bottom-no" data-id="14526050" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                        <div class="elementor-container elementor-column-gap-no">
                            <div class="elementor-row">
                                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-38747b76" data-id="38747b76" data-element_type="column">
                                    <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-185bba6 elementor-widget__width-auto elementor-absolute elementor-hidden-phone elementor-widget elementor-widget-image" data-id="185bba6" data-element_type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-image">
                                                <img data-lazyloaded="1" src="./Home – Shop – Agrikon_files/footer-bg-icon-2.png" width="314" height="336" data-src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2.png" class="attachment-medium_large size-medium_large wp-image-587 entered litespeed-loaded" alt="" data-srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2.png 314w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2-280x300.png 280w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2-28x30.png 28w" data-sizes="(max-width: 314px) 100vw, 314px" data-ll-status="loaded" sizes="(max-width: 314px) 100vw, 314px" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2.png 314w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2-280x300.png 280w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2-28x30.png 28w">
                                                <noscript><img width="314" height="336" src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2.png" class="attachment-medium_large size-medium_large wp-image-587" alt="" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2.png 314w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2-280x300.png 280w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-2-28x30.png 28w" sizes="(max-width: 314px) 100vw, 314px" /></noscript>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="elementor-element elementor-element-257a9126 elementor-widget__width-auto elementor-absolute elementor-widget elementor-widget-image" data-id="257a9126" data-element_type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-image">
                                                <img data-lazyloaded="1" src="./Home – Shop – Agrikon_files/footer-bg-icon.png" width="662" height="321" data-src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon.png" class="attachment-large size-large wp-image-586 entered litespeed-loaded" alt="" data-srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon.png 662w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-300x145.png 300w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-62x30.png 62w" data-sizes="(max-width: 662px) 100vw, 662px" data-ll-status="loaded" sizes="(max-width: 662px) 100vw, 662px" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon.png 662w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-300x145.png 300w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-62x30.png 62w">
                                                <noscript><img width="662" height="321" src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon.png" class="attachment-large size-large wp-image-586" alt="" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon.png 662w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-300x145.png 300w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/footer-bg-icon-62x30.png 62w" sizes="(max-width: 662px) 100vw, 662px" /></noscript>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="elementor-section elementor-inner-section elementor-element elementor-element-727c466e nt-structure nt-structure-yes elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="727c466e" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                            <div class="elementor-container elementor-column-gap-no">
                                                <div class="elementor-row">
                                                <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-6c39c5c4" data-id="6c39c5c4" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-2037345 elementor-widget elementor-widget-image" data-id="2037345" data-element_type="widget" data-widget_type="image.default">
                                                            <div class="elementor-widget-container">
                                                                <div class="elementor-image">
                                                                    <img data-lazyloaded="1" src="./Home – Shop – Agrikon_files/logo-light-300x91.png" width="300" height="91" data-src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-300x91.png" class="attachment-medium size-medium wp-image-558 entered litespeed-loaded" alt="" data-srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-300x91.png 300w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-99x30.png 99w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light.png 626w" data-sizes="(max-width: 300px) 100vw, 300px" data-ll-status="loaded" sizes="(max-width: 300px) 100vw, 300px" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-300x91.png 300w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-99x30.png 99w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light.png 626w">
                                                                    <noscript><img width="300" height="91" src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-300x91.png" class="attachment-medium size-medium wp-image-558" alt="" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-300x91.png 300w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light-99x30.png 99w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/12/logo-light.png 626w" sizes="(max-width: 300px) 100vw, 300px" /></noscript>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-793e8037 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="793e8037" data-element_type="widget" data-widget_type="heading.default">
                                                            <div class="elementor-widget-container">
                                                                <p class="elementor-heading-title elementor-size-default">There are many variations of passages of lorem ipsum available, but the majority suffered.</p>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-47fcf305 elementor-widget elementor-widget-agrikon-contact-form-7" data-id="47fcf305" data-element_type="widget" data-widget_type="agrikon-contact-form-7.default">
                                                            <div class="elementor-widget-container">
                                                                <div class="nt-cf7-form-wrapper form_47fcf305">
                                                                    <div class="wpcf7 no-js" id="wpcf7-f560-o1" lang="en-US" dir="ltr">
                                                                        <div class="screen-reader-response">
                                                                        <p role="status" aria-live="polite" aria-atomic="true"></p>
                                                                        <ul></ul>
                                                                        </div>
                                                                        <form action="https://ninetheme.com/themes/agrikon/home-shop/#wpcf7-f560-o1" method="post" class="wpcf7-form init demo" aria-label="Contact form" novalidate="novalidate" data-status="init">
                                                                        <div style="display: none;">
                                                                            <input type="hidden" name="_wpcf7" value="560">
                                                                            <input type="hidden" name="_wpcf7_version" value="5.7.7">
                                                                            <input type="hidden" name="_wpcf7_locale" value="en_US">
                                                                            <input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f560-o1">
                                                                            <input type="hidden" name="_wpcf7_container_post" value="0">
                                                                            <input type="hidden" name="_wpcf7_posted_data_hash" value="">
                                                                        </div>
                                                                        <div class="footer-widget">
                                                                            <div class="mc-form">
                                                                                <p><span class="wpcf7-form-control-wrap" data-name="email-434"><input size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" placeholder="Email Address" value="" type="email" name="email-434"></span><br>
                                                                                    <button type="submit" class="wpcf7-submit"><i class="agrikon-icon-right-arrow"></i></button>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="wpcf7-response-output" aria-hidden="true"></div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-4a9c3ee8 elementor-shape-circle e-grid-align-left elementor-grid-0 elementor-widget elementor-widget-social-icons" data-id="4a9c3ee8" data-element_type="widget" data-widget_type="social-icons.default">
                                                            <div class="elementor-widget-container">
                                                                <div class="elementor-social-icons-wrapper elementor-grid">
                                                                    <span class="elementor-grid-item">
                                                                    <a class="elementor-icon elementor-social-icon elementor-social-icon-facebook elementor-repeater-item-0efa240" href="https://ninetheme.com/themes/agrikon/" target="_blank">
                                                                    <span class="elementor-screen-only">Facebook</span>
                                                                    <i class="fab fa-facebook"></i>					</a>
                                                                    </span>
                                                                    <span class="elementor-grid-item">
                                                                    <a class="elementor-icon elementor-social-icon elementor-social-icon-twitter elementor-repeater-item-fcbf7c3" href="https://ninetheme.com/themes/agrikon/" target="_blank">
                                                                    <span class="elementor-screen-only">Twitter</span>
                                                                    <i class="fab fa-twitter"></i>					</a>
                                                                    </span>
                                                                    <span class="elementor-grid-item">
                                                                    <a class="elementor-icon elementor-social-icon elementor-social-icon-pinterest elementor-repeater-item-813606e" href="https://ninetheme.com/themes/agrikon/" target="_blank">
                                                                    <span class="elementor-screen-only">Pinterest</span>
                                                                    <i class="fab fa-pinterest"></i>					</a>
                                                                    </span>
                                                                    <span class="elementor-grid-item">
                                                                    <a class="elementor-icon elementor-social-icon elementor-social-icon-instagram elementor-repeater-item-afbbe30" href="https://ninetheme.com/themes/agrikon/" target="_blank">
                                                                    <span class="elementor-screen-only">Instagram</span>
                                                                    <i class="fab fa-instagram"></i>					</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-521a428d" data-id="521a428d" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-467b4e72 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="467b4e72" data-element_type="widget" data-widget_type="heading.default">
                                                            <div class="elementor-widget-container">
                                                                <h3 class="elementor-heading-title elementor-size-default">Links</h3>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-6ed4eec elementor-align-left elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="6ed4eec" data-element_type="widget" data-widget_type="icon-list.default">
                                                            <div class="elementor-widget-container">
                                                                <ul class="elementor-icon-list-items">
                                                                    <li class="elementor-icon-list-item">
                                                                        <a href="https://ninetheme.com/themes/agrikon/projects/"><span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="fas fa-chevron-right"></i>						</span>
                                                                        <span class="elementor-icon-list-text">Our Projects</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <a href="https://ninetheme.com/themes/agrikon/about/"><span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="fas fa-chevron-right"></i>						</span>
                                                                        <span class="elementor-icon-list-text">About us</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <a href="https://ninetheme.com/themes/agrikon/services/"><span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="fas fa-chevron-right"></i>						</span>
                                                                        <span class="elementor-icon-list-text">Our Services</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <a href="https://ninetheme.com/themes/agrikon/service-details/"><span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="fas fa-chevron-right"></i>						</span>
                                                                        <span class="elementor-icon-list-text">Upcoming Events</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <a href="https://ninetheme.com/themes/agrikon/about/"><span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="fas fa-chevron-right"></i>						</span>
                                                                        <span class="elementor-icon-list-text">Volunteers</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-760a6c93" data-id="760a6c93" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-6250818a agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="6250818a" data-element_type="widget" data-widget_type="heading.default">
                                                            <div class="elementor-widget-container">
                                                                <h3 class="elementor-heading-title elementor-size-default">News</h3>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-3b7b2ee5 elementor-widget elementor-widget-agrikon-post-types-list" data-id="3b7b2ee5" data-element_type="widget" data-widget_type="agrikon-post-types-list.default">
                                                            <div class="elementor-widget-container">
                                                                <ul class="list-unstyled footer-widget__post nt-post-list nt-orderby-rand">
                                                                    <li class="nt-post-list-item nt-post-id-2402 nt-post-type-post">
                                                                        <img data-lazyloaded="1" src="./Home – Shop – Agrikon_files/organic-news-20-150x150.jpg" width="150" height="150" data-src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-150x150.jpg" class="b-img wp-post-image entered litespeed-loaded" alt="" decoding="async" data-srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-150x150.jpg 150w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-e1614194419351-450x450.jpg 450w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-e1614194419351-100x100.jpg 100w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-500x500.jpg 500w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-750x750.jpg 750w" data-sizes="(max-width: 150px) 100vw, 150px" data-ll-status="loaded" sizes="(max-width: 150px) 100vw, 150px" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-150x150.jpg 150w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-e1614194419351-450x450.jpg 450w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-e1614194419351-100x100.jpg 100w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-500x500.jpg 500w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-750x750.jpg 750w">
                                                                        <noscript><img width="150" height="150" src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-150x150.jpg" class="b-img wp-post-image" alt="" decoding="async" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-150x150.jpg 150w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-e1614194419351-450x450.jpg 450w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-e1614194419351-100x100.jpg 100w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-500x500.jpg 500w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-20-750x750.jpg 750w" sizes="(max-width: 150px) 100vw, 150px" /></noscript>
                                                                        <div class="footer-widget__post-content">
                                                                        <span class="date">Feb 8, 2020</span>
                                                                        <h4 class="title"><a href="https://ninetheme.com/themes/agrikon/healthiest-beans-and-legumes/" title="Healthiest Beans and Legumes">Healthiest Beans and Legumes</a></h4>
                                                                        </div>
                                                                    </li>
                                                                    <li class="nt-post-list-item nt-post-id-2404 nt-post-type-post">
                                                                        <img data-lazyloaded="1" src="./Home – Shop – Agrikon_files/organic-news-6-e1608714911535-150x150.jpg" width="150" height="150" data-src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-150x150.jpg" class="b-img wp-post-image entered litespeed-loaded" alt="" decoding="async" data-srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-150x150.jpg 150w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-450x450.jpg 450w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-100x100.jpg 100w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-500x500.jpg 500w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-750x750.jpg 750w" data-sizes="(max-width: 150px) 100vw, 150px" data-ll-status="loaded" sizes="(max-width: 150px) 100vw, 150px" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-150x150.jpg 150w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-450x450.jpg 450w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-100x100.jpg 100w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-500x500.jpg 500w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-750x750.jpg 750w">
                                                                        <noscript><img width="150" height="150" src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-150x150.jpg" class="b-img wp-post-image" alt="" decoding="async" srcset="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-150x150.jpg 150w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-450x450.jpg 450w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-100x100.jpg 100w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-500x500.jpg 500w, https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-6-e1608714911535-750x750.jpg 750w" sizes="(max-width: 150px) 100vw, 150px" /></noscript>
                                                                        <div class="footer-widget__post-content">
                                                                        <span class="date">Feb 8, 2020</span>
                                                                        <h4 class="title"><a href="https://ninetheme.com/themes/agrikon/friendly-breakfast-ideas/" title="Friendly Breakfast Ideas">Friendly Breakfast Ideas</a></h4>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-7f043fa4" data-id="7f043fa4" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-11a6cca4 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="11a6cca4" data-element_type="widget" data-widget_type="heading.default">
                                                            <div class="elementor-widget-container">
                                                                <h3 class="elementor-heading-title elementor-size-default">Contact</h3>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-3a96ffcb elementor-align-left elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="3a96ffcb" data-element_type="widget" data-widget_type="icon-list.default">
                                                            <div class="elementor-widget-container">
                                                                <ul class="elementor-icon-list-items">
                                                                    <li class="elementor-icon-list-item">
                                                                        <span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="fab fa-whatsapp"></i>						</span>
                                                                        <span class="elementor-icon-list-text">555 342 0032</span>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="flaticon seorun-icon agrikon-icon-telephone"></i>						</span>
                                                                        <span class="elementor-icon-list-text">666 888 0000</span>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="flaticon seorun-icon agrikon-icon-email"></i>						</span>
                                                                        <span class="elementor-icon-list-text">needhelp@company.com</span>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <span class="elementor-icon-list-icon">
                                                                        <i aria-hidden="true" class="flaticon seorun-icon agrikon-icon-pin"></i>						</span>
                                                                        <span class="elementor-icon-list-text">80 broklyn golden street line New York, USA</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="elementor-section elementor-inner-section elementor-element elementor-element-50e0ac80 nt-section-ripped-top ripped-top-yes elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-bottom ripped-bottom-no" data-id="50e0ac80" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                            <div class="elementor-container elementor-column-gap-no">
                                                <div class="elementor-row">
                                                <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-396a338b" data-id="396a338b" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-2c4c7a0a agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="2c4c7a0a" data-element_type="widget" data-widget_type="heading.default">
                                                            <div class="elementor-widget-container">
                                                                <p class="elementor-heading-title elementor-size-default">© Copyright 2020 by Ninetheme.com</p>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-474a237f" data-id="474a237f" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-4fa1fa37 elementor-icon-list--layout-inline elementor-align-right elementor-tablet-align-center elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="4fa1fa37" data-element_type="widget" data-widget_type="icon-list.default">
                                                            <div class="elementor-widget-container">
                                                                <ul class="elementor-icon-list-items elementor-inline-items">
                                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                                        <span class="elementor-icon-list-text">Terms &amp; Conditions</span>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                                        <span class="elementor-icon-list-text">/</span>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                                        <span class="elementor-icon-list-text">Privacy Policy</span>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                                        <span class="elementor-icon-list-text">/</span>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                                        <span class="elementor-icon-list-text">Sitemap</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
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
