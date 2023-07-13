<?php

namespace backend\models;

use Yii;

class ProductCategory extends \yii\db\ActiveRecord
{
    // public $image;
    // public $avatar;
    // public $content;
    // public $status;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required','message'=>'Nhập {attribute}'],
            [['image'], 'required', 'message' => '{attribute} không được trống'],
            [['image','name','status','position'],'safe']
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'name'     => 'Tên danh mục',
            'status'    => 'Trạng thái',
            'create_date' => 'Ngày đăng',
            'position'  => 'Vị trí trên bộ lọc'
        ];
    }
}
