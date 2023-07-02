<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserCourse */

$this->title = 'Create User Course';
$this->params['breadcrumbs'][] = ['label' => 'User Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
