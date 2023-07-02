<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Employee;
use backend\models\Course;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
if( is_array($model->affliate_id) )
    $model->affliate_id = null;
Pjax::begin(['id' => 'popupPajax','enablePushState'=>false, 'enableReplaceState'=>false]);
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
                'action' => ['sale-admin/commission-detail'],
                'method' => 'get',
                'id'     => 'form-modal',
                'options' => [
                    'data-pjax' => 1
                ]
            ]); ?>
            <div class="row">
                <div class="col-lg-3">
                    <div id="dateRange-order" class="date-range pull-right tooltips btn btn-fit-height grey-salt" data-toggle="tooltip" data-placement="bottom" title="Ngày đặt đơn">
                        <i class="fal fa-calendar-alt"></i>&nbsp;<span class="visible-lg-inline-block">Ngày đặt đơn</span>&nbsp; <i class="fal fa-angle-down" style="float: right; margin-right: 2px; font-size: 16px; font-weight: bold; position: relative; top: 1px;"></i>
                        <?php
                            echo $form->field($model, 'date_start')->hiddenInput(['id'=> 'datestart_order'])->label(false);
                            echo $form->field($model, 'date_end')->hiddenInput(['id'=> 'dateend_order'])->label(false);
                        ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'affliate_id')->dropDownList($listSale,['prompt'=>'Tài khoản sale'])->label(false) ?>
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
    'emptyText' => 'Không có dữ liệu',
    'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> tài khoản sale</p>",
    'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
    'rowOptions'=>function($model){
        return ['id'=>'tr-user-'.$model->id];
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label'=>'Tài khoản sale',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->sale_name;
            },
        ],
        [
            'label'=>'Doanh thu khoá học',
            'format' => 'raw',
            'value' => function ($model) {
                if( $model->price > 0 ){
                    $price = $model->price;
                    return number_format($price,0,'.','.') . 'đ';
                }
                return '0 đ';
            },
            
        ],
        [
            'header'=>'Hoa hồng sale',
            'format' => 'raw',
            'value' => function ($model) {
                $price_sale     = 0;
                if( $model->price > 0 ){
                    $price      = $model->price;
                    $percent_revenue = $model->commission_percentage_of_sale;
                    $price_sale = number_format(($price/100)*$percent_revenue, 0, '.', '.');
                }

                return $price_sale . 'đ (' . $model->commission_percentage_of_sale . '%)';
            },
            
        ],
        [
            'header'=>'Hoa hồng của bạn',
            'format' => 'raw',
            'value' => function ($model) {
                $price_sale_admin    = 0;
                $percent_revenue_sale_admin = 0;
                if( $model->price > 0 ){
                    $price      = $model->price;
                    $percent_revenue_sale_admin = Yii::$app->user->identity->commission_percentage - $model->commission_percentage_of_sale;
                    $price_sale_admin = number_format(($price/100)*$percent_revenue_sale_admin, 0, '.', '.');
                }
                return $price_sale_admin . 'đ (' . $percent_revenue_sale_admin . '%)';
            },
            
        ],
    ],
]); ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('.btn_reset_modal').click(function(e){
            e.preventDefault();
            $('#form-order').find('input[type="text"],input[type="hidden"]:not([name="user_id"]),select').val('');
            $('#dateRange-order span').html('Ngày đặt đơn');
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
        $('#dateRange-order').daterangepicker({
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
                $('#dateRange-order span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $("#datestart_order").val(start.format('YYYY-MM-DD'));
                $("#dateend_order").val(end.format('YYYY-MM-DD'));
            }
        );
        var _range = <?= ($model->date_start) ? '"'.date('d/m/Y',strtotime($model->date_start)).' - '.date('d/m/Y',strtotime($model->date_end)).'"' : '"Ngày đặt đơn"' ?>;
        $('#dateRange-order span').html(_range);
        $('#dateRange-order').show();
        $('#dateRange-order').on('cancel.daterangepicker', function(ev, picker) {
            $('#dateRange-order span').html('Ngày đặt đơn');
            $("#datestart_order").val('');
            $("#dateend_order").val('');
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