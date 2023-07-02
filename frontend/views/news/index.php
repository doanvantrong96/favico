<?php
use yii\helpers\Url;
use yii\web\View ;
use yii\widgets\LinkPager;
$this->title = $title;
// $this->registerJsFile('/js/script.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$domain = Yii::$app->params['domain'];
Yii::$app->params['hasSlide'] = true;
?>
<div id="page-sub-header">
    <div class="slide">
        <section class="variable-width slider slide-home">
            <div class="mx-3 slide-home-item">
                <a href="#" tabindex="-1">
                    <div class="thumbnail">
                        <img src="/images/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg" class="attachment-large size-large wp-post-image" alt="Lê Hồng Minh - Khởi Nghiệp Công Nghệ - TopClass" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-300x157.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-768x402.jpg 768w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam.jpg 1200w" sizes="(max-width: 1024px) 100vw, 1024px">                                            
                    </div>
                    <div class="overlay"></div>
                    <div class="description">
                        <h4 class="mb-1">Lê Hồng Minh - Các Kiến Thức Khởi Nghiệp Công Nghệ Tại TopClass</h4>
                        <small class="text-muted">08-09-2020</small>
                    </div>
                </a>
            </div>
            <div class="mx-3 slide-home-item">
                <a href="#" tabindex="-1">
                    <div class="thumbnail">
                        <img src="/images/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg" class="attachment-large size-large wp-post-image" alt="Lê Hồng Minh - Khởi Nghiệp Công Nghệ - TopClass" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-300x157.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-768x402.jpg 768w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam.jpg 1200w" sizes="(max-width: 1024px) 100vw, 1024px">                                            
                    </div>
                    <div class="overlay"></div>
                    <div class="description">
                        <h4 class="mb-1">Lê Hồng Minh - Các Kiến Thức Khởi Nghiệp Công Nghệ Tại TopClass</h4>
                        <small class="text-muted">08-09-2020</small>
                    </div>
                </a>
            </div>
            <div class="mx-3 slide-home-item">
                <a href="#" tabindex="-1">
                    <div class="thumbnail">
                        <img src="/images/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg" class="attachment-large size-large wp-post-image" alt="Lê Hồng Minh - Khởi Nghiệp Công Nghệ - TopClass" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-300x157.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-768x402.jpg 768w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam.jpg 1200w" sizes="(max-width: 1024px) 100vw, 1024px">                                            
                    </div>
                    <div class="overlay"></div>
                    <div class="description">
                        <h4 class="mb-1">Lê Hồng Minh - Các Kiến Thức Khởi Nghiệp Công Nghệ Tại TopClass</h4>
                        <small class="text-muted">08-09-2020</small>
                    </div>
                </a>
            </div>
            <div class="mx-3 slide-home-item">
                <a href="#" tabindex="-1">
                    <div class="thumbnail">
                        <img src="/images/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg" class="attachment-large size-large wp-post-image" alt="Lê Hồng Minh - Khởi Nghiệp Công Nghệ - TopClass" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-1024x536.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-300x157.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam-768x402.jpg 768w, https://www.topclass.com.vn/articles/wp-content/uploads/2020/09/Le-Hong-Minh-Khoi-Nghiep-Cong-Nghe-TopClass-Ao-Cam.jpg 1200w" sizes="(max-width: 1024px) 100vw, 1024px">                                            
                    </div>
                    <div class="overlay"></div>
                    <div class="description">
                        <h4 class="mb-1">Lê Hồng Minh - Các Kiến Thức Khởi Nghiệp Công Nghệ Tại TopClass</h4>
                        <small class="text-muted">08-09-2020</small>
                    </div>
                </a>
            </div>
        </section>
    </div>
    </div>
<div class="container">
    <div class="row">
        <section id="primary" class="content-area col-sm-12 col-lg-8">
            <main id="main" class="site-main" role="main">
            <header class="page-header">
                <h2 class="page-title text-bold mb-0"><strong>Category: <span>Bạn Cần Biết</span></strong></h2>
            </header>
            <!-- .page-header -->
            <article id="post-449" class="post-449 post type-post status-publish format-standard has-post-thumbnail hentry category-ban-can-biet">
                <div class="row post-item align-items-center">
                    <div class="col-sm-4">
                        <a href="https://www.topclass.com.vn/articles/trai-nghiem-cua-nguoi-dung-tren-topclass/" rel="bookmark" title="Permanent Link to Có Nên Học TopClass? Tìm Hiểu Trải Nghiệm Của Người Dùng Trên TopClass">
                        <div class="thumb">
                            <img width="960" height="540" src="./Bạn Cần Biết Archives - TopClass_files/3-student-1-e1624946714512.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/3-student-1-e1624946714512.jpg 960w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/3-student-1-e1624946714512-300x169.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/3-student-1-e1624946714512-768x432.jpg 768w" sizes="(max-width: 960px) 100vw, 960px">			
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <header class="entry-header">
                        <h2 class="entry-title" style="-webkit-box-orient: vertical;"><a href="https://www.topclass.com.vn/articles/trai-nghiem-cua-nguoi-dung-tren-topclass/" rel="bookmark">Có Nên Học TopClass? Tìm Hiểu Trải Nghiệm Của Người Dùng Trên TopClass</a></h2>
                        <div class="entry-meta text-muted" style="font-size: 14px;">
                            <span class="posted-on text-muted mr-2"><i class="fal fa-user-edit mr-1"></i><span class="author vcard"><a class="url fn n" href="https://www.topclass.com.vn/articles/author/admin/">admin</a></span></span> | <span class="byline text-muted mx-2"> <i class="fal fa-calendar-alt mr-1"></i><a href="https://www.topclass.com.vn/articles/trai-nghiem-cua-nguoi-dung-tren-topclass/" rel="bookmark"><time class="entry-date published" datetime="2021-04-07T11:27:07+00:00">07/04/2021</time></a></span>  | <span class="view text-muted ml-2"> <i class="fal fa-laptop mr-1"></i>3278 Views</span>						
                        </div>
                        <!-- .entry-meta -->
                        </header>
                        <!-- .entry-header -->
                        <div class="entry-content" style="-webkit-box-orient: vertical;">
                        <p>Dù tuổi đời vẫn còn non trẻ nhưng TopClass Việt Nam rất vui khi trong thời gian qua đã đón nhận khá nhiều lời bình tích cực từ các bạn học viên</p>
                        </div>
                    </div>
                </div>
            </article>
            <!-- #post-## -->
            <article id="post-433" class="post-433 post type-post status-publish format-standard has-post-thumbnail hentry category-ban-can-biet">
                <div class="row post-item align-items-center">
                    <div class="col-sm-4">
                        <a href="https://www.topclass.com.vn/articles/masterclass-topclass-ca-lon-co-nuot-duoc-ca-be/" rel="bookmark" title="Permanent Link to MasterClass &amp; TopClass | Cá Lớn Có Nuốt Được Cá Bé?">
                        <div class="thumb">
                            <img width="1280" height="720" src="./Bạn Cần Biết Archives - TopClass_files/MasterClass-vs-TopClass-in-grey.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey.jpg 1280w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey-300x169.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey-1024x576.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey-768x432.jpg 768w" sizes="(max-width: 1280px) 100vw, 1280px">			
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <header class="entry-header">
                        <h2 class="entry-title" style="-webkit-box-orient: vertical;"><a href="https://www.topclass.com.vn/articles/masterclass-topclass-ca-lon-co-nuot-duoc-ca-be/" rel="bookmark">MasterClass &amp; TopClass | Cá Lớn Có Nuốt Được Cá Bé?</a></h2>
                        <div class="entry-meta text-muted" style="font-size: 14px;">
                            <span class="posted-on text-muted mr-2"><i class="fal fa-user-edit mr-1"></i><span class="author vcard"><a class="url fn n" href="https://www.topclass.com.vn/articles/author/admin/">admin</a></span></span> | <span class="byline text-muted mx-2"> <i class="fal fa-calendar-alt mr-1"></i><a href="https://www.topclass.com.vn/articles/masterclass-topclass-ca-lon-co-nuot-duoc-ca-be/" rel="bookmark"><time class="entry-date published" datetime="2021-04-05T10:52:46+00:00">05/04/2021</time></a></span>  | <span class="view text-muted ml-2"> <i class="fal fa-laptop mr-1"></i>1334 Views</span>						
                        </div>
                        <!-- .entry-meta -->
                        </header>
                        <!-- .entry-header -->
                        <div class="entry-content" style="-webkit-box-orient: vertical;">
                        <p>TopClass là gì? Học từ người nổi tiếng chắc hẳn đắt lắm? Có đáng không? Đó là câu hỏi của rất nhiều người về vấn đề học phí.</p>
                        </div>
                    </div>
                </div>
            </article>
            <!-- #post-## -->
            <article id="post-390" class="post-390 post type-post status-publish format-standard has-post-thumbnail hentry category-ban-can-biet">
                <div class="row post-item align-items-center">
                    <div class="col-sm-4">
                        <a href="https://www.topclass.com.vn/articles/hau-truong-quay-topclass-viet-nam-chung-toi-da-tao-ra-cac-khoa-hoc-nhu-the-nao/" rel="bookmark" title="Permanent Link to Hậu trường sản xuất TopClass – Kiến tạo nội dung hướng dẫn từ những người thành công hàng đầu">
                        <div class="thumb">
                            <img width="1200" height="628" src="./Bạn Cần Biết Archives - TopClass_files/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="Chung toi da tao ra topClass nhu the nao - hau truong topclass" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass.jpg 1200w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass-300x157.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass-1024x536.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass-768x402.jpg 768w" sizes="(max-width: 1200px) 100vw, 1200px">			
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <header class="entry-header">
                        <h2 class="entry-title" style="-webkit-box-orient: vertical;"><a href="https://www.topclass.com.vn/articles/hau-truong-quay-topclass-viet-nam-chung-toi-da-tao-ra-cac-khoa-hoc-nhu-the-nao/" rel="bookmark">Hậu trường sản xuất TopClass – Kiến tạo nội dung hướng dẫn từ những người thành công hàng đầu</a></h2>
                        <div class="entry-meta text-muted" style="font-size: 14px;">
                            <span class="posted-on text-muted mr-2"><i class="fal fa-user-edit mr-1"></i><span class="author vcard"><a class="url fn n" href="https://www.topclass.com.vn/articles/author/admin/">admin</a></span></span> | <span class="byline text-muted mx-2"> <i class="fal fa-calendar-alt mr-1"></i><a href="https://www.topclass.com.vn/articles/hau-truong-quay-topclass-viet-nam-chung-toi-da-tao-ra-cac-khoa-hoc-nhu-the-nao/" rel="bookmark"><time class="entry-date published" datetime="2021-04-01T07:46:29+00:00">01/04/2021</time></a></span>  | <span class="view text-muted ml-2"> <i class="fal fa-laptop mr-1"></i>3944 Views</span>						
                        </div>
                        <!-- .entry-meta -->
                        </header>
                        <!-- .entry-header -->
                        <div class="entry-content" style="-webkit-box-orient: vertical;">
                        <p>Quá trình tạo nên một sản phẩm giáo dục trực tuyến vô cùng thử thách, đòi hỏi ekip TopClass Việt Nam phải vô cùng tập trung.</p>
                        </div>
                    </div>
                </div>
            </article>
            <!-- #post-## -->
            <article id="post-367" class="post-367 post type-post status-publish format-standard has-post-thumbnail hentry category-ban-can-biet tag-chuong-trinh-khuyen-mai">
                <div class="row post-item align-items-center">
                    <div class="col-sm-4">
                        <a href="https://www.topclass.com.vn/articles/gia-han-chuong-trinh-8-3-mung-ngay-quoc-te-phu-nu/" rel="bookmark" title="Permanent Link to Gia Hạn Chương Trình 8/3 Mừng Ngày Quốc Tế Phụ Nữ 2021">
                        <div class="thumb">
                            <img width="1280" height="720" src="./Bạn Cần Biết Archives - TopClass_files/UU-DAI-TOPCLASS-8-3.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3.png 1280w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3-300x169.png 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3-1024x576.png 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3-768x432.png 768w" sizes="(max-width: 1280px) 100vw, 1280px">			
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <header class="entry-header">
                        <h2 class="entry-title" style="-webkit-box-orient: vertical;"><a href="https://www.topclass.com.vn/articles/gia-han-chuong-trinh-8-3-mung-ngay-quoc-te-phu-nu/" rel="bookmark">Gia Hạn Chương Trình 8/3 Mừng Ngày Quốc Tế Phụ Nữ 2021</a></h2>
                        <div class="entry-meta text-muted" style="font-size: 14px;">
                            <span class="posted-on text-muted mr-2"><i class="fal fa-user-edit mr-1"></i><span class="author vcard"><a class="url fn n" href="https://www.topclass.com.vn/articles/author/admin/">admin</a></span></span> | <span class="byline text-muted mx-2"> <i class="fal fa-calendar-alt mr-1"></i><a href="https://www.topclass.com.vn/articles/gia-han-chuong-trinh-8-3-mung-ngay-quoc-te-phu-nu/" rel="bookmark"><time class="entry-date published" datetime="2021-03-09T04:46:56+00:00">09/03/2021</time></a></span>  | <span class="view text-muted ml-2"> <i class="fal fa-laptop mr-1"></i>391 Views</span>						
                        </div>
                        <!-- .entry-meta -->
                        </header>
                        <!-- .entry-header -->
                        <div class="entry-content" style="-webkit-box-orient: vertical;">
                        <p>Do TopClass đã nhận được nhiều sự ủng hộ của các bạn nữ trong ngày 8/3 vừa qua nên chúng tôi quyết định gia hạn chương trình này đến hết Thứ 6 tuần này (ngày 12/03/2021).</p>
                        </div>
                    </div>
                </div>
            </article>
            <!-- #post-## -->
            <article id="post-346" class="post-346 post type-post status-publish format-standard has-post-thumbnail hentry category-ban-can-biet tag-chuong-trinh-khuyen-mai">
                <div class="row post-item align-items-center">
                    <div class="col-sm-4">
                        <a href="https://www.topclass.com.vn/articles/8-3-phu-nu-cung-nhau-lam-nen-suc-manh-chinh-phuc-the-gioi/" rel="bookmark" title="Permanent Link to 8/3 Phụ Nữ Cùng Nhau Làm Nên Sức Mạnh Chinh Phục Thế Giới">
                        <div class="thumb">
                            <img width="1280" height="720" src="./Bạn Cần Biết Archives - TopClass_files/UU-DAI-TOPCLASS-8-3.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3.png 1280w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3-300x169.png 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3-1024x576.png 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/03/UU-DAI-TOPCLASS-8-3-768x432.png 768w" sizes="(max-width: 1280px) 100vw, 1280px">			
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <header class="entry-header">
                        <h2 class="entry-title" style="-webkit-box-orient: vertical;"><a href="https://www.topclass.com.vn/articles/8-3-phu-nu-cung-nhau-lam-nen-suc-manh-chinh-phuc-the-gioi/" rel="bookmark">8/3 Phụ Nữ Cùng Nhau Làm Nên Sức Mạnh Chinh Phục Thế Giới</a></h2>
                        <div class="entry-meta text-muted" style="font-size: 14px;">
                            <span class="posted-on text-muted mr-2"><i class="fal fa-user-edit mr-1"></i><span class="author vcard"><a class="url fn n" href="https://www.topclass.com.vn/articles/author/admin/">admin</a></span></span> | <span class="byline text-muted mx-2"> <i class="fal fa-calendar-alt mr-1"></i><a href="https://www.topclass.com.vn/articles/8-3-phu-nu-cung-nhau-lam-nen-suc-manh-chinh-phuc-the-gioi/" rel="bookmark"><time class="entry-date published" datetime="2021-03-04T07:59:07+00:00">04/03/2021</time></a></span>  | <span class="view text-muted ml-2"> <i class="fal fa-laptop mr-1"></i>377 Views</span>						
                        </div>
                        <!-- .entry-meta -->
                        </header>
                        <!-- .entry-header -->
                        <div class="entry-content" style="-webkit-box-orient: vertical;">
                        <p>Cũng như nam giới, phụ nữ hoàn toàn có khả năng chủ động làm những điều mình muốn để làm chủ cuộc đời. Và phụ nữ cùng nhau có thể tạo nên sức mạnh chinh phục mọi thử thách.&nbsp;</p>
                        </div>
                    </div>
                </div>
            </article>
            <!-- #post-## -->
            <div class="row navigation pagination">
                <?php echo LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
            </div>
            </main>
            <!-- #main -->
        </section>
        <!-- #primary -->
        <aside id="secondary" class="widget-area col-sm-12 col-lg-4" role="complementary">
            <section id="categories-2" class="widget widget_categories">
            <h3 class="widget-title">Phân mục</h3>
            <ul class="nav flex-column">
                <li class="cat-item cat-item-7 nav-item"><a href="<?= Url::to(['news/index','slug' => 'chuyen-muc-test','id'=>6]);?>" class="nav-link">Âm Nhạc &amp; Trình Diễn</a></li>
                <li class="cat-item cat-item-13 current-cat nav-item"><a aria-current="page" href="<?= Url::to(['news/index','slug' => 'chuyen-muc-test','id'=>6]);?>" class="nav-link">Bạn Cần Biết</a></li>
                <li class="cat-item cat-item-6 nav-item"><a href="<?= Url::to(['news/index','slug' => 'chuyen-muc-test','id'=>6]);?>" class="nav-link">Kinh Doanh &amp; Marketing</a></li>
                <li class="cat-item cat-item-8 nav-item"><a href="<?= Url::to(['news/index','slug' => 'chuyen-muc-test','id'=>6]);?>" class="nav-link">Phim Ảnh &amp; Nghệ Thuật</a></li>
                <li class="cat-item cat-item-5 nav-item"><a href="<?= Url::to(['news/index','slug' => 'chuyen-muc-test','id'=>6]);?>" class="nav-link">Thiết Kế, Nhiếp Ảnh &amp; Thời Trang</a></li>
            </ul>
            </section>
            <section class="widget recent-posts-widget-with-thumbnails">
            <div>
                <h3 class="widget-title">Bài viết mới nhất</h3>
                <ul id="slider-id" class="list-unstyled">
                    <li>
                        <a class="row no-gutters mb-4" href="<?= Url::to(['news/detail','slug' => 'gioi-thieu-ve-topclass']);?>">
                        <div class="col-4">
                            <div class="thumb mr-2  d-flex justify-content-center align-items-center overflow-hidden" style="max-height: 65px;">
                                <img width="960" height="540" src="/images/3-student-1-e1624946714512.jpg" class="attachment-full size-full wp-post-image" alt="" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/3-student-1-e1624946714512.jpg 960w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/3-student-1-e1624946714512-300x169.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/3-student-1-e1624946714512-768x432.jpg 768w" sizes="(max-width: 960px) 100vw, 960px">							
                            </div>
                        </div>
                        <div class="col-8">
                            <p style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;height: inherit;text-overflow: ellipsis;overflow: hidden;" class="mb-1 slider-caption-class"><b>Có Nên Học TopClass? Tìm Hiểu Trải Nghiệm Của Người Dùng Trên TopClass</b></p>
                            <small class="text-muted"> </small>
                        </div>
                        </a>
                    </li>
                    <li>
                        <a class="row no-gutters mb-4" href="<?= Url::to(['news/detail','slug' => 'gioi-thieu-ve-topclass']);?>">
                        <div class="col-4">
                            <div class="thumb mr-2  d-flex justify-content-center align-items-center overflow-hidden" style="max-height: 65px;">
                                <img width="1280" height="720" src="/images/MasterClass-vs-TopClass-in-grey.jpg" class="attachment-full size-full wp-post-image" alt="" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey.jpg 1280w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey-300x169.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey-1024x576.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/MasterClass-vs-TopClass-in-grey-768x432.jpg 768w" sizes="(max-width: 1280px) 100vw, 1280px">							
                            </div>
                        </div>
                        <div class="col-8">
                            <p style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;height: inherit;text-overflow: ellipsis;overflow: hidden;" class="mb-1 slider-caption-class"><b>MasterClass &amp; TopClass | Cá Lớn Có Nuốt Được Cá Bé?</b></p>
                            <small class="text-muted"> </small>
                        </div>
                        </a>
                    </li>
                    <li>
                        <a class="row no-gutters mb-4" href="<?= Url::to(['news/detail','slug' => 'gioi-thieu-ve-topclass']);?>">
                        <div class="col-4">
                            <div class="thumb mr-2  d-flex justify-content-center align-items-center overflow-hidden" style="max-height: 65px;">
                                <img width="1200" height="628" src="/images/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass.jpg" class="attachment-full size-full wp-post-image" alt="Chung toi da tao ra topClass nhu the nao - hau truong topclass" loading="lazy" srcset="https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass.jpg 1200w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass-300x157.jpg 300w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass-1024x536.jpg 1024w, https://www.topclass.com.vn/articles/wp-content/uploads/2021/04/Chung-toi-da-tao-ra-topClass-nhu-the-nao-hau-truong-topclass-768x402.jpg 768w" sizes="(max-width: 1200px) 100vw, 1200px">							
                            </div>
                        </div>
                        <div class="col-8">
                            <p style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;height: inherit;text-overflow: ellipsis;overflow: hidden;" class="mb-1 slider-caption-class"><b>Hậu trường sản xuất TopClass - Kiến tạo nội dung hướng dẫn từ những người thành công hàng đầu</b></p>
                            <small class="text-muted"> </small>
                        </div>
                        </a>
                    </li>
                </ul>
            </div>
            </section>
        </aside>
        <!-- #secondary -->
        <div class="adv-bottom-post col-12">
        </div>
    </div>
    <!-- .row -->
</div>
        