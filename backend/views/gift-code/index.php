<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoachCourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mã khuyến mại';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách mã khuyến mại';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-gift';
?>

<div class="course-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có mã khuyến mại nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> mã khuyến mại</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'code',
                    [
                        'label' => "Loại",
                        'value' => function($model){
                            $giftTypePrice = Yii::$app->params['giftTypePrice'];
                            if( isset($giftTypePrice[$model->type_price]) )
                                return $giftTypePrice[$model->type_price];
                            return 'N/A';
                        }
                    ],
                    [
                        'attribute' => "price",
                        'value' => function($model){
                            if( $model->type_price == 1 )
                                return number_format($model->price,0,'.','.') . 'đ';
                            else if( $model->type_price == 2 )
                                return $model->price . '%' . ($model->max_price_promotion > 0 ? ' (Tối đa ' . number_format($model->max_price_promotion,0,'.','.') . 'đ)' : '');
                            else if( $model->type_price == 3 )
                                return $model->price . '%';
                            return 'N/A';
                            
                        }
                    ],
                    [
                        'label' => "Khoá học áp dụng",
                        'value' => function($model){
                            if( !empty($model->course_id) ){
                                $list_course_id = array_filter(explode(';', $model->course_id));
                                $list_course_name = ArrayHelper::map(\backend\models\Course::find()->where(['is_delete' => 0])->andWhere(['in', 'id', $list_course_id])->all(), 'name', 'name');
                                return implode(', ', $list_course_name);
                            }
                            return 'Tất cả';
                            
                        },
                        'contentOptions' => ['style'=>'max-width:250px']
                    ],
                    'date_start',
                    'date_end',
                    ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class'=>'text-center'],
                    'template' => '{update}{delete}',
                    'buttons' => [
                        'update' => function ($model, $url) use ($controller)  {
                            return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                        },
                        'delete' => function ($model, $url) use ( $controller){
                            return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá mã khuyến mại này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
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
table.table.table-striped.table-bordered td,table.table.table-striped.table-bordered th {
    vertical-align: middle;
}
</style>
