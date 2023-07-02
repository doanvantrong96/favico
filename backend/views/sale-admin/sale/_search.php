<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="panel">
    <div class="panel-hdr">
        <h2>
            Lọc và tìm kiếm
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <?php $form = ActiveForm::begin([
                'action' => ['list-sale'],
                'method' => 'get',
            ]); ?>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Nhập tên sale, email, sđt'])->label(false) ?>
                </div>
                <div class="col-lg-2">
                    <?php echo $form->field($model, 'is_active')->dropDownList([0=>'InActive', 1=>'Active'],['prompt'=>'Trạng thái tài khoản'])->label(false) ?>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fal fa-plus"></i> Thêm tài khoản', ['create-sale'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
