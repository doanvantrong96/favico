<?php
$db     = require __DIR__ . '/../../common/config/db.php';
$queue  = require __DIR__ . '/../../common/config/queue.php';
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php',
    require(__DIR__ . '/menu.php')
);

return [
    'id' => 'app-backend',
    'name'=>'abe.edu.vn',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','queue'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module'
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1','192.168.33.1'], // adjust this to your needs
            // 'generators' => [
            //     'mongoDbModel' => [
            //         'class' => 'yii\mongodb\gii\model\Generator'
            //     ]
            // ],
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'defaultRoles' => ['guest'],
        ],
        'request' => [
            'csrfParam' => '_csrf-erp',
            'cookieValidationKey' => 'xcALdDW8XEqJYHQVw5fR4cXTN4QEJV',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'queue' => [
            'class' => '\yii\queue\db\Queue',
            'db' => 'db', // DB connection component or its config ss
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => '\yii\mutex\MysqlMutex', // Mutex used to sync queries
            'ttr' => 10 * 60, // Max time for job execution
            'attempts' => 3, // Max number of attempts
        ],
        'db' => $db,
        'queue' => $queue,
        // 'timeZone' => 'Asia/Ho_Chi_Minh', 
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-erp',
            'class' => 'yii\web\Session',
            'cookieParams' => ['httponly' => true, 'lifetime' => 3600*24*30],
            'useCookies' => true,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['pattern'=>'dang-nhap.html', 'route'=>'site/login'],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
                ],
            ],
        ],
    ],
    'as beforeAction' => [
        'class' => 'backend\components\UAccess'
    ],
    'params' => $params,
];
