<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Course;
use backend\models\CourseSection;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoachSectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bài học';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách các bài học của lớp học';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-book';
?>

<div class="course-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có bài học nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> bài học</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'Ngày thêm',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('H:i d/m/Y', strtotime($model->create_date));
                        },
                    ],
                    [
                        'label'=>'Ảnh',
                        'format' => 'raw',
                        'attribute' => 'avatar',
                        'value' => function ($model) {
                            if( !empty($model['avatar']) )
                                return '<img src="' . $model['avatar'] . '" style="object-fit: cover;max-height:70px" />';
                            return '';
                        },
                    ],
                    [
                        'label'=>'Tên bài học',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><b>' . $model['name'] . '</b></p>';
                            return $html;
                        },
                        'contentOptions' => ['style'=>'max-width: 250px;']
                    ],
                    [
                        'label'=>'Video bài học',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( !empty($model->path_file) ){
                                return '<a href="/course-lesson/preview-video?id=' . $model->id . '" target="_blank">Xem</a>';
                            }
                            else
                                return 'Chưa có video';
                        },
                    ],
                    'sort',
                    [
                        'label'=>'Thuộc lớp học',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( $model->course_id > 0 ){
                                $modelCourse = Course::findOne($model->course_id);
                                if($modelCourse)
                                    return '<a href="/course/view?id=' . $modelCourse->id . '" target="_blank">' . $modelCourse->name . '</a>';
                                else
                                    return 'Chưa thuộc lớp học nào';
                            }else
                                return 'Chưa thuộc lớp học nào';
                        },
                    ],
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
                            return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá phần học này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
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
