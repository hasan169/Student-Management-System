<?php
	$conn = mysql_connect("localhost","root","");
	$dept = $_POST['dept'];
	$sql = "select courseno from course where dept = '$dept'";
	mysql_select_db('student_management_system');
	$ret = mysql_query($sql);
	$arr = array();
	while($row = mysql_fetch_array($ret)){
		array_push($arr,$row['courseno']);
	}
	echo json_encode($arr);
	exit();
?>