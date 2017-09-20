<style>
	pre{
		background: #ededed;
		border: 1px solid #ccc;
		padding: 15px;
		border-radius: 3px;
	}
</style>

<?php
	// require_once '../routes/routes.php';
	// require_once '../config.php';
	// require_once '../autoload.php';
	// require_once '../helpers/basehelper.php';
	// require_once '../Model.php';
	require_once '../config/autoload.php';


	$qs = "?".$_SERVER['QUERY_STRING'];
	$baseStr = Config::get('base_url').Config::get('base_folder');
	$requestUri = substr($_SERVER['REQUEST_URI'],strlen($baseStr));
	$requestUri = str_replace($qs,'',$requestUri);
	$route->serveRequest($requestUri);
?>
