<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
	protected $table = 'product_images';
	public $timestamps = false;

	protected $fillable = ['path', 'product_id'];

	protected $hidden = ['product_id'];

	public function product(){
		return $this->belongsTo('App\Models\Product');
	}
}
