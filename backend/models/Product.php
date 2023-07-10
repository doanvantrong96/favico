<?php

namespace backend\models;

use Yii;

class Product extends \yii\db\ActiveRecord
{
    CONST PUBLISHED = 1;
    public $listCategory;
    public $listTags;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','slug'],'required','message'=>'Nhập {attribute}'],
            [['title', 'slug'], 'string', 'max' => 255, 'tooLong' => '{attribute} tối đa {max} ký tự'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => '{attribute} không chứa dấu tiếng việt, dấu cách và ký tự đặc biệt như:`!~@#$%^...'],
            [['slug'], 'unique', 'message' => '{attribute} đã tồn tại'],
            [['description'], 'string', 'max' => 300, 'tooLong' => '{attribute} tối đa {max} ký tự'],
            [['slug'], 'unique', 'targetAttribute' => ['slug'], 'message' => '{attribute} đã tồn tại.'],
            [['image'], 'required', 'message' => '{attribute} không được trống'],
            [['image','title','status','position','slug','description','content','category_id','tag_id','is_most','related_product','create_date'],'safe']
        ];
    }

    public function beforeSave($insert){
       
        if( is_array($this->tag_id) ){
            $this->tag_id = ';' . implode(';',$this->tag_id) . ';';
        }
        if( is_array($this->related_product) ){
            $this->related_product = ';' . implode(';',$this->related_product) . ';';
        }
        
        //Sản phẩm đã duyệt -> Không lưu slug mới nếu thay đổi
        if( !$this->isNewRecord && in_array($this->status, [self::PUBLISHED]) ){
            unset($this->slug);
        }
        
        return parent::beforeSave($insert);
    }
    
    // public function afterSave($insert, $changedAttributes){
    //     parent::afterSave($insert, $changedAttributes);
        
    //     if( $insert || isset($changedAttributes['tag_id']) ){
    //         $arrCateId      = !empty($this->tag_id) ? array_filter(explode(';',$this->tag_id)) : [];
    //         ProductTag::saveData($this->id, $arrCateId);
    //     }
    // }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'title'     => 'Tên sản phẩm',
            'slug'      => 'Slug',
            'description'    => 'Mô tả sản phẩm',
            'content'    => 'Chi tiết sản phẩm',
            'category_id'    => 'Nhà cung cấp',
            'tag_id'    => 'Loại sản phẩm',
            'is_most'    => 'Sản phẩm nổi bật',
            'related_product'    => 'Sản phẩm liên quan',
            'create_date' => 'Ngày đăng',
            'position'  => 'Vị trí trên bộ lọc'
        ];
    }
}
