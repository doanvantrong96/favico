<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */
/* @var $form yii\widgets\ActiveForm */
// list(, $url) = Yii::$app->assetManager->publish('@mdm/admin/assets');
$this->title = 'Đổi mật khẩu';
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản' , 'url' => ['info']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = '';
?>
<style>
.form-group {
    margin-bottom: 15px;
    float: left;
    width: 100%;
}
</style>
<div class="employee-form">

    <?php $form = ActiveForm::begin([
    'id' => "some_form",
    // 'action' => [''],
    'options' => ['class' => 'edit_form'],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
]); ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'password_old')->passwordInput(['maxlength' => true,'autocomplete'=>'off']); ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'password_new')->passwordInput(['maxlength' => true,'autocomplete'=>'off']); ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'password_renew')->passwordInput(['maxlength' => true,'autocomplete'=>'off']); ?>
        </div>
    </div>
    <div class="form-group text-center" style="margin-top:15px">
        <?= Html::submitButton('<i class="fal fa-save"></i> Cập nhật', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>