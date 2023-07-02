<?php
    use yii\helpers\Url;

    // $url_payment = Url::to(['payment/check-out','amount'=>$Course->promotional_price > 0 ? $Course->promotional_price : $Course->price ,'bankID'=>'','course_id'=>$Course->id]);
    $url_payment = Url::to(['site/terms']) . '#thanh-toan';
?>
<div class="modal-header">
    <h5 class="modal-title">Thông báo</h5>
    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <p class="text-center"><img width="40" src="/images/block.svg"/></p>
    <p class="text-center">Nội dung khoá học đã bị khoá. Vui lòng ghi danh vào khoá học để mở khoá.</p>
    <a href="<?= $url_payment ?>" style="margin-bottom: 50px !important; margin-top: 50px !important;" class=" mb-3 text-uppercase btn btn-primary btn-lg">Mua khoá học ngay</a>
</div>