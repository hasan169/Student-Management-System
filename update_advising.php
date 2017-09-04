<?php
	$conn = mysql_connect("localhost","root","");
	$sem = $_POST['name'];
	$year = $_POST['year'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$sql = "delete from advising";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
	$sql = "insert into advising values ('$sem',$year,'$start','$end')";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
?>