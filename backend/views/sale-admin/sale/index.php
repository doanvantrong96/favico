<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = 'Danh sách tài khoản sale';
$this->params['breadcrumbs'][] = 'Sale Admin';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách tài khoản sale';

$userCurrent = Yii::$app->user->identity;


$listRole = [];

// AnimateAsset::register($this);
// YiiAsset::register($this);

$opts = Json::htmlEncode([
    'items' => [],
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
?>
<style type="text/css">
form .col-lg-3 {
    width: 245px;
    float: none;
    display: inline-block;
    text-align: left !important;
}
form .col-lg-2{display:inline-block}
.table-bordered td:last-child{text-align:center}
.pagination {
    text-align: center;
    width: 100%;
}
.pagination > li{display:inline-block}
.row_role > h3 {
    background-color: #E9E9E9;
    float: left;
    font-size: 18px;
    margin: 0;
    text-indent: 20px;
    width: 100%;
    padding: 10px 0;
    font-weight: 600;
}
.role_access {
    background-color: #fff;
    border: 1px dashed green;
    float: left;
    margin-bottom: 16px;
    padding: 10px 20px 10px;
    width: 100%;
}
.left_role, .right_role {
    float: left;
    width: 45%;
    margin-right: 5%;
}
.role_access h4 {
    border-bottom: 1px solid #ddd;
    font-size: 15px;
    margin: 0 0 10px;
    padding-bottom: 5px;
    font-weight: 600;
}
.list_role {
    max-height: 450px;
    min-height: 300px;
    overflow: auto;
    padding:0;
}
.list_role li:first-child{margin-top:10px}
.list_role li {
    margin-top:5px;
    display: inline-block;
    width: 100%;
}
.label_move {
    display: inline-block;
    font-size: 13px !important;
    width: auto;
    cursor:pointer;
}
.label_move:hover{color:#0096D7}
tr.disabled{opacity:0.7}
</style>
<div class="assignment-index">
    <?php
      if (Yii::$app->session->hasFlash('message')){
          $msg      = Yii::$app->session->getFlash('message');
          echo '<div class="alert alert-success">
                    ' . $msg . '
                </div>';
          Yii::$app->session->setFlash('message',null);
      }

    ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => 'Không có tài khoản sale nào',
                    'summary' => '<p>Tổng <strong>{totalCount}</strong> tài khoản</p>',
                    'rowOptions' => function($model){
                        if( $model['is_active'] == 1 )
                            return ['id' => 'tr-user' . $model->id];
                        else
                            return ['class'=>'disabled', 'id' => 'tr-user' . $model->id];
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn','header' => 'STT'],
                            [
                                'attribute' => 'id',
                                'label'=>'ID',
                                'contentOptions'=> ['class'=>'text-center'],
                                'headerOptions' => ['class'=>'text-center']
                            ],
                            [
                                'attribute' => 'username',
                                'label'=>'Tài khoản',
                                // 'contentOptions'=> ['class'=>'text-center'],
                                // 'headerOptions' => ['class'=>'text-center']
                            ],
                            [
                                'attribute' => 'fullname',
                                'label'=>'Tên',
                                // 'contentOptions'=> ['class'=>'text-center'],
                                // 'headerOptions' => ['class'=>'text-center']
                            ],
                            [
                                'label'=>'Phần trăm hoa hồng',
                                'value' => function($model){
                                    return $model->commission_percentage > 0 ? $model->commission_percentage . '%' : '---';
                                },
                                'contentOptions'=> ['style'=>'max-width:250px'],
                            ],
                            [
                                'label'=>'Trạng thái',
                                'value' => function($model){
                                    return $model['is_active'] == 1 ? 'Active' : 'InActive';
                                },
                                'contentOptions'=> ['class'=>'text-center status-user'],
                                'headerOptions' => ['class'=>'text-center']
                                // 'contentOptions'=> ['class'=>'text-center'],
                                // 'headerOptions' => ['class'=>'text-center']
                            ],
                            [
                                'label'=>'Banned/UnBanned',
                                'format' => 'raw',
                                'value' => function($model){
                                    return '<input type="checkbox" class="checkbox_banned" value="' . $model['id'] . '" />';
                                },
                                'contentOptions'=> ['class'=>'text-center'],
                                'headerOptions' => ['class'=>'text-center']
                                // 'contentOptions'=> ['class'=>'text-center'],
                                // 'headerOptions' => ['class'=>'text-center']
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                            'template' => '{reset_pass}{permission}{view}{update}{delete}',
                            'buttons' => [
                                'reset_pass' => function ($model, $url) use ($searchModel) {
                                    return '<a title="Cấp lại mật khẩu" href="javascript:;" class="reset_pass" style="margin:0 5px" data-fullname="' . ($url->fullname ? $url->fullname : $url->username) . '" data-id="' . $url->id . '"><i class="ni ni-refresh"></i></a>';
                                },
                                // 'permission' => function ($model, $url) use ($searchModel) {
                                //     return '<a class="permission" href="/assignment/getpermisstion" title="Cấp quyền" name="' . $url->username . '" id="' . $url['id'] . '"><i class="fal fa-list"></i></a>';
                                // },
                                // 'view' => function ($model, $url) use ($userCurrent,$searchModel) {
                                //     return '<a title="Xem chi tiết tài khoản" style="margin:0 0 0 8px" href="/assignment/view?id=' . $url['id'] . '"><i class="fal fa-search"></i></a>';
                                // },
                                'update' => function ($model, $url) use ($userCurrent,$searchModel) {
                                    return '<a title="Cập nhật tài khoản" style="margin:0 8px" href="/sale-admin/update-sale?id=' . $url['id'] . '"><i class="fal fa-pencil"></i></a>';
                                },
                                'delete' => function ($model, $url) use ($userCurrent,$searchModel) {
                                    $username = $url->username;

                                    return '<a class="btn_banned" title="Banned tài khoản" dtname="' . $username . '" dtid="' . $url['id'] . '" href="javascript:;"><i class="fal fa-ban"></i></a>';
                                }
                            ],
                            ]
                    ]
                ]);
            ?>
            <?php Pjax::end(); ?>
            <div class="row_button" style="text-align:right">
                <button class="btn btn-primary btn-change-status">Banned/UnBanned</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-form" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 90%; max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #886ab5; color: #fff;">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center"><i class="fal fa-spin fa-spinner"></i></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="display:none" id="btn-submit-modal" class="btn btn-primary"><i class="fal fa-spin fa-spinner loading-submit-form hide"></i> Cập nhật</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<style>
.date-create{color:gray}
table.table.table-striped.table-bordered td,table.table.table-striped.table-bordered th {
    vertical-align: middle;
}
.modal.opacity_hide{z-index:1100}
@media (max-width: 768px) {
    #modal-form .modal-dialog{
        max-width: 95% !important;
        width: 100% !important;
    }
}
</style>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var uid = 0;
        $('.reset_pass').click(function(){
            var _this = $(this);
            uid = _this.attr('data-id');
            $('#modal-form .modal-title').html('Cấp lại mật khẩu - Tài khoản ' + _this.attr('data-fullname'));
            $('#modal-form .modal-dialog').attr('style','width: 90%; max-width: 800px;');
            $('#btn-submit-modal').show();
            $('#modal-form').modal('show').find('.modal-body').load('/sale-admin/reset-password');
        });
        $('#btn-submit-modal').click(function(){
            toastr.remove();
            var _this           = $(this);
            var password_new    = $('#password_new').val();
            var password_renew  = $('#password_renew').val();
            var password        = $('#password').val();
            if( password_new == '' ){
                $('#password_new').focus();
                toastr['error']('Nhập mật khẩu mới');
            }else if( password_new.length < 6 ){
                $('#password_new').focus();
                toastr['error']('Mật khẩu mới tối thiểu 6 ký tự');
            }else if( password_renew == '' ){
                $('#password_renew').focus();
                toastr['error']('Nhập lại mật khẩu mới');
            }else if( password_renew != password_new ){
                $('#password_renew').focus();
                toastr['error']('Nhập lại mật khẩu mới không trùng khớp');
            }else if( password == '' ){
                $('#password').focus();
                toastr['error']('Nhập mật khẩu tài khoản của bạn');
            }else if(_this.find('.fal').hasClass('hide')){
                _this.find('.fal').removeClass('hide');
                $.ajax({
                    type : 'POST',
                    url : '/sale-admin/reset-password',
                    data : {id : uid, password_new : password_new, password_renew: password_renew, password : password},
                    success:function(res){
                        _this.find('.fal').addClass('hide');
                        if( res.status ){
                            $('#modal-form').modal('hide');
                            toastr['success'](res.msg);
                        }else{
                            toastr['error'](res.msg);
                        }
                    },
                    error:function(){
                        _this.find('.fal').addClass('hide');
                        toastr['error']('Có lỗi! Không thể cấp lại mật khẩu');
                    }
                })
            }
        });
    });
</script>