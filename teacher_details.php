<?php
	$conn = mysql_connect("localhost","root","");
	$id = $_POST["id"];
	$name = $_POST["name"];
	$des = $_POST["des"];
	$sql = "update teacher set name = '$name' , designation = '$des' where id = $id";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
?>