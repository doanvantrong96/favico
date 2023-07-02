<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Category;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\HistoryTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controller = Yii::$app->controller->id;
Pjax::begin(['id' => 'boxCoursePajax','enablePushState'=>false, 'enableReplaceState'=>false]);
?>
<div class="history-transaction-index">

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
                            $html = '<p style="margin-bottom: 0;"><b>' . $model['name'] . '</b></p>';
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
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{copy}',
                    'header' => 'Thao tác',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'text-center'],
                    'buttons' => [
                        'copy' => function ($model, $url) use ($controller)  {
                            
                            $url_detail = Yii::$app->params['domain_frontend'] . '/chi-tiet-khoa-hoc/' . $url->slug . '?aff=' . Yii::$app->user->identity->affliate_id;
                            return '<a title="Sao chép liên kết" class="btn-copy" href="javascript:;" data-link="' . $url_detail . '"><i style="font-size: 18px;" class="fal fa-copy"></i></a>';
                        },
                    ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
<style>
.date-create{color:gray}
table.table.table-striped.table-bordered td {
    vertical-align: middle;
}
.coming{
    position: absolute; top: 0; right: 0; background-color: red; color: #fff; padding: 1px 3px;
}
</style>