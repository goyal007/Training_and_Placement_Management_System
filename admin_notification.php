<?php

	session_start();
		if(!isset($_SESSION['user']))
		{
			header("Location: mnit.php");
		}
		if($_SESSION['user']=='student_int' )
    {
      header("Location: index_student_intern.php");
    }
    if($_SESSION['user']=='student_place' )
    {
      header("Location: index_student_placement.php");
    }
		if($_SESSION['user']=='company')
		{
			header("Location: index_company.php");
		}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin notifications</title>
  <link rel="stylesheet" type="text/css" href="1.css"> 
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body >
  <div class="list-unstyled3" >
          <ul>
            <li><a href="mnit.php"><img src="Mnit_logo.png" alt="MNIT Jaipur"  class="logo2" height="40"  align="left"/></a></li>
              <li style="float:right"><a  href="logout.php" title="<?php echo $_SESSION['admin_name']; ?> ">Log Out</a></li> 
	
            <div class="para">
            <p> Training &amp; Placement,MNIT Jaipur</p>
                </div>  
                   </ul>
          
        </div>
<!--		
  <div class="header">
  	<h3> <a style="color:white "href="profile_student2.php">View Profile</a></h3>
  </div>
  <div class="header">
    <h3> <a style="color:white "href="profile_student_update_place.php">Update Profile</a></h3>
  </div>  -->

<div class="index_student_intern">
				<ul class="list-unstyled4 list-horizontal-layout right-align">
						<a href="admin_noti_reg_int.php " class="btn7 ">Registered Students for Internship</a>
						<a href="admin_noti_reg_place.php " class="btn7">Registered Students for Placement</a>
				</ul>
				<ul class="list-unstyled4 list-horizontal-layout right-align">
						<a href="admin_noti_select_int.php " class="btn7 ">Selected Students for Internship</a>
						<a href="admin_noti_select_place.php" class="btn7">Selected Students for Placement</a>
				</ul>
		<!--		<ul class="list-unstyled4 list-horizontal-layout right-align">
						<a href="profile_student_update_place.php" class="btn5 ">Update Profile</a>
						<a href=" " class="btn5">Apply For Company</a>
				</ul>  -->
</div>

<div class="col-sm-4">
				<h3 class="mg-md  text-right tc-dim-gray">
					Training &amp; Placement Office
				</h3>
				<p class="text-right">
					Ground Floor,Prabha Bhawan<br>Malaviya National Institute of Technology<br>Jaipur - 302017
				</p>
				<p class="footer1">
					<strong>Phone</strong> <br><a href="tel:+911412529065">+91-141-2529065</a> <br><a href="tel:+919549654241">+91-9549654241</a> 
				</p>
				<p class="footer2">
				<strong>Email</strong> <br><a href="http://www.mnit.ac.in/placement/index.php">placements@mnit.ac.in</a>
				</p>
			</div>  
</body>
</html>