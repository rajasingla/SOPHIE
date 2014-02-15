<?php
	ini_set("display_errors", "1");
	error_reporting(-1);
	try
	{
		$con= new PDO("mysql:host=culmyca2k13.db.10414665.hostedresource.com;dbname=culmyca2k13","culmyca2k13","MAN@n2013");
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	/*$con=mysqli_connect("localhost","root","");
	mysqli_select_db($con,"judge");	
	if(mysqli_connect_errno($con))
	{
		echo "Failed to connect ".mysqli_connect_error();
	}*/
?>
