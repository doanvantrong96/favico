<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RegisterPracticeTrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Khách hàng đăng ký nhận ưu đãi';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách khách hàng đăng ký nhận ưu đãi';
$controller = Yii::$app->controller->id;
?>
<div class="register-practice-try-index">

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
                        'label'=>'Email',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><b>' . $model['email'] . '</b></p>';
                            return $html;
                        },
                    ],
                    [
                        'label'=>'Ngày đăng ký',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('H:i d/m/Y', strtotime($model->create_date));
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'contentOptions' => ['class'=>'text-center'],
                    'buttons' => [
                        'delete' => function ($model, $url) use ( $controller){
                            return '<a title="Xoá" onclick="return confirm(\'Bạn có chắc chắn muốn xoá email khách hàng này?\')" href="/' . $controller . '/delete?id=' . $url->id . '"><i class="fal fa-trash"></i></a>';
                        }
                    ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
