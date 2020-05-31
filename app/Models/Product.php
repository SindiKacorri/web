<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
	use SoftDeletes;
	protected $table = 'products';

	protected $dates = ['deleted_at'];
	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['uuid', 'title', 'description', 'category_id', 'state', 'is_featured', 'view_count'];

	/**
	 * The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = ['id', 'uuid', 'is_featured', 'state', 'category_id', 'created_at', 'updated_at', 'deleted_at'];

	/**
	 * Make rules for validating article before saving to database
	 */
	public static $rules = [
		'title' => 'required',
		'cat_id' => 'required|integer',
		'sizes' => 'required',
		'images' => 'required'
	];

	public function skinTypes(){
		return $this->belongsToMany('App\Models\SkinType', 'product_skin_types');
	}

	public function sizes(){
		return $this->belongsToMany('App\Models\Size', 'product_sizes', 'product_id', 'size_id')->withPivot('price', 'has_discount', 'second_price');
	}

	public function images(){
		return $this->hasMany('App\Models\ProductImage');
	}

	public function category(){
		return $this->belongsTo('App\Models\Category');
	}


	public function orders(){
		return $this->belongsToMany('App\Models\Order', 'product_orders');
	}

	public function getPricesList() {
		$priceList = [];

		foreach($this->sizes as $size) {
			array_push($priceList, $size->pivot->price);
		}
		return implode(',', $priceList);
	}

	public function getPriceFromSize(int $sizeId) {
		$size = $this->sizes()->where('size_id', $sizeId)->first();

		if($size->pivot->has_discount) {
			return $size->pivot->second_price;
		}

		return $size->pivot->price;
	}

	public function getSizeName(int $sizeId) {
		return $this->sizes()->where('size_id', $sizeId)->first()->name;
	}

	public function getSkinTypes() {
		$skinTypes = [];
		$skinTypesRelation = $this->skinTypes;
		
		foreach($skinTypesRelation as $skinType) {
			array_push($skinTypes, $skinType->name);
		}
		return implode(', ', $skinTypes);
	}
}
