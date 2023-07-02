<?php
    use yii\grid\GridView;
    use backend\models\Employee;
    use backend\models\Category;
    use yii\helpers\ArrayHelper;
    use backend\controllers\CommonController;
    
    $controller   = Yii::$app->controller->id;

    $listCategory = ArrayHelper::map(Category::find()->where(['status'=>1,'is_delete'=>0])->all(), 'id', 'name');

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'emptyText' => 'Không có bài viết nào',
    'summary' => "<p class='summary_data'>Hiển thị {begin} - {end} trong tổng số <b>{totalCount}</b> bài viết</p>",
    'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn','header' => 'STT'],
        // [
        //     'label' => 'ID',
        //     'format' => 'raw',
        //     'attribute' => 'id',
        // ],
        [
            'label'=>'Ảnh',
            'format' => 'raw',
            'value' => function ($data) {
                if(!empty($data->image)){
                    return '<img class="img-grid" src="' . $data->image.'"/>';
                }
                return '';
            },
            'contentOptions' => ['style'=>'width:150px'],
            'enableSorting' => false,
        ],
        [
            'label' => 'Tiêu đề',
            'format' => 'raw',
            'value' => function($data) use ($controller, $listCategory){
                $html = '<p><b>Tiêu đề</b>: <a style="font-weight: 500;" href="/' . $controller . '/update?id=' . $data->id . '">'.$data->title.'</a></p>';
                $cat_selected   = array_values(array_filter(explode(';', $data->category_id)));
                $listName       = [];
                foreach($cat_selected as $id){
                    if(isset($listCategory[$id]))
                        $listName[] = $listCategory[$id];
                }
                $html .= '<p><b>Chuyên mục</b>: ' . (!empty($listName) ? implode(', ', $listName) : '---') . '</p>';
                $html .= '<p><b>Mô tả</b>: ' . $data->description . '</p>';

                return $html;
            },
        ],
        [
            'label' => 'Tác giả - Thời gian',
            'format' => 'raw',
            'value' => function($data){
                $html = '<p><b>Tác giả</b>: ' . ($data->source ? $data->source : '---') . '</p>';
               
                
                $html .= '<p data-toggle="tooltip"  data-placement="bottom" title="Thời gian gửi duyệt bài"><b>Thời gian gửi duyệt</b>: ' . date('H:i d/m/Y',strtotime($data->date_pending)) . '</p>';
                $html .= '<p data-toggle="tooltip"  data-placement="bottom" title="Thời gian tạo bài"><b>Thời gian tạo</b>: ' . date('H:i d/m/Y',strtotime($data->create_at)) . '</p>';
                return $html;
            },
            'contentOptions' => ['style' => 'width:255px']
        ],
        [
            'label' => 'Duyệt',
            'format' => 'raw',
            'value' => function($data){
                $html = '';
                $modelUserRequest = null;
                $modelUserEdit = null;
                $modelUserCreate = Employee::findOne($data->author);
                if( $data->user_request_approve ){
                    $modelUserRequest = Employee::findOne($data->user_request_approve);
                }
                if( $data->user_update ){
                    $modelUserEdit = Employee::findOne($data->user_update);
                }
                $html .= '<p><b>Người gửi duyệt</b>: ' . ($modelUserRequest ? $modelUserRequest->fullname : '---') . '</p>';
                $html .= '<p><b>Người sửa</b>: ' . ($modelUserEdit ? $modelUserEdit->fullname : '---') . '</p>';
                $html .= '<p><b>Người tạo</b>: ' . ($modelUserCreate ? $modelUserCreate->fullname : '---') . '</p>';
                return $html;
            },
            'contentOptions' => ['style' => 'width:220px']
        ],
        ['class' => 'yii\grid\ActionColumn',
        'header' => 'Điều khiển',
        'contentOptions' => ['class'=>'text-center td_action','style'=>'width:160px'],
            'template' => '{view}{update}{published}{reject}{remove}',
            'buttons' => [
                // 'view' => function ($model, $url) use ($controller)  {
                //     $url_view = '#';//Yii::$app->params['domain_frontend'] . 'news/preview?id=' . $url->id;
                //     return '<a target="_blank" style="font-weight: 400; text-decoration: none !important;" data-toggle="tooltip" data-placement="right" title="Xem bài viết" href="' . $url_view . '">Xem bài viết</a>';
                // },
                'update' => function ($model, $url) use ($controller)  {
                    $action = '/' . $controller . '/update';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="bottom" title="Cập nhật" href="' . $action . '?id=' . $url->id . '">Sửa bài viết</a>';

                    return '';
                },
                'published' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/published';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" class="btn-action publish" data-placement="bottom" title="Xuất bản bài viết" href="' . $action . '?id=' . $url->id . '">Xuất bản bài viết</a>';
                    return '';
                },
                'reject' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/reject';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="bottom" title="Từ chối duyệt" class="btn-action reject" href="' . $action . '?id=' . $url->id . '">Từ chối duyệt</a>';
                    return '';
                },
                'remove' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/delete-pending';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="bottom" class="btn-action delete" title="Xoá bài viết" href="' . $action . '?id=' . $url->id . '">Xoá bài viết</a>';
                    return '';
                }
            ],
        ],
    ],
    ]); ?>