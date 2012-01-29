<?php require_once('../includes/initialize.php'); ?>
<?php
	
		$matches = Match::find_all();
		$users = User::find_all();
		$points = array( 12, 32, 32, 42 );
		
		if( $users ) {
			foreach( $users as $user ) {
				$user->calculatePoints( $matches, $points );
			}				
		}
	
?>
<table summary="" >
<tr><td>Home</td><td>Away</td><td>prognose</td><td>&nbsp;</td><td>real</td><td>&nbsp;</td><td>points</td></tr>
<?php

		
		$user = User::find_by_id( 2 );
		
		foreach( $matches as $match ) {
			$output = "<tr>";
			$homeId = 'home' . $match->id;
			$awayId = 'away' . $match->id;
			$pointsId = 'points' . $match->id;
			
			$output .= "<td>".$match->home."</td><td>".$match->away."</td><td>".$user->$homeId."</td><td>".$user->$awayId."</td><td>".$match->home_score."</td><td>".$match->away_score."</td><td>".$user->$pointsId."</td>";
			
			$output .= "</tr>";
			
			echo $match->time . '<br/>';
			
			echo $output;
			 
		}
		
		

?>
</table>

