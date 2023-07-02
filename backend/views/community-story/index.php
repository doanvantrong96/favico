<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Category;
use yii\helpers\ArrayHelper;

$this->title = 'Quản lý câu chuyện cộng đồng';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách câu chuyện cộng đồng';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-tag';
?>
<div class="projects-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có câu chuyện nào',
                'summary' => "<p class='summary_data'>Hiển thị {begin} - {end} trong tổng số <b>{totalCount}</b> câu chuyện</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn','header' => 'STT'],
                    [
                        'label'=>'Thông tin khách hàng',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><b>' . $model['fullname'] . '</b></p>';
                            $html .= '<p style="margin-bottom: 0;">Email: <b>' . ($model['email'] ? $model['email'] : '---') . '</b></p>';
                            return $html;
                        },
                    ],
                    [
                        'label'=>'Ảnh câu chuyện',
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
                        'attribute'=>'content',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $style_over = mb_strlen($data->content) > 300 ? '-webkit-line-clamp:5;overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical;' : '';
                            return '<p style="margin-bottom:0;' . $style_over . '">' . $data->content . '</p>';
                        },
                        'contentOptions' => ['style'=>'max-width:300px'],
                        'enableSorting' => false,
                    ],
                    'position',
                    [
                        'label' => 'Trạng thái',
                        'value' => function ($model) {
                            return \backend\controllers\CommonController::getStatusNameCommunity($model->status);
                        },
                    ],
                    [
                        'label' => 'Tình trạng',
                        'value' => function ($model) {
                            return \backend\controllers\CommonController::getStateNameCommunity($model->is_active);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class'=>'text-center'],
                        'template' => '{approved}{reject}{show}{hide}{update}{delete}',
                        'buttons' => [
                            'approved' => function ($model, $url) use ($controller)  {
                                if( $url->status == 0 )
                                    return '<a style="margin:0 5px" title="Duyệt" data-confirm="Bạn có chắc chắn muốn duyệt câu chuyện này?" href="/community-story/approved?id=' . $url->id . '"><i class="fal fa-check"></i></a>';
                                return '';
                            },
                            'reject' => function ($model, $url) use ($controller)  {
                                if( $url->status == 0 )
                                    return '<a style="margin:0 5px" title="Từ chối duyệt" data-confirm="Bạn có chắc chắn muốn từ chối duyệt câu chuyện này?" data-id="' . $url->id . '" href="/community-story/reject?id=' . $url->id . '"><i class="ni ni-close"></i></a>';
                                return '';
                            },
                            'show' => function ($model, $url) use ($controller)  {
                                if( $url->status == 1 && $url->is_active == 0 )
                                    return '<a style="margin:0 5px" title="Hiển thị" data-confirm="Bạn có chắc chắn muốn hiển thị câu chuyện này?" href="/community-story/show?id=' . $url->id . '"><i class="fal fa-eye"></i></a>';
                                return '';
                            },
                            'hide' => function ($model, $url) use ($controller)  {
                                if( $url->status == 1 && $url->is_active == 1 )
                                    return '<a style="margin:0 5px" title="Ẩn" data-confirm="Bạn có chắc chắn muốn ẩn câu chuyện này?" data-id="' . $url->id . '" href="/community-story/hide?id=' . $url->id . '"><i class="fal fa-eye-slash"></i></a>';
                                return '';
                            },
                            'update' => function ($model, $url) use ($controller)  {
                                return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                            },
                            'delete' => function ($model, $url) use ( $controller){
                                return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá câu chuyện cộng đồng này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>