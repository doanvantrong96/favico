<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = 'Thêm khoá học';
$this->params['breadcrumbs'][] = ['label' => 'Khoá học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['icon_page'] = 'fa-window';

?>
<div class="course-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
