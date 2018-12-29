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
if (isset($_POST['reg_comp']))
{
  $company_id = mysqli_real_escape_string($db, $_POST['company_id']);
  $company_name = mysqli_real_escape_string($db, $_POST['company_name']);
  $website = mysqli_real_escape_string($db, $_POST['website']);
  $address2 = mysqli_real_escape_string($db, $_POST['address2']);
  $coming_date = mysqli_real_escape_string($db, $_POST['coming_date']);
  $c_password1 = mysqli_real_escape_string($db, $_POST['c_password1']);
  $c_password2 = mysqli_real_escape_string($db, $_POST['c_password2']);
  if (filter_var($website, FILTER_VALIDATE_URL)) 
  {
   //its good
  } 
  else 
  {
   array_push($errors, "Invalid URl"); 
  }
  if (empty($company_name)) 
  { 
    array_push($errors, "Company name is required"); 
  }
  if (empty($company_id)) 
  { 
    array_push($errors, "Company Id is required"); 
  }
  if (empty($address2)) 
  { 
    array_push($errors, "Address is required"); 
  }
  if (empty($coming_date)) 
  { 
    array_push($errors, "Coming Date is required"); 
  }
  if (empty($c_password1)) 
  { 
    array_push($errors, "Password is required"); 
  }
  if ($c_password1 != $c_password2) 
  {
  array_push($errors, "passwords do not match");
  }
  $user_check_query = "SELECT * FROM company WHERE COMPANY_NAME='$company_name' AND COMPANY_ID='$company_id' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  
  if ($user)
  {
    if ($user['COMPANY_NAME'] === $company_name) 
    {
      array_push($errors, "Company name already exists");
    }
    if ($user['COMPANY_ID'] === $company_id) 
    {
      array_push($errors, "Company Id already exists");
    }
  }
  if (count($errors) == 0) 
  {
    $password = md5($c_password1);

    $query = "INSERT INTO COMPANY (COMPANY_ID,COMPANY_NAME,C_PASSWORD,WEBSITE,ADDRESS,COMING_DATE) 
          VALUES('$company_id', '$company_name', '$password', '$website', '$address2', '$coming_date')";
    mysqli_query($db, $query);
    header('location: company_login.php');
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration form for Company</title>
  <link rel="stylesheet" type="text/css" href="1.css"> 
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body >
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
  	<h2>Company Registration</h2>
  </div>
	
  <form method="post" action="company_register.php">
  	<?php include('wrong.php'); ?>
  	<div class="input-group">
  	  <label>Company Id</label>
  	  <input type="text" name="company_id" value="<?php echo $company_id; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Company Name</label>
  	  <input type="text" name="company_name" value="<?php echo $company_name; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="c_password1">
  	</div>
	<div class="input-group">
  	  <label>Confirm Password</label>
  	  <input type="password" name="c_password2">
  	</div>
	<div class="input-group">
  	  <label>Website</label>
  	  <input type="text" name="website" value="<?php echo $website ?>">
  	</div>
	<div class="input-group">
  	  <label>Address</label>
  	  <input type="text" name="address2" value="<?php echo $address2 ?>">
  	</div>
	<div class="input-group">
  	  <label>Visiting Date</label>
  	  <input type="date" name="coming_date" value="coming_date"<?php echo $coming_date ?>">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_comp">Sign up</button>
  	</div>
  	<p>
  		Already registered? <a href="company_login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>