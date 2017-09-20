<?php 
namespace Controller;
use Request\Request;
use Request\Validator;
class Controller{
	public function validate(Request $request, Array $params, Array $messages=[]){
		Validator::make($request->all(),$params,$messages);
	}
}