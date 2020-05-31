<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
	use Notifiable, LaratrustUserTrait;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'password', 'remember_token',
	];

	public function location(){
		return $this->hasOne('App\Models\UserLocation');
	}

	 /**
     * Get the user's name.
     *
     * @param  string  $value
     * @return string
     */
	public function getNameAttribute($value){
		$name = explode('-', $value);
		if(count($name) == 3){
			return $name[0] . " " . $name[1];
		}
		return $value;
	}
}
