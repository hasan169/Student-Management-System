<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
</head>
<script>
	function update(id){
		var name = document.getElementById("name").value;
		var des = document.getElementById("des").value;
		$.ajax({
			type: "POST",
			url: 'teacher_details.php',
			data: 'name='+name+'&id='+id+'&des='+des,
			success: function() {
				alert("updated");
			}
		});	
	}
</script>
<body>
<?php
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:index.php");
	}
include 'navbar.php';
$conn = mysql_connect("localhost","root","");
?>
 <div class="container-fluid" style="display:inline">
        <!--This is a comment. Comments are not displayed in the browser-->
    <div class="row">
		<div class="col-md-9">
			<div style="width:100%;height:83px;border-width:1px;border-bottom-style:double;border-bottom-color:#eeeeee">
                <h2 style="margin-left:30%;margin-top:-1px; color:#373e4a"> Student Managment  System</h2>
                <a style="color:black;margin-left:90%" href="logout.php"> Logout <img style="width:20px;height:20px" src="css/logout.png" /> </a>
            </div>
			<div style="margin-top:30px"><div>
	<?php
		$id = $_GET["id"];
		$sql = "select * from teacher where id = $id";
		mysql_select_db('student_management_system');
		$ret = mysql_query($sql);
		$row = mysql_fetch_array($ret);
	?>
  <form class="form-horizontal" method="POST" action="add_teacher.php" role="form">
	<div class="form-group" style="margin-left:100px">
      <label class="control-label col-sm-2" for="sid">Teacher ID:</label>
      <div class="col-sm-6">
        <textarea  class="form-control" rows="1" readonly><?php echo $row["id"];?></textarea>
      </div>
    </div>
	<div class="form-group" style="margin-left:100px">
      <label class="control-label col-sm-2" for="name">Full Name:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id ="name" value="<?php echo $row["name"];?>">
      </div>
    </div>
	<div class="form-group" style="margin-left:100px">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-6">
		<textarea  class="form-control" rows="1" readonly><?php echo $row["email"];?></textarea>
      </div>
    </div>
	<div class="form-group" style="margin-left:100px">
		<label class="control-label col-sm-2" for="dept">Department:</label>
		<div class="col-sm-6"> 
			<textarea  class="form-control" rows="1" readonly><?php echo $row["dept"];?></textarea>
		</div>
	</div>
	<div class="form-group" style="margin-left:100px">
		<label class="control-label col-sm-2" for="desig">Designation:</label>
		<div class="col-sm-6"> 
			<select class="form-control" id = "des">
				<option> <?php echo $row["designation"];?> </option>
				<option>Lecturer</option>
				<option>Assistant Professor</option>
				<option>Associate Professor</option>
				<option>Professor</option>
			</select>
		</div>
	</div>
	</form>
    <div class="form-group" style="margin-left:100px">
      <div class="col-sm-offset-2 col-sm-10">
        <button  onclick="update(<?php echo $id;?>)" class="btn btn-primary">Update</button>
      </div>
    </div>
		
		</div>
    </div>
</div>
</body>
</html>

