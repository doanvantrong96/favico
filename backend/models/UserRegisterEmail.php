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
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
