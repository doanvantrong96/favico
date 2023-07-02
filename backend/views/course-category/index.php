<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách danh mục khoá học';
$controller = Yii::$app->controller->id;
?>
<div class="course-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có danh mục nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> danh mục</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'Tên danh mục',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><b>' . $model['name'] . '</b></p>';
                            return $html;
                        },
                    ],
                    'except',
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($model, $url) use ($controller)  {
                            
                            return '<a title="Xem chi tiết" href="/' . $controller . '/view?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
                        },
                        'update' => function ($model, $url) use ($controller)  {
                            return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                        },
                        'delete' => function ($model, $url) use ( $controller){
                            return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá danh mục này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
                        }
                    ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<style>
.date-create{color:gray}
table.table.table-striped.table-bordered td {
    vertical-align: middle;
}
</style>