<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
	protected $table = 'users_location';

	public $timestamps = false;

	protected $fillable = [
		'country',
		'city',
		'address',
		'phone_number',
		'user_id'
	];

	protected $hidden = [
		'id', 'user_id'
	];
}
