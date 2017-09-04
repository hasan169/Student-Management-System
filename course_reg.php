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
	function get_course(){
		var course = document.getElementById("course").value;
		var selector = document.getElementById("teacher");
        var teacher = selector[selector.selectedIndex].id;
		$.ajax({
			type: "POST",
			url: "select_course_teacher.php",
			data: 'course=' + course + '&teacher=' + teacher,
			dataType: "json",
			success: function (data) {
				window.location.href="selectcourse.php";
			}
		}); 
	};
	function sel_teacher(){
		document.getElementById('teacher').options.length = 0;
		var selector = document.getElementById("course");
        var course = selector[selector.selectedIndex].value;
		$.ajax({
			type: "POST",
			url: "getcourseteacher.php",
			data: 'course=' + course,
			dataType: "json",
			success: function (data) {
				for (var i = 0; i < data.length; i = i + 2) { 
					var x = document.getElementById("teacher");
					var option = document.createElement("option");
					option.text = data[i+1];
					option.id = data[i];
					x.add(option);
				}
			}
		});
	};
</script>
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
<div style="width:60%;margin-left:20%;height:650px;background-color:#EFFBFB"> 
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
		$arr = array();
		$sql = "select dept from student where id = '$id' ";
		mysql_select_db('student_management_system');	
		$ret = mysql_query($sql);
		$row = mysql_fetch_array($ret);
		$dept = $row["dept"];
		$sql = "select distinct course.courseno from course_teacher,course where course.courseno = course_teacher.courseno and dept = '$dept' and semester_name ='$semester' and semester_year = $year";
		mysql_select_db('student_management_system');	
		$ret = mysql_query($sql);
		while( $row = mysql_fetch_array($ret)){
			$name = $row["courseno"];
			$flag = true;
			$sql = " select * from prerequisite where courseno = '$name'";
			$retval = mysql_query($sql);
			$flag = true;
			while($num = mysql_fetch_array($retval)){
				$course = $num["precourseno"];
				$sql = "select * from result where student_id = '$id' and courseno = '$course' and (attendance+quiz+final_mark >= 40)";
				$add = mysql_query($sql);
				if( !($a = mysql_fetch_array($add))){
					$flag = false;
					break;
				}
			}
			if( $flag ){
				array_push($arr,$name);
			}
		}
		$temp = array();
		$sql = "select courseno from selected_course where student_id = '$id' and semester_name = '$semester' and semester_year = $year";
		mysql_select_db('student_management_system');	
		$ret = mysql_query($sql);
		while($row = mysql_fetch_array($ret)){
			$course = $row["courseno"];
			array_push($temp,$course);
		}
		$data = array();
		$len = count($arr);
		$length = count($temp);
		for( $i = 0; $i < $len; $i++){
			$course = $arr[$i];
			$flag = true;
			for($j = 0; $j < $length; $j++){
				if($course == $temp[$j]){
					$flag = false;
					break;
				}
			}
			if($flag){
				array_push($data,$course);
			}
		}
		$final_course = array();
		$length = count($data);
		for($i = 0; $i < $length; $i++){
			$name = $data[$i];
			$sql = "select * from result where courseno = '$name' and student_id = '$id' and (attendance+quiz+final_mark) >= 40";
			mysql_select_db('student_management_system');		
			$ret = mysql_query($sql);
			if($row = mysql_fetch_array($ret)){
				
			}
			else{
				array_push($final_course,$data[$i]);
			}
		}							
	?>
	<div class="container" style="margin-left:-20px;margin-top:100px">
		<form class="form-horizontal" action="">
            <div class="form-group">
                <label class="control-label col-sm-2">Semester:</label>
                <div class="col-sm-4">
					<textarea class="form-control" rows="1" readonly><?php echo $semester; ?></textarea>
				</div>
            </div>                
			<div class="form-group">
                <label class="control-label col-sm-2">Year:</label>
                <div class="col-sm-4">
                    <textarea class="form-control" rows="1" readonly><?php  echo $year;?></textarea>
                </div>
            </div>
            <div class="form-group">
				<label class="control-label col-sm-2">Course:</label>
				<div class="col-sm-4">
                    <select class="form-control" onchange="sel_teacher()" id="course">
						<?php
							$len = count($final_course);
							for( $i = 0; $i < $len ;$i++){
								$name = $final_course[$i];
							?>
							<option> <?php echo $name; ?></option>
							<?php }
						?>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Teacher:</label>
                <div class="col-sm-4">
                     <select class="form-control" id="teacher">
					 </select>            
                </div>
            </div>
			</form>
			<div class="form-group">
                <div style="margin-left:180px" class="col-sm-6">
                    <button type="submit" onclick="get_course()" class="btn btn-primary">Register</button>
                </div>
            </div>
		
    </div>                           
</div>
<script>
	sel_teacher();
</script>
</body>
</html>