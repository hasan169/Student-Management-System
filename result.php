<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
   <script src="js/dropdown.js"></script>
</head>
<script>
	function grade( mark ){
		if( mark >= 80 ){
			return "A+";	
		}
		if( mark >= 75 ){
			return "A";
		}
		if( mark >= 70 ){
			return "A-";
		}
		if( mark >= 65 ){
			return "B+";	
		}
		if( mark >= 60 ){
			return "B";	
		}
		if( mark >= 55 ){
			return "B-";	
		}
		if( mark >= 50 ){
			return "C+";	
		}
		if( mark >= 45 ){
			return "C";	
		}
		if( mark >= 40  ){
			return "D";	
		}
		return "F";
	}
	function save(){
		var total = document.getElementById("res-table").rows.length;
		for(var i = 1; i < total; i++){
			var id = document.getElementById("res-table").rows[i].cells[0].innerHTML;
			var id1 = id + "1";
			var id2 = id + "2";
			var id3 = id + "3";
			var id4 = id + "4";
			var id5 = id + "5";
			var attendance = parseFloat(document.getElementById(id1).value);
			var quiz = parseFloat(document.getElementById(id2).value);
			var final_mark = parseFloat(document.getElementById(id3).value);
			var total = parseFloat(attendance + quiz + final_mark);
			document.getElementById(id4).innerHTML = total;
			document.getElementById(id5).innerHTML = grade(total);
			$.ajax({
				type: "POST",
				url: 'insertresult.php',
				data: 'id='+id+'&attendance='+attendance+'&quiz=' + quiz+'&final=' + final_mark,
				success: function() {}
			});
		}
	};
</script>
<body>
<?php
	session_start();
	if(!isset($_SESSION["teacher_id"])){
		header("location:index.php");
	}
?>
<div style="background-color:#EFFBFB;width:65%;margin-left:18%"> 
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
					$sem = trim($row["semester_name"]);
					$year = $row["semester_year"];
					$sql = "select * from course_teacher where semester_name = '$sem' and semester_year = $year and teacher_id = $id";
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
	function cal_grade($mark) {
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
			return "C+";	
		}
		if( $mark >= 50 ){
			return "C";	
		}
		if( $mark >= 45 ){
			return "C-";	
		}
		if( $mark >= 40  ){
			return "D";	
		}
		return "F";
	}
	$courseid = trim($_GET['courseno']);
	$sql = "select result.student_id as id,attendance,quiz,final_mark from result,selected_course where selected_course.student_id = result.student_id and selected_course.semester_name = '$sem' and selected_course.semester_year = $year and selected_course.courseno = '$courseid' and result.courseno = '$courseid' and teacher_id = '$id'";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
?>
<form class="form-horizontal">
    <div>
        <table id = "res-table" style="color:#a7a7a7" class="table table-bordered table-striped table-highlight">
            <thead>
                <th>Student ID</th>
                <th>Attendance (10)</th>
                <th>Quiz (20)</th>
                <th>Final (70)</th>
                <th>Total (100)</th>
                <th>Grade</th>
            </thead>
            <tbody>
				<?php 
					while($row = mysql_fetch_array($retval)){
						$total = $row['attendance'] + $row['quiz'] + $row['final_mark'];
						$id1 = $row["id"] . "1";
						$id2 = $row["id"] . "2";
						$id3 = $row["id"] . "3";
						$id4=  $row["id"] . "4";
						$id5=  $row["id"] . "5";
				?>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><input id="<?php echo $id1; ?>" type="text" class="form-control" value="<?php echo $row['attendance'];?>" /> </td>
                    <td><input id="<?php echo $id2; ?>" type="text" class="form-control" value="<?php echo $row['quiz'];?>"  /> </td>
                    <td><input id="<?php echo $id3; ?>" type="text" class="form-control" value="<?php echo $row['final_mark'];?>" /></td>
                    <td id="<?php echo $id4; ?>"><?php echo $total;?></td>
					<td id="<?php echo $id5; ?>"><?php echo cal_grade($total); ?></td>
                </tr>
					<?php } ?>
            </tbody>
        </table>
		  <button onclick="save()" type="button" class="btn btn-primary btn-block">SAVE</button>
    </div>
</form>
</div>
	<?php
		$_SESSION['course'] = $courseid;
	?>
</body>
</html>