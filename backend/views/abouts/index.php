<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Category;
use yii\helpers\ArrayHelper;

$this->title = 'Về chúng tôi';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Về chúng tôi';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-tag';
?>
<div class="projects-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có giới thiệu nào',
                'summary' => "<p class='summary_data'>Hiển thị {begin} - {end} trong tổng số <b>{totalCount}</b> giới thiệu</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn','header' => 'STT'],

                    [
                        'label'=>'Ảnh nền',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if(!empty($data->image)){
                                return '<img class="img-grid" src="'.$data->image.'"/>';
                            }
                            return '';
                        },
                        'contentOptions' => ['style'=>'width:200px'],
                        'enableSorting' => false,
                    ],

                    [
                        'label'=>'Icon',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if(!empty($data->avatar)){
                                return '<img class="img-grid" src="'.$data->avatar.'"/>';
                            }
                            return '';
                        },
                        'contentOptions' => ['style'=>'width:50px'],
                        'enableSorting' => false,
                    ],

                    [
                        'label' => 'Tiêu đề',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if(!empty($data->title)){
                                return $data->title;
                            }
                            return '';
                        },
                    ],

                    [
                        'label' => 'Thứ tự hiển thị',
                        'value' => function ($data) {
                            if(!empty($data->position)){
                                return $data->position;
                            }
                            return '';
                        },
                    ],

                    [
                        'label' => 'Trạng thái',
                        'value' => function ($model) {
                            return \backend\controllers\CommonController::getStatusName($model->status);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class'=>'text-center'],
                        'template' => '{view}{update}{delete}',
                        'buttons' => [
                            'update' => function ($model, $url) use ($controller)  {
                                return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                            },
                            'delete' => function ($model, $url) use ( $controller){
                                return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá mục này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>