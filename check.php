<?php session_start();
		ob_start();	 
		include "conn_db.php" ?> 
<?php	
	$username = $_POST['username'];
	$password = $_POST['password'];
	if($username==""||$password=="")
	{
		header("Location: /judge/index.php");
	}
	$username = stripslashes($username);
	$password = stripslashes($password);
	$sql= "SELECT username,salt,hash,id,admin FROM judge_user WHERE username = '".$username."'";
	$res = $con->query($sql);
	$res->setFetchMode(PDO::FETCH_ASSOC);
	$result = $res->fetch();
	//echo "hi";
	if($result)
	{
		//echo "hi1";
		$salt=$result['salt'];
		$has=$result['hash'];
		$hash=crypt($password,$salt);
		if($hash==$has)
		{
			//echo "hi2";
			$_SESSION["timeout"] = time();
			$_SESSION["username"] = $username;
			$_SESSION["uid"]=$result["id"];
			$_SESSION["login"] = true;
			$_SESION["check"] = 1;
				$url="/judge/welcome.php";
				//echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
				header("Location: ".$url);
		}
		else
		{
			//echo "hi3";
			$_SESSION["login"] = false;
			$url="/judge/index.php";
			//echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
			header("Location: ".$url);
		}
	}
	else
	{
		//echo "hi4";
		$_SESSION["login"] = false;
		$url="/judge/index.php";
		//echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
		header("Location: ".$url);
	}
	/*$rowcount=0;
	if($result != false)
		$rowcount = mysqli_num_rows($result);	
	if($rowcount==1)
	{
		$row=mysqli_fetch_array($result);
		$has=crypt($password,$row['salt']);
		if($has==$row['hash'])
		{
			$_SESSION["timeout"] = time();
			$_SESSION["username"] = $username;
			$_SESSION["login"] = true;
			header("Location: /judge/welcome.php");
		}
		else
		{
			$_SESSION["login"] = false;
			header("Location: /judge/index.php");
		}
	}
	else
	{
		$_SESSION["login"] = false;
		header("Location: /judge/index.php");
	}*/
?>
