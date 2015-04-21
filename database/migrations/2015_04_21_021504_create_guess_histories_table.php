<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuessHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guess_histories', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->integer('game_id');
            $table->string('number');
            $table->string('result');
            $table->integer('count');
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
		Schema::drop('guess_histories');
	}

}
