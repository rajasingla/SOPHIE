<?php include "conn_db.php" ?>
<?php	
	session_start();	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$username = stripslashes($username);
	$password = stripslashes($password);
	$sql= "SELECT username,salt,hash,admin FROM judge_user WHERE username = '".$username."'";
	$res = $con->query($sql);
	$res->setFetchMode(PDO::FETCH_ASSOC);
	$result = $res->fetch();
	if($result)
	{
		$salt=$result['salt'];
		$has=$result['hash'];
		$hash=crypt($password,$salt);
		$ad=$result['admin'];
		$stmt=$_POST['st'];
		$input=$_POST['ip'];
		$output=$_POST['op'];
		$timel=$_POST['tlimit'];
		$meml=$_POST['mlimit'];
		$conname=$_POST['cname'];
		$cod=$_POST['code'];
		if($hash==$has && $ad)
		{
			try
			{
				$que =$con->prepare("INSERT INTO problems(contest_name,problem_statement,problem_input,problem_output,problem_time,problem_memory,problem_code) VALUES(?,?,?,?,?,?,?)");
				$que->bindParam(1,$conname);	
				$que->bindParam(2,$stmt);	
				$que->bindParam(3,$input);	
				$que->bindParam(4,$output);	
				$que->bindParam(5,$timel);	
				$que->bindParam(6,$meml);
				$que->bindParam(7,$cod);
			}
			catch(PDOException $er)
			{
				$er->getMessage();
			}
			try
			{
				$que->execute();
			}
			catch(PDOException $e)
			{
				$e->getMessage();
			}
		}
		else
		{
			header('Location: /judge/error.php');
			die();
		}
	}
	else
	{
		header("Location: /judge/error.php");
		die();
	}
?>
<?php
	session_destroy();
	echo "PROBLEM ADDED SUCCESSFULLY";
?>
