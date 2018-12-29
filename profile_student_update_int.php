<?php

  session_start();
    if(!isset($_SESSION['user']))
    {
      header("Location: mnit.php");
    }
    if($_SESSION['user']=='admin')
    {
      header("Location: index_admin.php");
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

<?php
$student_name="";
$dob="";
$st_email="";
$address1="";
$contact_num="";
$tenth_per="";
$twelfth_per="";
$cgpa="";
//$backlogs="";
$st_password1="";
$st_password2="";
$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
// session_start();

$vari=$_SESSION['student_id'];

$user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$vari' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
$student_name=$user['STUDENT_NAME'];
$dob=$user['DOB'];
//echo $dob;
$st_email=$user['EMAIL'];
$address1=$user['ADDRESS'];
$contact_num=$user['CONTACT_NO'];
$tenth_per=$user['TENTH_PER'];
$twelfth_per=$user['TWELTH_PER'];
$cgpa=$user['CGPA'];

//$backlogs=$user['BACKLOGS'];


if (isset($_POST['profile_student_update_int'])) 
{
  // receive all input values from the form
  $student_name = mysqli_real_escape_string($db, $_POST['student_name']);
  $dob = mysqli_real_escape_string($db, $_POST['dob']);
  $st_email = mysqli_real_escape_string($db, $_POST['st_email']);
  $address1 = mysqli_real_escape_string($db, $_POST['address1']);
  $contact_num = mysqli_real_escape_string($db, $_POST['contact_num']);
  $tenth_per = mysqli_real_escape_string($db, $_POST['tenth_per']);
  $twelfth_per = mysqli_real_escape_string($db, $_POST['twelfth_per']);
  $cgpa = mysqli_real_escape_string($db, $_POST['cgpa']);
 // $backlogs = mysqli_real_escape_string($db, $_POST['backlogs']);
  $st_password2 = mysqli_real_escape_string($db, $_POST['st_password2']);//current password
  $st_password1 = mysqli_real_escape_string($db, $_POST['st_password1']);//new pasword
  $st_password3=md5($st_password2);
  //$st_password4= $st_password1;
  
  if(empty($st_password2) and empty($st_password1))
  {
    //$password=$user['S_PASSWORD'];
  }
  else if(empty($st_password2))
  {
     array_push($errors, "current password is required");   
  }
  else if(empty($st_password1))
  {
     array_push($errors, "new password is required"); 
  }
  else
  {
    if($st_password3==$user['S_PASSWORD'])
    {

    }
    else
    {
      array_push($errors, "Current Password is incorrect"); 
    }
  }





 /*if(empty($st_password1))
  $st_password1=$user['S_PASSWORD'];*/
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($student_name)) 
  { 
    array_push($errors, "Student Name is required"); 
  }
  if (empty($dob)) 
  { 
    array_push($errors, "Date of birth is required"); 
  }
  if (empty($st_email)) 
  { 
    array_push($errors, "Email is required"); 
  }
  if (empty($address1)) 
  { 
    array_push($errors, "Address is required"); 
  }
  if (empty($tenth_per)) 
  { 
    array_push($errors, "10th % is required"); 
  }
  if (empty($twelfth_per)) 
  { 
    array_push($errors, "12th % is required"); 
  }
  if (empty($cgpa)) 
  { 
    array_push($errors, "cgpa is required"); 
  }
  
  if (filter_var($st_email, FILTER_VALIDATE_EMAIL)) 
  {
  }
  else 
  {
    array_push($errors, "email is not a valid email address"); 
  }
  if(strlen($contact_num)!=10)
  {
     array_push($errors, "Contact Number not correct"); 
  }


if((int)$cgpa<1 or (int)$cgpa>10)
  {
    array_push($errors, "This CGPA not possible");
  }
  if((int)$tenth_per<1 or (int)$tenth_per>100)
  {
    array_push($errors, "This 10th % not possible");
  }
  if((int)$twelfth_per<1 or (int)$twelfth_per>100)
  {
    array_push($errors, "This 12th %  not possible");
  }




  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
/*  $user_check_query = "SELECT * FROM student WHERE STUDENT_ID=$vari LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);*/
  
  

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) 
  {
    if(empty($st_password2) and empty($st_password1))
    {
      $password=$user['S_PASSWORD'];
    }
    else
    {
      $password = md5($st_password1);//encrypt the password before saving in the database
    }
    

    $query = "UPDATE STUDENT set STUDENT_NAME='$student_name' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set DOB='$dob' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set EMAIL='$st_email' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set ADDRESS='$address1' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set CONTACT_NO='$contact_num' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set TENTH_PER='$tenth_per' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set TWELTH_PER='$twelfth_per' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set CGPA='$cgpa' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    $query = "UPDATE STUDENT set S_PASSWORD='$password' where STUDENT_ID='$vari'";
    mysqli_query($db, $query);

    header('location:index_student_intern.php');
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Updation form for Student</title>
  <link rel="stylesheet" type="text/css" href="1.css"> 
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body >
  <div class="list-unstyled3" >
          <ul>
            <li><a href="mnit.php"><img src="Mnit_logo.png" alt="MNIT Jaipur"  class="logo2" height="40"  align="left"/></a></li>
              <li style="float:right"><a  href="logout.php" title="<?php echo $_SESSION['student_name']; ?> ">Log Out</a></li> 
  
            <div class="para">
            <p> Training &amp; Placement,MNIT Jaipur</p>
                </div>  
                   </ul>
          
        </div>
  <div class="header">
    <h2>Update Profile</h2>
  </div>
  
  <form method="post" action="profile_student_update_int.php" >
    <?php include('wrong.php'); ?>
    
    <div class="input-group">
      <label>Student name</label>
      <input type="text" name="student_name" value="<?php echo $student_name; ?>">
    </div>
  
  <div class="input-group">
      <label>Date of birth</label>
      <input type="date" name="dob" value="<?php echo $dob; ?>" >    <!-- yyyy-mm-dd; -->
    </div>  
  <div class="input-group">
      <label>Email</label>
      <input type="email" name="st_email" value="<?php echo $st_email; ?>">
    </div>
  <div class="input-group">
      <label>Address</label>
      <input type="text" name="address1" value="<?php echo $address1; ?>">
    </div>
  <div class="input-group">
      <label>Contact Number</label>
      <input type="text" name="contact_num" value="<?php  echo $contact_num; ?>">
    </div> 
  <div class="input-group">
      <label>10th percentage</label>
      <input type="text" name="tenth_per" value="<?php echo $tenth_per; ?>">
    </div>
  <div class="input-group">
      <label>12th percentage</label>
      <input type="text" name="twelfth_per" value="<?php echo $twelfth_per; ?>">
    </div>
  <div class="input-group">
      <label>CGPA</label>
      <input type="text" name="cgpa" value="<?php echo $cgpa; ?>">
    </div>
  
  <!--<div class="input-group">
      <label>Backlogs</label>
      <input type="text" name="backlogs" value="<?php $backlogs; ?>">
    </div> -->
  
    <div class="input-group">
      <label>Current Password</label>
      <input type="password" name="st_password2">
    </div>
    <div class="input-group">
      <label>New Password</label>
      <input type="password" name="st_password1">
    </div>

  
  
  
    <div class="input-group">
      <button type="submit" class="btn" name="profile_student_update_int">Update</button>
    </div>
    <p>
      Updated the details <a href="index_student_intern.php">Go Back</a>
    </p> 
  </form>
</body>
</html>