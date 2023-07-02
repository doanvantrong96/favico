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
            <div class="panel" style="width:100%">
                <div class="panel-hdr">
                    <h2>
                        Thông tin
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'content')->textarea(['rows' => 4]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList']) ?>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <label class="control-label">Ảnh học viên</label>
                                <div class="custom-file">
                                    <input type="file" name="avatar" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/category" id="imgUpload">
                                    <label class="custom-file-label" for="imgUpload"><?= $model->image != '' ? $model->image : 'Chọn ảnh' ?></label>
                                </div>
                                <img class="img-preview" src="<?= $model->image ?>" style="<?= $model->image != '' ? '' : 'display:none' ?>" />
                                <?= $form->field($model, 'image')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fal fa-plus"></i>  Thêm mới' : '<i class="fal fa-save"></i>  Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<style>
    .control-label{width:100%}
.img-preview{
    /* width: 100%; */
    max-height: 100px;
    /* object-fit: cover; */
    margin: 20px 0 0;}
</style>