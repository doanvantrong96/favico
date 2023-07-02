<?php
    use yii\grid\GridView;
    use backend\models\Employee;
    use backend\models\Category;
    use yii\helpers\ArrayHelper;
    use backend\controllers\CommonController;
    
    $controller = Yii::$app->controller->id;
    $resultCateActive = Category::find()->select(['id','name','slug'])->where(['status'=>1,'is_delete'=>0])->all();
    $listCategory = ArrayHelper::map($resultCateActive, 'id', 'name');
    $listCategorySlug = [];
    foreach($resultCateActive as $rowCate){
        $listCategorySlug[$rowCate->id] = [
            'name' => $rowCate->name,
            'slug' => $rowCate->slug,
        ];
    }
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
            'contentOptions' => ['style'=>'width:200px'],
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
                $html .= '<p><b>Lượt xem</b>: ' . $data->viewed . '</p>';
                
                return $html;
            }
        ],
        [
            'label' => 'Tác giả - Thời gian xuất bản',
            'format' => 'raw',
            'value' => function($data){
                $html = '<p><b>Tác giả</b>: ' . ($data->source ? $data->source : '---') . '</p>';
               
                $html .= '<p data-toggle="tooltip"  data-placement="bottom" title="Thời gian xuất bản"><b>Thời gian XB</b>: ' . date('H:i d/m/Y',strtotime($data->date_publish)) . '</p>';
                
                return $html;
            },
            'contentOptions' => ['style' => 'width:220px']
        ],
        [
            'label' => 'Duyệt',
            'format' => 'raw',
            'value' => function($data){
                $html = '';
                $modelUserPublish = null;
                $modelUserEdit = null;
                $modelUserCreate = Employee::findOne($data->author);
                if( $data->user_publish ){
                    $modelUserPublish = Employee::findOne($data->user_publish);
                }
                if( $data->user_update ){
                    $modelUserEdit = Employee::findOne($data->user_update);
                }
                $html .= '<p><b>Người duyệt</b>: ' . ($modelUserPublish ? $modelUserPublish->fullname : '---') . '</p>';
                $html .= '<p><b>Người sửa</b>: ' . ($modelUserEdit ? $modelUserEdit->fullname : '---') . '</p>';
                $html .= '<p><b>Người tạo</b>: ' . ($modelUserCreate ? $modelUserCreate->fullname : '---') . '</p>';
                return $html;
            },
            'contentOptions' => ['style' => 'width:220px']
        ],
        ['class' => 'yii\grid\ActionColumn',
        'header' => 'Điều khiển',
        'contentOptions' => ['class'=>'text-center td_action','style'=>'width:120px'],
            'template' => '{view}{update}{reject_publish}{remove}',
            'buttons' => [
                // 'view' => function ($model, $url) use ($controller, $listCategorySlug)  {
                    
                //     // $slug_cate= "na";
                //     // $cat_selected = array_values(array_filter(explode(';', $url->category_id)));
                //     // foreach($cat_selected as $cateid){
                //     //     if( isset($listCategorySlug[$cateid]) ){
                //     //         $slug_cate = $listCategorySlug[$cateid]['slug'];
                //     //     }
                //     // }
                //     // $slug_post= $url->slug;
                //     // $id_post  = $url->id;
                //     $url_view = '#';//Yii::$app->params['domain_frontend'] . "$slug_cate/$slug_post-$id_post.html?utm_source=cms-" . Yii::$app->user->identity->id ;
                //     return '<a target="_blank" style="font-weight: 400; text-decoration: none !important;" data-toggle="tooltip" data-placement="right" title="Xem bài viết" href="' . $url_view . '">Xem bài viết</a>';
                // },
                'update' => function ($model, $url) use ($controller)  {
                    $action = '/' . $controller . '/update';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="' . $action . '?id=' . $url->id . '">Sửa bài viết</a>';

                    return '';
                },
                'reject_publish' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/reject-publish';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="right" title="Gỡ bài viết xuống" class="btn-action reject-publish" href="' . $action . '?id=' . $url->id . '">Gỡ bài viết</a>';
                    return '';
                },
                'remove' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/delete-publish';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="right" class="btn-action delete" title="Xoá bài viết" href="' . $action . '?id=' . $url->id . '">Xoá bài viết</a>';
                    return '';
                }
            ],
        ],
    ],
    ]); ?>