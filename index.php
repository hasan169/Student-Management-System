<!DOCTYPE html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet"> 
<html>
<head>
    <title></title>
</head>
<body style="background-color:#EFFBFB">
<?php
	session_start();
	if(isset($_SESSION["admin"])){
		header("location:admin.php");
	}
	if(isset($_SESSION["student_id"])){
		header("location:student.php");
	}
	if(isset($_SESSION["teacher_id"])){
		header("location:teacher_profile.php");
	}
?>
	<nav  style="background-color:#a7a7a7" class="navbar navbar-default">
		<div  class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="sreg.php"> <span style="color:white">Student Registration</span> </a>
			</div>
		</div>
	</nav>
	<div class="container" style="margin-top:180px;margin-left:250px">
		<form class="form-horizontal" method="POST" action="index.php" role="form">
		<div class="form-group">
			<label class="control-label col-sm-2"></label>
			<div class="col-sm-4">
				<select class="form-control" name = "type">
					<option>Admin</option>
					<option>Student</option>
					<option>Teacher</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="year">Email:</label>
			<div class="col-sm-4">
				<input type="email" class="form-control" name ="email" placeholder="Enter email">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Password:</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" name ="pass" placeholder="Enter password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10" style="margin-left:200px">
				<button type="submit" name="reg" class="btn btn-primary">Login</button>
			</div>
		</div>
		</form>
	</div>                     
<?php
	$conn = mysql_connect("localhost","root","");
	if(isset($_POST['reg'])){
		$type = $_POST['type'];
		$email = $_POST['email'];
		$password = $_POST['pass'];
		if( $type == "Teacher" ){
			$sql = "select pass,id from teacher where email = '$email'";
			mysql_select_db('student_management_system');
			$retval = mysql_query($sql);
			if($row = mysql_fetch_array($retval)){
				$pass = $row["pass"];
				if( $pass == $password ){
					session_start();
					$_SESSION['teacher_id'] = $row["id"];
					header("location:teacher_profile.php");
				}
			}
		}
		else if( $type == "Admin" ){
			$sql = "select pass  from admin where email = '$email'";
			mysql_select_db('student_management_system');
			$retval = mysql_query($sql);
			if($row = mysql_fetch_array($retval)){
				$pass = $row["pass"];
				if( $pass == $password ){
					session_start();
					$_SESSION["admin"] = "1";
					header("Location:admin.php");
				}
			}
		}
		else{
			$sql = "select * from student where email = '$email'";
			mysql_select_db('student_management_system');
			$retval = mysql_query($sql);
			if($row = mysql_fetch_array($retval)){
				$pass = $row["pass"];
				if( $pass == $password ){
					if($row['approval'] == 'yes'){
						session_start();
						$_SESSION['student_id'] = $row["id"];
						header("location:student.php");
					}
				}
			}
		}
		echo "<h4 style='margin-left:480px'> Invalid User Name or Password</h4>";	
	}		
?>
</body>
</html>