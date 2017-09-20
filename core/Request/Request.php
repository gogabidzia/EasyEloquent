<?php
namespace Request;
class Request{
	function __construct(){
		$this->request = $_REQUEST;
	}
	public function get($key){
		return htmlspecialchars($this->request[$key]);
	}
	public function getraw($key){
		return $this->request[$key];	
	}
	public function all(){
		$tmp = [];
		foreach($this->request as $key=>$param){
			$tmp[$key] = htmlspecialchars($param);
		}
		return $tmp;
	}
}