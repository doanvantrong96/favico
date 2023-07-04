<?php
$db     = require __DIR__ . '/../../common/config/db.php';
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php',
    require(__DIR__ . '/menu.php')
);

return [
    'id' => 'app-frontend',
    'name'=>'Frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
       
    ],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1637958006659754',
                    'clientSecret' => '96c8ca607a4fa49e3fe1da82008767a2',
                    'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
                    'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js'=>[]
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => 'xcALdDW8XEqJYHQVw5fR4cXTN4QEJV',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'db' => $db,
        'user' => [
            'identityClass' => 'common\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'mail.abe.edu.vn',
            'username' => 'support@abe.edu.vn',
            'password' => '3M@ail63cf647caa',
            'port' => '465',
            'encryption' => 'ssl',
            'streamOptions' => [
            'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
            ],
            ]
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/'                => '/site/index',
                'dang-ky' =>'/site/signup',
                'dang-nhap' =>'/site/login',
                'dang-xuat' => '/site/logout',
                'tim-kiem' => 'product/search',
                'tai-khoan' => '/user/index',
                'khoi-phuc-mat-khau' => 'site/reset-password',
                'chi-tiet-khoa-hoc/<slug_detail>' => '/course/index',
                'tong-quan-lop-hoc/<slug_course>' => '/course/course-overview',
                'danh-muc-khoa-hoc/<slug>' => '/category/index',
                'danh-muc-khoa-hoc' => '/category/index',   
                'chuyen-gia' => '/lecturers/index',
                'chuyen-gia/<slug>' => '/lecturers/detail',
                'thanh-toan-buoc-2' => '/site/final-payment',
                'thanh-toan' => '/site/payment',
                'cai-dat' => '/site/info-user',
                'about'=>'/site/about',
                'tien-trinh-cua-toi'=>'/site/my-progress',
                'payment/VnpayCreatePayment'    => 'payments/vnpay-create-payment',
                'payments/VnpayIpn'    => 'payments/vnpay-ipn',
                'payments/VnpayReturn'    => 'payments/vnpay-return',
                '<slug>-<id>' => '/category/index-news',




                // 'tin-tuc/<slug>/<id>' => '/news/index',
                // 'tin-tuc/<slug>' => '/news/detail',
                // 'tin-tuc' => '/news/index',
                // 'video/view/<vid>' => '/video/view',

                // 'quen-mat-khau' =>'/site/forgot-password',
                // 'auth' =>'/site/auth',
                // // 'fanpage/<type>' => '/support/perlink',
                // 'fanpage' => '/support/fb',
                // 'instagram' => '/support/insta',
                // 'youtube' => '/support/youtube',
                // 'group' => '/support/group',
                // 'verify-email/<token>'  => '/site/verify-email',
                // 'khoa-hoc-cua-toi' => '/user/mycourse',
                // 'doi-mat-khau' => '/user/change-password',
                // 'khoa-hoc-offline' => '/courseoffline/index',
                // 'khoa-hoc/video-<id>' => '/product/video',
                // 'doi-ngu-giao-vien/'=>'/site/teachers',
                // 'hinh-anh'=>'/site/images',
                // 'lien-he'=>'/support/lienhe',
                // 'he-thong-co-so'=>'/support/listclass',
                // 'chinh-sach-bao-mat'=>'/support/chinhsach',
                // 'qua-tang'=>'/site/gift',
                // 'khoa-hoc/chu-de/<slug>' => '/product/index',
                // 'khoa-hoc' => '/product/index',
                // 'chi-tiet-khoa-hoc/<slug>/<slug_lesson>' => '/product/detail',
                // 'chi-tiet-khoa-hoc/<slug>' => '/product/detail',
                // 'noi-dung-khoa' => '/product/block-content',
                // 'lien-he' => 'site/contact',
                // 'dieu-khoan-su-dung-dich-vu' => 'site/terms',
                // 'chinh-sach-bao-mat' => 'site/privacy-policy',
                // 'chinh-sach-doi-tra-va-hoan-lai-tien' => 'site/refund',
                // 'profile' => 'user/index',
                // 'danh-gia' => 'product/rating',


                // '<alias>' => '/courseoffline/detail',

                
                
                
            ],
        ],
        
    ],
    'as beforeAction' => [
        'class' => 'frontend\components\UAccess'
    ],
    'params' => $params,
];
