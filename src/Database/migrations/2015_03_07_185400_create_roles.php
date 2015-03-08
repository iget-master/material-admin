<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
		});

		Schema::create('permission_group_role', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('permission_group_id')->unsigned();
			$table->foreign('permission_group_id')->references('id')->on('permission_groups')->onDelete('cascade');
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permission_group_roles');
		Schema::drop('roles');
	}

}
