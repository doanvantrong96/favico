<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CoachCourse */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Giảng viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['icon_page'] = 'fa-user-md';

?>
<div class="coach-course-view">

    <p>
        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fal fa-edit"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fal fa-trash"></i> Xoá', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'onclick'=> "return confirm('Bạn có chắc chắn muốn xoá giảng viên này?')"
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Ảnh đại diện',
                'format' =>  'raw',
                'value' => function ($model) {
                    $r = ($model->avatar != "" ? '<img style="max-height: 200px;" src="'.$model->avatar.'" alt="" />' : '');
                    return $r;
                }
            ],
            [
                'label' => 'Ảnh banner',
                'format' =>  'raw',
                'value' => function ($model) {
                    $r = ($model->cover != "" ? '<img style="max-width: 100%; max-height: 200px;" src="'.$model->cover.'" alt="" />' : '');
                    return $r;
                }
            ],
            'name',
            [
                'attribute' => 'description',
                'format' =>  'raw',
                'value' => function ($model) {
                    return '<p style="white-space: pre-line;">' . $model->description  . '</p>';
                },
                'contentOptions'=>['style'=>'width:85%']
            ],
            'office',
            'level',
            [
                'label'=>'Trạng thái',
                'format' => 'raw',
                'value' => function ($model) {
                    return \backend\controllers\CommonController::getStatusName($model->status);
                },
            ], 
            [
                'label'=>'Video trailer',
                'format' => 'raw',
                'value' => function ($model) {
                    if( !empty($model->trailer) ){
                       
                        return '<div class="videojs-hls-player-wrapper" style="max-width:450px" id="video_player">
                            <video id="video" width="400" height="240" class="video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered ui-min ui-smooth v_5e8494e7ccb30-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-user-inactive">
                                <source src="' . $model->trailer . '" type="video/mp4" />
                                Your browser does not support the video tag.
                            </video></div>';
                    }
                    return 'Chưa có video';
                },
            ],    
        ],
    ]) ?>

</div>
