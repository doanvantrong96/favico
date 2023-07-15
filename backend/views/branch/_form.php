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
                            <div class="rule_y" style="float:left">
                                <p class="rule_y_1">26</p><p class="rule_y_1">52</p><p class="rule_y_1">78</p><p class="rule_y_1">104</p><p class="rule_y_1">130</p><p class="rule_y_2">156</p><p class="rule_y_2">182</p><p class="rule_y_2">208</p><p class="rule_y_2">234</p><p class="rule_y_2">260</p><p class="rule_y_2">286</p><p class="rule_y_2">312</p><p class="rule_y_2">338</p><p class="rule_y_2">364</p><p class="rule_y_2">390</p><p class="rule_y_2">416</p><p class="rule_y_2">442</p><p class="rule_y_2">468</p><p class="rule_y_2">494</p><p class="rule_y_2">520</p><p class="rule_y_2">546</p><p class="rule_y_2">572</p>
                            </div>
                            <div style="margin-left:4px">
                                <p class="map-x">
                                    <span class="loca_0">0</span><span class="loca_2">27</span><span class="loca_2">53</span><span class="loca_2">80</span><span class="loca_3">107</span><span class="loca_3">134</span><span class="loca_3">161</span><span class="loca_3">188</span><span class="loca_3">215</span><span class="loca_4">242</span><span class="loca_4">268</span><span class="loca_4">295</span><span class="loca_4">322</span><span class="loca_4">349</span><span class="loca_4">376</span><span class="loca_5">403</span><span class="loca_5">430</span><span class="loca_5">456</span><span class="loca_5">483</span><span class="loca_5">510</span><span class="loca_5">537</span>
                                </p>
                                <div class="location_map">
                                    <?= $this->render('_map',[]); ?>
                                    
                                    <?php
                                        if(isset($model->id) && $model->id > 0)
                                        {
                                    ?>
                                            <div id='pin-<?= $model->id ?>' class="box" style="top:<?= $model->loc_x ?>px;left:<?= $model->loc_y ?>px;background-image:url('<?= $model->image ?>');width:<?= $model->size ?>px">
                                                <img src="<?= $model->image ?>" style="width:<?= $model->size ?>px">
                                                <div class="pin-text"><?= $model->content ?></div>
                                            </div>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <div id='pin-x' class="box" >
                                                <div class="pin-text">Demo: X: 85 - Y: 245</div>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'loc_x')->textInput(['maxlength' => 5]) ?>
                            <?= $form->field($model, 'loc_y')->textInput(['maxlength' => 5]) ?>
                            <?= $form->field($model, 'content')->textInput(['maxlength' => true,'input-set'=>'.set-unicode','class'=>'form-control remove-unicode'])->label('Tiêu đề') ?>
                            <?= $form->field($model, 'size')->textInput(['maxlength' => 5]) ?>

                            <div class="form-group mb-0">
                                <label class="control-label">Icon tọa độ</label>
                                <div class="custom-file">
                                    <input type="file" name="avatar" accept="image/*" class="custom-file-input file-upload-ajax" data-folder="images/branch" id="imgUpload">
                                    <label class="custom-file-label" for="imgUpload"><?= $model->image != '' ? $model->image : 'Chọn ảnh' ?></label>
                                </div>
                                <img class="img-preview" src="<?= $model->image ?>" style="<?= $model->image != '' ? '' : 'display:none' ?>" />
                                <?= $form->field($model, 'image')->hiddenInput(['class'=>'input-hidden-value'])->label(false); ?>
                            </div>

                            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['statusList']) ?>
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
<script type="text/javascript">
jQuery(document).ready(function(){
    
});
</script>