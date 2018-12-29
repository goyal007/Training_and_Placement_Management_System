<?php 
//This is for Protection
//The user with active session will be redirected to its specific index page
  session_start();
  if(isset($_SESSION['user']))
  {
    if($_SESSION['user']=='admin')
    {
      header("Location: index_admin.php");
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
  }
?>

<?php
$admin_id="";
$admin_name="";
$a_email="";
$post="";
$con_number="";
$dob2="";
$qualification="";
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
if (isset($_POST['login_admin']))
{
//The mysqli_real_escape_string() function escapes special characters in a string for use in an SQL statement. 
 // receive all input values from the form 
  $admin_name = mysqli_real_escape_string($db, $_POST['admin_name']);
  $admin_id = mysqli_real_escape_string($db, $_POST['admin_id']);
  $admin_password = mysqli_real_escape_string($db, $_POST['admin_password']);

   // form validation: ensure that the form is correctly filled ...
  if (empty($admin_name)) 
  {
    array_push($errors, "Username is required");
  }
  if (empty($admin_id)) 
  {
    array_push($errors, "Id is required");
  }
  if (empty($admin_password)) 
  {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) 
  {
  //The md5() function calculates the MD5 hash of a string
  $password = md5($admin_password);
  $query = "SELECT * FROM admin WHERE ADMIN_NAME='$admin_name' AND A_PASSWORD='$password' AND ADMIN_ID='$admin_id'";
  //The mysqli_query() function performs a query against the database.
    $results = mysqli_query($db, $query);
  
  if (mysqli_num_rows($results) == 1) ////Return the number of rows in a result set:
  {
      $_SESSION['admin_id'] = $admin_id;
      $_SESSION['admin_name'] = $admin_name;
      $_SESSION['success'] = "Admin logged in";
      $_SESSION['user'] = "admin";//session variable used for protection
      header('location: index_admin.php');
  }
  else 
  {
      array_push($errors, "Wrong username/password combination");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin login </title>
  <link rel="stylesheet" type="text/css" href="1.css">
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body>
  <div class="list-unstyled3" >
          <ul>
            <li><a href="mnit.php"><img src="Mnit_logo.png" alt="MNIT Jaipur"  class="logo2" height="40"  align="left"/></a></li>
             <!-- <li style="float:right"><a  href="logout.php">Log Out</a></li> -->
  
            <div class="para">
            <p> Training &amp; Placement,MNIT Jaipur</p>
                </div>  
                   </ul>
          
        </div>
  <div class="header" >
  	<h2>Admin Login</h2>
  </div>
<!--/*The PHP superglobals $_GET and $_POST are used to collect form-data.-->	 
  <form method="post" action="admin_login.php">
  <?php include('wrong.php'); ?>
  	<div class="input-group">
  		<label>Admin Name</label>			<!--The <label> element does not render as anything special for the user. However, it provides a usability improvement for mouse users, because if the user clicks on the text within the <label> element, it toggles the control.-->
  		<input type="text" name="admin_name" >
  	</div>
	<div class="input-group">
  		<label>Admin Id</label>			
  		<input type="text" name="admin_id" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="admin_password">
  	</div>
	
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_admin">Sign in</button>
  	</div>
	
  	<p>
  		Not enrolled yet? <a href="admin_register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>