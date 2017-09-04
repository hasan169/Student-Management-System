<?php
	$conn = mysql_connect("localhost","root","");
	$dept = $_POST['dept'];
	$semester = $_POST['semester'];
	$year = $_POST['year'];
	$sql = "select distinct course.courseno as id from course_teacher,course where dept = '$dept' and course.courseno = course_teacher.courseno and semester_name = '$semester' and semester_year = $year";
	mysql_select_db('student_management_system');
	$ret = mysql_query($sql);
	$arr = array();
	while($row = mysql_fetch_array($ret)){
		array_push($arr,$row['id']);
	}
	echo json_encode($arr);
	exit();
?>