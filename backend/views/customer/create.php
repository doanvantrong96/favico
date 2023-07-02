<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CoachSection */

$this->title = 'Thêm phần học';
$this->params['breadcrumbs'][] = ['label' => 'Phần học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-create">
    <div class="card mb-g">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
