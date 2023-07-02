<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CoachSection */

$this->title = 'Thêm bài học';
// $this->params['breadcrumbs'][] = ['label' => 'Bài học', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['icon_page'] = 'fa-book';

?>
<div class="course-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
