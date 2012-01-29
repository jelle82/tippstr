<?php require_once('../includes/initialize.php'); ?>
<?php
	if( $session->is_logged_in() ) {
		$user = User::find_by_id( $session->user_id );
	} else {
		$session->message( 'Please log in.' );
		redirect_to ( 'login.php' );	
	}

	if( isset( $_GET['g'] ) ) { 
		$groupId = $_GET['g'];
		$group = Group::find_by_id($groupId);
		if( ! $group ) {
			$session->message( 'Group doesn\'t exist.' );
			redirect_to ( 'user.php' );
		}
	} else {
		$session->message( 'Please specify id.' );
		redirect_to ( 'user.php' );
	}
	
	if( isset( $_POST['submit'] ) ) { 
		if( $_POST['submit'] == 'Add' ) {
			$int = new IntUG();
			$newMember = User::find_by_id( $_POST['user'] );
			 if ( ! $newMember->isOfType( 'member', $group->id ) ){
				$int->u_id = $_POST['user'];
				$int->g_id = $group->id;
				$int->type = 'member';
				$int->save();
			} else {
				$session->message( 'User ' . $newMember->username . ' is already a member of this group.' );
			}
		} elseif( $_POST['submit'] == 'Join group' )  {
			$newMember = User::find_by_id( $user->id );
			if ( ! $newMember->isOfType( 'member', $group->id ) ){
				$int = new IntUG();
				$int->u_id = $newMember->id;
				$int->g_id = $group->id;
				$int->type = 'member';
				$int->save();
			} else {
				$session->message( 'User ' . $newMember->username . ' is already a member of this group.' );	
			}
		} else {
			//no valid submit
			$session->message( 'Nothing was submitted.' );	
		}
	}

	
	
	
?>
<?php include_layout_template('header.php'); ?>
<?php echo output_message( $message ); ?>
<h1>Group: '<?php echo $group->name; ?>'</h1>
<h2>Members</h2>
<?php 

	$members = $group->getMembers();
	//print_r($users);
	
	$output = '<ul>';
	
	foreach( $members as $member ) {
		$output .= '<li>'. $member->name . ' (<a href="user.php?u='. $member->id .'">' . $member->username .'</a>) - ' . $member->getTotalPoints();		
		$output .= '</li>';
	}
	
	$output .= '</ul>';
	
	echo $output;


 ?>
 <?php
 	if ( ! $user->isOfType ( 'member', $group->id ) ) { ?>
		<form method="post" action="group.php?g=<?php echo $group->id; ?>">
				<input type="submit" name="submit" value="Join group" />	
		</form>
<?php	} ?>
 
<?php
	if( $user->isOfType ( 'admin', $group->id ) ) { ?>
<h2>Add Members</h2>
	<form method="post" action="group.php?g=<?php echo $group->id; ?>">
	<?php
		$notMembers = $group->getMembers( false );
		
		$output = '<select name="user">';
		foreach( $notMembers as $notMember ) {
			$output .= '<option value="'. $notMember->id .'">'. $notMember->username . '</option>';
		}
		
		$output .= '</select>';
		
		echo $output;
	
	?>
	<input type="submit" name="submit" value="Add" />
	</form>
	
	<option><select size="0"></select></option>
<?php } ?>
<?php include_layout_template('footer.php'); ?>
