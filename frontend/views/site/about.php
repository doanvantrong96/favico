
<?php
use yii\helpers\Url;
use yii\web\View ;
?>
<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p>GIỚI THIỆU</p>
    </div>
    <h6>GIỚI THIỆU</h6>
</section>

<?php if(!empty($result)) { ?>
    <section class="top_about position-relative">
        <div class="container">
            <div class="gr_top_about">
                <img src="<?= $result[0]['image'] ?>" alt="">
                <div>
                    <p><?= $result[0]['title'] ?></p>
                    <span><?= $result[0]['content'] ?></span>
                    <img src="<?= $result[0]['avatar'] ?>" alt="">
                </div>
            </div>
        </div>
        <img class="bg_r" src="/images/page/bg-abr.png" alt="">
    </section>

    <section class="content_about">
        <div class="content_about_gr">
            <?php unset($result[0]); foreach($result as $row) { ?>
                <div class="content_about_item">
                    <h2><?= $row['title'] ?></h2>
                    <?= $row['content'] ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>