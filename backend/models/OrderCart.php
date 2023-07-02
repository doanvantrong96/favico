<?php

namespace backend\models;

use Yii;

class OrderCart extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL    = 2;
    const STATUS_CUSTOMER_CANCEL = 3;
    const STATUS_ADMIN_CANCEL = 4;
    public $list_course;
    public $commission_percentage_of_sale;
    public $sale_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            
        ];
    }

}
