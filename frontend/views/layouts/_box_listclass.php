<?php 
use backend\models\Classmodel;
    $model = new Classmodel();
    $listClass = $model->find()->where(['status'=>1])->orderBy(['id' => SORT_DESC ])->all();
?>

<style>
    .col-inner {
    font-size: 16px;
}
i.fa.fa-map-marker {
    color: #ff277f;
    margin-right: 5px;
}
</style>
<div class="row" id="row-1457174483">
    <div class="col small-12 large-12">
        <h1>Hệ thống cơ sở</h1>
        <div class="col-inner">
            <?php foreach($listClass as $class){?>
            <p><i class="fa fa-map-marker"></i> CS : <?= $class['local']?></p>
            <?php }?>
            </div>
    </div>
</div>