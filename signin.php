<?php
	$conn = mysql_connect("localhost","root","");
	$name = $_POST['name'];
	$id = $_POST['id'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$dept = $_POST['dept'];
	$sql = "insert into student values ('$id','$name','$dept','$email','$pass','no')";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);		
?>