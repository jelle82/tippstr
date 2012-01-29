<?php require_once('../includes/initialize.php'); ?>
<?php
	if( isset( $_POST['updatematches'] ) ) {
		
		$matches = Match::find_all();
		$i = 0;
		
		foreach($matches as $match) {
			
			$match->home = $_POST['home'][$match->id];
			$match->away = $_POST['away'][$match->id];
			$match->home_score = $_POST['home_score'][$match->id];
			$match->away_score = $_POST['away_score'][$match->id];
			//$match->time = '2012-' . 06 . '-' . 12 . ' ' . 14 . ':' . 30 . ':00';
			$match->time = '2012-' . $_POST['month'][$match->id] . '-' . $_POST['day'][$match->id] . ' ' . $_POST['hour'][$match->id] . ':' . $_POST['minute'][$match->id] . ':00';
			$match->save();
			$i++;
		}
		
		$msg = "Updated " . $i . " matches.";
	}
	
	$matches = Match::find_all();
	
	if( isset( $_POST['updatepoints'] ) ) {
		
		$users = User::find_all();
		$points = array( 10, 10, 15, 25 );
		
		if( $users ) {
			foreach( $users as $user ) {
				$user->calculatePoints( $matches, $points );
			}				
		}
	}
	
	$teams = Team::find_all();
?>

<h1>Update Scores - Admin</h1>

<?php if(isset($msg)) { echo '<p class="message"><em>' . $msg . '</em></p>'; } ?> 
<form method="post" action="admin.php">
	


	<?php
		$output = '<input type="submit" name="updatepoints" value="Update player points" /><br /><br />';
		$output .= '<input type="submit" name="updatematches" value="Update matches" /><br /><br />';
		foreach($matches as $match) {	
				
			//$output .= $match->id . ' ';
			//$output .= '<input type="text" size="15" name="time['.$match->id.']" value="'.$match->time.'" />';
			
			$time = $match->getTime( );
			$output .= '<input type="text" size="2" name="day['.$match->id.']" value="'.$time['day'].'" /> - ';
			$output .= '<input type="text" size="2" name="month['.$match->id.']" value="'.$time['month'].'" /> ';
			
			$output .= ' <input type="text" size="2" name="hour['.$match->id.']" value="'.$time['hour'].'" /> : ';
			$output .= '<input type="text" size="2" name="minute['.$match->id.']" value="'.$time['minute'].'" />';
			$output .= '<select name="home['.$match->id.']">';
			foreach( $teams as $team ) {
				$output .= '<option value="'. $team->id .'"';
				if($team->id == $match->home) {
					$output .= ' selected = "selected" ';	
				}
				$output .= '>'.$team->name.'</option>';
			}
			$output .= '</select>';
			$output .= ' : '; 
			$output .= '<select name="away['.$match->id.']">';
			foreach( $teams as $team ) {
				$output .= '<option value="'. $team->id .'"';
				if($team->id == $match->away) {
					$output .= ' selected = "selected" ';	
				}
				$output .= '>'.$team->name.'</option>';
			}
			$output .= '</select>';
			$output .= '<input type="text" size="2" name="home_score['.$match->id.']" value="'.$match->home_score.'" /> : <input type="text" size="2" name="away_score['.$match->id.']" value="'.$match->away_score.'" />';
			$output .= '<br /><br />';
		}
		
		$output .= '<input type="submit" name="updatematches" value="Update matches" /><br /><br />';
		$output .= '<input type="submit" name="updatepoints" value="Update player points" /><br /><br />';
		echo $output;
	?>

</form>