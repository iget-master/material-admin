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
	| Permission rules
	|--------------------------------------------------------------------------
	|
	| Define here all permission rules that may be used by your application.
	| 
	| * Permission middleware will automatically find for rules named with
	|   route name.
	|
	*/

	'rules' => [
		'user.index',
		'user.edit',
		'user.store',
		'user.update',
		'user.create',
		'user.destroy',
		'user.multiple_destroy'
	],

	'default_rule' => null,

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

];
