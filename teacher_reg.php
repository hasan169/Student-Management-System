<?php
	$conn = mysql_connect("localhost","root","");
	$name = $_POST['name'];
	$id = $_POST['id'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$dept = $_POST['dept'];
	$desig = $_POST['desig'];
	$sql = "insert into Teacher values ('$id','$name','$dept','$email','$pass','$desig')";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);			
?>