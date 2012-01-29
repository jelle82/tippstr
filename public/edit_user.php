<?php require_once('../includes/initialize.php'); ?>

<?php



if( $session->is_logged_in() ) {
		$user = User::find_by_id( $session->user_id );
	} else {
		$session->message( 'Please log in.' );
		redirect_to ( 'login.php' );	
	}
	
	if( isset($_GET['u']) ) {
		if( $user->id != $_GET['u'] ) {
			$session->message( 'You don\'t have enough permissions to edit this user.' );
			redirect_to( 'user.php?u=' . $_GET['u'] );
		}
	} else {
		$session->message( 'No valid ID.' );
		redirect_to( 'user.php?u=' . $user->id );	
	}
	
	$errors = array();
	
	
	if( isset ( $_POST['submit'] ) ) {
		
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
		
		if( empty( $errors ) ) {
			$user = User::find_by_id( $session->user_id );
			$user->username = $username;
			$user->email = $email;
			$user->name = $name;
			$user->save();	
			$session->message(  'User edited.');
			redirect_to( 'user.php?u=' . $user->id );
		} else {
			$msg = 'Oops, something went wrong.<br /><br />';
			$msg .= 'Please check the fields:';
			$errorFields = array_keys( $errors );
			
			foreach ( $errorFields as $errorField ) {
				$msg .= ' ' . $errorField . ', ';
			}
			
			$msg .= '.';
			$message = $msg;
				
		}
		
	}
	
	if( isset ( $_POST['changepassword'] ) ) {
		if( $_POST['password'][0] != $_POST['password'][1] || empty( $_POST['password'][0] ) ) {
			$errors['password'] = false;
		} else {
			$hashedPwd = md5( trim ( $_POST['password'][0] ) );
		}	
		
	if( empty( $errors ) ) {
			$user = User::find_by_id( $userId );
			$user->password = $hashedPwd;
			$user->save();	
			$session->message(  'User edited.');
			redirect_to( 'user.php' );
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
<h1>Edit User</h1>
<?php echo output_message( $message ); ?> 

<form id="form" method="post" action="edit_user.php?u=<?php echo $user->id; ?>">

<label for="name">Username: </label><input type="text" name="username" value="<?php echo $user->username; ?>" /><br/>
<label for="name">Email: </label><input type="text" name="email" value="<?php echo $user->email; ?>" /><br/>
<label for="name">Name: </label><input type="text" name="name" value="<?php echo $user->name; ?>" /><br/>
<input id="submit" class="button" type="submit" name="submit" value="Edit" /><br/><br/>
New password?<br/><br/>
<label for="name">Password: </label><input type="password" name="password[0]" value="" /><br/>
<label for="name">Password (again): </label><input type="password" name="password[1]" value="" /><br/><br/>
<input id="submit" class="button" type="submit" name="changepassword" value="Change" />

</form>
<?php include_layout_template('footer.php'); ?>