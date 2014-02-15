<?php 	session_start();
		session_destroy();
		session_start();
		include "conn_db.php" ?>
<form action="add.php" method="post">
Username : <input type="text" name="username"/><br />
Password : <input type="password" name="password"/><br />
Problem CODE: <input type="text" name="code"/><br />
Problem Statement:<br/>
<textarea rows="20" cols="80" name="st"></textarea><br />
Input:<br />
<textarea rows="7" cols="40" name="ip"></textarea><br />
Output<br />
<textarea rows="7" cols="80" name="op"></textarea><br />
Time Limit: <input type="text" name="tlimit"></input><br />
Memory Limit: <input type="text" name="mlimit"></input><br />
Contest Name: <input type="text" name="cname"></input><br />
<input type="submit" value="Add"/>
</form> 
