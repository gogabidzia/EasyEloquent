# EasyEloquent

##Installation
Just write your database parameteres under constructor function In Model.php file.
'''php
  $this->con = mysqli_connect("localhost", "root", "", "test");
'''

##features
  Relationships: BelongsTo-hasMany; Database:findOrFail-where-orderby-limit; 
##Examples

'''php
  class User extends Model{
		protected $table = "users";
	}
  $users = User::all()->get();
'''
