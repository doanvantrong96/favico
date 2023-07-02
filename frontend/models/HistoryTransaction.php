<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_transaction".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $user_id
 * @property string $create_date
 * @property double $price
 * @property integer $status
 * @property string $note
 */
class HistoryTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id', 'status'], 'integer'],
            [['create_date'], 'safe'],
            [['price'], 'number'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'user_id' => 'User ID',
            'create_date' => 'Create Date',
            'price' => 'Price',
            'status' => 'Status',
            'note' => 'Note',
        ];
    }
}
