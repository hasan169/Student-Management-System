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
		 window.location.href="add_teacher.php";
	 };
	 function update(id){
		 window.location.href="update_teacher.php?id="+ id ;
	 };
   </script>
</head>
<body>
<?php
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:index.php");
	}
	if(!isset($_POST['course'])){
		header("location:index.php");
	}
	include 'navbar.php';
	$conn = mysql_connect("localhost","root","");
	$course = $_POST['course'];
	$semester = $_POST['semester'];
	$dept = $_POST['dept'];
	$year = $_POST['year'];
	$sql = "select student_id,student.name as sname,teacher.name tname from selected_course,student,teacher where student_id = student.id and teacher_id = teacher.id and courseno = '$course' and semester_name = '$semester' and semester_year = $year";
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
			<div class="container" style="width:950px;height:470px;overflow-y:auto">
				<table class="table table-bordered" style="color:#a7a7a7;margin-top:5px">
					<thead>
						<tr>
							<th>Department</th>
							<th>Course No</th>
							<th>Teacher Name</th>
							<th>Student Id</th>
							<th>Student Name</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row = mysql_fetch_array($retval)){
							$tname = $row['tname'];
							$sid = $row['student_id'];
							$sname = $row['sname'];
						?>		
							<tr><td> <?php echo $dept; ?> </td><td> <?php echo $course; ?> </td><td> <?php echo $tname; ?> </td><td> <?php echo $sid;?> </td> <td> <?php echo $row['sname']; ?>  </td></tr>
						<?php } ?>
					</tbody>
				</table>	
			</div>
		</div>
    </div>
</div>
</body>
</html>