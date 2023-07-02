<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "detailinvoice".
 *
 * @property int $id
 * @property string $invoice_id
 * @property string $productname
 * @property string $image
 * @property int $status 1: chờ xác nhận, 2 đang vận chuyển, 3 đã huỷ, 4 hàng về , 5 đã lấy hàng, 6 trả lại
 * @property int $quantity
 * @property string $price
 */
class Detailinvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detailinvoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'productname', 'quantity', 'price'], 'required'],
            [['status', 'quantity'], 'integer'],
            [['invoice_id', 'productname', 'image', 'price','currency'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã sản phẩm',
            'invoice_id' => 'Mã đơn',
            'productname' => 'Tên sản phẩm',
            'image' => 'Link ảnh',
            'status' => 'Trạng thái',
            'quantity' => 'Số lượng',
            'price' => 'Giá',
            'currency' => 'Giá Tệ',
        ];
    }
}
