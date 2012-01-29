<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Team extends DatabaseObject {
	
	protected static $table_name="teams";
	protected static $db_fields = array( 'id', 'name' );
	
	public $id;
	public $name;


}