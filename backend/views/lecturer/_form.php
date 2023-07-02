<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CoachCourse */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" href="/css/default_skin.css" />
<link rel="stylesheet" href="/css/videojs-hls-player.css" />
<div class="coach-course-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'office')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'level')->textInput(['maxlength' => true,'placeholder' => 'Ví dụ: Chuyên viên, Chuyên gia,...']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'position')->textInput(['maxlength' => 5]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-12">
            <div class="form-group mb-0">
                <label class="control-label">Ảnh đại diện</label>
                <div class="custom-file">
                    <input type="file" name="avatar" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/lecturer" id="imgUpload">
                    <label class="custom-file-label" for="imgUpload"><?= $model->avatar != '' ? $model->avatar : 'Chọn ảnh' ?></label>
                </div>
                <img class="img-preview" style="max-width: 240px;max-height: 430px;margin-top: 10px;" src="<?= $model->avatar ?>" style="<?= $model->avatar != '' ? '' : 'display:none' ?>" />
                <?= $form->field($model, 'avatar')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group mb-0">
                <label class="control-label">Ảnh banner</label>
                <div class="custom-file">
                    <input type="file" name="cover" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/lecturer" id="imgCoverUpload">
                    <label class="custom-file-label" for="imgCoverUpload"><?= $model->cover != '' ? $model->cover : 'Chọn ảnh' ?></label>
                </div>
                <img class="img-preview" style="max-width: 100%; max-height: 200px; margin-top: 10px;" src="<?= $model->cover ?>" style="<?= $model->cover != '' ? '' : 'display:none' ?>" />
                <?= $form->field($model, 'cover')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-0">
                <label class="form-label">Video trailer</label>
                <div class="custom-file">
                    <input type="file" name="video" accept=".mp4" class="custom-file-input file-upload-ajax" data-folder="trailer/lecturer" data-id="<?= $model->id ?>" id="customFileVideo">
                    <label class="custom-file-label" for="customFileVideo"><?= $model->trailer != '' ? $model->trailer : 'Chọn video' ?></label>
                </div>
                <?= $form->field($model, 'trailer')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
            </div>
        </div>
    </div>
    <div class="form-group text-center" style="margin-top:10px">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fal fa-plus"></i> Thêm' : '<i class="fal fa-edit"></i> Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
