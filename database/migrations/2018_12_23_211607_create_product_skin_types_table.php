<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSkinTypesTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('product_skin_types', function(Blueprint $table){
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('skin_type_id')->unsigned();

			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->foreign('skin_type_id')->references('id')->on('skin_types')->onDelete('cascade');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('product_skin_types');
	}
}
