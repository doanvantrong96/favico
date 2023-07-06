<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;

$this->title = 'Dashboard';
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
                <div class="row" style="justify-content: space-between;">

                    <div class="col-sm-6 col-xl-3">
                        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                            <div style="position:relative;z-index:1">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <a href="/history-transaction/index?OrderCartSearch[status]=1" class="link-detail total_revenue" style="color:#fff"><?= $dataStatistic['total_revenue'] ?></a>
                                    <small style="font-size: 14px;" class="m-0 l-h-n">Doanh thu <span class="fal fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tổng doanh thu bán khoá học thành công theo thời gian đã chọn"></span></small>
                                </h3>
                            </div>
                            <i class="fal fa-money-bill position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <a href="/course/index?CourseSearch[is_sell]=1" class="link-detail total_course" style="color:#fff"><?= $dataStatistic['total_course_sell'] ?></a>
                                    <small style="font-size: 14px;" class="m-0 l-h-n">Khoá học đang bán <span class="fal fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tổng số khoá học đang bán"></span></small>
                                </h3>
                            </div>
                            <i class="fal fa-list-alt position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <a href="/customer/index" class="link-detail total_user_register" style="color:#fff"><?= $dataStatistic['total_user_register'] ?></a>
                                    <small style="font-size: 14px;" class="m-0 l-h-n">Khách hàng đăng ký mới <span class="fal fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tổng khách hàng đăng ký mới theo thời gian đã chọn"></span></small>
                                </h3>
                            </div>
                            <i class="fal fa-user-plus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                    <a href="/customer/index?CustomerSearch[status][]=0&CustomerSearch[status][]=2" class="link-detail total_user_lock" style="color:#fff"><?= $dataStatistic['total_user_lock'] ?></a>
                                    <small style="font-size: 14px;" class="m-0 l-h-n">Khách hàng bị khoá <span class="fal fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Tổng khách hàng bị khoá từ CMS hoặc bị khoá do đăng nhập nhiều thiết bị theo thời gian đã chọn"></span></small>
                                </h3>
                            </div>
                            <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Khoá học Trending
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container collapse show top-post top" style="">
            <div class="panel-content" style="min-height:200px;position: relative;">
                
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
            $('.total_revenue').text(dataStatistic.total_revenue);
            $('.total_course_sell').text(dataStatistic.total_course_sell);
            $('.total_user_register').text(dataStatistic.total_user_register);
            $('.total_user_lock').text(dataStatistic.total_user_lock);
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
  jQuery(document).ready(function(){
    var startDate = moment('<?= $date_start ?>');
    var endDate   = moment('<?= $date_end ?>');
    initStatistic($.parseJSON('<?= json_encode($dataStatistic) ?>'), 'all');
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

    $(document).on('click', '.box-summary .link-detail', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        if( ["", "#"].indexOf(url) === -1 ){
            
            var date_start = $('.box-summary .input-hidden-start').val();
            var date_end   = $('.box-summary .input-hidden-end').val();
            var char_add   = "?";
            if( url.indexOf(char_add) !== -1 ){
                char_add   = "&";
            }
            if( $(this).hasClass('total_revenue') )
                url += char_add + "OrderCartSearch[date_start]=" + date_start + "&OrderCartSearch[date_end]=" + date_end;
            else if( $(this).hasClass('total_user_register') )
                url += char_add + "CustomerSearch[date_start]=" + date_start + "&CustomerSearch[date_end]=" + date_end;
            else if( $(this).hasClass('total_user_lock') )
                url += char_add + "CustomerSearch[date_start_banned]=" + date_start + "&CustomerSearch[date_end_banned]=" + date_end;
            else if( $(this).hasClass('total_course') ){
                // url += char_add + "CourseSearch[date_start]=" + date_start + "&CourseSearch[date_end]=" + date_end;
            }
            else
                url += char_add + "date_start=" + date_start + "&date_end=" + date_end;
            window.open(url, "_blank");
        }
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

