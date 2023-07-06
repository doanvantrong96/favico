<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\ProductTag;
use backend\models\ProductCategory;

$this->title = 'Sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Sản phẩm';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-tag';

?>
<div class="projects-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có sản phẩm',
                'summary' => "<p class='summary_data'>Hiển thị {begin} - {end} trong tổng số <b>{totalCount}</b> sản phẩm</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn','header' => 'STT'],

                    [
                        'label'=>'Ảnh sản phẩm',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if(!empty($data->image)){
                                return '<img class="img-grid" src="'.$data->image.'"/>';
                            }
                            return '';
                        },
                        'contentOptions' => ['style'=>'width:500px'],
                        'enableSorting' => false,
                    ],

                    [
                        'label' => 'Tên',
                        'value' => function ($data) {
                            if(!empty($data->title)){
                                return $data->title;
                            }
                            return '';
                        },
                    ],
                    [
                        'label' => 'Vị trí hiển thị',
                        'value' => function ($data) {
                            if(!empty($data->position)){
                                return $data->position;
                            }
                            return '';
                        },
                    ],
                    
                    [
                        'label' => 'Nhà cung cấp',
                        'value' => function ($data) {
                            if(!empty($data->category_id)){
                                $all_category       = ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name');
                                return (isset($all_category[$data->category_id])) ? $all_category[$data->category_id] : 'NA' ;
                            }
                            return '';
                        },
                    ],
                    
                    [
                        'label' => 'Loại sản phẩm',
                        'value' => function ($data) {
                            // if($data->is_most != null){
                                $list_most      = Yii::$app->params['statusProduct'];
                                return (isset($list_most[$data->is_most])) ? $list_most[$data->is_most] : 'NA' ;
                            // }
                            // return '';
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