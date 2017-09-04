<!DOCTYPE html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/dropdown.js"></script>
<?php
	session_start();
	if(!isset($_SESSION["student_id"])){
		header("location:index.php");
	}
	$conn = mysql_connect("localhost","root","");
	mysql_select_db('student_management_system');	
	$sql = "select * from advising";
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	date_default_timezone_set("Asia/Dhaka");
	$date = new DateTime();
	$date =  $date->format('y-m-d');
	$date1=date_create($date);
	$date2=date_create($row["starting_date"]);
	$diff=date_diff($date2,$date1);
	$first =  $diff->format("%R%a days");
	$date2=date_create($row["ending_date"]);
	$diff=date_diff($date2,$date1);
	$second =  $diff->format("%R%a days");
	if( !($first >=0 && $second <= 0)){
		header('location:student.php');
	}
?>
<html>
<head>
    <title></title>
</head>
<script>
	function func(){
		$.ajax({
			type: "POST",
			url: "check.php",
			dataType: "json",
			success: function (data) {
				if( data < 5){
					window.location.href = "course_reg.php";
				}
				else{
					alert("You have already taken Five Course");
				}
			}
		}); 
	
	};
</script>
<body>
<?php
	$conn = mysql_connect("localhost","root","");
	$id = $_SESSION["student_id"];
	$sql = "select * from curr_semester";
	mysql_select_db('student_management_system');	
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
	$semester = $row["semester_name"];
	$year = $row["semester_year"];
	$sql = "select teacher_id,courseno from selected_course where student_id = '$id' and semester_name = '$semester' and semester_year = $year";
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
		$sql = "select * from advising";
		mysql_select_db('student_management_system');	
		$ret = mysql_query($sql);
		$row = mysql_fetch_array($ret);
		$semester = $row["semester_name"];
		$year = $row["semester_year"];
		$sql = "select courseno,name from selected_course,teacher where student_id = '$id' and teacher.id = selected_course.teacher_id and semester_name = '$semester' and semester_year = $year";
		$conn = mysql_connect("localhost","root","");
		mysql_select_db('student_management_system');	
		$retval = mysql_query($sql);
	?>
	<button style="float:right;margin-right:120px" onclick="func()" class="btn btn-primary"> ADD New Course </button>
	<div class="container">
		<table class="table table-bordered" style="margin-top:50px;width:700px;margin-left:120px;color:#a7a7a7">
			<thead>
				<tr>
					<th> semester Name</th> <th> semester Year </th> <th> Course no </th> <th> Teacher </th>
				</tr>
			</thead>
			<tbody>
				<?php
					while( $row = mysql_fetch_array($retval)){?>
					<tr> <th> <?php echo $semester; ?> </th> <th> <?php echo $year; ?> </th>  <th> <?php echo $row["courseno"];?></th> <th> <?php echo $row['name'];?></th> </tr>
				<?php 
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<script>
	sel_teacher();
</script>
</body>
</html>