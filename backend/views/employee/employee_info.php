<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */

$this->title = 'Thông tin tài khoản';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="employee-info">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'fullname',
            [
                'attribute' => 'email',
                'value' => function($model){
                    if(  $model->email )
                        return $model->email;
                    return '---';
                }
            ],
            [
                'attribute' => 'phone',
                'value' => function($model){
                    if(  $model->phone )
                        return $model->phone;
                    return '---';
                }
            ],
            [
                'attribute' => 'create_date',
                'value' => function($model){
                    if(  $model->create_date )
                        return date('H:i d/m/Y', $model->create_date);
                    return '---';
                }
            ]
        ],
    ]) ?>
    <p>
        <?= Html::a('Đổi mật khẩu', ['change-password'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
