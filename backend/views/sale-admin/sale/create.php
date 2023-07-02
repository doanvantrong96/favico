<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */

$this->title = 'Thêm tài khoản';
$this->params['breadcrumbs'][] = 'Sale Admin';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý tài khoản sale', 'url' => ['list-sale']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-update">
    <div class="card mb-g">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
