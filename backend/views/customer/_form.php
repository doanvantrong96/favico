<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Course;

$listCourse = ArrayHelper::map(Course::find()->all(),'id','name');

/* @var $this yii\web\View */
/* @var $model backend\models\CoachSection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coach-section-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6">
            <?php echo $form->field($model, 'course_id')->dropDownList($listCourse, ['prompt'=>'Chọn khoá học']) ?>
        </div>
    </div>
    
    <div class="form-group text-center" style="margin-top:10px">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fal fa-plus"></i> Thêm' : '<i class="fal fa-edit"></i> Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
