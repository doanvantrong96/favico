<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Customer;
use backend\models\Course;

/* @var $this yii\web\View */
/* @var $model backend\models\HistoryTransaction */

$this->title = 'Giao dịch #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mua khoá học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-transaction-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label'=>'Tên KH',
                'format' => 'raw',
                'value' => function ($model) {
                    $modelCustomer = Customer::findOne($model->user_id);
                    if( $modelCustomer )
                        return '<b><a href="/customer/view?id=' . $model->user_id . '" target="_blank">' . $modelCustomer['fullname'] . ' - ' . $modelCustomer['phone'] . '</a></b>';
                    return 'N/A';
                },
            ],
            [
                'label'=>'Khoá học',
                'format' => 'raw',
                'value' => function ($model) {
                    $modelCourse = Course::findOne($model->course_id);
                    if( $modelCourse )
                        return '<b><a href="/course/view?id=' . $model->course_id . '" target="_blank">' . $modelCourse['name'] . '</a></b>';
                    return 'N/A';
                },
            ],
            [
                'label'=>'Giá',
                'format' => 'raw',
                'value' => function ($model) {
                    return number_format($model->price,0,',',',') . ' VNĐ';
                },
            ],
            [
                'label'=>'Ngày mua',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('H:i d/m/Y', strtotime($model->create_date));
                },
            ],
            [
                'label'=>'Trạng thái giao dịch',
                'format' => 'raw',
                'value' => function ($model) {
                    if( $model->status == 0 )
                        return 'Đang chờ xử lý';
                    else if( $model->status == 1 )
                        return 'Thành công';
                    else if( $model->status == 2 )
                        return 'Thất bại';
            
                },
            ],
            [
                'label'=>'Ghi chú giao dịch',
                'attribute'=>'note',
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
