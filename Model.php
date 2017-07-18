<?php 
class Model{
	protected $fillable = [];
	protected $table;
	public $query;

	function __construct(){
		$this->con = mysqli_connect("localhost", "root", "", "test");
		if(empty($this->table)){
			$query = "DESCRIBE " . $this->defaultTableName();
		}else{
			$query = "DESCRIBE " . $this->table;
		}
		$query = mysqli_query($this->con, $query);
		while($result = $query->fetch_assoc()){
			array_push($this->fillable, $result['Field']);
		}
		if(!empty($this->fillable)){
			foreach ($this->fillable as $key => $value) {
				$this->$value = null;
			}
		}
		if(empty($this->query)){
			$this->query = "SELECT * FROM " . $this->table . " ";
		}
	}

	public function __get($key){
		return $this->getAttribute($key);
	}
	public function getAttribute($key){
		if (! $key) {
        	return;
	    }
	    if(array_key_exists($key, get_object_vars($this))){
			return;	    	
	    }
	    if(method_exists($this, $key)){
	    	// $this->$key = $key;
	    	// return;
	    	return $this->$key()->get();
	    }
	}

	private function defaultTableName(){
		return strtolower(get_class(self)) . "s";
	}
	private function getCallingClass(){
		$className = get_called_class();
		return new $className();
	}
	public function all(){
		$instance = isset($this)?$this:self::getCallingClass();
		return $instance->get();
	}
	public function where($field,$operator,$value=null){
		$instance = isset($this)?$this:self::getCallingClass();
		// wrap($instance);
		if(!isset($value)){
			$value = $operator;
			$operator = "=";
		}
		$pos = strrpos($instance->query, "WHERE");
		if($pos){
			$search_op = "AND";
		}else{
			$search_op = "WHERE";
		}
		$instance->query .= $search_op." " . $field. " " . 
		$operator . " '" . $value."' ";
		return $instance;
	}
	public function save(){

	}
	public function orderBy($field, $ascdesc){
		$instance = isset($this)?$this:self::getCallingClass();
		$instance->query.= "ORDER BY " . $field . " " . $ascdesc;
		return $instance;
	}
	public function limit($limit){
		$instance = isset($this)?$this:self::getCallingClass();
		$instance->query .= "LIMIT ".$limit;
	}
	public function get(){
		$instance = isset($this)?$this:self::getCallingClass();
		$arr = [];
		$result = mysqli_query($instance->con, $instance->query);
		while($row = $result->fetch_assoc()){
			$newInstance = self::getCallingClass();
			foreach ($row as $key => $value) {
				$newInstance->$key = $value;
			}
			array_push($arr, $newInstance);
		}
		return $arr;
	}
	public function findOrFail($id){
		$instance = isset($this)?$this:self::getCallingClass();
		return $instance->where('id',$id)->get()[0];
	}
	public function belongsTo($className,$column = null){
		$ltableName = strtolower($className);
		$index = $ltableName. "_id";
		if(isset($column)){
			return $className::where($column,$index);
		}else{
			return $className::where('id', $index);
		}
	}
	public function hasMany($className){
		$ltableName = strtolower(get_called_class());
		return $className::where($ltableName."_id", $this->id);
	}
}