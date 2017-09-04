<?php
	session_start();
	$material_id = $_POST['material_id'];
	$teacher_id = $_SESSION['teacher_id'];
	$conn = mysql_connect("localhost","root","");
	$sql = "select file_type from course_material where teacher_id = '$teacher_id' and material_id = '$material_id'";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$type = $row["file_type"];
	$sql = "delete from course_material where teacher_id = '$teacher_id' and material_id = '$material_id'";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
	unlink("./upload/" . $teacher_id . "t" . $material_id . "." . $type);
?>