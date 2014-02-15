<?php
	session_start(); ?>
<?php
	if(isset($_SESSION['check']))
	{
		if($_SESSION['check']==0)
			header("Location: /judge/index.php?visitor=true");
	}
	else
		header("Location: /judge/index.php?visitor=true");
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="/judge/js/file.js"></script>
<link rel="stylesheet" href="/judge/css/bootstrap.min.css">
<body style="height:100%">
<div style="min-height:85%;height:auto">
<nav class="navbar navbar-inverse navbar-static-top" role="navbar" style="margin-bottom:0px">
	<ul class="nav navbar-nav navbar-left">
		<li><a href="welcome.php">HOME</a></li>
		<li><a href="submissions.php">My Submissions</a></li>
		<li><a href="blog.php">BLOG</a></li>
		<li><a href="notifications.php">Notifications</a></li>
	</ul>
</nav>
<div class="jumbotron" style="background-color:#DFDAC7">
	<div class="container">
<?php
	include "conn_db.php";	
	echo "<p align='right'>hi! ".$_SESSION["username"]."  ";
?>
<a href="logout.php" class="btn btn-primary btn-sm" role="button"> Logout</a></p>
</div>
</div>

<div class="container">
	<?php 
		$sql="SELECT contest_name FROM judge_current_contest";
		$sql=$con->prepare($sql);
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();
		$contest=$sql->fetch();
		
		$sql="SELECT user_id FROM judge_current_contest_users";
		$sql=$con->prepare($sql);
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();
		$usr=array();
		while($ans=$sql->fetch())
		{
			array_push($usr,$ans['user_id']);
		}
		$sql="SELECT problem_id FROM problems WHERE contest_name='".$contest['contest_name']."'";
		$sql=$con->prepare($sql);
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();
		$pid=array();
		while($ans=$sql->fetch())
		{
			array_push($pid,$ans['problem_id']);
		}
		$rnk=array();
		foreach ($usr as $user_id)
		{
			$user_score=0;
			foreach ($pid as $problem_id)
			{
				//echo $user_id;
				//echo $problem_id;
				$sql="SELECT problem_score FROM judge_submissions WHERE user_id='".$user_id."' AND problem_status='1' AND problem_id='".$problem_id."' ORDER BY time_created ASC ";
				$sql=$con->prepare($sql);
				$sql->setFetchMode(PDO::FETCH_ASSOC);
				$sql->execute();
				while($ans=$sql->fetch())
				{
					$t=$ans['problem_score'];
					$t+=0;
					//echo $t;
					$user_score=$user_score + $t+100000;
					break;
				}
			}
			//echo $user_score;
			$rnk[$user_id]=$user_score;
		}
		arsort($rnk);
		//var_dump($rnk);
		//echo "<br>";
		echo "<div style='font-size:50px'><strong>Wall of Awesomeness!!</strong></div>";
		echo "<table class='table table-hover'>";
		echo "<tr><th>Rank</th><th>Username</th><th>Score</th></tr>";
		$hit=1;
		foreach($rnk as $id=>$scr)
		{
			$sql="SELECT username FROM judge_user WHERE id='".$id."'";
			$sql=$con->prepare($sql);
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$sql->execute();
			$u=$sql->fetch();
			echo "<tr><td>".$hit."</td><td>".$u['username']."</td><td>".$scr."</td></tr>";
			$hit+=1;
		}
		echo "</table>";
	?>
</div>

</div>
<?php include "footer.php" ?>
</body>
