<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CourseCategory */

$this->title = 'Danh mục ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục khoá học', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Xem chi tiết';
?>
<div class="course-category-view">

    <p>
        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fal fa-edit"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fal fa-trash"></i> Xoá', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'onclick'=> "return confirm('Bạn có chắc chắn muốn xoá danh mục này?')"
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'create_date',
            'slug',
            'except',
            [
                'attribute' => 'is_delete',
                'format'=> 'raw',
                'value' => function($model){
                    return $model->is_delete == 1 ? 'YES' : 'NO';
                }
            ]
        ],
    ]) ?>

</div>
