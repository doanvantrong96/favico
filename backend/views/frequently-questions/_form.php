<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\FrequentlyQuestionsGroup;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */
/* @var $form yii\widgets\ActiveForm */
$listGroup = ArrayHelper::map(FrequentlyQuestionsGroup::find()->where(['status' => 1, 'is_delete' => 0])->orderBy(['position' => SORT_ASC])->all(), 'id', 'name');
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
                            <?= $form->field($model, 'question')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'answer')->textarea(['rows' => 4]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'group_id')->dropDownList($listGroup, ['prompt' => 'Chọn nhóm']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList']) ?>
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