<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
yii\bootstrap\Modal::begin(['id' =>'modal']);
yii\bootstrap\Modal::end();
/* @var $this yii\web\View */
/* @var $model backend\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
$userid = Yii::$app->user->identity->id;
?>
<style>
    .form-group {
    margin-bottom: 15px;
    width: calc(50% - 20px);
    float: left;
    margin-right: 20px;
}
.product {
    border: 1px dashed #ccc;
    margin-bottom: 20px;
    float: left;
    width: 100%;
    padding: 0 20px;
    position: relative;
}
.listproduct.row.col-md-12 {
    padding-right: 0;
}
.invoice-form {
    width: 100%;
    float: left;
}
.add_marterial {
    float: left;
    display: inline-block;
    color: #337ab7;
    cursor: pointer;
}
.product .form-group {
    width: calc(25% - 20px);
}
span.remove {
    cursor: pointer;
    font-weight: 700;
    position: absolute;
    right: 5px;
    top: 1px;
    font-size: 14px;
}
</style>
<script src="/assets/ad15d64c/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'customername')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id_transport')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'status')->dropDownList($items,['prompt' => 'Chọn trạng thái']) ?> 
    <?= $form->field($model, 'note')->textarea(['rows' => '6']) ?> 
    <div class="listproduct row col-md-12">
    <?php 
     \yii\widgets\Pjax::begin(['id' => 'list_invoice']);
        echo    GridView::widget([
            'dataProvider' => $modelProduct,


        'tableOptions' => ['id' => 'inquiry-claimed-grid', 'class' => 'table table-striped table-bordered'],

        'columns' => [ 
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'productname',
                'label' =>'Tên sản phẩm'
            ],
            [
                'attribute'=>'status',
                'label' =>'Trạng thái',
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
                        return 'Trả lại';
                }
            ],
            [
                'attribute'=>'image',
                'label' =>'Link ảnh',
                'format'=>'raw',
                'value' =>function($url) {
                    if($url['image'] != null )
                        return Html::a('link ảnh',$url['image'],['target' => '_blank']);
                }
            ],
            [
                'attribute'=>'quantity',
                'label' =>'Số lượng'
            ],
            [
                'attribute'=>'price',
                'label' =>'Giá',
                'value' =>function($url) {
                    return number_format($url['price']);
                }
            ],
            [
                'attribute'=>'currency',
                'label' =>'Giá tệ',
                'visible'=> $userid == 1 ? '1' : '0'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update}{delete}',
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>','/product/update?id='.$model['id'], [
                        'title' => 'Cập nhật sản phẩm',
                        'class' => 'modalTrans',
                        ]);
                    },
                    'delete' => function ($url, $modelProduct) use ($model) {	
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>','/product/delete?id='.$modelProduct['id'].'&&invoice_id='.$model->id, [
                        'title' => 'Xoá sản phẩm','style'=>'float:right',
                        'data' => [
                            'confirm' => 'Xoá sản phẩm. Bạn có chắc chắn muốn xoá sản phẩm này của khách hàng',
                        ],
                        ]);
                    }
                ]
            ]
        ]
        ]);
        \yii\widgets\Pjax::end();
    ?>
    </div>
    <a href='/product/create?invoice_id=<?=$model->id?>' class="modalTrans" style="margin-bottom: 30px;float: left; ">+ Thêm sản phẩm</a>

    <div class="form-group" style="width: 100%; ">
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function(){
       
        $('.modalTrans').on('click',function(e) {
            e.preventDefault();
            $('#modal').modal('show').find('.modal-content').html('<h3 style=\'font-size: 20px; margin:0 0 10px; border-bottom: 1px solid #ddd; padding-bottom: 12px; text-indent: 10px; background-color: #eee; padding-top: 12px; border-top-left-radius: 4px; border-top-right-radius: 4px;\'>Cập nhật sản phẩm</h3><p style=\'margin:45px 0;float:left;width:100%\' class=\'text-center\'><i class=\'fa fa-spin fa-spinner\'></i> Đang tải dữ liệu...</p>').load($(this).attr('href'));
           
        });
    });
</script>