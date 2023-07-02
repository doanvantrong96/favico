<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\FrequentlyQuestionsGroup;
use yii\helpers\ArrayHelper;

$listGroup = ArrayHelper::map(FrequentlyQuestionsGroup::find()->where(['status' => 1, 'is_delete' => 0])->orderBy(['position' => SORT_ASC])->all(), 'id', 'name');
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
                    <?= $form->field($model, 'question')->textInput(['placeholder' => 'Nhập tên câu hỏi' ])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'group_id')->dropDownList($listGroup,['prompt'=>'Nhóm'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList'],['prompt'=>'Trạng thái'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
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
