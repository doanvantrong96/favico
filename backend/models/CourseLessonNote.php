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
class CourseLessonNote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson_note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'user_id', 'note'],'required','message' => '{attribute} không được trống'],
            [['create_date','last_update'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'note' => 'Ghi chú',
            'create_date' => 'Ngày thêm',
            'user_id' => 'Khách hàng',
            'lesson_id' => 'Bài học',
        ];
    }
}
