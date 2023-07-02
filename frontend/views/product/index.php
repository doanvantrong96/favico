<?php
use yii\helpers\Url;
use yii\web\View ;

$this->title = $Course->name;
$domain = Yii::$app->params['domain'];

Yii::$app->params['og_title']['content'] = $Course->name;
Yii::$app->params['og_description']['content'] = $Course->name;
Yii::$app->params['og_image']['content'] =  $domain.$Course->avatar;
$lessonCurrent = null;
$isShowLinkVideoCurrent = false;
if( $slug_lesson == '' && !empty($Lessions) ){
    $lessonCurrent = $Lessions[0];
    $slug_lesson = $lessonCurrent->slug;
}else if($slug_lesson != ''){
    foreach( $Lessions as $lesson ){
        if( $lesson->slug == $slug_lesson ){
            $lessonCurrent = $lesson;
            break;
        }
    }
}
if( $lessonCurrent ){
    $isShowLinkVideoCurrent = (($isset_Course || $lessonCurrent['is_prevew'] ) || $Course['price'] == 0 ) ? true : false;
}
?>
<link rel="stylesheet" href="/css/default_skin.css?v=1.2" />
<link rel="stylesheet" href="/css/videojs-hls-player.css?v=1.2" />
<div class="lesson-detail-page">
    <div class="lesson-detail-container">
        <div class="container">
        <div class="lesson-title">
            <div class="category"><?= $Course->category_name ?></div>
            <h3 class="title_lession"><?= $lessonCurrent ? $lessonCurrent->name : $Course->name ?></h3>
        </div>
        <div class="row">
            <div class="lesson-detail col-sm-12 col-md-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class='videojs-hls-player-wrapper' data-img="<?= $Course->avatar ?>" id="video_player"></div>
                    </div>
                </div>
                <?php if( $lessonCurrent ): ?>
                <section id="lesson-description" class="lesson-description"><?= $lessonCurrent->short_description ?></section>
                <?php endif; ?>
                <div class="collapse show" aria-expanded="true">
                    <?php if( $lessonCurrent ): ?>
                    <section id="lesson-preview" class="lesson-preview">
                        <h3 class="section-title">Nội dung bài học</h3>
                        <div class="lesson-description-full">
                            <?= $lessonCurrent->description ?>
                        </div>
                    </section>
                    <?php endif; ?>
                    <section class="lesson-review ">
                    <h3 class="section-title">Đánh giá</h3>
                    <?php 
                        $star = 0;
                        if( $lessonCurrent && $lessonCurrent['rating'] ){
                            $dataRating     = explode('/',$lessonCurrent['rating']);
                            $star           = $dataRating[2];
                        }

                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="score-rate d-flex align-items-center">
                                <h6 class="point"><?= $star ?></h6>
                                <div>
                                <p class="mb-1 ml-2s">
                                    <span class="stars" data-rating="<?= $star ?>" data-num-stars="5" ></span>
                                </p>
                                <?php if($star > 0): ?>
                                <p class="text-muted m-0 des-pt">Học viên đánh giá BMG Edu <span class="pt"><?= $star ?></span> trên 5 sao.</p>
                                <?php else: ?>
                                <p class="text-muted m-0">Hãy là người đầu tiên đánh giá bài học này.</p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>
                </div>

                <?php
                    echo $this->render('/layouts/_box_comment',[
                    'id'=>$Course->id,//Mã khoá học, Mã bài viết,....
                    'type'=>'course',//Loại comment: course, news,...
                    'placeholder'=>'Bình luận của bạn về khoá học này',//Placeholder input comment
                    ]);
                ?>
            </div>
            <div class="relative col">
                <?php if($Coach){ ?>
                <section class="instructor-info">
                    <div class="instructor-info-header">
                    <a href="#"><img alt="" class="instructor-info-image" src="<?= $Coach->avatar ?>"></a>
                    <a class="instructor-info-header-text" href="#">
                        <h3 class="instructor-name"><?= $Coach->name ?></h3>
                        <div class="instructor-subtitle">Chuyên gia hàng đầu tại BMG Edu</div>
                    </a>
                    </div>
                    <div class="instructor-info-course-desc"></div>
                </section>
                <?php } ?>
                <?php if( !$isset_Course && $Course->price > 0 ){ ?>
                <section class="instructor-info">
                    <?php
                        $promotional_price = $Course->promotional_price > 0 ? $Course->promotional_price : $Course->price;
                        $price = $Course->price;                        
                        // $url_buy = Url::to(['payment/check-out','amount'=>$Course->promotional_price > 0 ? $Course->promotional_price : $Course->price ,'bankID'=>'','course_id'=>$Course->id]);
                        $url_buy = Url::to(['site/terms']) . '#thanh-toan';
                        if(!Yii::$app->user->identity){
                            $url_buy = 'javascript:;';
                        }
                    ?>
                    <div class="instructor-info-header text-center">
                        <h4 class="course-price">
                            <?= number_format($promotional_price,0,'.','.') ?><sup>đ</sup>
                            <?php if($promotional_price > 0 ){ ?>
                                <span class="price-discount"><?= number_format($promotional_price,0,'.','.') ?><sup>đ</sup></span>
                            <?php } ?>
                        </h4>
                    </div>
                    <div class="instructor-info-course-content">
                        <p class="text-center">
                            <a href="<?= $url_buy ?>" class="btn btn-buy btn-primary <?= !Yii::$app->user->identity ? 'needLogin' : '' ?>">
                                MUA KHOÁ HỌC
                            </a>
                        </p>
                        <ul style="margin-left: 0">
                            <li><i class="fa fa-users" aria-hidden="true"></i>Số người đã học: 
                                <span><?= $Course->total_learn ?> người</span>
                            </li>
                            <li><i class="fa fa-clock" aria-hidden="true"></i>Thời lượng: 
                                <span><?= $Course->total_hours_learn ?> giờ</span>
                            </li>
                            <li><i class="fa fa-play-circle" aria-hidden="true"></i>Giáo trình: 
                                <span><?= $Course->total_lessons ?> bài giảng</span>
                            </li>
                            <li><i class="fa fa-history" aria-hidden="true"></i>Sở hữu khóa học trọn đời</li>
                        </ul>
                    </div>
                </section>
                <?php } ?>
                <div class="relative" style="height: 100%;">
                    <div class="d-flex flex-column">
                    <div class="lesson-list list_video flex-grow-1 d-flex flex-column h-100">
                        <h3><span class="text-uppercase mr-2">Danh sách bài học</span><span>(<?= count($Lessions) ?> bài học)</span></h3>
                        <ul class="flex-grow-1">
                            <?php 
                                $stt = 0;
                                foreach($Sections as $section){
                            ?>
                            <li>
                                <h3><?= $section['name']?></h3>
                                <ul>
                                <?php
                                    foreach($Lessions as $key=>$lesson){
                                        
                                        if( $lesson['course_section_id'] == $section['id']){
                                            $stt++;
                                        $isShowLinkVideo = (($isset_Course || $lesson['is_prevew'] ) || $Course['price'] == 0 ) ? true : false;
                                        //Url::to(['product/detail', 'slug' => $Course->slug,'slug_lesson'=>$lesson->slug])
                                ?>
                                
                                    <li>
                                        <a href="javascript:;" data-stt="<?= $stt ?>" data-id="<?= $lesson['id'] ?>" link_youtube="<?= ($isShowLinkVideo &&  $lesson['link_youtube'])? $lesson['link_youtube'] : '' ?>" class="d-flex <?= $isShowLinkVideo ? 'show' : 'notshow'?> <?= $key == 0 ? 'active' : '' ?>">
                                            <div class="indicator"><i class="far fa-play-circle"></i></div>
                                            <div><?= $lesson->name ?></div>
                                        </a>
                                    </li>
                                <?php
                                    } 
                                    } ?>
                                </ul>
                            </li>
                            <?php 
                            
                            }
                            
                            ?>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<input type="hidden" id="course_id" value="<?= $Course->id ?>" />
<?php if( !Yii::$app->user->isGuest ): ?>
<input type="hidden" id="usrif" value="<?= Yii::$app->user->identity->fullname . ' ' . Yii::$app->user->identity->phone ?>" />
<?php endif; ?>
<?php if($lessonCurrent && $isShowLinkVideoCurrent && $lessonCurrent['link_youtube'] == ""){ ?>
<script>
  var id    = '<?= $lessonCurrent->id ?>';
  var _0x6c93=["\x76\x69\x64\x65\x6F","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x69\x64","\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x63\x6C\x61\x73\x73","\x76\x69\x64\x65\x6F\x2D\x6A\x73\x20\x76\x6A\x73\x2D\x64\x65\x66\x61\x75\x6C\x74\x2D\x73\x6B\x69\x6E\x20\x76\x6A\x73\x2D\x66\x6C\x75\x69\x64\x20\x76\x6A\x73\x2D\x31\x36\x2D\x39\x20\x76\x6A\x73\x2D\x62\x69\x67\x2D\x70\x6C\x61\x79\x2D\x63\x65\x6E\x74\x65\x72\x65\x64\x20\x75\x69\x2D\x6D\x69\x6E\x20\x75\x69\x2D\x73\x6D\x6F\x6F\x74\x68\x20\x76\x5F\x35\x65\x38\x34\x39\x34\x65\x37\x63\x63\x62\x33\x30\x2D\x64\x69\x6D\x65\x6E\x73\x69\x6F\x6E\x73\x20\x76\x6A\x73\x2D\x63\x6F\x6E\x74\x72\x6F\x6C\x73\x2D\x65\x6E\x61\x62\x6C\x65\x64\x20\x76\x6A\x73\x2D\x77\x6F\x72\x6B\x69\x6E\x67\x68\x6F\x76\x65\x72\x20\x76\x6A\x73\x2D\x76\x37\x20\x76\x6A\x73\x2D\x68\x6C\x73\x2D\x71\x75\x61\x6C\x69\x74\x79\x2D\x73\x65\x6C\x65\x63\x74\x6F\x72\x20\x76\x6A\x73\x2D\x68\x61\x73\x2D\x73\x74\x61\x72\x74\x65\x64\x20\x76\x6A\x73\x2D\x70\x61\x75\x73\x65\x64\x20\x76\x6A\x73\x2D\x75\x73\x65\x72\x2D\x69\x6E\x61\x63\x74\x69\x76\x65","\x73\x6F\x75\x72\x63\x65","\x73\x72\x63","\x2F\x75\x70\x6C\x6F\x61\x64\x73\x2F\x76\x69\x64\x65\x6F\x2D\x6C\x65\x73\x73\x6F\x6E\x2F","\x2F\x76\x69\x64\x65\x6F\x2E\x6D\x33\x75\x38","\x74\x79\x70\x65","\x61\x70\x70\x6C\x69\x63\x61\x74\x69\x6F\x6E\x2F\x78\x2D\x6D\x70\x65\x67\x55\x52\x4C","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x76\x69\x64\x65\x6F\x5F\x70\x6C\x61\x79\x65\x72","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64"];var video=document[_0x6c93[1]](_0x6c93[0]);video[_0x6c93[3]](_0x6c93[2],_0x6c93[0]);video[_0x6c93[3]](_0x6c93[4],_0x6c93[5]);var video_source=document[_0x6c93[1]](_0x6c93[6]);video_source[_0x6c93[3]](_0x6c93[7],_0x6c93[8]+ id+ _0x6c93[9]);video_source[_0x6c93[3]](_0x6c93[10],_0x6c93[11]);video[_0x6c93[12]](video_source);document[_0x6c93[14]](_0x6c93[13])[_0x6c93[12]](video)
</script>
<?php } ?>
<script src="/js/video.js"></script>
<script src="/js/videojs-http-streaming.js"></script>
<script src="/js/videojs-contrib-quality-levels.min.js"></script>
<script src="/js/videojs-hls-quality-selector.min.js"></script>
<script>
    // var _0xb046=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x2F\x6A\x73\x2F\x63\x75\x73\x74\x6F\x6D\x2E\x6A\x73","\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x62\x6F\x64\x79"];
    var _0xd878=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x2F\x6A\x73\x2F\x63\x75\x73\x74\x6F\x6D\x2E\x6A\x73\x3F\x76\x3D\x31\x2E\x32\x2E\x32","\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x62\x6F\x64\x79"];
    var _0xb046=[_0xd878[0],_0xd878[1],_0xd878[2],_0xd878[3],_0xd878[4],_0xd878[5],_0xd878[6]];
    var _script=document[_0xb046[1]](_0xb046[0]);
    _script[_0xb046[4]](_0xb046[2],_0xb046[3]);document[_0xb046[6]][_0xb046[5]](_script)
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.stars').stars();
    });
    
</script>