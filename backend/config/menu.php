<?php
$group_dashboard = [
    [
        'label' => 'Dashboard',
        'icon' => 'fal fa-chart-pie',
        'url' => '/'
    ],
];

$group_setting = [
    [
        'label' => 'Quản lý tài khoản',
        'icon' => 'fal fa-user',
        'url' => '/assignment/index'
    ],
    // [
    //     'label' => 'Quản lý vai trò',
    //     'icon' => 'fal fa-users',
    //     'url' => '/role/index'
    // ],
    // [
    //     'label' => 'Quản lý task',
    //     'icon' => 'fal fa-tasks',
    //     'url' => '/permission/index'
    // ]
];
$group_config = [
    [
        'label' => 'Cài đặt khác',
        'icon' => 'fal fa-cogs',
        'url' => '/config/index'
    ]
];
$group_branch = [
    [
        'label' => 'Quản lý chi nhánh',
        'icon' => 'fal fa-map-marker',
        'url' => '/branch/index'
    ]
];
$group_banner = [
    [
        'label' => 'Quản lý banner',
        'icon' => 'fal fa-image',
        'url' => '/banner/index'
    ],
    
];
$group_config_home = [
    [
        'label' => 'Banner',
        'icon' => 'fal fa-image',
        'url' => '/banner/index'
    ],
    [
        'label' => 'Đối tác',
        'icon' => 'fal fa-users',
        'url' => '/partner/index'
    ],
    [
        'label' => 'Về chúng tôi',
        'icon' => 'fal fa-bookmark',
        'url' => '/abouts/index'
    ],
    [
        'label' => 'Góc kỹ thuật',
        'icon' => 'fal fa-wrench',
        'url' => '/technical/index'
    ]
];
$group_news = [
    [
        'label' => 'Viết bài mới',
        'icon' => 'fal fa-pencil',
        'url' => '/news/create'
    ],
    [
        'label' => 'Danh sách bài viết',
        'icon' => 'fal fa-list',
        'url' => '/news/index'
    ],
    [
        'label' => 'Quản lý chuyên mục',
        'icon' => 'fal fa-tags',
        'url' => '/category/index'
    ],
];

$group_comment = [
    [
        'label' => 'Quản lý bình luận',
        'icon' => 'fal fa-comments',
        'url' => '/comment/index'
    ]
];
$group_customer     = [
    [
        'label' => 'Quản lý khách hàng',
        'icon' => 'fal fa-envelope',
        'url' => '/user-register-email/index'
    ]
];

$group_product = [
    [
        'label' => 'Danh sách sản phẩm',
        'icon' => 'fal fa-tasks',
        'url' => '/product/index'
    ],
    [
        'label' => 'Thêm mới sản phẩm',
        'icon' => 'fal fa-plus',
        'url' => '/product/create'
    ],
    [
        'label' => 'Quản lý nhà cung cấp',
        'icon' => 'fal fa-building',
        'url' => '/product-category/index'
    ],
    [
        'label' => 'Quản lý loại sản phẩm',
        'icon' => 'fal fa-file',
        'url' => '/product-tag/index'
    ]
];
$menu_group_controller = [
    [
        'label' => 'Cấu hình trang chủ',
        'icon'  => 'fal fa-cog',
        'controller' => 'banner,config',
        'child_action' => $group_config_home
    ],
    [
        'label' => 'Quản lý bình luận',
        'icon'  => 'fal fa-gift',
        'controller' => 'comment',
        'child_action' => $group_comment
    ],
    [
        'label' => 'Quản lý sản phẩm',
        'icon'  => 'fal fa-book',
        'controller' => 'product',
        'child_action' => $group_product
    ],
    [
        'label' => 'Tin tức',
        'icon'  => 'fal fa-newspaper',
        'controller' => 'news,category-tags',
        'child_action' => $group_news
    ],
    [
        'label' => 'Quản lý chi nhánh',
        'icon'  => 'fal fa-map',
        'controller' => 'branch',
        'child_action' => $group_branch
    ],
    [
        'label' => 'Quản lý khách hàng',
        'icon'  => 'fal fa-envelope',
        'controller' => 'user-register-email',
        'child_action' => $group_customer
    ],
    [
        'label' => 'Quản lý hệ thống',
        'icon'  => 'fal fa-cog',
        'controller' => 'assignment,role,permission',
        'child_action' => $group_setting
    ],
    [
        'label' => 'Cái đặt khác',
        'icon'  => 'fal fa-cogs',
        'controller' => 'config',
        'child_action' => $group_config
    ]
];

return [
    "menu" => $menu_group_controller
];
?>