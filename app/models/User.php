<?php 
namespace App\Models;
use Model;


class User extends Model{
	protected $table = 	'users';
	public function todos(){
		return $this->hasMany('App\Models\Todo');
	}
}
