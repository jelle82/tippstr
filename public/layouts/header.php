<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Group</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/modernizr.js"></script>
</head>
<body class="container_12">

	<header>
		<div id="login-header"><span class="grid_3 push_9">
			<?php 
			global $session; 
			if ( $session->is_logged_in() ) { 
			$user = User::find_by_id( $session->user_id );		
		?>
			
			Hello <a href="user.php?u=<?php echo $user->id; ?>"><?php echo $user->username; ?></a>, 
			<a href="logout.php"><?php echo 'Log out'; ?></a>
			
		<?php } else {?>
			<a href="login.php">Login</a> or <a href="register.php" >Register</a>
			
		<?php } ?>
		</span></div>
		<hgroup>
			<h1>tippstr</h1>
			<h2>Tipp den EM 2012 mit Freunden und Kollegen</h2>
		</hgroup>
		
		<nav>
			<div class="grid_12">
				<a href="">Item 1</a>
				<a href="">Item 2</a>
				<a href="">Item 3</a>
				<a href="">Item 4</a>
			</div>
		</nav>
	</header>