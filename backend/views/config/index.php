<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Category;
use yii\helpers\ArrayHelper;

$this->title = 'Cài đặt khác';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Cài đặt khác';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-tag';
?>
<div class="projects-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có bản ghi nào',
                'summary' => "<p class='summary_data'>Hiển thị {begin} - {end} trong tổng số <b>{totalCount}</b> bản ghi</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn','header' => 'STT'],
                    
                    [
                        'label' => 'Loại config',
                        'value' => function ($data) {
                            if(!empty($data->type)){
                                $list_type  = Yii::$app->params['type_config'];
                                return isset($list_type[$data->type]) ? $list_type[$data->type] : '(error)';
                            }
                            return '';
                        },
                    ],
                    
                    [
                        'label' => 'Nội dung hiển thị',
                        'value' => function ($data) {
                            if(!empty($data->name)){
                                return $data->name;
                            }
                            return '';
                        },
                    ],
                    [
                        'label' => 'Link của Nội dung (nếu có)',
                        'value' => function ($data) {
                            if(!empty($data->value)){
                                return $data->value;
                            }
                            return '';
                        },
                    ],[
                        'label' => 'Vị trí/ Sắp xếp',
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
                    [
                        'label'=>'Icon',
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
                    ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class'=>'text-center'],
                        'template' => '{view}{update}{delete}',
                        'buttons' => [
                            'update' => function ($model, $url) use ($controller)  {
                                return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                            },
                            // 'delete' => function ($model, $url) use ( $controller){
                            //     return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá mục này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
                            // }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.min.js" integrity="sha256-M8IkAPnXdVChgPQwts/KeepRP4ogs+hzBtPmVhUj5YA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/svg.connectable.js/2.0.1/svg.connectable.min.js"></script>
<script type="text/javascript" src="https://imagemap.org/js/svg.draggable.min.js"></script>
<script type="text/javascript" src="https://imagemap.org/js/svg.draw.min.js"></script>
<script type="text/javascript" src="https://imagemap.org/js/svg.select.min.js"></script>
<script type="text/javascript" src="https://imagemap.org/js/svg.resize.min.js"></script>
<script type="text/javascript" src="https://imagemap.org/js/map.min.js"></script>