<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration {

	public function up()
	{
		Schema::create('grades', function(Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->string('Name', 255);
			$table->string('Notes', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('grades');
	}
}
