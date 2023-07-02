<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course_lesson".
 *
 * @property integer $id
 * @property string $name
 * @property integer $course_section_id
 * @property string $create_date
 * @property string $link_video
 * @property integer $is_prevew
 */
class CourseLessonQuestion extends \yii\db\ActiveRecord
{
    public $listAnswer;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_name'],'required','message' => '{attribute} không được trống'],
            [['create_date','type','course_id','lesson_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Câu hỏi',
            'create_date' => 'Ngày thêm',
            'course_id' => 'Khoá học',
            'lesson_id' => 'Bài học',
        ];
    }

    public static function saveQuestionAnswer($item_id = 0, $type = 1){
        $post       = $_POST;
        $msgError   = "";
        $statusSave = true;
        if( isset($post['CourseLessonQuestion']) && !empty($post['CourseLessonQuestion']) && isset($post['CourseLessonAnswer']) && !empty($post['CourseLessonAnswer']) && isset($post['CourseLessonAnswerCorrect']) && !empty($post['CourseLessonAnswerCorrect'])  ){
            $dataQuestionNew = isset($post['CourseLessonQuestionNew']) ? $post['CourseLessonQuestionNew'] : [];
            $dataQuestion    = $post['CourseLessonQuestion'];
            $dataAnswer      = $post['CourseLessonAnswer'];
            $dataCorrect     = $post['CourseLessonAnswerCorrect'];

            $transaction     = Yii::$app->db->beginTransaction();
            try{

                foreach($dataQuestion as $id => $question_name){
                    if( empty(trim($question_name)) || !isset($dataCorrect[$id]) || empty($dataCorrect[$id]) || !isset($dataAnswer[$id]) || count(array_filter($dataAnswer[$id])) < 4 )
                        continue;
                    $flagAdd     = isset($dataQuestionNew[$id]) && $dataQuestionNew[$id] ? true : false;
                    if( $flagAdd ){
                        $model   = new CourseLessonQuestion;
                        $model->type = $type;
                        if( $type == 1 )
                            $model->lesson_id = $item_id;
                        else
                            $model->course_id = $item_id;
                    }else{
                        $model   = self::findOne($id);
                        if( !$model || $model->is_delete ){
                            continue;
                        }
                    }
                    $model->question_name = trim($question_name);
                    $model->save(false);       
                    
                    if( isset($dataAnswer[$id]) ){
                        $stt = 1;
                        foreach($dataAnswer[$id] as $id_ans => $answer_name){
                            if( empty(trim($answer_name)) )
                                continue;
                            $isCorrect = isset($dataCorrect[$id]) && $dataCorrect[$id] == $stt ? 1 : 0;
                            if( $flagAdd ){
                                $modelAns   = new CourseLessonAnswer;
                                
                            }else{
                                $modelAns   = CourseLessonAnswer::findOne($id_ans);
                                if( !$modelAns ){
                                    $modelAns   = new CourseLessonAnswer;
                                }else if( $modelAns->is_delete )
                                    continue;
                            }
                            $modelAns->question_id = $model->id;
                            $modelAns->answer_name = trim($answer_name);
                            $modelAns->is_correct  = $isCorrect;
                            $modelAns->position    = $stt;
                            $modelAns->save(false);
                            $stt++;
                        }
                    }
                }
                $transaction->commit();
            }
            catch(\Exception $e){
                $transaction->rollBack();
                $msgError = $e->getMessage();
                $statusSave = false;
            }
        }
        if( isset($post['CourseLessonQuestionRemove']) && !empty($post['CourseLessonQuestionRemove']) ){
            $condition_delete_question = 'type = ' . $type . ' and id IN (' . $post['CourseLessonQuestionRemove'] . ')';
            if( $type == 1 )
                $condition_delete_question .= ' and lesson_id = ' . $item_id;
            else
                $condition_delete_question .= ' and course_id = ' . $item_id;
            
            $condition_delete_answer  = 'question_id IN (' . $post['CourseLessonQuestionRemove'] . ')';

            Yii::$app->db->CreateCommand("UPDATE course_lesson_question SET is_delete = 1 WHERE $condition_delete_question")->execute();

            Yii::$app->db->CreateCommand("UPDATE course_lesson_answer SET is_delete = 1 WHERE $condition_delete_answer")->execute();
        }

        return [
            'status' => $statusSave,
            'msg'    => $msgError
        ];
    }

    public static function getQuestionAnswer($item_id = 0, $type = 1){
        $condition = ['type' => $type, 'is_delete' => 0, 'status' => 1];
        if( $type == 1 )
            $condition['lesson_id'] = $item_id;
        else
            $condition['course_id'] = $item_id;
        $resultQuestion = self::find()->where($condition)->orderBy(['id' => SORT_DESC])->all();
        if( !empty($resultQuestion) ){
            $arrQuesId  = \yii\helpers\ArrayHelper::map($resultQuestion, 'id', 'id');
            $resultAnswer = CourseLessonAnswer::find()->where(['in','question_id', $arrQuesId])->andWhere(['is_delete' => 0])->all();
            if( !empty($resultAnswer) ){
                $dataAnswer = [];
                foreach($resultAnswer as $answer){
                    $dataAnswer[$answer->question_id][] = $answer;
                }
                foreach($resultQuestion as $key=>$question){
                    if( isset($dataAnswer[$question->id]) ){
                        $resultQuestion[$key]->listAnswer= $dataAnswer[$question->id];
                    }
                }
            }
        }

        return $resultQuestion;
    }
}
