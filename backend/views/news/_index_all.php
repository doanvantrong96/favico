<?php
    use yii\grid\GridView;
    use backend\models\Employee;
    use backend\models\Category;
    use backend\models\Tag;
    use yii\helpers\ArrayHelper;
    use backend\models\News;
    use backend\controllers\CommonController;
    
    $controller = Yii::$app->controller->id;

    $resultCateActive = Category::find()->select(['id','name','slug'])->where(['status'=>1,'is_delete'=>0])->all();
    $listCategory     = Yii::$app->params['category_news'];//ArrayHelper::map($resultCateActive, 'id', 'name');
    // $listCategorySlug = [];
    // foreach($resultCateActive as $idCate=>$rowCate){
    //     $listCategorySlug[$idCate] = [
    //         'name' => $rowCate->name,
    //         'slug' => $rowCate->slug,
    //     ];
    // }
    
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
                if( $data->status == News::PUBLISHED )
                    $html .= '<p><b>Lượt xem</b>: ' . $data->viewed . '</p>';

                return $html;
            }
        ],
        [
            'label' => 'Thời gian',
            'format' => 'raw',
            'value' => function($data){
                $html  = '';
                $html .= '<p data-toggle="tooltip"  data-placement="bottom" title="Thời gian tạo bài"><b>Thời gian tạo</b>: ' . date('H:i d/m/Y',strtotime($data->create_at)) . '</p>';
                if($data->status == News::PUBLISHED)
                    $html .= '<p data-toggle="tooltip"  data-placement="bottom" title=""><b>Thời gian duyệt</b>: ' . date('H:i d/m/Y',strtotime($data->date_publish)) . '</p>';
                
                return $html;
            },
            'contentOptions' => ['style' => 'width:250px']
        ],
        [
            'label' => 'Trạng thái',
            'format' => 'raw',
            'value' => function($data){
                $news_status = Yii::$app->params['news_status'];
                $html = (isset($news_status[$data->status]) ? $news_status[$data->status] : 'N/A')  . '</p>';
                return $html;
            },
            'contentOptions' => ['style' => 'width:150px']
        ],
        ['class' => 'yii\grid\ActionColumn',
        'header' => 'Điều khiển',
        'contentOptions' => ['class'=>'text-center td_action','style'=>'width:150px'],
            'template' => '{view}{update}{published}{hide}{remove}',
            'buttons' => [
                // 'view' => function ($model, $url) use ($controller, $listCategorySlug)  {
                //     if( $url->status == News::PUBLISHED ){
                //         // $slug_cate= "na";
                //         // $cat_selected = array_values(array_filter(explode(';', $url->category_id)));
                //         // foreach($cat_selected as $cateid){
                //         //     if( isset($listCategorySlug[$cateid]) ){
                //         //         $slug_cate = $listCategorySlug[$cateid]['slug'];
                //         //         if( $listCategorySlug[$cateid]['is_parent'] > 0 ){
                //         //             break;
                //         //         }
                //         //     }
                //         // }
                //         // $slug_post= $url->slug;
                //         // $id_post  = $url->id;
                //         $url_view = '#';//Yii::$app->params['domain_frontend'] . "$slug_cate/$slug_post-$id_post.html?utm_source=cms-" . Yii::$app->user->identity->id ;
                //         return '<a target="_blank" style="font-weight: 400; text-decoration: none !important;" data-toggle="tooltip" data-placement="right" title="Xem bài viết" href="' . $url_view . '">Xem bài viết</a>';
                //     }
                //     else{
                //         $url_view = '#';//Yii::$app->params['domain_frontend'] . 'news/preview?id=' . $url->id;
                //         return '<a target="_blank" style="font-weight: 400; text-decoration: none !important;" data-toggle="tooltip" data-placement="right" title="Xem bài viết" href="' . $url_view . '">Xem bài viết</a>';
                //     }
                // },
                'update' => function ($model, $url) use ($controller)  {
                    $action = '/' . $controller . '/update';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="' . $action . '?id=' . $url->id . '">Sửa bài viết</a>';

                    return '';
                },
                'published' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/published';
                    if( CommonController::checkAccess($action) && $url->status != News::PUBLISHED )
                        return '<a data-toggle="tooltip" class="btn-action publish" data-placement="bottom" title="Hiển thị bài viết lên website" href="' . $action . '?id=' . $url->id . '">Đăng bài viết</a>';
                    return '';
                },
                'hide' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/hide';
                    if( CommonController::checkAccess($action) && $url->status == News::PUBLISHED )
                        return '<a data-toggle="tooltip" class="btn-action publish" data-placement="bottom" title="Ẩn bài viết khỏi website" href="' . $action . '?id=' . $url->id . '">Ẩn bài viết</a>';
                    return '';
                },
                'remove' => function ($model, $url) use ( $controller){
                    $action = '/' . $controller . '/delete';
                    if( CommonController::checkAccess($action) )
                        return '<a data-toggle="tooltip" data-placement="right" class="btn-action delete" title="Xoá bài viết" href="' . $action . '?id=' . $url->id . '">Xoá bài viết</a>';
                    return '';
                }
            ],
        ],
    ],
    ]); ?>