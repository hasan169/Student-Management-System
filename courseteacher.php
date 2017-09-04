<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
   <script>
	 function func(){
		 window.location.href="add_courseteacher.php";
	 };
	 function update(ob){
		 window.location.href="update_courseteacher.php?id="+ ob.id + "&course=" + ob.name ;
	 };
   </script>
</head>
<body>
<?php
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:index.php");
	}
include 'navbar.php';
$conn = mysql_connect("localhost","root","");
$sql = "select * from advising";
mysql_select_db('student_management_system');
$ret = mysql_query($sql);
$sem = "";
$year = 0;
if($row = mysql_fetch_array($ret)){
	$sem = $row["semester_name"];
	$year = $row["semester_year"];
}
$sql = "select * from course_teacher,teacher where semester_name = '$sem' and semester_year = $year and teacher.id = course_teacher.teacher_id ";
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
			<div style="margin-top:40px"> </div>
			<button class="btn btn-primary" onclick="func()" style="float:right;margin-top:-20px;margin-right:50px">Add Course Teacher</button>
			<div class="container" style="width:950px;height:470px;overflow-y:auto">
				<table class="table table-bordered" style="color:#a7a7a7;margin-top:10px">
					<thead>
						<tr>
							<th>Semester Name</th>
							<th>Semester Year</th>
							<th>Teacher Name</th>
							<th>Course No</th>
							<th>Total Seat</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row = mysql_fetch_array($retval)){
							$name = $row['name'];
							$courseno = $row['courseno'];
							$total = $row['total_seat'];
							$id = $row["id"];
						?>		
							<tr><td> <?php echo $sem; ?> </td><td> <?php echo $year; ?> </td><td> <?php echo $name; ?> </td><td> <?php echo $courseno;?> </td><td> <?php echo $total;?></td> <td> <button class="btn btn-primary btn-xs" id="<?php echo $id; ?>" name="<?php echo $courseno; ?>" onclick="update(this)"> Details</button> </td></tr>
						<?php } ?>
					</tbody>
				</table>	
			</div>
		</div>
    </div>
</div>
</body>
</html>
