<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "email_receive_offers".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $description
 */
class EmailReceiveOffers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_receive_offers';
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
