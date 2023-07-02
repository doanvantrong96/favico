<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Course;
use backend\models\CourseLessonQuestion;

$listCourse = ArrayHelper::map(Course::find()->where(['is_delete' => 0])->all(),'id','name');
$listQuestion = $model->isNewRecord ? [] : CourseLessonQuestion::getQuestionAnswer($model->id);
/* @var $this yii\web\View */
/* @var $model backend\models\CourseLesson */
/* @var $form yii\widgets\ActiveForm */
?>

<link rel="stylesheet" href="/css/default_skin.css" />
<link rel="stylesheet" href="/css/videojs-hls-player.css" />
<div class="course-lesson-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Thông tin bài học
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
                        <?= $form->field($model, 'total_answer_correct_need')->textInput(['maxlength' => true])->label('Số câu trả lời đúng <i title="Số câu trả lời đúng tối thiểu khi user làm bài tập (Mức ĐẠT)" data-toggle="tooltip" class="fal fa-info-circle"></i>') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?= $form->field($model, 'description')->textarea(['class'=>'form-control']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo $form->field($model, 'course_id')->dropDownList($listCourse, ['prompt'=>'Chọn khoá học']) ?>
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
                <?php if( !$model->isNewRecord ){ ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label class="form-label">Video bài học</label>
                            <div class="custom-file">
                                <input type="file" name="video" class="custom-file-input" data-input="#courselesson-path_file" data-id="<?= $model->id ?>" id="customFile">
                                <label class="custom-file-label" for="customFile"><?= $model->path_file != '' ? $model->path_file : 'Chọn video' ?></label>
                            </div>
                            <div class="meter" style="display:none">
                                <span style="width:0"></span>
                                <i></i>
                                <p class="cancel-upload"><b class="fal fa-times-circle"></b> Huỷ</p>
                            </div>
                            <?= $form->field($model, 'path_file')->hiddenInput()->label(false); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="row">
                    <?php if( !$model->isNewRecord ){ ?>
                    <div class="col-lg-12 box-video <?= !empty($model->path_file) ? '' : 'hide' ?>">
                        <div class="form-group mb-0">
                            <div class="videojs-hls-player-wrapper" id="video_player">
                                <video id="video" width="400" height="240" class="video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered ui-min ui-smooth v_5e8494e7ccb30-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-user-inactive">
                                    <source src="<?= $model->path_file ?>" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-collapsed">
        <div class="panel-hdr">
            <h2>
                Thông tin câu hỏi bài tập <a style="margin-left:15px" class="add_new_question" href="javascript:;"><i class="fal fa-plus"></i> Thêm câu hỏi</a>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container collapse">
            <div class="panel-content content-question">
                <div class="alert alert-info keep warning-question <?= empty($listQuestion) ? 'hide' : '' ?>">
                    <b>Lưu ý:</b> Vui lòng nhập đầy đủ câu hỏi, câu trả lời và chọn đáp án đúng. Trường hợp nhập thiếu hệ thống sẽ bỏ qua không lưu!
                </div>
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
                        <div class="row">
                            <div class="col-lg-10">
                                <label style="margin-top: 10px;" class="control-label lb-question" for="question-<?= $question->id ?>">Câu hỏi</label>
                                <input type="text" id="question-<?= $question->id ?>" class="form-control input-question" value="<?= $question->question_name ?>" name="CourseLessonQuestion[<?= $question->id ?>]">
                            </div>
                            <div class="col-lg-2">
                                <a href="javascript:;" style="margin-top: 33px;" dtid="<?= $question->id ?>" class="btn btn-primary remove-question"><i class="fal fa-trash"></i> Xoá</a>
                            </div>
                        </div>
                        <input type="hidden" class="answer_correct" name="CourseLessonAnswerCorrect[<?= $question->id ?>]" value="<?= $answerCorrect ?>" />
                        <input type="hidden" class="question_new" name="CourseLessonQuestionNew[<?= $question->id ?>]" value="0" />
                        <div class="row">
                            <?php
                                foreach($question->listAnswer as $key=>$answer){
                                    $stt = $key + 1;
                            ?>
                            <div class="col-lg-5">
                                <label style="margin-top: 10px;" class="control-label lb-answer-<?= $stt ?>" for="answer-<?= $stt ?>-<?= $question->id ?>">Đáp án <?= $stt ?></label>
                                <input type="text" id="answer-<?= $stt ?>-<?= $question->id ?>" value="<?= $answer->answer_name ?>" class="form-control input-answer-<?= $stt ?>" name="CourseLessonAnswer[<?= $question->id ?>][<?= $answer->id ?>]">
                                <label class="lb-correct">
                                    <input type="radio" <?= $answer->is_correct ? 'checked="true"' : '' ?> class="radio_correct" name="CheckBoxAnswerCorrect[<?= $question->id ?>]" value="<?= $stt ?>" /> Đáp án đúng
                                </label>
                            </div>
                            <?php } ?>
                        </div>    
                    </div>
                <?php
                        }
                    }else{
                        echo '<p class="empty-question">Chưa có câu hỏi nào</p>';
                    }
                ?>
                <input type="hidden" value="" class="input_question_remove" name="CourseLessonQuestionRemove" />
            </div>
        </div>
    </div>
    <div class="form-group text-center" style="margin-top:10px">
        <?= Html::submitButton('Lưu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    #video_player{
        max-width:400px;
    }
    .field-lesson-question {
        border: 1px dashed #ccc;
        padding: 15px;
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
</style>
<script src="/js/jquery-1.12.4.js"></script>
<script src="/js/video.js"></script>
<script src="/js/videojs-http-streaming.js"></script>
<script src="/js/videojs-contrib-quality-levels.min.js"></script>
<script src="/js/videojs-hls-quality-selector.min.js"></script>
<script src="/js/custom_upload_read_video.js"></script>
<script type="text/javascript">
var id_question_new = 99999;
jQuery(document).ready(function(){
    
    var ajaxUpload;
    $('.cancel-upload').click(function(){
        ajaxUpload.abort();
        $(".meter").slideUp();
    });

    $('.add_new_question').click(function(){
        id_question_new++;
        var template = $('.box-question-template').clone();
        template.find('.lb-question').attr('for','question-' + id_question_new);
        template.find('.input-question').attr('id','question-' + id_question_new).attr('name','CourseLessonQuestion[' + id_question_new + ']');
        
        template.find('.answer_correct').attr('name','CourseLessonAnswerCorrect[' + id_question_new + ']');
        template.find('.question_new').attr('name','CourseLessonQuestionNew[' + id_question_new + ']');
        template.find('.radio_correct').attr('name', 'CheckBoxAnswerCorrect[' + id_question_new + ']');
        
        for( var i = 1; i <= 4; i++ ){
            template.find('.lb-answer-' + i).attr('for','answer-' + i + '-' + id_question_new);
            template.find('.input-answer-' + i).attr('id','answer-' + i + '-' + id_question_new).attr('name','CourseLessonAnswer[' + id_question_new + '][' + i + ']');
        }        

        $('.content-question').append(template.html());

        $('.empty-question').remove();
        $('.warning-question').removeClass('hide');
        if( !$('.content-question').parent().hasClass('show') ){
            $('.content-question').parent().parent().find('.panel-toolbar .plus').trigger('click');
        }
    });
    $(document).on('click','.remove-question',function(){
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
        if( $('.content-question .field-lesson-question').length <= 0 ){
            $('.content-question').append('<p class="empty-question">Chưa có câu hỏi nào</p>');
            $('.warning-question').addClass('hide');
        }
    });
    $(document).on('click','.radio_correct',function(){
        $(this).parent().parent().parent().parent().find('.answer_correct').val($(this).val());
    });
});
</script>

<div class="hide box-question-template">
    <div class="form-group field-lesson-question">
        <div class="row">
            <div class="col-lg-10">
                <label style="margin-top: 10px;" class="control-label lb-question" for="">Câu hỏi</label>
                <input type="text" id="" class="form-control input-question" name="CourseLessonQuestion[]">
            </div>
            <div class="col-lg-2">
                <a href="javascript:;" style="margin-top: 33px;" dtid="0" class="btn btn-primary remove-question"><i class="fal fa-trash"></i> Xoá</a>
            </div>
        </div>
        <input type="hidden" class="answer_correct" name="CourseLessonAnswerCorrect[]" value="" />
        <input type="hidden" class="question_new" name="CourseLessonQuestionNew[]" value="1" />
        <div class="row">
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-1" for="">Đáp án 1</label>
                <input type="text" id="" class="form-control input-answer-1" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct" name="CheckBoxAnswerCorrect" value="1" /> Đáp án đúng
                </label>
            </div>
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-2" for="">Đáp án 2</label>
                <input type="text" id="" class="form-control input-answer-2" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct" name="CheckBoxAnswerCorrect"  value="2" /> Đáp án đúng
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-3" for="">Đáp án 3</label>
                <input type="text" id="" class="form-control input-answer-3" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct" name="CheckBoxAnswerCorrect"  value="3" /> Đáp án đúng
                </label>
            </div>
            <div class="col-lg-5">
                <label style="margin-top: 10px;" class="control-label lb-answer-4" for="">Đáp án 4</label>
                <input type="text" id="" class="form-control input-answer-4" name="CourseLessonAnswer[]">
                <label class="lb-correct">
                    <input type="radio" class="radio_correct" name="CheckBoxAnswerCorrect" value="4" /> Đáp án đúng
                </label>
            </div>
        </div>    
    </div>
</div>