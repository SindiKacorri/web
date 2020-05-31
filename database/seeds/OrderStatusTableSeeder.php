<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusTableSeeder extends Seeder
{
	/**
	* Run the database seeds.
	*
	* @return void
	*/
	public function run()
	{
		// statusi 1 = ne pritje
		$values = [['id' => 1, 'name' => 'Ne proces'],['id' =>2, 'name' => 'Perfunduar'], ['id' => 3,'name'=> 'Anuluar']];

		DB::table('order_status')->insert($values);
	}
}
