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
		Schema::create('permission_groups', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::table('users', function(Blueprint $table)
		{
			$table->string('surname');
			$table->integer('permission_group_id')->unsigned();
			$table->foreign('permission_group_id')->references('id')->on('permission_groups');
			$table->date('dob')->nullable();
			$table->string('language', 5);
			$table->string('color');
			$table->string('img_url')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('users_permission_group_id_foreign');
			$table->dropColumn('surname');
			$table->dropColumn('permission_group_id');
			$table->dropColumn('dob');
			$table->dropColumn('language');
			$table->dropColumn('color');
			$table->dropColumn('img_url');
		});

		Schema::drop('permission_groups');
	}

}
