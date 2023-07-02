<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Customer;
use backend\models\OrderCart;
use backend\models\Course;
use backend\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HistoryTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mua khoá học';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý giao dịch mua khoá học của khách hàng';
$controller = Yii::$app->controller->id;
?>
<div class="history-transaction-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có giao dịch nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> giao dịch</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'rowOptions'=>function($model){
                    return ['id'=>'tr-user-'.$model->id];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
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
                        'label'=>'Khách hàng',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $customer = Customer::findOne($model->user_id);
                            if( $customer ){
                                $html = '<p style="margin-bottom: 0;"><b>' . $customer['fullname'] . '</b></p>';
                                $html .= '<p style="margin-bottom: 0;">Email: <b>' . ($customer['email'] ? $customer['email'] : '---') . '</b></p>';
                                $html .= '<p style="margin-bottom: 0;">SĐT: <b>' . ($customer['phone'] ? $customer['phone'] : '---') . '</b></p>';
                            }else
                                $html = 'N/A';
                            return $html;
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
                                    if( $price_discount > 0 )
                                        $html_price = '<span data-toggle="tooltip" data-placement="bottom" title="Giá giảm">' . number_format($price_discount,0,',',',') . '</span> (<span data-toggle="tooltip" data-placement="bottom" style="text-decoration: line-through;" title="Giá gốc">' . number_format($price,0,',',',') . '</span>)';
                                    else
                                        $html_price = number_format($price,0,',',',');

                                    $html .= '<p style="margin-bottom:0">- <b>' . $modelCourse->name . '</b>: ' . $html_price . '</p>';


                                }
                            }
                            return $html ? $html : '---';
                        },
                        
                    ],
                    [
                        'label'=>'Mã khuyến mại',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( $model->gift_code ){
                                return $model->gift_code;
                            }
                            return 'Không có';
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
                        'label'=>'Sale',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if( $model->affliate_id > 0 ){
                                $modelSale = Employee::findOne(['affliate_id' => $model->affliate_id]);
                                if( $modelSale )
                                    return $modelSale->fullname;
                                else
                                    return 'N/A';
                            }
                            
                            return '---';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['class'=>'text-center','style'=>'width:10%'],
                        'template' => '{cancel}{payment}',
                        'buttons' => [
                            // 'view' => function ($model, $url) use ($controller)  {
                                
                            //     return '<a title="Xem chi tiết" href="/' . $controller . '/view?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
                            // },
                            'cancel' => function ($model, $url) use ($controller)  {
                                if( $url->status == OrderCart::STATUS_PENDING )
                                    return '<a style="margin:0 5px" title="Huỷ giao dịch" class="btn_cancel_trans" data-confirm="Bạn có chắc chắn muốn huỷ giao dịch này?" data-id="' . $url->id . '" href="/history-transaction/cancel?id=' . $url->id . '"><i class="ni ni-close"></i></a>';
                                return '';
                            },
                            'payment' => function ($model, $url) use ($controller)  {
                                if( $url->status == OrderCart::STATUS_PENDING )
                                    return '<a style="margin:0 5px" title="Xác nhận đã thanh toán" class="btn_payment" data-confirm="Bạn có chắc chắn muốn xác nhận giao dịch này đã thanh toán?" data-id="' . $url->id . '" href="/history-transaction/verify?id=' . $url->id . '"><i class="fal fa-check"></i></a>';
                                return '';
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
