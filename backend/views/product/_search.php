<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Category;
use backend\models\ProductTag;
use backend\models\ProductCategory;
use yii\helpers\ArrayHelper;
use backend\models\Employee;
use backend\controllers\CommonController;

?>

<div class="panel">
    <div class="panel-hdr">
        <h2>
            Lọc và tìm kiếm
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'title')->textInput(['placeholder' => 'Nhập tên sản phẩm cần tìm ...' ])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList'],['prompt'=>'Trạng thái'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php
                        $all_category       = ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name');
                        echo $form->field($model, 'category_id')->dropDownList($all_category,['prompt'=>'Nhà cung cấp','class'=>'form-control select2'])->label(false);
                    ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'is_most')->dropDownList(Yii::$app->params['statusProduct'],['prompt'=>'Kiểu sản phẩm'])->label(false) ?>
                </div>
                <div class="col-lg-9">
                    <?php 
                        $all_tag       = ArrayHelper::map(ProductTag::find()->all(), 'id', 'name');
                        echo $form->field($model, 'tag_id')->dropDownList($all_tag,['multiple' => true,'placeholder'=>'Chọn loại', 'class'=>'form-control select2'])->label(false) ?>
                </div>
                
                <div class="col-lg-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<style>
    .form-parent .select2{
        width:100% !important;
    }
    .img-grid{
        max-width: 200px;
        max-height: 100px;
    }
</style>
