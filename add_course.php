<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
</head>
<body>
<?php
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:index.php");
	}
include 'navbar.php';
$conn = mysql_connect("localhost","root","");
$sql = "select * from department";
mysql_select_db('student_management_system');
$retval = mysql_query($sql);
?>
<div class="container-fluid" style="display:inline">
        <!--This is a comment. Comments are not displayed in the browser-->
    <div class="row">
		<div class="col-md-9">
			<div style="width:100%;height:83px;border-width:1px;border-bottom-style:double;border-bottom-color:#eeeeee">
                <h2 style="margin-left:30%;margin-top:-1px; color:#373e4a"> Student Managment  System</h2>
                <a style="color:black;margin-left:90%" href="logout.php"> Logout <img style="width:20px;height:20px" src="css/logout.png" /> </a>
            </div>
			<div style="margin-top:60px"> </div>
			<form class="form-horizontal" method="POST" action="add_course.php" role="form">
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Course Title:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name ="name" placeholder="Course Title">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="cid">Course-no:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name ="cid" placeholder="Enter Course-no">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="credit">Credit:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name = "credit" placeholder="Credit">
      </div>
    </div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="dept">Department:</label>
		<div class="col-sm-6"> 
			<select class="form-control" name = "dept">
				<?php while( $row = mysql_fetch_array($retval)){?>
					 <option> <?php echo $row["name"];?> </option>
				<?php } ?> 
			</select>
		</div>
	</div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="reg" class="btn btn-primary">Register</button>
      </div>
    </div>
  </form>
		</div>
    </div>
</div>
  <?php
	$conn = mysql_connect("localhost","root","");
	date_default_timezone_set("Asia/Dhaka");
	if(isset($_POST['reg'])){
		$name = $_POST['name'];
		$id = $_POST['cid'];
		$credit = $_POST['credit'];
		$dept = $_POST['dept'];
		$sql = "insert into course values ('$id','$name','$dept','$credit')";
		mysql_select_db('student_management_system');
		$retval = mysql_query($sql);
	}		
  ?>
</body>
</html>