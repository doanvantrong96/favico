<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryTags */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="category-tags-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="panel" style="width:100%">
                <div class="panel-hdr">
                    <h2>
                        Thông tin
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'type')->dropDownList(Yii::$app->params['type_config']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control'])->label('Nội dung hiển thị') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'value')->textInput(['class'=>'form-control','maxlength'=>300]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList']) ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'position')->textInput(['maxlength' => 5])->label('Thứ tự hiển thị trên trang chủ') ?>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-0">
                                <label class="control-label">Ảnh/ Icon (nếu có)</label>
                                <div class="custom-file">
                                    <input type="file" name="avatar" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/technical" id="imgUpload">
                                    <label class="custom-file-label" for="imgUpload"><?= $model->image != '' ? $model->image : 'Chọn ảnh' ?></label>
                                </div>
                                <img class="img-preview" src="<?= $model->image ?>" style="<?= $model->image != '' ? '' : 'display:none' ?>" />
                                <?= $form->field($model, 'image')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fal fa-plus"></i>  Thêm mới' : '<i class="fal fa-save"></i>  Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<style>
    .control-label{width:100%}
.img-preview{
    /* width: 100%; */
    max-height: 100px;
    /* object-fit: cover; */
    margin: 20px 0 0;}
</style>
<script src="/assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    if( $('#editor').length > 0 )
    {
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
});
</script>