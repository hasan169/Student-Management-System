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
<script>
	function func(){
		window.location.href="add_material.php";
	};
	function file_delete(id){
		
		$.ajax({
			type: "POST",
			url: 'file_delete.php',
			data: 'material_id='+id,
			success: function() {
				window.location.href="course_material.php";
			}
		});
	}
</script>
<body>
<?php
	session_start();
	if(!isset($_SESSION["teacher_id"])){
		header("location:index.php");
	}
?>
<div style="width:65%;margin-left:18%;min-height:650px; background-color:#EFFBFB"> 
	<nav  style="background-color:#a7a7a7" class="navbar navbar-default">
		<div  class="container-fluid">
			<ul  class="nav navbar-nav">
				<li><a style="color:white" href="teacher_profile.php">Home</a></li>
				<?php
					$id = $_SESSION["teacher_id"];
					$conn = mysql_connect("localhost","root","");
					$sql = "select * from curr_semester";
					mysql_select_db('student_management_system');	
					$retval = mysql_query($sql);
					$row = mysql_fetch_array($retval);
					$semester = $row["semester_name"];
					$year = $row["semester_year"];
					$sql = "select * from course_teacher where semester_name = '$semester' and semester_year = $year and teacher_id = $id";
					$retval = mysql_query($sql);
				?>
				<li class="dropdown"><a style="color:white" class="dropdown-toggle" data-toggle="dropdown" href="#">Result<span class="caret"></span></a>
					<ul class="dropdown-menu">
					
						<?php
							while($row = mysql_fetch_array($retval)){?>
								<li><a href="result.php?courseno=<?php echo $row["courseno"];?> "><?php echo $row["courseno"];?></a></li>
						<?php	}
						?>
					</ul>
				</li>
				<li><a style="color:white" href="course_material.php">Course Material</a></li>
				<li><a style="color:white" href="logout.php">Log out</a></li>
			</ul>
		</div>
	</nav>
	<button class="btn btn-primary" style="float:right;margin-right:50px" onclick="func()"> Add Material</button>
	<?php
		$sql = "select * from course_material where teacher_id = '$id'";
		mysql_select_db('student_management_system');	
		$retval = mysql_query($sql);
	?>               
	<div style="margin-top:80px"> </div>
  <div class="container" >
		<table class="table table-bordered" style="width:800px;color:#a7a7a7;margin-left:40px" >
			<thead>
				<tr>
					<th>Material Name</th>
					<th>Course No</th>
					<th>Upload Date</th>
					<th> </th>
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
				<tr> <td> <?php echo $name . "." . $type; ?> </td> <td> <?php echo $course; ?> </td> <td> <?php echo $date; ?> </td> <td> <a href="<?php echo $path; ?>" download="<?php echo $name; ?>" > Download</a> </td> <td> <button class="btn btn-primary btn-xs" type="button" onclick="file_delete(<?php echo $material_id; ?>)"> Delete </button> </td> </tr>
				<?php	}
				?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>