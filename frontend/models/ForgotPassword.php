<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

/**
 * Signup form
 */
class ForgotPassword extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required','message'=>'{attribute} không được để trống'],
            ['email', 'checkEmail'],
            ['email', 'email','message'=>'Email không đúng định dạng'],
            ['email', 'string', 'max' => 255],
        ];
    }
    public function checkEmail($attribute, $params)
    {
        $user = Users::findOne(['email'=>$this->email]);
        if( !$user )
            $this->addError($attribute, 'Email không tồn tại');
    }
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            
        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */

    public function forgot()
    {
        if (!$this->validate()) {
            return null;
        }
        $length      = 10;
        $newPassword = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        $user = Users::findOne(['email'=>$this->email]);
        if( $user ){
            $user->password = md5(md5($newPassword));
            $user->save(false);
            // $this->sendEmail($user,$newPassword);
            return true;
        }else{
            return false;
        }
        

    }
   
    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public static function sendEmail($user,$password)
    {
        if( $user && !empty($user->email)){            
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
                
                                                    <h1 style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,&quot;Lucida Grande&quot;,sans-serif;margin-bottom:15px;color:#47505e;margin:0px 0 10px;line-height:1.2;font-weight:200;line-height:45px;font-weight:bold;margin-bottom:30px;font-size:28px;line-height:40px;margin-bottom:10px;font-weight:400;color:#ffffff;padding-left:40px;padding-right:40px;padding-top:40px;padding-top:0px">Chào ' . $fullname . '!</h1>
                
                                                    <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;color:#ffffff;opacity:0.8;padding-left:40px;padding-right:40px;margin-bottom:0;padding-bottom:0">Glad to have you on board.</p>
                
                                                </div>
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px">Dưới đây là mật khẩu đăng nhập mới cho tài khoản của bạn:</p>
                
                
                
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;text-align:center;padding-left:40px;padding-right:40px"><b>' . $password . '</b></p>
                
                
                
                                                <p style="font-weight:normal;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;line-height:1.7;margin-bottom:1.3em;font-size:15px;color:#47505e;padding-left:40px;padding-right:40px">Nếu bạn không gửi yêu cầu này. Vui lòng bỏ qua email này</p>
                
                
                
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
            $compose->setFrom(['account@yogalunathai.com' => 'Yoga Luna Thái'])->setSubject('Quên mật khẩu')->setHtmlBody($body_mail);
            $compose->setTo($user->email);
            $r = $compose->send();

        }
        
    }
}
