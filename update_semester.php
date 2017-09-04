<?php
	$conn = mysql_connect("localhost","root","");
	$sem = $_POST['name'];
	$year = $_POST['year'];
	$sql = "delete from curr_semester";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
	$sql = "insert into curr_semester values ('$sem',$year)";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);			
?>