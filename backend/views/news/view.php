<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\CategoryTags;

/* @var $this yii\web\View */
/* @var $model backend\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Bài viết', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Xem bài viết';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['icon_page'] = 'fa-newspaper';

?>
<style>.news-view img{max-width:100%}</style>
<div class="news-view">
    <p>
        <?= Html::a('<i class="fal fa-plus"></i> Thêm', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fal fa-edit"></i> Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if( $model->status == 1 ){ ?>
        <?= Html::a('<i class="fal fa-eye-slash"></i> Ẩn', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'onclick'=> "return confirm('Bạn có chắc chắn muốn ẩn bài này?')"
        ]) ?>
        <?php }else{ ?>
            <?= Html::a('<i class="fal fa-eye"></i> Hiện', ['show', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'onclick'=> "return confirm('Bạn có chắc chắn muốn hiện bài này?')"
        ]) ?>
        <?php } ?>
    </p>
</div>