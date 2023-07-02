<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Course;

$listCourse = ArrayHelper::map(Course::find()->where(['is_delete'=>0])->all(),'id','name');
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
                    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Nhập tên bài học'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'course_id')->dropDownList($listCourse, ['prompt'=>'Chọn khoá học','class'=>'form-control select2'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fal fa-plus"></i> Thêm bài học', ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
