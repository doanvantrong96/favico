<?php
    use yii\helpers\Url;
?>
<div class="modal-header pl-0">
    <h5 class="modal-title font-weight-bold">Đăng Ký</h5>
    <p class="register-hint">Đã có tài khoản? <button type="button" id="btnLogin" data-url="<?= Url::to(['site/login']);?>" class="btn btn-link btn-open-modal">Đăng nhập</button>.</p>
    <button type="button" class="close" aria-label="Close"><span aria-hidden="true"><i class="far fa-times-circle text-dark"></i></span></button>
</div>
<div class="modal-body">
    <form id="signup" action="<?= Url::to('/site/signup');?>" class="mb-3">
        <div class="form-group">
            <label class="fz-18" for="">Họ và tên*</label>
            <input placeholder="Họ và tên" name="SignupForm[fullname]" type="fullname" class="form-control">
            <p style="text-align:left;font-size: 14px;font-style: italic;margin-top: 5px;">Vui lòng nhập chính xác tên đăng ký. Thông tin này sẽ được ghi trên chứng nhận hoàn thành khóa học của bạn.</p>
        </div>
        <div class="form-group d-flex" style="gap:10px">
            <div class="form-group w-50">
                <label class="fz-18" for="">Email*</label>
                <input placeholder="Email" name="SignupForm[email]" type="email" class="form-control">
            </div>
            <div class="form-group w-50">
                <label class="fz-18" for="">Số điện thoại*</label>
                <input placeholder="Số điện thoại" name="SignupForm[phone]" type="phone" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="form-control-container">
                <label class="fz-18" for="">Mật khẩu *</label>
                <input placeholder="Mật khẩu" name="SignupForm[password]" type="password" class="form-control">
                <i class="fa-eye reveal far"></i>
            </div>
        </div>
        <p class="toc text-muted  mt-3 mb-3"><span class="d-block fz-16">Bằng cách đăng ký hoặc tạo tài khoản, bạn đồng ý với <a target="_blank" href="<?=  Url::to(['category/index-news','slug' => 'chinh-sach-bao-mat-thong-tin','id' => 19]) ?>">Chính sách bảo mật</a> và <a target="_blank" href="<?=  Url::to(['category/index-news','slug' => 'dieu-khoan-su-dung-tai-khoan-abe-academy','id' => 18])?>">Điều khoản sử dụng dịch vụ</a>.</span></p>
        <button type="button" class="btnSubmitModal btn btn-primary fz-18 mb-2">Tạo tài khoản</button>
    </form>
    <div class="separator"><span>Hoặc</span></div>
    <?php /*<a href="<?= Url::to(['site/auth','authclient'=>'facebook']);?>" class="btn-login-google mb-3 text-uppercase btn btn-secondary btn-lg"> <img class="mb-2 mr-2" src="/images/page/login-gg.svg" alt=""> Đăng ký bằng Google</a>*/ ?>
    <a href="<?= Url::to(['site/auth','authclient'=>'facebook']);?>" class="btn-login-facebook mb-3 text-uppercase btn btn-secondary btn-lg"><img class="mb-2 mr-2" src="/images/page/icon-fb.svg" alt=""> Đăng ký bằng Facebook</a>
</div>
