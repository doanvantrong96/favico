<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */

$this->title = 'Cập nhật';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chuyên mục'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = Yii::t('app', 'Cập nhật');
?>
<div class="utility-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
