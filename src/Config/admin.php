<?php

return [
    /*
	|--------------------------------------------------------------------------
	| Admin Home Settings
	|--------------------------------------------------------------------------
	*/

    'home_route' => 'materialadmin.empty',
    'brand_image_url' => 'https://placehold.it/120x40',

    /*
	|--------------------------------------------------------------------------
	| Admin Menu Settings
	|
	|  Menu
	|  |
	|  |---> Group
	|        |
	|        |---> Item
	|        |---> Item
	|        |---> Item
	|        |---> Item
	|--------------------------------------------------------------------------
	*/

    'menu' => [
        'basic_group' => [
            'home' => [
                'route' => 'materialadmin.empty',
                'icon' => 'zmdi zmdi-home'
            ],
            'settings' => [
                'route' => 'setting.index',
                'icon' => 'zmdi zmdi-settings'
            ]
        ],
    ],

    /*
	|--------------------------------------------------------------------------
	| Permission roles
	|--------------------------------------------------------------------------
	|
	| Define here all permission roles that may be used by your application.
	| 
	| * Permission middleware will automatically find for roles named with
	|   route name.
	|
	*/

    'roles' => [
        'user.index',
        'user.edit',
        'user.store',
        'user.update',
        'user.create',
        'user.destroy',
        'user.multiple_destroy'
    ],

    'default_role' => null,

    /*
	|--------------------------------------------------------------------------
	| Allowed system languages
	|--------------------------------------------------------------------------
	*/

    'languages' => [
        'pt_BR' => "Português Brasileiro",
        'en'    => "English",
        'it'    => "Italiano",
    ],

    /*
	|--------------------------------------------------------------------------
	| Settings page
	|--------------------------------------------------------------------------
	*/

    'settings_groups' => [
        [
            'name'          => 'security',
            'translation'   => [
                "name" => 'materialadmin::admin.security',
                "help" => 'materialadmin::admin.security_help',
            ],
            'icon'          => 'md-security',
            'order'             => 0,
        ]
    ],

    'settings_items' => [
        'permission_groups' => [
            'translation_key'   => 'materialadmin::admin.permission_groups',
            'group'             => 'security',
            'order'                 => 0,
            'item'              => 'materialadmin::setting.item.permission_groups',
            'edit'              => 'materialadmin::setting.edit.permission_groups',
            'model'                 => 'Iget\Base\Models\PermissionGroup',
            'relationships'     => [
                [
                    "name" => "roles",
                    "model" => "Iget\Base\Models\Role",
                    "relation" => "many-to-many",
                ]
            ]
        ]
    ],

    /*
	|--------------------------------------------------------------------------
	| Search engine
	|--------------------------------------------------------------------------
	*/

    'search' => [
        'cache_lifetime' => 43200,
        'aliases' => [
            'user' => 'Iget\Base\Models\User'
        ],
        'relations' => [
            'user' => [
                'permission_group'
            ],
        ],
        'scopes' => []
    ],

];
