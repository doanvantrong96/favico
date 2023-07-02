<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CoachSection */

$this->title = 'Cập nhật bài học';
// $this->params['breadcrumbs'][] = ['label' => 'Bài học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

?>
<div class="course-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

