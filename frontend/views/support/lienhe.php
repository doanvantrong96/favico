<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Liên hệ';


?>
<style>

.title-contact {
    font-style: normal;
    font-weight: 400;
    font-size: 18px;
    line-height: 29px;
    color: #636982;
    margin-bottom: 35px;

}
.b-title {
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 19px;
    color: #33415d;
    margin-bottom: 8px;
    display: inline-block;
}
table svg {
    position: relative;
    top: 10px;
}
svg {
    position: relative;
    top: 4px;
}
.btn-primary {
    
    border-color: unset;
}
path {
    fill: #ff277f;
}
.table_info td p {
    text-align: left;
    margin-left: 10px;
    font-size: 16px;
    color: #1a1919;
}
.b-to-right {
    margin-bottom: 15px;
    margin-left: 20px;
    display: inline-block;
}
.table_info td {

    display: inline-block;
    border-top: none!important;
    padding-top: 0!important;
    text-align: center;
    border-bottom: none;
}
i.fa.fa-lg.fa-facebook {
    color: #ff277f;
    position: relative;
    top: 9px;
    font-size: 20px;
    left: 3px;
}
</style>
<div class="container">
<p class="title-contact" style="color:#d00000">Bộ phận chăm sóc khách hàng của Học Viện Quốc Tế Yoga Luna Thái hoạt động 24/7.<br>
Quý Khách hàng có thể liên hệ trực tiếp với chúng tôi bằng bất kỳ hình thức nào dưới đây:
                </p>
    <div class="row">
        <div class="col-md-6 div-text">
        <p>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3574 6.52906C15.461 6.42512 15.6177 6.39394 15.7532 6.45031C15.8886 6.50635 15.9773 6.63898 15.9773 6.78577V10.9049C15.9773 11.706 15.3255 12.3574 14.5248 12.3574H4.14468L0.619847 15.8822C0.550332 15.9518 0.45743 15.9886 0.363098 15.9886C0.316289 15.9886 0.2688 15.9797 0.224102 15.961C0.0886468 15.9049 0 15.7723 0 15.6255V1.4638C0 0.66274 0.651779 0.0113021 1.45249 0.0112H14.5248C14.8085 0.0112 15.0844 0.0941616 15.3234 0.251268C15.4362 0.325753 15.4986 0.456613 15.4844 0.591353C15.4709 0.725753 15.3837 0.841702 15.2581 0.891711C14.9823 1.00163 14.7418 1.15803 14.5433 1.35697L12.1868 3.71306C12.128 3.67193 12.0603 3.64245 11.983 3.64245H3.99431C3.7936 3.64245 3.63118 3.80487 3.63118 4.00558C3.63118 4.2063 3.7936 4.36871 3.99431 4.36871H11.531L10.1234 5.77617C10.1162 5.78335 10.1108 5.79171 10.1054 5.80007C10.1006 5.80738 10.0959 5.81468 10.09 5.82121H3.99431C3.7936 5.82121 3.63118 5.98363 3.63118 6.18434C3.63118 6.38506 3.7936 6.54747 3.99431 6.54747H9.78271L9.46243 8.14962C9.39081 8.50706 9.50216 8.87513 9.76031 9.13365C10.0163 9.38934 10.3823 9.50424 10.744 9.43118L12.5596 9.06805C12.7702 9.02584 12.9631 8.92303 13.1156 8.77018L15.3574 6.52906ZM3.99431 8.7262H8.35176C8.55248 8.7262 8.71489 8.56381 8.71489 8.36306C8.71489 8.16235 8.55248 7.99993 8.35176 7.99993H3.99431C3.7936 7.99993 3.63118 8.16235 3.63118 8.36306C3.63118 8.56378 3.7936 8.7262 3.99431 8.7262Z" fill="#0999D8"></path>
                        </svg>
                        <b class="b-title b-to-right">Liên hệ</b>
                    </p>
            <?php $form = ActiveForm::begin(['id' => 'form-contact']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true,'placeholder'=>'Họ và tên'])->label(false) ?>
            <?= $form->field($model, 'email')->label(false)->textInput(['placeholder'=>'Email'])?>

            <?= $form->field($model, 'phone')->label(false)->textInput(['placeholder'=>'Số điện thoại']) ?>
            <?= $form->field($model, 'content')->textarea(['rows' => '6','placeholder'=>'Nội dung'])->label(false)?>


            <div class="form-group">
            <?= Html::submitButton('Gửi lời nhắn', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6 div-text">
            <table class="table table-condensed table_info">
                        <tbody><tr>
                            <td>
                                <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.4403 11.4961C16.475 11.7327 16.3939 11.9384 16.1973 12.1133L13.8884 14.1501C13.7842 14.253 13.6482 14.3405 13.4804 14.4124C13.3126 14.4845 13.1477 14.5308 12.9857 14.5513C12.9742 14.5513 12.9394 14.554 12.8815 14.5591C12.8237 14.5642 12.7485 14.5668 12.6559 14.5668C12.4359 14.5668 12.08 14.5334 11.5881 14.4665C11.0963 14.3996 10.4945 14.235 9.78277 13.9727C9.07089 13.7104 8.26367 13.3169 7.36097 12.7923C6.45828 12.2677 5.49765 11.5475 4.47919 10.6319C3.66905 9.9221 2.9978 9.24314 2.46542 8.59507C1.93304 7.94694 1.50482 7.34771 1.18077 6.79733C0.856684 6.24696 0.613643 5.74803 0.451615 5.30053C0.289587 4.85303 0.179639 4.46726 0.121772 4.14321C0.0639053 3.81916 0.0407584 3.56455 0.0523318 3.37938C0.0639053 3.19421 0.069692 3.09133 0.069692 3.07076C0.0928388 2.92674 0.144919 2.78014 0.225933 2.63098C0.306947 2.48181 0.405321 2.36094 0.521055 2.26835L2.82995 0.216033C2.99198 0.0720111 3.17716 0 3.38548 0C3.53593 0 3.66903 0.0385774 3.78476 0.115732C3.90049 0.192887 3.99887 0.288044 4.07988 0.401205L5.93742 3.53369C6.04158 3.69828 6.07051 3.87831 6.02422 4.07377C5.97792 4.26923 5.87955 4.43383 5.72909 4.56756L4.87845 5.32368C4.8553 5.34425 4.83505 5.37769 4.81769 5.42398C4.80033 5.47027 4.79165 5.50885 4.79165 5.53971C4.83794 5.75575 4.9421 6.00264 5.10413 6.2804C5.24301 6.52729 5.45712 6.8282 5.74645 7.18311C6.03579 7.53802 6.44665 7.94692 6.97902 8.40984C7.49983 8.88311 7.96276 9.25083 8.36783 9.51321C8.77282 9.77543 9.11145 9.9684 9.38343 10.0918C9.65541 10.2153 9.86373 10.2899 10.0084 10.3155L10.2253 10.3541C10.2485 10.3541 10.2862 10.3464 10.3382 10.331C10.3903 10.3155 10.4279 10.2975 10.451 10.2769L11.4405 9.38194C11.649 9.21737 11.8919 9.13507 12.1697 9.13507C12.3665 9.13507 12.5227 9.16591 12.6384 9.22766H12.6557L16.0062 10.9868C16.2493 11.1206 16.394 11.2903 16.4403 11.4961Z" fill="#0999D8"></path>
                                </svg>
                            </td>
                            <td>
                                <p><b class="b-title"> <span>  &nbsp </span>Điện thoại (24/7)</b></p>
                                <p><span>  &nbsp </span><a href="tel:0985060558">0985 06 05 58</a></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <svg width="22" height="15" viewBox="0 0 22 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.3697 0.390608L10.8978 7.7573L1.42673 0.390608C1.81385 0.20147 2.25168 0.0854797 2.72442 0.0854797H19.0711C19.5433 0.0854797 19.981 0.20147 20.3697 0.390608ZM21.4458 13.3587C21.6611 13.0122 21.7955 12.6185 21.7955 12.1938V2.50726C21.7955 2.03312 21.636 1.59435 21.3712 1.22082L14.5641 6.51462L21.4458 13.3587ZM13.5385 7.31163L11.346 9.01791C11.2177 9.11721 11.058 9.1668 10.8978 9.1668C10.7374 9.1668 10.5777 9.11721 10.4495 9.01791L8.25649 7.31155L1.2877 14.2431C1.70541 14.476 2.19494 14.6156 2.72436 14.6156H19.0711C19.6005 14.6156 20.0902 14.476 20.5078 14.2431L13.5385 7.31163ZM0 2.50727C0 2.03309 0.159645 1.59432 0.424401 1.22079L7.23081 6.51347L0.349879 13.3587C0.133771 13.0123 0 12.6186 0 12.1939V2.50727Z" fill="#0999D8"></path>
                                </svg>
                            </td>
                            <td>
                                <p><b class="b-title">Chăm sóc khách hàng</b></p>
                                <p><a href="mailto:luna@yogalunathai.com">luna@yogalunathai.com</a></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa fa-lg fa-facebook"></i>
                            </td>
                            <td>
                                <p><b class="b-title">   <span>  &nbsp    &nbsp </span>Fanpage</b></p>
                                <p><span>  &nbsp    &nbsp </span><a href="https://www.facebook.com/hvqtyogalunathai112">fb/hvqtyogalunathai112</a></p>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.06185 1.65819C4.30017 -0.331113 7.92898 -0.331113 10.167 1.65819C12.1837 3.45076 12.4107 6.82596 10.6992 8.85423L6.11442 14.7397L1.52962 8.85423C-0.181839 6.82596 0.0451784 3.45076 2.06185 1.65819ZM4.2784 5.21081C4.2784 6.1396 5.1253 6.89238 6.17021 6.89238C7.21512 6.89238 8.06202 6.1396 8.06202 5.21081C8.06202 4.28201 7.21512 3.52923 6.17021 3.52923C5.1253 3.52923 4.2784 4.28201 4.2784 5.21081Z" fill="#0999D8"></path>
                                </svg>
                            </td>
                            <td>
                                <p><b class="b-title">Địa chỉ</b></p>
                                <p class="p-bottom">
                                    <b class="b-title">Văn phòng Hà Nội</b><br>
                                    Tầng 12 tòa nhà Hồ Gươm Plaza, số 102 Trần Phú, P. Mộ Lao, Q. Hà Đông, TP. Hà Nội, Việt Nam
                                </p>
                                <p class="p-bottom">
                                    <b class="b-title">Văn phòng Hồ Chí Minh</b><br>
                                    Tầng 19 toà nhà Indochina Park Tower, số 4 Nguyễn Đình Chiểu, Phường Đa Kao, Quận 1, TP. HCM
                                </p>
                            </td>
                        </tr> -->
                    </tbody></table>
                   
        </div>
        <div style="padding-right: 15px;padding-left: 15px;">
            <p style="color:#d00000;font-size: 18px;margin-bottom: 20px;">Đăng ký bằng Hình Thức Đóng phí trực tiếp tại Hệ thống Học viện Quốc Tế Yoga Luna Thái hoặc chuyển khoản vào Số tài khoản sau : </p>
                        <img width="720" height="540"
                            src="https://yogalunathai.com/wp-content/uploads/2020/01/bankaccount.png"
                            data-src="https://yogalunathai.com/wp-content/uploads/2020/01/bankaccount.png"
                            class="attachment-large size-large lazy-load-active" alt=""
                            srcset="https://yogalunathai.com/wp-content/uploads/2020/01/bankaccount.png 720w"
                            data-srcset="https://yogalunathai.com/wp-content/uploads/2020/01/bankaccount.png 720w"
                            sizes="(max-width: 720px) 100vw, 720px" style="margin-bottom: 30px; ">
                            <?php 
                        echo $this->render('/layouts/_box_listclass');
                    ?>
                    <!-- <a href='/qua-tang'> -->
                    <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1012219800">
                    <div class="img-inner dark"> <a><img width="720" height="540"
                            src="https://yogalunathai.com/wp-content/uploads/2020/01/registercourse.png"
                            data-src="https://yogalunathai.com/wp-content/uploads/2020/01/registercourse.png"
                            class="attachment-large size-large lazy-load-active" alt=""
                            srcset="https://yogalunathai.com/wp-content/uploads/2020/01/registercourse.png 720w, https://yogalunathai.com/wp-content/uploads/2020/01/81177978_1861683487309766_5087353320041873408_n-300x225.jpg 300w"
                            data-srcset="https://yogalunathai.com/wp-content/uploads/2020/01/registercourse.png 720w, https://yogalunathai.com/wp-content/uploads/2020/01/81177978_1861683487309766_5087353320041873408_n-300x225.jpg 300w"
                            sizes="(max-width: 720px) 100vw, 720px"></a></div>
                </div>
        </div>

        
    </div>

</div>