<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\News */

$this->title = 'Viết bài mới';
$this->params['breadcrumbs'][] = ['label' => 'Bài viết', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['icon_page'] = 'fa-newspaper';

?>
<div class="course-create">
    <div class="card mb-g">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'all_category' => [],
                'related_news' => [],
                'all_tag' => []
            ]) ?>
        </div>
    </div>
</div>