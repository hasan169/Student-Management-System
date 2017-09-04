<?php
	session_start();
	$id = $_POST['id'];
	$course = $_SESSION['course'];
	$attendance = $_POST["attendance"];
	$final = $_POST["final"];
	$quiz = $_POST["quiz"];
	$conn = mysql_connect("localhost","root","");
	$sql = "select * from curr_semester";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$sem = trim($row["semester_name"]);
	$year = $row["semester_year"];
	$sql = "update result set attendance = $attendance, quiz = $quiz ,final_mark = $final where student_id = '$id' and courseno = '$course' and semester_name = '$sem' and semester_year = $year";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
?>