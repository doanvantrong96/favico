<?php

namespace backend\models;

use Yii;

class Comment extends \yii\db\ActiveRecord
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
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','author','position'],'required','message'=>'Nhập {attribute}'],
            [['avatar'], 'required', 'message' => '{attribute} không được trống'],
            [['status','content','avatar','position','author','type','product_id'],'safe']
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'avatar'    => 'Ảnh đại diện',
            'content'   => 'Nội dung',
            'status'    => 'Trạng thái',
            'create_date' => 'Ngày đăng',
            'position'  => 'Thứ tự hiển thị',
            'type'      => 'Loại comment',
            'rate'      => 'Đánh giá',
            'product_id'=> 'Id sản phẩm'
        ];
    }
}
