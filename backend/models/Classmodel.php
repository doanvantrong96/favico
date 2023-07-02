<?php

namespace backend\models;

use Yii;


class Classmodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['local'], 'required', 'message' => '{attribute} không được trống'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'local' => 'Địa chỉ',
            'status' => 'Trạng thái'
        ];
    }
}
