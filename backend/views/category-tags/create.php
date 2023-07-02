<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = 'Thêm chuyên mục ';
$this->params['breadcrumbs'][] = ['label' => 'Chuyên mục tin tức', 'url' => ['index']];
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
