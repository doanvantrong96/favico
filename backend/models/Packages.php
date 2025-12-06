<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Packages extends ActiveRecord
{
    /**
     * Thuộc tính dùng để upload QR Code
     */
    public $qr_upload;

    public static function tableName()
    {
        return 'packages';
    }

    public function rules()
    {
        return [
            [['package_name', 'package_price'], 'required'],

            [['package_price', 'promotion_price'], 'number', 'min' => 0],
            [['number','pdf_file'], 'integer', 'min' => 0],
            [['status'], 'integer'],

            [['created_at'], 'safe'],

            [['package_name', 'pdf_file', 'qr_code'], 'string', 'max' => 255],

            // Upload QR code
            [['qr_code'], 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],

            // Validate nâng cao
            ['promotion_price', 'validatePromotion'],
        ];
    }

    public function validatePromotion($attribute)
    {
        if ($this->promotion_price && $this->promotion_price >= $this->package_price) {
            $this->addError($attribute, 'Giá khuyến mãi phải nhỏ hơn giá gói.');
        }
    }

    public function attributeLabels()
    {
        return [
            'package_name' => 'Tên gói',
            'package_price' => 'Giá gói',
            'promotion_price' => 'Giá khuyến mãi',
            'number' => 'Số LÁ SỐ',
            'pdf_file' => 'Số PDF File',
            'qr_code' => 'QR Code',
            'qr_upload' => 'Upload QR Code',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
        ];
    }

    /**
     * Soft Delete: đổi status = 0
     */
    public function softDelete()
    {
        $this->status = 0;
        return $this->save(false);
    }

    /**
     * Upload function
     */
    public function uploadQR()
    {
        if ($this->qr_upload) {
            $fileName = 'qr_' . time() . '.' . $this->qr_upload->extension;
            $path = 'uploads/qr/' . $fileName;

            if ($this->qr_upload->saveAs($path)) {
                $this->qr_code = $path;
                return true;
            }
            return false;
        }
        return true;
    }

    // Tạo đường dẫn URL để hiển thị ảnh
    public function getQrImageUrl()
    {
        if (!$this->qr_code) {
            return null;
        }
        return Yii::getAlias('@web/img/qr/' . $this->qr_code);
    }
}
