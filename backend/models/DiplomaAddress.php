<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "diploma_address".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $description
 */
class DiplomaAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diploma_address';
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
