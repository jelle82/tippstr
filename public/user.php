<?php require_once('../includes/initialize.php'); ?>
<?php
	
	if( isset( $_GET['u'] ) ) {
		$user = User::find_by_id( $_GET['u'] );
		if( ! $user ) {
			$session->message( 'No user found.' );
			redirect_to ( 'login.php' );	
		}
		
	} else {
		$session->message( 'Please use a valid ID.' );
		redirect_to ( 'login.php' );	
	}
	
	
	$message = '';
	
	if( isset( $_POST['update'] ) ) { 
		$matches = Match::find_all();
		
		if( ! empty( $user ) ) {
		
			foreach($matches as $match) {
				
				$now = time();
				$matchTime = strtotime($match->time);
				
				if( $matchTime > $now ) {
					$homeId = 'home' . $match->id;
					$awayId = 'away' . $match->id;
					
					$user->$homeId = $_POST['home_score'][$match->id];
					$user->$awayId = $_POST['away_score'][$match->id];
						
					$user->save();
				} else {
					//match is finished or has started
					$session->message( 'Match ' . $match->id . ' has already started or is finished and could not be updated.<br />' );
				}
	
			}
			
			$message .= 'Scores updated.';
		} else {
			$session->message( 'No user found.' );
			redirect_to( 'index.php' );	
		}
	}
	
	

	$matches = Match::find_all();
?>
<?php include_layout_template('header.php'); ?>

<div id="content">



<?php echo output_message( $message ); ?>
<div class="sidebar">
<h1>User Info</h1>
<ul>
<li>Username: <?php echo $user->username; ?></li>
<li>Name:  <?php echo $user->name; ?></li>
<li>Email:  <?php echo $user->email; ?></li>
</ul>
<?php echo 'Total points: ' . $user->getTotalPoints( $matches ); ?>
<?php if ( $user->isLoggedInUser() ) {	echo '<p><a href="edituser.php?u=' . $user->id . '" >Edit</a></p>'; } ?>

<h2><?php echo $user->isLoggedInUser() ? 'Your' : 'His'; ?> Groups</h2>
<?php 

	$groups = $user->getGroups();
	
	$output = '<ul>';
	
	foreach( $groups as $group ) {
		$output .= '<li><a href="group.php?g='. $group->id .'">'. $group->name . '</a>';		
		$output .= '</li>';
	}
	
	$output .= '</ul>';
	
	echo $output;

?>
<?php if ( $user->isLoggedInUser() ) { echo '<p><a href="groups.php">Join Group</a></p>'; } ?>
<?php if ( $user->isLoggedInUser() ) { echo '<p><a href="create_group.php">Create Group</a></p>' ; } ?>

</div>


<div class="main">
<h1>Predictions - <?php echo $user->username; ?></h1>
<?php echo $user->getFormPredictions(); ?>
</div>
</div>
<?php include_layout_template('footer.php'); ?>