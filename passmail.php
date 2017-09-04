<?php
	mysql_connect("localhost","root","");
	$name = $_POST['em'];
	if (!filter_var($name, FILTER_VALIDATE_EMAIL)) {
		echo "true"; 
	}
	else{
		$sql = "select email from student";
		mysql_select_db('student_management_system');
		$ret = mysql_query($sql);
		$flag = false;
		while($row = mysql_fetch_array($ret)){
			if($row['email'] == $name){
				$flag  = true;
				break;
			}
		}
		$sql = "select email from teacher";
		mysql_select_db('student_management_system');
		$ret = mysql_query($sql);
		while($row = mysql_fetch_array($ret)){
			if($row['email'] == $name){
				$flag  = true;
				break;
			}
		}
		if($flag){
			echo "true";
		}
		else{
			echo "false";
		}
	}
?>