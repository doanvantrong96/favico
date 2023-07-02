<?php

namespace backend\models;
use \yii\db\Query;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property string $username
 * @property string $id_transport
 * @property string $customername
 * @property int $status 1: chờ xác nhận, 2 đang vận chuyển, 3 đã huỷ, 4 hàng về , 5 đã lấy hàng, 6 đã trả lại
 * @property string $totalprice
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
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
            [['username', 'customername'], 'required'],
            [['status'], 'integer'],
            [['username', 'id_transport', 'customername'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nhân viên tạo',
            'id_transport' => 'Mã vận chuyển',
            'customername' => 'Khách hàng',
            'status' => 'Trạng thái',
            'note' => 'Ghi chú',
        ];
    }
    public function getInvoice(){
        $query = new Query;
        
        $query	->select([
            'invoice.id','invoice.created_at','invoice.updated_at','invoice.status','invoice.id_transport','invoice.customername','invoice.username','invoice.note',
            '(SELECT SUM(detailinvoice.price*detailinvoice.quantity) FROM detailinvoice WHERE detailinvoice.invoice_id = invoice.id) as totalprice','(SELECT SUM(detailinvoice.currency*detailinvoice.quantity) FROM detailinvoice WHERE detailinvoice.invoice_id = invoice.id) as totalcurrency'])  
            ->from('invoice')
            ->join('INNER JOIN', 'detailinvoice',
                'detailinvoice.invoice_id =invoice.id')
            ->where('invoice.status != 0')
            ->groupBy('invoice.id')
            ->orderby(['id'=>SORT_DESC])	;	
        $command = $query->createCommand();
        return $data = $command->queryAll();
    }
    public function getCustomerInvoice($customername){
        $query = new Query;
        
        $query	->select([
            'invoice.id','invoice.created_at','invoice.updated_at','invoice.status','invoice.id_transport','invoice.customername','invoice.username',
            '(SELECT SUM(detailinvoice.price*detailinvoice.quantity) FROM detailinvoice WHERE detailinvoice.invoice_id = invoice.id) as totalprice'])  
            ->from('invoice')
            ->join('INNER JOIN', 'detailinvoice',
                'detailinvoice.invoice_id =invoice.id')
            ->where('invoice.status != 0 && invoice.customername="'.$customername.'"')
            ->groupBy('invoice.id')
            ->orderby(['id'=>SORT_DESC])	;	
        $command = $query->createCommand();
        return $data = $command->queryAll();
    }
}
