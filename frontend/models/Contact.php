<?php

namespace frontend\models;

use Yii;


class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required', 'message' => '{attribute} không được trống'],
            ['email', 'email'],
            [['source', 'url','province'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Họ và tên',
            'phone' => 'SĐT',
            'email' => 'Email',
            'content' => 'Nội dung',
            'status' => 'Trạng thái',
        ];
    }
}
