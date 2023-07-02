<?php 
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
?>
<style>
    .form {
        margin-top: 20px;
    }
    .btn-primary {
        border-color: unset;
    }
    .btn-primary:hover {
        color: #fff;
        background-color: #ff277f;
        box-shadow: inset 0 0 0 100px rgba(0,0,0,0.2);
    }
</style>

<div class="form">
    
        <p>Luna Thái luôn có các chương trình ưu đãi lớn và nhiều quà tặng cho học viên đăng ký mới. Đăng ký ngay để nhận ưu đãi từ Luna Thái. Tư vấn viên sẽ liên hệ bạn ngay sau khi bạn để thông tin chi tiết</p>
        <div class="col medium-10 small-12 large-10">
        <?php $form = ActiveForm::begin(['id' => 'form-contact']); ?>

    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Họ và tên'])->label(false) ?>
    <?= $form->field($model, 'email')->label(false)->textInput(['placeholder'=>'Email'])?>
    <?= $form->field($model, 'phone')->label(false)->textInput(['placeholder'=>'Số điện thoại']) ?>
    <?= $form->field($model, 'province')->textInput(['placeholder'=>'Tỉnh thành'])->label(false)?>
    <?= $form->field($model, 'source')->hiddenInput(['value'=>$source])->label(false)?>
    <?= $form->field($model, 'url')->hiddenInput(['value'=>$actual_link])->label(false)?>

    <div class="form-group">
    <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
<script>

</script>