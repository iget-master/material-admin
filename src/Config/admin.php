<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Admin Home Settings
	|--------------------------------------------------------------------------
	*/

	'home_route' => 'materialadmin.empty',

	/*
	|--------------------------------------------------------------------------
	| Admin Menu Settings
	|--------------------------------------------------------------------------
	*/

	'menu' => [
		'options' => [
			'Home' => [
				'route' => 'materialadmin.empty',
				'icon' => 'md md-home'
			],
			'Usuários' => [
				'route' => 'user.index',
				'icon' => 'md md-people'
			],
			'Configurações' => [
				'route' => 'setting.index',
				'icon' => 'md md-settings'
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
		'en' 	=> "English",
		'it' 	=> "Italiano",
	],

	/*
	|--------------------------------------------------------------------------
	| Settings page
	|--------------------------------------------------------------------------
	*/

	'settings_groups' => [
		[
			'name' 			=> 'security',
			'translation' 	=> [
				"name" => 'materialadmin::admin.security',
				"help" => 'materialadmin::admin.security_help',
			],
			'icon' 			=> 'md-security',
			'order'			=> 0,
		]
	],

	'settings_items' => [
		'permission_groups' => [
			'translation_key' 	=> 'materialadmin::admin.permission_groups',
			'group' 			=> 'security',
			'order'				=> 0,
			'item'				=> 'materialadmin::setting.item.permission_groups',
			'edit'				=> 'materialadmin::setting.edit.permission_groups',
			'model'				=> 'IgetMaster\MaterialAdmin\Models\PermissionGroup',
		]
	]

];
