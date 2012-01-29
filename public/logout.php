<?php require_once('../includes/initialize.php'); ?>
<?php
$session->logout();
$session->message( 'You are now logged out.' );
redirect_to ( 'login.php' );
