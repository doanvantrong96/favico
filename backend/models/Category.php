<?php

namespace backend\models;

use Yii;

class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required','message'=>'Nhập {attribute}'],
            // [['slug'], 'unique', 'targetAttribute' => ['slug'], 'message' => '{attribute} đã tồn tại.'],
            [['status','except','slug','position','image'],'safe']
        ];
    }

    public function beforeSave($insert){
       
        if( $this->slug ){
            $this->slug = \backend\controllers\CommonController::LocDau($this->slug);
        }
        return parent::beforeSave($insert);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên danh mục',
            'except'    => 'Mô tả',
            'image' => 'Ảnh',
            'status' => 'Trạng thái',
            'create_date' => 'Ngày tạo',
            'position' => 'Thứ tự'
        ];
    }

}
