<?php
	namespace Router;
	use Request\Request;
	use Config;
	class Route{
		private $insertIndex = 0;
		private $noIncreaseIndex = ['name','middleware'];
		private $increaseIndex = ['get','post'];
		private $routeName = '';
		function __construct(){
			$GLOBALS['app_routes'] = [];
		}
		public function __get($key){
			if(method_exists($this, $key)){
				return $this->serveMethod($key);
			}
			return;
		}
		public function serveMethod($key){
			if(!$key){
				return;
			}
			if(in_array($key, $this->IncreaseIndex)){
				$this->insertIndex++;
			}
		}
		public function makeUrlPattern(string $string, $method,$postget){
			$exploded = explode('/', $string);
			$hash = [
				'type'=>$postget,
				'method'=>$method,
				'pattern'=>$string,
				'hash'=>[],
				'request_method'=>$postget,
			];
			foreach ($exploded as $value) {
				if(empty($value)){
					continue;
				}
				preg_match_all('/{(.*?)}/', $value, $matches, PREG_PATTERN_ORDER);
				if(isset($matches[1][0])){
					$arr = [
						'type'=>'parameter',
						'name'=>$matches[1][0],
					];
				}
				else{
					$arr = [
						'type'=>'static',
						'name'=>$value
					];
				}
				array_push($hash['hash'], $arr);
			}
			return $hash;
		}
		public function matchRoute($routeUrl){
			$exploded = explode('/', $routeUrl);
			$tmp = [];
			$staticKeysInOrder = [];
			$parameters = [];
			$passingParameters = [];
			$isTypeOrderMatching = true;
			$isStaticKeysMatching = true;
			$matchMethod = false;
			foreach ($exploded as $value) {
				if(!empty($value)){
					array_push($tmp, $value);
				}
			}
			foreach($GLOBALS['app_routes'] as $route){
				if(count($route['hash'])!==count($tmp)){
					continue;
				}
				foreach ($route['hash'] as $key => $value) {
					if($value['type']=='static'){
						$staticKeysInOrder[$key]=$value['name'];
					}
					if($value['type']=='parameter'){
						array_push($parameters, $value['name']);
						array_push($passingParameters, $tmp[$key]);
					}
				}
				foreach($staticKeysInOrder as $key=>$value){
					$bool = ($tmp[$key]== $staticKeysInOrder[$key]);
					$isTypeOrderMatching = $isTypeOrderMatching&&$bool;
				}
				if($isTypeOrderMatching && $isStaticKeysMatching){
					return [
						'method'=>$route['method'],
						'params'=>$parameters,
						'passParams'=>$passingParameters,
						'request_method'=>$route['request_method']
					];
				}
				return false;
			}
		}
		public function serveRequest($requestUri){
			$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
			$route = $this->matchRoute($requestUri);
			if(!$route){
				show_404();
				return;
			}
			$params = $route['passParams'];
			$request = new Request();
			array_push($params, $request);
			$controller = explode('@',$route['method'])[0];
			$method = explode('@',$route['method'])[1];

			if($requestMethod!==strtolower($route['request_method'])){
				show_404();
				return;
			}
			$strController = "App\Controllers\\$controller";
			$objController = new $strController();

			$response = call_user_func_array([$objController, $method], $params);

			if(gettype($response)=='array' || gettype($response)=='object'){
				echo json_encode($response);
				return;
			}
			echo $response;
		}
		public function all(){
			return $GLOBALS['app_routes'];
		}
		public function name($name){
			//Problem Here//
			return $this;
		}
		public function middleware($middleware){
			// da aqa kido rragatqmaunda//
			return $this;
		}
		private function makeRoute($routeUrl,$controller,$method){
			$pattern = $this->makeUrlPattern($routeUrl,$controller,$method);
			array_push($GLOBALS['app_routes'], $pattern);
		}
		public function get(string $routeUrl, $method){
			$this->makeRoute($routeUrl,$method,'get');
			return $this;
		}
		public function post(string $routeUrl, $method){
			$this->makeRoute($routeUrl,$method,'post');
			return $this;
		}
	}