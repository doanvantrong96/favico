<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;

$this->title = 'Thống kê';
?>
<div class="statistic-index">
    <div class="panel box-summary">
        <div class="panel-hdr">
            <h2>
                Tổng quan
            </h2>
            <div class="box-date">
                <span>Từ</span>
                <div style="width: auto;" class="input-date-statistic pull-right tooltips btn btn-fit-height grey-salt" data-format="YYYY-MM-DD">
                    <i class="fal fa-calendar-alt"></i>&nbsp;<span class="visible-lg-inline-block"><?= date('d/m/Y', strtotime($date_start)) ?></span>&nbsp; <i class="fal fa-angle-down"></i>
                    <input type="hidden" class="input-hidden-start" value="<?= $date_start ?>" />
                </div>
                <span>Đến</span>
                <div style="width: auto;" class="input-date-statistic pull-right tooltips btn btn-fit-height grey-salt" data-format="YYYY-MM-DD">
                    <i class="fal fa-calendar-alt"></i>&nbsp;<span class="visible-lg-inline-block"><?= date('d/m/Y', strtotime($date_end)) ?></span>&nbsp; <i class="fal fa-angle-down"></i>
                    <input type="hidden" class="input-hidden-end" value="<?= $date_end ?>" />
                </div>
                <button type="button" class="btn btn-primary btn-report" data-type="summary">Xem</button>
            </div>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container collapse show top-post top" style="">
            <div class="panel-content" style="position: relative;">
                <div class="row">

                    <div class="col-sm-6 col-xl-3">
                        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                            <div style="position:relative;z-index:1">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <a href="#" class="link-detail total_order" style="color:#fff"><?= $dataStatistic['total_order'] ?></a>
                                    <small style="font-size: 14px;" class="m-0 l-h-n">Lượt đặt hàng <span class="fal fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tổng lượt đặt hàng của các tài khoản sale theo thời gian đã chọn"></span></small>
                                </h3>
                            </div>
                            <i class="fal fa-cart-plus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                            <div style="position:relative;z-index:1">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <a href="#"  class="link-detail total_order_success" style="color:#fff"><?= $dataStatistic['total_order_success'] ?></a>
                                    <small style="font-size: 14px;" class="m-0 l-h-n">Lượt đặt hàng thành công <span class="fal fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tổng lượt đơn hàng thanh toán thành công các tài khoản sale theo thời gian đã chọn"></span></small>
                                </h3>
                            </div>
                            <i class="fal fa-cart-plus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                            <div style="position:relative;z-index:1">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <a href="javascript:;" class="link-detail total_revenue" style="color:#fff"><?= $dataStatistic['total_revenue'] ?></a>
                                    <small style="font-size: 14px;" class="m-0 l-h-n">Hoa hồng tạm tính <span class="fal fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tổng hoa hồng tạm tính nhận được sau khi trừ % hoa hồng từ các tài khoản sale bạn đã tạo theo thời gian đã chọn"></span></small>
                                </h3>
                            </div>
                            <i class="fal fa-money-bill position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Danh sách đơn hàng
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container collapse show top-post top" style="">
            <div class="panel-content" style="height:400px;position: relative;">
                <?php
                    $template_index = 'transaction/index';
                    echo $this->render($template_index, [
                        'dataProvider' => $dataProvider,
                        'searchModel'  => $searchModel,
                        'listSale'     => $listSale
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-1.12.4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
  var isMobile      = window.innerWidth <= 600;
  var dynamicColors = function(listColorExclude = []) {
    var color =  "";
    var isNotBreak = false;
    do
    {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);

        color =  "rgb(" + r + "," + g + "," + b + ")";
        if( color != "" && color != "rgb(255,255,255)" && listColorExclude.indexOf(color) === -1 ){
            isNotBreak = true;
        }
    } while (!isNotBreak)
    
    return color;
  }
  
  function initStatistic(dataStatistic, type = 'all'){
    
        if( type == 'all' || type == 'summary' ){
            $('.total_order').text(dataStatistic.total_order);
            $('.total_order_success').text(dataStatistic.total_order_success);
            $('.total_revenue').text(dataStatistic.total_revenue);
        }
  }
  function ajaxStatistic(type,date_start,date_end, _element){
    _element.addClass('disabled');
    $.ajax({
        url : window.location.href,
        type : 'POST',
        data : {type : type, date_start: date_start,date_end: date_end },
        success : function(result){
            initStatistic(result, type);
            setTimeout(function(){
                _element.removeClass('disabled');
            },1000)
        },
        error: function(){
            _element.removeClass('disabled');
            toastr["error"]('Có lỗi! Vui lòng liên hệ quản trị');
        }
    })
  }
  function copyToClipboard(text, msg) {
        toastr.remove();
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        $temp.focus();
        document.execCommand("copy");
        $temp.remove();

        toastr["success"](msg);
  }
  jQuery(document).ready(function(){
    var startDate = moment('<?= $date_start ?>');
    var endDate   = moment('<?= $date_end ?>');
    initStatistic($.parseJSON('<?= json_encode($dataStatistic) ?>'), 'all');
    $('.total_revenue').click(function(){
        var _this = $(this);
        $('#modal-order .modal-dialog').attr('style','width: 80%; max-width: none;');
        $('#modal-order .modal-title').html('Chi tiết hoa hồng theo tài khoản sale');
        $('#modal-order').modal('show').find('.modal-body').load('/sale-admin/commission-detail?OrderCartSearch[date_start]=' + $('.box-summary .input-hidden-start').val() + '&OrderCartSearch[date_end]=' + $('.box-summary .input-hidden-end').val());
    });
    $('.input-date-statistic').each(function(index,_this){
        var options = {
            singleDatePicker: true,
            showDropdowns: true,
            minDate: moment().startOf('year').format('YYYY-MM-DD'),
            minYear: parseInt(moment().format('YYYY'),10),
            maxYear: parseInt(moment().add(10, 'Y').format('YYYY')),
            format: $(_this).attr('data-format'),
            locale: {
                format: $(_this).attr('data-format'),
                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            }
        };
        
        $(_this).daterangepicker(options, function(start, end, label) {
            $(_this).find('span').text(start.format('DD/MM/YYYY'));
            $(_this).find('input[type="hidden"]').val(start.format('YYYY-MM-DD'));
        });
    });
    
    $('.btn-report').click(function(){
        if( $(this).hasClass('disabled') ){
            return false;
        }
        var type = $(this).attr('data-type');
        var date_start = $(this).parent().parent().find('.input-hidden-start').val();
        var date_end = $(this).parent().parent().find('.input-hidden-end').val();
        ajaxStatistic(type, date_start, date_end, $(this));
    });

    $(document).on('click','.btn-copy',function(){
        var text = $(this).attr('data-link');

        copyToClipboard(text, 'Đã sao chép thành công vào bảng nhớ tạm.');
    });

  });
</script>
<style>
.daterangepicker{
    width:auto;
}
.input-date-statistic{
    border: 1px solid #E5E5E5;
    padding: 4px 4px;
}
.btn-report{
    padding: 4px 9px;
}
.chart-legend {
    max-height: 100px;
    width: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    margin-bottom:15px;
}
.chart-legend ul {
    display: flex;
    flex-wrap: wrap;
    padding-left:0;
}
.chart-legend ul li {
    display: flex;
    width: auto;
    margin-right: 15px;
    align-items: center;
    height: 25px;
    cursor: pointer;
}
.chart-legend ul li span{
    display: inline-block;
    width: 40px;
    height: 15px;
    margin-right:3px;
}
.chart-legend ul li.hidden {
    text-decoration: line-through;
}
@media only screen and (max-width: 600px) {
    .panel-hdr{
        flex-direction: column;
        align-items: flex-start;
    }
    .box-date {
        padding: 0 10px;
        margin-bottom: 15px;
    }
    .box-date > span{
        font-size:13px;
    }
    .btn-report {
        padding: 4px 4px;
    }
    .panel-toolbar{
        position: absolute;
        top: 15px;
        right: 0;
    }
    .select2-container{
        width: 100% !important;
        margin: 10px 0;
    }
    .panel-content{
        /* height: auto !important; */
    }
}
</style>

<div class="modal fade" id="modal-order" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 80%; max-width: none;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #886ab5; color: #fff;">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center"><i class="fal fa-spin fa-spinner"></i></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>