<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
    //     'formatter' => [
    //         'dateFormat' => 'YYYY-MM-DD HH:mm:ss',
    //         'decimalSeparator' => ',',
    //         'thousandSeparator' => ' ',
    //         'currencyCode' => 'EUR',
    //    ]
    ],
];
