<?php require_once('../includes/initialize.php'); ?>

<?php

	if( isset ( $_POST['submit'] ) ) {
		
		$errors = array();
		
		$trimming = array( 'username', 'email', 'name' );
		
		$validateLength = array( 'username' => 30, 'email' => 60, 'name' => 50 );
		
		foreach ( $trimming as $field ) {
			$$field = trim( $_POST[$field] );
		}
		
		foreach ( $validateLength as $key => $value ) {
			
			if ( empty($$key) || strlen($$key) > $value ) {
				$errors[$key] = strlen($$key);
			}
		}
		
		if( ! valEmail ( $email ) ) {
			$errors[ 'email' ] = $email;
		}
		
		if( User::usernameExists( $username ) ) {
			$errors[ 'username' ] = $username;
		}
		
		if( $_POST['password'][0] != $_POST['password'][1] || empty( $_POST['password'][0] ) ) {
			$errors['password'] = false;
		} else {
			$hashedPwd = md5( trim ( $_POST['password'][0] ) );
		}
		
		
		if( empty( $errors ) ) {
			$user = new User();
			$user->username = $username;
			$user->email = $email;
			$user->name = $name;
			$user->password = $hashedPwd;
			$user->save();	
			$msg = 'User registered.';
			$session->message( $msg );
			$session->login($user);
			redirect_to( 'user.php?u=' . $user->id );
		} else {
			$msg = 'Oops, something went wrong.<br /><br />';
			$msg .= 'Please check the fields:';
			$errorFields = array_keys( $errors );
			
			foreach ( $errorFields as $errorField ) {
				$msg .= ' ' . $errorField . ', ';
			}
			
			$msg .= '.';
			$session->message( $msg );
				
		}
	}

?>
<?php include_layout_template('header.php'); ?>
<?php echo output_message( $message ); ?> 
<h1>Register</h1> 

<form id="form" method="post" action="register.php">

	<label for="name">Username: </label><input type="text" name="username" value="" />
	<label for="name">Email: </label><input type="text" name="email" value="" />
	<label for="name">Name: </label><input type="text" name="name" value="" />
	<label for="name">Password: </label><input type="password" name="password[0]" value="" />
	<label for="name">Password (again): </label><input type="password" name="password[1]" value="" />
	<input id="submit-btn" class="button" type="submit" name="submit" value="Register" />

</form>
<?php include_layout_template('footer.php'); ?>
  