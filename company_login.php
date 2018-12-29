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
$company_id="";
$company_name="";
$company_type="";
$website="";
$address2="";
$coming_date="";
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
if (isset($_POST['login_company'])) 
{ 
  $company_name = mysqli_real_escape_string($db, $_POST['company_name']);
  $company_id = mysqli_real_escape_string($db, $_POST['company_id']);
  $c_password = mysqli_real_escape_string($db, $_POST['c_password']);
  if (empty($company_name)) 
  {
    array_push($errors, "Company name is required");
  }
  if (empty($company_id)) 
  {
    array_push($errors, "Company Id is required");
  }
  if (empty($c_password)) 
  {
    array_push($errors, "Password is required");
  }
  if (count($errors) == 0) 
  {
    $password = md5($c_password);
    $query = "SELECT * FROM company WHERE COMPANY_NAME='$company_name' AND C_PASSWORD='$password' AND COMPANY_ID='$company_id'";
  //The mysqli_query() function performs a query against the database.
    $results = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($results);
    if($user['APPROVAL']=='rejected')
    {
      array_push($errors, "Company is not valid");
    }
    else
    {
        if (mysqli_num_rows($results) == 1) ////Return the number of rows in a result set:
      {
        $_SESSION['company_name'] = $company_name;
        $_SESSION['company_id'] = $company_id;
        $_SESSION['user'] = "company";
        $_SESSION['success'] = "Company logged in";
        header('location:index_company.php');
      }
      else 
      {
        array_push($errors, "Wrong username/password combination");
      }
    }
    
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Company Login</title>
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
  	<h2>Company Login</h2>
  </div>
<!--/*The PHP superglobals $_GET and $_POST are used to collect form-data.-->	 
  <form method="post" action="company_login.php">
  <?php include('wrong.php'); ?>
  	<div class="input-group">
  		<label>Company Name</label>			<!--The <label> element does not render as anything special for the user. However, it provides a usability improvement for mouse users, because if the user clicks on the text within the <label> element, it toggles the control.-->
  		<input type="text" name="company_name" >
  	</div>
	<div class="input-group">
  		<label>Company Id</label>			<!--The <label> element does not render as anything special for the user. However, it provides a usability improvement for mouse users, because if the user clicks on the text within the <label> element, it toggles the control.-->
  		<input type="text" name="company_id" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="c_password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_company">Sign in</button>
  	</div>
	
  	<p>
  		Not enrolled yet? <a href="company_register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>