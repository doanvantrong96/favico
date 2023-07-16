<?php
use yii\helpers\Url;
use yii\web\View ;

?>

<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p>SẢN PHẨM</p>
        <span>/</span>
        <p>CHI TIẾT SẢN PHẨM</p>
    </div>
    <h6><?= $result->title ?></h6>
</section>

<section class="product_detail">
    <div class="container">
        <div class="detail_group">
            <div class="detail_top position-relative">
                <div class="grid_detail_top">
                    <img class="w-100 img_sp" src="/images/page/image 20.png" alt="">
                    <div class="d-flex">
                        <span><?= $result->title ?></span>
                        <p><?= $result->description ?></p>
                    </div>
                </div>
                <img class="img_ab" src="/images/page/bg-abr.png" alt="">
            </div>

            <div class="tab_detail">
            <ul class="nav nav-tabs nav_tab">
                <li><a class="active" data-toggle="tab" href="#description_product">Mô tả sản phẩm</a></li>
                <li><a data-toggle="tab" href="#review_product">Đánh giá (<?= count($comment) ?>)</a></li>
            </ul>

            <div class="tab-content">
                <div id="description_product" class="tab-pane fade in active show">
                    <h3>Mô tả sản phẩm</h3>
                    <?= $result->content ?>
                </div>
                <div id="review_product" class="tab-pane fade">
                    <h3>Đánh giá</h3>
                    <div class="gr_comment">
                        <?php 
                            if(!empty($comment)) {
                                foreach($comment as $item) {
                        ?>
                            <div class="item_comment">
                                <div class="avatar_comment">
                                    <img src="<?= $item['avatar'] ?>" alt="" class="w-100">
                                </div>
                                <div class="content_comment">
                                    <a href="javascript:void(0)"><?= $item['author'] ?></a>
                                    <div style="display: flex;">
                                        <?php for($i = 1; $i <= 5; $i++) { ?>
                                            <?php if($i <= $item['rate']) { ?>
                                                <img src="/images/icon/star-active.svg" alt="">
                                            <?php }else{ ?>
                                                <img src="/images/icon/star.svg" alt="">
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <span><?= date('d/m/Y', strtotime($item['create_date'])) ?></span>
                                    <p><?= $item['content'] ?></p>
                                </div>
                            </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <?php if(!empty($product_lq)) { ?>
            <div class="product_relate_detail new_relate">
                <div class="rel_title flex-center gap-20">
                    <div class="bd-logo"></div>
                    <img data-lazyloaded="1" src="/images/icon/logo-fa.svg">
                    <div class="bd-logo"></div>
                </div>
                <h2>Sản Phẩm Liên Quan</h2>
                <div class="product_relate">
                <div class="list_product">
                    <?php foreach($product_lq as $row) { ?>
                        <div class="item_product">
                            <a class="flex-center" href="<?= Url::to(['/prodict/detail','id' => $row['id']]) ?>">
                                <img src="/images/page/image 20.png" alt="">
                                <p><?= $row['title'] ?></p>
                                <span>Chi tiết</span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="flex-center w-100 mt-4">
                    <a href="<?= Url::to(['/prodict/index']) ?>" class="see_more_td flex-center">Xem tất cả</a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>