<?php

return [
    // 站点标题
    'name' => 'Laravel Shop',
    // 页面顶部 Logo
    'logo' => '<b>Laravel</b> Shop',
    // 页面顶部小 Logo
    'logo-mini' => '<b>LS</b>',
    // 路由配置
    'route' => [
        // 路由前缀
        'prefix' => 'admin',
        // 控制器命名空间前缀
        'namespace' => 'App\\Admin\\Controllers',
        // 默认中间件列表
        'middleware' => ['web', 'admin'],
    ],

    // Laravel-Admin 的安装目录
    'directory' => app_path('Admin'),
    // Laravel-Admin 的页面标题
    'title' => 'Laravel Shop 管理后台',
    // 是否使用 https
    'secure' => env('ADMIN_HTTPS', false),
    // Laravel-Admin 用户认证设置
    'auth' => [
        'controller' => App\Admin\Controllers\AuthController::class,
        'guards' => [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admin',
            ],
        ],
        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model' => Encore\Admin\Auth\Database\Administrator::class,
            ],
        ],
    ],

    // Laravel-Admin 文件上传设置
    'upload' => [
        // 对应
    ]
]