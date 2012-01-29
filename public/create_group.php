<?php require_once('../includes/initialize.php'); ?>

<?php
if( $session->is_logged_in() ) {
		$userId = $session->user_id;
	} else {
		$session->message( 'Please log in.' );
		redirect_to ( 'login.php' );	
	}

	if( isset ( $_POST['submit'] ) ) {
		
		$errors = array();
		
		$trimming = array( 'name' );
		
		$validateLength = array( 'name' => 50 );
		
		foreach ( $trimming as $field ) {
			$$field = trim( $_POST[$field] );
		}
		
		foreach ( $validateLength as $key => $value ) {
			
			if ( empty($$key) || strlen($$key) > $value ) {
				$errors[$key] = strlen($$key);
			}
		}
		
		if( empty( $errors ) ) {
			$group = new Group();
			$group->name = $name;
			$group->creator_id = $userId;
			$group->save();
			
			//save as admin
			$int = new IntUG();
			$int->u_id = $userId;
			$int->g_id = $group->id;
			$int->type = 'admin';
			$int->save();
			
			//save as member
			$int = new IntUG();
			$int->u_id = $userId;
			$int->g_id = $group->id;
			$int->type = 'member';
			$int->save();
			
			$msg = 'Group created.';
			$session->message( $msg );
			redirect_to('group.php?g=' . 	$group->id);
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
<h1>Create Group</h1>
<?php if(isset($msg)) { echo '<p class="message"><em>' . $msg . '</em></p>'; } ?> 

<form method="post" action="create_group.php">

<label for="name">Name Group: </label><input type="text" name="name" value="" /><br/>
<input type="submit" name="submit" value="Create" />

</form>
<?php include_layout_template('footer.php'); ?>