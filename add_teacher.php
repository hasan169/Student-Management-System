<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet"> 
</head>
<script src="js/jquery.min.js"></script>
<script>
	function ufunc(str){
		document.getElementById("ln").innerHTML = str;
		document.getElementById("ln").style.visibility = "visible";		
	};
	function wfunc( str ){
		document.getElementById("lpwd").innerHTML = str;
		document.getElementById("lpwd").style.visibility = "visible";
	};
	function idfunc(){
		document.getElementById("lid").innerHTML = "Invalid Teacher ID";
		document.getElementById("lid").style.visibility = "visible";
	};
	function func(){
		document.getElementById("ln").style.visibility = "hidden";
		document.getElementById("lid").style.visibility = "hidden";
		document.getElementById("le").style.visibility = "hidden";
		document.getElementById("lpwd").style.visibility = "hidden";
		document.getElementById("lrpwd").style.visibility = "hidden";
		document.getElementById("success").style.visibility = "hidden";
		var username = document.getElementById("name").value;
		username = username.trim();
		if( username.length < 4 ){
			ufunc("name should be at least 4 characters");
		}
		else{
			var flag = true;
			for(  var  i = 0; i < username.length; i++){
				if ( !((username[i] >= 'a' && username[i] <= 'z') || (username[i] >= 'A' && username[i] <= 'Z') || username[i] ==' ')){
					flag = false;
					break;
				}
			}
			if( !flag){
				ufunc("only 'a'.. 'z', 'A'... 'Z'  and space are allowed");
			}
			else{
				var sid = document.getElementById("sid").value;
				var flag = true;
				var str;
				for(  var  i = 0; i < sid.length; i++){
					if ( !(sid[i] >= '0' && sid[i] <= '9')){
						flag = false;
						break;
					}
				}
				if( !flag){
					idfunc();
				}
				else{
					var user_mail = document.getElementById("email").value;
					$.ajax({
						type: "POST",
						url: 'passmail.php',
						data: 'em='+user_mail,
						success: function(result) {
							if( result === "true"){
								document.getElementById("le").style.visibility = "visible";
							}
							else{
								var pass = document.getElementById("pwd").value;
								var flag = false;
								for( var  i = 0 ; i < pass.length; i++){
									if(!((pass[i] >= 'a' && pass[i] <= 'z') || (pass[i] >= 'A' && pass[i] <= 'Z') || (pass[i] >= '0' && pass[i] <= '9') || pass[i] == '_' || pass[i] == ' ' || pass[i] == '.' || pass[i] == ',')){
										flag = true;
										break;
									}
								}
								if( flag ){
									wfunc("'a'...'z' , 'A'...'Z' , '0'...'9'  , '_' , comma,dot are allowed");
								}
								else if(pass.length < 6 ){
									wfunc("password should be at least 6 characters in length");
								}
								else{
									var repass = document.getElementById("rpwd").value;
									if( pass != repass ){
										document.getElementById("lrpwd").style.visibility = "visible";
									}
									else{
										var dept = document.getElementById("dept").value;
										var des = document.getElementById("desig").value;
										$.ajax({
											type: "POST",
											url: 'teacher_reg.php',
											data: 'name='+username+'&email='+user_mail+'&pass='+pass+'&id='+sid+'&dept='+dept+'&desig=' + des,
											success: function() {
												document.getElementById("name").value = "";
												document.getElementById("email").value ="";
												document.getElementById("pwd").value ="";
												document.getElementById("rpwd").value = "";
												document.getElementById("sid").value = "";
												document.getElementById("success").style.visibility = "visible";
											}
										});							
									}
								}
							}
						}				
					});
				}			
			}
		}
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
			<div style="margin-top:30px"><div>
  <form class="form-horizontal" method="POST" action="add_teacher.php" role="form">
    <div class="form-group" style="margin-left:50px">
      <label class="control-label col-sm-2" >Full Name:</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" id ="name" placeholder="Enter Full Name">
      </div>
	  <label id="ln" class="control-label col-sm-4" style="visibility:hidden; margin-left:-20px"></label>
    </div>
	<div class="form-group" style="margin-left:50px">
      <label class="control-label col-sm-2" >Teacher ID:</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" id ="sid" placeholder="Enter Teacher Id">
      </div>
	  <label id="lid" class="control-label col-sm-2" style="visibility:hidden;margin-left:-20px"></label>
    </div>
	<div class="form-group" style="margin-left:50px">
      <label class="control-label col-sm-2" >Email:</label>
      <div class="col-sm-5">
        <input type="email" class="form-control" id = "email" placeholder="Enter email">
      </div>
	  <label id="le" class="control-label col-sm-2" style="visibility:hidden;margin-left:-40px">Invalid Email</label>
    </div>
    <div class="form-group" style="margin-left:50px">
      <label class="control-label col-sm-2" >Password:</label>
      <div class="col-sm-5">
        <input type="password" class="form-control" id = "pwd" placeholder="Enter password">
      </div>
	  <label id="lpwd" class="control-label col-sm-5" style="visibility:hidden;margin-left:-45px"></label>
    </div>
	<div class="form-group" style="margin-left:50px">
      <label class="control-label col-sm-2" for="rpwd">Re-enter Password:</label>
      <div class="col-sm-5">
        <input type="password" class="form-control" id = "rpwd" placeholder="Re-enter password">
      </div>
	   <label id="lrpwd" class="control-label col-sm-3" style="visibility:hidden;margin-left:-50px">Password Do Not Match</label>
    </div>
	<div class="form-group" style="margin-left:50px">
		<label class="control-label col-sm-2" for="dept">Department:</label>
		<div class="col-sm-5"> 
			<select class="form-control" id = "dept">
				<?php while( $row = mysql_fetch_array($retval)){?>
					 <option> <?php echo $row["name"];?> </option>
				<?php } ?> 
			</select>
		</div>
	</div>
	<div class="form-group" style="margin-left:50px">
		<label class="control-label col-sm-2" for="desig">Designation:</label>
		<div class="col-sm-5"> 
			<select class="form-control" id = "desig">
				<option>Lecturer</option>
				<option>Assistant Professor</option>
				<option>Associate Professor</option>
				<option>Professor</option>
			</select>
		</div>
	</div>
	</form>
    <div class="form-group" style="margin-left:55px">
      <div class="col-sm-offset-2 col-sm-10">
        <button onclick="func()" class="btn btn-primary">Register</button>
      </div>
    </div>
	<div style="margin-top:60px;margin-left:10px;visibility:hidden" id="success" class="alert alert-success">
		<strong>Regestration completed!!</strong>
	</div>
		</div>
    </div>
</div>
</body>
</html>