<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSchema extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_group_rules', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('permission_group_id')->unsigned();
			$table->foreign('permission_group_id')->references('id')->on('permission_groups');
			$table->string('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permission_group_tables');
	}

}
