<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Lecturer;
use backend\models\Employee;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */
/* @var $form yii\widgets\ActiveForm */
// list(, $url) = Yii::$app->assetManager->publish('@mdm/admin/assets');

$listLecturer      = ArrayHelper::map(Lecturer::find()->where(['is_delete' => 0])->all(),'id','name');
$this->registerJS('
    $("#is_admin").click(function(){
        if( $(this).is(":checked") ){
            $(".field-account-type,.field-role").addClass("hide");
        }else{
            $(".field-account-type,.field-role").removeClass("hide");
        }
    })
')
?>
<style>
.form-group {
    margin-bottom: 15px;
    float: left;
    width: 100%;
}
</style>
<div class="employee-form">

    <?php $form = ActiveForm::begin([
    'id' => "some_form",
    // 'action' => [''],
    'options' => ['class' => 'edit_form'],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
//     'fieldConfig' => [
//         'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-4 div_err\">{error}</div>",
//         'labelOptions' => ['class' => 'col-lg-3 control-label'],
// ]
]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Tài khoản') ?>
        </div>
        <?php if($model->isNewRecord){ ?>
            <div class="col-lg-6">
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'autocomplete'=>'off'])->label('Mật khẩu'); ?>
            </div>
        <?php } ?>
        <div class="col-lg-6">
            <?= $form->field($model, 'fullname')->textInput(['maxlength' => true])->label('Họ tên') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Điện thoại') ?>
        </div>
        <div class="col-lg-6">
            <div class="custom-control custom-switch" style="display: inline-block; margin-right: 10px; margin-top: 32px;">
                <input type="checkbox" name="User[is_active]" class="custom-control-input" id="is_active" <?= ($model->isNewRecord || $model->is_active == 1) ? 'checked="true"' : '' ?> value="1">
                <label class="custom-control-label" for="is_active">Active tài khoản?</label>
            </div>
        </div>
        <div class="col-lg-6 field-commission_percentage">
            <?= $form->field($model, 'commission_percentage')->textInput(['maxlength' => true])->label('Hoa hồng (%)') ?>
        </div>
    </div>
    <div class="form-group text-center" style="margin-top:15px">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fal fa-plus"></i> Thêm' : '<i class="fal fa-save"></i> Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    .select2-container .select2-selection--multiple{
        min-height: 37px;
    }
    .field-lecturer .select2-container{
        width: 100% !important;
    }
    .select2-container{
        width: 100% !important;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function(){
        
    });
</script>