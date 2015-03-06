<?php namespace IgetMaster\MaterialAdmin;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		PermissionGroup::create([
				'name'=>'Administrator'
			]);

		User::create([
				'email'=>'test@domain.com'
				'password'=>\Hash::make('12345678'),
				'name'=>'Admin',
				'surname'=>'Test',
				'permission_group_id'=>1,
				'dob'=>'2015-03-06',
				'language'=>'pt-BR'
			]);
	}

}
