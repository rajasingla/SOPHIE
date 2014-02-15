<?php include "conn_db.php" ?>
<?php 
	$username=$_POST['username'];
	$sql="SELECT username from judge_user WHERE username='".$username."'";
	$sql=$con->prepare($sql);
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$sql->execute();
	try
	{
		$res=$sql->fetch();
	}
	catch(PDOException $e)
	{
		$e->getMessage();
	}
	if($res)
	{
		echo "1";//exists
	}
	else
	{
		echo "0";//not-exists
	}
?>
