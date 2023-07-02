<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSearch */
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
                'action' => ['list-course'],
                'method' => 'get',
            ]); ?>
            <div class="row">
                <div class="col-lg-3 hide">
                    <input type="text" name="date_start" class="hide" value="<?= (isset($_GET['date_start'])) ? $_GET['date_start'] : '' ?>" id="date_start">
                    <input type="text" name="date_end" value="<?= (isset($_GET['date_end'])) ? $_GET['date_end'] : '' ?>" class="hide" id="date_end">
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Nhập tên khoá học'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'status')->dropDownList([1 => 'Hoạt động',0=>'Không hoạt động'],['prompt'=>'Chọn trạng thái'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'is_coming')->dropDownList([1 => 'Sắp diễn ra', 0 => 'Đang diễn ra'],['prompt'=>'Loại'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <a href="list-course" class="btn btn-warning">Reset</a>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>