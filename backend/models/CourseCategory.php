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
class CourseCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }
   
}
