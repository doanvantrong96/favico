<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoachSectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Khách hàng liên hệ';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách khách hàng liên hệ';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-users';
?>

<div class="course-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có khách hàng nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> khách hàng</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'Tên KH',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model['name'],['/contact/view?id='.$model['id']],['style'=> $model['status'] == 0 ?'font-weight: bold' : '']);
                            
                        },
                    ],
                    'phone',
                    'content',
                    'province',
                    [
                        'label'=>'Nguồn đăng ký',
                        'format' => 'raw',
                        'value' => function ($model) {
                            
                            return '<a class="profile-link" href="'.$model->url.'" target="_blank">'.$model->source.'</a>';
                        },
                    ],
                    
                    [
                        'label'=>'Ngày đăng ký',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('H:i d/m/Y', strtotime($model->time));
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($model, $url) use ($controller)  {
                            return '<a title="Xem chi tiết" href="/' . $controller . '/view?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
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
