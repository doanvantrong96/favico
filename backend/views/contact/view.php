<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Course;
use backend\models\CourseLesson;
/* @var $this yii\web\View */
/* @var $model backend\models\CoachSection */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Khách hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coach-course-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email',
            'phone',
            'province',
            [
                'label'=>'Nguồn đăng ký',
                'format' => 'raw',
                'value' => function ($model) {
                    
                    return '<a class="profile-link" href="'.$model->url.'" target="_blank">'.$model->source.'</a>';
                },
            ],
            'content',            
            [
                'label'=>'Ngày đăng ký',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('H:i d/m/Y', strtotime($model->time));
                },
            ],
        ],
    ]) ?>

</div>
