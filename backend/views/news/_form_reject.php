<?php
    use yii\widgets\ActiveForm;
    use backend\models\News;
?>

<?php $form = ActiveForm::begin(['id'=>'form_modal']); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group field-news-title">
                <label class="control-label" for="news-title">Bài viết</label>
                <p><b><?= $model->title ?></b></p>
                <div class="help-block"></div>
            </div>

            <?= $form->field($model, 'reason')->textarea(['class'=>'form-control','maxlength' => 300,'style'=>'height: 100px;min-height:100px'])->label($model->status === News::PUBLISHED ? 'Lý do gỡ xuống' : 'Lý do từ chối'); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>