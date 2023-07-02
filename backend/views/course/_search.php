<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseSearch */
/* @var $form yii\widgets\ActiveForm */
$isRoleLecturer = Yii::$app->user->identity->account_type == \backend\models\Employee::TYPE_LECTURER;
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
                <?php if( !$isRoleLecturer ): ?>
                <div class="col-lg-3">
                    <div id="date-ranger" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Ngày tạo">
                        <i class="fal fa-calendar"></i>&nbsp;<span class="visible-lg-inline-block">Ngày tạo</span>&nbsp; <i class="fal fa-angle-down"></i>
                    </div>
                    <input type="text" name="CourseSearch[date_start]" class="hide" value="<?= (isset($_GET['CourseSearch']) && isset($_GET['CourseSearch']['date_start'])) ? $_GET['CourseSearch']['date_start'] : '' ?>" id="date_start">
                    <input type="text" name="CourseSearch[date_end]" value="<?= (isset($_GET['CourseSearch']) && isset($_GET['CourseSearch']['date_end'])) ? $_GET['CourseSearch']['date_end'] : '' ?>" class="hide" id="date_end">
                </div>
                <?php endif; ?>
                <div class="col-lg-3">
                    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Nhập tên khoá học'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'status')->dropDownList([1 => 'Hoạt động',0=>'Không hoạt động'],['prompt'=>'Chọn trạng thái'])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->field($model, 'is_coming')->dropDownList([1 => 'Sắp diễn ra', 0 => 'Đang diễn ra'],['prompt'=>'Loại'])->label(false) ?>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <a href="index" class="btn btn-warning">Reset</a>
                        <?php if( !$isRoleLecturer ): ?>
                        <?= Html::a('<i class="fal fa-plus"></i> Thêm khoá học', ['create'], ['class' => 'btn btn-success']) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?= $form->field($model, 'is_sell')->hiddenInput(['id'=> 'is_sell'])->label(false); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){

        <?php if((isset($_GET['CourseSearch']['date_start']) && !empty($_GET['CourseSearch']['date_start']))){?>
            var startDate = moment('<?= date('Y-m-d',strtotime($_GET['CourseSearch']['date_start'])) ?>');
        <?php }
            else{
        ?>
            var startDate = moment('2022-12-12');
        <?php
            }
        if((isset($_GET['CourseSearch']['date_end']) && !empty($_GET['CourseSearch']['date_end']))){?>
            var endDate = moment('<?= date('Y-m-d',strtotime($_GET['CourseSearch']['date_end'])) ?>');
        <?php }
            else{
        ?>
            var endDate = moment('<?= date('Y-m-d', time()); ?>');
        <?php
            }
         ?>
        $('#date-ranger').daterangepicker(
            {
                opens: 'right',
                startDate: startDate,
                endDate: endDate,
                minDate: '12/12/2022',
                maxDate: '12/31/2025',
                dateLimit: {
                    days: 365
                },
                showDropdowns: false,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Tuần này(Thứ 2 - Hôm nay)': [moment().startOf('week'), moment()],
                    'Tuần trước(Thứ 2 - Chủ Nhật trước)': [moment().subtract('week', 1).startOf('week'), moment().subtract('week', 1).endOf('week')],
                    '7 ngày qua': [moment().subtract('days', 6), moment()],
                    '14 ngày qua': [moment().subtract('days', 13), moment()],
                    '30 ngày qua': [moment().subtract('days', 29), moment()],
                    'Tháng hiện tại': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
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
                $('#date-ranger span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $("#date_start").val(start.format('YYYY-MM-DD'));
                $("#date_end").val(end.format('YYYY-MM-DD'));
            }
        );
        var _range = <?= (isset($_GET['CourseSearch']['date_start']) && !empty($_GET['CourseSearch']['date_end'])) ? '"'.date('d/m/Y',strtotime($_GET['CourseSearch']['date_start'])).' - '.date('d/m/Y',strtotime($_GET['CourseSearch']['date_end'])).'"' : '"Ngày tạo"' ?>;
        $('#date-ranger span').html(_range);
        
        $('#date-ranger').show();
        $('#date-ranger').on('cancel.daterangepicker', function(ev, picker) {
            $('#date-ranger span').html('Ngày tạo');
            $("#date_start").val('');
            $("#date_end").val('');
        });
    });

</script>