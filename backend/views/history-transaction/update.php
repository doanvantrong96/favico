<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HistoryTransaction */

$this->title = 'Update History Transaction: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'History Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="history-transaction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
