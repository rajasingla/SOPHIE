<?php
	session_start();
	ob_start(); ?>
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
<div style="min-height:89%;height:auto">
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
<br />

<div class="container">
	<div class="row">
		<div class="col-md-8">

	<?php
		$sth=$con->query("SELECT contest_name FROM judge_current_contest");
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$sth=$sth->fetch();
		$pid=$_GET['id'];
		$sql="SELECT contest_name,problem_code,problem_statement,problem_time,problem_memory FROM problems WHERE problem_id='".$pid."'";
		$sql=$con->prepare($sql);
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();
		try
		{
			$ans=$sql->fetch();
		}
		catch(PDOException $e)
		{
			$e->getMessage();
		}
		if($ans)
		{
			if(trim($ans['contest_name'])==trim($sth['contest_name']))
			{
				echo "<h3 style='margin-bottom:0px'><strong>".$ans['contest_name']."</strong></h3><hr style='height:5px;margin-top:0px' />";
				echo "Problem : <strong>".$ans['problem_code']."</strong>";
				echo "<pre>".$ans['problem_statement']."</pre>";
				echo "<br>Time Limit: ".$ans['problem_time']."s<br><br>";
				echo "<a href='/judge/submit.php?id=".$pid."' class='btn btn-success'>Solve</a>";
			}
			else
			{
				//echo "hello";
				header("Location: /judge/error.php");		
			}
		}
		else
		{
			//echo "hello";
			header("Location: /judge/error.php");
		}
	?>
		</div>
		<div class="col-md-1">
		</div>
		<div class="col-md-3">

		<table style="font-size:15px" class="table table-hover">
		<tr class="active"><td>Username</td><td>Problem</td><td>Result</td><td>Language</td></tr>
		<?php
			$sql="SELECT user_id,problem_id,problem_code,problem_status,problem_lang from judge_submissions WHERE problem_id='".$pid."' AND contest_name='".$sth['contest_name']."' ORDER BY time_created DESC LIMIT 0,11";
			$sql=$con->prepare($sql);
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$sql->execute();
			$variable=1.0;
			$count=0.0;
			while($r=$sql->fetch())
			{
				$sql_user="SELECT username FROM judge_user WHERE id='".$r['user_id']."'";
				$sql_user=$con->prepare($sql_user);
				$sql_user->setFetchMode(PDO::FETCH_ASSOC);
				$sql_user->execute();
				$ans_user=$sql_user->fetch();
				$lang="c++";
				switch($r['problem_lang'])
				{
					case '1':	$lang="C++";break;
					case '10':	$lang="Java";break;
					case '11':	$lang="C";break;
					case '4':	$lang="Python";break;
					case '116':	$lang="Python 3";break;
					default:	$lang="C++";break;
				}
				$loc='/judge/css/loader.gif';
				switch($r['problem_status'])
				{
					case '1': $loc='/judge/css/ac-icon.gif';break;
					case '2': $loc='/judge/css/wa-icon.gif';break;
					case '3': $loc='/judge/css/tle-icon.gif';break;
					case '4': $loc='/judge/css/rte-icon.gif';break;
					default:  $loc='/judge/css/loader.gif';
				}
				echo "<tr class='pagi pagination_".$variable."' id='pagin_".$variable."' style='font-size:12px'><td style='overflow:hidden;'><div style='width:80px'>".$ans_user['username']."</div></td><td><div width='80px'><a href='/judge/problem.php?id=".$r['problem_id']."'>".$r['problem_code']."</a></div></td><td><div align='center'><img src='".$loc."'></div></td><td><div align='right'>".$lang."</div></td></tr>";
				$count=$count+1.0;
				if($count>10.0)
				{
					$count=0.0;
					$variable=$variable+1.0;
				}
			}
		?>
		</table>

		</div>
	</div>
</div>

</div>
<?php include "footer.php" ?>
</body>