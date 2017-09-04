<?php
	$conn = mysql_connect("localhost","root","");
	$sql = "select *  from advising";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$sem = trim($row['semester_name']);
	$year = $row['semester_year'];
	$id = $_POST['id'];
	$course = trim($_POST['course']);
	$total = $_POST['seat'];
	$sql = "update course_teacher set total_seat = $total where courseno = '$course' and  teacher_id = $id and semester_name = '$sem' and semester_year = $year";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
?>