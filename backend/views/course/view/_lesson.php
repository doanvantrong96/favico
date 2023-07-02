<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Course;
use backend\models\CourseLessonQuestion;

$listQuestion   = CourseLessonQuestion::getQuestionAnswer($model->id);
?>

<div class="lesson-view">
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
        <div class="panel-container">
            <div class="panel-content content-lesson">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'label' => 'Ảnh',
                            'format' =>  'raw',
                            'value' => function ($model) {
                                $r = ($model->avatar != "" ? '<img style="max-width: 100%;max-height: 200px;" src="'.$model->avatar.'" alt="" />' : '');
                                return $r;
                            }
                        ],
                        'name',
                        // 'sort',
                        [
                            'label'=>'Tài liệu',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $documents       = $model->document ? json_decode($model->document, true) : [];
                                $html = '';
                                if( !empty($documents) ){
                                    foreach($documents as $doc_id => $doc){
                                        $link    = !empty($doc['link']) ? $doc['link'] : $doc['file_link'];
                                        $html .= '<p style="margin-bottom:0">- <a href="' . $link . '" target="_blank">' . $doc['name'] . '</a></p>';
                                    }
                                    return $html;
                                }
                                return 'Chưa cập nhật';
                            },
                        ],
                        'create_date',
                        [
                            'label'=>'Video bài học',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if( $model->path_file != '' ){
                                    return '<div class="videojs-hls-player-wrapper"  style="max-width:450px" id="video_player">
                                    <video id="video" width="400" height="240" class="hasFile video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered ui-min ui-smooth v_5e8494e7ccb30-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-user-inactive">
                                        <source src="' . $model->path_file . '" type="video/mp4" />
                                        Your browser does not support the video tag.
                                    </video></div>';
                                }
                                return 'Chưa có video';
                            },
                        ],
                        [
                            'label'=>'Thuộc khoá học',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if( $model->course_id > 0 ){
                                    $modelCourse = Course::findOne($model->course_id);
                                    if($modelCourse)
                                        return $modelCourse->name;
                                    else
                                        return 'Chưa thuộc khoá học nào';
                                }else
                                    return 'Chưa thuộc khoá học nào';
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
                    Danh sách câu hỏi
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                    <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
                </div>
            </div>
            <div class="panel-container">
                <div class="panel-content content-lesson">
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
                                <div class="col-lg-12">
                                    <label style="margin-top: 10px;" class="control-label lb-question" for="question-<?= $question->id ?>">Câu hỏi</label>
                                    <input type="text" readonly id="question-<?= $question->id ?>" class="form-control input-question" value="<?= $question->question_name ?>" name="CourseLessonQuestion[<?= $question->id ?>]">
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                    foreach($question->listAnswer as $key=>$answer){
                                        $stt = $key + 1;
                                ?>
                                <div class="col-lg-6">
                                    <label style="margin-top: 10px;" class="control-label lb-answer-<?= $stt ?>" for="answer-<?= $stt ?>-<?= $question->id ?>">Đáp án <?= $stt ?></label>
                                    <input type="text" readonly id="answer-<?= $stt ?>-<?= $question->id ?>" value="<?= $answer->answer_name ?>" class="form-control input-answer-<?= $stt ?>" name="CourseLessonAnswer[<?= $question->id ?>][<?= $answer->id ?>]">
                                    <label class="lb-correct">
                                        <input type="radio" <?= $answer->is_correct ? 'checked="true"' : 'disabled' ?> class="radio_correct_lesson" name="CheckBoxAnswerCorrect[<?= $question->id ?>]" value="<?= $stt ?>" /> Đáp án đúng
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
                </div>
            </div>
        </div>
</div>
<style>
.detail-view th{vertical-align: middle;}
</style>