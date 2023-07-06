<?php
/**
 * Created by Visual code.
 * User: ngochan
 * Date: 12/03/20
 * Time: 22:10 PM
 */

$group_dashboard = [
    [
        'label' => 'Dashboard',
        'icon' => 'fal fa-chart-pie',
        'url' => '/'
    ],
];

$group_course = [
    [
        'label' => 'Danh sách khoá học',
        'icon' => 'fal fa-list-alt',
        'url' => '/course/index'
    ],
    // [
    //     'label' => 'Danh sách bài học',
    //     'icon' => 'fal fa-book',
    //     'url' => '/course-lesson/index'
    // ],
    [
        'label' => 'Quản lý danh mục',
        'icon' => 'fal fa-tags',
        'url' => '/category/index'
    ],
    [
        'label' => 'Danh sách giảng viên',
        'icon' => 'fal fa-user-md',
        'url' => '/lecturer/index'
    ],
];
$group_users = [
    [
        'label' => 'Danh sách khách hàng',
        'icon' => 'fal fa-users',
        'url' => '/customer/index'
    ],
    [
        'label' => 'Giao dịch mua khoá học',
        'icon' => 'fal fa-money-bill-alt',
        'url' => '/history-transaction/index'
    ],
    [
        'label' => 'Đăng ký email ưu đãi',
        'icon' => 'fal fa-envelope',
        'url' => '/user-register-email/index'
    ],
];
$group_setting = [
    [
        'label' => 'Quản lý tài khoản',
        'icon' => 'fal fa-user',
        'url' => '/assignment/index'
    ],
    [
        'label' => 'Quản lý vai trò',
        'icon' => 'fal fa-users',
        'url' => '/role/index'
    ],
    [
        'label' => 'Quản lý task',
        'icon' => 'fal fa-tasks',
        'url' => '/permission/index'
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
    ],
    [
        'label' => 'Nhóm câu hỏi thường gặp',
        'icon' => 'fal fa-book',
        'url' => '/frequently-questions-group/index'
    ],
    [
        'label' => 'Câu hỏi thường gặp',
        'icon' => 'fal fa-book',
        'url' => '/frequently-questions/index'
    ],
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
$group_lecturer_report = [
    [
        'label' => 'Dashboard',
        'icon' => 'fal fa-chart-pie',
        'url' => '/lecturer-report/index'
    ],
    [
        'label' => 'Khoá học',
        'icon' => 'fal fa-list-alt',
        'url' => '/lecturer-report/list-course'
    ],
];
$group_gift_code = [
    [
        'label' => 'Mã khuyến mại',
        'icon' => 'fal fa-gift',
        'url' => '/gift-code/index'
    ]
];
$group_sale_admin = [
    [
        'label' => 'Dashboard',
        'icon' => 'fal fa-chart-pie',
        'url' => '/sale-admin/index'
    ],
    [
        'label' => 'Quản lý tài khoản sale',
        'icon' => 'fal fa-list-alt',
        'url' => '/sale-admin/list-sale'
    ],
];
$menu_group_controller = [
    // [
    //     'label' => 'Dashboard',
    //     'controller' => 'site',
    //     'child_action' => $group_dashboard
    // ],
    [
        'label' => 'Thống kê',
        'icon'  => 'fal fa-chart-bar',
        'controller' => 'lecturer-report',
        'child_action' => $group_lecturer_report,
        'enable'=> 'lecturer'
    ],
    [
        'label' => 'Sale Admin',
        'icon'  => 'fal fa-chart-bar',
        'controller' => 'sale-admin',
        'child_action' => $group_sale_admin,
        'enable'=> 'sale_admin'
    ],
    [
        'label' => 'Cấu hình trang chủ',
        'icon'  => 'fal fa-cog',
        'controller' => 'banner,config',
        'child_action' => $group_config_home
    ],  
    // [
    //     'label' => 'Khoá học',
    //     'icon'  => 'fal fa-window',
    //     'controller' => 'course,lecturer,course-category,course-lesson',
    //     'child_action' => $group_course
    // ],
    // [
    //     'label' => 'Mã khuyến mại',
    //     'icon'  => 'fal fa-gift',
    //     'controller' => 'gift-code',
    //     'child_action' => $group_gift_code
    // ],
    [
        'label' => 'Tin tức',
        'icon'  => 'fal fa-newspaper',
        'controller' => 'news,category-tags',
        'child_action' => $group_news
    ],
    [
        'label' => 'Khách hàng',
        'icon'  => 'fal fa-users',
        'controller' => 'users,user-course,register-practice-try,history-transaction',
        'child_action' => $group_users
    ],
    [
        'label' => 'Quản lý hệ thống',
        'icon'  => 'fal fa-cog',
        'controller' => 'assignment,role,permission',
        'child_action' => $group_setting
    ]
];

return [
    "menu" => $menu_group_controller
];
?>