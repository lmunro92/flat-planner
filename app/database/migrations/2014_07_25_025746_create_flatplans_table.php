<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlatplansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flatplans', function($table) {
			$table->increments('id');
			$table->string('issue_name');
			$table->integer('pub_date');
			$table->integer('organization_id')->unsigned();
			$table->integer('user_id')->unsigned();
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
		Schema::drop('flatplans');
	}

}
