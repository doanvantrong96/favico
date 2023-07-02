<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coach_course".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $description
 */
class FrequentlyQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'frequently_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question','answer','group_id'], 'required', 'message' => '{attribute} không được trống'],
            [['status'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Câu hỏi',
            'answer' => 'Câu trả lời',
            'group_id' => 'Nhóm',
            'status' => 'Trạng thái'
        ];
    }

}
