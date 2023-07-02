<?php

namespace backend\models;

use Yii;

class FrequentlyQuestionsGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'frequently_questions_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '{attribute} không được trống'],
            [['status','position'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên nhóm',
            'position' => 'Thứ tự hiển thị',
            'status' => 'Trạng thái'
        ];
    }

}
