<?php
    $guides          = $model->study_guide ? json_decode($model->study_guide, true) : [];
    $guideName       = '';
    $guideLink       = '';
    $guideFileLink   = '';
    if( isset($guides[$item_id]) ){
        $data               = $guides[$item_id];
        $guideName       = $data['name'];
        $guideLink       = $data['link'];
        $guideFileLink   = $data['file_link'];
    }
?>
<form id="form-action">
    <div class="form-group">
        <div class="row">
            <div class="col-lg-12">
                <label style="margin-top: 10px;" class="control-label lb-Guide" for="guide_name">Tên hướng dẫn</label>
                <input type="text" id="guide_name" class="form-control input-Guide" value="<?= $guideName ?>" name="GuideName">
            </div>
        </div>
        <div class="row box-content">
            <div class="col-lg-12">
                <label style="margin-top: 10px;" class="control-label lb-link" for="guide-link">Đường dẫn liên kết</label>
                <input type="text" id="guide-link" class="form-control input-link" value="<?= $guideLink ?>" name="GuideLink">
            </div>
            <div class="col-lg-12">
                <label style="margin-top: 10px;" class="control-label" for="">Tải file</label>
                <div class="custom-file">
                    <input type="file" name="avatar" class="custom-file-input file-upload-ajax" data-folder="lesson/guide" id="customFileGuide">
                    <label class="custom-file-label" for="customFileGuide"><?= $guideFileLink ? $guideFileLink : 'Chọn file' ?></label>
                </div>
                <input type="hidden" class="input-file-link input-hidden-value" value="<?= $guideFileLink ?>" name="GuideFileLink" />
            </div>
        </div>    
    </div>

</form>