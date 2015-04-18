<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftColumnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('draft_columns', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('draft_id')->unsigned()->nullable();
            $table->foreign('draft_id')->references('id')->on('drafts');
            $table->string('column');
            $table->text('value');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('draft_columns');
	}

}
