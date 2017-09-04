<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet"> 
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<script>
	function update(){
		var name = document.getElementById("name").value;
		var year = document.getElementById("year").value;
		$.ajax({
			type: "POST",
			url: 'update_semester.php',
			data: 'name='+name+'&year='+year,
			success: function() {
				alert("updated");
			}
		});	
	};
</script>
<body>
<?php
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:index.php");
	}
	include 'navbar.php';
	$conn = mysql_connect("localhost","root","");	
	$sql = "select *  from curr_semester";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
	$sem = "";
	$year = "";
	while( $row = mysql_fetch_array($retval)){
		$sem = $row["semester_name"];
		$year = $row["semester_year"];
	}
?>
 <div class="container-fluid" style="display:inline">
        <!--This is a comment. Comments are not displayed in the browser-->
    <div class="row">
		<div class="col-md-9">
			<div style="width:100%;height:83px;border-width:1px;border-bottom-style:double;border-bottom-color:#eeeeee">
                <h2 style="margin-left:30%;margin-top:-1px; color:#373e4a"> Student Managment  System</h2>
                <a style="color:black;margin-left:90%" href="logout.php"> Logout <img style="width:20px;height:20px" src="css/logout.png" /> </a>
            </div>
			<div style="margin-top:60px"> </div>
	<form class="form-horizontal"  role="form">
	  <div class="form-group">
		<label class="control-label col-sm-2" for="name">Semester Name:</label>
      <div class="col-sm-6">
		<select class="form-control" id = "name">
				<option><?php echo $sem;?></option>
				<option>Fall</option>
				<option>Spring</option>
				<option>Summer</option>
		</select>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="year">Semester Year:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id ="year" value="<?php echo $year;?>">
      </div>
    </div>
  </form>
	 <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-primary" onclick="update()" > Update</button>
		</div>
    </div>
		</div>
	</div>
 </div>
</body>
</html>