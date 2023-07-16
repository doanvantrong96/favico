<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = $category->name;
?>

<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p><?= $category->name ?></p>
    </div>
    <h6><?= $category->name ?></h6>
</section>

<section class="recruitment">
    <div class="container">
        <div class="row parent_new">
            <?php foreach($post as $row) { ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="blog-card">
                        <div class="blog-card__image">
                            <img
                                data-lazyloaded="1"
                                src="<?= $row['image'] ?>"
                            />
                            <a href="/"></a>
                        </div>
                        <div class="blog-card__content">
                            <div class="blog-card__date"><a href="/"> <?= date('d/m', strtotime($row['date_publish'])) ?></a></div>
                            <h3 class="title"><a href="<?= Url::to(['/news/detail','id' => $row['id']]) ?>"><?= $row['title'] ?></a></h3>
                            <a class="btn_read" href="<?= Url::to(['/news/detail','id' => $row['id']]) ?>">Đọc ngay</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if($post == 9) : ?>
            <div class="flex-center w-100">
                <span cat-id="<?= $category->id ?>" class="see_more_td flex-center">Xem thêm</span>
            </div>
        <?php endif; ?>
    </div>
</section>