<?php
use yii\helpers\Url;
use yii\web\View ;

?>

<section class="banner_bread text-center text-white">
    <div class="breadcrumbs">
        <a href="/">HOME</a>
        <span>/</span>
        <p>SẢN PHẨM</p>
    </div>
    <h6>Sản Phẩm</h6>
</section>

<section class="product">
    <div class="container">
        <div class="grid_product">
            <div class="filter_product">
                <div class="search_product position-relative d-inline-block w-100">
                    <input type="text" placeholder="Tìm kiếm">
                    <a href="">
                        <img src="/images/icon/search.svg" alt="">
                    </a>
                </div>
                <div class="filter_cat">
                    <h4>Danh Mục Sản Phẩm</h4>
                    <div class="option_filter active mb-3">
                        <div class="top_option">
                            <p class="font-weight-bold">Thương hiệu</p>
                            <img src="/images/icon/arrow-b.svg" class="img_arrow" alt="">
                        </div>
                        <div class="checkbox_option">
                            <div class="form_group d-flex gap-16">
                                <input class="trigger" type="checkbox">
                                <label for="trigger" class="checker"></label>
                                <label for="">Phavico</label>
                            </div>
                            <div class="form_group d-flex gap-16">
                                <input class="trigger" type="checkbox">
                                <label for="trigger" class="checker"></label>
                                <label for="">Phavico</label>
                            </div>
                            <div class="form_group d-flex gap-16">
                                <input class="trigger" type="checkbox">
                                <label for="trigger" class="checker"></label>
                                <label for="">Phavico</label>
                            </div>
                        </div>
                    </div>
                    <div class="option_filter active">
                        <div class="top_option">
                            <p class="font-weight-bold">Con giống</p>
                            <img src="/images/icon/arrow-b.svg" class="img_arrow" alt="">
                        </div>
                        <div class="checkbox_option">
                            <div class="form_group d-flex gap-16">
                                <input class="trigger" type="checkbox">
                                <label for="trigger" class="checker"></label>
                                <label for="">Cám lợn</label>
                            </div>
                            <div class="form_group d-flex gap-16">
                                <input class="trigger" type="checkbox">
                                <label for="trigger" class="checker"></label>
                                <label for="">Cám lợn</label>
                            </div>
                            <div class="form_group d-flex gap-16">
                                <input class="trigger" type="checkbox">
                                <label for="trigger" class="checker"></label>
                                <label for="">Cám lợn</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_hot filter_cat">
                    <h4>Sản Phẩm Nổi Bật</h4>
                    <div class="list_product_hot">
                        <div>
                            <a href="">
                                <img src="/images/page/image 20.png" alt="">
                            </a>
                            <p>Cám cá <br> Hanofeed: <br> C-01</p>
                        </div>
                        <div>
                            <a href="">
                                <img src="/images/page/image 20.png" alt="">
                            </a>
                            <p>Cám cá <br> Hanofeed: <br> C-01</p>
                        </div>
                        <div>
                            <a href="">
                                <img src="/images/page/image 20.png" alt="">
                            </a>
                            <p>Cám cá <br> Hanofeed: <br> C-01</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product_right">
                <div class="filter_right">
                    <div class="summeri">
                        <p class="mb-0">Hiển thị 1–9 trên 14 kết quả</p>
                    </div>
                    <div class="sort_prod">
                        <select name="" id="">
                            <option value="">Sắp xếp theo mới nhất</option>
                            <option value="">Sắp xếp theo cũ nhất</option>
                        </select>
                    </div>
                </div>
                <div class="result_product">
                    <div class="result_product_gr">
                        <div class="cat_result">
                            <h6>CÁM CÁ</h6>
                            <div class="line_tit"></div>
                        </div>
                        <div class="list_product">
                            <?php for($i = 0; $i < 9; $i++) { ?>
                                <div class="item_product">
                                    <a class="flex-center" href="">
                                        <img src="/images/page/image 20.png" alt="">
                                        <p>Cám cá Hanofeed: C-01</p>
                                        <span>Chi tiết</span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="result_product_gr">
                        <div class="cat_result">
                            <h6>CÁM GÀ</h6>
                            <div class="line_tit"></div>
                        </div>
                        <div class="list_product">
                            <?php for($i = 0; $i < 9; $i++) { ?>
                                <div class="item_product">
                                    <a class="flex-center" href="">
                                        <img src="/images/page/image 20.png" alt="">
                                        <p>Cám cá Hanofeed: C-01</p>
                                        <span>Chi tiết</span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="result_product_gr">
                        <div class="cat_result">
                            <h6>CÁM LỢNK</h6>
                            <div class="line_tit"></div>
                        </div>
                        <div class="list_product">
                            <?php for($i = 0; $i < 9; $i++) { ?>
                                <div class="item_product">
                                    <a class="flex-center" href="">
                                        <img src="/images/page/image 20.png" alt="">
                                        <p>Cám cá Hanofeed: C-01</p>
                                        <span>Chi tiết</span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>