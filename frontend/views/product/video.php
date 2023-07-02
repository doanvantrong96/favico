<?php 
    use yii\helpers\Url;

?>
<style>
.box_left {
    width: 450px;
    float: left;
    height: 400px;
    overflow-y: scroll;
    border-right: 1px solid #ccc;
    margin-right: 20px;
    background: #f5f5f5;
}

ul{
    list-style: none;
}
ul.list_video li {
    border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;
    padding: 10px 20px;
    cursor: pointer;
    margin-bottom: 0;
    padding-top: 15px;
}
ul.list_video li:hover , ul.list_video li.active {
    background: #ce6d96;
}
ul.list_video li:hover span, ul.list_video li.active span {
    color: #fff;
}
.box_left h2 {
    padding: 30px 20px 0 20px;
}
.box_left h3 {
    padding: 10px 20px 10px;
    background: rgb(232, 232, 232);
    margin: 0;
    margin-top: 10px;
    
}
video{
    width: calc(100% - 500px);
    outline: none !important;
}
.box_right h2 {
    padding-top: 30px;
}
span.btn.view {
    float: right;
    background: #ff277f;
    position: relative;
    top: -3px;
    border-radius: 20px;
    color: #fff;
    padding: 3px 10px;
    font-size: .75em;
}
.fix_left {
    float: left;
    width: 450px;
    padding: 15px 20px;
    border-right: 1px solid #ccc;
}
.fix_right {
    float: left;
    width: calc(100% - 450px);
    height: 100%;
}
.fix_left span {
    cursor: pointer;
    padding: 10px;
}
.fix_right > div {
    width: 50%;
    height: 100%;
    float: left;
    text-align: center;
    padding-top: 15px;
    cursor: pointer;
}
.fix_right > div:hover {
    background: #ff277f;
}
.fix_right > div:hover, .fix_right .active {
    background: #ff277f;
}
.div_fix {
    position: fixed;
    top: 0;
    width: 100%;
    background: #000;
    height: 50px;
    z-index: 10000;
    color: #fff;
    border-right: 1px solid #ccc;
    font-weight: bold;
    font-size: 16px;
}
.fix_right > div:first-child {
    border-right: 1px solid #ccc;
}
#footer,.coppyright{
    display:none
}
h1, h2, h3, h4, h5, h6, .heading-font, .off-canvas-center .nav-sidebar.nav-vertical>li>a {
    font-family: 'Roboto', sans-serif;
}
.notshow .view{
    opacity: 0.5;
}
.lession_name{
    width: 80%;
    overflow: hidden;
    height: 20px;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: inline-block;

}
.content_left{
    display:none;
    /* display:block; */
}
.content_left.active{
    display:block;
    /* display:none; */
}
.content_left.lock {
    text-align: center;
    padding-top: 60px;
}
/* Custom CSS Mobile */

</style>
<link rel="stylesheet" href="/css/default_skin.css" />
<link rel="stylesheet" href="/css/videojs-hls-player.css" />
<div>
    <div class="box_left">
        <h2><?= $Course->name ?></h2>
        <?php 
            $lesson_id_first = 0;
            foreach($Sections as $section){
        ?>
        <h3><?= $section['name']?></h3>
            
            <ul class="list_video">
                <?php 
                $i = 0;
                foreach( $Lessions as $lession){ 
                    if( $lession['course_section_id'] == $section['id']){
                        if( $lesson_id_first <= 0 ){
                            $lesson_id_first =  $lession['id'];
                        }
                        $isShowLinkVideo = (($isset_Course || $lession['is_prevew'] ) || $Course['price'] == 0 ) ? true : false;
                ?>
                    <li data-id="<?= $isShowLinkVideo ? $lession['id'] : '' ?>" link_youtube = "<?= ($isShowLinkVideo &&  $lession['link_youtube'])? $lession['link_youtube'] : '' ?>" class="<?= $isShowLinkVideo ? 'show' : 'notshow'?> <?= $i == 0 ? 'active' : '' ?>">
                        <div>
                            <span class="lession_name"><?= $lession['name']?></span>
                            <span class="btn view">Xem ngay</span>
                        </div>
                    </li>
                    <?php }
                    $i++; 
                }?>

            </ul>
        <?php } ?>
    </div>
    <div class="box_right">
        <div class="content_left active unlock">
            <h2 class="title_lession"><?= $Lessions[0]['name']?></h2>

            <div class='videojs-hls-player-wrapper' id="video_player">
            </div>
        </div>
        <div class="content_left lock">
            <div class="icon_lock">
                <i class="fa fa-lock"></i>
            </div>
            

            <h2>Nội dung khoá học đã bị khoá</h2>
            <?php if(Yii::$app->user->isGuest){ ?><h3>Nếu bạn đã ghi danh, bạn cần phải <a href="/site/login" >đăng nhập</a></h3><?php }?>
            <a class="button primary" style="border-radius:99px;" href="http://cogaivangyoga.vn/payment/check-out?amount=<?= $Course->price?>&bankID=&course_id=<?=$Course->id?>">
                <span>Ghi danh vào khoá học để mở khoá</span>
            </a>
        </div>
    </div>
    <style>
        .icon_lock i{
            font-size: 60px;
        }
        a.button.primary {
    margin-top: 20px;
}
.content_left.lock {
    text-align: center;
    padding-top: 60px;
}
p {
    margin-bottom: 10px;
}
        .fix_left i {
    width: 15px;
    height: 20px;
    font-size: 20px;
    padding-top: 0px;
    position: relative;
    top: 1px;
}
.fix_right .disabled {
    opacity: 0.5;
}
.box_right {
    float: right;
    margin-right: 15px;
    width: calc(100% - 485px);
}
    </style>
    <div class="div_fix">
        <div class="fix_left">
                <span><i class="fa fa-angle-left" title="Back to course curriculum"></i><span class="text-button">Quay lại</span></span>
        </div>
        <div class="fix_right">
            <div class="back_lession"> <i class="fa fa-arrow-left" aria-hidden="true"></i>  <span class="text-button">Bài tập trước</span></div>
            <div class="next_lession active"><span class="text-button">Hoàn thành và tiếp tục</span>  <i class="fa fa-arrow-right" aria-hidden="true"></i></div>
        </div>
    </div>
</div>
<script>
  var id    = '<?= $lesson_id_first ?>';
  var _0x6c93=["\x76\x69\x64\x65\x6F","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x69\x64","\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x63\x6C\x61\x73\x73","\x76\x69\x64\x65\x6F\x2D\x6A\x73\x20\x76\x6A\x73\x2D\x64\x65\x66\x61\x75\x6C\x74\x2D\x73\x6B\x69\x6E\x20\x76\x6A\x73\x2D\x66\x6C\x75\x69\x64\x20\x76\x6A\x73\x2D\x31\x36\x2D\x39\x20\x76\x6A\x73\x2D\x62\x69\x67\x2D\x70\x6C\x61\x79\x2D\x63\x65\x6E\x74\x65\x72\x65\x64\x20\x75\x69\x2D\x6D\x69\x6E\x20\x75\x69\x2D\x73\x6D\x6F\x6F\x74\x68\x20\x76\x5F\x35\x65\x38\x34\x39\x34\x65\x37\x63\x63\x62\x33\x30\x2D\x64\x69\x6D\x65\x6E\x73\x69\x6F\x6E\x73\x20\x76\x6A\x73\x2D\x63\x6F\x6E\x74\x72\x6F\x6C\x73\x2D\x65\x6E\x61\x62\x6C\x65\x64\x20\x76\x6A\x73\x2D\x77\x6F\x72\x6B\x69\x6E\x67\x68\x6F\x76\x65\x72\x20\x76\x6A\x73\x2D\x76\x37\x20\x76\x6A\x73\x2D\x68\x6C\x73\x2D\x71\x75\x61\x6C\x69\x74\x79\x2D\x73\x65\x6C\x65\x63\x74\x6F\x72\x20\x76\x6A\x73\x2D\x68\x61\x73\x2D\x73\x74\x61\x72\x74\x65\x64\x20\x76\x6A\x73\x2D\x70\x61\x75\x73\x65\x64\x20\x76\x6A\x73\x2D\x75\x73\x65\x72\x2D\x69\x6E\x61\x63\x74\x69\x76\x65","\x73\x6F\x75\x72\x63\x65","\x73\x72\x63","\x2F\x75\x70\x6C\x6F\x61\x64\x73\x2F\x76\x69\x64\x65\x6F\x2D\x6C\x65\x73\x73\x6F\x6E\x2F","\x2F\x76\x69\x64\x65\x6F\x2E\x6D\x33\x75\x38","\x74\x79\x70\x65","\x61\x70\x70\x6C\x69\x63\x61\x74\x69\x6F\x6E\x2F\x78\x2D\x6D\x70\x65\x67\x55\x52\x4C","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x76\x69\x64\x65\x6F\x5F\x70\x6C\x61\x79\x65\x72","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64"];var video=document[_0x6c93[1]](_0x6c93[0]);video[_0x6c93[3]](_0x6c93[2],_0x6c93[0]);video[_0x6c93[3]](_0x6c93[4],_0x6c93[5]);var video_source=document[_0x6c93[1]](_0x6c93[6]);video_source[_0x6c93[3]](_0x6c93[7],_0x6c93[8]+ id+ _0x6c93[9]);video_source[_0x6c93[3]](_0x6c93[10],_0x6c93[11]);video[_0x6c93[12]](video_source);document[_0x6c93[14]](_0x6c93[13])[_0x6c93[12]](video)
</script>
  <script src="/js/video.js"></script>
<script src="/js/videojs-http-streaming.js"></script>
<script src="/js/videojs-contrib-quality-levels.min.js"></script>
<script src="/js/videojs-hls-quality-selector.min.js"></script>
<script>
    var _0xb046=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x2F\x6A\x73\x2F\x63\x75\x73\x74\x6F\x6D\x2E\x6A\x73","\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x62\x6F\x64\x79"];var _script=document[_0xb046[1]](_0xb046[0]);_script[_0xb046[4]](_0xb046[2],_0xb046[3]);document[_0xb046[6]][_0xb046[5]](_script)
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var height = $( window ).height();
        $('.box_left').height(height);
        $('.list_video li:first-child').addClass('active');
        $('.fix_right .back_lession').addClass('disabled');
        
        $('.fix_left span').click(function(){
            // window.history.back();
            window.location.href="<?= Url::to(['product/detail', 'slug' => $Course['slug']]);?>";
        });
        // window.oncontextmenu = function ()
        //     {
        //         return false;  
        //     }
    });
    
</script>
<style>
    @media (max-width: 549px) {
        .div_fix {
            height: 56px;
        }
        .text-button{
            display:none
        }
        .box_left {
            width: 100%;
            height: 220px !important;
            display: inline-block !important;
        }
        video {
            width: 100%;
            height: auto;
        }
        .box_right {
            padding: 0 5%;
            width: 100%;
            margin-right: 0px;
        }
        .fix_left {
            width: 15%;
        }
        .fix_right {
            width: 85%;
        }
        .lession_name{
            width: 70%;
        }
    } 
div#quick-alo-phoneIcon {
    display: none;
}  
.fb-icon {
    display: none;
}
</style>