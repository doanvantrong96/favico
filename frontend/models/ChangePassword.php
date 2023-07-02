<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

/**
 * Signup form
 */
class ChangePassword extends Model
{
    public $password_old;
    public $password_new;
    public $password_renew;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password_renew','password_new'], 'required','message'=>'{attribute} không được để trống'],
            [['password_old'], 'required','on'=>'has_password','message'=>'{attribute} không được để trống'],
            ['password_old', 'checkPasswordOld'],
            [['password_new','password_renew'], 'string', 'min' => 6,'tooShort'=>'{attribute} tối thiểu 6 ký tự'],
            [
                'password_renew', 'compare', 'compareAttribute' => 'password_new',
                'message' => "Nhập lại mật khẩu không chính xác", 'skipOnEmpty' => false,
                'when' => function ($model) {
                    return $model->password_new !== null && $model->password_new !== '';
                },
            ]
        ];
    }
    public function checkPasswordOld($attribute, $params)
    {
        $user = Users::findOne(Yii::$app->user->identity->id);
        if( $user->password != '' && $user->password != md5(md5($this->password_old)) )
            $this->addError($attribute, 'Mật khẩu cũ không chính xác');
    }
    public function attributeLabels()
    {
        return [
            'password_old' => 'Mật khẩu cũ',
            'password_new' => 'Mật khẩu mới',
            'password_renew' => 'Nhập lại mật khẩu',
        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */

    public function updatePassword()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = Users::findOne(Yii::$app->user->identity->id);
        if( $user ){
            $user->password = md5(md5($this->password_new));
            $user->save(false);
            return true;
        }else{
            return false;
        }
        

    }
   
}
