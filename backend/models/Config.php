<?php

namespace backend\models;

use Yii;

class Config extends \yii\db\ActiveRecord
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
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['title','content'],'required','message'=>'Nhập {attribute}'],
            // [['image'], 'required', 'message' => '{attribute} không được trống'],
            [['type','status','name','image','position','create_date','value'],'safe']
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'type'     => 'Loại config',
            'name'     => 'Nội dung hiển thị',
            'value'   => 'Link của Nội dung',
            'status'    => 'Trạng thái',
            'image'    => 'Ảnh/ Icon',
            'position'  => 'Vị trí/ Sắp xếp'
        ];
    }
}
