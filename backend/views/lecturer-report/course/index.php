<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Category;
use backend\models\Lecturer;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Khoá học';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách khoá học';
$this->params['breadcrumbs']['icon_page'] = 'fa-window';
$controller = Yii::$app->controller->id;
$isRoleLecturer = Yii::$app->user->identity->account_type == \backend\models\Employee::TYPE_LECTURER;
?>
<div class="course-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có khoá học nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> khoá học</p>",
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
                        'label'=>'Thông tin khoá học',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><a href="view-course?id=' . $model->id . '"><b>' . $model['name'] . '</b></a></p>';
                            $cateName = '---';
                            if( !empty($model->category_id) ){
                                $arrCateId = array_filter(explode(';',$model->category_id));
                                $resultCate= Category::find()->where(['status' => 1, 'is_delete' => 0 ])->andWhere(['in', 'id', $arrCateId])->all();
                                if( !empty($resultCate) ){
                                    $cateName = implode(', ', \yii\helpers\ArrayHelper::map($resultCate, 'name', 'name'));
                                }
                            }
                            $html .= '<p style="margin-bottom: 0;"><b>Danh mục</b>: ' . $cateName . '</p>';
                            $html .= '<p style="margin-bottom: 0;"><b>Số bài học</b>: ' . $model->total_lessons . '</p>';
                            $html .= '<i class="date-create">Ngày tạo: ' . date('H:i d/m/Y', strtotime($model['create_date'])) . '</i>';
                            if( $model->is_coming ){
                                $html .= '<label class="coming">Sắp diễn ra</label>';
                            }
                            return $html;
                        },
                        'contentOptions' => ['style'=>'position:relative']
                    ],
                    [
                        'label'=>'Lượt xem',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom:0"><b>Tổng lượt xem</b>: ' . number_format($model->total_view, 0, '.', '.') . '</p>';
                            $resultViewToday = \backend\models\CourseViewed::findOne(['course_id' => $model->id, 'date' => date('Y-m-d')]);
                            $viewToday = $resultViewToday ? $resultViewToday->total_view : 0;
                            $html .= '<p style="margin-bottom:0"><b>Lượt xem hôm nay</b>: ' . number_format($viewToday, 0, '.', '.') . '</p>';

                            return $html;
                        },
                    ],
                    [
                        'label'=>'Lượt đăng ký',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $data = $model->getDataRegisterAndStudyCourse(1);
                            return number_format($data['totalRegister'], 0, '.', '.');
                        },
                    ],
                    [
                        'label'=>'Học viên đã học',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $data = $model->getDataRegisterAndStudyCourse(2);
                            return number_format($data['totalStudy'], 0, '.', '.');
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
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($model, $url) use ($controller)  {
                            
                            return '<a title="Xem chi tiết" href="/' . $controller . '/view-course?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
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
.coming{
    position: absolute; top: 0; right: 0; background-color: red; color: #fff; padding: 1px 3px;
}
</style>
<script type="text/javascript">
jQuery(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>