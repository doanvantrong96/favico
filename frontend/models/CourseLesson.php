<?php

namespace frontend\models;

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
class CourseLesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_section_id', 'is_prevew','course_id'], 'integer'],
            [['create_date'], 'safe'],
            [['link_video'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên bài học',
            'course_section_id' => 'Phần học',
            'create_date' => 'Ngày thêm',
            'link_video' => 'Video bài học',
            'is_prevew' => 'Được xem thử?',
            'course_id' => 'Khoá học'
        ];
    }
}
