<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Match extends DatabaseObject {
	
	protected static $table_name="matches";
	protected static $db_fields = array('id', 'home', 'away', 'home_score', 'away_score', 'time');
	
	public $id;
	public $home;
	public $away;
	public $home_score;
	public $away_score;
	public $time;
	
	public function getTime( ) {
		global $database;
		
		$time['year'] = substr($this->time, 0, 4);
		$time['month'] = substr($this->time, 5, 2);
		$time['day'] = substr($this->time, 8, 2);
		$time['hour'] = substr($this->time, 11, 2);
		$time['minute'] = substr($this->time, 14, 2);
		$time['second'] = substr($this->time, 17, 2);
		
		return $time;
	}
	
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM " .self::$table_name. " ORDER BY time ASC");
  }

}