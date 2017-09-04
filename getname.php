<?php
	$conn = mysql_connect("localhost","root","");
	date_default_timezone_set("Asia/Dhaka");
	if(isset($_POST['dept'])){
		$dept = $_POST['dept'];
		$sql = "select name from teacher where dept = '$dept'";
		mysql_select_db('student_management_system');
		$ret = mysql_query($sql);
		$arr = array();
		$i = 0;
		while($row = mysql_fetch_array($ret)){
			$arr[$i] = $row['name'];
			$i++;
		}
		echo json_encode($arr);
		exit();
	}
?>