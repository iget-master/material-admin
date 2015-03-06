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
		Model::unguard();

		$permission_group_id = PermissionGroup::create([
				'name'=>'Administrator'
			])->id;

		User::create([
				'email'=>'test@domain.com',
				'password'=>\Hash::make('12345678'),
				'name'=>'Admin',
				'surname'=>'Test',
				'permission_group_id'=>$permission_group_id,
				'dob'=>'2015-03-06',
				'language'=>'pt-BR'
			]);
	}

}
