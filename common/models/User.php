<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    public $userRole;
    public $updated_at;
    public $created_at;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Tài khoản',
            'fullname' => 'Họ tên',
            'password' => 'Mật khẩu',
            'password_hash' => 'Mật khẩu',
            'created_at' => 'Thời gian tạo',
            'updated_at' => 'Cập nhật lần cuối',
            'is_active' => 'Trạng thái',
            'phone' => 'Số điện thoại',
            'commission_percentage' => 'Hoa hồng'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            ['is_active', 'default', 'value' => self::STATUS_ACTIVE],
            ['is_active', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['username'], 'unique','message' => '{attribute} đã tồn tại'],
            [['fullname','username'], 'required', 'message' => '{attribute} không được trống'],
        ];
        if( $this->isNewRecord ){
            $rules[] = [['password'], 'required', 'message' => '{attribute} không được trống'];
        }
        if( Yii::$app->controller->id == 'sale-admin' && in_array(Yii::$app->controller->action->id, ['create-sale', 'update-sale']) ){
            $rules[] = [['commission_percentage'], 'required', 'message' => '{attribute} không được trống'];
            $rules[] = [['commission_percentage'], 'validateCommissionPercentage'];
        }
        return $rules;
    }

    public function validateCommissionPercentage($attribute){
        if( Yii::$app->user->identity ){
            $commission_percentage_sale_admin = Yii::$app->user->identity->commission_percentage;
            if( $this->commission_percentage > $commission_percentage_sale_admin ){
                $this->addError($attribute, 'Phần trăm hoa hồng tài khoản sale không được vượt quá phần trăm hoa hồng của bạn');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'is_active' => self::STATUS_ACTIVE]);
    }

    public static function findByID($id)
    {
        return static::findOne(['id' => $id]);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'is_active' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'is_active' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'is_active' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return md5(md5($password)) == $this->password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = md5(md5($password));
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
