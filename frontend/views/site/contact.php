<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Liên hệ';
?>
<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p>LIÊN HỆ</p>
    </div>
    <h6>Liên Hệ</h6>
</section>

<section class="content_contact elementor elementor-1303">
    <div class="elementor-section-wrap">
        <div
            class="elementor-section elementor-top-section elementor-element elementor-element-14548c2 nt-section section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-bottom ripped-bottom-no"
            data-id="14548c2"
            data-element_type="section"
        >
            <div class="elementor-container elementor-column-gap-no">
                <div class="elementor-row">
                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-f8d2eed" data-id="f8d2eed" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                            <div class="elementor-widget-wrap">
                                <div class="text_left_ct">
                                    <img class="logo_ct" src="/images/page/logo-green.svg" alt="">
                                    <p class="p_lh">LIÊN HỆ NGAY</p>
                                    <span class="sp_lh">Để lại lời nhắn</span>
                                    <p class="lh_hi">Xin chào, hãy liên hệ với chúng tôi để được giải đáp mọi thắc mắc. <br> Có rất nhiều cách để liên hệ với chúng tôi</p>
                                    <div class="gr_ct_left">
                                        <div class="item_ct_left">
                                            <img src="/images/icon/ctl1.svg" alt="">
                                            <div>
                                                <span>VĂN PHÒNG ĐẠI DIỆN:</span>
                                                <p>Địa chỉ: TT 12-04, Khu 31ha, Thị trấn Trâu Quỳ, Gia Lâm, Hà Nội</p>
                                            </div>
                                        </div>
                                        <div class="item_ct_left">
                                            <img src="/images/icon/ctl2.svg" alt="">
                                            <div>
                                                <span>NHÀ MÁY SẢN XUẤT:</span>
                                                <p>Nhà máy 1: An Lạc, Trưng Trắc, Văn Lâm, Hưng Yên <br> Nhà máy 2: Km7, Quốc lộ 39, thị trấn Yên Mỹ, H. Yên Mỹ, Hưng Yên</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-06c9cc4" data-id="06c9cc4" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                            <div class="elementor-widget-wrap">
                                <div class="elementor-element elementor-element-4a3200d elementor-widget elementor-widget-agrikon-contact-form-7" data-id="4a3200d" data-element_type="widget" data-widget_type="agrikon-contact-form-7.default">
                                    <div class="elementor-widget-container">
                                        <div class="nt-cf7-form-wrapper form_4a3200d">
                                            <div class="wpcf7 no-js" id="wpcf7-f1338-p1303-o1" lang="en-US" dir="ltr">
                                                <div class="screen-reader-response">
                                                    <p role="status" aria-live="polite" aria-atomic="true"></p>
                                                    <ul></ul>
                                                </div>
                                                <?php $form = ActiveForm::begin(); ?>
                                                    <div class="contact-one__form">
                                                        <div class="row">

                                                            <?= $form->field($model, 'name', ['options' => ['class' => 'col-lg-6 form_ct']])->textInput(['class' => 'aaa', 'placeholder' => 'Họ và tên *'])->label(false) ?>
                                                            
                                                            <?= $form->field($model, 'phone', ['options' => ['class' => 'col-lg-6 form_ct']])->textInput(['class' => 'aaa', 'placeholder' => 'Số điện thoại *'])->label(false) ?>
                                                            
                                                            <?= $form->field($model, 'email', ['options' => ['class' => 'col-lg-6 form_ct']])->textInput(['class' => 'aaa', 'placeholder' => 'Email'])->label(false) ?>

                                                            <?= $form->field($model, 'address', ['options' => ['class' => 'col-lg-6 form_ct']])->textInput(['class' => 'aaa', 'placeholder' => 'Địa chỉ'])->label(false) ?>
                                                            
                                                            <?= $form->field($model, 'note', ['options' => ['class' => 'col-lg-12 form_ct']])->textarea(['class' => 'aaa', 'placeholder' => 'Nội dung'])->label(false) ?>
                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <?= Html::submitButton('Gửi tin nhắn', ['class' => 'btn btn-primary thm-btn']) ?>
                                                    </div>

                                                <?php ActiveForm::end(); ?>
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
        <div
            class="elementor-section elementor-top-section elementor-element elementor-element-d964f0a elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no"
            data-id="d964f0a"
            data-element_type="section"
        >
            <div class="elementor-container elementor-column-gap-no">
                <div class="elementor-row">
                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-1850638" data-id="1850638" data-element_type="column" data-settings='{"background_background":"classic"}'>
                        <div class="elementor-column-wrap elementor-element-populated">
                            <div class="elementor-widget-wrap">
                                <div
                                    class="gr_ct elementor-section elementor-inner-section elementor-element elementor-element-6360141 elementor-section-content-top elementor-section-boxed elementor-section-height-default elementor-section-height-default nt-section-ripped-top ripped-top-no nt-section-ripped-bottom ripped-bottom-no"
                                    data-id="6360141"
                                    data-element_type="section"
                                    data-settings='{"background_background":"classic"}'
                                >
                                    <div class="elementor-container elementor-column-gap-no">
                                        <div class="elementor-row">
                                            <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-c1f20f3" data-id="c1f20f3" data-element_type="column">
                                                <div class="elementor-column-wrap elementor-element-populated">
                                                    <div class="elementor-widget-wrap">
                                                        <div
                                                            class="elementor-element elementor-element-133ec26 elementor-view-stacked elementor-shape-circle elementor-widget elementor-widget-icon"
                                                            data-id="133ec26"
                                                            data-element_type="widget"
                                                            data-widget_type="icon.default"
                                                        >
                                                            <div class="elementor-widget-container">
                                                                <div class="elementor-icon-wrapper">
                                                                    <div class="elementor-icon">
                                                                        <img src="/images/icon/ct1.svg" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="elementor-element elementor-element-770edb1 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading"
                                                            data-id="770edb1"
                                                            data-element_type="widget"
                                                            data-widget_type="heading.default"
                                                        >
                                                            <div class="elementor-widget-container"><h3 class="elementor-heading-title elementor-size-default">Địa chỉ</h3></div>
                                                        </div>
                                                        <div
                                                            class="elementor-element elementor-element-8cac106 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading"
                                                            data-id="8cac106"
                                                            data-element_type="widget"
                                                            data-widget_type="heading.default"
                                                        >
                                                            <div class="elementor-widget-container">
                                                                <p class="elementor-heading-title elementor-size-default p_ct">
                                                                <strong>Nhà máy 1:</strong> An Lạc, Trưng Trắc, Văn Lâm, Hưng Yên <br>
                                                                <strong>Nhà máy 2:</strong> Km7, Quốc lộ 39, thị trấn Yên Mỹ, <br>
                                                                H. Yên Mỹ, Hưng Yên
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-5ea00db" data-id="5ea00db" data-element_type="column">
                                                <div class="elementor-column-wrap elementor-element-populated">
                                                    <div class="elementor-widget-wrap">
                                                        <div
                                                            class="elementor-element elementor-element-47d265e elementor-view-stacked elementor-shape-circle elementor-widget elementor-widget-icon"
                                                            data-id="47d265e"
                                                            data-element_type="widget"
                                                            data-widget_type="icon.default"
                                                        >
                                                            <div class="elementor-widget-container">
                                                                <div class="elementor-icon-wrapper">
                                                                    <div class="elementor-icon">
                                                                        <img src="/images/icon/ct2.svg" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="elementor-element elementor-element-0b78905 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading"
                                                            data-id="0b78905"
                                                            data-element_type="widget"
                                                            data-widget_type="heading.default"
                                                        >
                                                            <div class="elementor-widget-container"><h3 class="elementor-heading-title elementor-size-default">Lịch làm việc</h3></div>
                                                        </div>
                                                        <div
                                                            class="elementor-element elementor-element-c23b612 elementor-widget__width-initial agrikon-transform transform-type-translate elementor-widget elementor-widget-heading"
                                                            data-id="c23b612"
                                                            data-element_type="widget"
                                                            data-widget_type="heading.default"
                                                        >
                                                            <div class="elementor-widget-container">
                                                                <p class="elementor-heading-title elementor-size-default p_ct">Thời gian làm việc: T.Hai - T.Bảy: <br>  7h00 - 17h00.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-8e44475" data-id="8e44475" data-element_type="column">
                                                <div class="elementor-column-wrap elementor-element-populated">
                                                    <div class="elementor-widget-wrap">
                                                        <div
                                                            class="elementor-element elementor-element-5ce094a elementor-view-stacked elementor-shape-circle elementor-widget elementor-widget-icon"
                                                            data-id="5ce094a"
                                                            data-element_type="widget"
                                                            data-widget_type="icon.default"
                                                        >
                                                            <div class="elementor-widget-container">
                                                                <div class="elementor-icon-wrapper">
                                                                    <div class="elementor-icon">
                                                                        <img src="/images/icon/ct3.svg" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="elementor-element elementor-element-0b78905 agrikon-transform transform-type-translate elementor-widget elementor-widget-heading"
                                                            data-id="0b78905"
                                                            data-element_type="widget"
                                                            data-widget_type="heading.default"
                                                        >
                                                            <div class="elementor-widget-container"><h3 class="elementor-heading-title elementor-size-default">Liên hệ với chúng tôi</h3></div>
                                                        </div>
                                                        <div
                                                            class="elementor-element elementor-element-24c451b elementor-align-left elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                                            data-id="24c451b"
                                                            data-element_type="widget"
                                                            data-widget_type="icon-list.default"
                                                        >
                                                            <div class="elementor-widget-container">
                                                                <ul class="elementor-icon-list-items">
                                                                    <li class="elementor-icon-list-item">
                                                                        <a href="tel:+02213997768">
                                                                            <span class="elementor-icon-list-icon"><img src="/images/icon/phone.svg" alt=""></span>
                                                                            <span class="elementor-icon-list-text"> 02213 997 768</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="elementor-icon-list-item">
                                                                        <a class="mt5" href="mailto:cskh@Phavico.com">
                                                                            <span class="elementor-icon-list-icon"> <img src="/images/icon/email.svg" alt=""> </span>
                                                                            <span class="elementor-icon-list-text">cskh@Phavico.com</span>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="map_contact container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3726.4258905983756!2d106.01109861098375!3d20.935405280610208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a5032273326d%3A0xc440958cf23769b0!2zQ8O0bmcgVHkgdGjhu6ljIMSDbiBjaMSDbiBudcO0aSBQSEFWSUNP!5e0!3m2!1svi!2s!4v1688788570631!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

</section>