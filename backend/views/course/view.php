<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Category;
use backend\models\Lecturer;
use backend\models\CourseLesson;
use backend\controllers\CommonController;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = 'Khoá học ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Khoá học', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Xem chi tiết';
$this->params['breadcrumbs']['icon_page'] = 'fa-window';

$isRoleLecturer = Yii::$app->user->identity->account_type == \backend\models\Employee::TYPE_LECTURER;

$listLesson   = CourseLesson::getListLesson($model->id);
$action_change_position_lesson = '/course/save-position-of-lesson';
$permission_change_position_lesson   = CommonController::checkAccess($action_change_position_lesson);
$controller     = Yii::$app->controller->id;
?>
<div class="course-view">
    <?php if( !$isRoleLecturer ): ?>
    <p>
        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fal fa-edit"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fal fa-trash"></i> Xoá', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'onclick'=> "return confirm('Bạn có chắc chắn muốn xoá khoá học này?')"
        ]) ?>
    </p>
    <?php endif; ?>
    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Thông tin khoá học
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container">
            <div class="panel-content content-course">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'label' => 'Ảnh',
                            'format' =>  'raw',
                            'value' => function ($model) {
                                $r = ($model->avatar != "" ? '<img height="100em" src="'.$model->avatar.'" alt="" />' : '');
                                return $r;
                            }
                        ],
                        'name',
                        [
                            'label' => 'Phôi ảnh chứng chỉ',
                            'format' =>  'raw',
                            'value' => function ($model) {
                                $r = ($model->certificate != "" ? '<img height="100px" src="'.$model->certificate.'" alt="" />' : '');
                                return $r;
                            }
                        ],
                        [
                            'label'=>'Danh mục',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if( !empty($model->category_id) ){
                                    $arrCateId = array_filter(explode(';',$model->category_id));
                                    $resultCate= Category::find()->where(['status' => 1, 'is_delete' => 0 ])->andWhere(['in', 'id', $arrCateId])->all();
                                    if( !empty($resultCate) ){
                                        return implode(', ', \yii\helpers\ArrayHelper::map($resultCate, 'name', 'name'));
                                    }
                                }
                                return 'N/A';
                            },
                        ],
                        [
                            'label'=>'Giảng viên',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if( $model->lecturer_id ){
                                    $modelLecturer = Lecturer::findOne(['id' => $model->lecturer_id, 'is_delete' => 0]);
                                    if( $modelLecturer )
                                        return $modelLecturer->name;
                                }

                                return 'N/A';
                            },
                            'visible' => !$isRoleLecturer
                        ],
                        // [
                        //     'label'=>'Tài liệu',
                        //     'format' => 'raw',
                        //     'value' => function ($model) {
                        //         $documents       = $model->document ? json_decode($model->document, true) : [];
                        //         $html = '';
                        //         if( !empty($documents) ){
                        //             foreach($documents as $doc_id => $doc){
                        //                 $link    = !empty($doc['link']) ? $doc['link'] : $doc['file_link'];
                        //                 $html .= '<p style="margin-bottom:0">- <a href="' . $link . '" target="_blank">' . $doc['name'] . '</a></p>';
                        //             }
                        //             return $html;
                        //         }
                        //         return 'Chưa cập nhật';
                        //     },
                        // ],
                        [
                            'label'=>'Hướng dẫn học',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $guides       = $model->study_guide ? json_decode($model->study_guide, true) : [];
                                $html = '';
                                if( !empty($guides) ){
                                    foreach($guides as $guide){
                                        $link    = !empty($guide['link']) ? $guide['link'] : $guide['file_link'];
                                        $html .= '<p style="margin-bottom:0">- <a href="' . $link . '" target="_blank">' . $guide['name'] . '</a></p>';
                                    }
                                    return $html;
                                }
                                return 'Chưa cập nhật';
                            },
                        ],
                        'create_date',
                        [
                            'attribute' => 'description',
                            'format'=> 'raw',
                            'contentOptions'=>['style'=>'width:82%']
                        ],
                        'total_lessons',
                        [
                            'attribute' => 'price',
                            'format'=> 'raw',
                            'value' => function($model){
                                $html = '';
                                if( $model['price'] <= 0 ){
                                    $html = 'Miễn phí';
                                }else{
                                    if( $model->price > 0 ){
                                        if( $model->promotional_price > 0 )
                                            $html = '<span data-toggle="tooltip" data-placement="bottom" title="Giá khuyến mại">' . number_format($model->promotional_price,0,',',',') . '</span> (<span data-toggle="tooltip" data-placement="bottom" style="text-decoration: line-through;" title="Giá gốc">' . number_format($model->price,0,',',',') . '</span>)';
                                        else
                                            $html = number_format($model->price,0,',',',');
                                    }
                                }
                                
                                return $html;
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format'=> 'raw',
                            'value' => function($model){
                                return \backend\controllers\CommonController::getStatusName($model->status);
                            }
                        ],
                        [
                            'label'=>'Video trailer',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if( !empty($model->trailer) ){
                                
                                    return '<div class="videojs-hls-player-wrapper" id="video_player_course">
                                        <video id="video_course" width="400" height="240" class="video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered ui-min ui-smooth v_5e8494e7ccb30-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-user-inactive">
                                            <source src="' . $model->trailer . '" type="video/mp4" />
                                            Your browser does not support the video tag.
                                        </video></div>';
                                }
                                return 'Chưa có video';
                            },
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Danh sách bài học <?= $model->total_lessons > 0 ? '(<span class="total_lesson" style="margin-right:3px">' . $model->total_lessons . '</span> bài)' : '' ?>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container">
            <div class="panel-content content-lesson">
                <?php 
                    if( !empty($listLesson) ){
                        foreach($listLesson as $lesson){
                ?>
                    <div class="form-group field-lesson-question" data-id="<?= $lesson->id ?>">
                        <div class="row align-items-center">
                            <div class="col-lg-10" style="margin:0">
                            <a class="btn_view_detail" data-title="Chi tiết bài học" data-type="lesson" href="javascript:;" data-id="<?= $lesson->id ?>"><b id="lesson_name_<?= $lesson->id ?>"><?= $lesson->name ?></b></a>
                            </div>
                            <div class="col-lg-2" style="margin:0">
                                <a href="javascript:;" data-id="<?= $lesson->id ?>" data-type="lesson" data-title="Cập nhật bài học" class="btn btn-primary btn-edit">Sửa</a>
                                <a href="javascript:;" data-id="<?= $lesson->id ?>" data-type="lesson" dataConfirm="Bạn có chắc chắn muốn xoá bài học này?" class="btn btn-warning btn-delete">Xoá</a>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }else{
                        echo '<p class="text-center">Chưa có bài học nào</p>';
                    }
                ?>
            </div>
        </div>
    </div>

</div>
<style>
    .field-lesson-question,.field-document,.field-guide{
        border: 1px dashed #ccc;
        padding: 15px;
        position: relative;
    }
    .field-lesson-question > .row,.field-document > .row,.field-guide > .row{
        position: relative;
    }
    .field-lesson-question .panel-toolbar,.field-document .panel-toolbar,.field-guide .panel-toolbar{
        position: absolute;
        right: 15px;
        top: 0;
    }
    #video_player_course {
        max-width: 400px;
    }
    @media (max-width: 768px) {
        #modal-form .modal-dialog{
            max-width: 95% !important;
        }
    }
</style>
<?php if( $permission_change_position_lesson ): ?>
<link href='/css/draganddrop.css' rel='stylesheet' type='text/css'>
<script src='/js/jquery-1.12.4.js' type='text/javascript'></script>
<script src='/js/draganddrop.js' type='text/javascript'></script>
<script type="text/javascript">
var savePositionLesson = function(){
    var listLesson  = $('.content-lesson .field-lesson-question');
    if( listLesson.length > 1 ){
        var dataPosition = {};
        for( var i = 0; i < listLesson.length; i++ ){
            var item = $(listLesson[i]);
            dataPosition[item.attr('data-id')] = i;
        }
        toastr.remove();
        $.ajax({
            type : 'POST',
            url : '<?= $action_change_position_lesson ?>',
            data : {data: dataPosition},
            success:function(res){
                toastr['success']('Cập nhật thứ tự bài học thành công');
            },
            error:function(){
                
            }
        });
    }
}
var id_question_lesson_new = 99999;
jQuery(document).ready(function(){
    if( $('.content-lesson .field-lesson-question').length > 1 ){
        $('.content-lesson').sortable({container: '.content-lesson', nodes: ':not(.alert)',update: function(evt) {
            savePositionLesson();
        }});
    }
    var item_id = -1;
    var type_modal = '';
    var url_action = '';
    $(document).on('click', '.btn-edit', function(){
        item_id         = parseInt($(this).attr('data-id'));
        type_modal      = $(this).attr('data-type');
        if( type_modal == 'lesson' )
            $('#modal-form .modal-dialog').attr('style','width: 80%; max-width: none;');
        else
            $('#modal-form .modal-dialog').attr('style','width: 800px; max-width: none;');
        url_action      = '/<?= $controller ?>/save-data-of-course?course_id=<?= $model->id ?>&type=' + type_modal + '&item_id=' + item_id;
        $('#modal-form .modal-title').html($(this).attr('data-title'));
        $('#modal-form').modal('show').find('.modal-body').load(url_action, function(){
            $("#btn-submit-modal").show();
            $('#modal-form [data-toggle=tooltip]').tooltip();
            if( type_modal == 'lesson' && $('#modal-form #video').hasClass('hasFile') ){
                _0xd85bx13();
            }
        });
    });
    $('#modal-form').on('hidden.bs.modal', function () {
        if( type_modal == 'lesson' && $('#modal-form #video').hasClass('hasFile') ){
            _0xd85bx11();
        }
        $("#btn-submit-modal").hide();
        $('#modal-form').find('.modal-body').html('');
    });
    $('#btn-submit-modal').click(function(){
        var _this       = $(this);
        var form        = $("#form-action");
        if(_this.find('.fal').hasClass('hide')){
            _this.find('.fal').removeClass('hide');
            toastr.remove();
            $.ajax({
                type : 'POST',
                url : url_action,
                data : form.serializeArray(),
                success:function(res){
                    _this.find('.fal').addClass('hide');
                    if( res.status ){
                        $('#modal-form').modal('hide');
                        toastr['success'](res.msg);
                        if( type_modal == 'lesson' ){
                            if( !res.data.isNew ){
                                $('#lesson_name_' + res.data.item_id).text(res.data.name);
                            }else{
                                var template = $('.box-lesson-template').clone();
                                template.find('.title_lesson').attr('id','lesson_name_' + res.data.item_id).text(res.data.name);
                                template.find('.btn').attr('data-id',res.data.item_id);
                                $('.content-lesson').append(template.html());
                            }
                        }else if( type_modal == 'document' ){
                            if( !res.data.isNew ){
                                $('#document_name_' + res.data.item_id).text(res.data.name);
                            }else{
                                var template = $('.box-document-template').clone();
                                template.find('.title_doc').attr('id','document_name_' + res.data.item_id).text(res.data.name);
                                template.find('.btn').attr('data-id',res.data.item_id);
                                $('.content-document').append(template.html());
                            }
                        }else if( type_modal == 'guide' ){
                            if( !res.data.isNew ){
                                $('#guide_name_' + res.data.item_id).text(res.data.name);
                            }else{
                                var template = $('.box-guide-template').clone();
                                template.find('.title_doc').attr('id','guide_name_' + res.data.item_id).text(res.data.name);
                                template.find('.btn').attr('data-id',res.data.item_id);
                                $('.content-guide').append(template.html());
                            }
                        }
                        else if( type_modal == 'question' ){
                            if( !res.data.isNew ){
                                $('#question_name_' + res.data.item_id).text(res.data.name);
                            }else{
                                var template = $('.box-question-template').clone();
                                template.find('.title_ques').attr('id','question_name_' + res.data.item_id).text(res.data.name);
                                template.find('.btn').attr('data-id',res.data.item_id);
                                $('.content-question').prepend(template.html());
                            }
                        }

                    }else{
                        $('.list-error').remove();
                        var html_error = '<ul class="list-error" style="color:red;padding:0"><li style="list-style: none;"><b>Vui lòng sửa các lỗi sau đây:</b></li>';
                        res.error.map(function(name, index){
                            html_error += '<li style="padding-left:10px;list-style: inside;">' + name + '</li>';
                        });
                        html_error += '</ul>';
                        $('#modal-form .modal-body').prepend(html_error);
                        $("#modal-form").animate({ scrollTop: 0 }, 600);
                    }
                },
                error:function(){
                    _this.find('.fal').addClass('hide');
                    toastr['error']('Có lỗi! Không thể thực hiện thao tác này');
                }
            })
        }
    });
    $(document).on('click','.add_new_question_lesson', function(){
        id_question_lesson_new++;
        var template = $('.box-question-lesson-template').clone();
        template.find('.lb-question').attr('for','question-' + id_question_lesson_new);
        template.find('.input-question').attr('id','question-' + id_question_lesson_new).attr('name','CourseLessonQuestion[' + id_question_lesson_new + ']');
        
        template.find('.answer_correct').attr('name','CourseLessonAnswerCorrect[' + id_question_lesson_new + ']');
        template.find('.question_new').attr('name','CourseLessonQuestionNew[' + id_question_lesson_new + ']');
        template.find('.radio_correct_lesson').attr('name', 'CheckBoxAnswerCorrect[' + id_question_lesson_new + ']');
        
        for( var i = 1; i <= 4; i++ ){
            template.find('.lb-answer-' + i).attr('for','answer-' + i + '-' + id_question_lesson_new);
            template.find('.input-answer-' + i).attr('id','answer-' + i + '-' + id_question_lesson_new).attr('name','CourseLessonAnswer[' + id_question_lesson_new + '][' + i + ']');
        }        

        $('.content-question-lesson .warning-question').after(template.html());
        $('.warning-question').removeClass('hide');
        $('.empty-question').remove();
    });
    $(document).on('click','.remove-question-lesson',function(){
        var id = parseInt($(this).attr('dtid'));
        var _parent = $(this).parent().parent().parent();
        if( id <= 0 ){
            _parent.remove();
        }else if(confirm('Bạn có chắc chắn muốn xoá câu hỏi này?')){
            _parent.remove();
            var question_remove = $('.input_question_remove').val();
            if( question_remove == "" )
                question_remove = id;
            else
                question_remove += "," + id;

            $('.input_question_remove').val(question_remove);
        }
        if( $('.content-question-lesson .field-lesson-question').length <= 0 ){
            $('.content-question-lesson').append('<p class="empty-question">Chưa có câu hỏi nào</p>');
            $('.warning-question').addClass('hide');
        }
    });
    $(document).on('click','.radio_correct_lesson',function(){
        $(this).parent().parent().parent().parent().find('.answer_correct').val($(this).val());
    });
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        if( !$(this).hasClass('waiting') && confirm($(this).attr('dataConfirm')) ){
            toastr.remove();
            var _this       = $(this);
            _this.addClass('waiting');
            item_id         = parseInt(_this.attr('data-id'));
            type_modal      = _this.attr('data-type');
            url_action      = '/course/remove-data-of-course?course_id=<?= $model->id ?>&type=' + type_modal + '&item_id=' + item_id;
            $.ajax({
                type : 'GET',
                url : url_action,
                data : {},
                success:function(res){
                    if( res.status ){
                        toastr['success'](res.msg);
                        // if( type_modal == 'document' || type_modal == 'guide' ){
                            _this.parent().parent().parent().remove();
                        // }
                        if( type_modal == 'lesson' ){
                            $('.total_lesson').text($('.content-lesson .field-lesson-question').length);
                        }
                    }else{
                        _this.removeClass('waiting');
                        toastr['error'](res.msg);
                    }
                },
                error:function(){
                    _this.removeClass('waiting');
                    toastr['error']('Có lỗi! Không thể thực hiện thao tác này');
                }
            });
        }
    });
});
</script>
<?php endif; ?>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 800px; max-width: none;">
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
                <button type="button" style="display:none" id="btn-submit-modal" class="btn btn-primary"><i class="fal fa-spin fa-spinner loading-submit-form hide"></i> Lưu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="hide box-question-lesson-template">
    <div class="form-group field-lesson-question">
        <div class="row">
            <div class="col-lg-10">
                <label style="margin-top: 10px;" class="control-label lb-question" for="">Câu hỏi</label>
                <input type="text" id="" class="form-control input-question" name="CourseLessonQuestion[]">
            </div>
            <div class="col-lg-2">
                <a href="javascript:;" style="margin-top: 33px;" dtid="0" class="btn btn-primary remove-question-lesson"><i class="fal fa-trash"></i> Xoá</a>
            </div>
        </div>
        <input type="hidden" class="answer_correct" name="CourseLessonAnswerCorrect[]" value="" />
        <input type="hidden" class="question_new" name="CourseLessonQuestionNew[]" value="1" />
        <div class="row">
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-1" for="">Đáp án 1</label>
                <input type="text" id="" class="form-control input-answer-1" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct_lesson" name="CheckBoxAnswerCorrect" value="1" /> Đáp án đúng
                </label>
            </div>
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-2" for="">Đáp án 2</label>
                <input type="text" id="" class="form-control input-answer-2" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct_lesson" name="CheckBoxAnswerCorrect"  value="2" /> Đáp án đúng
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-3" for="">Đáp án 3</label>
                <input type="text" id="" class="form-control input-answer-3" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct_lesson" name="CheckBoxAnswerCorrect"  value="3" /> Đáp án đúng
                </label>
            </div>
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-4" for="">Đáp án 4</label>
                <input type="text" id="" class="form-control input-answer-4" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct_lesson" name="CheckBoxAnswerCorrect" value="4" /> Đáp án đúng
                </label>
            </div>
        </div>    
    </div>
</div>