<?php
	session_start();
	//sesion_unset();	
	session_destroy();
	header("Location: /judge/index.php");
?>
