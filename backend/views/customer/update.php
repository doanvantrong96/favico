<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CoachSection */

$this->title = 'Cập nhật phần học';
$this->params['breadcrumbs'][] = ['label' => 'Phần học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

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

