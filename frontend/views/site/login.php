<?php
    use yii\helpers\Url;
?>
<div class="modal-header pl-0">
    <h5 class="modal-title">Đăng nhập</h5>
    <p class="register-hint mt-3">Chưa có tài khoản? <button data-url="<?= Url::to(['site/signup']);?>" id="btnSignUpInSide" type="button" class="btn btn-link btn-open-modal">Đăng ký</button>.</p>
    <button type="button" class="close" aria-label="Close"><span aria-hidden="true"><i class="far fa-times-circle text-dark"></i></span></button>
</div>
<div class="modal-body">
    <form id="login_form" action="<?= Url::to(['site/login']);?>" class="mb-3">
        <div class="form-group  ">
            <label for="" class="fz-18">Email *</label>
            <input placeholder="Email" name="LoginForm[username]" type="email" class="form-control  form-control" value="">
        </div>
        <div class="form-group  ">
        <div class="form-control-container">
            <label for="" class="fz-18">Mật khẩu *</label>
            <input placeholder="Mật khẩu" name="LoginForm[password]" type="password" class="form-control  form-control" value="">
            <i class="fa-eye reveal far"></i>
        </div>
        </div>
        <button type="button" class="btnSubmitModal btn-lg text-uppercase btn btn-primary">Đăng nhập</button>
    </form>
    <?php /*<p class="forget-password text-muted"><button id="" data-url="<?= Url::to(['site/forgot-password']);?>" class="btn btn-link btn-open-modal">Quên mật khẩu?</button></p>*/ ?>
    <div class="separator"><span>Hoặc</span></div>
    <?php /*<a href="<?= Url::to(['site/auth','authclient'=>'facebook']);?>" class="btn-login-google mb-3 text-uppercase btn btn-secondary btn-lg"> <img class="mb-2 mr-2" src="/images/page/login-gg.svg" alt=""> Đăng nhập bằng Google</a>*/ ?>
    <a href="<?= Url::to(['site/auth','authclient'=>'facebook']);?>" class="btn-login-facebook mb-3 text-uppercase btn btn-secondary btn-lg"><img class="mb-2 mr-2" src="/images/page/icon-fb.svg" alt=""> Đăng nhập bằng Facebook</a>
    <div class="text-center">
        <a href="javascript:void(0)" class="reset_passw text-dark" data-toggle="modal" data-target="#model_resetpass">Quên mật khẩu</a>   
    </div>
</div>

<div class="forgot_password">
    <div class="modal fade" id="model_resetpass" tabindex="-1" role="dialog" aria-labelledby="model_resetpassLabel" aria-hidden="true">
        <div class="modal-dialog dialog_resp" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mc-background__content content_reset_pass">
                        <button type="button" class="c-button c-button--link c-button--md mc-modal__close mc-p-0 " data-dismiss="modal" aria-label="Close">
                            <svg width="24" height="25" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" role="img" class="mc-icon mc-icon--md mc-icon--scale-4 mc-m-2">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.418 2.918a1.429 1.429 0 0 1 2.02 0L12 10.48l7.561-7.562a1.429 1.429 0 0 1 2.02 2.02l-7.56 7.562 7.56 7.561a1.429 1.429 0 1 1-2.02 2.02L12 14.522l-7.561 7.56a1.429 1.429 0 1 1-2.02-2.02l7.56-7.561-7.56-7.561a1.429 1.429 0 0 1 0-2.02Z" fill="currentColor"></path>
                            </svg>
                        </button>
                        <div class="mc-px-4 mc-py-6">
                            <div>
                            <div class="text-center">
                                <h4 class="mc-text-h4 mc-text--center mc-mb-6">Reset password</h4>  
                            </div>
                            <div class="mc-form-group mc-form-group--default mc-mb-4">
                            <div class="row no-gutters justify-content-between align-items-center">
                                <div class="col align-self-end">
                                <label for="email" class="d-block mc-text-h8 mc-text--left mc-mb-1">Email <span aria-hidden="true">*</span>
                                </label>
                                </div>
                                <div class="col-12">
                                <div class="">
                                    <div class="mc-form-input mc-form-element mc-form-element--default">
                                    <input id="email_res" name="email" type="email" class="mc-form-element__element" aria-describedby="email-help-text email-info-text" required="" data-ba="email-input" autocomplete="email" aria-invalid="true" value="">
                                    </div>
                                </div>
                                </div>
                                <div class="col align-self-start">
                                <p id="email-help-text" class="mc-text-x-small mc-opacity--muted mc-text--left mc-mt-1"></p>
                                </div>
                                <div class="col-auto align-self-start mc-ml-auto"></div>
                            </div>
                            </div>
                            <button type="submit" class="btn_sendemail_rp" data-ba="submit-btn">Send Email</button>
                            <!-- <p class="mc-text--center mc-mt-4">Remember your password? <a class="mc-text--link">Log In.</a> -->
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>