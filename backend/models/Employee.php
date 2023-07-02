<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $password
 * @property string $create_date
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property integer $is_active
 * @property string $locale
 * @property string $birthday
 * @property string $last_update
 * @property string $device_id
 * @property string $ip
 * @property integer $is_admin
 * @property string $username
 * @property string $password_reset_token
 * @property string $auth_key
 */
class Employee extends \yii\db\ActiveRecord
{
    const TYPE_STAFF = 1;//Nhân viên
    const TYPE_LECTURER = 2;//Giảng viên
    const TYPE_SALE = 3;//Sale
    const TYPE_SALE_ADMIN = 4;//Sale admin
    public $password_old;
    public $password_new;
    public $password_renew;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['id', 'ip', 'username'], 'required'],
            [['id', 'is_active', 'is_admin'], 'integer'],
            [['create_date', 'birthday', 'last_update'], 'safe'],
            [['fullname', 'email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 40],
            [['phone'], 'string', 'max' => 20],
            [['address', 'password_reset_token'], 'string', 'max' => 255],
            [['locale'], 'string', 'max' => 10],
            [['device_id'], 'string', 'max' => 50],
            [['ip', 'username'], 'string', 'max' => 30],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];

        if( Yii::$app->controller->action->id == 'change-password' ){
            $rules[] = [['password_old'],'validatePasswordOld'];
            $rules[] = [['password_old','password_new','password_renew'],'required','message' => '{attribute} không được trống'];
            $rules[] = [['password_renew'], 'compare', 'compareAttribute' => 'password_new', 'message' => 'Mật khẩu mới nhập lại không khớp'];
            $rules[] = [['password_new'], 'string', 'min' => 6, 'tooShort' => '{attribute} quá ngắn. Tối thiểu {min} ký tự'];
        }

        return $rules;
    }

    public function validatePasswordOld(){
        if( $this->password_old && md5(md5($this->password_old)) != $this->password )
            $this->addError('password_old', 'Mật khẩu hiện tại không chính xác');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã tài khoản',
            'fullname' => 'Họ và tên',
            'password' => 'Mật khẩu truy cập',
            'create_date' => 'Ngày tạo tài khoản',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'is_active' => '1:active / 0: banned',
            'locale' => 'ngôn ngữ sử dụng backend: vi, en',
            'birthday' => 'ngày sinh nhật',
            'last_update' => 'ngày cập nhật profile mới nhất',
            'device_id' => 'mã thiết bị truy cập',
            'ip' => 'ip nhân viên đang truy cập',
            'is_admin' => '0: tk thường / 1: tk super admin',
            'username' => 'Tên tài khoản',
            'password_reset_token' => 'token để reset mật khẩu',
            'auth_key' => 'token để reset mật khẩu',
            'password_old' => 'Mật khẩu hiện tại',
            'password_new' => 'Mật khẩu mới',
            'password_renew' => 'Nhập lại mật khẩu mới'
        ];
    }
}
