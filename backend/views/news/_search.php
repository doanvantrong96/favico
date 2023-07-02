<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Employee;
use backend\controllers\CommonController;

$listAuthor = ( CommonController::checkAccess('/news/show') || CommonController::checkAccess('/news/hide') ) ? ArrayHelper::map(Employee::find()->where(['is_active'=>1])->all(),'id','fullname') : [];
$resultCategory = \backend\models\Category::find()->select(['id','name','slug'])->where(['status'=>1,'is_delete'=>0])->all();
$listCategory = [];
foreach($resultCategory as $rowCat){
    $listCategory[$rowCat['id']] = $rowCat['name'];
}
/* @var $this yii\web\View */
/* @var $model backend\models\CoachCourseSearch */
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

                <div class="col-md-3">
                    <?= $form->field($model, 'title')->textInput(['placeholder' => 'Nhập tên bài viết cần tìm ...' ])->label(false) ?>
                </div>
                <div class="col-lg-3">
                    <div id="date-range" class="date-range pull-right tooltips btn btn-fit-height grey-salt" data-toggle="tooltip" data-placement="top" title="Ngày đăng bài">
                        <i class="fal fa-calendar-alt"></i>&nbsp;<span class="visible-lg-inline-block">Ngày đăng bài</span>&nbsp; <i class="fal fa-angle-down" style="float: right; margin-right: 2px; font-size: 16px; font-weight: bold; position: relative; top: 1px;"></i>
                        <?php
                            echo $form->field($model, 'date_start')->hiddenInput(['id'=> 'date_start'])->label(false);
                            echo $form->field($model, 'date_end')->hiddenInput(['id'=> 'date_end'])->label(false);
                        ?>
                    </div>
                    
                    
                </div>
                <?php if( $model->tab == 'all' ): ?>
                <div class="col-lg-3">
                    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['news_status'],['prompt'=>'Trạng thái','class'=>'form-control select2'])->label(false) ?>
                </div>
                <?php endif; ?>
                <?php /*if(!empty($listAuthor) && Yii::$app->user->identity->is_admin){ ?>
                <div class="col-lg-3">
                    <?= $form->field($model, 'author')->dropDownList($listAuthor,['prompt'=>'Người đăng bài','class'=>'form-control select2'])->label(false) ?>
                </div>
                

                <div class="col-lg-9">
                    <?= $form->field($model, 'category_id')->dropDownList($listCategory,['class'=>'form-control select2','multiple'=>true,'placeholder'=> "Chuyên mục"])->label(false) ?>
                </div>
                <?php }*/ ?>
                <div class="col-lg-3">
                    
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fal fa-search"></i> Lọc', ['class' => 'btn btn-primary']) ?>
                        <?php 
                            if($roleCreate)
                                echo Html::a('<i class="fal fa-plus"></i> Viết bài mới', ['create'], ['class' => 'btn btn-success']);
                        ?>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'tab')->hiddenInput()->label(false); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){

        <?php if( $model->date_start ){?>
            var startDate = moment('<?= date('Y-m-d',strtotime($model->date_start)) ?>');
        <?php }
            else{
        ?>
            var startDate = moment('2021-03-01');
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
        $('#date-range').daterangepicker({
                opens: 'right',
                startDate: startDate,
                endDate: endDate,
                minDate: '01/03/2021',
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
                $('#date-range span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $("#date_start").val(start.format('YYYY-MM-DD'));
                $("#date_end").val(end.format('YYYY-MM-DD'));
            }
        );
        var _range = <?= ($model->date_start) ? '"'.date('d/m/Y',strtotime($model->date_start)).' - '.date('d/m/Y',strtotime($model->date_end)).'"' : '"Ngày đăng bài"' ?>;
        $('#date-range span').html(_range);
        $('#date-range').show();
        $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
            $('#date-range span').html('Ngày đăng bài');
            $("#date_start").val('');
            $("#date_end").val('');
        });
    });

</script>

<style>
.date-range{padding: 8px 4px;min-width: 175px;width:100%;width: 100%;border: 1px solid #E5E5E5;text-align: left; padding-left: 14px;}
button.applyBtn.btn.btn-sm.blue { background-color: #886ab5; color: #fff; }
button.applyBtn.btn.btn-sm.blue:hover {opacity:.8 }
.date-range .form-group{display:none}
.select2-container .select2-selection--multiple{min-height:37px}
.select2-container--default .select2-selection--multiple .select2-selection__rendered{padding:2px 5px}
</style>