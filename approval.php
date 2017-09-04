<?php
	$id = $_POST['id'];
	$conn = mysql_connect("localhost","root","");
	$sql = "update student set approval = 'yes' where id = '$id'";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
?>