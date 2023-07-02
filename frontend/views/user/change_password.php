<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Thay đổi mật khẩu';
?>
<style>
    .page-account {
    text-align: center;
}
.page-account .row{
    align-items: center;
    justify-content: center;
}
label.control-label {
    float: left;
}
.page-account .col-lg-6{
    padding: 20px 40px;
    background: #0E0E0E;
    border-radius: 10px;
    margin: 60px;
}
</style>

<div class="page-account container">
   
    <div class="row">
        <div class="col-lg-6">
        <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?php if( Yii::$app->user->identity->password != ''){ ?>
                <?= $form->field($model, 'password_old')->passwordInput() ?>
                <?php } ?>
                <?= $form->field($model, 'password_new')->passwordInput() ?>
                <?= $form->field($model, 'password_renew')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary','style'=>'width: 200px; padding: 10px 0; font-size: 17px;', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
