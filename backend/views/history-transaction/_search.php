<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Employee;
use yii\helpers\ArrayHelper;

$listSale = ArrayHelper::map(Employee::find()->where(['is_active'=>1, 'account_type' => Employee::TYPE_SALE ])->all(),'affliate_id','fullname');
/* @var $this yii\web\View */
/* @var $model backend\models\HistoryTransactionSearch */
/* @var $form yii\widgets\ActiveForm */
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
                    <?= $form->field($model, 'fullname')->textInput(['placeholder'=>'Tên KH, SĐT, Mã đơn'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary btn_search_modal']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
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