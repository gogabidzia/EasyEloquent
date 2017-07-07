# EasyEloquent

## Installation
Just write your database parameteres under constructor function In Model.php file.
```php
  $this->con = mysqli_connect("localhost", "root", "", "test");
```

## features
  Relationships: BelongsTo-hasMany; Database:findOrFail-where-orderby-limit; 
## Examples

```php
  class User extends Model{
	protected $table = "users";
	public function todos(){
		return $this->hasMany("Todo");
	}
  }
  class Todo extends Model{
	protected $table = "todo";

	public function user(){
		return $this->belongsTo('User');
	}
  }
  $user = User::findOrFail($id);
  print_r($user->todos);
  
```
