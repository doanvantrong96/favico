<?php
    use backend\controllers\CommonController;
    $action_config = '/news/config-home';
                    
?>
<ul class="nav nav-tabs">
    <?php /*if( CommonController::checkAccess($action_config) ): ?>
    <li class="nav-item">
        <a class="nav-link" style="text-decoration: none !important;" target="_blank" href="<?= $action_config ?>">Cấu hình bài viết trang chủ</a>
    </li>
    <?php endif;*/ ?>
    <li class="nav-item"><a class="nav-link <?= $tab == 'all' ? 'active' : '' ?>" href="/news/index?NewsSearch[tab]=all">Tất cả</a></li>
    <li class="nav-item"><a class="nav-link <?= $tab == 'published' ? 'active' : '' ?>" href="/news/index?NewsSearch[tab]=published">Đã duyệt</a></li>
    <li class="nav-item"><a class="nav-link <?= $tab == 'drafts' ? 'active' : '' ?>" href="/news/index?NewsSearch[tab]=drafts">Nháp</a></li>
</ul>