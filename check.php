<?php
	$conn = mysql_connect("localhost","root","");
	$sql = "select * from advising";
	mysql_select_db('student_management_system');
	$ret = mysql_query($sql);
	$row = mysql_fetch_array($ret);
	$sem = $row["semester_name"];
	$year = $row["semester_year"];
	session_start();
	$id = $_SESSION["student_id"];
	$sql = "select count(courseno) as total from selected_course where student_id = '$id' and semester_name = '$sem' and semester_year = $year";
	mysql_select_db('student_management_system');
	$ret = mysql_query($sql);
	$row = mysql_fetch_array($ret);
	echo $row["total"];
	exit();
?>