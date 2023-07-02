<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RegisterPracticeTrySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel">
    <div class="panel-hdr">
        <h2>
            Lọc và tìm kiếm
        </h2>
    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'email')->textInput(['placeholder'=>'Nhập email'])->label(false) ?>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?= Html::Button('<i class="fal fa-search"></i> Lọc', ['id'=>'btn-search','class' => 'btn btn-primary']) ?>
                        <?= Html::Button('Xuất excel', ['class' => 'btn btn-success','id'=>'form-export-btn']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('btn-search').addEventListener('click', function(e) {
        e.preventDefault();
        $('input[name="_export"]').remove();
        var form = e.target.closest('form');
        form.submit();
    });
    document.getElementById('form-export-btn').addEventListener('click', function(e) {
        e.preventDefault();
        var form = e.target.closest('form');
        var m = document.createElement("input");
        m.setAttribute('type', 'hidden');
        m.setAttribute('name', '_export');
        form.appendChild(m);
        form.submit();
    });
</script>
