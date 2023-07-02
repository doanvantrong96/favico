<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\News */

$this->title = 'Cập nhật bài viết';
$this->params['breadcrumbs'][] = ['label' => 'Bài viết', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['icon_page'] = 'fa-newspaper';
?>
<div class="news-update">
    <div class="card mb-g">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'all_category' => $all_category,
                'related_news' => $related_news,
                'all_tag' => $all_tag
            ]) ?>
        </div>
    </div>

</div>
