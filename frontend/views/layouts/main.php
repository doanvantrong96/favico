<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use backend\models\Category;
use backend\models\Config;

AppAsset::register($this);



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

$config = Config::find()->where(['status' => 1])->orderBy(['position' => SORT_ASC])->asArray()->all();
$menu_top_left = [];
$menu_top_right = [];
$hotline = '';
$address = '';
$work_time = '';
$email = '';
$facebook = '';
$youtube = '';
$email = '';
foreach($config as $row){
    if($row['type'] == 'menu_top_left')
        array_push($menu_top_left, $row);
    if($row['type'] == 'menu_top_right')
        array_push($menu_top_right, $row);
    if($row['type'] == 'hotline')
        $hotline = $row;
    if($row['type'] == 'address')
        $address = $row;
    if($row['type'] == 'email')
        $email = $row;
    if($row['type'] == 'work_time')
        $work_time = $row;
    if($row['type'] == 'facebook')
        $facebook = $row;
    if($row['type'] == 'youtube')
        $youtube = $row;
    if($row['type'] == 'email')
        $email = $row;
}

$url_full = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
        <link rel="stylesheet" id="wp-bootstrap-starter-fontawesome-cdn-css" href="/css/fontawesome.min.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/css/all.min.css" crossorigin="anonymous" />
        <link data-optimized="2" rel="stylesheet" href="/css/layout.css">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="icon" type="image/png" href="/images/icon/logo-fa.svg" sizes="50x50">
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
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?= Html::encode($this->title) ?>">
        <meta property="og:description" content="">
        
        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="">
        <meta name="twitter:title" content="<?= Html::encode($this->title) ?>">
        <meta name="twitter:description" content="">
        <meta name="twitter:image" content="/images/icon/logo-fa.svg">


        <title><?= Html::encode($this->title) ?></title>
        <?php $this->
        head() ?>
        <style>
            @import url(https://fonts.googleapis.com/css?family=Lato:600, 500, 400, 300&display=swap);
        </style>

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0&appId=1438665563271474&autoLogAppEvents=1" nonce="NvknslKE"></script>

        <!--Start of Tawk.to Script New-->
            <!-- <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/63fa203531ebfa0fe7ef489d/1gq4grko2';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
            </script> -->
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
    <div class="logo-box">
        <a href="/" aria-label="logo image" class="nt-logo header-logo logo-type-img has-mobile-logo">
            <img class="main-logo" src="/images/page/logo.png" alt="Agrikon" />
        </a>
        <span class="fa fa-bars mobile-nav__toggler"></span>
    </div>
    <div class="mobile-nav__wrapper mobile-nav__default">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="far fa-times"></i></span>
            <div class="mobile-nav__container">
                <div class="container">
                    <ul class="main-menu__list">
                        <?php foreach($menu_top_left as $row) { ?>
                            <li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item"><a href="<?= $row['value'] ?>"><?= $row['name'] ?></a></li>
                        <?php } ?>
                        <?php foreach($menu_top_right as $row) { ?>
                            <li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item"><a href="<?= $row['value'] ?>"><?= $row['name'] ?></a></li>
                        <?php } ?>
                        <li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item">
                            <a class="hotline_header hotline_mb flex-center" href="<?= $hotline['value'] ?>">
                                <span>GỌI NGAY</span>
                                <p class="mb-0"><?= $hotline['name'] ?></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>    
    <div class="elementor-2700 elementor">
        <div id="fb-customer-chat"></div>
        <section class=" <?= ($controller == 'site' && $action == 'index') ? 'theme_home' : 'not_theme_home' ?> elementor-section elementor-top-section elementor-element elementor-element-6ac7fd0 elementor-section-height-min-height elementor-hidden-tablet elementor-hidden-phone elementor-section-boxed elementor-section-height-default elementor-section-items-middle nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="6ac7fd0" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
            <div class="elementor-container elementor-column-gap-default">
            <div class="elementor-row align-items-center">
                <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-7d7708f" data-id="7d7708f" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                        <div class="elementor-element elementor-element-794a64d elementor-icon-list--layout-inline elementor-mobile-align-center elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="794a64d" data-element_type="widget" data-widget_type="icon-list.default">
                            <div class="elementor-widget-container">
                                <ul class="elementor-icon-list-items elementor-inline-items">
                                        <?php foreach($menu_top_left as $row) { ?>
                                            <li class="elementor-icon-list-item elementor-inline-item">
                                                <a href="<?= $row['value'] ?>"><span class=" <?= $url_full == $row['value'] ? 'active' : '' ?> elementor-icon-list-text"><?= $row['name'] ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                      
                                        <li class="elementor-icon-list-item elementor-inline-item">
                                        <a href="javascript:;"><span class="elementor-icon-list-text">Tin tức</span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php 
                                                $cat = Category::find()->where(['status' => 1,'is_delete' => 0])->all();
                                                if(!empty($cat)){
                                                    foreach($cat as $row){
                                            ?>
                                            <li><a class="dropdown-item" href="<?= Url::to(['news/index', 'slug' => $row['slug']]); ?>"><?= $row['name'] ?></a></li>
                                            <?php }} ?>
                                        </ul>
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
                                <a href="/">
                                    <img class="logo_header" src="<?= ($controller == 'site' && $action == 'index') ? '/images/page/logo.svg' : '/images/page/logo-green.svg' ?>" alt="">
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
                                    <?php foreach($menu_top_right as $row) { ?>
                                        <li class="elementor-icon-list-item elementor-inline-item">
                                            <a href="<?= $row['value'] ?>"><span class=" <?= $url_full == $row['value'] ? 'active' : '' ?> elementor-icon-list-text"><?= $row['name'] ?></span></a>
                                        </li>
                                    <?php } ?>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                        <a class="hotline_header flex-center" href="<?= $hotline['value'] ?>">
                                            <span class=" text-center text-white">GỌI NGAY <br> <?= $hotline['name'] ?></span>
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
        <section class=" <?= ($controller == 'site' && $action == 'index') ? 'home_sticky' : 'not_theme_home not_home_sticky' ?> menu_hidden elementor-section elementor-top-section elementor-element elementor-element-6ac7fd0 elementor-section-height-min-height elementor-hidden-tablet elementor-hidden-phone elementor-section-boxed elementor-section-height-default elementor-section-items-middle nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="6ac7fd0" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
            <div class="elementor-container elementor-column-gap-default">
            <div class="elementor-row align-items-center">
                <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-7d7708f" data-id="7d7708f" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                        <div class="elementor-element elementor-element-794a64d elementor-icon-list--layout-inline elementor-mobile-align-center elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="794a64d" data-element_type="widget" data-widget_type="icon-list.default">
                            <div class="elementor-widget-container">
                                <ul class="elementor-icon-list-items elementor-inline-items">
                                    <?php foreach($menu_top_left as $row) { ?>
                                        <li class="elementor-icon-list-item elementor-inline-item">
                                            <a href="<?= $row['value'] ?>"><span class="elementor-icon-list-text <?= $url_full == $row['value'] ? 'active' : '' ?>"><?= $row['name'] ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                        <a href="javascript:;"><span class="<?= $controller.'/'.$action == 'news/detail' ? 'active' : '' ?> elementor-icon-list-text">Tin tức</span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php 
                                                $cat = Category::find()->where(['status' => 1,'is_delete' => 0])->all();    
                                                if(!empty($cat)){
                                                    foreach($cat as $row){
                                            ?>
                                            <li><a class="dropdown-item" href="<?= Url::to(['news/index', 'slug' => $row['slug']]); ?>"><?= $row['name'] ?></a></li>
                                            <?php }} ?>
                                        </ul>
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
                                <a href="/">
                                    <img class="logo_header" src="<?= ($controller == 'site' && $action == 'index') ? '/images/page/logo.svg' : '/images/page/logo-green.svg' ?>" alt="">
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
                                    <?php foreach($menu_top_right as $row) { ?>
                                        <li class="elementor-icon-list-item elementor-inline-item">
                                            <a href="<?= $row['value'] ?>"><span class="<?= $url_full == $row['value'] ? 'active' : '' ?> elementor-icon-list-text"><?= $row['name'] ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="elementor-icon-list-item elementor-inline-item">
                                        <a class="hotline_header flex-center" href="<?= $hotline['value'] ?>">
                                            <span class=" text-center text-white">GỌI NGAY <br> <?= $hotline['name'] ?></span>
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
                <div class="elementor-inner footer_bg">
                    <div class="elementor-section-wrap">
                        <div class="elementor-section elementor-top-section elementor-element elementor-element-14526050 elementor-section-full_width nt-structure nt-structure-yes nt-section-ripped-top ripped-top-yes elementor-section-height-default elementor-section-height-default nt-section-ripped-bottom ripped-bottom-no" data-id="14526050" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                        <div class="elementor-container elementor-column-gap-no">
                            <div class="elementor-row">
                                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-38747b76" data-id="38747b76" data-element_type="column">
                                    <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-section elementor-inner-section elementor-element elementor-element-727c466e nt-structure nt-structure-yes elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no" data-id="727c466e" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                            <div class="elementor-container elementor-column-gap-no">
                                                <div class="elementor-row grid_ft">
                                                <div class="elementor-column elementor-inner-column elementor-element" data-id="6c39c5c4" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-2037345 elementor-widget elementor-widget-image" data-id="2037345" data-element_type="widget" data-widget_type="image.default">
                                                            <div class="elementor-widget-container">
                                                                <div class="elementor-image">
                                                                    <img data-lazyloaded="1" src="/images/page/logo.svg" width="300" height="91" data-src="/images/page/logo.svg" class="attachment-medium size-medium wp-image-558 entered litespeed-loaded" alt="" data-srcset="/images/page/logo.svg " data-sizes="(max-width: 300px) 100vw, 300px" data-ll-status="loaded" sizes="(max-width: 300px) 100vw, 300px" srcset="/images/page/logo.svg">
                                                                    <noscript><img width="300" height="91" src="/images/page/logo.svg" class="attachment-medium size-medium wp-image-558" alt="" srcset="/images/page/logo.svg" sizes="(max-width: 300px) 100vw, 300px" /></noscript>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-793e8037 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="793e8037" data-element_type="widget" data-widget_type="heading.default">
                                                            <div class="elementor-widget-container">
                                                                <p class="elementor-heading-title text-white font-weight-bold">CÔNG TY CỔ PHẦN THỨC ĂN CHĂN NUÔI PHAVICO</p>
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
                                                                        <form>
                                                                        <div class="footer-widget">
                                                                            <p class="text-white mt-4">Đăng ký để nhận tin tức mới nhất</p>
                                                                            <div class="mc-form d-flex">
                                                                                <p class="mb-0"><span class="wpcf7-form-control-wrap" data-name="email-434"><input size="40" class="email_offer wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" placeholder="Email của bạn" value="" type="email" name="email-434"></span><br>
                                                                                    <button id="send_mail" type="button" class="wpcf7-submit"><img src="/images/icon/rignt.svg" alt=""></button>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="wpcf7-response-output" aria-hidden="true"></div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gr_item_ft">
                                                    <div class="elementor-column elementor-inner-column elementor-element" data-id="521a428d" data-element_type="column">
                                                        <div class="elementor-column-wrap elementor-element-populated">
                                                            <div class="elementor-widget-wrap">
                                                                <div class="elementor-element  agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="467b4e72" data-element_type="widget" data-widget_type="heading.default">
                                                                <div class="elementor-widget-container">
                                                                    <h3 class="elementor-heading-title elementor-size-default title_ft text-white">Phavico</h3>
                                                                    <div class="br_ft"><i></i></div>
                                                                </div>
                                                                </div>
                                                                <div class="elementor-element elementor-element-6ed4eec elementor-align-left elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="6ed4eec" data-element_type="widget" data-widget_type="icon-list.default">
                                                                <div class="elementor-widget-container">
                                                                    <ul class="elementor-icon-list-items">
                                                                    <?php foreach($menu_top_left as $row) { ?>
                                                                        <li class="elementor-icon-list-item">
                                                                            <a href="<?= $row['value'] ?>">
                                                                            <span class="elementor-icon-list-text link_ft"><?= $row['name'] ?></span>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="elementor-column elementor-inner-column elementor-element" data-id="521a428d" data-element_type="column">
                                                        <div class="elementor-column-wrap elementor-element-populated">
                                                            <div class="elementor-widget-wrap">
                                                                <div class="elementor-element agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="467b4e72" data-element_type="widget" data-widget_type="heading.default">
                                                                <div class="elementor-widget-container">
                                                                    <h3 class="elementor-heading-title elementor-size-default title_ft text-white">Liên kết</h3>
                                                                    <div class="br_ft"><i></i></div>
                                                                </div>
                                                                </div>
                                                                <div class="elementor-element elementor-element-6ed4eec elementor-align-left elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="6ed4eec" data-element_type="widget" data-widget_type="icon-list.default">
                                                                <div class="elementor-widget-container">
                                                                    <ul class="elementor-icon-list-items">
                                                                        <?php foreach($menu_top_right as $row) { ?>
                                                                            <li class="elementor-icon-list-item">
                                                                                <a href="<?= $row['value'] ?>">
                                                                                <span class="elementor-icon-list-text link_ft"><?= $row['name'] ?></span>
                                                                                </a>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-column elementor-inner-column elementor-element" data-id="7f043fa4" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element agrikon-transform transform-type-translate elementor-widget elementor-widget-heading" data-id="11a6cca4" data-element_type="widget" data-widget_type="heading.default">
                                                            <div class="elementor-widget-container">
                                                                <h3 class="elementor-heading-title elementor-size-default title_ft text-white">Địa chỉ</h3>
                                                                <div class="br_ft"><i></i></div>
                                                            </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-3a96ffcb elementor-align-left elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="3a96ffcb" data-element_type="widget" data-widget_type="icon-list.default">
                                                            <div class="elementor-widget-container">
                                                                <ul class="elementor-icon-list-items">
                                                                    <li class="elementor-icon-list-item">
                                                                        <img src="/images/icon/f1.svg" alt="">
                                                                        <div>
                                                                        <p class="text-white"><?= $address['name'] ?></p>
                                                                        </div>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <img src="/images/icon/f2.svg" alt="">
                                                                        <p class="text-white"><?= $hotline['name'] ?></p>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <img src="/images/icon/f3.svg" alt="">
                                                                        <p class="text-white">Thời gian làm việc: <?= $work_time['name'] ?></p>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <img src="/images/icon/f4.svg" alt="">
                                                                        <p class="text-white"><?= $email['name'] ?></p>
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
                                                                <p class="elementor-heading-title elementor-size-default">Copyrights © 2012-2023 CÔNG TY CP THỨC ĂN CHĂN NUÔI PHAVICO.</p>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-474a237f" data-id="474a237f" data-element_type="column">
                                                    <div class="elementor-column-wrap elementor-element-populated">
                                                        <div class="elementor-widget-wrap">
                                                            <div class="elementor-element elementor-element-4fa1fa37 elementor-icon-list--layout-inline elementor-align-right elementor-tablet-align-center elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="4fa1fa37" data-element_type="widget" data-widget_type="icon-list.default">
                                                            <div class="elementor-widget-container gr_frs">
                                                                <p class="mb-0 fz-14 text-gr">Gọi cho chúng tôi <?= $hotline['name'] ?></p>
                                                                <div>
                                                                    <a href="<?= isset($facebook['value']) ? $facebook['value'] : '' ?>"><img src="/images/icon/s1.svg" alt=""></a>
                                                                    <a href="mailto:<?= isset($email['name']) ? $email['name'] : '' ?>"><img src="/images/icon/s2.svg" alt=""></a>
                                                                    <a href="<?= isset($youtube['value']) ? $youtube['value'] : '' ?>"><img src="/images/icon/s3.svg" alt=""></a>
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
