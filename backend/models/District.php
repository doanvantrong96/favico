<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $description
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
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
