<?php
use yii\helpers\Url;
use yii\web\View ;


?>

<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p>Tin Tức</p>
    </div>
    <h6><?= $new->title ?></h6>
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
                        <img src="/images/page/new1.png" alt="">
                        <noscript>
                            <img
                                width="1600"
                                height="900"
                                src="<?= $new->image ?>"
                                class="img-fluid wp-post-image"
                            />
                        </noscript>
                    </div>
                    <div class="blog-details__content">
                        <?= $new->content ?>
                    </div>
                    <div class="blog-details__meta">
                        <div class="blog-details__tags">
                            <span>Tags:</span>
                            <a href="https://ninetheme.com/themes/agrikon/tag/envato/" rel="tag">Ngô ngọt</a>, 
                            <a href="https://ninetheme.com/themes/agrikon/tag/fruit/" rel="tag">chăn nuôi</a>,
                            <a href="https://ninetheme.com/themes/agrikon/tag/ninetheme/" rel="tag">nông sản</a>, 
                        </div>
                    </div>
                    <div class="paginations">
                        <a class="flex-center" href="https://ninetheme.com/themes/agrikon/work-friendly-lunch-recipes/" rel="prev">Đọc bài trước</a> 
                        <a class="btn-disabled flex-center" href="#0">Đọc bài tiếp theo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="new_relate">
    <div class="rel_title flex-center gap-20">
        <div class="bd-logo"></div>
        <img data-lazyloaded="1" src="/images/icon/logo-fa.svg">
        <div class="bd-logo"></div>
    </div>
    <h2>Các bài viết liên quan</h2>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <div class="blog-card__image">
                        <img
                            data-lazyloaded="1"
                            src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-24-768x432.jpg"
                        />
                        <a href="https://ninetheme.com/themes/agrikon/this-doctor-is-also-a-farmer/"></a>
                    </div>
                    <div class="blog-card__content">
                        <div class="blog-card__date"><a href="https://ninetheme.com/themes/agrikon/2020/02/08/">05/04</a></div>
                        <h3 class="title"><a href="">Giá trứng gia cầm bất ngờ tăng trở lại sau một thời gian dài giảm sâu</a></h3>
                        <a class="btn_read" href="">Đọc ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <div class="blog-card__image">
                        <img
                            data-lazyloaded="1"
                            src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-24-768x432.jpg"
                        />
                        <a href="https://ninetheme.com/themes/agrikon/this-doctor-is-also-a-farmer/"></a>
                    </div>
                    <div class="blog-card__content">
                        <div class="blog-card__date"><a href="https://ninetheme.com/themes/agrikon/2020/02/08/">05/04</a></div>
                        <h3 class="title"><a href="">Giá trứng gia cầm bất ngờ tăng trở lại sau một thời gian dài giảm sâu</a></h3>
                        <a class="btn_read" href="">Đọc ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="blog-card">
                    <div class="blog-card__image">
                        <img
                            data-lazyloaded="1"
                            src="https://ninetheme.com/themes/agrikon/wp-content/uploads/2020/02/organic-news-24-768x432.jpg"
                        />
                        <a href="https://ninetheme.com/themes/agrikon/this-doctor-is-also-a-farmer/"></a>
                    </div>
                    <div class="blog-card__content">
                        <div class="blog-card__date"><a href="https://ninetheme.com/themes/agrikon/2020/02/08/">05/04</a></div>
                        <h3 class="title"><a href="">Giá trứng gia cầm bất ngờ tăng trở lại sau một thời gian dài giảm sâu</a></h3>
                        <a class="btn_read" href="">Đọc ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>