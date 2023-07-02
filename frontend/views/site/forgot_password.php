<?php
    use yii\helpers\Url;
?>
<div class="modal-header">
    <h5 class="modal-title">Đặt lại mật khẩu</h5>
    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form action="<?= Url::to(['site/forgot-password']);?>" class="mb-3">
        <div class="form-group"><label for="email" class="">Địa chỉ email</label><input id="email" placeholder="Địa chỉ email" type="email" name="ForgotPassword[email]" class="form-control"></div>
        <button type="button" class="btn btn-primary">Gửi email</button>
    </form>
    <p class="register-hint"><button id="btnLogin" data-url="<?= Url::to(['site/login']);?>" class="btn btn-link btn-open-modal">Trở về trang đăng nhập</button></p>
</div>