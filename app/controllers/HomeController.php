<?php
	namespace App\Controllers;

	use Controller\Controller;
	use Request\Request;
	use App\Models\User;
	use App\Models\Todo;
	use Request\Validator;
	use Router\Route;
	class HomeController extends Controller{
		function __construct(){

		}
		public function index(Request $request){
			wrap($GLOBALS['app_routes']);
		}
		public function login($first,$second,Request $request){

		}
		public function abgd($first,$second, Requet $request){

		}
	}
?>