<?php 
namespace App\Models;
use Model;
class Todo extends Model{
	protected $table = 'todo';
	public function user(){
		return $this->belongsTo('App\Models\Todo');
	}
}
