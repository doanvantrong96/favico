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
class CourseLessonAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_name','question_id'],'required','message' => '{attribute} không được trống'],
            [['create_date','is_correct','lesson_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Câu trả lời',
            'create_date' => 'Ngày thêm',
            'question_id' => 'Câu hỏi',
        ];
    }
}
