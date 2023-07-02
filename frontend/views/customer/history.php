<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

$this->title = 'Lịch sử đặt hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table tr td:last-child{
        text-align: center;
    }
</style>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

<?php 
   echo  GridView::widget([

'dataProvider' => $dataProvider,


// 'tableOptions' => ['id' => 'inquiry-claimed-grid', 'class' => 'table table-striped table-bordered'],
'emptyText' => 'Không có yêu cầu nào',
'summary' => 'Tổng số {totalCount} hàng',
'columns' => [

    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute'=>'id',
        'label' => 'Mã đơn',
    ],
    [
        'attribute'=>'link',
        'label' => 'Link ảnh',
        'format'=>'raw',
        'value' =>function($url) {
            return Html::a('link ảnh',$url['link'],['target' => '_blank']);
        }
    ],
    [
        'attribute'=>'status',
        'label'=>'Trạng thái',
        'value'=>function($model){
            if($model['status'] == 1)
                return 'Chờ xác nhận';
            if($model['status'] == 2)
                return 'Đã xác nhận';
            if($model['status'] == 3)
                return 'Đã huỷ';
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
        'class' => 'yii\grid\ActionColumn',
        'template' => ' {delete}',
        'buttons'=>[

            
            'delete' => function ($url, $model) {	
                if($model['status'] ==1)	
                return Html::a(Html::button('Huỷ yêu cầu', ['class' => ' btn btn-primary']),'/customer/delete?id='.$model['id'], [
                'title' => 'Huỷ yêu cầu',
                'data' => [
                    'confirm' => 'Huỷ yêu cầu. Bạn có chắc chắn muốn huỷ yêu cầu này của mình',
                ],
                ]);
            },
        ]
    ]
],

])
?>
</div>
