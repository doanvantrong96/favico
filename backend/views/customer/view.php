<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\CoachSection */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Khách hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="coach-course-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fullname',
            'email',
            'phone',
            'fb_id',
            'apple_id',
            [
                'label'=>'Ngày đăng ký',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('H:i d/m/Y', strtotime($model->create_date));
                },
            ],
        ],
    ]) ?>

</div>
