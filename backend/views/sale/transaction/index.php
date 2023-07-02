<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Customer;
use backend\models\OrderCart;
use backend\models\Course;
use backend\models\Employee;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\HistoryTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controller = Yii::$app->controller->id;
Pjax::begin(['id' => 'boxPajax','enablePushState'=>false, 'enableReplaceState'=>false]);
?>
<div class="history-transaction-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có đơn hàng nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> đơn hàng</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'rowOptions'=>function($model){
                    return ['id'=>'tr-user-'.$model->id];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn','header' => 'STT'],
                    [
                        'label'=>'Mã đơn',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->id;
                        },
                    ],
                    [
                        'label'=>'Ngày đặt đơn',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('H:i d/m/Y', strtotime($model->create_date));
                        },
                    ],
                    [
                        'label'=>'Khoá học',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $list_course = explode(',', $model->list_course);
                            $html = '';
                            foreach($list_course as $row){
                                $data = explode('#', $row);
                                $modelCourse    = Course::findOne($data[0]);
                                if( $modelCourse ){
                                    $price      = (int)$data[1];
                                    $price_discount = (int)$data[2];
                                    $html_price = '';
                                    // if( $price_discount > 0 )
                                    //     $html_price = '<span data-toggle="tooltip" data-placement="bottom" title="Giá giảm">' . number_format($price_discount,0,',',',') . '</span> (<span data-toggle="tooltip" data-placement="bottom" style="text-decoration: line-through;" title="Giá gốc">' . number_format($price,0,',',',') . '</span>)';
                                    // else
                                    //     $html_price = number_format($price,0,',',',');

                                    $html .= '<p style="margin-bottom:0">- <b>' . $modelCourse->name . '</b> ' . $html_price . '</p>';


                                }
                            }
                            return $html ? $html : '---';
                        },
                        
                    ],
                    [
                        'label'=>'Giá',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( $model->price > 0 ){
                                $price = $model->price;
                                return number_format($price,0,'.','.') . 'đ';
                            }
                            return '---';
                        },
                        
                    ],
                    [
                        'label'=>'Tình trạng',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $status_order = Yii::$app->params['orderStatus'];
                            if( isset($status_order[$model['status']]) )
                                return $status_order[$model['status']];
                            
                            return '---';
                        },
                        
                    ],
                    [
                        'header'=>'Hoa hồng <i class="fal fa-info-circle" data-toggle="tooltip" title="Các đơn hàng chờ thanh toán, lỗi hoặc huỷ thì hoa hồng sẽ là tạm tính."></i>',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( $model->price > 0 ){
                                $price = $model->price;
                                $percent_revenue = Yii::$app->user->identity->commission_percentage;
                                return number_format(($price/100)*$percent_revenue, 0, '.', '.') . 'đ';
                            }
                            return 0;
                        },
                        
                    ],
                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'contentOptions' => ['class'=>'text-center','style'=>'width:10%'],
                    //     'template' => '{view}',
                    //     'buttons' => [
                    //         'view' => function ($model, $url) use ($controller)  {
                                
                    //             return '<a title="Xem chi tiết" href="/' . $controller . '/view-order?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
                    //         },
                    //     ],
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>