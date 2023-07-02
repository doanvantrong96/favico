<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Course;
use backend\models\CourseSection;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseLesson */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bài học', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = 'Xem video';
$this->params['breadcrumbs']['icon_page'] = 'fa-book';
?>

<link rel="stylesheet" href="/css/default_skin.css" />
<link rel="stylesheet" href="/css/videojs-hls-player.css" />
<div class="coach-course-view">

    <p>
        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fal fa-edit"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fal fa-trash"></i> Xoá', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'onclick'=> "return confirm('Bạn có chắc chắn muốn xoá bài học này?')"
        ]) ?>
    </p>

    <div class="videojs-hls-player-wrapper" id="video_player">
        <video id="video" width="400" height="240" class="video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered ui-min ui-smooth v_5e8494e7ccb30-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-user-inactive">
        <source src="<?= $model->path_file ?>" type="video/mp4" />
        Your browser does not support the video tag.
    </video></div>

</div>
<script src="/js/jquery-1.12.4.js"></script>
<script src="/js/video.js"></script>
<script src="/js/videojs-http-streaming.js"></script>
<script src="/js/videojs-contrib-quality-levels.min.js"></script>
<script src="/js/videojs-hls-quality-selector.min.js"></script>
<script src="/js/custom_upload_read_video.js?v=1"></script>
<style>
.detail-view th{vertical-align: middle;}
</style>