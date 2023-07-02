<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Course;
use yii\helpers\ArrayHelper;

$listCourse = ArrayHelper::map(Course::find()->where(['is_delete' => 0])->all(),'id','name');
/* @var $this yii\web\View */
/* @var $model backend\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="action-form">
<?php $form = ActiveForm::begin(['enableAjaxValidation' => true,'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-12">
            <?php 
                if( $model->course_id != '' )
                    $model->course_id = array_filter(explode(';', $model->course_id));
                echo $form->field($model, 'course_id')->dropDownList($listCourse,['multiple'=>true, 'placeholder' => 'Chọn','class'=>'form-control select2'])->label('Khoá học áp dụng <i class="fal fa-info-circle" data-toggle="tooltip" title="Nếu không chọn khoá học nào thì mã khuyến mại sẽ áp dụng cho toàn bộ khoá học"></i>') 
            ?>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php echo $form->field($model, 'type_price')->dropDownList(Yii::$app->params['giftTypePrice']) ?>
        </div>
        <div class="col-lg-6 ">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true,'class'=>'form-control ' . ($model->type_price == 1 ? 'input-price':'')])->label($model->type_price == 1 ? 'Số tiền' : 'Số phần trăm (Nhập số)') ?>
        </div>
       
        <div class="col-lg-6 row_max_price <?= $model->type_price == 2 ? '' : 'hide' ?>">
            <?= $form->field($model, 'max_price_promotion')->textInput(['maxlength' => true,'class'=>'form-control input-price']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'date_start')->textInput(['maxlength' => true,'class'=>'form-control input-date','data-format'=>'YYYY-MM-DD']) ?>
            <i class="fal fa-calendar-alt icon-calendar-form" style="position: absolute; top: 35px; right: 25px;"></i>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'date_end')->textInput(['maxlength' => true,'class'=>'form-control input-date','data-format'=>'YYYY-MM-DD']) ?>
            <i class="fal fa-calendar-alt icon-calendar-form" style="position: absolute; top: 35px; right: 25px;"></i>
        </div>
    </div>
    <div class="form-group text-center" style="margin-top:10px">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fal fa-plus"></i> Thêm' : '<i class="fal fa-edit"></i> Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<style>
.img-preview{width: 100%;
    max-height: 300px;
    object-fit: cover;
    margin: 20px 0 0;}
    .field-banner-image{display:none}
</style>
<script>
    jQuery(document).ready(function(){
        $('#giftcode-type_price').change(function(){
            if( $(this).val() == 1 ){
                $('.field-giftcode-price label').text('Số tiền');
                $('.row_max_price').addClass('hide');
                $('#giftcode-price').addClass('input-price');
            }else{
                $('.field-giftcode-price label').text('Số phần trăm (Nhập số)');
                if( $(this).val() == 2 ){
                    $('.row_max_price').removeClass('hide');
                }else{
                    $('.row_max_price').addClass('hide');
                }
                $('#giftcode-price').removeClass('input-price');
            }
        })
    });
</script>