<?php
	session_start(); 
	include "conn_db.php"?>
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
	if(!isset($_GET['id']))
		header("Location: /judge/welcome.php");
	$prob=$_GET['id'];
	if(empty($prob))
		header("Location: /judge/error.php");
	$_SESSION['timeout']=time();
	$_SESSION['current']=$prob;
	$sql="SELECT problem_code FROM problems WHERE problem_id='".$prob."'";
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
	$co=$row['problem_code'];
?>
<link rel="stylesheet" href="/judge/css/bootstrap.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script language="javascript" src="/judge/js/ide.js"></script>
<body style="height:100%;">
<div style="min-height:89%">
<div class="jumbotron" style="background-color:#DFDAC7">
	<div class="container">
<?php
	include "conn_db.php";	
	echo "<p align='right'>hi! ".$_SESSION["username"]."  ";
?>
<a href="logout.php" class="btn btn-primary btn-sm" role="button"> Logout</a></p>
</div>
</div>	
	<div class="hidden">
		<form id="for">
			<textarea name="code"><?php echo stripcslashes($_POST['code']); ?></textarea>
			<input type="text" name="lang" value="<?php echo $_POST['lang']; ?>"></input>
			<input type="text" name="id" value="<?php echo $_GET['id']; ?>"></input>
		</form>
	
	</div>
<div class="container">
<div id="ajax" style="text-align:center;">
	<h3 align="center">Submission Running...</h3>
	<img src="/judge/loader.gif" alt="submission" align="center"></img>
</div>
<br />
Go back to <a href="/judge/welcome.php">Main Page</a>.
</div>
</div>
<?php include "footer.php" ?>
</body>
