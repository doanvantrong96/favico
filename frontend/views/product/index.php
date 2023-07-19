<?php
use yii\helpers\Url;
use yii\web\View ;
use yii\widgets\LinkPager;
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>

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
                    <input type="text" placeholder="Tìm kiếm" id="ip_search">
                    <span>
                        <img class="search_pr" src="/images/icon/search.svg" alt="">
                    </span>
                </div>
                <div class="filter_cat">
                    <h4>Danh Mục Sản Phẩm</h4>
                    <div class="option_filter active mb-3">
                        <div class="top_option">
                            <p class="font-weight-bold">Thương hiệu</p>
                            <img src="/images/icon/arrow-b.svg" class="img_arrow" alt="">
                        </div>
                        <div class="checkbox_option">
                            <?php 
                                foreach($product_cat as $id => $name){ 
                                    $checked = '';
                                    if(isset($_GET['cat']) && $_GET['cat'] == $id)
                                        $checked = 'checked';
                            ?>
                                <div class="form_group d-flex gap-16">
                                    <input class="trigger product_cat" name="product_cat" type="checkbox" <?= $checked ?> value="<?= $id ?>">
                                    <label for="trigger" class="checker"></label>
                                    <label for=""><?= $name ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="option_filter active">
                        <div class="top_option">
                            <p class="font-weight-bold">Con giống</p>
                            <img src="/images/icon/arrow-b.svg" class="img_arrow" alt="">
                        </div>
                        <div class="checkbox_option">
                            <?php 
                                foreach($product_tag as $id => $name){ 
                            ?>
                                <div class="form_group d-flex gap-16">
                                    <input class="trigger product_tag" name="product_tag" type="radio" value="<?= $id ?>">
                                    <label for="trigger" class="checker"></label>
                                    <label for=""><?= $name ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if(!empty($most)) { ?>
                    <div class="product_hot filter_cat">
                        <h4>Sản Phẩm Nổi Bật</h4>
                        <div class="list_product_hot">
                            <?php foreach($most as $row) { ?>
                                <div>
                                    <a href="<?= Url::to(['/product/detail','slug' => $row['slug'],'id' => $row['id']]) ?>">
                                        <img src="<?= $row['image'] ?>" alt="">
                                    </a>
                                    <a href="<?= Url::to(['/product/detail','slug' => $row['slug'],'id' => $row['id']]) ?>">
                                        <p><?= $row['title'] ?></p>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="product_right">

                <div class="filter_right">
                    <div class="summeri">
                        <!-- <p class="mb-0">Hiển thị 1–9 trên 14 kết quả</p> -->
                    </div>
                    <!-- <div class="sort_prod">
                        <select name="" id="">
                            <option value="">Sắp xếp theo mới nhất</option>
                            <option value="">Sắp xếp theo cũ nhất</option>
                        </select>
                    </div> -->
                </div>
                <div class="result_product">
                    <?php
                        if(!empty($arr_data)){ 
                        foreach($arr_data as $name_tag => $item_product) {
                    ?>
                    <div class="result_product_gr">
                        <div class="cat_result">
                            <h6><?= $name_tag ?></h6>
                            <div class="line_tit"></div>
                        </div>
                        <div class="list_product">
                            <?php foreach($item_product as $row) { ?>
                                <div class="item_product">
                                    <a class="flex-center" href="<?= Url::to(['/product/detail','slug' => $row['slug'],'id' => $row['id']]) ?>">
                                        <img src="<?= $row['image'] ?>" alt="">
                                        <p><?= $row['title'] ?></p>
                                        <span>Chi tiết</span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php }} ?>
                </div>
                <div id="page_product"></div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" value="<?= $total_page ?>" id="total_page">

<script>
    $(document).ready(function(){
        var inputs = $('.product_tag');
        var checked = inputs.filter(':checked').val();
        inputs.on('click', function(){
            if($(this).val() === checked) {
                $(this).prop('checked', false);
                checked = '';
                
            } else {
                $(this).prop('checked', true);
                checked = $(this).val();
            }
        });


        var width = $(window).width();
        var scroll_top = 480;
        if(width < 768)
            scroll_top = 50;

        $(document).on('click','.product_cat,.product_tag', function(){
            jQuery("html,body").animate({scrollTop: scroll_top}, 500);
            getDataSearch();
        });
        $(document).on('click','.search_pr', function(){
            getDataSearch();
        });


        var totalPage = $('#total_page').val();
        if(totalPage <= 1)
            getDataSearch();
        console.log('totalPage', totalPage);
        renderPagination(totalPage);
        function renderPagination(totalPage){
            $('#page_product').twbsPagination({
                totalPages: totalPage,
                visiblePages: 10,
                next: '<img src="/images/icon/next.svg">',
                prev: '<img src="/images/icon/prev.svg">',
                last: '',
                first: '',
                onPageClick: function (event, page) {
                    jQuery("html,body").animate({scrollTop: scroll_top}, 500);
                    getDataSearchPage(page);
                    // getDataSearch(page);
                }
            });
        }

        function getDataSearchPage(page = 1){
            let arr_cat = [];
            $("input:checkbox[name=product_cat]:checked").each(function(){
                arr_cat.push($(this).val());
            });
        
            var tag = "";
            var selected = $("input:radio[name=product_tag]:checked");
            if (selected.length > 0) {
                tag = selected.val();
            }
            let q = $('#ip_search').val();
            $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {category: arr_cat, tag: tag, page:page, q:q},
            success: function(res){
                var data = $.parseJSON(res);
                $('.result_product').html(data.res);
                $('#total_page').val(data.total_page);
            }
            })
        }
        function getDataSearch(page = 1){
            let arr_cat = [];
            $("input:checkbox[name=product_cat]:checked").each(function(){
                arr_cat.push($(this).val());
            });
        
            var tag = "";
            var selected = $("input:radio[name=product_tag]:checked");
            if (selected.length > 0) {
                tag = selected.val();
            }

            let q = $('#ip_search').val();
            $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {category: arr_cat, tag: tag, page:page, q:q},
            success: function(res){
                var data = $.parseJSON(res);
                $('.result_product').html(data.res);
                $('#total_page').val(data.total_page);
                var $pagination = $('#page_product');
                $pagination.twbsPagination('destroy');
                renderPagination(data.total_page);
                console.log(1121212);
            }
            })
        }
    });
</script>
