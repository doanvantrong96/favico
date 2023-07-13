<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chuyên mục'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-tags-view">
    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-edit"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>  
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Ngày tạo',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDateTime($model->create_at, 'php: H:i:s m/d/Y');
                },
            ],
            'slug',
            'description',
            'seo_title',
            'seo_description',
            [
                'label' => 'Trạng thái',
                'value' => function ($model) {
                    return $model->status == 1 ? 'Hiện' : 'Ẩn';
                },
            ],
            
        ],
    ]) ?>

</div>