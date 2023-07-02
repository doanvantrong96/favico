<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Employee;
use backend\models\Course;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$listSale = ArrayHelper::map(Employee::find()->where(['is_active'=>1, 'account_type' => Employee::TYPE_SALE ])->all(),'affliate_id','fullname');

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
                'action' => ['customer/history-order?user_id=' . $user_id],
                'method' => 'get',
                'id'     => 'form-modal',
                'options' => [
                    'data-pjax' => 1
                ]
            ]); ?>
            <div class="row">
                <div class="col-lg-3">
                    <div id="date-range-order" class="date-range pull-right tooltips btn btn-fit-height grey-salt" data-toggle="tooltip" data-placement="bottom" title="Ngày đặt đơn">
                        <i class="fal fa-calendar-alt"></i>&nbsp;<span class="visible-lg-inline-block">Ngày đặt đơn</span>&nbsp; <i class="fal fa-angle-down" style="float: right; margin-right: 2px; font-size: 16px; font-weight: bold; position: relative; top: 1px;"></i>
                        <?php
                            echo $form->field($model, 'date_start')->hiddenInput(['id'=> 'date_start_order'])->label(false);
                            echo $form->field($model, 'date_end')->hiddenInput(['id'=> 'date_end_order'])->label(false);
                        ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'status')->dropDownList(Yii::$app->params['orderStatus'],['prompt'=>'Tình trạng đơn hàng'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'type')->dropDownList(Yii::$app->params['orderType'],['prompt'=>'Hình thức thanh toán'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'affliate_id')->dropDownList($listSale,['prompt'=>'Sale'])->label(false) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'id')->textInput(['placeholder'=>'Mã đơn'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary btn_search_modal']) ?>
                        <?= Html::a('<i class="fal fa-history"></i> Chọn lại', ['index'], ['class' => 'btn btn-success btn_reset_modal']) ?>
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
    'emptyText' => 'Không có đơn hàng nào',
    'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> đơn hàng</p>",
    'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
    'rowOptions'=>function($model){
        return ['id'=>'tr-user-'.$model->id];
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label'=>'Ngày đặt đơn',
            'format' => 'raw',
            'value' => function ($model) {
                return date('H:i d/m/Y', strtotime($model->create_date));
            },
        ],
        [
            'label'=>'Khoá học',
            'format' => 'raw',
            'value' => function ($model) {
                $list_course = explode(',', $model->list_course);
                $html = '';
                foreach($list_course as $row){
                    $data = explode('#', $row);
                    $modelCourse    = Course::findOne($data[0]);
                    if( $modelCourse ){
                        $price      = (int)$data[1];
                        $price_discount = (int)$data[2];
                        $html_price = '';
                        if( $price_discount > 0 )
                            $html_price = '<span data-toggle="tooltip" data-placement="bottom" title="Giá giảm">' . number_format($price_discount,0,',',',') . '</span> (<span data-toggle="tooltip" data-placement="bottom" style="text-decoration: line-through;" title="Giá gốc">' . number_format($price,0,',',',') . '</span>)';
                        else
                            $html_price = number_format($price,0,',',',');

                        $html .= '<p style="margin-bottom:0">- <b>' . $modelCourse->name . '</b>: ' . $html_price . '</p>';


                    }
                }
                return $html ? $html : '---';
            },
            
        ],
        [
            'label'=>'Mã khuyến mại',
            'format' => 'raw',
            'value' => function ($model) {
                if( $model->gift_code ){
                    return $model->$model->gift_code;
                }
                return 'Không có';
            },
            
        ],
        [
            'label'=>'Giá',
            'format' => 'raw',
            'value' => function ($model) {
                if( $model->price > 0 ){
                    $price = $model->price;
                    return number_format($price,0,'.','.') . 'đ';
                }
                return '---';
            },
            
        ],
        [
            'label'=>'Tình trạng',
            'format' => 'raw',
            'value' => function ($model) {
                $status_order = Yii::$app->params['orderStatus'];
                if( isset($status_order[$model['status']]) )
                    return $status_order[$model['status']];
                
                return '---';
            },
            
        ],
        [
            'label'=>'Sale',
            'format' => 'raw',
            'value' => function ($model) {
                if( $model->affliate_id > 0 ){
                    $modelSale = Employee::findOne(['affliate_id' => $model->affliate_id]);
                    if( $modelSale )
                        return $modelSale->fullname;
                    else
                        return 'N/A';
                }
                
                return '---';
            },
        ]
    ],
]); ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('.btn_reset_modal').click(function(e){
            e.preventDefault();
            $('#form-modal').find('input[type="text"],input[type="hidden"]:not([name="user_id"]),select').val('');
            $('#date-range-order span').html('Ngày đặt đơn');
            $('.btn_search_modal').trigger('click');
        });
        <?php if( $model->date_start ){?>
            var startDate = moment('<?= date('Y-m-d',strtotime($model->date_start)) ?>');
        <?php }
            else{
        ?>
            var startDate = moment('2022-12-10');
        <?php
            }
        if( $model->date_end ){?>
            var endDate = moment('<?= date('Y-m-d',strtotime($model->date_end)) ?>');
        <?php }
            else{
        ?>
            var endDate = moment('<?= date('Y-m-d', time()); ?>');
        <?php
            }
         ?>
        $('#date-range-order').daterangepicker({
                opens: 'right',
                startDate: startDate,
                endDate: endDate,
                minDate: '12/10/2022',
                maxDate: '12/31/2025',
                dateLimit: {
                    days: 365
                },
                showDropdowns: false,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                // ranges: {
                //     'Hôm nay': [moment(), moment()],
                //     'Hôm qua': [moment().subtract('days', 1), moment().subtract('days', 1)],
                //     'Tuần này(Thứ 2 - Hôm nay)': [moment().startOf('week'), moment()],
                //     'Tuần trước(Thứ 2 - Chủ Nhật trước)': [moment().subtract('week', 1).startOf('week'), moment().subtract('week', 1).endOf('week')],
                //     '7 ngày qua': [moment().subtract('days', 6), moment()],
                //     '14 ngày qua': [moment().subtract('days', 13), moment()],
                //     '30 ngày qua': [moment().subtract('days', 29), moment()],
                //     'Tháng hiện tại': [moment().startOf('month'), moment().endOf('month')],
                //     'Tháng trước': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                // },
                buttonClasses: ['btn btn-sm'],
                applyClass: ' blue',
                cancelClass: 'default',
                format: 'MM/DD/YYYY',
                separator: ' đến ',
                locale: {
                    applyLabel: 'Chọn',
                    cancelLabel: 'Hủy',
                    fromLabel: 'Từ',
                    toLabel:'Đến',
                    customRangeLabel: 'Tùy chỉnh',
                    daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    firstDay: 1
                }
            },
            function (start, end) {
                $('#date-range-order span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $("#date_start_order").val(start.format('YYYY-MM-DD'));
                $("#date_end_order").val(end.format('YYYY-MM-DD'));
            }
        );
        var _range = <?= ($model->date_start) ? '"'.date('d/m/Y',strtotime($model->date_start)).' - '.date('d/m/Y',strtotime($model->date_end)).'"' : '"Ngày đặt đơn"' ?>;
        $('#date-range-order span').html(_range);
        $('#date-range-order').show();
        $('#date-range-order').on('cancel.daterangepicker', function(ev, picker) {
            $('#date-range-order span').html('Ngày đặt đơn');
            $("#date_start_order").val('');
            $("#date_end_order").val('');
        });
    });

</script>

<style>
.date-range{padding: 8px 4px;min-width: 175px;width:100%;width: 100%;border: 1px solid #E5E5E5;text-align: left; padding-left: 14px;}
button.applyBtn.btn.btn-sm.blue { background-color: #886ab5; color: #fff; }
button.applyBtn.btn.btn-sm.blue:hover {opacity:.8 }
.date-range .form-group{display:none}
td p{margin-bottom:0}
</style>
<?php Pjax::end(); ?>