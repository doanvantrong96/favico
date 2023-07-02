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
                            <?= $form->field($model, 'expert_name')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'position')->textInput(['maxlength' => 255, 'placeholder' => 'Nhập số']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <label class="control-label">Ảnh câu chuyện</label>
                                <div class="custom-file">
                                    <input type="file" name="avatar" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/category" id="imgUpload">
                                    <label class="custom-file-label" for="imgUpload"><?= $model->image != '' ? $model->image : 'Chọn ảnh' ?></label>
                                </div>
                                <img class="img-preview" src="<?= $model->image ?>" style="<?= $model->image != '' ? '' : 'display:none' ?>" />
                                <?= $form->field($model, 'image')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <label class="control-label">Hình ảnh, video, mp3 hoặc file pdf (Nếu có)</label>
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input file-upload-ajax" data-folder="community/media" id="fileUpload">
                                    <label class="custom-file-label" for="fileUpload"><?= $model->file_path != '' ? $model->file_path : 'Chọn file' ?></label>
                                </div>
                                <?= $model->file_path != '' ? '<a style="margin-top: 10px; display: inline-block;" href="' . $model->file_path . '" target="_blank">Xem file</a>' : '' ?>
                                <?= $form->field($model, 'file_path')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
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