<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CoachCourseSearch */
/* @var $form yii\widgets\ActiveForm */
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
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Nhập tên giảng viên'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList'],['prompt'=>'Trạng thái'])->label(false) ?>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fal fa-plus"></i> Thêm giảng viên', ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
