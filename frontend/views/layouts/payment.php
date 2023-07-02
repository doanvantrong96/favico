<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="https://bmggroup.vn/xmlrpc.php"> -->
	<script src="./resoure/sdk.js" async="" crossorigin="anonymous"></script>
	<title>Trang chu cogaivang.vn – Thanh toán</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="dns-prefetch" href="https://fonts.googleapis.com/">
	<link rel="dns-prefetch" href="https://s.w.org/">
	
	<link rel="stylesheet" id="dashicons-css" href="./resoure/dashicons.min.css" type="text/css" media="all">
	<link rel="stylesheet" id="admin-bar-css" href="./resoure/admin-bar.min.css" type="text/css" media="all">
	<link rel="stylesheet" id="contact-form-7-css" href="./resoure/styles.css" type="text/css" media="all">
	<link rel="stylesheet" id="wordfenceAJAXcss-css" href="./resoure/wordfenceBox.1581523568.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="flatsome-icons-css" href="./resoure/fl-icons.css" type="text/css" media="all">
	<link rel="stylesheet" id="flatsome-main-css" href="./resoure/flatsome.css" type="text/css" media="all">
	<link rel="stylesheet" id="flatsome-style-css" href="./resoure/style.css" type="text/css" media="all">
	<link rel="stylesheet" id="hoanggia-style-css" href="./resoure/style(1).css" type="text/css" media="all">
	<link rel="stylesheet" id="hoanggia-child-style-css" href="./resoure/style(2).css" type="text/css" media="all">
	<link rel="stylesheet" id="flatsome-googlefonts-css" href="./resoure/css" type="text/css" media="all">
	<script type="text/javascript" src="./resoure/jquery.js"></script>
	<script type="text/javascript" src="./resoure/jquery-migrate.min.js"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
		var WFAJAXWatcherVars = { "nonce": "8896eb46a9" };
/* ]]> */
	</script>
	<script type="text/javascript" src="./resoure/admin.ajaxWatcher.1581523568.js"></script>
    <style id="custom-css" type="text/css">
		.footer{background-color:#fff;text-align:center}
        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        .wrap > .container{padding-top:20px}
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }
        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }
        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }
        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }
	</style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

</style>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
