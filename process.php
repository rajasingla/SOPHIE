<?php session_start(); 
	include "conn_db.php" ?>
<?php
	if(isset($_SESSION['check']))
	{
		if($_SESSION['check']==0)
			header("Location: /judge/index.php?visitor=true");
	}
	else
		header("Location: /judge/index.php?visitor=true");
?>
<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$username = stripslashes($username);
	$password = stripslashes($password);
	$email = stripslashes($email);
	$admin=0;
	//$username = mysqli_real_escape_string($con,$username);
	//$password = mysqli_real_escape_string($con,$password);
	//$email = mysqli_real_escape_string($con,$email);
	$salt=uniqid(mt_rand(), true);
	$hash=crypt($password,$salt);
	$num="0";
	try
	{
		try
		{
			$sth=$con->prepare("INSERT INTO judge_user (username,salt,hash,email,admin) VALUES (?,?,?,?,?)");
			$sth->bindParam(1, $username);
			$sth->bindParam(2, $salt);
			$sth->bindParam(3, $hash);
			$sth->bindParam(4, $email);
			$sth->bindParam(5, $admin);
		}
		catch(PDOException $se)
		{
			$se->getMessage();
		}
		//echo $que;
		try
		{
			$sth->execute();
		}
		catch(PDOException $pe)
		{
			$pe->getMessage();
		}
		//if(!mysqli_query($con,$que))
		//{
			//die('Error: ' . mysqli_error($con));
		//}
	}
	catch(PDOException $e)
	{
		$e->getMessage();
	}
?>
<?php
	session_destroy();
	header("Location: /judge/index.php?registered=true");
?>
