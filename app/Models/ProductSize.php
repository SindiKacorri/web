<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
	protected $table = 'product_sizes';
	public $timestamps = false;

	protected $hidden = ['id', 'product_id', 'size_id', 'price', 'has_discount', 'second_price'];

	public function products(){
		return $this->belongsToMany('App\Models\Product');
	}
}
