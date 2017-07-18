<?php 
include 'Model.php';
	class User extends Model{
		function __construct(){
			parent::__construct();
		}
		protected $table = "users";

		public function todos(){
			return $this->hasMany("Todo");
		}
	}
	class Todo extends Model{
		protected $table = "todo";

		public function user(){
			return $this->belongsTo('User');
		}
	}
	function wrap($obj){
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}
	$user = User::findOrFail(1);
	wrap($user->todos()->orderBy('title','asc')->get());
?>