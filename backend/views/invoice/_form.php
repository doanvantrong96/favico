<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
/* .invoice-form {
    width: 100%;
    float: left;
} */
p.add_marterial {
    float: left;
    display: inline-block;
    color: #337ab7;
    cursor: pointer;
    margin-bottom: 20px;
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
form div.required label.control-label:after {

content:" * ";

color:red;

}
</style>
<script src="/assets/ad15d64c/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
<div class="invoice-form">

    <?php $form = ActiveForm::begin([
        'id'=>'prodForm',
        'method' => 'post',
        'action' => '/invoice/create',
        // 'fieldConfig' => [
        //     'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-6 div_err\">{error}</div>",
        //     'labelOptions' => ['class' => 'col-lg-2 control-label'],
        // ],
    ]); ?>
    <?= $form->field($model, 'customername')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id_transport')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'note')->textarea(['rows' => '6']) ?> 
    <div class="listproduct row col-md-12">
        <div class="product" id="material-1">
            <span class="remove" onclick="removeMaterial(1)" title="Xoá" dtid="1">X</span>
            <h4 >Sản phẩm 1</h4>
            <div class="form-group required">
                <label class="control-label" for="invoice-customername">Tên sản phẩm</label>
                <input type="text" class="form-control"  name="material_name[1]  maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
            <div class="form-group">
                <label class="control-label" for="invoice-customername">Link ảnh</label>
                <input type="text" class="form-control" name="material_link[1]  maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
            <div class="form-group required">
                <label class="control-label" for="invoice-customername">Giá</label>
                <input type="text" class="form-control price"  name="material_price[1] maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
            <?php if( $userid == 1): ?>
            <div class="form-group">
                <label class="control-label" for="invoice-customername">Giá tệ</label>
                <input type="text" class="form-control"  name="material_currency[1] maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
           <?php endif;?>
            <div class="form-group  required">
                <label class="control-label" for="invoice-customername">Số lượng</label>
                <input type="text" class="form-control" name="material_quantity[1]  maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
        </div>
    </div>
    <p class="add_marterial">+ Thêm sản phẩm</p>

    <div class="form-group" style="width: 100%; ">
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success','id'=>'my_id','onclick'=>'submitFormData()']) ?>
    
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function(){
        var i = 1;
        $('.add_marterial').on('click',function(){
            i++;
            $('.listproduct').append(Mustache.render($('#tmpl_material').html(), {id : i}));
            //$('#material-' + i + ' select').chosen();
	    });
        
    });
    function submitFormData(e){
             event.preventDefault();
             var flag_submit = true;
             $('form div.required input').each(function(){
                if($(this).val() == '')
                  return flag_submit = false;
                return true;
             });
			if( flag_submit )
				$( "#prodForm" ).submit();
            else{
                alert('Điền đầy đủ thông tin trường có dấu *');
            }
            
	    }
    function removeMaterial(id){
            if(confirm('Bạn có chắc chắn muốn xoá sản phẩm này?')){
                $('#material-' + id).remove();
            }
	    }
</script>
<script type="text/template" id="tmpl_material">
        <div class="product" id="material-{{id}}">
         <span class="remove" onclick="removeMaterial({{id}})" title="Xoá" dtid="{{id}}">X</span>
            <h4 >Sản phẩm {{id}}</h4>
            <div class="form-group field-invoice-customername required">
                <label class="control-label" for="invoice-customername">Tên sản phẩm</label>
                <input type="text" class="form-control" name="material_name[{{id}}] maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
            <div class="form-group field-invoice-customername">
                <label class="control-label" for="invoice-customername">Link ảnh</label>
                <input type="text" class="form-control" name="material_link[{{id}}] maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
            <div class="form-group field-invoice-customername required">
                <label class="control-label" for="invoice-customername">Giá</label>
                <input type="text" class="form-control price"  name="material_price[{{id}}] maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
            <?php if( $userid == 1): ?>
            <div class="form-group">
                <label class="control-label" for="invoice-customername">Giá tệ</label>
                <input type="text" class="form-control"  name="material_currency[{{id}}] maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
           <?php endif;?>
            <div class="form-group field-invoice-customername required">
                <label class="control-label" for="invoice-customername">Số lượng</label>
                <input type="text" class="form-control" name="material_quantity[{{id}}] maxlength="255" aria-required="true">

                <div class="help-block"></div>
            </div>
        </div>
</script>