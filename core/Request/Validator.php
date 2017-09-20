<?php
namespace Request;

class Validator{
	public function make($array, $rules ,$messages=[]){
		$all_rules = [];
		foreach($rules as $key => $value) {
			$rule = explode('|', $value);

			foreach($rule as $rulekey=>$rulevalue){

				$ruleParam = explode(':', $rulevalue);
				$all_rules[$key][$ruleParam[0]] = isset($ruleParam[1])?$ruleParam[1]:true;
			}
		}
		wrap($all_rules);
	}
}