<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
   <script>
	function sel_course(){
		document.getElementById('course').options.length = 0;
		var selector = document.getElementById("dept");
        var dept = selector[selector.selectedIndex].value;
		selector = document.getElementById("semester");
        var semester = selector[selector.selectedIndex].value;
		selector = document.getElementById("year");
        var year = selector[selector.selectedIndex].value;
		$.ajax({
			type: "POST",
			url: "taken_course.php",
			data: 'dept=' + dept + '&semester=' + semester + "&year=" + year,
			dataType: "json",
			success: function (data) {
				for (var i = 0; i < data.length; i++) { 
					var x = document.getElementById("course");
					var option = document.createElement("option");
					option.text = data[i];
					x.add(option);
				}
			}
		});
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
	$sql = "select * from department";
	mysql_select_db('student_management_system');
	$dept = mysql_query($sql);
	$sql = "select distinct semester_name  from semester";
	mysql_select_db('student_management_system');
	$sem = mysql_query($sql);
	$sql = "select distinct semester_year  from semester";
	mysql_select_db('student_management_system');
	$year = mysql_query($sql);
?>
 <div class="container-fluid" style="display:inline">
        <!--This is a comment. Comments are not displayed in the browser-->
    <div class="row">
		<div class="col-md-9">
			<div style="width:100%;height:83px;border-width:1px;border-bottom-style:double;border-bottom-color:#eeeeee">
                <h2 style="margin-left:30%;margin-top:-1px; color:#373e4a"> Student Managment  System</h2>
                <a style="color:black;margin-left:90%" href="logout.php"> Logout <img style="width:20px;height:20px" src="css/logout.png" /> </a>
            </div>
			<div style="margin-top:50px"> </div>
		<form class="form-horizontal" style="margin-left:50px" method="POST" action="get_student.php" role="form">
			<div class="form-group">
				<label class="control-label col-sm-2">Semester Name:</label>
				<div class="col-sm-6">
					<select class="form-control" name="semester" id="semester" onchange="sel_course()">
						<?php
							while($row = mysql_fetch_array($sem)){
								$name = $row["semester_name"];
							?>
							<option><?php echo $name;  ?> </option> 
						<?php	}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" >Semester Year:</label>
				<div class="col-sm-6">
					<select class="form-control" name="year" id="year" onchange="sel_course()">
						<?php
							while($row = mysql_fetch_array($year)){
								$name = $row["semester_year"];
							?>
							<option><?php echo $name;  ?> </option> 
						<?php	}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="name">Department:</label>
				<div class="col-sm-6">
					 <select class="form-control" name="dept" id="dept" onchange="sel_course()">
						<?php
							while($row = mysql_fetch_array($dept)){
								$name = $row["name"];
							?>
							<option><?php echo $name;  ?> </option> 
						<?php	}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="year">Course No:</label>
				<div class="col-sm-6">
					<select class="form-control" id="course" name="course">
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary"> Show </button>
				</div>
			</div>
		</form>
	</div>
   </div>
</div>	
	<script>
		sel_course();
	</script>
</body>
</html>