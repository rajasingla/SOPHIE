<?php include 'conn_db.php' ?>
<?php 
	session_start();
	$TTL=3600;
	if(isset($_SESSION["username"]))
	{
		if(time()-$_SESSION["timeout"]>$TTL)
		{
			session_destroy();
			session_start();
			$_SESSION['check']=0;
		}
		else{
			$_SESSION["timeout"]=time();
			$_SESSION["check"]=1;			
			header("Location: /judge/welcome.php");}
	}
	else
		$_SESSION['check']=0;
?>
<link href="/judge/css/bootstrap.min.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="/judge/js/file.js"></script>
<body style="height:100%">
	<?php include 'header.php'; ?>

<?php
	if(isset($_GET['visitor']))
	{
		if($_GET['visitor']=='true')
		{
?>		
<div class="alert alert-danger" style="margin-top:0px" align="center">
	<strong>Aha!! </strong>You must login first
</div>
<div class="container" style="min-height:89%">

<?php			
		}
	}
?>
<div class="container">
	<div class="row">
		<div class="col-md-5">
			<h3>Login</h3>
			<form action="check.php" method="post" role="form" id="ford">
				<div class="form-group">
					<label for="exampleInputEmail">Username : <div style="color:red" class="use1"><small>Required</small></div></label>
					<input type="text" name="username" class="form-control" id="exampleInputEmail" />
				</div><br/>
				<div class="form-group">
					<label for="exampleInputPassword">Password : <div style="color:red" class="pass1"><small>Required</small></div></label>
					<input type="password" name="password" class="form-control" id="exampleInputPassword"/>
				</div>
				<?php 
					if(isset($_SESSION["login"]))
						if($_SESSION["login"]==false)
							echo "<strong><small style='color:red'>Invalid Credentials</small></strong><br />";
				?>
				<br />
				<input type="submit" class="btn btn-primary" />
			</form>
		<br />
		</div>
		<div class="col-md-1" style="padding-top:130px">
			<center>--<b>or</b>--</center>
		</div>
		<div class="col-md-6">
			<h3>Fill in your details</h3>
			<form action="process.php" method="post" id="register" role="form">
				<div class="form-group">
				<label for="exampleInputEmail1">Username : <div style="color:red" class="use2"><small style="color:red" id="reguse">Required</small></div></label>
				<input type="text" name="username" class="form-control" id="exampleInputEmail1"/></div><br />
				<div class="form-group">
				<label for="exampleInputPassword1">Password : <div style="color:red" class="pass2"><small style="color:red" id="regpass">Required</small></div></label>
				<input type="password" name="password" class="form-control" id="exampleInputPassword1"/></div><br />
				<div class="form-group">
				<label for="exampleInputPassword1">Re-type Password : <div style="color:red" class="repass2"><small style="color:red" id="regrepass">Required</small></div></label>
				<input type="password" name="rep_password" class="form-control" id="exampleInputPassword1" /></div><br />
				<div class="form-group">
				<label for="exampleInputEmail1">Email : <div style="color:red" class="email1"><small style="color:red" id="regemail">Required</small></div></label>
				<input type="text" name="email" class="form-control" id="exampleInputEmail1" /></div>
				By clicking on 'Submit' you agree with the <a href="/judge/tos.html" class="link">Terms of Service </a>and <a href="/judge/privacy.html">Privacy Policy</a>
				<br /><br />
			<input type="submit" action="submit" value="Submit" class="btn btn-primary"/>
			</form>
		</div>
	</div>
</div>
</div>
<?php include "footer.php" ?>
</body>
