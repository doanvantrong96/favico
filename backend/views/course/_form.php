<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;
use backend\models\Lecturer;
use backend\models\CourseLessonQuestion;
use backend\models\CourseLesson;

$controller     = Yii::$app->controller->id;

$listCategory   = ArrayHelper::map(Category::find()->where(['status' => 1,'is_delete' => 0])->all(),'id','name');
$listCoach      = ArrayHelper::map(Lecturer::find()->where(['is_delete' => 0])->all(),'id','name');
if( !empty($model->category_id) && !is_array($model->category_id) ){
    $model->category_id = array_filter(explode(';', $model->category_id));
}
$listQuestion = $model->isNewRecord ? [] : CourseLessonQuestion::getQuestionAnswer($model->id, 2);
$listLesson   = $model->isNewRecord ? [] : CourseLesson::getListLesson($model->id);
$this->registerJS('
    $("#checkbox_is_coming").click(function(){
        if( $(this).is(":checked") ){
            $(".row-time_coming").removeClass("hide");
            $("#customSwitch2").prop("checked", false);
        }else{
            $(".row-time_coming").addClass("hide");
        }
    });
    $("#customSwitch2").click(function(){
        if( $(this).is(":checked") ){
            $("#checkbox_is_coming").prop("checked", false);
            $(".row-time_coming").addClass("hide");
        }
    });
');
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(['id'=>'form_course','enableAjaxValidation' => true,'options' => ['enctype' => 'multipart/form-data']]); ?>
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
        <div class="panel-container show">
            <div class="panel-content">
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-0">
                            <label class="form-label">Ảnh</label>
                            <div class="custom-file">
                                <input type="file" name="avatar" accept="image/*" class="custom-file-input" id="customFileAvatar">
                                <label class="custom-file-label" for="customFileAvatar"><?= $model->avatar != '' ? $model->avatar : 'Chọn ảnh' ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo $form->field($model, 'lecturer_id')->dropDownList($listCoach, ['prompt'=>'Chọn giảng viên','class' => 'form-control select2']) ?>
                    </div>

                    <div class="col-lg-6">
                        <?php echo $form->field($model, 'category_id')->dropDownList($listCategory, ['multiple' => true,'class' => 'form-control select2','placeholder'=>'Chọn danh mục']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <?php echo $form->field($model, 'total_todo_question')->textInput(['maxlength' => 2, 'placholder' => 'Nhập số'])->label('Tổng câu hỏi cần làm bài tập lớn <i title="Tổng câu hỏi bài tập lớn user cần làm sau khi học xong các bài học" data-toggle="tooltip" class="fal fa-info-circle"></i>') ?>
                    </div>
                    <div class="col-lg-4">
                        <?php echo $form->field($model, 'questions_per_lesson')->textInput(['maxlength' => 3, 'placholder' => 'Nhập số'])->label('Số câu hỏi lấy ở mỗi bài tập <i title="Số câu hỏi lấy ở mỗi bài học để tạo thành bài tập lớn của khoá học" data-toggle="tooltip" class="fal fa-info-circle"></i>') ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <?= $form->field($model, 'description')->textarea(['class'=>'form-control','rows' => 6]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'price')->textInput(['class'=>'form-control input-price'])->label('Giá <i style="font-size:12px">(Không điền hoặc để = 0 là Miễn phí)</i> <i style="position: absolute; right: 15px; font-size: 12px; top: 3px;">Đơn vị nghìn</i>',['class'=>'control-label']) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'promotional_price')->textInput(['class'=>'form-control input-price'])->label('Giá khuyến mại <i style="position: absolute; right: 15px; font-size: 12px; top: 3px;">Đơn vị nghìn</i>',['class'=>'control-label']) ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label class="form-label">Phôi ảnh chứng chỉ</label>
                            <div class="custom-file">
                                <input type="file" name="certificate" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/certificate" data-id="<?= $model->id ?>" id="customFileCertificate">
                                <label class="custom-file-label" for="customFileCertificate"><?= $model->certificate != '' ? $model->certificate : 'Chọn ảnh' ?></label>
                            </div>
                            <?= $form->field($model, 'certificate')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label class="form-label">Video trailer</label>
                            <div class="custom-file">
                                <input type="file" name="video" accept=".mp4" class="custom-file-input file-upload-ajax" data-folder="trailer/course" data-id="<?= $model->id ?>" id="customFileVideo">
                                <label class="custom-file-label" for="customFileVideo"><?= $model->trailer != '' ? $model->trailer : 'Chọn video' ?></label>
                            </div>
                            <?= $form->field($model, 'trailer')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-lg-2">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="Course[is_coming]" class="custom-control-input" id="checkbox_is_coming" <?= ($model->is_coming == 1) ? 'checked="true"' : '' ?> value="1">
                            <label class="custom-control-label" for="checkbox_is_coming">Sắp diễn ra</label>
                        </div>
                    </div>
                    <div class="row-time_coming col-lg-3 <?= $model->is_coming ? '' : 'hide' ?>" style="margin: -10px 0 0;">
                        <?php 
                            if( $model->time_coming && strpos($model->time_coming, '-') !== false ){
                                $model->time_coming = date('d/m/Y', strtotime($model->time_coming));
                            }
                            echo $form->field($model, 'time_coming')->textInput(['maxlength' => true, 'data-format' => 'DD/MM/YYYY', 'class' => 'form-control input-date', 'placeholder' => 'Thời gian diễn ra'])->label(false);
                        ?>
                    </div>
                    <div class="col-lg-2">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="Course[status]" class="custom-control-input" id="customSwitch2" <?= ($model->isNewRecord || $model->status == 1) ? 'checked="true"' : '' ?> value="1">
                            <label class="custom-control-label" for="customSwitch2">Hoạt động</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        if( !$model->isNewRecord ){
    ?>

    <div class="panel">
            <div class="panel-hdr">
                <h2>
                    Thông tin bài học <a style="margin-left:15px" data-title="Thêm bài học" data-type="lesson" class="btn_add_new" href="javascript:;"><i class="fal fa-plus"></i> Thêm</a>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                    <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content content-lesson">
                    <?php 
                        if( !empty($listLesson) ){
                            foreach($listLesson as $lesson){
                    ?>
                        <div class="form-group field-lesson" data-id="<?= $lesson->id ?>">
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
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php /*
    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Thông tin tài liệu <a style="margin-left:15px" data-title="Thêm tài liệu" data-type="document" class="btn_add_new" href="javascript:;"><i class="fal fa-plus"></i> Thêm</a>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content content-document">
                <?php
                    $documents       = $model->document ? json_decode($model->document, true) : [];
                    if( !empty($documents) ){
                        foreach($documents as $doc_id => $doc){
                ?>
                <div class="form-group field-document">
                    <div class="row align-items-center">
                        <div class="col-lg-10" style="margin:0">
                            <b id="document_name_<?= $doc_id ?>"><?= $doc['name'] ?></b>
                        </div>
                        <div class="col-lg-2" style="margin:0">
                            <a href="javascript:;" data-id="<?= $doc_id ?>" data-type="document" data-title="Cập nhật tài liệu" class="btn btn-primary btn-edit">Sửa</a>
                            <a href="javascript:;" data-id="<?= $doc_id ?>" data-type="document" dataConfirm="Bạn có chắc chắn muốn xoá tài liệu này?" class="btn btn-warning btn-delete">Xoá</a>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    */ ?>
    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Thông tin hướng dẫn học <a style="margin-left:15px" data-title="Thêm hướng dẫn học" data-type="guide" class="btn_add_new" href="javascript:;"><i class="fal fa-plus"></i> Thêm</a>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content content-guide">
                <?php
                    $guides       = $model->study_guide ? json_decode($model->study_guide, true) : [];
                    if( !empty($guides) ){
                        foreach($guides as $guide_id => $guide){
                ?>
                <div class="form-group field-guide">
                    <div class="row align-items-center">
                        <div class="col-lg-10" style="margin:0">
                            <b id="guide_name_<?= $guide_id ?>"><?= $guide['name'] ?></b>
                        </div>
                        <div class="col-lg-2" style="margin:0">
                            <a href="javascript:;" data-id="<?= $guide_id ?>" data-type="guide" data-title="Cập nhật hướng dẫn" class="btn btn-primary btn-edit">Sửa</a>
                            <a href="javascript:;" data-id="<?= $guide_id ?>" data-type="guide" dataConfirm="Bạn có chắc chắn muốn xoá hướng dẫn này?" class="btn btn-warning btn-delete">Xoá</a>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Thông tin câu hỏi bài tập <a style="margin-left:15px" data-title="Thêm câu hỏi bài tập" data-type="question" class="btn_add_new" href="javascript:;"><i class="fal fa-plus"></i> Thêm</a>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content content-question">
                <?php 
                    if( !empty($listQuestion) ){
                        foreach($listQuestion as $question){
                            $answerCorrect = "";
                            if( !empty($question->listAnswer) ){
                                foreach($question->listAnswer as $stt=>$answer){
                                    if( $answer->is_correct ){
                                        $answerCorrect = $stt + 1;
                                    }
                                }
                            }
                ?>
                    <div class="form-group field-lesson-question">
                        <div class="row align-items-center">
                            <div class="col-lg-10" style="margin:0">
                                <b id="question_name_<?= $question->id ?>"><?= $question->question_name ?></b>
                            </div>
                            <div class="col-lg-2" style="margin:0">
                                <a href="javascript:;" data-id="<?= $question->id ?>" data-type="question" data-title="Cập nhật câu hỏi" class="btn btn-primary btn-edit">Sửa</a>
                                <a href="javascript:;" data-id="<?= $question->id ?>" data-type="question" dataConfirm="Bạn có chắc chắn muốn xoá câu hỏi này?" class="btn btn-warning btn-delete">Xoá</a>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="form-group text-center" style="margin-top:10px">
        <?= Html::submitButton('Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    #video_player{
        max-width:400px;
    }
    .field-lesson,.field-lesson-question,.field-document,.field-guide{
        border: 1px dashed #ccc;
        padding: 15px;
        position: relative;
    }
    .lb-correct{
        position: absolute;
        top: 12px;
        right: 15px;
        display: flex;
        align-items: center;
    }
    .lb-correct input{
        margin-right:3px;
    }
    .field-lesson-question > .row,.field-document > .row,.field-guide > .row{
        position: relative;
    }
    .field-lesson-question .panel-toolbar,.field-document .panel-toolbar,.field-guide .panel-toolbar{
        position: absolute;
        right: 15px;
        top: 0;
    }
    .modal-hide{
        z-index: 2000;
    }
    @media (max-width: 768px) {
        #modal-form .modal-dialog{
            max-width: 95% !important;
        }
    }
</style>
<link href='/css/draganddrop.css' rel='stylesheet' type='text/css'>
<script src='/js/draganddrop.js' type='text/javascript'></script>
<script type="text/javascript">
var id_question_new = 99999;
var id_document_new = 1000;
var id_guide_new    = 1000;
var id_question_lesson_new = 99999;
var savePositionLesson = function(){
    var listLesson  = $('.content-lesson .field-lesson');
    if( listLesson.length > 1 ){
        var dataPosition = {};
        for( var i = 0; i < listLesson.length; i++ ){
            var item = $(listLesson[i]);
            dataPosition[item.attr('data-id')] = i;
        }
        toastr.remove();
        $.ajax({
            type : 'POST',
            url : '/<?= $controller ?>/save-position-of-lesson',
            data : {data: dataPosition},
            success:function(res){
                toastr['success']('Cập nhật thứ tự bài học thành công');
            },
            error:function(){
                
            }
        });
    }
}
jQuery(document).ready(function(){
    $('.content-lesson').sortable({container: '.content-lesson', nodes: ':not(.alert)',update: function(evt) {
        savePositionLesson();
    }});

    var course_id       = <?= $model->isNewRecord ? 0 : $model->id ?>;
    var item_id         = 0;
    var type_modal      = '';
    var url_action      = '';
    var item_id_2       = 0;
    var type_modal_2    = '';
    var url_action_2    = '';
    $(document).on('click', '.btn_add_new', function(){
        item_id         = -1;
        type_modal      = $(this).attr('data-type');
        if( type_modal == 'lesson' )
            $('#modal-form .modal-dialog').attr('style','width: 80%; max-width: none;');
        else
            $('#modal-form .modal-dialog').attr('style','width: 800px; max-width: none;');
        url_action      = '/<?= $controller ?>/save-data-of-course?course_id=' + course_id + '&type=' + type_modal + '&item_id=' + item_id;
        $('#modal-form .modal-title').html($(this).attr('data-title'));
        $('#modal-form').modal('show').find('.modal-body').load(url_action, function(responseText, textStatus, XMLHttpRequest){
            if (textStatus == "error") {
                $('#modal-form .modal-body').html('<p class="text-center" style="margin-top:35px;font-weight:bold">Có lỗi! Không thể thực hiện thao tác này. Vui lòng liên hệ quản trị</p>');
                return;
            }
            $("#btn-submit-modal").show();
            $('#modal-form [data-toggle=tooltip]').tooltip();
        });
    });
    $(document).on('click', '.btn_add_new_2', function(){
        $('#modal-form').addClass('modal-hide');
        item_id_2         = -1;
        type_modal_2      = $(this).attr('data-type');
        
        url_action_2      = '/<?= $controller ?>/save-data-of-course?course_id=' + course_id + '&type=' + type_modal_2 + '&item_id=' + item_id_2;
        $('#modal-form-2 .modal-title').html($(this).attr('data-title'));
        $('#modal-form-2').modal('show').find('.modal-body').load(url_action_2, function(responseText, textStatus, XMLHttpRequest){
            if (textStatus == "error") {
                $('#modal-form-2 .modal-body').html('<p class="text-center" style="margin-top:35px;font-weight:bold">Có lỗi! Không thể thực hiện thao tác này. Vui lòng liên hệ quản trị</p>');
                return;
            }
            $("#btn-submit-modal-2").show();
            $('#modal-form-2 [data-toggle=tooltip]').tooltip();
        });
    });
    
    $('#modal-form').on('hidden.bs.modal', function () {
        if( type_modal == 'lesson' && $('#modal-form #video').hasClass('hasFile') ){
            _0xd85bx11();
        }
        $("#btn-submit-modal").hide();
        $('#modal-form').find('.modal-body').html('');
    });
    $('#modal-form-2').on('hidden.bs.modal', function () {
        $('body').addClass('modal-open');
        $('#modal-form').removeClass('modal-hide');
    });
    
    $(document).on('click', '.btn_view_detail', function(){
        item_id         = parseInt($(this).attr('data-id'));
        type_modal      = $(this).attr('data-type');
        if( type_modal == 'lesson' )
            $('#modal-form .modal-dialog').attr('style','width: 80%; max-width: none;');
        else
            $('#modal-form .modal-dialog').attr('style','width: 800px; max-width: none;');
        url_action      = '/<?= $controller ?>/view-detail?type=' + type_modal + '&item_id=' + item_id;
        $('#modal-form .modal-title').html($(this).attr('data-title'));
        $('#modal-form').modal('show').find('.modal-body').load(url_action, function(responseText, textStatus, XMLHttpRequest){
            if (textStatus == "error") {
                $('#modal-form .modal-body').html('<p class="text-center" style="margin-top:35px;font-weight:bold">Có lỗi! Không thể thực hiện thao tác này. Vui lòng liên hệ quản trị</p>');
                return;
            }
            $("#btn-submit-modal").hide();
            $('#modal-form [data-toggle=tooltip]').tooltip();
            if( type_modal == 'lesson' && $('#modal-form #video').hasClass('hasFile') ){
                _0xd85bx13();
            }
        });
    });
    $(document).on('click', '.btn-edit', function(){
        item_id         = parseInt($(this).attr('data-id'));
        type_modal      = $(this).attr('data-type');
        if( type_modal == 'lesson' )
            $('#modal-form .modal-dialog').attr('style','width: 80%; max-width: none;');
        else
            $('#modal-form .modal-dialog').attr('style','width: 800px; max-width: none;');
        url_action      = '/<?= $controller ?>/save-data-of-course?course_id=' + course_id + '&type=' + type_modal + '&item_id=' + item_id;
        $('#modal-form .modal-title').html($(this).attr('data-title'));
        $('#modal-form').modal('show').find('.modal-body').load(url_action, function(responseText, textStatus, XMLHttpRequest){
            if (textStatus == "error") {
                $('#modal-form .modal-body').html('<p class="text-center" style="margin-top:35px;font-weight:bold">Có lỗi! Không thể thực hiện thao tác này. Vui lòng liên hệ quản trị</p>');
                return;
            }
            $("#btn-submit-modal").show();
            $('#modal-form [data-toggle=tooltip]').tooltip();
            if( type_modal == 'lesson' && $('#modal-form #video').hasClass('hasFile') ){
                _0xd85bx13();
            }
        });
    });
    $(document).on('click', '.btn-edit-2', function(){
        $('#modal-form').addClass('modal-hide');
        item_id_2         = parseInt($(this).attr('data-id'));
        type_modal_2      = $(this).attr('data-type');
        var _parent       = $(this).parent().parent();
        url_action_2      = '/<?= $controller ?>/save-data-of-course?course_id=' + course_id + '&type=' + type_modal_2 + '&item_id=' + item_id_2;
        $('#modal-form-2 .modal-title').html($(this).attr('data-title'));
        $('#modal-form-2').modal('show').find('.modal-body').load(url_action_2, function(responseText, textStatus, XMLHttpRequest){
            if (textStatus == "error") {
                $('#modal-form-2 .modal-body').html('<p class="text-center" style="margin-top:35px;font-weight:bold">Có lỗi! Không thể thực hiện thao tác này. Vui lòng liên hệ quản trị</p>');
                return;
            }
            $('#modal-form-2 #document-name').val(_parent.find('.doc_name').val());
            $('#modal-form-2 #document-img').val(_parent.find('.doc_img').val());
            $('#modal-form-2 #document-type').val(_parent.find('.doc_type').val());
            $('#modal-form-2 #document-link').val(_parent.find('.doc_link').val());
            $('#modal-form-2 #document-file-link').val(_parent.find('.doc_file_link').val());            
            $('#modal-form-2 .document-img-label').text(_parent.find('.doc_img').val());
            $('#modal-form-2 .document-file-link-label').text(_parent.find('.doc_file_link').val() !== '' ? _parent.find('.doc_file_link').val() : 'Chọn file');

            if( _parent.find('.doc_type').val() == 'link' ){
                $('#modal-form-2 .field-link').removeClass('hide');
                $('#modal-form-2 .field-file-link').addClass('hide');
            }else{
                $('#modal-form-2 .field-link').addClass('hide');
                $('#modal-form-2 .field-file-link').removeClass('hide');
            }

            $("#btn-submit-modal-2").show();
            $('#modal-form-2 [data-toggle=tooltip]').tooltip();
        });
    });
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        if( !$(this).hasClass('waiting') && confirm($(this).attr('dataConfirm')) ){
            toastr.remove();
            var _this       = $(this);
            _this.addClass('waiting');
            item_id         = parseInt(_this.attr('data-id'));
            type_modal      = _this.attr('data-type');
            url_action      = '/<?= $controller ?>/remove-data-of-course?course_id=' + course_id + '&type=' + type_modal + '&item_id=' + item_id;
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
    $(document).on('click', '.btn-delete-2', function(e){
        e.preventDefault();
        if( !$(this).hasClass('waiting') && confirm($(this).attr('dataConfirm')) ){
            toastr.remove();
            var _this       = $(this);
            _this.addClass('waiting');
            _this.parent().parent().parent().remove();
            toastr['success']('Xoá thành công. Bấm nút Lưu để lưu dữ liệu');
        }
    });

    $(document).on('change', '#document-type', function(){
        if( $(this).val() == 'link' ){
            $('#form-action-2 .field-link').removeClass('hide');
            $('#form-action-2 .field-file-link').addClass('hide');
        }else{
            $('#form-action-2 .field-link').addClass('hide');
            $('#form-action-2 .field-file-link').removeClass('hide');
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
                                template.find('.btn,.btn_view_detail,.field-lesson').attr('data-id',res.data.item_id);
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

    $('#btn-submit-modal-2').click(function(){
        var _this       = $(this);
        var form        = $("#form-action-2");
        if(_this.find('.fal').hasClass('hide')){
            _this.find('.fal').removeClass('hide');
            toastr.remove();
            $.ajax({
                type : 'POST',
                url : url_action_2,
                data : form.serializeArray(),
                success:function(res){
                    _this.find('.fal').addClass('hide');
                    if( res.status ){
                        $('#modal-form-2').modal('hide');
                        toastr['success'](res.msg);
                        if( type_modal_2 == 'document' ){
                            if( item_id_2 > 0 ){
                                $('#document_name_' + item_id_2).text(res.data.name);
                                $('#doc_name_' + item_id_2).val(res.data.name);
                                $('#doc_img_' + item_id_2).val(res.data.img);
                                $('#doc_type_' + item_id_2).val(res.data.type);
                                $('#doc_link_' + item_id_2).val(res.data.link);
                                $('#doc_file_link_' + item_id_2).val(res.data.file_link);
                            }else{
                                var template = $('.box-document-template').clone();
                                id_document_new++;
                                template.find('.title_doc').attr('id','document_name_' + id_document_new).text(res.data.name);
                                template.find('.btn').attr('data-id',id_document_new);
                                template.find('.doc_name').attr('name', 'DocumentName[' + id_document_new + ']').attr('id', 'doc_name_' + id_document_new).val(res.data.name);
                                template.find('.doc_img').attr('name', 'DocumentImg[' + id_document_new + ']').attr('id', 'doc_img_' + id_document_new).val(res.data.img);
                                template.find('.doc_type').attr('name', 'DocumentType[' + id_document_new + ']').attr('id', 'doc_type_' + id_document_new).val(res.data.type);
                                template.find('.doc_link').attr('name', 'DocumentLink[' + id_document_new + ']').attr('id', 'doc_link_' + id_document_new).val(res.data.link);
                                template.find('.doc_file_link').attr('name', 'DocumentFileLink[' + id_document_new + ']').attr('id', 'doc_file_link_' + id_document_new).val(res.data.file_link);
                                $('.content-document').append(template.html());
                            }
                        }

                    }else{
                        $('.list-error-2').remove();
                        var html_error = '<ul class="list-error-2" style="color:red;padding:0"><li style="list-style: none;"><b>Vui lòng sửa các lỗi sau đây:</b></li>';
                        res.error.map(function(name, index){
                            html_error += '<li style="padding-left:10px;list-style: inside;">' + name + '</li>';
                        });
                        html_error += '</ul>';
                        $('#modal-form-2 .modal-body').prepend(html_error);
                        $("#modal-form-2").animate({ scrollTop: 0 }, 600);
                    }
                },
                error:function(){
                    _this.find('.fal').addClass('hide');
                    toastr['error']('Có lỗi! Không thể thực hiện thao tác này');
                }
            })
        }
    });

});
</script>
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
<div class="modal fade" id="modal-form-2" tabindex="-1" role="dialog" aria-hidden="true">
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
                <button type="button" style="display:none" id="btn-submit-modal-2" class="btn btn-primary"><i class="fal fa-spin fa-spinner loading-submit-form hide"></i> Lưu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="hide box-question-template">
    <div class="form-group field-lesson-question">
        <div class="row align-items-center">
            <div class="col-lg-10" style="margin:0">
                <b class="title_ques" id="question_name_{id}">{name}</b>
            </div>
            <div class="col-lg-2" style="margin:0">
                <a href="javascript:;" data-id="{id}" data-type="question" data-title="Cập nhật câu hỏi" class="btn btn-primary btn-edit">Sửa</a>
                <a href="javascript:;" data-id="{id}" data-type="question" dataConfirm="Bạn có chắc chắn muốn xoá câu hỏi này?" class="btn btn-warning btn-delete">Xoá</a>
            </div>
        </div>
    </div>
</div>

<div class="hide box-lesson-template">
    <div class="form-group field-lesson" data-id="">
        <div class="row align-items-center">
            <div class="col-lg-10" style="margin:0">
                <a class="btn_view_detail" data-title="Chi tiết bài học" data-type="lesson" href="javascript:;" data-id=""><b class="title_lesson" id="lesson_name_{id}">{name}</b></a>
            </div>
            <div class="col-lg-2" style="margin:0">
                <a href="javascript:;" data-id="{id}" data-type="lesson" data-title="Cập nhật bài học" class="btn btn-primary btn-edit">Sửa</a>
                <a href="javascript:;" data-id="{id}" data-type="lesson" dataConfirm="Bạn có chắc chắn muốn xoá bài học này?" class="btn btn-warning btn-delete">Xoá</a>
            </div>
        </div>
    </div>
</div>

<div class="hide box-document-template">
    <div class="form-group field-document">
        <div class="row align-items-center">
            <div class="col-lg-10" style="margin:0">
                <b class="title_doc" id="document_name_{id}">{name}</b>
            </div>
            <div class="col-lg-2" style="margin:0">
                <a href="javascript:;" data-id="{id}" data-type="document" data-title="Cập nhật tài liệu" class="btn btn-primary btn-edit-2">Sửa</a>
                <a href="javascript:;" data-id="{id}" data-type="document" dataConfirm="Bạn có chắc chắn muốn xoá tài liệu này?" class="btn btn-warning btn-delete-2">Xoá</a>
            </div>
            <input type="hidden" class="input-hidden-value doc_name" value="" name="DocumentName[]" />
            <input type="hidden" class="input-hidden-value doc_img" value="" name="DocumentImg[]" />
            <input type="hidden" class="input-hidden-value doc_type" value="" name="DocumentType[]" />
            <input type="hidden" class="input-hidden-value doc_link" value="" name="DocumentLink[]" />
            <input type="hidden" class="input-hidden-value doc_file_link" value="" name="DocumentFileLink[]" />
        </div>
    </div>
</div>


<div class="hide box-guide-template">
    <div class="form-group field-guide">
        <div class="row align-items-center">
            <div class="col-lg-10" style="margin:0">
                <b class="title_doc" id="guide_name_{id}">{name}</b>
            </div>
            <div class="col-lg-2" style="margin:0">
                <a href="javascript:;" data-id="{id}" data-type="guide" data-title="Cập nhật hướng dẫn" class="btn btn-primary btn-edit">Sửa</a>
                <a href="javascript:;" data-id="{id}" data-type="guide" dataConfirm="Bạn có chắc chắn muốn xoá hướng dẫn này?" class="btn btn-warning btn-delete">Xoá</a>
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