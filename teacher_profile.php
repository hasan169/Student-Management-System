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
	if(!isset($_SESSION["teacher_id"])){
		header("location:index.php");
	}
?>
<div style="width:65%;margin-left:18%"> 
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
	<?php
		$name = "";
		$email = "";
		$dept = "";
		$conn = mysql_connect("localhost","root","");
		$sql = "select * from teacher where id = '$id'";
		mysql_select_db('student_management_system');	
		$retval = mysql_query($sql);
		while($row = mysql_fetch_array($retval)){
			$id = $row["id"];
			$name = $row["name"];
			$email = $row["email"];
			$dept = $row["dept"];
			$des = $row["designation"];
		}
	?>
	<div class="container" style="margin-top:-20px; height:650px;width:100%;background-color:#EFFBFB">
		<h3> Teacher Profile:</h3>
		<form class="form-horizontal" action="" style="margin-left:100px;margin-top:100px">
            <div class="form-group">
                <label class="control-label col-sm-2">Teacher Id:</label>
                <div class="col-sm-6">
					<textarea class="form-control" rows="1" readonly><?php echo $id; ?></textarea>
				</div>
            </div>                
			<div class="form-group">
                <label class="control-label col-sm-2">Name:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" rows="1" readonly><?php  echo $name;?></textarea>
                </div>
            </div>
            <div class="form-group">
				<label class="control-label col-sm-2">Department:</label>
				<div class="col-sm-6">
                    <textarea class="form-control" rows="1" readonly><?php echo $dept;?></textarea>
                </div>
            </div>
			 <div class="form-group">
				<label class="control-label col-sm-2">Designation:</label>
				<div class="col-sm-6">
                    <textarea class="form-control" rows="1" readonly><?php echo $des;?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Email:</label>
                <div class="col-sm-6">
                     <textarea class="form-control" rows="1" readonly><?php echo $email;?></textarea>             
                </div>
            </div>
		</form>
    </div>                           
</div>
</body>
</html>