<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = 'Cập nhật khoá học';
$this->params['breadcrumbs'][] = ['label' => 'Khoá học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs']['icon_page'] = 'fa-window';

?>
<div class="course-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
