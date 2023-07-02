<?php
    $documents          = $model->document ? json_decode($model->document, true) : [];
    $documentName       = '';
    $documentImg        = '';
    $documentType       = 'link';
    $documentLink       = '';
    $documentFileLink   = '';
    if( isset($documents[$item_id]) ){
        $data               = $documents[$item_id];
        $documentName       = $data['name'];
        $documentImg        = $data['img'];
        $documentType       = $data['type'];
        $documentLink       = $data['link'];
        $documentFileLink   = $data['file_link'];
    }
?>
<form id="form-action-2">
    <div class="form-group">
        <div class="row">
            <div class="col-lg-12">
                <label style="margin-top: 10px;" class="control-label lb-document" for="document-name">Tên tài liệu</label>
                <input type="text" id="document-name" class="form-control input-document" value="<?= $documentName ?>" name="DocumentName">
            </div>
        </div>
        <div class="row box-content">
            <div class="col-lg-12">
                <label style="margin-top: 10px;" class="control-label" for="">Ảnh</label>
                <div class="custom-file">
                    <input type="file" name="avatar" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="lesson/img-document" id="customImgDocument">
                    <label class="custom-file-label document-img-label" for="customImgDocument"><?= $documentImg ? $documentImg : 'Chọn ảnh' ?></label>
                </div>
                <input type="hidden" id="document-img" class="input-hidden-value" value="<?= $documentImg ?>" name="DocumentImg" />
            </div>
            <div class="col-lg-12">
                <label style="margin-top: 10px;" class="control-label" for="">Loại</label>
                <select id="document-type" name="DocumentType" class="form-control">
                    <option <?= $documentType == 'link' ? 'selected="selected"' : '' ?> value="link">Đường dẫn</option>
                    <option <?= $documentType == 'file' ? 'selected="selected"' : '' ?> value="file">Upload file</option>
                </select>
            </div>
            <div class="col-lg-12 field-link <?= $documentType == 'link' ? '' : 'hide' ?>">
                <label style="margin-top: 10px;" class="control-label lb-link" for="document-link">Đường dẫn liên kết</label>
                <input type="text" id="document-link" class="form-control input-link" value="<?= $documentLink ?>" name="DocumentLink">
            </div>
            <div class="col-lg-12 field-file-link <?= $documentType == 'file' ? '' : 'hide' ?>">
                <label style="margin-top: 10px;" class="control-label" for="">Tải file</label>
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input file-upload-ajax" data-folder="lesson/document" id="customFileDocument">
                    <label class="custom-file-label document-file-link-label" for="customFileDocument"><?= $documentFileLink ? $documentFileLink : 'Chọn file' ?></label>
                </div>
                <input type="hidden" id="document-file-link" class="input-file-link input-hidden-value" value="<?= $documentFileLink ?>" name="DocumentFileLink" />
            </div>
        </div>    
    </div>

</form>