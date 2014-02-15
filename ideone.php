<?php session_start();
		ob_start();
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
	$prob=$_POST['id'];
	if(empty($prob))
		header("Location: /judge/error.php");
	$sth=$con->query("SELECT contest_name,end_time FROM judge_current_contest");
	//$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$sth=$sth->fetch();
	$sql="SELECT problem_input,problem_output,problem_time,problem_code FROM problems WHERE problem_id='".$prob."'";
	$sql=$con->prepare($sql);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	try
	{
		$row=$sql->fetch();
	}
	catch(PDOException $e)
	{
		$e->getMessage();
	}
	$username = "daspalrahul";
	$password = "judgeapi";
	$lang = $_POST['lang'];
	$sta=-1;
	$code =$_POST["code"];
	$code=stripcslashes($code);
	//$code=trim($code);
	$input = $row["problem_input"];
	$input=stripcslashes($input);
	$op = $row["problem_output"];
	$op=stripcslashes($op);
	$op=trim($op);
	$time = $row["problem_time"];
	$run = true;
	$private = false;
	$client = new soapClient("http://ideone.com/api/1/service.wsdl");
	$result = $client->createSubmission($username,$password,$code,$lang,$input,$run,$private);
	//AC 1
	//WA 2
	//TLE 3
	//RTE 4 
	//SUB FAIL 5
	//LIMIT 6
	//CANT CREATE 7
	if($result["error"]=="OK")
	{
		$status = $client->getSubmissionStatus($username,$password,$result["link"]);
		if($status["error"]==0)
		{
			while($status["status"]!=0)
			{
				sleep(3);
				$status = $client->getSubmissionStatus($username,$password,$result["link"]);
			}
			$details = $client->getSubmissionDetails($username,$password,$result["link"],true,true,true,true,true);
			if($details["error"]=="OK")
			{
				//echo $details["output"]."<br>";
				//echo $op."<br>";
				if(strcmp($op,trim($details['output']))){
					//var_dump($details);
					$sta=2;
					//echo strcmp((string)$op,$details['output']);
					echo "<strong>WA,try again</strong><br>";} // output strings do not match
				else
				{
					if($details["time"]>$time)
					{
						$sta=3;
						echo "<strong>TLE, try again</strong><br>";
					}
					else
					{
						$sta=1;
						echo "<strong>AC, congrats</strong><br>";
					}
				}
				//var_dump($details);
			}
			else{
				$sta=5;
				echo "error_submission_failed";			
				//var_dump($details);
				}
		}
		else{
			$sta=6;
			echo "monthly_limit";
			//vardump($status);
			}
	}
	else{
		$sta=7;
		echo "couldn't_create_submission";
		//var_dump($result);
		}
	if($sta==1||$sta==2||$sta==3||$sta==4)
	{
		$uid=$_SESSION['uid'];
		
		$sql="SELECT submission_id FROM judge_submissions WHERE problem_status='1' AND problem_id='".$prob."' AND user_id='".$uid."'";
		$sql=$con->prepare($sql);
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();
		$a=$sql->fetch();
		if($a==NULL)
		{
			$sq="SELECT solved FROM problems WHERE problem_id='".$prob."'";
			$sq=$con->prepare($sq);
			$sq->setFetchMode(PDO::FETCH_ASSOC);
			$sq->execute();
			$an=$sq->fetch();
			$counter=$an['solved'];
			$counter=intval($counter);
			$counter=$counter+1;
			$sq="UPDATE problems SET solved='".$counter."' WHERE problem_id='".$prob."'";
			$sq=$con->prepare($sq);
			$sq->execute();
		}
		$sco=strtotime($sth['end_time'])-time();
		if($sta==2||$sta==3||$sta==4)
			$sco=0;
		$sql="INSERT INTO judge_submissions(contest_name,problem_id,user_id,code,problem_status,problem_code,problem_lang,problem_score) VALUES (?,?,?,?,?,?,?,?)";
		$sql=$con->prepare($sql);
		$sql->bindParam(1,$sth['contest_name']);
		$sql->bindParam(2,$prob);
		$sql->bindParam(3,$uid);
		$sql->bindParam(4,$code);
		$sql->bindParam(5,$sta);
		$sql->bindParam(6,$row['problem_code']);
		$sql->bindParam(7,$lang);
		$sql->bindParam(8,$sco);
		try
		{
			$sql->execute();
		}
		catch(PDOException $e)
		{
			$e->getMessage();
		}
		if($sta==1)
		{
			$sql="INSERT INTO judge_current_contest_users(user_id) VALUES (?) ON DUPLICATE KEY UPDATE dummy=dummy+1";
			$sql=$con->prepare($sql);
			$sql->bindParam(1,$uid);
			$sql->execute();
		}
	}
	$_SESSION["timeout"]=time();
?>
<br>
<br>
	
