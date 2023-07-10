<?php

namespace backend\models;

use Yii;

class Abouts extends \yii\db\ActiveRecord
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
        return 'abouts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'],'required','message'=>'Nhập {attribute}'],
            [['image','avatar'], 'required', 'message' => '{attribute} không được trống'],
            [['status','content','image','avatar','position'],'safe']
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'image'     => 'Ảnh nền',
            'avatar'    => 'Ảnh đại diện - ảnh nhỏ',
            'title'     => 'Tiêu đề',
            'content'   => 'Nội dung',
            'status'    => 'Trạng thái',
            'create_date' => 'Ngày đăng',
            'position'  => 'Thứ tự hiển thị'
        ];
    }
}
