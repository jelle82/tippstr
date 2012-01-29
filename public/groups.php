<?php require_once('../includes/initialize.php'); ?>
<?php
	
	if( $session->is_logged_in() ) {
		$user = User::find_by_id( $session->user_id );	
	}
	
	$groups = Group::find_all();
?>
<?php include_layout_template('header.php'); ?>
<?php echo output_message( $message ); ?>
<h1>Groups</h1>
<p>Click on on Group to view and join it</p>
<?php
	
	$output = '<ul>';
	
	foreach( $groups as $group ) {
		$output .= '<li><a href="group.php?g='. $group->id .'">'. $group->name . '</a>';		
		$output .= '</li>';
	}
	
	$output .= '</ul>';
	
	echo $output;

?>
<p><a href="create_group.php">Create Group</a></p>
<?php include_layout_template('footer.php'); ?>