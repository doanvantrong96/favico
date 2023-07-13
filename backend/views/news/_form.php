<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;
use backend\models\News;
use backend\controllers\CommonController;

$listCategory = ArrayHelper::map(Category::find()->where(['status'=>1,'is_delete'=>0])->all(), 'id', 'name');

$disabledEditForm = $model->status == News::PUBLISHED && !Yii::$app->user->identity->is_admin  && !CommonController::checkRolePermission('edit_all_post');
if( $disabledEditForm ){
    $this->registerJS('
        $("#form_post").submit(function(event){event.preventDefault();});
        $("#form_post").find("input, textarea").prop("disabled", true);
        $("#form_post").find("select option").prop("disabled", true);
        $("#form_post").find("select.select2").trigger("change.select2");
        $(".reload_category,.add_category,.field-news-tag > label a, #gallery .button_action_image").remove();
        setTimeout(function(){
            CKEDITOR.config.readOnly = true;
            $(".select2-selection__choice__remove").remove();
        },1000);
    ');
}else{
    $this->registerJs('
    var flagSendValidate = true;
    var isSubmit = true;
    var tm;
    $("#form_post").on("submit", function (event) { 
        event.preventDefault();
        if( !flagSendValidate || !isSubmit )
            return false;
        var _this = $(this);
        clearTimeout(tm);
        tm = setTimeout(function(){
            if( _this.find(".has-error").length <= 0 ){
                flagSendValidate = false;
                var form      = _this[0];
                var form_data = new FormData(form);
                $.ajax({
                    url: _this.attr("action"), 
                    dataType: "JSON",  
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: "post",                        
                    beforeSend: function() {},
                    success: function(response){
                        if( response.constructor === Object && Object.keys(response).length > 0 ){
                            Object.keys(response).map(function(key, index){
                                $(form).yiiActiveForm("updateAttribute", key, [response[key]]);
                            });
                            setTimeout(function(){
                                $("html, body").animate({ scrollTop: _this.find(".has-error").offset().top - 50}, 500 );
                            }, 300);
                        }else{
                            form.submit();
                            isSubmit = false;
                        }
                    },
                    complete: function() {
                        setTimeout(function(){
                            flagSendValidate = true;
                        }, 1000);
                    },
                    error: function (data) {
                         
                    }
                });     
            }else{
                $("html, body").animate({ scrollTop: _this.find(".has-error").offset().top - 50}, 500 );
            }
        }, 300);
        
                   
        return false;
    });
');
}
?>
<style type="text/css">
    .gallery-photo {position: absolute; top: 0; right: 0; margin: 0; opacity: 0; -ms-filter: 'alpha(opacity=0)'; font-size: 200px; direction: ltr; cursor: pointer}
    .list_ul {margin:0;padding:0}
    .list_ul li{list-style:none;margin-bottom:6px}
    #preview-img{width:100%;
    max-height: 200px;
    object-fit: contain;
    margin: 5px 0 0;}
    #gallery{position:relative}
    .button_action_image { float: right; font-size: 13px;}
    .control-label{width:100%}
    #placeholder-note{float:right}
    div#feed-form-text {min-height:70px;max-height:150px; overflow: auto; border: 1px solid #dddd; padding: 10px; font-size: 15px; line-height: 26px;outline: none !important; }
    .box-hash-tag { position: absolute; width: 300px; box-shadow: rgba(101, 119, 134, 0.2) 0px 0px 15px, rgba(101, 119, 134, 0.15) 0px 0px 3px 1px; padding: 0; z-index: 10; background-color: #fff; border-radius: 3px; overflow: auto; max-height: 200px; }
    #cke_feed-form-text{display:none !important}
    .item-hash-tag { float: left; width: 100%; padding: 10px; border-bottom: 1px solid #ddd; font-weight: 500; font-size: 15px; }
    #feed-form-text font{color:#000}
    .box-hash-tag{top:95px !important}
    .hash-tag{margin-bottom: 10px; display: inline-block;}
    .hash-tag:after{content:""}
    #viewNews img { width: 100%}
</style>

<div class="news-form">
    <?php
        if( $disabledEditForm ){
    ?>
        <div class="alert alert-warning keep">
            <i class="fal fa-exclamation-triangle"></i> Cảnh báo: Bài viết đã được xuất bản. Bạn không có quyền sửa bài viết này!
        </div>
    <?php } ?>
    <?php $form = ActiveForm::begin(['id'=>'form_post','enableAjaxValidation' => true]); ?>
        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control remove-unicode'])->label('Tiêu đề') ?>
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'class'=>'form-control set-unicode'])->label('Slug') ?>
                <?= $form->field($model, 'description')->textarea(['class'=>'form-control input-max-length','maxlength'=>true,'style'=>'height: 100px;']); ?>
                <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 200,'class'=>'form-control']) ?>
                <?= $form->field($model, 'seo_description')->textarea(['class'=>'form-control','maxlength'=>300,'style'=>'height: 60px;']); ?>
                <?= $form->field($model, 'related_news')->dropDownList($related_news,['data-url'=> '/common/get-related-news', 'data-id-igrs' => ($model->isNewRecord ? 0 : $model->id) , 'data-placeholder'=>'Nhập tên bài viết liên quan', 'class' => 'form-control select2 ajax disabled-close', 'multiple' => 'multiple' ])->label('Bài viết liên quan') ?>
            </div>

            <div class="col-md-4">
                <?php 
                    $category_id       = is_array($model->category_id) ? $model->category_id : [];
                    echo $form->field($model, 'category_id')->dropDownList($listCategory,['data-placeholder'=>'Nhập tên chuyên mục', 'class' => 'form-control select2', 'multiple' => 'multiple' ])->label('Chuyên mục');
                ?>
                         
                <div id="gallery">
                    <label class="control-label" style="width:100%">
                        Ảnh
                        <span class="blue fileinput-button" style="color: #337ab7;float:right" id="fileinput">
                            <i class="fal fa-plus"></i>
                            <span>Thêm ảnh mới</span>
                            <input class="gallery-photo file-upload-ajax" data-folder="images/news" accept="image/*" style="width:10px" type="file" id="gallery-photo-add">
                        </span>
                        <?= $form->field($model, 'image')->hiddenInput(['id'=>'post_avatar','class'=>'input-hidden-value'])->label(false) ?>
                        <div class="meter" style="display:none;margin:10px 0">
                            <span style="width:0"></span>
                            <i></i>
                        </div>
                        <img id="preview-img" class="img-preview" src="<?= $model->image ?>" style="<?= $model->image != '' ? '' : 'display:none' ?>" />
                    </label>
                    
                </div>
                <?php
                    $action_hide            = '/news/reject';
                    $action_published       = '/news/published';
                    $permission_hide        = CommonController::checkAccess($action_hide);
                    $permission_published   = CommonController::checkAccess($action_published);
                ?>
                
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'content')->textarea(['id'=>'editor','class'=>'form-control','style'=>'height: 510px;']); ?>
            </div>
            
            <?php if( !$disabledEditForm ){ ?>
                <div class="col-md-12" style="position: relative; z-index: 10;">
                    <div class="button_action text-center">
                        <input type="hidden" name="" value="1" id="input_type_submit" />
                        <?= $form->field($model, 'is_edit_post')->hiddenInput(['id'=>'is_edit_post'])->label(false); ?>
                        <?php
                            if( !$model->isNewRecord ){

                                if( $permission_published && in_array($model->status, [News::DRAFT, News::HIDE]) ){
                                    echo Html::Button('<i class="fal fa-check"></i> Đăng bài', ['type' => $model->image ? 'submit' : 'button','name'=>'save_published','style'=>'width:110px;margin-right:3px','class' => 'btn btn-success']);
                                }

                                if( $permission_hide && in_array($model->status, [News::PUBLISHED]) )
                                    echo Html::Button('Ẩn bài', ['type' => $model->image ? 'submit' : 'button', 'name'=>'save_hide','style'=>'width:130px;','class' => 'btn btn-success']);
                                
                            } 
                        ?>
                        <?= Html::Button($model->isNewRecord ? '<i class="fal fa-plus"></i> Đăng bài' : '<i class="fal fa-save"></i> Cập nhật', ['type' => !$model->isNewRecord ? 'submit' : 'button','name'=>'save_published','style'=>'width:110px;','class' => 'btn btn-primary']) ?>
                        <?php
                            if( $model->isNewRecord ){
                                echo Html::submitButton('Lưu nháp', ['name'=>'save_draft','style'=>'width:100px','class' => 'btn btn-warning']);
                            } 
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<link rel="stylesheet" href="/css/dropzone.css" />
<link href="/css/cropper.css" rel="stylesheet"/>
<script src="/js/dropzone.js"></script>
<script src="/js/cropper.js"></script>
<script src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
<div class="modal fade" id="modal_crop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: bold; color: #000;">Cắt ảnh trước khi tải lên</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="image_crop" />
                        </div>
                        <div class="col-md-4" style="padding-left:30px">
                            <div class="preview_crop"></div>
                            <div class="col-md-12" style="padding-left:0;margin-top: 15px;display:flex">
                                <input type="number" style="width: calc(100% - 25px);" class="form-control" value="90" placeholder="Nhập số từ 1 -> 100" maxlength="3" id="quality_image" />
                                <span data-toggle="tooltip" data-placement="bottom" style="background-color: #007BFF; color: #fff; width: 20px; height: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-left: 5px; position: relative; top: 8px; cursor: help;" class="fal fa-info" title="Phần trăm chất lượng ảnh so với ảnh gốc sau khi upload (%)"></span>
                            </div>
                            <div class="col-md-12" style="padding-left:0;margin-top: 15px;">
                                <button type="button" data-id="crop" class="btn btn-primary btn-crop"><i class="fal fa-spin fa-spinner hide loading-crop"></i> Cắt và tải lên</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>			
<style>
.list-cate{
    list-style: none;
    padding: 0 0 0 10px;
    overflow-x: auto;
    max-height: 130px;
    margin-top: 0;
    margin-bottom:0;
}
.list-cate > li:first-child { margin-top: 10px; }
.list-cate .li_parent{
    width:100%;
    margin-bottom:8px;
}
.list-cate .li_parent label{font-weight:400;display: flex;
    align-items: center;}
.list-cate .li_parent label input{
    margin-right:5px;
}
.list-cate .li_parent ul{
    padding-left:15px;
    list-style: none;
}
.list-cate .li_parent ul li{
    margin-top:6px;
}
img#image_crop {
    width: 100%;
}
.preview_crop {
    overflow: hidden;
    width: 160px; 
    height: 160px;
    margin-bottom: 10px;
    border: 1px solid red;
}
.button_action{
    position: fixed;
    bottom: 30px;
    transform: translate(-50%, 0);
    left: 50%;
    margin-left: 0;
}
.button_action .btn{
    padding:0.5rem .9rem;
    margin-bottom:15px;
}
#video_player{
    margin-top:10px;
}
.box-loading-upload{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 100000;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0,0,0,.5);
    color: #f3e151;
}
.box-loading-upload img{
    width:50px;
    margin-right:-8px;
}
</style>
<script type="text/javascript">
    var processUpload = false;
    var uploadImage = function(image,_modal,_elementButton){
        var formData = new FormData();
        formData.append("image",image);
        formData.append("folder",'news');
        formData.append("quality", $('#quality_image').val() );
        processUpload = true;
        $.ajax({
            url: "/common/upload-image-base64",
            type: "POST",
            data : formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $("#gallery .meter > span").width(percentComplete + '%');
                        var percentCompleteShow = percentComplete.toFixed(1);
                        percentCompleteShow     = percentCompleteShow.toString().replace('.0','');
                        $("#gallery .meter > i").html(percentCompleteShow+'%');
                        if( percentComplete == 100 ){
                            setTimeout(function(){
                                $("#gallery .meter").slideUp();
                            }, 1000);
                        }
                    }
                }, false);
                return xhr;
            },
            beforeSend: function() {
                $("#gallery .meter").slideDown();
                $("#gallery .meter > span").width('0%');
                $("#gallery .meter > i").html('');
            },
            success: function(data){
                processUpload = false;
                _elementButton.find('.loading-crop').addClass('hide');
                let result = JSON.parse(data);
                if( result.status ){
                    _modal.modal('hide');
                    $('#preview-img').attr('src',result.url).show();
                    $('#post_avatar').val(result.url);
                    toastr['success'](result.message);
                }else{
                    toastr['error'](result.message);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                processUpload = false;
                _elementButton.find('.loading-crop').addClass('hide');
                toastr['error'](thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    jQuery(document).ready(function(){
        
        $('#form_post .form-control:not(.reason), #form_post select').change(function(){
            $('#is_edit_post').val(1);
        });
        if( $('#editor').length > 0 ){
            CKEDITOR.timestamp='<?= strtotime('2022-07-14') ?>';
            CKEDITOR.config.removePlugins = 'flash';
            CKEDITOR.config.removeButtons = 'Flash';
            CKEDITOR.config.language = 'vi';
            var editor = CKEDITOR.replace('editor', {
                extraPlugins: "image2,wordcount,notification",
                removePlugins: 'image,scayt,wsc,language',
                image2_alignClasses: [ 'align-left', 'align-center', 'align-right' ],
                // filebrowserBrowseUrl: '/assets/global/plugins/ckeditor/ckfinder/ckfinder.html',
                // filebrowserUploadUrl: '/assets/global/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&currentFolder=<?= date('Y/m/d') ?>&type=Hình ảnh',
                filebrowserBrowseUrl: '/assets/global/plugins/ckeditor/ckfinder/ckfinder.html?type=Video',
                filebrowserImageBrowseUrl: '/assets/global/plugins/ckeditor/ckfinder/ckfinder.html?type=Images',
                filebrowserUploadUrl: '/assets/global/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&currentFolder=<?= date('Y/m/d') ?>&type=Video',
                filebrowserImageUploadUrl: '/assets/global/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&currentFolder=<?= date('Y/m/d') ?>&type=Images',
                filebrowserWindowWidth: '1000',
                filebrowserWindowHeight: '700',
                height: '500px',
                allowedContent: {
                    script: true,
                    div: true,
                    $1: {
                        // This will set the default set of elements
                        elements: CKEDITOR.dtd,
                        attributes: true,
                        styles: true,
                        classes: true
                    }
                },
                wordcount: {
                    showWordCount: true,
                    showCharCount: true,
                    filter: new CKEDITOR.htmlParser.filter({
                        elements: {
                            div: function( element ) {
                                if(element.attributes.class == 'mediaembed') {
                                    return false;
                                }
                            }
                        }
                    })
                },
                on: {
                    dialogShow: function( evt ) {
                        var dialog = evt.data;
                        if ( dialog._.name === 'image2' && !dialog._.model.data.src ) {
                            evt.data.getContentElement( 'info', 'hasCaption' ).setValue( true );
                        }else if ( dialog._.name === 'html5video' && !dialog._.model.ready ) {
                            evt.data.getContentElement( 'info', 'responsive' ).setValue( true );
                            evt.data.getContentElement( 'info', 'controls' ).setValue( true );
                        }
                    }
                }
            } );
            editor.on( 'fileUploadRequest', function( evt ) {
                var fileLoader = evt.data.fileLoader,
                xhr = fileLoader.xhr;
                if( $('.box-loading-upload').length <= 0 )
                    $('body').append('<div class="box-loading-upload"> <img src="/img/loading-upload.svg" /> Đang tải file lên (<span class="percent_complete">0</span>%) </div>');

                $('.box-loading-upload').show();
                xhr.upload.onprogress = function(e){
                    if (e.lengthComputable){
                        var percentComplete = parseInt((e.loaded / e.total) * 100);
                        $('.box-loading-upload .percent_complete').text(percentComplete);
                        if( percentComplete == 100 )
                            $('.box-loading-upload').hide();
                    }
                };
            } );
            
            editor.on( 'fileUploadResponse', function( evt ) {
                $('.box-loading-upload').hide();
            } );
            editor.on('change',function(){
                $('#is_edit_post').val(1);
            });
            $(window).resize(function(){
                if(screen.width === window.innerWidth){
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) { /* Safari */
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) { /* IE11 */
                        document.msExitFullscreen();
                    }
                }
            })
        }
        
        $('#news-reason').keyup(function(){
            if( $(this).val() !== '' ){
                $('.btn-reject').attr('type','submit');
            }else{
                $('.btn-reject').attr('type','button');
            }
        });
        $('.btn-reject:not([type=submit])').click(function(){
            $('.form-reject').removeClass('hide');
            if( $('#news-reason').val() == '' )
                $('#news-reason').focus();

        });
        $('#form_post .btn-success:not([type=submit]),#form_post .btn-primary:not([type=submit])').click(function(){
            toastr.remove();
            if( $('#post_avatar').val() == "" )
                toastr['error']('Vui lòng tải ảnh bài viết');
            else{
                $('#form_post').submit();
            }
        });
        $('.preview_post').click(function(){
            // toastr['error']('Chức năng đang cập nhật');
        });
        $(document).on('click','.input_cat',function(){
            var is_parent = !$(this).hasClass('cat_child');
            if( !is_parent ){
                var input_cat_parent = $('.input_cat[value="' + $(this).attr('data-parent') + '"]');
                if( $(this).is(':checked') ){
                    input_cat_parent.prop('checked',true);
                }else{
                    var _parent = input_cat_parent.parent().parent();
                    if( _parent.find('ul .input_cat:checked').length <= 0 )
                        input_cat_parent.prop('checked',false);
                }
            }
            
        });
        
        $(document).on('click','.reload_category',function(){
            var listCateSelected    = [];
            var listCateChecked     = $('.list-cate .input_cat:checked');
            if( listCateChecked.length > 0 ){
                for( var i = 0; i < listCateChecked.length; i++ ){
                    listCateSelected.push($(listCateChecked[i]).val());
                }
            }
            var _this   = $(this);
            _this.find('.fa-spin').removeClass('hide');
            $.ajax({
                type : 'POST',
                url : '/common/get-category-news',
                data: {},
                success:function(res){
                    _this.find('.fa-spin').addClass('hide');
                    if( Object.keys(res).length > 0 ){
                        var html_cate = '';
                        Object.keys(res).map(function(value,key){
                            var item = res[value];
                            var html_child = '';
                            if( item.child.length > 0 ){
                                item.child.map(function(itemChild,k){
                                    html_child += '<li class="li_child"><label><input class="input_cat cat_child" type="checkbox" data-parent="' + item.id + '" name="News[category_id][]" value="' + itemChild.id + '" /><span>' + itemChild.name + '</span></label></li>';
                                });
                            }
                            html_cate += '<li class="li_parent"><label><input class="input_cat" type="checkbox" name="News[category_id][]" value="' + item.id + '" /><span>' + item.name + '</span></label><ul>' + html_child + '</ul></li>';
                        });
                        $('.list-cate').html(html_cate);
                        if( listCateSelected.length > 0 ){
                            listCateSelected.map(function(value,k){
                                $('.input_cat[value="' + value + '"]').prop('checked',true);
                            });
                        }
                    }
                }
            })
        });
        var $modal = $('#modal_crop');

        var image = document.getElementById('image_crop');

        var cropper;
        // $('#gallery-photo-add').on('change', function(event) {
        //     if(this.files[0]){
        //         var files = event.target.files;
        //         var done = function(url){
        //             image.src = url;
        //             $modal.modal('show');
        //         };

        //         if(files && files.length > 0)
        //         {
        //             reader = new FileReader();
        //             reader.onload = function(event)
        //             {
        //                 done(reader.result);
        //             };
        //             reader.readAsDataURL(files[0]);
        //         }
                
        //     }
        // });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                // aspectRatio: 1,
                zoomable:false,
                zoomOnWheel:false,
                viewMode: 3,
                autoCropArea: 1,
                preview:'.preview_crop'
            });
            $('[data-toggle="tooltip"]').tooltip();
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        $('.btn-crop').click(function(){
            if( processUpload )
                return;
            var _this = $(this);
            canvas = cropper.getCroppedCanvas({
                minWidth: 256,
                minHeight: 256,
                maxWidth: 4096,
                maxHeight: 4096,
                fillColor: '#fff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            _this.find('.loading-crop').removeClass('hide');
            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function(){
                    var base64data = reader.result;
                    uploadImage(base64data,$modal,_this);
                    
                };
            });
        });
    });
</script>
