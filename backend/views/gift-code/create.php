<?php

use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Thêm';
$this->params['breadcrumbs'][] = ['label' => 'Mã khuyến mại', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['icon_page'] = 'fa-gift';
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
