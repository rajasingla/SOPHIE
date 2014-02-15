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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="/judge/js/file.js"></script>
<link rel="stylesheet" href="/judge/css/bootstrap.min.css">
<body style="height:100%" alink="red">
<div style="min-height:85%;height:auto">
<nav class="navbar navbar-inverse navbar-static-top" role="navbar" style="margin-bottom:0px">
	<ul class="nav navbar-nav navbar-left">
		<li><a href="welcome.php">HOME</a></li>
		<li class="active"><a href="submissions.php">My Submissions</a></li>
		<li><a href="blog.php">BLOG</a></li>
		<li><a href="notifications.php">Notifications</a></li>
	</ul>
</nav>
<div class="jumbotron" style="background-color:#DFDAC7">
	<div class="container">
<?php	
	echo "<p><div align='right'>hi! ".$_SESSION["username"]."  ";
?>
<a href="logout.php" class="btn btn-primary btn-sm" role="button"> Logout</a></div></p>
</div>
</div>
<?php
	$sql="SELECT submission_id,problem_code,problem_status,time_created FROM judge_submissions WHERE user_id='".$_SESSION['uid']."' ORDER BY time_created DESC";
	$sql=$con->prepare($sql);
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	try
	{
		$sql->execute();
	}
	catch(PDOException $e)
	{
		$e->getMessage();
	}
	
	$count=0;
?>
<div class="container">
<table class="table" border="2px" id="tab">
<label for="tab">Submission History</label>	
<tr style="background-color:white">
	<th>Time Submitted</th>
	<th><div align="center">Problem</div></th>
	<th><div align="right">Status</div></th>
</tr>
<?php
	while($row=$sql->fetch())
	{
		$count=1;
		$sta=-1;
		$col="white";
		if($row['problem_status']==1){
			$sta="AC";
			$col="#32CD32";}
		else{
			$sta="WA";
			$col="#FF8C00";}
		if($row['problem_status']==3)
			$sta="TLE";
		echo "<tr style='background-color:".$col."'><td style='width:250px'>".$row['time_created']."</td><td><a href='code.php?id=".$row['submission_id']."' target='_blank'><div align='center'>".$row['problem_code']."</div></a></td><td align='right'><strong>".$sta."</strongstrong></td></tr>";
		$count=$count+1;
	}
	if($count==0)
		echo "No problem Solved!!"
?>
</table>
</div>
</div>
</div>
<?php include "footer.php" ?>

</body>
