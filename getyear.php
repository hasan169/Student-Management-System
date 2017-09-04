<?php
	$conn = mysql_connect("localhost","root","");
	$sem = $_POST['semester'];
	$sql = "select semester_year from semester where semester_name = '$sem'";
	mysql_select_db('student_management_system');
	$ret = mysql_query($sql);
	$arr = array();
	while($row = mysql_fetch_array($ret)){
		array_push($arr,$row['semester_year']);
	}
	echo json_encode($arr);
	exit();
?>