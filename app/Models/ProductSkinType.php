<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSkinType extends Model
{
	protected $table = 'product_skin_types';
	public $timestamps = false;

	protected $hidden = ['id', 'product_id', 'skin_type_id'];

	public function products(){
		return $this->belongsToMany('App\Models\Product');
	}
}
