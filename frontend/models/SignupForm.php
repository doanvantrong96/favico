<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $fullname;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            // ['username', 'required','message'=>'{attribute} không được để trống'],
            // ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Tài khoản đã tồn tại.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            
            ['fullname', 'trim'],
            // ['fullname', 'required','message'=>'{attribute} không được để trống'],
            ['fullname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            // ['email', 'required','message'=>'{attribute} không được để trống'],
            ['email', 'email','message'=>'Email không đúng định dạng'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'Email đã tồn tại.'],
            
            ['phone', 'trim'],
            // ['phone', 'required','message'=>'{attribute} không được để trống'],
            ['phone', 'string', 'min' => 10, 'max' => 10],
            ['phone', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'Số điện thoại đã được sử dụng.'],

            ['password', 'required','message'=>'{attribute} không được để trống'],
            ['password', 'string', 'min' => 6],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Tài khoản đăng nhập',
            'password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
            'fullname' => 'Họ và tên',
            
        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */

    public function signup()
    {
        $user = new Users();
        $user->fullname = $this->fullname;
        // $user->username = $this->username;

        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        // $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if( $user->save() ){
            // $this->sendEmail($user);
            Yii::$app->user->login($user, 3600 * 24 * 30 );
            return true;
        }
        return false;;

    }
    public static function update()
    {
        // if (!$this->validate()) {
        //     return null;
        // }
        $user = new Users();
        // $user->username = $this->username;
        $user->fullname = $this->fullname;
        $user->email = $this->email;
        $user->phone = $this->phone;
        // $user->setPassword($this->password);
        // $user->generateAuthKey();
        // $user->generateEmailVerificationToken();
        if( $user->save() ){
            // $this->sendEmail($user);
            // Yii::$app->user->login($user, 3600 * 24 * 30 );
            return true;
        }
        return false;;

    }
    public static function updatePassword()
    {
        // if (!$this->validate()) {
        //     return null;
        // }
        $user = new Users();       
        $user->setPassword($this->password);
        // $user->generateAuthKey();
        // $user->generateEmailVerificationToken();
        if( $user->save() ){
            // $this->sendEmail($user);
            // Yii::$app->user->login($user, 3600 * 24 * 30 );
            return true;
        }
        return false;;

    }
    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public static function sendEmail($user)
    {
        if( $user && !empty($user->email)){
            $link_verify = 'https://' . $_SERVER['SERVER_NAME'] . '/verify-email/' . $user->verification_token;
            
            //Gửi email xác thực
            $fullname    = $user->fullname != '' ? $user->fullname : $user->username;
            if( $fullname == '' )
                $fullname = $user->email;
            $body_mail = '
                <table style="background:#f5f6f7" width="100%" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="width:700px;margin:auto;margin-top:50px;border-radius:7px">
                                    <tbody>
                                        <tr>
                                            <td style="border-top-left-radius:6px;border-top-right-radius:6px;height:80px;background:#2b3636;background-size:300px;background-position:100%;background-repeat:no-repeat;line-height:55px;padding-top:40px;text-align:center;color:#ffffff;display:block!important;margin:0 auto!important;clear:both!important">
                                                <img src="https://yogalunathai.com/resoure/luna.png" height="64" width="64" style="max-width:100%;border-radius:50%;padding:5px" class="CToWUd">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background:#fff;border-bottom-left-radius:6px;border-bottom-right-radius:6px;padding-bottom:40px;margin:0 auto!important;clear:both!important">
                                                <div style="background:#2b3636;color:#ffffff;padding:0px 60px 40px;text-align:center;margin-bottom:40px">
                
                                                    <h1 style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,&quot;Lucida Grande&quot;,sans-serif;margin-bottom:15px;color:#47505e;margin:0px 0 10px;line-height:1.2;font-weight:200;line-height:45px;font-weight:bold;margin-bottom:30px;font-size:28px;line-height:40px;margin-bottom:10px;font-weight:400;color:#ffffff;padding-left:40px;padding-right:40px;padding-top:40px;padding-top:0px">Chào mừng ' . $fullname . '!</h1>
                
                                                    <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;color:#ffffff;opacity:0.8;padding-left:40px;padding-right:40px;margin-bottom:0;padding-bottom:0">Glad to have you on board.</p>
                
                                                </div>
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px">Vui lòng xác nhận tài khoản của bạn bằng cách ấn vào nút bên dưới:</p>
                
                
                
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;text-align:center;padding-left:40px;padding-right:40px"><a href="' . $link_verify . '" style="word-wrap:break-word;color:#09a59a;text-decoration:none;background-color:#09a59a;border:solid #09a59a;line-height:2;max-width:100%;font-size:14px;padding:8px 40px 8px 40px;margin-top:30px;margin-bottom:30px;font-weight:600;display:inline-block;border-radius:30px;margin-left:auto;margin-right:auto;text-align:center;color:#fff!important" target="_blank">Xác nhận Email</a></p>
                
                
                
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px">Sau khi xác nhận, bạn sẽ có quyền truy cập vào Yogalunathai.com bằng tài khoản mới.</p>
                
                
                
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px;margin-bottom:0;padding-bottom:0">Thân mến,<br>Yoga Luna Thái</p>
                
                
                
                                            </td>
                
                                        </tr>
                
                                    </tbody>
                                </table>
                                <div style="padding-top:30px;padding-bottom:55px;width:100%;text-align:center;clear:both!important">
                
                                <p style="font-weight:normal;padding:0;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;font-size:12px;color:#666;margin-top:0px">© Yoga Luna Thái</p>
                
                                </div>
                
                        <br>
                
                    </td>
                
                    </tr>
                
                    </tbody>
                </table>
            ';
            $compose = Yii::$app->mail->compose();
            $compose->setFrom(['account@cogaivangyoga.vn' => 'Yoga Luna Thái'])->setSubject('Xác nhận Tài khoản của Bạn')->setHtmlBody($body_mail);
            // $compose->setTo($user->email);
            $compose->setTo('ngochan9296@gmail.com');
            $r = $compose->send();
            // $compose = Yii::$app->mail->compose();
            // $compose->setFrom(['account@cogaivangyoga.vn' => 'Cogaivangyoga.vn'])->setSubject('Xác nhận Tài khoản của Bạn')->setHtmlBody($body_mail);
            // $compose->setTo($user->email);
            // $r = $compose->send();
        }
        
    }
}
