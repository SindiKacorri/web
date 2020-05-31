<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';


	protected $fillable = [
		'status_id',
		'user_id',
		'message'
	];

	protected $hidden = [
		'id', 'status_id', 'user_id'
	];
	/*
	 * Make rules for validating order checkout
	 * before saving to database
	 *
	 */
	public static $rules = [
		'first_name' => 'required',
		'last_name' => 'required',
		'country' => 'required',
		'city' => 'required',
		'address' => 'required',
		'email' => 'required',
		'phone_number' => 'required'
	];

	/**
	 * return order products
	 * see relationships, do not forget
	 *
	 * @return void
	 */
	public function products(){
		return $this->belongsToMany('App\Models\Product', 'product_orders')->withPivot('size_id', 'qty');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}

	public function size(){
		return $this->belongsTo('App\Models\Size');
	}

	public function color(){
		return $this->belongsTo('App\Models\Color');
	}
}
