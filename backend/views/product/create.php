<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */

$this->title = Yii::t('app', 'Thêm');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Danh sách sản phẩm'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="utility-create">
    
    <?= $this->render('_form', [
        'model' => $model,
        'all_category' => [],
        'related_product' => [],
        'all_tag' => []
    ]) ?>

</div>