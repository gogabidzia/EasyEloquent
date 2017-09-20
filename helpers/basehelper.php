<?php
use Router\Route;
if(!function_exists('wrap')){
	function wrap($obj){
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}
}
if(!function_exists('br')){
	function br($obj){
		echo "<br>";
	}
}
if(!function_exists('br')){
	function cond($cond){
		echo $cond?"true!":"false!";
	}
}
if(!function_exists('view')){
	function view(String $view, Array $data=[]){
		$view = implode('/',explode('.', $view));
		if(!empty($data)){
			foreach($data as $key=>$value){
				eval('$'.$key.'= $value;');
			}
		}
		include '../app/views/'.$view.'.php';
	}
}
if(!function_exists('show_404')){
	function show_404($view=false){
		header("HTTP/1.0 404 Not Found");
		if($view){
			return view($view);
		}
		return view('errors.404');
	}
}
if(!function_exists('route')){
	function route(){
		return $GLOBALS['app_routes'];
	}
}