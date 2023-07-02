<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Course;
use backend\models\CourseLesson;
use backend\models\CourseLessonQuestion;

$listCourse     = ArrayHelper::map(Course::find()->where(['is_delete' => 0])->all(),'id','name');
$listQuestion   = $modelLesson->isNewRecord ? [] : CourseLessonQuestion::getQuestionAnswer($modelLesson->id);
/* @var $this yii\web\View */
/* @var $modelLesson backend\models\CourseLesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-lesson-form">

<form id="form-action">
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
                    <div class="col-lg-12">
                        <div class="form-group field-courselesson-name has-success">
                            <label class="control-label" for="courselesson-name">Tên bài học</label>
                            <input type="text" id="courselesson-name" class="form-control" name="CourseLesson[name]" value="<?= $modelLesson->name ?>" maxlength="100" aria-required="true" aria-invalid="false">

                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group field-courselesson-description required">
                            <label class="control-label" for="courselesson-description">Nội dung bài học</label>
                            <textarea id="courselesson-description" class="form-control" name="CourseLesson[description]" aria-required="true"><?= $modelLesson->description ?></textarea>

                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label class="form-label">Ảnh</label>
                            <div class="custom-file">
                                <input type="file" name="avatar" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/lesson" id="customFileAvatar">
                                <label class="custom-file-label" for="customFileAvatar"><?= $modelLesson->avatar != '' ? $modelLesson->avatar : 'Chọn ảnh' ?></label>
                            </div>
                            <input type="hidden" id="courselesson-avatar" class="form-control input-hidden-value" name="CourseLesson[avatar]" value="<?= $modelLesson->avatar ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label class="form-label">Video bài học</label>
                            <div class="custom-file">
                                <input type="file" name="video" accept=".mp4" class="custom-file-input" data-input="#courselesson-path_file" data-id="<?= $modelLesson->isNewRecord ? 0 : $modelLesson->id ?>" id="customFile">
                                <label class="custom-file-label" for="customFile"><?= $modelLesson->path_file != '' ? $modelLesson->path_file : 'Chọn video' ?></label>
                            </div>
                            <div class="meter" style="display:none">
                                <span style="width:0"></span>
                                <i></i>
                                <p class="cancel-upload"><b class="fal fa-times-circle"></b> Huỷ</p>
                            </div>
                            <input type="hidden" id="courselesson-path_file" class="form-control" name="CourseLesson[path_file]" value="<?= $modelLesson->path_file ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 box-video <?= !empty($modelLesson->path_file) ? '' : 'hide' ?>">
                        <div class="form-group mb-0">
                            <div class="videojs-hls-player-wrapper" id="video_player">
                                <?php if(!empty($modelLesson->path_file)): ?>
                                <video id="video" width="400" height="240" class="<?= !empty($modelLesson->path_file) ? 'hasFile' : '' ?> video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered ui-min ui-smooth v_5e8494e7ccb30-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-user-inactive">
                                    <source src="<?= $modelLesson->path_file ?>" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel ">
        <div class="panel-hdr">
            <h2>
                Thông tin tài liệu <a style="margin-left:15px" data-title="Thêm tài liệu" data-type="document" class="btn_add_new_2" href="javascript:;"><i class="fal fa-plus"></i> Thêm</a>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content content-document">
                <?php
                    $documents       = $modelLesson->document ? json_decode($modelLesson->document, true) : [];
                    if( !empty($documents) ){
                        foreach($documents as $doc_id => $doc){
                ?>
                <div class="form-group field-document">
                    <div class="row align-items-center">
                        <div class="col-lg-10" style="margin:0">
                            <b id="document_name_<?= $doc_id ?>"><?= $doc['name'] ?></b>
                        </div>
                        <div class="col-lg-2" style="margin:0">
                            <a href="javascript:;" data-id="<?= $doc_id ?>" data-type="document" data-title="Cập nhật tài liệu" class="btn btn-primary btn-edit-2">Sửa</a>
                            <a href="javascript:;" data-id="<?= $doc_id ?>" data-type="document" dataConfirm="Bạn có chắc chắn muốn xoá tài liệu này?" class="btn btn-warning btn-delete-2">Xoá</a>
                        </div>

                        <input type="hidden" id="doc_name_<?= $doc_id ?>" class="input-hidden-value doc_name" value="<?= $doc['name'] ?>" name="DocumentName[<?= $doc_id ?>]" />
                        <input type="hidden" id="doc_img_<?= $doc_id ?>" class="input-hidden-value doc_img" value="<?= $doc['img'] ?>" name="DocumentImg[<?= $doc_id ?>]" />
                        <input type="hidden" id="doc_type_<?= $doc_id ?>" class="input-hidden-value doc_type" value="<?= $doc['type'] ?>" name="DocumentType[<?= $doc_id ?>]" />
                        <input type="hidden" id="doc_link_<?= $doc_id ?>" class="input-hidden-value doc_link" value="<?= $doc['link'] ?>" name="DocumentLink[<?= $doc_id ?>]" />
                        <input type="hidden" id="doc_file_link_<?= $doc_id ?>" class="input-hidden-value doc_file_link" value="<?= $doc['file_link'] ?>" name="DocumentFileLink[<?= $doc_id ?>]" />
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
                Thông tin câu hỏi bài tập <a style="margin-left:15px" class="add_new_question_lesson" href="javascript:;"><i class="fal fa-plus"></i> Thêm câu hỏi</a>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content content-question-lesson">
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
                                <a href="javascript:;" style="margin-top: 33px;" dtid="<?= $question->id ?>" class="btn btn-primary remove-question-lesson"><i class="fal fa-trash"></i> Xoá</a>
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
                                    <input type="radio" <?= $answer->is_correct ? 'checked="true"' : '' ?> class="radio_correct_lesson" name="CheckBoxAnswerCorrect[<?= $question->id ?>]" value="<?= $stt ?>" /> Đáp án đúng
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
</form>

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
