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
?>
 <div class="container-fluid" style="display:inline">
        <!--This is a comment. Comments are not displayed in the browser-->
    <div class="row">
		<div class="col-md-9">
			<div style="margin-top:5px"> </div>
			<div class="container">
				<form style="float:right;margin-right:165px" class="navbar-form" role="search" method="POST">
					<div  class="input-group">
						<input type="text" class="form-control" placeholder="Search" name="id">
						<div class="input-group-btn">
							<button class="btn btn-default" type="submit" name ="search"><img src="css/search.png" style="width:20px;height:17px" /></button>
						</div>
					</div>
				</form>
			</div>
			<div class="container" style="height:570px;overflow-y:auto">
				<?php
					if(isset($_POST['search'])){
						$flag = false;
						$conn = mysql_connect("localhost","root","");
						$id = $_POST["id"];
						$sql = "select semester_name,semester_year from result where student_id = '$id' group by semester_name,semester_year";
						mysql_select_db('student_management_system');		
						$ret = mysql_query($sql);
						$semester_name = array();
						$semester_year = array();
						while($row  = mysql_fetch_array($ret)){
							$flag = true;
							$sem = $row["semester_name"];
							$year = $row["semester_year"];
							array_push($semester_name,$sem);
							array_push($semester_year,$year);
						}
						if($flag){
							$sql = "select * from student where id = '$id'";
							mysql_select_db('student_management_system');	
							$ret = mysql_query($sql);
							$row = mysql_fetch_array($ret);
							$name = $row["name"];
							$dept = $row["dept"];
							$sql = "select sum(credit) as tot from course,result where student_id  = '$id' and course.courseno = result.courseno and (attendance+quiz+final_mark) >= 40";
							mysql_select_db('student_management_system');	
							$ret = mysql_query($sql);
							$row = mysql_fetch_array($ret);
							
						?>
							<table class="table table-bordered" style="width:500px;color:#a7a7a7;margin-left:40px">
								<tbody>
									<tr> <td> Student Id: </td>  <td> <?php echo $id ?></td></tr>
									<tr> <td> Student Name: </td>  <td> <?php echo $name; ?></td></tr>
									<tr> <td> Department: </td>  <td> <?php echo $dept; ?></td></tr>
									<tr> <td>  Credit Completed: </td>  <td> <?php echo $row['tot']; ?></td></tr>
								</body>
							</table>
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
						<table class="table table-bordered" style="margin-top:5px;margin-left:40px;color:#a7a7a7; width:900px">
							<thead>
								<tr><th> Semester Name</th> <th>Semester Year </th> <th> Course No </th>
									<th> Attendance </th> <th> Quiz Mark</th> <th> Final Mark</th> 
									<th> Total Mark</th><th> Grade </th></tr>
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
									<td> <?php echo $final; ?> </td> <td> <?php echo $total; ?> </td> <td> <?php echo grade($total); ?> </td></tr>
								<?php } ?>
								<tr> <td> GPA :</td> <td> <?php printf("%0.3f",$sum/$counter); ?> </td> </tr>
								<tr> <td> CGPA :</td> <td> <?php printf("%0.3f",$result/$cum); ?> </td> </tr>
								</tbody>
							</table>
					<?php	}
					}
					else{
						echo "<h3> No Student Found</h3>";
					}
				}
			?>
			</div>
		</div>
    </div>
</div>
</body>
</html>