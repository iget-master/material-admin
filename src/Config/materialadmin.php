<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Admin Home Settings
	|--------------------------------------------------------------------------
	*/

	'home_route' => 'admin.empty',

	/*
	|--------------------------------------------------------------------------
	| Admin Menu Settings
	|--------------------------------------------------------------------------
	*/

	'menu_options' => array(
		'Home' => array(
			'route' => 'materialadmin.empty',
			'icon' => 'md md-home'
		),
		'Usuários' => array(
			'route' => 'user.index',
			'icon' => 'md md-people'
		)
	),

	'permissions' => array(
		/*
		|--------------------------------------------------------------------------
		| Routes Permission Level
		|--------------------------------------------------------------------------
		*/

		'routes' => array(
			'materialadmin.empty' => 1,
			'user.index' => 2,
			'user.edit' => 2,
			'user.store' => 2,
			'user.update' => 2,
			'user.create' => 2,
			'user.destroy' => 2,
			'user.multiple_destroy' => 2,

		),

		'default' => 1
	),

);
