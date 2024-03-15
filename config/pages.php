<?php
return [
    [
        'permission' => 'dashboard',
        'name' => 'pages.dashboard.title_singular',
        'text' => 'global.dashboard',
        'href' => 'dashboard',
        'children' => []
    ],
    [
        'permission' => 'permission_show',
        'name' => 'pages.permissions.title',
        'text' => 'global.all',
        'href' => 'permissions.index',
        'children' => []
    ],
    [
        'permission' => 'role_create',
        'name' => 'pages.roles.title',
        'text' => 'global.all',
        'href' => 'roles.index',
        'children' => [
            [
                'permission' => 'role_create',
                'text' => 'global.create',
                'href' => 'roles.create',
                'sidebar' => true
            ],
            [
                'permission' => 'role_edit',
                'text' => 'global.edit',
                'href' => 'roles.edit',
                'sidebar' => false
            ]
        ]
    ],
    [
        'permission' => 'user_create',
        'name' => 'pages.users.title',
        'text' => 'global.all',
        'href' => 'users.index',
        'children' => [
            [
                'permission' => 'user_create',
                'text' => 'global.create',
                'href' => 'users.create',
                'sidebar' => true
            ],
            [
                'permission' => 'users_edit',
                'text' => 'global.edit',
                'href' => 'users.edit',
                'sidebar' => false
            ],
            [
                'permission' => 'users_show',
                'text' => 'global.show',
                'href' => 'users.show',
                'sidebar' => false
            ]
        ]
    ],
    [
        'permission' => 'sd_event_show',
        'name' => 'speed_date::speed_date.events',
        'text' => 'global.all',
        'href' => 'speed_date.events.index',
        'children' => [
            [
                'permission' => 'sd_event_create',
                'text' => 'global.create',
                'href' => 'speed_date.events.create',
                'sidebar' => true
            ],
            [
                'permission' => 'sd_event_edit',
                'text' => 'global.edit',
                'href' => 'speed_date.events.edit',
                'sidebar' => false
            ],
            [
                'permission' => 'sd_event_show',
                'text' => 'global.show',
                'href' => 'speed_date.events.show',
                'sidebar' => false
            ]
        ]
    ],
    [
        'permission' => 'sd_vote_show',
        'name' => 'speed_date::speed_date.ratings',
        'text' => 'global.all',
        'href' => 'speed_date.ratings.index',
        'children' => [
            [
                'permission' => 'sd_vote_create',
                'text' => 'global.create',
                'href' => 'speed_date.ratings.create',
                'sidebar' => true
            ],
            [
                'permission' => 'sd_vote_show',
                'text' => 'global.show',
                'href' => 'speed_date.ratings.show',
                'sidebar' => false
            ]
        ]
    ],
    [
        'permission' => 'settings_show',
        'name' => 'pages.settings.title',
        'text' => 'global.all',
        'href' => 'settings.index',
        'children' => [
            [
                'permission' => 'settings_show',
                'text' => 'global.general',
                'href' => 'settings.generalInfo',
                'sidebar' => true
            ],
            [
                'permission' => 'settings_show',
                'text' => 'global.database',
                'href' => 'settings.databaseInfo',
                'sidebar' => true
            ],
            [
                'permission' => 'settings_show',
                'text' => 'global.debug',
                'href' => 'settings.debugInfo',
                'sidebar' => true
            ],
            [
                'permission' => 'settings_show',
                'text' => 'global.log',
                'href' => 'settings.logInfo',
                'sidebar' => true
            ],
            [
                'permission' => 'settings_show',
                'text' => 'global.mail',
                'href' => 'settings.mailInfo',
                'sidebar' => true
            ]
        ]
    ]
];
