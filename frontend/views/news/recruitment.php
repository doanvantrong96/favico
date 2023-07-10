<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Tuyển dụng';
?>

<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p>TUYỂN DỤNG</p>
    </div>
    <h6>Tuyển Dụng</h6>
</section>

<section class="recruitment">
    <div class="container">
        <div class="row">
            <?php for($i = 0; $i < 9; $i++) { ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="blog-card">
                        <div class="blog-card__image">
                            <img
                                data-lazyloaded="1"
                                src="/images/page/new1.png"
                            />
                            <a href="/"></a>
                        </div>
                        <div class="blog-card__content">
                            <div class="blog-card__date"><a href="/">05/04</a></div>
                            <h3 class="title"><a href="">Giá trứng gia cầm bất ngờ tăng trở lại sau một thời gian dài giảm sâu</a></h3>
                            <a class="btn_read" href="">Đọc ngay</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="flex-center w-100">
                <span class="see_more_td flex-center">Xem thêm</span>
            </div>
        </div>
    </div>
</section>