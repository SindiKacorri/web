<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('products', function(Blueprint $table){
			$table->increments('id');
			$table->string('uuid');
			$table->string('title');
			$table->text('description')->nullable();
			$table->boolean('is_featured')->default(false);
			$table->integer('view_count')->default(0);
			$table->string('product_code', 25)->nullable();
			$table->boolean('state')->default(false); // don't know why it will be used
			$table->integer('category_id')->unsigned();
			//$table->integer('company_id')->unsigned();

			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			//$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('products');
	}
}
