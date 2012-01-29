<?php require_once('../includes/initialize.php'); ?>
<?php
	
	if( $session->is_logged_in() ) {
		$userId = $session->user_id;
		$user = User::find_by_id($userId);
	}
	
	$msg = '';
?>
<?php include_layout_template('header.php'); ?>
<?php echo output_message( $message ); ?>   
<?php 
	if( isset( $user ) ) {
		echo '<h1>Welcome - '. $user->username . '</h1>';
	} else {
		echo '<h1>Welcome</h1>';
	}
?>
<?php include_layout_template('footer.php'); ?>