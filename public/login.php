<?php require_once('../includes/initialize.php'); ?>
<?php

	if( $session->is_logged_in() ) {
		$userId = $session->user_id;
		redirect_to( 'user.php?u=' . $userId );
	}

	if( isset ( $_POST['submit'] ) && ! empty( $_POST['username'] ) ) {
		$username = $_POST['username'];
		$hashedPassword = md5( $_POST['password'] );
		
		if ( $user = User::authenticate( $username, $hashedPassword ) ) { 
			$session->message('Logged in.');
			$session->login($user);
			redirect_to( 'user.php?u=' . $user->id );
		} else {
			$session->message('Not logged in.');
		};
	}

?>
<?php include_layout_template('header.php'); ?>
<h1>Log in</h1>
<?php echo output_message( $message ); ?>  

<form method="post" action="login.php">

<label for="name">Username: </label><input type="text" name="username" value="" /><br/>
<label for="password">Password: </label><input type="password" name="password" value="" /><br/>
<input type="submit" name="submit" value="Log in" />

</form>
<?php include_layout_template('footer.php'); ?>