<!DOCTYPE html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet"> 
<html>
<head>
    <title></title>
</head>
<script>
	function ufunc(str){
		document.getElementById("ln").innerHTML = str;
		document.getElementById("ln").style.visibility = "visible";		
	};
	function wfunc( str ){
		document.getElementById("lp").innerHTML = str;
		document.getElementById("lp").style.visibility = "visible";
	};
	function idfunc(){
		document.getElementById("lid").innerHTML = "Invalid Student ID";
		document.getElementById("lid").style.visibility = "visible";
	};
	function func(){
		document.getElementById("ln").style.visibility = "hidden";
		document.getElementById("lid").style.visibility = "hidden";
		document.getElementById("le").style.visibility = "hidden";
		document.getElementById("lp").style.visibility = "hidden";
		document.getElementById("lrp").style.visibility = "hidden";
		document.getElementById("success").style.visibility = "hidden";
		var username = document.getElementById("name").value;
		username = username.trim();
		if( username.length < 4 ){
			ufunc("name should be at least 4 characters in length");
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
				ufunc("only 'a'.. 'z', 'A'... 'Z'  and space '  ' are allowed");
			}
			else{
				var sid = document.getElementById("sid").value;
				var flag = true;
				var str;
				if( sid.length != 12){
					flag = false;
				}
				else{
					for(  var  i = 0; i < sid.length; i++){
						if ( !((sid[i] >= '0' && sid[i] <= '9')  || sid[i] =='.')){
							flag = false;
							break;
						}
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
									wfunc("only 'a'...'z' , 'A'...'Z' , '0'...'9' , underscore '_' , comma ',' , dot '.' are allowed");
								}
								else if(pass.length < 6 ){
									wfunc("password should be at least 6 characters in length");
								}
								else{
									var repass = document.getElementById("rpwd").value;
									if( pass != repass ){
										document.getElementById("lrp").style.visibility = "visible";
									}
									else{
										var dept = document.getElementById("dept").value;
										$.ajax({
											type: "POST",
											url: 'signin.php',
											data: 'name='+username+'&email='+user_mail+'&pass='+pass+'&id='+sid+'&dept='+dept,
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
<body style="background-color:#EFFBFB">
	<nav  style="background-color:#a7a7a7" class="navbar navbar-default">
		<div  class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="sreg.php"> <span style="color:white">Student Registration</span> </a>
			</div>
			<ul  class="nav navbar-nav">
				<li><a style="color:white" href="index.php">Home</a></li>
			</ul>
		</div>
	</nav>
	<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db('student_management_system');
$sql = "select * from department";
$retval = mysql_query($sql);
?>
<div class="container" style="margin-left:17%;margin-top:100px">
  <form class="form-horizontal" role="form">
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Full Name:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id ="name" placeholder="Enter Full Name">
      </div>
	    <label id="ln" class="control-label col-sm-4" style="visibility:hidden;margin-left:-45px"></label>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="sid">Student ID:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id ="sid" placeholder="Enter Student ID">
      </div>
	   <label id="lid"class="control-label col-sm-3" style="visibility:hidden;margin-left:-65px"></label>
    </div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="dept">Department:</label>
		<div class="col-sm-4"> 
			<select class="form-control" id = "dept">
				<?php while( $row = mysql_fetch_array($retval)){?>
					 <option> <?php echo $row["name"];?> </option>
				<?php } ?> 
			</select>
		</div>
	</div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-4">
        <input type="email" class="form-control" id = "email" placeholder="Enter email">
      </div>
	   <label id="le" class="control-label col-sm-2" style="visibility:hidden;margin-left:-65px">Invalid Email</label>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-4">
        <input type="password" class="form-control" id = "pwd" placeholder="Enter password">
      </div>
	   <label id="lp" class="control-label col-sm-6" style="visibility:hidden;margin-left:-50px" >only 'a'...'z' , 'A'...'Z' , '0'...'9' , underscore '_' , comma ',' , dot '.' are allowed</label>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="rpwd">Re-enter Password:</label>
      <div class="col-sm-4">
        <input type="password" class="form-control" id = "rpwd" placeholder="Re-enter password">
      </div>
	   <label id="lrp" class="control-label col-sm-2" style="visibility:hidden;margin-left:8px">Password Do Not match</label>
    </div>
	</form>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button onclick="func()" class="btn btn-primary">Register</button>
      </div>
	</div>
</div>
	<div style="margin-top:20px;visibility:hidden" id="success" class="alert alert-success">
		<strong>Regestration completed!!</strong>
	</div>
</body>
</html>