<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryTagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Chuyên mục';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách chuyên mục tin tức';
$controller = Yii::$app->controller->id;
?>

<div class="projects-index">
    <?php
    if (Yii::$app->session->hasFlash('message')){
        $msg      = Yii::$app->session->getFlash('message');
        echo '<div class="alert alert-success">
                    <i class="fal fa-check"></i> ' . $msg . '
                </div>';
        Yii::$app->session->setFlash('message',null);
    }
    ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => 'Không có chuyên mục nào',
        'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> chuyên mục</p>",
        'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
        'columns' => array(
            array('class' => 'yii\grid\SerialColumn'),
            'name',
            [
                'label' => 'Ngày tạo',
                'value' => function ($model) {
                    return date('H:i d/m/Y',strtotime($model->create_date));
                },
                'contentOptions' => array('style' => 'width:180px'),
                'headerOptions' => array('style' => 'width:180px')
            ],
            [
                'attribute' => 'user_create',
                'value' => function ($model) {
                    return $model::_getEmployee($model->user_create);
                },
                'contentOptions' => array('style' => 'width:150px')
            ],
            
            ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        // 'view' => function ($model, $url) use ($controller)  {
                            
                        //     return '<a title="Xem chi tiết" href="/' . $controller . '/view?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
                        // },
                        'update' => function ($model, $url) use ($controller)  {
                            return '<a title="Cập nhật" style="margin:0 8px" href="/' . $controller . '/update?id=' . $url->id . '"><i class="fal fa-pencil"></i></a>';
                        },
                        'delete' => function ($model, $url) use ( $controller){
                            return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá chuyên mục này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
                        }
                    ],
                    ],
        ),
    ]); ?>

</div>