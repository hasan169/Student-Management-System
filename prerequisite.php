<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
   <script>
	 function func(){
		 window.location.href="add_pre.php";
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
$sql = "select * from prerequisite,course where course.courseno = prerequisite.courseno";
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
			<div style="margin-top:40px"> </div>
			<button class="btn btn-primary" onclick="func()" style="float:right;margin-top:-20px;margin-right:50px"> Add Pre-Requisite </button>
			<div class="container" style="width:950px;height:470px;overflow-y:auto">
				<table class="table table-bordered" style="color:#a7a7a7;margin-top:5px">
					<thead>
						<tr>
							<th>Course No</th>
							<th>Pre-Requisite Course No</th>
							<th>Department</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row = mysql_fetch_array($retval)){
							$name = $row['courseno'];
							$pre = $row['precourseno'];
							$dept = $row['dept'];
						?>		
							<tr><td> <?php echo $name; ?> </td><td> <?php echo $pre; ?> </td><td> <?php echo $dept; ?> </td></tr>
						<?php } ?>
					</tbody>
				</table>	
			</div>
		</div>
    </div>
</div>
</body>
</html>