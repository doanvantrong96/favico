<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?v=1.0',
        'css/notifications/toastr/toastr.css',
        '/assets/global/plugins/select2/select2.css',
        '/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css',
        '/css/default_skin.css',
        '/css/videojs-hls-player.css'
    ];
    public $js = [
        // 'js/mustache.js',
        'js/video.js',
        'js/videojs-http-streaming.js',
        'js/videojs-contrib-quality-levels.min.js',
        'js/videojs-hls-quality-selector.min.js',
        'https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js',
        'js/notifications/toastr/toastr.js',
        '/js/dependency/moment/moment.js',
        '/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js',
        'js/main.js?v=1.0',
        'js/custom_upload_read_video.js?v=1.0'
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
