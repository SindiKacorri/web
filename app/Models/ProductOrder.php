<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
	protected $table = 'product_orders';

	public $timestamps = false;

	protected $fillable = [
		'product_id', 'order_id', 'size_id', 'qty'
	];
	protected $hidden = [
		'id', 'product_id', 'order_id', 'size_id', 'qty'
	];
}
