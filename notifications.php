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
		<li class="active"><a href="notifications.php">Notifications</a></li>
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
Rules and Stuff:-
<ol>
	<li>General rules of any short coding contest apply here!!.</li>
	<li>Each problem has a fixed score of 100000 and a variable time based score &#8804; 99999 .</li>
	<li>Sharing of code is strictly prohibited and the defaulters will be banned.</li>
	<li>If the submission does not go through, wait 10-15 seconds before re-submitting.</li>
	<li>For contest IDE, we'll only consider top 3 students for MANAN </li>
</ol>
</div>
</div>
<?php include "footer.php" ?>

</body>
