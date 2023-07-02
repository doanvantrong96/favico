<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoachCourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Giảng viên';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách giảng viên';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-user-md';
?>

<div class="course-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có giảng viên nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> giảng viên</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'Ảnh',
                        'format' => 'raw',
                        'attribute' => 'avatar',
                        'value' => function ($model) {
                            if( !empty($model['avatar']) )
                                return '<img src="' . $model['avatar'] . '" width="100" height="100" style="object-fit: cover;" />';
                            return '';
                        },
                    ],
                    [
                        'label'=>'Tên giảng viên',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><b>' . $model['name'] . '</b></p>';
                            return $html;
                        },
                    ],
                    [
                        'label'=>'Chức danh',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->office;
                        },
                    ],
                    'position',
                    [
                        'label'=>'Ngày thêm',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('H:i d/m/Y', strtotime($model->create_date));
                        },
                    ],
                    [
                        'label' => 'Trạng thái',
                        'attribute' => 'status',
                        'format'=> 'raw',
                        'value' => function($model){
                            return \backend\controllers\CommonController::getStatusName($model->status);
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'contentOptions' => ['class'=>'text-center'],
                    'buttons' => [
                        'view' => function ($model, $url) use ($controller)  {
                            
                            return '<a title="Xem chi tiết" href="/' . $controller . '/view?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
                        },
                        'update' => function ($model, $url) use ($controller)  {
                            return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                        },
                        'delete' => function ($model, $url) use ( $controller){
                            return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá giảng viên này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
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
