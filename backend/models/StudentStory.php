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
class StudentStory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_story';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','image','address'], 'required', 'message' => '{attribute} không được trống'],
            [['status','address'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Tên câu chuyện',
            'image' => 'Ảnh học viên',
            'address' => 'Địa chỉ',
            'status' => 'Trạng thái'
        ];
    }

}
