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
<div style="min-height:89%;height:auto">
<nav class="navbar navbar-inverse navbar-static-top" role="navbar" style="margin-bottom:0px">
	<ul class="nav navbar-nav navbar-left">
		<li class="active"><a href="welcome.php">HOME</a></li>
		<li><a href="submissions.php">My Submissions</a></li>
		<li><a href="blog.php">BLOG</a></li>
		<li><a href="notifications.php">Notifications</a></li>
		<li><a href="ranking.php">Rankings</a></li>
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
	//$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$sth=$sth->fetch();
	if($sth)
	{
		echo "<p class='lead'><b>Contest Name: ".$sth['contest_name']."</b></p>";
		$sq=$con->prepare('SELECT problem_id,problem_code,solved FROM problems WHERE contest_name="'.$sth['contest_name'].'"');
		//$que=$con->query($sq);
		$sq->setFetchMode(PDO::FETCH_ASSOC);
		$sq->execute();
		$no=0;
		$hit=1;
		echo "<table class='table table-hover'><div class='par'><tr><th>Sr no.</th><th>Problem Code</th><th style='text-align:right'>Solved By</th></tr>";
		while($row=$sq->fetch())
		{
			$hit=0;
			$no=$no+1;
			echo "<tr><td width='20px'><b>".$no."</b></td><td>";
			echo "<div class='flipi'><b><a href='/judge/problem.php?id=".$row['problem_id']."'>".$row['problem_code']."</a></b> <small> </small></div></td>";
			echo "<td style='text-align:right'>".$row['solved']."</td></tr>";		
		}
		echo "</div></table>";
		if($hit)
		{
			echo "NO Problems Added";
		}
	}
	else
	{
		echo "NO running Contests Sorry!!!";
	}
?>
</div>
<div class="col-md-1"></div>
<div class="col-md-3">
	
	<table style="font-size:15px" class="table table-hover">
		<tr class="active"><td>Username</td><td>Problem</td><td>Result</td><td>Language</td></tr>
		<?php
			$sql="SELECT user_id,problem_id,problem_code,problem_status,problem_lang from judge_submissions WHERE contest_name='".$sth['contest_name']."' ORDER BY time_created DESC LIMIT 0,30";
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
	<input class="btn btn-success" type="button" onclick="prev()" value="Prev" />
	<input style="margin-left:150px"class="btn btn-success" type="button" onclick="nex()" value="Next" />
</div>
</div>
</div>
</div>
<?php include "footer.php" ?>
</body>
<script>
	var count=1;
	function nex()
	{
		count=parseInt(count);
		count=count+1;
		if(count==4)
			count=3;
		var hd=".pagination_"+count;
		$(".pagi").fadeOut('slow',function(){
		$(hd).fadeIn('slow');
		});
	}
	function prev()
	{
		count=parseInt(count);
		count=count-1;
		if(count==0)
			count=1;
		var hd=".pagination_"+count;
		$(".pagi").fadeOut('slow',function(){
		$(hd).fadeIn('slow');
		});
	}
</script>