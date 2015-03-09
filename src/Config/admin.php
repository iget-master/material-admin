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
			'name' 				=> 'security',
			'translation_key' 	=> 'materialadmin::admin.security',
			'icon' 				=> 'md-security',
			'order'				=> 0,
		]
	],

	'settings_items' => [
		[
			'name'				=> 'permission_groups',
			'translation_key' 	=> 'materialadmin::admin.permission_groups',
			'group' 			=> 'security',
			'order'				=> 0,
			'item'				=> 'materialadmin::settings.item.permission_groups',
			'edit'				=> 'materialadmin::settings.edit.permission_groups',
		]
	]

];
