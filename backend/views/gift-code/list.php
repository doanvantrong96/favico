<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

Pjax::begin(['id' => 'boxPajax','enablePushState'=>false, 'enableReplaceState'=>false]);
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
                'action' => ['gift-code/list','code'=>isset($_GET['code']) ? $_GET['code'] : ''],
                'method' => 'get',
                'id'     => 'form-modal',
                'options' => [
                    'data-pjax' => 1
                ]
            ]); ?>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'code')->textInput(['placeholder'=>'Nhập mã khuyến mại'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'type_price')->dropDownList([1 => 'Số tiền', 2 => 'Phần trăm'],['prompt'=>'Loại khuyến mại'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'service')->dropDownList(Yii::$app->params['list_service'],['prompt'=>'Tất cả dịch vụ'])->label(false) ?>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary btn_search_modal']) ?>
                        <?= Html::a('<i class="fal fa-history"></i> Chọn lại', ['index'], ['class' => 'btn btn-success btn_reset_modal']) ?>
                        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['gift-code/create'], ['data-pjax'=>0,'class' => 'btn btn-warning','target'=>'_blank']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="table-responsive">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'emptyText' => 'Không có mã khuyến mại nào',
    'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> mã khuyến mại</p>",
    'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => '',
            'format'=> 'raw',
            'value' => function($model){
                $is_checked = isset($_GET['code']) && $_GET['code'] == $model->code ? 'checked="true"' : '';
                return '
                    <div class="custom-control custom-radio">
                        <input '  . $is_checked . ' type="radio" class="custom-control-input" id="gift-code-' . $model->id . '" value="' . $model->code . '" name="gift_code_choose">
                        <label class="custom-control-label" for="gift-code-' . $model->id . '"></label>
                    </div>
                ';
            }
        ],
        'code',
        [
            'attribute' => "price",
            'value' => function($model){
                if( $model->type_price == 1 )
                    return number_format($model->price,0,'.','.') . 'đ';
                else
                    return $model->price . '%' . ($model->max_price_promotion > 0 ? ' (Tối đa ' . number_format($model->max_price_promotion,0,'.','.') . 'đ)' : '');
                
            }
        ],
        [
            'label' => "Dịch vụ",
            'value' => function($model){
                if( $model->service != '' && $model->service != '0' ){
                    $list_service_code = array_filter(explode(';', $model->service));
                    $list_service_name = [];
                    foreach($list_service_code as $id){
                        if( isset(Yii::$app->params['list_service'][$id]) )
                            $list_service_name[] = Yii::$app->params['list_service'][$id];
                    }
                    return implode(', ', $list_service_name);
                }
                return 'Tất cả';
                
            }
        ],
        'date_start',
        'date_end',
    ],
]); 
?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('.btn_reset_modal').click(function(e){
            e.preventDefault();
            $('#form-modal').find('input[type="text"],input[type="hidden"]:not([name="code"]),select').val('');
            $('.btn_search_modal').trigger('click');
        });
    });

</script>
<?php Pjax::end(); ?>