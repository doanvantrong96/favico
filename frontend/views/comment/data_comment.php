<?php
    if( !empty($dataCommentParent) ){
        $user_id_current = 0;
        $avatar = '<i class="icon-user-comment"></i>';
        $avatarUser     = '';
        if( Yii::$app->user->identity && Yii::$app->user->identity->fb_id != '' ){
            $avatarUser = '<img src="https://graph.facebook.com/' . Yii::$app->user->identity->fb_id . '/picture?type=normal" width="39" height="39" style="border-radius:50%" />';
            $user_id_current = Yii::$app->user->identity->id;
        }else
            $avatarUser     = $avatar;
        foreach($dataCommentParent as $commentParent){
            $arrCommentChild = isset($dataCommentChild[$commentParent['id']]) ? $dataCommentChild[$commentParent['id']] : [];
?>
<div class="item-comment item-parent-<?= $commentParent['id'] ?>">
    <?= $commentParent->user_id == $user_id_current ? $avatarUser : (isset($dataUserComment[$commentParent['user_id']]) ? $dataUserComment[$commentParent['user_id']] : $avatar) ?>
    <div class="info-comment">
        <b class="user-comment"><?= $commentParent['username'] ?></b>
        <div class="content-comment">
            <?= $commentParent['comment'] ?>
        </div>
        <p class="action-comment">
            <span class="reply-comment" dtid="<?= $commentParent['id'] ?>"><b class="dot">●</b> <span class="total-reply reply-<?= count($arrCommentChild) ?>"><?= count($arrCommentChild) ?></span> Trả lời</span>
            <span class="time-comment"><b class="dot">●</b> <?= date('H:i d/m/Y', strtotime($commentParent->create_date)) ?></span>
        </p>
        <div class="comment-child <?= !empty($arrCommentChild) ? 'active' : '' ?>">
        <?php 
            if( !empty($arrCommentChild) ){
                foreach($arrCommentChild as $commentChild){ 
        ?>
            <div class="item-comment-child">
                <?= $commentChild->user_id == $user_id_current ? $avatarUser : (isset($dataUserComment[$commentParent['user_id']]) ? $dataUserComment[$commentParent['user_id']] : $avatar) ?>
                <div class="info-comment">
                    <b class="user-comment"><?= $commentChild['username'] ?></b>
                    <div class="content-comment">
                        <?= $commentChild['comment'] ?>
                    </div>
                    <p class="action-comment">
                        <span class="time-comment"><b class="dot">●</b> <?= date('H:i d/m/Y', strtotime($commentChild->create_date)) ?></span>
                    </p>
                </div>
            </div>
            <?php 
                    }
                } 
            ?>

        </div>
    </div>
</div>
<?php
        }
    }
?>