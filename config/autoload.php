<?php
class Config{
	public static function get($key){
		return self::getConfig()[$key];
	}
	public static function getConfig(){
		return (include 'website.php');
	}
	public function getFiles(){
		return (include 'files.php');
	}
}
foreach(Config::getFiles()['classes'] as $key=>$class){
	require_once $class;
}
foreach (Config::getFiles()['helpers'] as $key => $value) {
	require_once $value;
}
foreach (Config::getFiles()['constants'] as $key => $value) {
	require_once $value;
}
$controllers = array_diff(scandir('../app/controllers'), array('.', '..'));
$models = array_diff(scandir('../app/models'), array('.', '..'));

foreach($controllers as $controller){
	require_once '../app/controllers/'.$controller;
}
foreach($models as $model){
	require_once '../app/models/'.$model;
}

use Router\Route as Route;
$route = New Route();
include '../routes/routes.php';
