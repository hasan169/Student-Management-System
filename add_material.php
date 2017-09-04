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
<div style="width:65%;margin-left:18%;background-color:#EFFBFB;min-height:650px"> 
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
		$sql = "select * from course_teacher where semester_name = '$semester' and semester_year = $year and teacher_id = $id";
		$retval = mysql_query($sql);
	?>
	<div class="container" style="margin-top:100px">
		<form action="add_material.php" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label col-sm-2" for="">Course No:</label>
				<div class="col-sm-6"> 
					<select class="form-control" name ="course"/>
						<?php
							while($row = mysql_fetch_array($retval)){
								$course = $row["courseno"];
						?>
						<option> <?php echo $course; ?> </option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="">Name:</label>
				<div class="col-sm-6"> 
					<input type="text" class="form-control" name ="material_name"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="">Upload File:</label>
				<div class="col-sm-6"> 
					<input type="file" class="form-control" name="file">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for=""></label>
				<div class="col-sm-6"> 
					<input type="submit" class="btn btn-primary" value="Upload File" name="save">
				</div>
			</div>
		</form>
	</div>
</div>
<?php
	if(isset($_POST['save'])){
		$course = $_POST['course'];
		$name = $_POST['material_name'];
		$allowedExts = array("pdf", "doc", "docx", "txt");
		$extension = end(explode(".", $_FILES["file"]["name"]));
		if ( ($_FILES["file"]["type"] == "text/plain") ||  ($_FILES["file"]["type"] == "application/pdf") || ($_FILES["file"]["type"] == "application/msword") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES["file"]["size"] < 20000000) && in_array($extension, $allowedExts)){
			if ($_FILES["file"]["error"] > 0){}
			else{
				$type = "";
				for( $i = 0; $i < 4; $i++){
					if($extension == $allowedExts[$i]){
						$type =  $allowedExts[$i];
						break;
					}
				}					
				$material_id = 1;
				$sql = "select max(material_id) as id from course_material where teacher_id = '$id'";
				mysql_select_db('student_management_system');
				$ret = mysql_query($sql);
				if($row = mysql_fetch_array($ret)){
					$material_id  = $row['id'];
					$material_id = $material_id + 1;
				}
				date_default_timezone_set("Asia/Dhaka");
				$sql = "insert into course_material values ($material_id,'$id','$course',CURDATE(),'$name','$type')";
				$ret = mysql_query($sql);
				move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" .$id ."t" . $material_id ."." . $type);
			}
		}
	}
?>
</body>
</html>