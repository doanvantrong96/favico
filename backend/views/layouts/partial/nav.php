<?php
    use yii\helpers\Url;
    use mdm\admin\components\AccessControl;
    use yii\helpers\Json;
    use backend\models\Employee;
    

    $user = Yii::$app->user->identity;
    $accessCtroller = new AccessControl;
    $isAdmin        = false;
    if( !Yii::$app->user->isGuest )
        $isAdmin    = Yii::$app->user->identity->is_admin;
    
    $menu           = isset(Yii::$app->params['menu']) ? Yii::$app->params['menu'] : [];
    $actionCurrent  = explode('?',Yii::$app->request->url);
    $actionCurrent  = $actionCurrent[0];
?>
<nav id="js-primary-nav" class="primary-nav" role="navigation">
    <div class="nav-filter">
        <div class="position-relative">
            <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
            <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                <i class="fal fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="info-card">
        <div class="img-avatars">
            <img src="/img/demo/avatars/logo.png" class="profile-image rounded-circle" alt="<?= $user->fullname ?>">
        </div>
        <div class="info-card-text">
            <a href="#" class="d-flex align-items-center text-white">
                <span class="text-truncate text-truncate-sm d-inline-block">
                    Xin chào, <?= $user->fullname ?>
                </span>
            </a>
            <!-- <span class="d-inline-block text-truncate text-truncate-sm"></span> -->
        </div>
        <img src="/img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">
        <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
            <i class="fal fa-angle-down"></i>
        </a>
    </div>
    <ul id="js-nav-menu" class="nav-menu">
        <?php 
            if( !empty($menu) ){
                $dataActionAccess = [];
                foreach($menu as $groupMenu){
                    if( isset($groupMenu['enable']) && !empty($groupMenu['enable']) ){
                        if( $groupMenu['enable'] == 'lecturer' ){
                            if( !$user->lecturer_id ){
                                continue;   
                            }
                        }else if( $groupMenu['enable'] == 'sale' ){
                            if( !$user->affliate_id ){
                                continue;   
                            }
                        }
                        else if( $groupMenu['enable'] == 'sale_admin' ){
                            if( $user->account_type != Employee::TYPE_SALE_ADMIN ){
                                continue;   
                            }
                        }
                    }
                    $flag_active_menu   = false;
                    $flag_has_access    = false;
                    $link_parent        = '#';
                    $label_parent       = '';
                    $icon_parent        = '';
                    $totalChild         = count($groupMenu['child_action']);
                    if( $totalChild == 1 ){
                        $link_parent = $groupMenu['child_action'][0]['url'];
                        $label_parent= $groupMenu['child_action'][0]['label'];
                        $icon_parent = isset($groupMenu['child_action'][0]['icon']) ? $groupMenu['child_action'][0]['icon'] : '';
                    }else{
                        $label_parent= $groupMenu['label'];
                        $icon_parent = isset($groupMenu['icon']) ? $groupMenu['icon'] : '';
                    }
                    
                    foreach($groupMenu['child_action'] as $key=>$value){
                        if( !$isAdmin ){
                            $check = $accessCtroller->checkRouter($value['url']);
                            if ($check)
                                $flag_has_access = true;
                        }else{
                            $check = true;
                            $flag_has_access = true;
                        }
                        $dataActionAccess[$value['url']] = $check;

                        $dataUrl = array_values(array_filter(explode('/',$value['url'])));
                        if( !empty($dataUrl) ){
                            $dataUrl[0]   = '/' . $dataUrl[0];
                            $arrUrlActive = [$value['url'],($dataUrl[0] . '/create'),($dataUrl[0] . '/view'),($dataUrl[0] . '/update')];
                        }
                        else
                            $arrUrlActive = [$value['url']];
                        if ( in_array($actionCurrent,$arrUrlActive) )
                            $flag_active_menu = true;
                        
                    }
                    
                    if( $isAdmin || $flag_has_access ){
        ?>
            <li <?= $flag_active_menu ? 'class="active open"' : '' ?>>
                <a href="<?= $link_parent ?>" data-filter-tags="<?= $label_parent ?>">
                    <?= !empty($icon_parent) ? '<i class="' . $icon_parent . '"></i>' : '' ?>
                    <span class="nav-link-text"><?= $label_parent ?></span>
                </a>
                <?php if( $totalChild > 1 ){ ?>
                    <ul>
                        <?php
                            foreach($groupMenu['child_action'] as $childAction){
                                $data_filter_tags = $childAction['label'];
                                $boolAccess = $isAdmin ? true : false;
                                if( !$boolAccess && isset($dataActionAccess[$childAction['url']]) )
                                    $boolAccess = $dataActionAccess[$childAction['url']];
                                if( $boolAccess ){
                        ?>
                            <li <?= $childAction['url'] == $actionCurrent ? 'class="active"' : '' ?>>
                                <a href="<?= $childAction['url'] ?>" title="<?= $childAction['label'] ?>" data-filter-tags="<?= $data_filter_tags ?>">
                                    <?= isset($childAction['icon']) && !empty($childAction['icon']) ? '<i class="' . $childAction['icon'] . '"></i>' : '' ?>
                                    <span class="nav-link-text"><?= $childAction['label'] ?></span>
                                </a>
                            </li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                <?php } ?>
            </li>
        <?php
                    }
                }
            }
        ?>
    </ul>
    <div class="filter-message js-filter-message bg-success-600"></div>
</nav>