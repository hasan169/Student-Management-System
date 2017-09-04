<!DOCTYPE html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <script src="js/jquery.min.js"></script>
<html>
<head>
    <title></title>
    <style>
        a:hover {
            background-color: #fafafa;
            text-decoration: none !important;
        }
    </style>
</head>
<body>
    <?php
		session_start();
		if(!isset($_SESSION["admin"])){
			header("location:index.php");
		}
		include 'navbar.php';
	?>
    <div class="container-fluid"  style="display:inline">
        <!--This is a comment. Comments are not displayed in the browser-->
        <div class="row">
            <div class="col-md-9">
				<div style="width:100%;height:83px;border-width:1px;border-bottom-style:double;border-bottom-color:#eeeeee">
                    <h2 style="margin-left:30%;margin-top:-1px; color:#373e4a"> Student Managment  System</h2>
                    <a style="color:black;margin-left:90%" href="logout.php"> Logout <img style="width:20px;height:20px" src="css/logout.png" /> </a>
                </div>
                <div style="margin-top:100px"></div>             
                <a href="teacher.php" style="margin-top:5px;margin-left:20px;border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#f56954;margin-left:25%;margin-top:20%;font-size:30px"> Teacher </p> </a>
                <a href="approve.php" style="margin-top:5px;margin-left:20px; border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#303641;margin-left:25%;margin-top:20%;font-size:30px"> Student </p> </a>
                <a href="course.php" style="margin-top:5px;margin-left:20px; border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#00c0ef;margin-left:25%;margin-top:20%;font-size:30px">  Course </p> </a>
                <a href="semester.php" style="margin-top:5px;margin-left:20px; border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#00b29e;margin-left:25%;margin-top:20%;font-size:30px"> Semester </p> </a>
                <div style="margin-top:10px"></div>
                <a href="courseteacher.php" style="margin-top:5px;margin-left:20px;border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#ba79cb;margin-left:10px; margin-top:20%;font-size:28px">Course Teacher</p> </a>
                <a href="advising.php" style="margin-top:5px;margin-left:20px; border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#00a65a;margin-left:20%;margin-top:20%;font-size:30px"> Advising </p> </a>
                <a href="prerequisite.php" style="margin-top:5px;margin-left:20px; border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#ffa812;margin-left:10%;margin-top:20%;font-size:30px"> Pre-Requisite</p> </a>
                <a href="department.php" style="margin-top:5px;margin-left:20px; border-style: groove;border-radius:5px; border-width:thin; border-color:#eeeeee;display:inline-block;height:120px;width:220px"> <p style="color:#6c541e;margin-left:15%;margin-top:20%;font-size:30px"> Department </p> </a> 
            </div>
        </div>
    </div>
</body>
</html>