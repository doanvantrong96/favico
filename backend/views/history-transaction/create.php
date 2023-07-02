<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HistoryTransaction */

$this->title = 'Create History Transaction';
$this->params['breadcrumbs'][] = ['label' => 'History Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-transaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
