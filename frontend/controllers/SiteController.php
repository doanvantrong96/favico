<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Users;
use backend\models\Course;
use backend\models\CoachCourse;
use backend\models\CourseLesson;
use backend\models\CourseCategory;
use common\models\Order;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ForgotPassword;
use frontend\models\ContactForm;
use yii\data\ArrayDataProvider;
use backend\models\News;
use frontend\models\Contact;

use backend\models\Banner;
use backend\models\Lecturer;
use backend\models\Partner;
use backend\models\StudentStory;
use backend\models\FrequentlyQuestions;
use backend\models\OrderCart;
use backend\models\OrderCartProduct;
use backend\models\UserCourse;
use backend\models\CourseLessonActive;
use backend\models\CourseLessonNote;
use backend\models\FavoriteCourse;
use backend\models\ContinueLesson;
use backend\models\GiftCode;
use backend\models\UserRegisterEmail;
use backend\models\CommunityStory;
use backend\models\UserLogin;
use backend\models\FrequentlyQuestionsGroup;
use frontend\controllers\PaymentsController;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    // [
                    //     'actions' => ['signup'],
                    //     'allow' => true,
                    //     'roles' => ['?'],
                    // ],
                    [
                        'actions' => ['logout','historyOrder'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthFb'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function oAuthFb($client)
    {
        try {
            $userAttributes = $client->getUserAttributes();
            if (is_array($userAttributes) && $userAttributes) {
                /*
                * Check có tài khoản hay chưa bằng fb_id
                */
                // $model = new UsersLoginForm();
                $fullname   = '';
                $email      = '';
                
                $email      = isset($userAttributes['email']) ? $userAttributes['email'] : '';
                $fullname   = $userAttributes['name'];
                $fb_id      = $userAttributes['id'];
                $app_access_token = "1637958006659754|NThZ9F49ZlHR_7WvYucvwFdel_8";
                $avatar      = "https://graph.facebook.com/". $fb_id ."/picture?type=large&access_token=" . $app_access_token;
                //Kiểm tra xem id fb đã tồn tại chưa: Nếu có thì login / Tạo tài khoản mới
                $checkExist = Users::findOne(['fb_id'=>$fb_id]);
                if( !$checkExist && !empty($email) ){
                    $checkExist = Users::findOne(['email'=>$email]);
                }

                if( $checkExist ){
                    $checkExist->fb_id = $fb_id;
                    $checkExist->save(false);
                    $user           = $checkExist;
                }else{
                    $user           = new Users();
                    $user->fullname = $fullname;
                    $user->email    = $email;
                    $user->fb_id    = $fb_id;
                    $user->avatar   = $avatar;
                    // $user->generateEmailVerificationToken();
                    $user->save(false);
                    // if( !empty($email) ){
                    //     SignupForm::sendEmail($user);
                    // }
                }
                Yii::$app->user->login($user, 3600 * 24 * 30 );
                return $this->goHome();
            } else {
                
            }
            return $this->goHome();
        } catch (\Exception $e) {
            var_dump($e);die;
        }
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->title = 'favico';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'ABE Academy cung cấp các khoá học trực tuyến được tạo cho sinh viên ở mọi cấp độ kỹ năng. Chuyên gia hướng dẫn tốt nhất Việt Nam.'
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => '/images/page/logo.png'
        ]);
       Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'prefix' => 'og: http://ogp.me/ns#',
            'content' => "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
        ]);
        

       
        return $this->render('index',[
            
        ]);
    }



    public function actionCreateStory(){
        if(!empty($_POST)){
            $address = $_POST['address'];
            $content = $_POST['content'];
            $expert_name = $_POST['expert_name'];
            $file_name = NULL;
            
            if (!empty($_FILES['images'])) {
                $file_name = $this->actionUploadFileAuthor($_FILES['images']);
            }
            $model = new CommunityStory();
            $model->user_id = Yii::$app->user->identity->id;
            $model->fullname = Yii::$app->user->identity->fullname;
            $model->email = Yii::$app->user->identity->email;
            $model->address = $address;
            $model->content = $content;
            $model->image = $file_name;
            $model->expert_name = $expert_name;
            $model->file_path = $file_name;
            $model->save(false);
            echo 1;
            exit;
        }
    }

    public function actionUploadFileAuthor($files)
    {
        if (!empty($files)) {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            // Create directory if it does not exist
            if (!is_dir("uploads/image-story/")) {
                mkdir("uploads/image-story/");
            }
            if (!is_dir("uploads/image-story/" . $year . "/")) {
                mkdir("uploads/image-story/" . $year . "/");
            }
            if (!is_dir("uploads/image-story/" . $year . "/" . $month . "/")) {
                mkdir("uploads/image-story/" . $year . "/" . $month . "/");
            }
            if (!is_dir("uploads/image-story/" . $year . "/" . $month . "/" . $day . "/")) {
                mkdir("uploads/image-story/" . $year . "/" . $month . "/" . $day . "/");
            }
            // foreach($files as $file) {
            for ($i = 0; $i < count($files['name']); $i++) {
                $temp = explode(".", $files["name"][$i]);
                $newfilename = date('H-i-s-') . rand() . '.' . end($temp);
                $link_img = "/uploads/image-story/" . $year . "/" . $month . "/" . $day . "/" . $newfilename;
                move_uploaded_file($files["tmp_name"][$i], "uploads/image-story/" . $year . "/" . $month . "/" . $day . "/" . $newfilename);

                return $link_img;
            }
        }
    }
    public function actionAbout(){
        $this->view->title = 'Phavico';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => ''
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'image',
        ]);
        return $this->render('about');
    }
    public function actionPlan(){
        return $this->render('plan');
    }
    // public function beforeAction($action)
    // {
    //     $referrer = Yii::$app->request->referrer ? Yii::$app->request->referrer : null;
    //     if ( !Yii::$app->user->identity && $referrer && strpos($referrer,'login') === false && strpos($referrer,'signup') === false) {
    //         $url_access = Yii::$app->request->referrer;

    //         Yii::$app->session->set('url_access', $url_access);
    //     }
    //     return parent::beforeAction($action);
    // }
    
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$model->validate()) {
                foreach($model->getErrors() as $row){
                    return [
                        'status' => 0,
                        'message' => $row['0']
                    ];
                    break;
                }
            }
            $user = Users::findOne(['email' => $model->username]);
            if($user['date_banned'] != null){
                $date_curren = strtotime(date("Y/m/d H:i:s"));
                $time_banner = strtotime($user['date_banned']);
                if($time_banner > $date_curren)
                    return [
                        'status' => 0,
                        'message' => 'Tài khoản của bạn đang bị khóa'
                    ];

            }

            if( $model->login() ){
                $resultCheck = $this->checkLogin();
                if( $resultCheck ){
                    return [
                        'status' => 1,
                        'message' => "Success"
                    ];
                }else{
                    return [
                        'status' => 0,
                        'message' => 'Đăng nhập không thành công! </br> Nguyên Nhân: Vượt quá số lượng thiết bị cho phép'
                    ];
                }
            }
            else
                return [
                    'status' => 0,
                    'message' => 'Thông tin đăng nhập không chính xác'
                ];
        } else {
            $model->password = '';

            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }
    }

    private function checkLogin(){
        if (!Yii::$app->user->isGuest) {
            $user       = Yii::$app->user->identity;
            $maxLogin   = 3;//Yii::$app->params['max_login'];
            $totalLoginPlace = UserLogin::find()->where(['user_id'=>$user->id,'status'=>0])->count();
            $user_login = UserLogin::find()->where(['user_id'=>$user->id,'status'=>0])->asArray()->all();
            $list_ip = array_column($user_login,'ip_address');
            $ip_current = $_SERVER['REMOTE_ADDR'];
            $modelUser  = Users::findOne(['id'=>$user->id]);
            if(in_array($ip_current,$list_ip)){
                return true;
            }
            //Check total login place with config params
            if( $totalLoginPlace < $maxLogin ){
                // $browser        = get_browser(null, true);
                $ip_address     = $_SERVER['REMOTE_ADDR'];
                $user_agent     = $_SERVER['HTTP_USER_AGENT'];
                $os             = NULL;//$browser['platform'];
                $browser_name   = NULL;//$browser['browser'];
                $version        = NULL;//str_replace('.0','',$browser['version']);
                // if( $version == 0 || strpos($user_agent,'coc_coc_browser') !== false ){
                //     $dataUg     = explode(' ', $user_agent);
                //     foreach($dataUg as $r){
                //         if( strpos($r,'coc_coc_browser') !== false ){
                //             $version = str_replace('coc_coc_browser/','', $r);
                //             break;
                //         }
                //     }
                // }
                $device         = NULL;//$browser['device_type'] == 'Desktop' ? 'PC' : 'Mobile';
                $checkIpExits   = UserLogin::find()->where(['user_id'=>$user->id,'user_agent'=>$user_agent, 'ip_address' => $ip_address, 'is_revoke'=>0])->one();
                if( !$checkIpExits ){
                    $model      = new UserLogin;
                    $model->user_id     = $user->id;
                    $model->time_login  = date('Y-m-d H:i:s');
                    $model->os          = $os;
                    $model->browser     = $browser_name;
                    $model->version     = $version;
                    $model->user_agent  = $user_agent;
                    $model->device      = $device;
                    $model->ip_address  = $ip_address;
                    $model->token       = md5($user_agent . $ip_address . $user->id);
                    $model->save(false);
                    $totalLoginPlace++;

                    Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'tklgusf',
                        'value' => $model->token,
                        'expire' => time() + 86400 * 30,
                    ]));
                    if( $totalLoginPlace == $maxLogin ){
                        //Send email warning
    
                    }
                }else{
                    if( $modelUser->status == 1 ){
                        $modelUser->time_login  = date('Y-m-d H:i:s');
                        $modelUser->ip_address  = $ip_address;
                        $modelUser->status = 0;
                        $modelUser->save(false);
                    }
                }
                
                return true;
            }else{
                //Lock account
                $modelUser->status = 3;
                $modelUser->save(false);

                Yii::$app->user->logout();

                Yii::$app->session->setFlash('error', 'Bạn đã đăng nhập đối đa 3 thiết bị. Vui lòng đăng xuất ở thiết bị khác trước khi đăng nhập.');

                return false;
            }
        }
        
        return true;
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $user       = Yii::$app->user->identity;
        $modelUser  = Users::findOne(['id'=>$user->id]);
        $ip_current = $_SERVER['REMOTE_ADDR']; 
        // $browser        = get_browser(null, true);
        $os             = NULL;//$browser['platform'];
        $browser_name   = NULL;//$browser['browser'];
        $user_login = UserLogin::find()->where(['user_id'=>$modelUser->id,'status'=>0,'browser' => $browser_name, 'os' => $os])->asArray()->all();
        if(!empty($user_login)){
            foreach($user_login as $item){
                $model = UserLogin::findOne($item['id']);
                $model->delete();
            }
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    /*
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) ) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$model->validate()) {
                foreach($model->getErrors() as $row){
                    return [
                        'status' => 0,
                        'message' => $row['0']
                    ];
                    break;
                }
            }
            if($model->signup()){
                // Yii::$app
                // ->mail
                // ->compose()
                // ->setFrom(['support@elearning.abe.edu.vn' => 'ABE Academy'])
                // ->setTo($model->email)
                // ->setSubject('Đăng ký tài khoản thành công')
                // ->setHtmlBody('<p>Chúc mừng bạn đã đăng ký tài khoản thành công</p>')
                // ->send();
                return [
                    'status' => 1,
                    'message' => "Success"
                ];
            }
            else
                return [
                    'status' => 0,
                    'message' => 'Có lỗi xảy ra. Vui lòng thử lại'
                ];
        }

        return $this->renderAjax('signup', [
            'model' => $model,
        ]);
    }
    /*
     * Update user up.
     *
     * @return mixed
     */
    public function actionUpdatephone()
    {
        $models = new SignupForm();
        if(isset($_POST['phone'])){
            $model = Users::findOne(['id' => Yii::$app->user->identity->id]);
            $model_check = Users::findOne(['phone' => $_POST['phone']]);
            if(empty($model_check)){
                $model->phone = $_POST['phone'];
                $model->save(false);
                return 1;
            }else{
                return 2;
            }
       
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotPassword();
        if ($model->load(Yii::$app->request->post()) ) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$model->validate()) {
                foreach($model->getErrors() as $row){
                    return [
                        'status' => 0,
                        'message' => $row['0']
                    ];
                    break;
                }
            }
            if( $model->forgot() )
                return [
                    'status' => 1,
                    'message'=> 'Yêu cầu khôi phục mật khẩu thành công. Mật khẩu mới đã được gửi vào email của bạn'
                ];
            else
                return [
                    'status' => 0,
                    'message' => 'Có lỗi xảy ra. Vui lòng thử lại'
                ];          
        }
        return $this->renderAjax('forgot_password', [
            'model' => $model,
        ]);
        
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        if(empty($token) || !Yii::$app->user->isGuest){
            return $this->goHome();
        }
        if(isset($_POST['password']) && !empty($_POST['password'])){
            $model = Users::find()
            ->where(['verification_token' => $token]) 
            ->one();
            $pass = $_POST['password'];
            $model->password = md5(md5($pass));
            $model->save(false);
            return $this->goHome();
        }
        return $this->render('resetPassword', [
        ]);
    }

    public function actionMailResetpass(){
            $session = Yii::$app->session;
            if (!$session->has('check_sendmail') && isset($_POST['email'])){
                $email = $_POST['email'];
                $user = Users::findOne(['email' => $email]);
                if(!empty($user)){
                    $host = 'https://' . $_SERVER['HTTP_HOST'];
                    $verification_token = $user['verification_token'];
                    Yii::$app
                        ->mail
                        ->compose()
                        ->setFrom(['support@elearning.abe.edu.vn' => 'ABE Academy'])
                        ->setTo($email)
                        ->setSubject('Reset Mật khẩu')
                        ->setHtmlBody('<div style="padding:15px 20px;border: 1px solid #707070;margin: 0px auto;max-width: 800px;font-size: 16px;font-family: roboto;text-align:left">
                                            <div style="background-color: #191c21;text-align: left;"><img style="width: 150px;" src="https://elearning.abe.edu.vn/images/page/logo.svg" alt=""></div>
                                            <h1 style="font-size:24px;margin-bottom:10px">THAY ĐỔI MẬT KHẨU</h1>
                                            <h4>Xin chào bạn</h4>
                                            <p style="margin-bottom:10px">Bạn đã yêu cầu phục hồi lại mật khẩu trên website <a href="http://elearning.abe.edu.vn/">elearning.abe.edu.vn</a>. Nếu bạn không có yêu cầu hoặc có sự nhầm lẫn nào thì bạn có thể bỏ qua email này.</p>
                                            <p style="margin-bottom:10px">Bấm vào nút bên dưới để xác nhận và nhập mật khẩu mới</p>
                                            <a style="margin-bottom:10px;margin-bottom: 10px;background: red;color: #fff;padding: 10px;display: inline-block;border-radius: 5px;text-transform: uppercase;" href="'. $host .'/khoi-phuc-mat-khau?token='. $verification_token .'">Đặt lại mật khẩu</a>
                                            <p style="font-weight:bold">ABE Academy</p>
                                        </div>')
                        ->send();
    
                        $session->set('check_sendmail', '1');
                        echo 1;die;
                }else{
                    echo 3;die;
                }
            }else{
                echo 2;die;
            }         
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        $model     = Users::findOne(['verification_token'=>$token]);
        if( $model ){
            $model->is_verify_account = 1;
            $model->verification_token= '';
            $model->date_verify_email = date('Y-m-d H:i:s');
            $model->save(false);

            Yii::$app->session->setFlash('success', 'Xác thực tài khoản thành công');
        }
        
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    public function actionRegisterfree(){
        if (!Yii::$app->user->isGuest) {
            $this->redirect('/product/index');
        }else{
            $this->redirect('/site/signup');
        }
    }

    public function actionTerms(){
        return $this->render('terms',[
        ]);
    }

    public function actionPrivacyPolicy(){
        return $this->render('privacy_policy');
    }
    public function actionRefund(){
        return $this->render('refund');
    }
    /**
    * Function xử lý push log lượt xem bài viết, chuyên mục
    */
    public function actionTracking(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if( $request->isPost ){
            $params_post = $request->post();
            $params      = $this->validateParamsLog($params_post);
            if( is_array($params) ){
                $params_push_queue = [
                    'id'            => (int)$params['tracking_id'],
                    'type'          => (int)$params['tracking_type'],
                    'date'          => date('Y-m-d H:i:s'),
                    'session_id'    => $params['session'],
                    'user_agent'    => $params['user_agent'],
                    'ip_address'    => $params['ip_address'],
                    'url'           => $params['url'],
                    'user_id'       => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : 0
                ];
                
                Yii::$app->queue->push(new \backend\components\ProcessLogView($params_push_queue));
            }
        }
        exit();
    }

    private function validateParamsLog($arrData){
        $ip_address        = \backend\controllers\CommonController::getAgentIp();
        $ipBlackList       = Yii::$app->params['ip_blacklist'];
        if( !in_array($_SERVER['REMOTE_ADDR'], $ipBlackList) && Yii::$app->getRequest()->validateCsrfToken() && isset($arrData['url']) && !empty($arrData['url']) && isset($arrData['data']) && !empty($arrData['data']) ){
            $str_params = \backend\controllers\CommonController::encryptDecrypt($arrData['data'], 'decrypt');
            if( strpos($str_params, '#_#') !== false ){
                $arrParams = explode('#_#', $str_params);
                $params    = ['url' => $arrData['url'], 'ip_address' => $ip_address];
                $time_expire = 0;
                if( count($arrParams) >= 6 ){
                    foreach($arrParams as $key=>$value){
                        switch($key){
                            case 0:
                                $params['session'] = $value;
                                break;
                            case 1:
                                $params['tracking_id'] = (int)$value;
                                break;
                            case 2:
                                $params['tracking_type'] = (int)$value;
                                break;
                            case 3:
                                if( !empty($value) && $value != 'NA' )
                                    $params['cate_id'] = $value;
                                break;
                            case 4:
                                $params['user_agent'] = $value;
                                break;
                            case 5:
                                $time_expire = (int)$value;
                                break;
                        }
                    }
                }
                $session_check = Yii::$app->session->getId();
                $time_current  = time();
                $listTypeValid = [ProcessLogView::TYPE_NEWS, ProcessLogView::TYPE_COURSE];
                $user_agent_check = $_SERVER['HTTP_USER_AGENT'];
                
                if( $time_expire >= $time_current && isset($params['tracking_id']) && !empty($params['tracking_id']) && isset($params['tracking_type']) && in_array($params['tracking_type'], $listTypeValid) && isset($params['user_agent']) && $params['user_agent'] == $user_agent_check && isset($params['session']) && $params['session'] == $session_check ){
                    return $params;
                }
            }
        }
        return false;
    }
}
