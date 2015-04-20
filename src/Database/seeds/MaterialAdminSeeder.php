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
		]);User::create([
			'email'=>'asasas@domain.com',
			'password'=>\Hash::make('12345678'),
			'name'=>'Admin',
			'surname'=>'Test',
			'permission_group_id'=>$administrator->id,
			'dob'=>'11/06/1990',
			'language'=>'pt-BR'
		]);User::create([
			'email'=>'dsaasdasd@domain.com',
			'password'=>\Hash::make('12345678'),
			'name'=>'Admin',
			'surname'=>'Test',
			'permission_group_id'=>$administrator->id,
			'dob'=>'11/06/1990',
			'language'=>'pt-BR'
		]);User::create([
			'email'=>'retertert@domain.com',
			'password'=>\Hash::make('12345678'),
			'name'=>'Admin',
			'surname'=>'Test',
			'permission_group_id'=>$administrator->id,
			'dob'=>'11/06/1990',
			'language'=>'pt-BR'
		]);User::create([
			'email'=>'fdgdfgdfgh@domain.com',
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
	}
}
