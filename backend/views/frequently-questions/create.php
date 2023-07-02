<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */

$this->title = Yii::t('app', 'Thêm');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Câu hỏi thường gặp'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="utility-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>