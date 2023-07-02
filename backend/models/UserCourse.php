<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_course".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $user_id
 * @property string $create_date
 * @property double $percent_complete
 */
class UserCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id'], 'integer'],
            [['create_date'], 'safe'],
            [['percent_complete'], 'number'],
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
            'percent_complete' => 'Percent Complete',
        ];
    }
}
