<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


$this->title = 'Khôi phục mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .site-reset-password {
        display: flex;
        flex-direction: column;
        max-width: 400px;
        margin: 100px auto;
        
    }
    form#form_reset_pass {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    #form_reset_pass input{
        height: 50px;
        border-radius:5px;
        text-indent:15px;
    }
    #form_reset_pass span{
        height: 50px;
        border-radius:5px;
        background:red;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    #form_reset_pass span:hover{
        opacity: .85;
    }
    .site-reset-password h1{
        font-size: 24px;
    }
</style>
<div class="container">
    <div class="site-reset-password">
        <h1><?= Html::encode($this->title) ?></h1>
        <form id="form_reset_pass" method="POST" action="<?= Url::to(['site/reset-password','token' => $_GET['token']]) ?>">
            <input type="password" name="password" id="password" placeholder="Nhập mật khẩu mới">
            <input type="password" name="re_password" id="re_password" placeholder="Nhập lại mật khẩu mới"> 
            <span id="reset_pass">Cập nhật</span>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#reset_pass').click(function(){
            var pass = $('#password').val();
            var re_pass = $('#re_password').val();
            if(pass == ''){
                toastr['warning']('Nhập mật khẩu mới của bạn.');
                return;
            }
            if(pass.length < 6){
                toastr['warning']('Mật khẩu tối thiểu 6 ký tự.');
                return;
            }
            if(re_pass == ''){
                toastr['warning']('Nhập lại mật khẩu mới của bạn.');
                return;
            }
            if(pass != re_pass){
                toastr['warning']('Mật khẩu mới không khớp.');
                return;
            }
            $("#form_reset_pass").submit();
            toastr['success']('Cập nhật mật khẩu thành công.');
        });
    });
</script>