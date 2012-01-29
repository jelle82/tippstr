<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Group extends DatabaseObject {
	
	protected static $table_name="groups";
	protected static $db_fields = array( 'id', 'creator_id', 'name' );
	
	public $id;
	public $creator_id;
	public $name;

	public function getMembers( $inGroup = true ) {
		global $database;
		$groupId = $this->id;
		
		$intUgs = IntUG::find_by_sql("SELECT * FROM int_ug WHERE g_id={$groupId} AND type='member'");
		//print_r($intUgs);
	
		$users = array( );
		$members = array( );
		
		foreach( $intUgs as $intUg ) {
			if( $intUg->u_id > 0 ) {
				$members[] = User::find_by_id( $intUg->u_id );
			}
		}
		
		if( ! $inGroup ) {
		
			if( empty( $intUgs ) ) {
				//no users for this group
				return User::find_all();
				
			} else {
				
				$users = User::find_all();
				
				foreach( $users as $user ) {
					if ( ! in_array($user, $members) ) {
							$nonmembers[] = $user;
					}
				}
				
				return $nonmembers;
			}
		}
		
		//we need the group members
		return $members;
	}
}