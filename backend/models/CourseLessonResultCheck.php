<?php

namespace backend\models;

use Yii;


class CourseLessonResultCheck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson_result_check';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id','user_id'],'required','message' => '{attribute} không được trống'],
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
            'lesson_id' => 'ID lớp học',
            'user_id' => 'ID khách hàng',
            'total_answer' => 'Tổng số câu hỏi',
            'total_answer_correct' => 'Tổng số câu trả lời đúng',
            'create_date' => 'ngày khởi tạo',
            'last_update' => 'ngày cập nhật lần cuối',
        ];
    }
}
