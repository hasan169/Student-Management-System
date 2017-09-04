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
	function approve(ob){
		$.ajax({
				type: "POST",
				url: 'approval.php',
				data: 'id='+ob.id
			});
			var tbl = document.getElementById(ob.id);
			tbl.innerHTML = "Approved";
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
$sql = "select * from student where approval = 'no'";
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
			<div class="container" style="width:950px;height:470px;overflow-y:auto">
				<table class="table table-bordered" style="color:#a7a7a7">
					<thead>
						<tr>
							<th>Student Name</th>
							<th>Student ID</th>
							<th>Email</th>
							<th>Department</th>
							<th>Approval</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row = mysql_fetch_array($retval)){
							$name = $row['name'];
							$id = $row['id'];
							$dept = $row['dept'];
							$email = $row['email'];
						?>		
							<tr><td> <?php echo $name; ?> </td><td> <?php echo $id; ?> </td><td> <?php echo $email; ?> </td><td> <?php echo $dept;?> </td>
							<td> <button id = "<?php echo "$id"; ?>"  onclick="approve(this)" type="button" class="btn btn-primary btn-xs">Approve</button></td></tr>
						<?php } ?>
					</tbody>
				</table>	
			</div>
		</div>
    </div>
</div>
</body>
</html>