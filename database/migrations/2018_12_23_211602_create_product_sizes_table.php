<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSizesTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('product_sizes', function(Blueprint $table){
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('size_id')->unsigned();
			$table->decimal('price', 8, 2)->nullable();
			$table->boolean('has_discount')->default(false);// if has discount
			$table->decimal('second_price', 8, 2)->nullable();

			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('product_sizes');
	}
}
