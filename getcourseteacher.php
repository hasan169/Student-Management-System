<?php
	$course = $_POST['course'];
	$conn = mysql_connect("localhost","root","");
	$sql =  "select * from advising";
	mysql_select_db('student_management_system');
	$ret = mysql_query($sql);
	$row = mysql_fetch_array($ret);
	$semester = $row["semester_name"];
	$year = $row["semester_year"];
	$sql = "select name,teacher.id  from teacher,course_teacher where courseno = '$course' and teacher.id = course_teacher.teacher_id and semester_name = '$semester' and semester_year = $year and total_seat > 0";
	mysql_select_db('student_management_system');
	$ret = mysql_query($sql);
	$arr = array();
	while($row = mysql_fetch_array($ret)){
		$id = $row["id"];
		$name = $row["name"];
		array_push($arr,$id,$name);
	}
	echo json_encode($arr);
	exit();	
?>