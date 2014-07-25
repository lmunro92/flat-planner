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
			$table->integer('number');
			$table->string('slug');
			$table->text('notes');
			$table->string('color');
			$table->string('image_url');
			$table->boolean('copy');
			$table->boolean('edit');
			$table->boolean('art');
			$table->boolean('design');
			$table->boolean('approve');
			$table->boolean('proofread');
			$table->boolean('close');
			$table->integer('flatplan_id')->unsigned();
			$table->integer('spread_page_id')->unsigned();
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
