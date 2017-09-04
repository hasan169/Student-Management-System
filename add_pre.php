<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
</head>
<script type='text/javascript'>
	function sel_course(){
		document.getElementById('crse').options.length = 0;
		document.getElementById('pre').options.length = 0;
		var selector = document.getElementById("de");
        var dept = selector[selector.selectedIndex].value;
		$.ajax({
			type: "POST",
			url: "getcourse.php",
			data: 'dept=' + dept,
			dataType: "json",
			success: function (data) {
				for (var i = 0; i < data.length; i++) { 
					var x = document.getElementById("crse");
					var y = document.getElementById("pre");
					var option = document.createElement("option");
					option.text = data[i];
					x.add(option);
					var option2 = document.createElement("option");
					option2.text = data[i];
					y.add(option2);
				}
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
	$sql = "select * from department";
	mysql_select_db('student_management_system');
	$retval = mysql_query($sql);
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
			<form class="form-horizontal" method="POST" action="add_pre.php" role="form">
  	<div class="form-group">
		<label class="control-label col-sm-2" for="dept">Department:</label>
		<div class="col-sm-6"> 
			<select id = "de" class="form-control" name = "dept" onchange="sel_course()">
				<?php while( $row = mysql_fetch_array($retval)){?>
						<option> <?php echo $row["name"];?> </option>
				<?php } ?> 
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="">Course No:</label>
		<div class="col-sm-6"> 
			<select id = "crse" class="form-control" name = "course">
				
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="">Pre-Requisite Course NO:</label>
		<div class="col-sm-6"> 
			<select id = "pre" class="form-control" name="prereq">
			</select>
		</div>
	</div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="reg" class="btn btn-primary">Register</button>
      </div>
    </div>
  </form>
		</div>
    </div>
</div>
<script> sel_course(); </script>
<?php
	$conn = mysql_connect("localhost","root","");
	if(isset($_POST['reg'])){
		$course = $_POST['course'];
		$pre = $_POST['prereq'];
		$sql = "insert into prerequisite values ('$course','$pre')";
		mysql_select_db('student_management_system');
		$retval = mysql_query($sql);
	}		
?>
</body>
</html>