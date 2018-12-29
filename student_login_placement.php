<?php 

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
$student_id="";
$student_name="";
$father_name="";
$mother_name="";
$dob="";
$gender="";
$st_email="";
$address1="";
$contact_num="";
$branch="";
$tenth_per="";
$tenth_pass="";
$twelfth_per="";
$twelfth_pass="";
$cgpa="";
$pass="";
$backlogs="";
$apply="";
$st_password="";
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'placement');

if (isset($_POST['login_student_place'])) 
{
  

  $student_name = mysqli_real_escape_string($db, $_POST['student_name']);
  $student_id = mysqli_real_escape_string($db, $_POST['student_id']);
  $apply = mysqli_real_escape_string($db, $_POST['apply']);
  $st_password = mysqli_real_escape_string($db, $_POST['st_password']);

  if (empty($student_name)) 
  {
    array_push($errors, "Student Name is required");
  }
  if (empty($student_id)) 
  {
    array_push($errors, "Student Id is required");
  }
  if (empty($apply)) 
  {
    array_push($errors, "apply is required");
  }
  if (empty($st_password)) 
  {
    array_push($errors, "Password is required");
  }
  if(($apply!='placement' and $apply!='Placement' ))
  {
    array_push($errors, "You entered incorrect info for Apply");
  }

  if (count($errors) == 0 ) 
  {
//The md5() function calculates the MD5 hash of a string
    $password = md5($st_password);
  $query = "SELECT * FROM student WHERE STUDENT_NAME='$student_name' AND S_PASSWORD='$password' AND STUDENT_ID='$student_id' AND APPLY_FOR='$apply'";
  //The mysqli_query() function performs a query against the database.
    $results = mysqli_query($db, $query);
  
    if (mysqli_num_rows($results) == 1 ) ////Return the number of rows in a result set:
  {
      $_SESSION['student_name'] = $student_name;
      $_SESSION['success'] = "placement";
      $_SESSION['student_id'] = $student_id;
      $_SESSION['user'] = "student_place";
      header('location: index_student_placement.php');
    }
  else 
  {
      array_push($errors, "Wrong username/password combination or Not Registered yet");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>student login for placement</title>
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
  <div class="header">
  	<h2>Student Log in for Placement</h2>
  </div>
<!--/*The PHP superglobals $_GET and $_POST are used to collect form-data.-->	 
  <form method="post" action="student_login_placement.php">
  <?php include('wrong.php'); ?>
  	<div class="input-group">
  		<label>Student Name</label>			
  		<input type="text" name="student_name" >
  	</div>
	<div class="input-group">
  		<label>Student Id</label>			
  		<input type="text" name="student_id" >
  	</div>
	<div class="input-group">
  		<label>Apply for</label>			<!--The <label> element does not render as anything special for the user. However, it provides a usability improvement for mouse users, because if the user clicks on the text within the <label> element, it toggles the control.-->
  		<input type="text" name="apply" value="Placement" readonly >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="st_password">
  	</div>
	
	
	
	
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_student_place">Sign in</button>
  	</div>
	
  	<p>
  		Not enrolled yet? <a href="student_register.php">Sign up</a>
      <br>
      <a href="place_forgot.php">Forgot Password</a>
  	</p>
  </form>
</body>
</html>