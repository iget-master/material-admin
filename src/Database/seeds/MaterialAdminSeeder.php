<?php

use IgetMaster\MaterialAdmin\Models\PermissionGroup;
use IgetMaster\MaterialAdmin\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MaterialAdminSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{	
		/* For security reasons, ask for user confirmation before do this seeding */
		echo "Do you want to truncate your tables before seed? (Type \"yes\" to confirm): ";
		$stdin = fopen('php://stdin', 'r');
		if (strtolower($stdin) == 'yes') {
			DB::statement("SET foreign_key_checks=0");
			DB::table('users')->truncate();
			DB::table('roles')->truncate();
			DB::table('permission_groups')->truncate();
			DB::table('permission_group_roles')->truncate();
			DB::statement("SET foreign_key_checks=1");
		}

		$administrator = PermissionGroup::create([
				'name'=>'Administrator'
			]);

		User::create([
			'email'=>'test@domain.com',
			'password'=>\Hash::make('12345678'),
			'name'=>'Admin',
			'surname'=>'Test',
			'permission_group_id'=>$administrator->id,
			'dob'=>'2015-03-06',
			'language'=>'pt-BR'
		]);

		/* Create all rules and assign all to administrator rules */
		foreach(\Config::get('admin.roles') as $role_name) {
			$role = Roles::create([ 'name'=>$role_name ]);
			$administrator->roles()->attach($role->id);
		}
	}

}
