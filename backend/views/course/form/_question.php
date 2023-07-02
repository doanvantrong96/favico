<?php
    use backend\models\CourseLessonQuestion;
    use backend\models\CourseLessonAnswer;

    $question_name = '';
    $listAnswer    = [];
    if( $item_id > 0 ){
        $modelQuestion = CourseLessonQuestion::findOne($item_id);
        if( $modelQuestion ){
            $question_name = $modelQuestion->question_name;

            $listAnswer    = CourseLessonAnswer::find()->where(['question_id' => $modelQuestion->id])->andWhere(['is_delete' => 0])->all();
        }
    }
?>
<form id="form-action">
    <div class="form-group">
        <div class="row">
            <div class="col-lg-12">
                <label style="margin-top: 10px;" class="control-label lb-question" for="question-name">Câu hỏi</label>
                <input type="text" id="question-name" class="form-control input-question" value="<?= $question_name ?>" name="CourseLessonQuestion">
            </div>
        </div>
        <div class="row box-content">
            <?php
                for($i = 0; $i < 4; $i++){
                    $answer_name = '';
                    $stt         = $i + 1;
                    $id_answer   = $i + 1;
                    $is_correct  = 0;
                    if( isset($listAnswer[$i]) ){
                        $answer_name = $listAnswer[$i]->answer_name;
                        $is_correct  = $listAnswer[$i]->is_correct;
                        $id_answer   = $listAnswer[$i]->id;
                    }
            ?>
            <div class="col-lg-6">
                <label style="margin-top: 10px;" class="control-label lb-answer-1" for="answer-<?= $stt ?>">Đáp án <?= $stt ?></label>
                <input type="text" id="answer-<?= $stt ?>" class="form-control input-answer-<?= $stt ?>" value="<?= $answer_name ?>" name="CourseLessonAnswer[<?= $id_answer ?>]">
                <label class="lb-correct">
                    <input type="radio" <?= $is_correct ? 'checked="true"' : '' ?> class="radio_correct" name="CheckBoxAnswerCorrect" value="<?= $stt ?>" /> Đáp án đúng
                </label>
            </div>
            <?php 
                }
            ?>
        </div>    
    </div>
</form>