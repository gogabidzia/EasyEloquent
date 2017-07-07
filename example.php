<?php 
include 'Model.php';
	class User extends Model{
		protected $table = "users";
	}
	function wrap($obj){
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}
	$users = User::all()->get();
	wrap($users);
?>