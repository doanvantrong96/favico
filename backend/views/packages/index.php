<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Danh sách gói";
?>

<div class="packages-index">

    <h1><?= $this->title ?></h1>

    <p><?= Html::a('Thêm gói mới', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'package_name',
            'package_price',
            'promotion_price',
            'number',
            'status',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>
</div>
