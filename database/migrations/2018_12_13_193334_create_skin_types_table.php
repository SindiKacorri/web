<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkinTypesTable extends Migration
{
	 /**
	  * Run the migrations.
	  *
	  * @return void
	  */
	 public function up()
	 {
		Schema::create('skin_types', function(Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->string('code');
		});
	 }

	 /**
	  * Reverse the migrations.
	  *
	  * @return void
	  */
	 public function down()
	 {
		Schema::dropIfExists('skin_types');
	 }
}
