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
$admin_id="";
$admin_name="";
$a_email="";
$post="";
$con_number="";
$dob2="";
$qualification="";
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
if (isset($_POST['reg_admin']))
{
  $admin_id = mysqli_real_escape_string($db, $_POST['admin_id']);
  $admin_name = mysqli_real_escape_string($db, $_POST['admin_name']);
  $post = mysqli_real_escape_string($db, $_POST['post']);
  $con_number = mysqli_real_escape_string($db, $_POST['con_number']);
  $dob2 = mysqli_real_escape_string($db, $_POST['dob2']);
  $qualification = mysqli_real_escape_string($db, $_POST['qualification']);
  $a_email = mysqli_real_escape_string($db, $_POST['a_email']);
  $admin_password1 = mysqli_real_escape_string($db, $_POST['admin_password1']);
  $admin_password2 = mysqli_real_escape_string($db, $_POST['admin_password2']);

  if (empty($admin_name)) 
  { 
    array_push($errors, "Username is required"); 
  }
  if (empty($admin_id)) 
  { 
    array_push($errors, "Id is required"); 
  }
  if (empty($a_email)) 
  { 
    array_push($errors, "Email is required"); 
  }
if (empty($post)) 
  { 
    array_push($errors, "Post is required"); 
  }
  if (empty($con_number)) 
  { 
    array_push($errors, "Contact details required"); 
  }
  if (empty($qualification)) 
  { 
    array_push($errors, "fill qualification Block"); 
  }
  if (empty($dob2)) 
  { 
    array_push($errors, "Date of birth is required"); 
  }
  if (empty($admin_password1)) 
  { 
    array_push($errors, "Password is required"); 
  }
  if ($admin_password1 != $admin_password2) 
  {
  array_push($errors, "passwords do not match");
  }
  if (filter_var($a_email, FILTER_VALIDATE_EMAIL)) 
  {
  }
  else 
  {
    array_push($errors, "email is not a valid email address"); 
  }
  $user_check_query1 = "SELECT * FROM admin";
  $result1 = mysqli_query($db, $user_check_query1);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user1 = mysqli_fetch_assoc($result1);

  if(!($user1))
  {
  $user_check_query = "SELECT * FROM admin WHERE ADMIN_NAME='$admin_name' AND ADMIN_ID='$admin_id' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  if ($user)
  { 
    if ($user['ADMIN_NAME'] === $admin_name) 
    {
      array_push($errors, "Username already exists");
    }
    if ($user['ADMIN_ID'] === $admin_id) 
    {
      array_push($errors, "Admin Id already exists");
    }
  }
  if (count($errors) == 0) 
  {
    $password = md5($admin_password1);
    $query = "INSERT INTO admin (ADMIN_ID,ADMIN_NAME,A_PASSWORD,POST,EMAIL,CONTACT_NO,DOB,QUALIFICATION) 
          VALUES('$admin_id', '$admin_name', '$password', '$post', '$a_email', '$con_number', '$dob2', '$qualification')";
    mysqli_query($db, $query);
    header('location: admin_login.php');
  }
  }
  else
  {
    array_push($errors, "Only Admin can register new admin");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration Form For Admin</title>
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
  	<h2>Admin Registration</h2>
  </div>
	
  <form method="post" action="admin_register.php">
  	<?php include('wrong.php'); ?>
  	<div class="input-group">
  	  <label>Admin Id</label>
  	  <input type="text" name="admin_id" value="<?php echo $admin_id; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Admin Name</label>
  	  <input type="text" name="admin_name" value="<?php echo $admin_name; ?>">
  	</div>
	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="a_email" value="<?php echo $a_email ?>">
  	</div>
	<div class="input-group">
  	  <label>Post</label>
  	  <input type="text" name="post" value="<?php echo $post; ?>">
  	</div>
	<div class="input-group">
  	  <label>Contact Number</label>
  	  <input type="text" name="con_number" value="<?php echo $con_number; ?>">
  	</div>
	<div class="input-group">
  	  <label>Date of birth</label>
  	  <input type="date" name="dob2" value="<?php echo $dob2; ?>">
  	</div>
	<div class="input-group">
  	  <label>Qualification</label>
  	  <input type="text" name="qualification" value="<?php echo $qualification; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="admin_password1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="admin_password2">
  	</div> 

  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_admin">Sign up</button>
  	</div>
	
	
  	<p>
  		Already registered? <a href="admin_login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>