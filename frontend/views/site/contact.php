<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Liên hệ';
?>
<div class="term-page container">
    <h1>Thông tin về chúng tôi</h1>
    <p>Địa chỉ: <?= Yii::$app->params['address'] ?></p>
    <p>Điện thoại: <?= Yii::$app->params['hotline'] ?></p>
    <p>Email: <?= Yii::$app->params['email'] ?></p>
</div>
