<?php
$avatar = '<i class="icon-user-comment"></i>';
if( Yii::$app->user->identity && Yii::$app->user->identity->fb_id != '' )
    $avatar = '<img src="https://graph.facebook.com/' . Yii::$app->user->identity->fb_id . '/picture?type=normal" width="39" height="39" style="border-radius:50%" />';
if(!$isCommentChild){
?>
<div class="item-comment item-parent-<?= $modelComment->id ?>">
    <?= $avatar ?>
    <div class="info-comment">
        <b class="user-comment"><?= $modelComment->username ?></b>
        <div class="content-comment">
            <?= $modelComment->comment ?>
        </div>
        <p class="action-comment">
            <span class="reply-comment" dtid="<?= $modelComment->id ?>"><b class="dot">●</b> <span class="total-reply reply-0">0</span> Trả lời</span>
            <span class="time-comment"><b class="dot">●</b> <?= date('H:i d/m/Y', time()) ?></span>
        </p>
        <div class="comment-child"></div>
    </div>
</div>
<?php }else{ ?>
<div class="item-comment-child">
    <?= $avatar ?>
    <div class="info-comment">
        <b class="user-comment"><?= $modelComment->username ?></b>
        <div class="content-comment">
            <?= $modelComment->comment ?>
        </div>
        <p class="action-comment">
            <span class="time-comment"><b class="dot">●</b> <?= date('H:i d/m/Y', time()) ?></span>
        </p>
    </div>
</div>
<?php } ?>