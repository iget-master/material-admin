<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMessages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function($table){
            $table->increments('id');
            $table->integer('to_user_id')->unsigned();
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('from_user_id')->unsigned()->nullable();
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('subject', 255);
            $table->text('message');
            $table->tinyInteger('read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }

}
