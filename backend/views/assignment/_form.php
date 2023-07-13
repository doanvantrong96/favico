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
            <input type="checkbox" name="User[is_admin]" class="hide" id="is_admin" value="1">
            <?php /* if( Yii::$app->user->identity->is_admin ){ ?>
                <div class="custom-control custom-switch"  style="display: inline-block; margin-top: 32px;">
                    <input type="checkbox" name="User[is_admin]" class="custom-control-input" id="is_admin" <?= $model->is_admin == 1 ? 'checked="true"' : '' ?> value="1">
                    <label class="custom-control-label" for="is_admin">Là Admin?</label>
                </div>
            <?php 
               }
            */ ?>
        </div>
        <?php /*
        <div class="col-lg-6 field-account-type <?= $model->is_admin == 1 ? 'hide' : '' ?>">
            <?php echo $form->field($model, 'account_type')->dropDownList(Yii::$app->params['employeeAccountType'], ['class' => 'form-control select2'])->label('Loại tài khoản') ?>
        </div>
        <div class="col-lg-6 field-lecturer <?= $model->account_type == Employee::TYPE_LECTURER && !$model->is_admin ? '' : 'hide' ?>">
            <?php echo $form->field($model, 'lecturer_id')->dropDownList($listLecturer, ['class' => 'form-control select2', 'prompt' => 'Chọn'])->label('Giảng viên') ?>
        </div>
        <div class="col-lg-6 field-commission_percentage <?= in_array($model->account_type, [Employee::TYPE_SALE, Employee::TYPE_SALE_ADMIN]) && !$model->is_admin ? '' : 'hide' ?>">
            <?= $form->field($model, 'commission_percentage')->textInput(['maxlength' => true])->label('Hoa hồng (%)') ?>
        </div>
        <div class="col-lg-6 field-role  <?= $model->is_admin == 1 ? 'hide' : '' ?>">
            <div class="form-group field-user-role">
                <label class="control-label" for="user-role">Nhóm quyền</label>
                <select multiple="multiple" id="user-role" name="roles[]"  class="form-control select2">
                    <?php
                        foreach($model->userRole as $role=>$typechecked){
                    ?>
                    <option <?= ($typechecked == 'checked' ? 'selected="true"' : '') ?> value="<?= $role ?>"><?= $role ?></option>
                    <?php
                        }
                    ?>
                </select>

                <div class="help-block"></div>
            </div>
        </div>
        */ ?>
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
        $('#user-role').select2({
            placeholder: "Chọn 1 hoặc nhiều nhóm quyền",
            allowClear: true
        });
        // $('#user-account_type').change(function(){
        //     if( $(this).val() == <?= Employee::TYPE_LECTURER ?> ){
        //         $('.field-lecturer').removeClass('hide');
        //         $('.field-commission_percentage').addClass('hide');
        //     }else if( $(this).val() == <?= Employee::TYPE_SALE ?> || $(this).val() == <?= Employee::TYPE_SALE_ADMIN ?> ){
        //         $('.field-lecturer').addClass('hide');
        //         $('.field-commission_percentage').removeClass('hide');
        //     }else{
        //         $('.field-lecturer,.field-commission_percentage').addClass('hide');
        //     }
        // });
    });
</script>