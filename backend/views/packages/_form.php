<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

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
                        <div class="col-md-6">
                            <?= $form->field($model, 'package_name')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control remove-unicode'])->label('Tên gói') ?>
                            <?= $form->field($model, 'package_price')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control remove-unicode'])->label('Giá gói') ?>
                            <?= $form->field($model, 'promotion_price')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control remove-unicode'])->label('Giá khuyến mại') ?>
                            <?= $form->field($model, 'number')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control remove-unicode'])->label('Số LÁ SỐ') ?>
                            <?= $form->field($model, 'pdf_file')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control remove-unicode'])->label('Số FILE PDF') ?>
                            
                        </div>
                        <div class="col-md-6">
                           <div class="form-group mb-0">
                                <label class="control-label">Ảnh QR Code</label>
                                <div class="custom-file">
                                    <input type="file" name="qr_code" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/qr_code" id="imgUpload">
                                    <label class="custom-file-label" for="imgUpload"><?= $model->qr_code != '' ? $model->qr_code : 'Chọn ảnh' ?></label>
                                </div>
                                <img class="img-preview" src="<?= $model->qr_code ?>" style="<?= $model->qr_code != '' ? '' : 'display:none' ?>" />
                                <?= $form->field($model, 'qr_code')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
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
    max-height: 300px;
    margin: 20px 0 0;}
</style>
