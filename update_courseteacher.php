<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
</head>
<script type='text/javascript'>
	function update(id){
		var total = document.getElementById("seat").value;
		var course = document.getElementById("course").value;
		$.ajax({
			type: "POST",
			url: "courseteacher_details.php",
			data: 'id=' + id + '&course='+course+'&seat='+total,
			success: function () {
				alert("updated");
			}
		});
	};
</script>
<body>
<?php
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:index.php");
	}
	include 'navbar.php';
	$id = $_GET["id"];
	$courseno = $_GET["course"];
	$conn = mysql_connect("localhost","root","");
	mysql_select_db('student_management_system');
	$sql = "select * from advising";
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$sem = $row["semester_name"];
	$year = $row["semester_year"];
	$sql = "select name from teacher where id = $id";
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$name = $row["name"];
	$sql = "select total_seat from course_teacher where semester_name = '$sem' and semester_year = $year and courseno = '$courseno' and teacher_id = $id";
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$total = $row["total_seat"];
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
			<form class="form-horizontal" role="form">
	<div class="form-group">
      <label class="control-label col-sm-2">Semester Name:</label>
      <div class="col-sm-6">
        <textarea id= "semester" class="form-control" rows="1" readonly> <?php echo $sem; ?> </textarea>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2">Semester Year:</label>
      <div class="col-sm-6">
        <textarea id="year" class="form-control" rows="1" readonly> <?php echo $year; ?> </textarea>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2">Name:</label>
      <div class="col-sm-6">
        <textarea class="form-control" rows="1" readonly> <?php echo $name; ?> </textarea>
      </div>
    </div>
	<div class="form-group">
		<label class="control-label col-sm-2" >Course NO:</label>
		<div class="col-sm-6"> 
			  <textarea class="form-control" rows="1" id="course" readonly> <?php echo $courseno; ?> </textarea>
		</div>
	</div>
	<div class="form-group">
      <label class="control-label col-sm-2">Total Seat:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id ="seat" value = "<?php echo $total; ?>">
      </div>
    </div>
	  </form>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button class="btn btn-primary" onclick="update(<?php echo $id; ?>)">Update</button>
      </div>
    </div>
		</div>
    </div>
</div>
</body>
</html>

