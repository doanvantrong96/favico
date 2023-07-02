<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = 'Cập nhật giảng viên';
$this->params['breadcrumbs'][] = ['label' => 'Giảng viên', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs']['icon_page'] = 'fa-user-md';

?>
<div class="course-update">
    <div class="card mb-g">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
