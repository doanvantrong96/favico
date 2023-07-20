<?php

namespace backend\models;

use Yii;

class Technical extends \yii\db\ActiveRecord
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
        return 'technical';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','content'],'required','message'=>'Nhập {attribute}'],
            [['image'], 'required', 'message' => '{attribute} không được trống'],
            [['title','status','content','image','position','is_delete'],'safe']
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'image'     => 'Ảnh',
            'title'     => 'Tiêu đề',
            'content'   => 'Nội dung',
            'status'    => 'Trạng thái',
            'create_date' => 'Ngày đăng',
            'position'  => 'Vị trí trên trang chủ'
        ];
    }
}
