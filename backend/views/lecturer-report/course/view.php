<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Category;
use backend\models\Lecturer;
use backend\models\CourseLesson;
use backend\controllers\CommonController;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = 'Khoá học ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Khoá học', 'url' => ['list-course']];
$this->params['breadcrumbs'][] = 'Xem chi tiết';
$this->params['breadcrumbs']['icon_page'] = 'fa-window';

$listLesson   = CourseLesson::getListLesson($model->id);
?>
<div class="course-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Ảnh',
                'format' =>  'raw',
                'value' => function ($model) {
                    $r = ($model->avatar != "" ? '<img height="100em" src="'.$model->avatar.'" alt="" />' : '');
                    return $r;
                }
            ],
            'name',
            [
                'label' => 'Phôi ảnh chứng chỉ',
                'format' =>  'raw',
                'value' => function ($model) {
                    $r = ($model->certificate != "" ? '<img height="100px" src="'.$model->certificate.'" alt="" />' : '');
                    return $r;
                }
            ],
            [
                'label'=>'Danh mục',
                'format' => 'raw',
                'value' => function ($model) {
                    if( !empty($model->category_id) ){
                        $arrCateId = array_filter(explode(';',$model->category_id));
                        $resultCate= Category::find()->where(['status' => 1, 'is_delete' => 0 ])->andWhere(['in', 'id', $arrCateId])->all();
                        if( !empty($resultCate) ){
                            return implode(', ', \yii\helpers\ArrayHelper::map($resultCate, 'name', 'name'));
                        }
                    }
                    return 'N/A';
                },
            ],
            [
                'label'=>'Tài liệu',
                'format' => 'raw',
                'value' => function ($model) {
                    $documents       = $model->document ? json_decode($model->document, true) : [];
                    $html = '';
                    if( !empty($documents) ){
                        foreach($documents as $doc_id => $doc){
                            $link    = !empty($doc['link']) ? $doc['link'] : $doc['file_link'];
                            $html .= '<p style="margin-bottom:0">- <a href="' . $link . '" target="_blank">' . $doc['name'] . '</a></p>';
                        }
                        return $html;
                    }
                    return 'Chưa cập nhật';
                },
            ],
            [
                'label'=>'Hướng dẫn học',
                'format' => 'raw',
                'value' => function ($model) {
                    $guides       = $model->study_guide ? json_decode($model->study_guide, true) : [];
                    $html = '';
                    if( !empty($guides) ){
                        foreach($guides as $guide){
                            $link    = !empty($guide['link']) ? $guide['link'] : $guide['file_link'];
                            $html .= '<p style="margin-bottom:0">- <a href="' . $link . '" target="_blank">' . $guide['name'] . '</a></p>';
                        }
                        return $html;
                    }
                    return 'Chưa cập nhật';
                },
            ],
            'create_date',
            [
                'attribute' => 'description',
                'format'=> 'raw',
                'contentOptions'=>['style'=>'width:82%']
            ],
            'total_lessons',
            [
                'attribute' => 'price',
                'format'=> 'raw',
                'value' => function($model){
                    $html = '';
                    if( $model['price'] <= 0 ){
                        $html = 'Miễn phí';
                    }else{
                        if( $model->price > 0 ){
                            if( $model->promotional_price > 0 )
                                $html = '<span data-toggle="tooltip" data-placement="bottom" title="Giá khuyến mại">' . number_format($model->promotional_price,0,',',',') . '</span> (<span data-toggle="tooltip" data-placement="bottom" style="text-decoration: line-through;" title="Giá gốc">' . number_format($model->price,0,',',',') . '</span>)';
                            else
                                $html = number_format($model->price,0,',',',');
                        }
                    }
                    
                    return $html;
                }
            ],
            [
                'attribute' => 'status',
                'format'=> 'raw',
                'value' => function($model){
                    return \backend\controllers\CommonController::getStatusName($model->status);
                }
            ],
            [
                'label'=>'Video trailer',
                'format' => 'raw',
                'value' => function ($model) {
                    if( !empty($model->trailer) ){
                       
                        return '<div class="videojs-hls-player-wrapper" id="video_player">
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

    <div class="panel">
        <div class="panel-hdr">
            <h2>
                Danh sách bài học <?= $model->total_lessons > 0 ? '(' . $model->total_lessons . ' bài)' : '' ?>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed minus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Thu gọn"><i class="fal fa-minus" style="color: #fff; position: relative; top: -2px;"></i></button>
                <button class="btn btn-panel waves-effect waves-themed plus" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Mở rộng"><i class="fal fa-plus" style="color: #fff; position: relative; top: -2px;"></i></button>
            </div>
        </div>
        <div class="panel-container">
            <div class="panel-content content-lesson">
                <?php 
                    if( !empty($listLesson) ){
                        foreach($listLesson as $lesson){
                ?>
                    <div class="form-group field-lesson-question" data-id="<?= $lesson->id ?>">
                        <div class="row align-items-center">
                            <div class="col-lg-12" style="margin:0">
                                <a href="view-lesson?id=<?= $lesson->id ?>" target="_blank"><b id="lesson_name_<?= $lesson->id ?>"><?= $lesson->name ?></b></a>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }else{
                        echo '<p class="text-center">Chưa có bài học nào</p>';
                    }
                ?>
            </div>
        </div>
    </div>

</div>
<style>
    .field-lesson-question,.field-document,.field-guide{
        border: 1px dashed #ccc;
        padding: 15px;
        position: relative;
    }
    .field-lesson-question > .row,.field-document > .row,.field-guide > .row{
        position: relative;
    }
    .field-lesson-question .panel-toolbar,.field-document .panel-toolbar,.field-guide .panel-toolbar{
        position: absolute;
        right: 15px;
        top: 0;
    }
    @media (max-width: 768px) {
        #modal-form .modal-dialog{
            max-width: 95% !important;
        }
    }
</style>