<?php
    use frontend\models\Course;
    use yii\helpers\Url;

    $course_name = 'N/A';
    $url_course  = '#';
    $amount      = 0;
    if( isset($order) && $order ){
        $modelCourse = Course::findOne($order->course_id);
        if($modelCourse ){
            $course_name = $modelCourse->name;
            $url_course  = Url::to(['product/detail', 'slug' => $modelCourse->slug]);//Điền link chi tiết khoá học ở đây
            $amount      = number_format($order->price,0,',',',');
        }
    }
?>
<p style="text-align: center"><b>Kết quả giao dịch mua khoá học</b></p>
<div class="row">
    <table class="table table-striped table-hover table-hover">
        <tbody>
            <tr>
                <td>Thông tin thanh toán</td>
                <td>Thanh toán mua khoá học #<?= (isset($order) && $order) ? $order->course_id  : 'N/A' ?></td>
            </tr>
            <tr>
                <td>Tên khoá học</td>
                <td><a href="<?= $url_course ?>"><?= $course_name ?></a></td>
            </tr>
            <tr>
                <td>Số tiền thanh toán</td>
                <td><?= $amount ?></td>
            </tr>
            <tr>
                <td>Đơn vị tiền thanh toán</td>
                <td>VND</td>
            </tr>
            <tr>
                <td>Trạng thái thanh toán</td>
                <td><?= $RspCode == '00' ? 'Giao dịch thành công' : 'Giao dịch thất bại' ?></td>
            </tr>
            <tr>
                <td>Ghi chú thanh toán</td>
                <td><?= $Message ?></td>
            </tr>
            <tr>
                <td>Ngân hàng</td>
                <td><?= $Bank ?></td>
            </tr>
        </tbody>
    </table>
</div>
<p style="text-align: center">
    <a  class="btn btn-default" href="<?= Url::to(['product/index']);?>">Về trang chủ</a>
</p>
<footer class="footer">
    <p>© http://<?= $_SERVER['SERVER_NAME'] ?> 2021</p>
</footer>