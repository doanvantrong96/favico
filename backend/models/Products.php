<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\helpers\FileHelper;
/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $productname
 * @property string $image
 * @property string $video
 * @property string $des
 * @property int $status 0:notshow;1:show;2:notbuy
 * @property string $price
 * @property string $pricesale
 * @property string $size
 * @property string $color
 * @property string $brand
 * @property int $timesale
 * @property int $created_at
 * @property int $updated_at
 */

class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFiles;
    public $image_avt;
    public static function tableName()
    {
        return 'product';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productname', 'price'], 'required','message'=>'{attribute} không được để trống'],
            [[ 'status'], 'integer'],
            [['productname' ,'video', 'price', 'pricesale', 'size', 'color', 'brand','timesale'], 'string', 'max' => 255],
            [['des'], 'string', 'max' => 4000],
            [['productname'], 'unique'],
            // [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10,'maxSize' => 1024*1024*2*10,'message'=>'File ảnh không hợp lệ'],
            // [['image_avt'], 'file', 'extensions' => 'png, jpg, jpeg','maxSize' => 1024*1024*2,'message'=>'File ảnh không hợp lệ'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function upload()
    { 
        if ($this->validate()) { 
            $i = 1;
            $time = time();
            $image_name = '';
            $path = 'uploads/images/'. $this->getNameImage($this->productname ) .'/';
            if( $this->isNewRecord ){
                if( is_dir($path)){
                    return false;
                }
                FileHelper::createDirectory($path);
                $this->path = $path;
            }else{
                $path = $this->path;
            }
               
            if( count($this->image_avt) > 0 ){
                $this->avatar = Url::base(true).'/'.$path.$this->getNameImage($this->productname.'_'.$time.$i).'.' . $this->image_avt[0]->extension;
                $this->image_avt[0]->saveAs($path. $this->getNameImage($this->productname.'_'.$time.$i). '.' . $this->image_avt[0]->extension);
                
                // $image_name = $this->avatar.';';
            }
            if( count($this->imageFiles) > 0 ){
                foreach ($this->imageFiles as $file) {
                    $i++;
                    $image_name .= Url::base(true).'/'.$path.$this->getNameImage($this->productname.'_'.$time.$i).'.' . $file->extension.';';
                    $file->saveAs($path .$this->getNameImage($this->productname.'_'.$time.$i). '.' . $file->extension);
                }
                $this->image =  rtrim($image_name,';');
            }
            
           
            return true;
        } else {
            return false;
        }
    }
    public function attributeLabels()
    {
        return [
            'id' => 'Mã',
            'productname' => 'Tên sản phẩm',
            'image' => 'Ảnh',
            'avatar' => 'Ảnh đại diện',
            'image_avt' => 'Ảnh đại diện',
            'video' => 'Video',
            'des' => 'Mô tả',
            'status' => 'Trạng thái',
            'price' => 'Giá niêm yết',
            'pricesale' => 'Giá bán',
            'size' => 'Size',
            'color' => 'Màu',
            'brand' => 'Thương hiệu',
            'timesale' => 'Thời gian bán',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'imageFiles' =>'Ảnh sản phẩm'
        ];
    }
    public function getNameImage ($str){
 
        $unicode = array(
         
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
         
        'd'=>'đ',
         
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
         
        'i'=>'í|ì|ỉ|ĩ|ị',
         
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
         
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
         
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
         
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
         
        'D'=>'Đ',
         
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
         
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
         
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
         
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
         
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
         
        );
         
        foreach($unicode as $nonUnicode=>$uni){
         
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
         
        }
        $str = str_replace(' ','_',$str);
         
        return $str;
         
        }
}
