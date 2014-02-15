<?php
	session_start();
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
	$uid=$_SESSION['uid'];
	$sid=$_GET['id'];
	$sql="SELECT user_id,code,problem_code,problem_status,time_created,problem_lang FROM judge_submissions WHERE submission_id='".$sid."'";
	$sql=$con->prepare($sql);
	try
	{
		$sql->execute();
	}
	catch(PDOException $e)
	{
		$e->getMessage();
	}
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	try
	{
		$res=$sql->fetch();
	}
	catch(PDOException $e)
	{
		$e->getMessage();
	}
	$lang="c++";
	switch($res['problem_lang'])
	{
		case '1':	$lang="C++ (gcc-4.8.1)";break;
		case '10':	$lang="Java (JavaSE 6)";break;
		case '11':	$lang="C (gcc-4.8.1)";break;
		case '4':	$lang="Python (python 2.7.3)";break;
		case '116':	$lang="Python 3 (python 3.2.3)";break;
		default:	$lang="C++ (gcc-4.8.1)";break;
	}
	$sta=-1;
	if($res['problem_status']==1)
		$sta="AC";
	else
		$sta="WA";
	if($res['problem_status']==3)
		$sta="TLE";
	if($res['user_id']==$uid)
	{
		echo "<h3>PROBLEM CODE : ".$res['problem_code']."</h3>";
		echo "<h5>Problem Status : ".$sta."</h5>";
		echo "<h5>Time Submitted : ".$res['time_created']."</h5>";
		echo "<h5>Language : ".$lang."</h5>";
		echo "<b>CODE :</b>";
		echo "<pre style='margin-left:20px'>".htmlspecialchars($res['code'])."</pre>";
	}
	else
		header("Location: /judge/error.php");
?>
