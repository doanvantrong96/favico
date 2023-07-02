<?php
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '2G');
ini_set('post_max_size', '2G');
ini_set('max_execution_time', 1800);
ini_set('max_input_time', 300);
date_default_timezone_set('Asia/Saigon');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../config/main.php')
);

(new yii\web\Application($config))->run();
