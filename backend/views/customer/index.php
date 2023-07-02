<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\OrderWork;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoachSectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Khách hàng';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách khách hàng đăng ký';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-users';
?>

<div class="course-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card mb-g">
        <div class="card-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => 'Không có khách hàng nào',
                'summary' => "<p class='summary_data'>Hiển {begin} - {end} trong tổng số <b>{totalCount}</b> khách hàng</p>",
                'layout'=> "{summary}\n{items}\n<div class='page-navigation'>{pager}</div>",
                'rowOptions'=>function($model){
                    return ['id'=>'tr-user-'.$model->id];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'Thông tin khách hàng',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<p style="margin-bottom: 0;"><b>' . $model['fullname'] . '</b></p>';
                            $html .= '<p style="margin-bottom: 0;">Email: <b>' . ($model['email'] ? $model['email'] : '---') . '</b></p>';
                            $html .= '<p style="margin-bottom: 0;">SĐT: <b>' . ($model['phone'] ? $model['phone'] : '---') . '</b></p>';
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
                    [
                        'label'=>'Trạng thái',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html_info = '';
                            if( $model->status == 1 )
                                $html_info = '<i class="tooltip" data-placement="bottom" title="Đang hoạt động"><i class="fal fa-info"></i></i>';
                            else if( $model->status == 0 )
                                $html_info = '<i class="tooltip" data-placement="bottom" title="Bị cấm đăng nhập"><i class="fal fa-info"></i></i>';
                            else if( $model->status == 2 )
                                $html_info = '<i class="tooltip" data-placement="bottom" title="Đăng nhập quá nhiều thiết bị"><i class="fal fa-info"></i></i>';
                            return \backend\controllers\CommonController::getStatusNameUser($model->status) . $html_info;
                        },
                        'contentOptions' => ['style'=>'position:relative']
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class'=>'text-center'],
                    'template' => '{view}{history_order}{history_signin}{resetpass}{delete}',
                    'buttons' => [
                        // 'view' => function ($model, $url) use ($controller)  {
                            
                        //     return '<a title="Xem chi tiết" href="/' . $controller . '/view?id=' . $url->id . '"><i class="fal fa-search"></i></a>';
                        // },
                        'history_signin' => function ($model, $url) use ($controller)  {
                            
                            return '<a style="margin:0 5px" title="Thông tin thiết bị đăng nhập" class="view_history_login" data-fullname="' . (!empty($url->fullname) ? $url->fullname : $url->phone) . '" data-id="' . $url->id . '" href="javascript:;"><i class="fal fa-sign-in"></i></a>';
                        },
                        'history_order' => function ($model, $url) use ($controller)  {
                            
                            return '<a style="margin:0 5px" title="Lịch sử mua khoá học" class="view_history_order" data-fullname="' . (!empty($url->fullname) ? $url->fullname : $url->phone) . '" data-id="' . $url->id . '" href="javascript:;"><i class="fal fa-history"></i></a>';
                        },
                        'resetpass' => function ($model, $url) use ($controller)  {
                            return '<a title="Cấp lại mật khẩu" href="javascript:;" class="reset_pass" style="margin:0 5px" data-fullname="' . $url->fullname . '" data-id="' . $url->id . '"><i class="ni ni-refresh"></i></a>';
                        },
                        'delete' => function ($model, $url) use ($controller)  {
                            if( $url->status == 1 )
                                return '<a style="margin-left:5px" title="Khoá" onclick="return confirm(\'Bạn có chắc chắn muốn khoá tài khoản khách hàng này?\')" href="/' . $controller . '/banned?id=' . $url->id . '"><i class="fal fa-ban"></i></a>';
                            else if( $url->status == 0)
                                return '<a style="margin-left:5px" title="Mở khoá" onclick="return confirm(\'Bạn có chắc chắn muốn mở khoá tài khoản khách hàng này?\')" href="/' . $controller . '/unbanned?id=' . $url->id . '"><i class="fal fa-check"></i></a>';
                            else if( $url->status == 2 )
                                return '<a style="margin-left:5px" title="Mở khoá đăng nhập" onclick="return confirm(\'Bạn có chắc chắn muốn mở khoá đăng nhập tài khoản khách hàng này?\')" href="/' . $controller . '/unlock?id=' . $url->id . '"><i class="fal fa-unlock"></i></a>';
                            return '';
                        }
                    ],
                    ],
                ],
            ]); ?>
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
        $('.view_history_login').click(function(){
            var _this = $(this);
            uid = _this.attr('data-id');
            $('#btn-submit-modal').hide();
            $('#modal-form .modal-dialog').attr('style','width: 80%; max-width: none;');
            $('#modal-form .modal-title').html('Khách hàng ' + _this.attr('data-fullname') + ' - Thông tin thiết bị đăng nhập');
            $('#modal-form').modal('show').find('.modal-body').load('/<?= $controller ?>/history-login?user_id=' + uid);
        });
        $('.view_history_order').click(function(){
            var _this = $(this);
            uid = _this.attr('data-id');
            $('#btn-submit-modal').hide();
            $('#modal-form .modal-dialog').attr('style','width: 80%; max-width: none;');
            $('#modal-form .modal-title').html('Khách hàng ' + _this.attr('data-fullname') + ' - Lịch sử mua khoá học');
            $('#modal-form').modal('show').find('.modal-body').load('/<?= $controller ?>/history-order?user_id=' + uid);
        });
        $(document).on('click','.view_work_detail',function(e){
            e.preventDefault();
            var _this = $(this);
            var id = _this.attr('data-id');
            $('#modal-form').addClass('opacity_hide');
            $('#modal-order .modal-dialog').attr('style','width: 90%; max-width: none;');
            $('#modal-order .modal-title').html('Chi tiết đơn hàng #' + id);
            $('#modal-order').modal('show').find('.modal-body').load(_this.attr('href'));
        });
        $('#modal-order').on('hidden.bs.modal', function () {
            $('#modal-form').removeClass('opacity_hide');
            $('body').addClass('modal-open');
        });

        $('.reset_pass').click(function(){
            var _this = $(this);
            uid = _this.attr('data-id');
            $('#modal-form .modal-title').html('Cấp lại mật khẩu - Khách hàng ' + _this.attr('data-fullname'));
            $('#modal-form .modal-dialog').attr('style','width: 90%; max-width: 800px;');
            $('#btn-submit-modal').show();
            $('#modal-form').modal('show').find('.modal-body').load('/customer/reset-password');
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
                    url : '/customer/reset-password',
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
<div class="modal fade" id="modal-order" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 80%; max-width: none;">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>