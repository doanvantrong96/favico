<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "continue_lesson".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $description
 */
class ContinueLesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'continue_lesson';
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
