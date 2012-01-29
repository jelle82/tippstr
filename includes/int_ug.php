<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class IntUG extends DatabaseObject {
	
	protected static $table_name="int_ug";
	protected static $db_fields = array( 'id', 'u_id', 'g_id', 'type' );
	
	public $id;
	public $u_id;
	public $g_id;
	public $type;


}