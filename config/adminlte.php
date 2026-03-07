<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>CT</b>-CSP',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'CT-CSP',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => 'admin/users/profile',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-success elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark navbar-success',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'Search Rider...',
            'topnav_right' => true,
            'url'          => 'admin/riders/search',
            'method'       => 'get',
            'input_name'   => 'query',
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Search...',
        ],
        [
            'text' => 'DASHBOARD',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'submenu' => [
                [
                    'text' => 'Overview',
                    'url'  => 'admin/dashboard/overview',
                ],
                [
                    'text' => 'Analytics',
                    'url'  => 'admin/dashboard/analytics',
                ],
                [
                    'text' => 'Quick Stats',
                    'url'  => 'admin/dashboard/stats',
                ],
            ],
        ],
        [
            'text' => 'BLOG ARTICLES',
            'icon' => 'fas fa-fw fa-newspaper',
            'submenu' => [
                [
                    'text' => 'All Blog Posts',
                    'url'  => 'admin/blog/posts',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Create New Post',
                    'url'  => 'admin/blog/posts/create',
                    'icon' => 'fas fa-fw fa-plus-circle',
                ],
                [
                    'text' => 'Categories',
                    'url'  => 'admin/blog/categories',
                    'icon' => 'fas fa-fw fa-folder',
                ],
                [
                    'text' => 'Sub Categories',
                    'url'  => 'admin/blog/sub-categories',
                    'icon' => 'fas fa-fw fa-folder-open',
                ],
                [
                    'text' => 'Comments',
                    'url'  => 'admin/blog/comments',
                    'icon' => 'fas fa-fw fa-comments',
                ],
            ],
        ],
        [
            'text' => 'EVENTS',
            'icon' => 'fas fa-fw fa-calendar-alt',
            'submenu' => [
                ['text' => 'All Events', 'url' => 'admin/events'],
                ['text' => 'Add New Event', 'url' => 'admin/events/create'],
                ['text' => 'Upcoming Events', 'url' => 'admin/events/upcoming'],
                ['text' => 'Past Events', 'url' => 'admin/events/past'],
                ['text' => 'Categories', 'url' => 'admin/events/categories'],
                ['text' => 'Event Results', 'url' => 'admin/events/results'],
            ],
        ],
        [
            'text' => 'PARTICIPANTS',
            'icon' => 'fas fa-fw fa-users',
            'submenu' => [
                ['text' => 'All Participants', 'url' => 'admin/participants'],
                ['text' => 'Registered Users', 'url' => 'admin/participants/registered'],
                ['text' => 'Pending Approvals', 'url' => 'admin/participants/pending'],
                ['text' => 'Blacklist', 'url' => 'admin/participants/blacklist'],
                ['text' => 'Export List', 'url' => 'admin/participants/export'],
            ],
        ],
        [
            'text' => 'REGISTRATIONS',
            'icon' => 'fas fa-fw fa-clipboard-list',
            'submenu' => [
                ['text' => 'New Registrations', 'url' => 'admin/registrations/new'],
                ['text' => 'Confirmed', 'url' => 'admin/registrations/confirmed'],
                ['text' => 'Pending', 'url' => 'admin/registrations/pending'],
                ['text' => 'Cancelled', 'url' => 'admin/registrations/cancelled'],
                ['text' => 'Check-in List', 'url' => 'admin/registrations/check-in'],
            ],
        ],
        [
            'text' => 'PAYMENTS',
            'icon' => 'fas fa-fw fa-money-bill-wave',
            'submenu' => [
                ['text' => 'All Transactions', 'url' => 'admin/payments'],
                ['text' => 'Pending Payments', 'url' => 'admin/payments/pending'],
                ['text' => 'Completed Payments', 'url' => 'admin/payments/completed'],
                ['text' => 'Failed Payments', 'url' => 'admin/payments/failed'],
                ['text' => 'Refunds', 'url' => 'admin/payments/refunds'],
                [
                    'text' => 'Payment Gateway',
                    'url' => 'admin/payments/methods',
                    'icon' => 'fas fa-fw fa-credit-card',
                ],
            ],
        ],
        [
            'text' => 'SPONSORS',
            'icon' => 'fas fa-fw fa-handshake',
            'submenu' => [
                ['text' => 'All Sponsors', 'url' => 'admin/sponsors'],
                ['text' => 'Add Sponsor', 'url' => 'admin/sponsors/create'],
                ['text' => 'Sponsor Packages', 'url' => 'admin/sponsors/packages'],
                ['text' => 'Sponsor Payments', 'url' => 'admin/sponsors/payments'],
                ['text' => 'Contracts', 'url' => 'admin/sponsors/contracts'],
            ],
        ],
        [
            'text' => 'USERS',
            'icon' => 'fas fa-fw fa-user-shield',
            'submenu' => [
                ['text' => 'All Users', 'url' => 'admin/users'],
                ['text' => 'Admins', 'url' => 'admin/users/admins'],
                ['text' => 'Staff', 'url' => 'admin/users/staff'],
                ['text' => 'Participants', 'url' => 'admin/users/participants'],
                ['text' => 'Roles & Permissions', 'url' => 'admin/users/roles'],
            ],
        ],
        [
            'text' => 'CONTENT',
            'icon' => 'fas fa-fw fa-edit',
            'submenu' => [
                [
                    'text' => 'Pages',
                    'route' => 'admin.content.pages',
                    'icon' => 'fas fa-fw fa-file-alt',
                ],
                [
                    'text' => 'Special Deals',
                    'route' => 'admin.content.deals',
                    'icon' => 'fas fa-fw fa-tags',
                ],
                [
                    'text' => 'Media Library',
                    'route' => 'admin.content.media',
                    'icon' => 'fas fa-fw fa-images',
                ],
                [
                    'text' => 'Testimonials',
                    'route' => 'admin.content.testimonials',
                    'icon' => 'fas fa-fw fa-quote-left',
                ],
                [
                    'text' => 'FAQs',
                    'route' => 'admin.content.faqs',
                    'icon' => 'fas fa-fw fa-question-circle',
                ],
            ],
        ],
        [
            'text' => 'GALLERY',
            'icon' => 'fas fa-fw fa-images',
            'submenu' => [
                [
                    'text' => 'Categories',
                    'route' => 'admin.gallery.categories.index',
                    'icon' => 'fas fa-fw fa-folder-open',
                ],
                [
                    'text' => 'All Galleries',
                    'route' => 'admin.gallery.images.index',
                    'icon' => 'fas fa-fw fa-image',
                ],
            ],
        ],
        [
            'text' => 'NOTIFICATIONS',
            'icon' => 'fas fa-fw fa-bell',
            'submenu' => [
                ['text' => 'Send Email', 'url' => 'admin/notifications/email'],
                ['text' => 'Send SMS', 'url' => 'admin/notifications/sms'],
                ['text' => 'Templates', 'url' => 'admin/notifications/templates'],
                ['text' => 'Broadcast', 'url' => 'admin/notifications/broadcast'],
                ['text' => 'History', 'url' => 'admin/notifications/history'],
            ],
        ],
        [
            'text' => 'REPORTS',
            'icon' => 'fas fa-fw fa-chart-bar',
            'submenu' => [
                ['text' => 'Sales Report', 'url' => 'admin/reports/sales'],
                ['text' => 'Registration Report', 'url' => 'admin/reports/registrations'],
                ['text' => 'Payment Report', 'url' => 'admin/reports/payments'],
                ['text' => 'Participant Report', 'url' => 'admin/reports/participants'],
                ['text' => 'Event Report', 'url' => 'admin/reports/events'],
                ['text' => 'Financial Summary', 'url' => 'admin/reports/financial'],
            ],
        ],
        [
            'text' => 'SETTINGS',
            'icon' => 'fas fa-fw fa-cog',
            'submenu' => [
                ['text' => 'General Settings', 'url' => 'admin/settings/general'],
                ['text' => 'Payment Settings', 'url' => 'admin/settings/payments'],
                ['text' => 'Email Settings', 'url' => 'admin/settings/email'],
                ['text' => 'SMS Settings', 'url' => 'admin/settings/sms'],
                ['text' => 'Language Settings', 'url' => 'admin/settings/language'],
                ['text' => 'Backup', 'url' => 'admin/settings/backup'],
                ['text' => 'System Logs', 'url' => 'admin/settings/logs'],
            ],
        ],
        [
            'text' => 'SUPPORT',
            'icon' => 'fas fa-fw fa-life-ring',
            'submenu' => [
                ['text' => 'Help Center', 'url' => 'admin/support/help'],
                ['text' => 'Support Tickets', 'url' => 'admin/support/tickets'],
                ['text' => 'FAQs Management', 'url' => 'admin/support/faqs'],
                ['text' => 'Documentation', 'url' => 'admin/support/docs'],
                ['text' => 'Contact Support', 'url' => 'admin/support/contact'],
                ['text' => 'Feedback', 'url' => 'admin/support/feedback'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
