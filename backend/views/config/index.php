<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Course;
use backend\models\News;
use yii\helpers\ArrayHelper;

$this->title = 'Cấu hình trang chủ';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Cấu hình hiển thị dữ liệu tại trang chủ';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-tag';

$listCourseHotBig = Course::getHotConfig();
$listCourseHot = Course::getHotConfig(2, true);
$listNewsHot = News::getNewsHot(true);

?>
<div class="projects-index">
    <form id="form-config" action="" method="POST">
        <div class="panel">
            <div class="panel-hdr">
                <h2>
                    <span>Khoá học nổi bật</span>
                    <p>Chọn 1 khoá học</p>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                    <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
                </div>
            </div>
            <div class="panel-container collapse show donotmiss-post">
                <div class="panel-content">
                    <?php
                        $html_option_selected   = '';
                        
                        if( !empty($listCourseHotBig) ){
                            foreach($listCourseHotBig as $id=>$name){
                                $html_option_selected .= '<option selected="selected" value="' . $id . '">' . $name . '</option>';
                            }
                        }

                    ?>
                    <select class="form-control ajax select2 muti" maxItem="1" maxItemName="khoá học" multiple name="course_hot_big[]" data-url="/config/search-course" data-placeholder="Nhập tên khoá học">
                        <?= $html_option_selected ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-hdr">
                <h2>
                    <span>Khoá học nổi bật</span>
                    <p>Chọn nhiều khoá học</p>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                    <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
                </div>
            </div>
            <div class="panel-container collapse show donotmiss-post">
                <div class="panel-content">
                    <?php
                        $html_option_selected   = '';
                        $html_course_pos = '';
                        if( !empty($listCourseHot) ){
                            foreach($listCourseHot as $row){
                                $html_option_selected .= '<option selected="selected" value="' . $row->id . '">' . $row->name . '</option>';
                                $html_course_pos .= '
                                    <div class="item-pos row" id="course_pos_' . $row->id . '" data-id="' . $row->id . '">
                                        <div class="col-md-6">
                                            <label for="">Khoá học</label>
                                            <input class="form-control" readonly="true" value="' . $row->name . '" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Thứ tự hiển thị</label>
                                            <input class="form-control" name="course_hot_pos[' . $row->id . ']" value="' . ($row->hot_pos === 999 ? '' : $row->hot_pos) . '" placeholder="Nhập số" />
                                        </div>
                                    </div>
                                ';
                            }
                        }

                    ?>
                    <select class="form-control select-pos muti ajax select2 disabled-close" data-type="course" name="course_hot[]" data-url="/config/search-course" multiple data-placeholder="Nhập tên khoá học">
                        <?= $html_option_selected ?>
                    </select>

                    <div class="list-content-pos <?= empty($html_course_pos) ? 'hide' : '' ?>">
                        <h3>Thứ tự hiển thị <i class="fal fa-info-circle" data-toggle="tooltip" title="Khoá học nổi bật sẽ được hiển thị theo thứ tự tăng dần"></i></h3>
                        <div class="content-pos">
                            <?= $html_course_pos ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-hdr">
                <h2>
                    <span>Sự kiện nổi bật</span>
                    <p>Chọn nhiều bài viết</p>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                    <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-trigger="hover" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
                </div>
            </div>
            <div class="panel-container collapse show donotmiss-post">
                <div class="panel-content">
                    <?php
                        $html_option_selected   = '';
                        $html_news_pos = '';
                        if( !empty($listNewsHot) ){
                            foreach($listNewsHot as $row){
                                $html_option_selected .= '<option selected="selected" value="' . $row->id . '">' . $row->title . '</option>';
                                $html_news_pos .= '
                                    <div class="item-pos row" id="news_pos_' . $row->id . '" data-id="' . $row->id . '">
                                        <div class="col-md-6">
                                            <label for="">Bài viết</label>
                                            <input class="form-control" readonly="true" value="' . $row->title . '" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Thứ tự hiển thị</label>
                                            <input class="form-control" name="news_hot_pos[' . $row->id . ']" value="' . ($row->hot_pos === 999 ? '' : $row->hot_pos) . '" placeholder="Nhập số" />
                                        </div>
                                    </div>
                                ';
                            }
                        }

                    ?>
                    <select class="form-control select-pos muti ajax select2" data-type="news" multiple name="post_hot[]" data-url="/config/search-news" data-placeholder="Nhập tên bài viết">
                        <?= $html_option_selected ?>
                    </select>
                    <div class="list-content-pos <?= empty($html_news_pos) ? 'hide' : '' ?>">
                        <h3>Thứ tự hiển thị <i class="fal fa-info-circle" data-toggle="tooltip" title="Sự kiện nổi bật sẽ được hiển thị theo thứ tự tăng dần"></i></h3>
                        <div class="content-pos">
                            <?= $html_news_pos ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center box-save-button" style="margin-top:10px">
            <button type="button" class="btn btn-primary btn-save"><i class="fal fa-save"></i> Lưu cấu hình</button>
        </div>
    </form>
</div>
<script src="/js/jquery-1.12.4.js"></script>
<script type="text/javascript">
    function toggleItemPos(_this){
        var listIdNew   = _this.select2('data');
        var _parent     = _this.parent();
        var type        = _this.attr('data-type');
        if( listIdNew.length <= 0 ){
            _parent.find('.list-content-pos').addClass('hide');
            _parent.find('.list-content-pos .content-pos').html('');
        }else{
            _parent.find('.list-content-pos').removeClass('hide');
            var listItem = _parent.find('.item-pos');
            var listIdOld= [];
            if( listItem.length > 0 ){
                var listIdNewCheck = listIdNew.map((x)=> x.id);
                for( var i = 0; i < listItem.length; i++ ){
                    var id = $(listItem[i]).attr('data-id');
                    console.log('id:',id);
                    if( listIdNewCheck.indexOf(id) === -1 ){
                        _parent.find('#' + type + '_pos_' + id).remove();
                    }else
                        listIdOld.push(id);
                }
            }
            var html_pos_append = '';
            var label           = type == 'course' ? 'Khoá học' : 'Bài viết';
            for( var j = 0; j < listIdNew.length; j++ ){
                if( listIdOld.indexOf(listIdNew[j].id) === -1 ){//Add
                    var title = _parent.find('.select2 option[value="' + listIdNew[j].id + '"]').text();
                    html_pos_append += '<div class="item-pos row" id="' + type + '_pos_' + listIdNew[j].id + '" data-id="' + listIdNew[j].id + '">';
                    html_pos_append += '    <div class="col-md-6">';
                    html_pos_append += '        <label for="">' + label + '</label>';
                    html_pos_append += '        <input class="form-control" readonly="true" value="' + title + '" />';
                    html_pos_append += '        </div>';
                    html_pos_append += '    <div class="col-md-4">';
                    html_pos_append += '        <label for="">Thứ tự hiển thị</label>';
                    html_pos_append += '           <input class="form-control" name="' + type + '_hot_pos[' + listIdNew[j].id + ']" value="" placeholder="Nhập số" />';
                    html_pos_append += '    </div>';
                    html_pos_append += '</div>';
                }
            }
            if( html_pos_append != '' ){
                _parent.find('.list-content-pos .content-pos').append(html_pos_append);
            }
        }
    }
    jQuery(document).ready(function(){
        var flagEnableSave = true;
        $('.btn-save').click(function(){
            toastr.remove();
            var formData = $('#form-config').serializeArray();
            var _this = $(this);
            if( _this.find('.fa-spin').length > 0 || !flagEnableSave )
                return;
            flagEnableSave = false;
            _this.find('.fal').attr('class','fal fa-spin fa-spinner');
            $.ajax({
                type: 'POST',
                url: window.location.href,
                data: formData,
                success: function(res){
                    setTimeout(function(){
                        flagEnableSave = true;
                    }, 1200)
                    _this.find('.fal').attr('class','fal fa-save');
                    if( res.errorCode == 0 ){
                        toastr["success"](res.message);
                    }else
                        toastr["error"](res.message);
                },
                error: function(){
                    flagEnableSave = true;

                    toastr["error"]('Có lỗi! Vui lòng liên hệ Admin');
                }
            })
        });
        var tm;
        $(document).on('change', '.select-pos', function(){
            var _this = $(this);
            clearTimeout(tm);
            tm = setTimeout(function(){
                toggleItemPos(_this);
            }, 200)
        });
    });
</script>
<style>
    .panel-hdr h2{
        flex-direction: column;
        align-items: flex-start;
    }
    .panel-hdr h2 span{
        line-height: 20px;
        margin: 10px 0 5px;
    }
    .panel-hdr h2 p{
        margin: 0 0 10px;
        line-height: 20px;
        font-size: 12px;
        font-weight: 400;
        font-style: italic;
        color: #333;
    }
    .list-content-pos {
        margin: 15px 0 0;
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 4px;
    }
    .item-pos{
        align-items: center;
    }
    .item-pos label{
        display: block;
    }
    .item-pos {
        align-items: center;
        margin: 0 0 15px;
        border: 1px dashed #ccc;
        padding: 5px 0;
    }
</style>