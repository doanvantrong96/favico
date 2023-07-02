<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đơn hàng';
$this->params['breadcrumbs'][] = $this->title;
$userid = Yii::$app->user->identity->id;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tạo đơn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'label'=>'Mã đơn'
            ],
           
            [
                'attribute'=>'id_transport',
                'label'=>'Mã vận đơn'
            ],
            [
                'attribute'=>'customername',
                'label'=>'Khách hàng'
            ],
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
                        return 'Hàng về đến kho';
                    if($model['status'] == 5)
                        return 'Đã lấy hàng';
                    if($model['status'] == 6)
                        return 'Hàng trả lại';
                }
            ],
            [
                'attribute'=>'totalprice',
                'label'=>'Tổng tiền',
                // 'format'=>'raw',
                // 'format' => ['decimal',0]
                'value' =>function($url) {
                    return number_format($url['totalprice']);
                }
            ],
            [
                'attribute'=>'totalcurrency',
                'label'=>'Tổng tệ',
                // 'format'=>'raw',
                // 'format' => ['decimal',0]
                'value' =>function($url) {
                    return number_format($url['totalcurrency']);
                },
                'visible'=> $userid == 1 ? '1' : '0'
            ],
            [
                'attribute'=>'username',
                'label'=>'Nhân viên đặt'
            ],
            [
                'attribute'=>'note',
                'label'=>'Ghi chú',
            ],

            [
                'attribute'=>'created_at',
                'label'=>'Thời gian tạo',
                'value' =>function($model){
                    return Yii::$app->formatter->asTime($model['created_at'],'y-mm-dd hh:mm:ss');
                }
            ],
            [
                'attribute'=>'updated_at',
                'label'=>'Cập nhật lần cuối',
                'value' =>function($model){
                    return Yii::$app->formatter->asTime($model['updated_at'],'y-mm-dd hh:mm:ss');
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update}{delete}',
                'buttons'=>[

                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>','/invoice/update?id='.$model['id'], [
                        'title' => 'Cập nhật đơn hàng',

                        ]);
                    },
                    'delete' => function ($url, $model) {	
                        if($model['status'] ==1)	
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>','/invoice/delete?id='.$model['id'], [
                        'title' => 'Huỷ yêu cầu','style'=>'float:right',
                        'data' => [
                            'confirm' => 'Huỷ yêu cầu. Bạn có chắc chắn muốn huỷ yêu cầu này của khách hàng',
                        ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
