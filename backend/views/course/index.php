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
                        'label'=>'Tên khoá học',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><a href="view?id=' . $model->id . '"><b>' . $model['name'] . '</b></a></p>';
                            $html .= '<i class="date-create">Ngày tạo: ' . date('H:i d/m/Y', strtotime($model['create_date'])) . '</i>';
                            if( $model->is_coming ){
                                $html .= '<label class="coming">Sắp diễn ra</label>';
                            }
                            return $html;
                        },
                        'contentOptions' => ['style'=>'position:relative']
                    ],
                    [
                        'label'=>'Danh mục',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( !empty($model->category_id) ){
                                $arrCateId = array_filter(explode(';',$model->category_id));
                                $resultCate= Category::find()->where(['status' => 1, 'is_delete' => 0 ])->andWhere(['in', 'id', $arrCateId])->all();
                                if( !empty($resultCate) ){
                                    return implode(', ', \yii\helpers\ArrayHelper::map($resultCate, 'name', 'name'));
                                }
                            }
                            return 'N/A';
                        },
                    ],
                    [
                        'label'=>'Giảng viên',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( $model->lecturer_id ){
                                $modelLecturer = Lecturer::findOne(['id' => $model->lecturer_id, 'is_delete' => 0]);
                                if( $modelLecturer )
                                    return $modelLecturer->name;
                            }

                            return 'N/A';
                        },
                        'visible' => !$isRoleLecturer
                    ],
                    
                    'total_lessons',
                    [
                        'label'=>'Giá',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            if( $model['price'] <= 0 ){
                                $html = 'Miễn phí';
                            }else{
                                if( $model->price > 0 ){
                                    if( $model->promotional_price > 0 )
                                        $html = '<span data-toggle="tooltip" data-placement="bottom" title="Giá khuyến mại">' . number_format($model->promotional_price,0,',',',') . '</span> (<span data-toggle="tooltip" data-placement="bottom" style="text-decoration: line-through;" title="Giá gốc">' . number_format($model->price,0,',',',') . '</span>)';
                                    else
                                        $html = number_format($model->price,0,',',',');
                                }
                            }
                            
                            return $html;
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
                    'buttons' => [
                        'view' => function ($model, $url) use ($controller)  {
                            
                            return '<a title="Xem chi tiết" href="/' . $controller . '/view?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
                        },
                        'update' => function ($model, $url) use ($controller)  {
                            return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                        },
                        'delete' => function ($model, $url) use ( $controller){
                            return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá khoá học này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
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