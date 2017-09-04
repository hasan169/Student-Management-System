<!DOCTYPE html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/dropdown.js"></script>
<html>
<head>
    <title></title>
</head>
<body>
<?php
	session_start();
	if(!isset($_SESSION["student_id"])){
		header("location:index.php");
	}
	$conn = mysql_connect("localhost","root","");
	$sid = $_SESSION["student_id"];
	$sql = "select * from curr_semester";
	mysql_select_db('student_management_system');	
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$semester = $row["semester_name"];
	$year = $row["semester_year"];
	$sql = "select teacher_id,courseno from selected_course where student_id = '$sid' and semester_name = '$semester' and semester_year = $year";
	$retval = mysql_query($sql);
?>
<div style="background-color:#EFFBFB; min-height:650px; color:#a7a7a7;width:70%;margin-left:17%"> 
	<nav  style="background-color:#a7a7a7" class="navbar navbar-default">
		<div  class="container-fluid">
			<ul  class="nav navbar-nav">
				<li><a style="color:white" href="student.php">Home</a></li>
				<li><a style="color:white" href="selectcourse.php">Advising</a></li>
				<li><a style="color:white" href="student_result.php">Result</a></li>
				<li class="dropdown"><a style="color:white" class="dropdown-toggle" data-toggle="dropdown" href="#">Course Material<span class="caret"></span></a>
					<ul class="dropdown-menu">
					
						<?php
							while($row = mysql_fetch_array($retval)){?>
								<li><a href="show_material.php?teacher_id=<?php echo $row["teacher_id"];?> "><?php echo $row["courseno"];?></a></li>
						<?php	}
						?>
					</ul>
				</li>
				<li><a style="color:white" href="logout.php">Log out</a></li>
			</ul>
		</div>
	</nav>
	
	<?php
		$id = $_GET["teacher_id"]; 
		$sql = "select * from course_material where teacher_id = '$id'";
		mysql_select_db('student_management_system');	
		$retval = mysql_query($sql);
	?>               
	<div style="margin-top:80px"> </div>
  <div class="container">
	<table class="table table-bordered" style="width:800px;color:#a7a7a7;margin-left:70px" >
		<thead>
			<tr>
				<th>Material Name</th>
				<th>Course No</th>
				<th>Upload Date</th>
				<th> </th>
			</tr>
		</thead>
		<tbody>
			<?php
				while($row = mysql_fetch_array($retval)){
					$type = $row["file_type"];
					$material_id = $row["material_id"];
					$course = $row["courseno"];
					$name = $row["name"];
					$date = $row["upload_date"];
					$path = "./upload/" .$id . "t" . $material_id . "." . $type; 
			?>
			<tr> <td> <?php echo $name; ?> </td> <td> <?php echo $course; ?> </td> <td> <?php echo $date; ?> </td> <td> <a href="<?php echo $path; ?>" download="<?php echo $name; ?>" > Download</a> </td></tr>
			<?php	}
			?>
		</tbody>
  </table>
</div>

</div>
</body>
</html>
