<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CoachCourseSearch */
/* @var $form yii\widgets\ActiveForm */
$controller = Yii::$app->controller->id;
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
                    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Nhập tên, email, sđt khách hàng'])->label(false) ?>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <a href="/<?= $controller ?>/export" class="btn btn-info waves-effect waves-themed"><i class="fal fa-search"></i> Xuất</a>
        </div>
    </div>
</div>
