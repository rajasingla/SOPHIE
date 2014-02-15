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
<script language="Javascript" type="text/javascript" src="/judge/editarea/edit_area/edit_area_full.js"></script>
<body style="height:100%;min-height:100%">
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
	<p><b>Problem Code : </b><?php echo $co; ?></p>
</div>
<form method="post" action="analyze.php?id=<?php echo $prob ?>">
<div class="container">
	<textarea name="code" id="file" rows="20" cols="80" class="form-control"></textarea>
</div>
<br />
<div class="container">
<select name="lang" id="lang" class="form-control">
<option value="11" >C (gcc-4.8.1)</option>
<option value="1" selected>C++ (gcc-4.8.1)</option>
<option value="10" >Java (JavaSE 6)</option>
<option value="4" >Python (python 2.7.3)</option>
<option value="116" >Python 3 (python 3.2.3)</option>
</select>
</div>
<br />
<div class="container">
<input type="submit" value="Submit" class="btn btn-success" />
</div>
</form>
<?php include "footer.php" ?>
</body>	
<script language="Javascript" type="text/javascript">
$(document).ready(function(){
	var lang_map = {
			1:			"cpp",
			10:			"java",
			11:			"c",
			4:			"python",
			116:		"python",
	};
	editAreaLoader.init({
	        id: "file"       
	        ,start_highlight: true  
	        ,allow_resize: "both"
	        ,allow_toggle: true
	        ,word_wrap: true
	        ,language: "en"
	        ,syntax: "cpp"  
			,font_size: "8"
	        ,syntax_selection_allow: "basic,brainfuck,c,cpp,java,pas,perl,php,python,ruby,sql"
			,toolbar: "search, go_to_line, fullscreen, |, undo, redo, |, select_font,syntax_selection,|, change_smooth_selection, highlight, reset_highlight, word_wrap, |, help"          
	});
	$("#lang").bind('change', function(){
		var lang_id = $("#lang").val();
		if (typeof lang_map[lang_id] != "undefined") {
			window.frames['frame_file'].document.getElementById('syntax_selection').value = lang_map[lang_id];
			window.frames['frame_file'].editArea.execCommand('change_syntax', lang_map[lang_id]);
		} else {
			window.frames['frame_file'].document.getElementById('syntax_selection').value = "basic";
			window.frames['frame_file'].editArea.execCommand('change_syntax', lang_map[lang_id]);
		}
	});
});
</script>
