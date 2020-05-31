<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model {
	protected $table = 'sizes';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	/**
	 * The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = ['id'];

	/*
	 * Make rules for validating article before saving to database
	 */
	public static $rules = [
		'name' => 'required|unique:sizes,name'
	];

	/**
	 * get threads attached to category
	* @return [type] [description]
	*/
	public function products(){
		return $this->hasMany('App\Models\Product','product_id');
	}
}
