<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Employee;
use backend\models\Category;
use yii\helpers\ArrayHelper;
use backend\controllers\CommonController;

$listCategory = ArrayHelper::map(Category::find()->where(['status'=>1,'is_delete'=>0])->all(), 'id', 'name');

$this->title = 'Quản lý bài viết';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs']['description_page'] = 'Quản lý danh sách bài viết';
$controller = Yii::$app->controller->id;
$this->params['breadcrumbs']['icon_page'] = 'fa-newspaper';
$params =  Yii::$app->params;

$this->registerJS('
    var url = "";
    var tm;
    $(".btn-action").click(function(e){
        e.preventDefault();
        var _this = $(this);
        // _this.tooltip("hide");
        url = _this.attr("href");
        if( _this.hasClass("reject-publish") || _this.hasClass("reject") || _this.hasClass("reject-approve") ){
            var titlePopup = _this.hasClass("reject") ? "Từ chối duyệt bài" : (_this.hasClass("reject-publish") ? "Gỡ bài viết xuống" : "Từ chối xuất bản");
            $("#modal-form .modal-title").html( titlePopup );
            
            $("#modal-form").modal("show").find(".modal-body").load(url);
        }else{
            var txt_confirm = "";
            if( _this.hasClass("delete") ){
                txt_confirm = "Bạn có chắc chắn muốn xoá bài viết này?";
            }else if( _this.hasClass("request-approve") ){
                txt_confirm = "Bạn có chắc chắn muốn gửi xét duyệt bài viết này?";
            }else if( _this.hasClass("approved") ){
                txt_confirm = "Bạn có chắc chắn muốn duyệt bài viết này?";
            }else if( _this.hasClass("publish") ){
                txt_confirm = "Bạn có chắc chắn muốn đăng bài viết này?";
            }
            if( _this.find(".fal").length <= 0 && txt_confirm !== "" && confirm(txt_confirm)){
                _this.append(" <i class=\'fal fa-spin fa-spinner\'></i>");
                clearTimeout(tm);
                toastr.remove();
                $.ajax({
                    type: "GET",
                    url : url,
                    data: {},
                    success: function(res){
                        _this.find(".fal").remove();
                        if( res.errorCode == 0 ){
                            $(".table tr[data-key=" + res.data.id + "]").remove();
                            toastr["success"](res.message);
                            tm = setTimeout(function(){
                                window.location.reload();
                            }, 2000);
                        }else{
                            toastr["error"](res.message);
                            $(".tooltip").remove();
                        }
                    },
                    error: function(){
                        _this.find(".fal").remove();
                        toastr["error"]("Có lỗi! Vui lòng liên hệ Quản trị");
                    }
                })
            }
        }
    });
    var process = false;
    $("#btn-submit-modal").click(function(){
        toastr.remove();
        var value = $.trim($("#news-reason").val());
        if( value == "" ){
            $("#news-reason").focus();
            toastr["error"]("Vui lòng nhập lý do");
        }else{
            if( $("#btn-submit-modal .fal:not(.hide)").length > 0 )
                return false;

            $("#btn-submit-modal .fal").removeClass("hide");
            process = true;
            
            $.ajax({
                type: "POST",
                url : url,
                data: {reason: value},
                success: function(res){
                    $("#btn-submit-modal .fal").addClass("hide");
                    if( res.errorCode == 0 ){
                        $(".table tr[data-key=" + res.data.id + "]").remove();
                        setTimeout(function(){
                            process = false;

                            if( $(".grid-view .table tbody tr").length <= 0 ){
                                window.reload();
                            }
                        },1000);
                        toastr["success"](res.message);
                        $("#modal-form").modal("hide");
                    }else{
                        process = false;
                        toastr["error"](res.message);
                    }
                },
                error: function(){
                    process = false;
                    $("#btn-submit-modal .fal").addClass("hide");
                    toastr["error"]("Có lỗi! Vui lòng liên hệ Quản trị");
                }
            });
        }
    });
');
?>
<div class="projects-index">
    <?php 
        //echo $this->render('_menu',['tab' => $searchModel->tab]);
    ?>
    <div class="tab-content mt-1">
        <?php echo $this->render('_search', ['model' => $searchModel, 'roleCreate'=>CommonController::checkAccess('/' . $controller . '/create')]); ?>
        
        <div class="card mb-g">
            <div class="card-body table-responsive list-news-index">
                <?php
                    $template_index = '_index_' . $searchModel->tab;
                    echo $this->render($template_index, [
                        'dataProvider' => $dataProvider
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
<style>
    .table td p{
        margin-bottom:5px;
    }
    .table td p:last-child{
        margin-bottom:0;
    }
    .td_action a{
        display: inline-block;
        width: 100%;
        text-align: left;
        margin-bottom:5px;
    }
    .td_action a:last-child{
        margin-bottom:0;
    }
    .select2-container{
        width: 100% !important;
    }
    .img-grid {
        max-width: 100%;
    }
</style>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:850px; max-width: none;">
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
                <button type="button" id="btn-submit-modal" class="btn btn-primary"><i class="fal fa-spin fa-spinner loading-submit-form hide"></i> <span>Xác nhận</span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>