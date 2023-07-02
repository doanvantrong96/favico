<?php
    use frontend\models\Course;
    use yii\helpers\Url;

    $course_name = 'N/A';
    $url_course  = '#';
    $amount      = 0;
?>
<p style="text-align: center"><b>Kết quả giao dịch mua khoá học</b></p>
<div class="row">
    <table class="table table-striped table-hover table-hover">
        <tbody>
            <tr>
                <td>Thông tin thanh toán</td>
                <td><?= $_GET['vnp_OrderInfo'] ?></td>
            </tr>
           <?php /* <tr>
                <td>Tên khoá học</td>
                <td><a href="<?= $url_course ?>"><?= $course_name ?></a></td>
            </tr>*/ ?>
            <tr>
                <td>Số tiền thanh toán</td>
                <td><?= number_format($_GET['vnp_Amount']/100,0,'','.') ?></td>
            </tr>
            <tr>
                <td>Đơn vị tiền thanh toán</td>
                <td>VND</td>
            </tr>
            <tr>
                <td>Trạng thái thanh toán</td>
                <td><?= $returnData['Message'] ?></td>
            </tr>
            <tr>
                <td>Ngân hàng</td>
                <td><?= $_GET['vnp_BankCode'] ?></td>
            </tr>
        </tbody>
    </table>
</div>
<p style="text-align: center">
    <a  class="btn btn-default" href="<?= Url::to(['site/index']);?>">Về trang chủ</a>
</p>
<footer class="footer">
    <p>© http://<?= $_SERVER['SERVER_NAME'] .' '. date("Y") ?></p>
</footer>