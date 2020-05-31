<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model {
	protected $table = 'subcategories';

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
		* Make rules for validating subcategory before saving to database
		*/
	public static $rules = [
		'name' => 'required|unique:subcategories,name'
	];
}
