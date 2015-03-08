<?php

use IgetMaster\MaterialAdmin\Models\PermissionGroup;
use IgetMaster\MaterialAdmin\Models\User;
use IgetMaster\MaterialAdmin\Models\Role;
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
		$stdin = trim(fgets(STDIN));
		if (strtolower($stdin) == 'yes') {
			DB::statement("SET foreign_key_checks=0");
			DB::table('users')->truncate();
			DB::table('roles')->truncate();
			DB::table('permission_groups')->truncate();
			DB::table('permission_group_role')->truncate();
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
			'dob'=>'11/06/1990',
			'language'=>'pt-BR'
		]);

		/* Create all rules and assign all to administrator rules */
		foreach(\Config::get('admin.roles') as $role_name) {
			$role = Role::create([ 'name'=>$role_name ]);
			$administrator->roles()->attach($role->id);
		}

		foreach(User::with('permission_group.roles')->first()->permission_group->roles as $role_name) {
			echo "$role_name->name\n";
		}
	}
}
