<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Chuyên mục & tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coach-course-view">

    <p>
        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fal fa-edit"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fal fa-trash"></i> Xoá', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'onclick'=> "return confirm('Bạn có chắc chắn muốn xoá chuyên mục, tags này?')"
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            array(
                'label'=>'Loại',
                'value' => function ($data) {
                    if($data->type == 0){
                        return 'Chuyên mục';
                    }
                    else {
                        return 'Tags';
                    }
                },
            ),
            'name',
            [
                'label' => 'Ngày tạo',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDateTime($model->create_date, 'php: H:i:s m/d/Y');
                },
            ],
            'slug',
            'except',
            'title_seo',
        ],
    ]) ?>

</div>