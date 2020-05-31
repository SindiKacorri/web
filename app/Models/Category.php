<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $table = 'categories';

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
	'name' => 'required|unique:categories,name'
	];

	/**
	 * get threads attached to category
	* @return [type] [description]
	*/
	public function products(){
		return $this->hasMany('App\Models\Product', 'category_id');
	}
}
