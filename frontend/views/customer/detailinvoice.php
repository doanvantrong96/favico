<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

$this->title = 'Chi tiết đơn hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

.modal-content {
    float: left;
    padding: 20px;
    width: 100%;
}
</style>
<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>

<?php 
   echo  GridView::widget([

'dataProvider' => $dataProvider,


// 'tableOptions' => ['id' => 'inquiry-claimed-grid', 'class' => 'table table-striped table-bordered'],
'emptyText' => 'Không có sản phẩm nào',
'columns' => [

    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute'=>'productname',
        'label' => 'Tên sản phẩm',
    ],
    // [
    //     'attribute'=>'link',
    //     'label' => 'Link ảnh',
    //     'format'=>'raw',
    //     'value' =>function($url) {
    //         return Html::a('link ảnh',$url['link'],['target' => '_blank']);
    //     }
    // ],
    [
        'attribute'=>'status',
        'label'=>'Trạng thái',
        'value'=>function($model){
            if($model['status'] == 1)
                return 'Chờ xác nhận';
            if($model['status'] == 2)
                return 'Đang vận chuyển';
            if($model['status'] == 3)
                return 'Đã huỷ';
            if($model['status'] == 4)
                return 'Hàng đã về';
            if($model['status'] == 5)
                return 'Đã lấy hàng';
            if($model['status'] == 6)
                return 'Đã trả lại';

        }
    ],
    // [
    //     'attribute'=>'created_at',
    //     'label'=>'Thời gian tạo',
    //     'value' =>function($model){
    //         return Yii::$app->formatter->asTime($model['created_at'],'y-mm-dd hh:mm:ss');
    //     }
    // ],
    [
        'attribute'=>'quantity',
        'label'=>'Số lượng',
        
    ],
    [
        'attribute'=>'price',
        'label'=>'Giá',
        'value'=>function($model){
            return number_format($model['price']);
        }
    ],
    // [
    //     'class' => 'yii\grid\ActionColumn',
    //     'template' => ' {confirm}',
    //     'buttons'=>[

            
    //         'confirm' => function ($url, $model) {	
    //             if($model['status'] ==1)	
    //             return Html::a(Html::button('Xác nhận', ['class' => ' btn btn-primary']),'/customer/confirm?id='.$model['id'], [
    //             'title' => 'Xác nhận đơn hàng',
    //             'data' => [
    //                 'confirm' => 'Xác nhận đơn hàng là đồng ý với đơn hàng này của chúng tôi. Chúng tôi sẽ đặt hàng theo các thông tin sản phẩm có trong đơn hàng.',
    //             ],
    //             ]);
    //         },
    //     ]
    // ]
],

])
?>
</div>
