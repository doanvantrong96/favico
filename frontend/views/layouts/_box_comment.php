<?php
    $avatar = '<i class="icon-user-comment"></i>';
    $avatarUser     = '';
    if( Yii::$app->user->identity && Yii::$app->user->identity->fb_id != '' ){
        $avatarUser = '<img src="https://graph.facebook.com/' . Yii::$app->user->identity->fb_id . '/picture?type=normal" width="39" height="39" style="border-radius:50%" />';
    }else
        $avatarUser     = $avatar;
?>
    <!-- <p>Chưa có bình luận nào. Hãy là người đầu tiên.</p> -->
<section id="lesson-comment" class="lesson-comment">
    <h3 class="section-title">Bình luận</h3>
    <div class="form-comment">
        <?= $avatarUser ?>
        <div class="right-form">
            <div class="box-input">
                <textarea rows="3" class="form-control area_comment" id="area_comment" placeholder="<?= isset($placeholder) ? $placeholder : '' ?>"></textarea>
            </div>
            <span class="btn-comment" dtid="0">Bình luận</span>
        </div>
    </div>
    <div class="data-comment"></div>
</section>
<style type="text/css">
.box-content h4{font-size:18px}
.lesson-comment{border-bottom:0 !important}
.form-comment > img,.item-comment > img,.item-comment-child > img{width:39px;height:39px}
.form-comment,.item-comment,.item-comment-child { display: flex;    border-bottom: 1px solid rgb(230,231,232);
    margin-bottom: 25px;
    padding-bottom: 25px; }
.right-form {
    display: inline-block;
    width: calc(100% - 55px);
    margin-left: 15px;
}
.right-form .box-input{
    display: flex;
    padding:10px;
    border: 1px solid rgb(230,231,232);
}
.area_comment {
    outline: none !important;
    border: 0 !important;
    box-shadow: none !important;
    padding: 0 5px;
    margin-bottom: 0;
}
.btn-comment { background-color: #f54040; color: #fff; padding: 9px 20px; display: inline-block; margin: 10px 0 0;cursor: pointer; }
.btn-comment:hover{background-color: #f54040e0}
.btn-comment.disabled{cursor: progress;}
.info-comment {
    display: inline-block;
    width: calc(100% - 55px);
    margin-left: 15px;
}
.content-comment { margin: 6px 0 10px; }
.action-comment span { color: #666;font-weight:500; display: inline-block; margin-right: 10px; cursor: pointer; }
.action-comment span.reply-comment,.action-comment span.reply-comment .total-reply{ color: #337ab7}
.comment-child {
    display: inline-block;
    width: 100%;
    margin-top: 15px;
    position: relative;
    background-color: #F3F3F4;
}
.comment-child.active:after {
    content: '';
    display: block;
    position: absolute;
    left: 15px;
    bottom: 100%;
    width: 0;
    height: 0;
    border-bottom: 11px solid #F3F3F4;
    border-top: 11px solid transparent;
    border-left: 11px solid transparent;
    border-right: 11px solid transparent;
}
.item-comment-child {
    margin-left: 20px;
    margin-right: 20px;
    width: calc(100% - 40px);
    padding-bottom: 20px;
    margin-bottom: 20px;
}
.item-comment-child:first-child{padding-top:20px}
.item-comment:last-child,.item-comment-child:last-child {
    border: 0;
    padding-bottom: 0;
}
.icon-user-comment{
    background: url(/images/icon-user.svg) no-repeat;
    width: 39px;
    height: 39px;
    display: inline-block;
    background-size: 100%;
}
.action-comment span.reply-0{display:none}
.form-comment.form-comment-child {
    padding: 15px 20px;
    border-bottom: 0;
    margin-bottom: 0;
}
.form-comment.form-comment-child .right-form .box-input {
    display: flex;
    padding: 0;
    border: 0;
}
.form-comment.form-comment-child .area_comment{padding:5px;min-height: 80px;}
.action-comment span.total-reply{margin-right:0}
.time-comment{color:#666;font-size:14px}
.dot{
    display: inline-block;
    font-size: 14px;
    vertical-align: middle;
    margin:-5px 0px 0;
    color: #babbb8;
}
.box-content h4 {
    font-size: 20px;
    padding-bottom: 15px;
    margin-bottom: 15px;
    text-transform: uppercase;
}
.comment-child .btn-comment{padding: 6px 20px;}
</style>
<!-- <script type="text/javascript" src="/js/jquery.min.js"></script> -->
<script type="text/javascript">
    var getComment = function(){
        $.ajax({
            url : '/comment/list-comment',
            type : 'POST',
            data : {id : '<?= $id ?>', type : '<?= $type ?>'},
            success:function(res){
                $('.data-comment').html(res);
            }
        });
    }
    jQuery(document).ready(function($){
        getComment();
        $(document).on('click','.reply-comment',function(){
            if( $(this).parent().parent().find('.comment-child .form-comment-child').length <= 0 ){
                var id = $(this).attr('dtid');
                $(this).parent().parent().find('.comment-child').append('<div class="form-comment form-comment-child"><?= $avatarUser ?><div class="right-form"><div class="box-input"><textarea rows="2" class="form-control area_comment" placeholder="Câu trả lời của bạn"></textarea></div><span class="btn-comment" dtid="' + id + '">Trả lời</span></div></div>');
            }else{
                $(this).parent().parent().find('.comment-child .area_comment').focus();
            }
        });
        $(document).on('click','.btn-comment',function(){
            var area_comment = $.trim($(this).parent().find('.area_comment').val());
            if( area_comment == '' ){
                $(this).parent().find('.area_comment').focus();
            }else{
                var _this = $(this);
                if( _this.hasClass('disabled') )
                    return false;
                _this.addClass('disabled');
                var parent_id = parseInt(_this.attr('dtid'));
                $.ajax({
                    url : '/comment/create',
                    type : 'POST',
                    data : {id : '<?= $id ?>', parent_id : parent_id, comment : area_comment, type : '<?= $type ?>'},
                    success:function(res){
                        _this.removeClass('disabled');
                        if( res.status ){
                            if( parent_id > 0 ){
                                $('.item-parent-' + parent_id + ' .comment-child').addClass('active').prepend(res.item);
                                _this.parent().find('.area_comment').val('');
                                var total_reply = parseInt($('.reply-comment[dtid="' + parent_id + '"] .total-reply').html()) + 1;
                                $('.reply-comment[dtid="' + parent_id + '"] .total-reply').removeClass('reply-0').html(total_reply);
                            }else{
                                $('#area_comment').val('');
                                $('.data-comment').prepend(res.item);
                            }
                        }else{
                            if( typeof res.login != 'undefined' ){
                                $('#modal .modal-content').load('/dang-nhap',function(){
                                    setTimeout(function(){
                                        $('#modal').modal('show');
                                    }, 500);
                                });
                            }
                            else{
                                toastr['error'](res.message);
                            }
                        }
                        
                    }
                });
            }
        });
    });
</script>