<?php
use yii\helpers\Url;
use yii\web\View ;


?>

<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p>TIN TỨC</p>
    </div>
    <h6>Tin Tức</h6>
</section>

<section class="content_new">
    <div class="container">
        <div class="row justify-content-lg-center">
            <div class="col-lg-10 col-xl-9">
                <div class="nt-theme-content">
                    <div class="blog__h1">
                        <h1><?= $new->description ?></h1>
                    </div>
                    <div class="blog-details__image">
                        <!-- <img src="/images/page/new1.png" alt=""> -->
                        <img src="<?= $new->image ?>"/>
                    </div>
                    <div class="blog-details__content">
                        <?= $new->content ?>
                    </div>
                    <?php if(!empty($tag)){ ?>
                        <div class="blog-details__meta">
                            <div class="blog-details__tags">
                                <span>Tags:</span>
                                <?php $numItems = count($tag); $i = 0; foreach($tag as $row) { ?>
                                    <a href="<?= Url::to(['/news/index','slug' => $row['slug']]) ?>" rel="tag"><?= $row['name'] . ((++$i === $numItems) ? '' : ',') ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="paginations">
                        <a class="flex-center" href="/" rel="prev">Đọc bài trước</a> 
                        <a class="btn-disabled flex-center" href="#0">Đọc bài tiếp theo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(!empty($post_lq)) : ?>
    <section class="new_relate">
        <div class="rel_title flex-center gap-20">
            <div class="bd-logo"></div>
            <img data-lazyloaded="1" src="/images/icon/logo-fa.svg">
            <div class="bd-logo"></div>
        </div>
        <h2>Các bài viết liên quan</h2>
        <div class="container">
            <div class="row">
                <?php foreach($post_lq as $row) { ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="blog-card">
                        <div class="blog-card__image">
                            <img
                                data-lazyloaded="1"
                                src="<?= $row['image'] ?>"
                            />
                            <a href="/"></a>
                        </div>
                        <div class="blog-card__content">
                            <div class="blog-card__date"><a href="<?= Url::to(['/news/detail','slug' => $row['slug'],'id' => $row['id']]) ?>"><?= date('d/m', strtotime($row['date_publish'])) ?></a></div>
                            <h3 class="title"><a href="<?= Url::to(['/news/detail','slug' => $row['slug'],'id' => $row['id']]) ?>"><?= $row['title'] ?></a></h3>
                            <a class="btn_read" href="<?= Url::to(['/news/detail','slug' => $row['slug'],'id' => $row['id']]) ?>">Đọc ngay</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php endif; ?>