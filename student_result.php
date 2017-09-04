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
	function point($mark) {
		if( $mark >= 80 ){
			return 4.00;	
		}
		if( $mark >= 75 ){
			return 3.75;
		}
		if( $mark >= 70 ){
			return 3.50;
		}
		if( $mark >= 65 ){
			return 3.25;	
		}
		if( $mark >= 60 ){
			return 3.00;	
		}
		if( $mark >= 55 ){
			return 2.75;	
		}
		if( $mark >= 50 ){
			return 2.50;	
		}
		if( $mark >= 45 ){
			return 2.25;	
		}
		if( $mark >= 40  ){
			return 2.00;	
		}
		return 0.00;
	}
	function grade($mark) {
		if( $mark >= 80 ){
			return "A+";	
		}
		if( $mark >= 75 ){
			return "A";
		}
		if( $mark >= 70 ){
			return "A-";
		}
		if( $mark >= 65 ){
			return "B+";	
		}
		if( $mark >= 60 ){
			return "B";	
		}
		if( $mark >= 55 ){
			return "B-";	
		}
		if( $mark >= 50 ){
			return "C+";	
		}
		if( $mark >= 45 ){
			return "C";	
		}
		if( $mark >= 40  ){
			return "D";	
		}
		return "F";
	}
		$sql = "select semester_name,semester_year from result where student_id = '$id' group by semester_name,semester_year";
		mysql_select_db('student_management_system');	
		$ret = mysql_query($sql);
		$semester_name = array();
		$semester_year = array();
		while($row  = mysql_fetch_array($ret)){
			$sem = $row["semester_name"];
			$year = $row["semester_year"];
			array_push($semester_name,$sem);
			array_push($semester_year,$year);
		}
	?>
	<div class="container">
		<?php 
			$cum = 0;
			$result = 0;
			$len = count($semester_name);
			for($i = 0; $i < $len; $i++){
				$sem = $semester_name[$i];
				$year = $semester_year[$i];
				$sql = "select * from result where student_id = '$id' and semester_name = '$sem' and semester_year = '$year'";
				mysql_select_db('student_management_system');	
				$ret = mysql_query($sql);
		?>
		<table class="table table-bordered" style="width:900px">
			<thead>
				<tr>
					<th> Semester Name</th> <th>Semester Year </th> <th> Course No </th>
					<th> Attendance </th> <th> Quiz Mark</th> <th> Final Mark</th> 
					<th> Total Mark</th>
					<th> Grade </th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sum = 0;
					$counter = 0;
					while($row = mysql_fetch_array($ret)){
						$total = 0;
						$course = $row["courseno"];
						$attendance = $row["attendance"];
						$quiz = $row["quiz"];
						$final = $row["final_mark"];
						$total = $attendance + $quiz + $final;
						if($total >= 40 ){
							$counter++;
							$sum = $sum + point($total);
							$cum++;
							$result = $result + point($total);
						}
					?>
				<tr><td> <?php echo $sem; ?> </td> <td> <?php echo $year; ?> </td> <td> <?php echo $course; ?> </td> <td> <?php echo $attendance; ?> </td> <td> <?php echo $quiz; ?> </td>
				<td> <?php echo $final; ?> </td> <td> <?php echo $total; ?> </td> <td> <?php echo grade($total); ?> </td>
				</tr>
				<?php } ?>
				<tr> <td> GPA :</td> <td> <?php printf("%0.3f",$sum/$counter); ?> </td> </tr>
				<tr> <td> CGPA :</td> <td> <?php printf("%0.3f",$result/$cum); ?> </td> </tr>
			</tbody>
		</table>
			<?php } ?>
	</div>
</div>
</body>
</html>