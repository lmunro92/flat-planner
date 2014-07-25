<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('flatplans', function($table){
			$table->foreign('organization_id')->references('id')->on('organizations');
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::table('pages', function($table){
			$table->foreign('flatplan_id')->references('id')->on('flatplans');
			$table->foreign('spread_page_id')->references('id')->on('pages');
		});

		Schema::table('assignments', function($table){
			$table->foreign('user_id')->references('id')->on('users');
		});
		
		Schema::table('roles', function($table){
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('organization_id')->references('id')->on('organizations');
		});

		Schema::table('assignment_page', function($table){
			$table->foreign('assignment_id')->references('id')->on('assignments');
			$table->foreign('page_id')->references('id')->on('pages');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('flatplans', function($table){
			$table->dropForeign('flatplans_organization_id_foreign');
			$table->dropForeign('flatplans_user_id_foreign');
		});
		Schema::table('pages', function($table){
			$table->dropForeign('pages_flatplan_id_foreign');
			$table->dropForeign('pages_spread_page_id_foreign');
		});
		Schema::table('assignments', function($table){
			$table->dropForeign('assignments_user_id_foreign');
		});
		Schema::table('roles', function($table){
			$table->dropForeign('roles_user_id_foreign');
			$table->dropForeign('roles_organization_id_foreign');
		});
		Schema::table('assignment_page', function($table){
			$table->dropForeign('assignment_page_assignment_id_foreign');
			$table->dropForeign('assignment_page_assignment_id_foreign');
		});
	}

}
