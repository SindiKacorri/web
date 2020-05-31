<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [['id' => 1, 'title' => 'Cash','description' => 'pagese cash', 'is_active' => true],
        ['id' => 2, 'title' => 'PayPal','description' => 'pagese Paypal', 'is_active' => true]];

		DB::table('payment_methods')->insert($values);
    }
}
