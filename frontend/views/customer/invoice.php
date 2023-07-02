<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

yii\bootstrap\Modal::begin(['id' =>'modal']);
yii\bootstrap\Modal::end();
$this->title = 'Danh sách đơn hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="/assets/ad15d64c/jquery.js"></script>
<style>
    table tr td:last-child{
        text-align: center;
    }
</style>
<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>

<?php 
   echo  GridView::widget([

'dataProvider' => $dataProvider,


// 'tableOptions' => ['id' => 'inquiry-claimed-grid', 'class' => 'table table-striped table-bordered'],
'emptyText' => 'Không có đơn hàng nào',
'summary' => 'Tổng số {totalCount} hàng',

'columns' => [

    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute'=>'id',
        'label' => 'Mã đơn',
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
    [
        'attribute'=>'created_at',
        'label'=>'Thời gian tạo',
        'value' =>function($model){
            return Yii::$app->formatter->asTime($model['created_at'],'y-mm-dd hh:mm:ss');
        }
    ],
    // [
    //     'attribute'=>'updated_at',
    //     'attribute'=>'Cập nhật lần cuối',
    //     'value' =>function($model){
    //         return Yii::$app->formatter->asTime($model['updated_at'],'y-mm-dd hh:mm:ss');
    //     }
    // ],
    [
        'attribute'=>'totalprice',
        'label'=>'Tổng tiền',
        'format'=>'raw',
        'value'=>function($model){
            return Html::a(number_format($model['totalprice']),'/customer/detailinvoice?id='.$model['id'],['class'=>'modalTrans']);
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => ' {confirm}',
        'buttons'=>[

            
            'confirm' => function ($url, $model) {	
                if($model['status'] ==1)	
                return Html::a(Html::button('Xác nhận', ['class' => ' btn btn-primary']),'/customer/confirm?id='.$model['id'], [
                'title' => 'Xác nhận đơn hàng',
                'data' => [
                    'confirm' => 'Xác nhận đơn hàng là đồng ý với đơn hàng này của chúng tôi. Chúng tôi sẽ đặt hàng theo các thông tin sản phẩm có trong đơn hàng.',
                ],
                ]);
            },
        ]
    ]
],

])
?>
</div>
<script>
    $(function(){
       
        $('.modalTrans').on('click',function(e) {
            e.preventDefault();
            $('#modal').modal('show').find('.modal-content').html('<h3 style=\'font-size: 20px; margin:0 0 10px; border-bottom: 1px solid #ddd; padding-bottom: 12px; text-indent: 10px; background-color: #eee; padding-top: 12px; border-top-left-radius: 4px; border-top-right-radius: 4px;\'>Chi tiết đơn hàng</h3><p style=\'margin:45px 0;float:left;width:100%\' class=\'text-center\'><i class=\'fa fa-spin fa-spinner\'></i> Đang tải dữ liệu...</p>').load($(this).attr('href'));
           
        });
    });
</script>