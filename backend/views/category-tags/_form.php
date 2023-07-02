<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="category-tags-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group-control">   
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'except')->textarea(['rows' => '6']) ?>
            </div>
            <div class="col-lg-12">
                <div class="form-group text-center" style="margin-top:10px">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fal fa-plus"></i> Thêm' : '<i class="fal fa-edit"></i> Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>