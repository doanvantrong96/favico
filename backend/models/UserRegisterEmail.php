<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_register_email".
 *
 * @property integer $id
 * @property string $email
 */
class UserRegisterEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_register_email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code'], 'unique','message'=>'{attribute} đã tồn tại'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID'
        ];
    }
}
