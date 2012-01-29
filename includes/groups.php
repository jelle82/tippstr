<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {
	
	protected static $table_name="users";
	protected static $db_fields = array('id', 'username', 'email', 'password', 'name',
		'home1', 'away1', 'points1',
		'home2', 'away2', 'points2',
		'home3', 'away3', 'points3',
		'home4','away4','points4',
		'home5','away5','points5',
		'home6','away6','points6',
		'home7','away7','points7',
		'home8','away8','points8',
		'home9','away9','points9',
		'home10','away10','points10',
		'home11','away11','points11',
		'home12','away12','points12',
		'home13','away13','points13',
		'home14','away14','points14',
		'home15','away15','points15', 
		'home16','away16','points16',
		'home17','away17','points17',
		'home18','away18','points18',
		'home19','away19','points19',
		'home20','away20','points20',
		'home21','away21','points21',
		'home22','away22','points22',
		'home23','away23','points23',
		'home24','away24','points24',
		'home25','away25','points25',
		'home26','away26','points26',
	);
	
	public $id;
	public $username;
	public $email;
	public $password;
	public $name;
	public $home1;
	public $away1;
	public $points1;
	public $home2;
	public $away2;
	public $points2;
	public $home3;
	public $away3;
	public $points3;
	public $home4;
	public $away4;
	public $points4;
	public $away5;
	public $away6;
	public $away7;
	public $away8;
	public $away9;
	public $away10;
	public $away11;
	public $away12;
	public $away13;
	public $away14;
	public $away15;
	public $away16;
	public $away17;
	public $away18;
	public $away19;
	public $away20;
	public $away21;
	public $away22;
	public $away23;
	public $away24;
	public $away25;
	public $away26;
	public $home5;
	public $home6;
	public $home7;
	public $home8;
	public $home9;
	public $home10;
	public $home11;
	public $home12;
	public $home13;
	public $home14;
	public $home15;
	public $home16;
	public $home17;
	public $home18;
	public $home19;
	public $home20;
	public $home21;
	public $home22;
	public $home23;
	public $home24;
	public $home25;
	public $home26;
	public $points5;
	public $points6;
	public $points7;
	public $points8;
	public $points9;
	public $points10;
	public $points11;
	public $points12;
	public $points13;
	public $points14;
	public $points15;
	public $points16;
	public $points17;
	public $points18;
	public $points19;
	public $points20;
	public $points21;
	public $points22;
	public $points23;
	public $points24;
	public $points25;
	public $points26;

	
	public function calculatePoints( $matches = array(), $points = array( 11, 11, 11, 11 ) ) {
		global $database;
		
		//10 points for correct home_score; 10 points for correct away_score; 11 points for correct difference
		if( ! empty( $matches ) &&  count( $points ) == 4 && is_array( $matches ) ) {
			
				$correctScoreOneSide = $points[0];
				$correctScoreBothSides = $points[1]; //extra points for guessing correctly
				$correctDifference = $points[2];
				$correctWinnerOrTie = $points[3];
			
			foreach( $matches as $match ) {
				
				$now = time();
				$matchTime = strtotime($match->time);
				$matchPoints = 0;
				
				if( $matchTime < $now ) {
				
					$homeId = 'home' . $match->id;
					$awayId = 'away' . $match->id;
					
					if( $this->$homeId == $match->home_score )
						$matchPoints += $correctScoreOneSide;
						
					if( $this->$awayId == $match->away_score )
						$matchPoints += $correctScoreOneSide;
						
					if( ( $this->$homeId == $match->home_score ) && ( $this->$awayId == $match->away_score ) )
						$matchPoints += $correctScoreBothSides;
				
					if( ($this->$homeId - $this->$awayId) == ($match->home_score - $match->away_score) )
						$matchPoints += $correctDifference;
						
					if( ( ( $this->$homeId > $this->$awayId ) && ( $match->home_score > $match->away_score ) ) || ( ( $this->$homeId < $this->$awayId ) && ( $match->home_score < $match->away_score ) ) || ( ( $this->$homeId == $this->$awayId ) && ( $match->home_score == $match->away_score ) ) )
						$matchPoints += $correctWinnerOrTie;
						
				}
				
				$pointsId = 'points' . $match->id;
				$this->$pointsId = $matchPoints;
				
				$this->save();
			
			}
			
				
		} else {
			// no matches or points-array not long enough
			return false;	
		}
		
		return true;
		
	}
  
	public function getTotalPoints( $matches = array() ) {
		
		if ( empty( $matches ) ) {
			$matches = Match::find_all();	
		}
		
		$points = 0;
		
		if( is_array( $matches ) ) {
			foreach($matches as $match) {	
				$pointsId = 'points' . $match->id;
				$points += $this->$pointsId;
			}
		}
		
		return $points; 
	}
	
	public function getGroups( ) {
		global $database;
		$intUgs = IntUG::find_by_sql("SELECT * FROM int_ug WHERE u_id={$this->id} AND type='member'");
		$groups = array( );
		
		foreach( $intUgs as $intUg ) {
			$groups[] = Group::find_by_id( $intUg->g_id );
		}
		
		return $groups;
	}
	
	public function isOfType ( $type = "", $g_id = 0 ) {
		global $database;
		$result_array = IntUG::find_by_sql("SELECT * FROM int_ug WHERE u_id={$this->id} AND g_id={$g_id} AND type='{$type}'");
		return !empty($result_array) ? true : false;
	}
	
	public function isGroupAdmin ( $g_id = 0 ) {
		global $database;

		$result_array = IntUG::find_by_sql("SELECT * FROM int_ug WHERE u_id={$this->id} AND g_id={$g_id} AND type='admin'");
		return !empty($result_array) ? true : false;
	}
	
	public function isMember ( $g_id = 0 ) {
		global $database;
		
		$result_array = IntUG::find_by_sql("SELECT * FROM int_ug WHERE u_id={$this->id} AND g_id={$g_id} AND type='member'");
		return !empty($result_array) ? true : false;
	}
	
	public function isLoggedInUser() {
		global $session;
		
		if ( $session->is_logged_in() && $this->id == $session->user_id ) {
    		return $this->id;
    	} else {
    		return false;	
    	}
  }
	
	public function getFormPredictions ( $matches = array() ) {
		
		if ( empty( $matches ) )
			$matches = Match::find_all();
			
		if ( is_array( $matches ) ) {	
			if( $this->isLoggedInUser() ) {
				
				$output = '<form method="post" action="user.php?u='. $this->id .'">';
				$output .= '<input type="submit" name="update" value="Save predictions" /><br /><br />';
				
				foreach($matches as $match) {	
					
					$homeId = 'home' . $match->id;
					$awayId = 'away' . $match->id;
					$pointsId = 'points' . $match->id;	
					
					$now = time();
					$matchTime = strtotime($match->time);
					
					$output .= $match->time . ' ';
					$output .= '<label size="25" for="home_score['.$match->id.']" />'.$match->home.'</label> : <label size="25" for="away_score['.$match->id.']" />'.$match->away.'</label>';
					
					if ( $matchTime > $now ) {
						$output .= '<input type="text" size="2" name="home_score['.$match->id.']" value="'.$this->$homeId.'" /> : <input type="text" size="2" name="away_score['.$match->id.']" value="'.$this->$awayId.'" />';
						$output .= '( - ) ';	
						$output .= '0';
					} else {
						$output .= ' ' . $this->$homeId.' : '.$this->$awayId . ' ';
						$output .= '(' . $match->home_score.' : '.$match->away_score.') ';
						$output .= $this->$pointsId;
					}
					
					$output .= '<br /><br />';
				}
				
				$output .= '<input type="submit" name="update" value="Save predictions" /><br /><br />';
				$output .= '</form>';
				return $output;
				
			} else {
				
				$output = '<h3>Predictions</h3>';
			
				//userpage is not from logged in user
				foreach($matches as $match) {	
					
					$homeId = 'home' . $match->id;
					$awayId = 'away' . $match->id;
					$pointsId = 'points' . $match->id;	
					
					$now = time();
					$matchTime = strtotime($match->time);
					
					$output .= '<p>'.$match->time . ' ';
					$output .= $match->home.' : '.$match->away . ' ';
					$output .= $this->$homeId.' : '.$this->$awayId . ' ';
					
					if ( $matchTime > $now ) {
						//match score not known yet
						$output .= '( - ) ';	
						$output .= '0';
					} else {
						//match score is known
						$output .= '(' . $match->home_score.' : '.$match->away_score.') ';
						$output .= $this->$pointsId.'</p>';
					}
				}
				return $output;
			}
			
		} else {
			//matches is not an array
			return false;	
		}
	}
	
	
	public static function authenticate($username="", $password="") {
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

    $sql  = "SELECT * FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}


}