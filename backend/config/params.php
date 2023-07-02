<?php
return [
    'adminEmail' => 'admin@example.com',
    'root_foder_upload' => '/home/edhcklfhosting/public_html/yogalunathai/frontend/web',
    'statusList' => [
        1        => 'Hoạt động',
        0        => 'Không hoạt động'
    ],
    'stateCommunityList' => [
        1        => 'Hiển thị',
        0        => 'Ẩn'
    ],
    'statusCommunityList' => [
        0        => 'Chờ duyệt',
        1        => 'Đã duyệt',
        2        => 'Từ chối duyệt'
    ],
    'news_status' => [
        2 => 'Nháp',
        // 0 => 'Chờ duyệt',
        0 => 'Đang ẩn',
        1 => 'Đang hiển thị'
    ],
    'userStatus' => [
        0 => 'Khoá',
        1 => 'Hoạt động',
        2 => 'Khoá đăng nhập'
    ],
    'orderStatus' => [
        0 => 'Chờ thanh toán',
        1 => 'Đã thanh toán',
        2 => 'Thanh toán không thành công',
        3 => 'Khách hàng huỷ',
        4 => 'Admin huỷ'
    ],
    'orderType' => [
        1 => 'Chuyển khoản',
        2 => 'VNPAY',
    ],
    'employeeAccountType' => [
        1 => 'Nhân viên',
        2 => 'Giảng viên',
        3 => 'Sale',
        4 => 'Sale Admin'
    ],
    'giftTypePrice' => [
        1 => 'Số tiền',
        2 => 'Phần trăm - Số tiền tối đa',
        3 => 'Phần trăm - Tổng đơn hàng'
    ],
    'permission' => [
        'view_all_post_of_category' => ['Xem toàn bộ bài viết chuyên mục'],
        'edit_all_post' => ['Sửa bài viết bỏ qua trạng thái'],
        'view_dashboard'=> ['Xem DashBoard']
    ],
];
