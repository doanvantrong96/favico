<?php

namespace backend\models;

use Yii;


class CourseLessonActive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson_active';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id','course_id','user_id'],'required','message' => '{attribute} không được trống'],
            [['create_date','lesson_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lesson_id' => 'ID lớp học',
            'course_id' => 'Mã lớp học',
            'user_id' => 'ID khách hàng',
            'status' => 'Trạng thái',
            'create_date' => 'Ngày thêm',
            'last_update' => 'Ngày update',
        ];
    }
}
