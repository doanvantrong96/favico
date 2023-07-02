<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Category;

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
                <div class="col-lg-4">
                    <?= $form->field($model, 'content')->textInput(['placeholder' => 'Nhập tên khách hàng, email, câu chuyện' ])->label(false) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusCommunityList'],['prompt'=>'Trạng thái'])->label(false) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'is_active')->dropDownList(Yii::$app->params['stateCommunityList'],['prompt'=>'Tình trạng'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<style>
    .form-parent .select2{
        width:100% !important;
    }
    .img-grid{
        max-width: 200px;
        max-height: 100px;
    }
</style>
