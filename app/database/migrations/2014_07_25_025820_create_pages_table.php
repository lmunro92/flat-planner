<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function($table){
			$table->increments('id');
			$table->string('page_number');
			$table->string('slug')->nullable();
			$table->text('notes')->nullable();
			$table->string('color')->default('white');
			$table->string('image_url')->nullable();
			$table->boolean('copy')->default(false);
			$table->boolean('edit')->default(false);
			$table->boolean('art')->default(false);
			$table->boolean('design')->default(false);
			$table->boolean('approve')->default(false);
			$table->boolean('proofread')->default(false);
			$table->boolean('close')->default(false);
			$table->integer('flatplan_id')->unsigned();
			$table->integer('spread_page_id')->unsigned()->nullable();
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
		Schema::drop('pages');
	}

}
