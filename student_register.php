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
//$father_name="";
//$mother_name="";
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
if (isset($_POST['reg_student'])) 
{
  $student_id = mysqli_real_escape_string($db, $_POST['student_id']);
  $student_name = mysqli_real_escape_string($db, $_POST['student_name']);
  //$father_name = mysqli_real_escape_string($db, $_POST['father_name']);
  //$mother_name = mysqli_real_escape_string($db, $_POST['mother_name']);
  $dob = mysqli_real_escape_string($db, $_POST['dob']);
  $gender = mysqli_real_escape_string($db, $_POST['gender']);
  $st_email = mysqli_real_escape_string($db, $_POST['st_email']);
  $address1 = mysqli_real_escape_string($db, $_POST['address1']);
  $contact_num = mysqli_real_escape_string($db, $_POST['contact_num']);
  $branch = mysqli_real_escape_string($db, $_POST['branch']);
  $tenth_per = mysqli_real_escape_string($db, $_POST['tenth_per']);
  $tenth_pass = mysqli_real_escape_string($db, $_POST['tenth_pass']);
  $twelfth_per = mysqli_real_escape_string($db, $_POST['twelfth_per']);
  $twelfth_pass = mysqli_real_escape_string($db, $_POST['twelfth_pass']);
  $cgpa = mysqli_real_escape_string($db, $_POST['cgpa']);
  $pass = mysqli_real_escape_string($db, $_POST['pass']);
  $backlogs = mysqli_real_escape_string($db, $_POST['backlogs']);
  $apply = mysqli_real_escape_string($db, $_POST['apply']);
  $st_password1 = mysqli_real_escape_string($db, $_POST['st_password1']);
  $st_password2 = mysqli_real_escape_string($db, $_POST['st_password2']);

  //Backlogs can be empty 

  if (empty($student_id)) 
  { 
    array_push($errors, "Student Id is required"); 
  }
  if (empty($student_name)) 
  { 
    array_push($errors, "Student Name is required"); 
  }
 /* if (empty($father_name)) 
  { 
    array_push($errors, "Father's Name is required"); 
  }
  if (empty($mother_name)) 
  { 
    array_push($errors, "Mother's Name is required"); 
  }*/
  if (empty($dob)) 
  { 
    array_push($errors, "Date of birth is required"); 
  }
  if (empty($gender)) 
  { 
    array_push($errors, "Gender is required"); 
  }
  if (empty($st_email)) 
  { 
    array_push($errors, "Email is required"); 
  }
  if (empty($branch)) 
  { 
    array_push($errors, "Branch is required"); 
  }
if (empty($tenth_per)) 
  { 
    array_push($errors, "10th % is required"); 
  }

  if (empty($tenth_pass)) 
  { 
    array_push($errors, "10th pass year is required"); 
  }
  if (empty($twelfth_per)) 
  { 
    array_push($errors, "12th % is required"); 
  }
  if (empty($twelfth_pass)) 
  { 
    array_push($errors, "12th pass year is required"); 
  }


  if (empty($cgpa)) 
  { 
    array_push($errors, "cgpa is required"); 
  }
  if (empty($pass)) 
  { 
    array_push($errors, "College passing year  is required"); 
  }
  if (empty($address1)) 
  { 
    array_push($errors, "Address is required"); 
  }
  if (empty($apply)) 
  { 
    array_push($errors, "apply for field is required"); 
  }
  if (empty($st_password1)) 
  { 
    array_push($errors, "Password is required"); 
  }
  if ($st_password1 != $st_password2) 
  {
  array_push($errors, "passwords do not match");
  }
  
  if (filter_var($st_email, FILTER_VALIDATE_EMAIL)) 
  {
  }
  else 
  {
    array_push($errors, "email is not a valid email address"); 
  }

  if(($apply=='internship' or $apply=='Internship') and $pass!='2020')
  {
    array_push($errors, "Not eligible for internship i.e not 3rd year student"); 
  }
  if(($apply=='placement' or $apply=='Placement') and $pass!='2019')
  {
    array_push($errors, "Not eligible for placement i.e not 4th year student"); 
  }
  if(strlen($contact_num)!=10)
  {
     array_push($errors, "Contact Number not correct"); 
  }
  if($cgpa<1 or $cgpa>10)
  {
    array_push($errors, "This CGPA not possible");
  }
  if($tenth_per<1 or $tenth_per>100)
  {
    array_push($errors, "This 10th % not possible");
  }
  if($twelfth_per<1 or $twelfth_per>100)
  {
    array_push($errors, "This 12th %  not possible");
  }
  if(((int)$twelfth_pass-(int)$tenth_pass)<2)
  {
    array_push($errors, "10th and 12th pass not correct");
  }
  $user_check_query = "SELECT * FROM student WHERE STUDENT_NAME='$student_name' AND STUDENT_ID='$student_id'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  
  if ($user)
  { // if user exists
    if ($user['STUDENT_NAME'] === $student_name) 
    {
      array_push($errors, "Student already registered");
    }
    if ($user['STUDENT_ID'] === $student_id) 
    {
      array_push($errors, "Id already exists");
    }
    if ($user['EMAIL'] === $st_email) 
    {
      array_push($errors, "email already exists");
    }
  }

  if (count($errors) == 0) 
  {
    $password = md5($st_password1);//encrypt the password before saving in the database
    if(isset($_FILES['image']['tmp_name']))
    {
          $file = addslashes(file_get_contents($_FILES['image']['tmp_name']));        
    }
    else
    {
          //$file = null;
          //echo "not set";
    }

    $query = "INSERT INTO student (STUDENT_ID,S_PASSWORD,STUDENT_NAME,GENDER,DOB,EMAIL,ADDRESS,CONTACT_NO,BRANCH,TENTH_PER,TENTH_PASS_YEAR,TWELTH_PER,TWELTH_PASS_YEAR,CGPA,PASSING_YEAR,BACKLOGS,APPLY_FOR,IMAGE) 
          VALUES('$student_id', '$password', '$student_name','$gender', '$dob', '$st_email', '$address1', '$contact_num', '$branch', '$tenth_per', '$tenth_pass', '$twelfth_per', '$twelfth_pass', '$cgpa', '$pass', '$backlogs','$apply','$file')";
   mysqli_query($db, $query);
   
    //$_SESSION['student_name'] = $student_name;
    $_SESSION['success'] = "Student registered successfully";
    /*if(mysqli_query($db, $query))  
      {  
           echo '<script>alert("Image Inserted into Database")</script>';  
      }  */
    header('location:student.php');
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration form for Student</title>
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
  	<h2>Student Registration</h2>
  </div>
	
  <form method="post" action="student_register.php" enctype="multipart/form-data">
  	<?php include('wrong.php'); ?>
  	<div class="input-group">
  	  <label>Student id</label>
  	  <input type="text" name="student_id" value="<?php echo $student_id; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Student name</label>
  	  <input type="text" name="student_name" value="<?php echo $student_name; ?>">
  	</div>
	<!--<div class="input-group">
  	  <label>Father name</label>
  	  <input type="text" name="father_name" value="<?php //echo $father_name; ?>">
  	</div>
	<div class="input-group">
  	  <label>Mother name</label>
  	  <input type="text" name="mother_name" value="<?php //echo $mother_name; ?>">
  	</div> -->
	<div class="input-group">
  	  <label>Date of birth</label>
  	  <input type="date" name="dob" value="<?php echo $dob; ?>" >    <!-- yyyy-mm-dd; -->
  	</div>
	<div class="input-group">
      <label>Gender</label>
      <!-- <input type="text" name="gender" value="<?php echo $gender; ?>"> -->
    <select name="gender" >
    <option value="Male">Male</option>
    <option value="Female">Female</option>
     </select>
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
  	  <input type="number" name="contact_num" value="<?php echo $contact_num; ?>">
  	</div>
	<div class="input-group">
      <label>Branch</label>
    
     <!-- <input type="text" name="branch" value="<?php echo $branch; ?>"> -->

    <select name="branch" >
    <option value="CSE">Computer Science and Engineering</option>
    <option value="ECE">Electronics and Comm. Engineering</option>
    <option value="EE">Electrical Engineering</option>
    <option value="CE">Civil Engineering</option>
    <option value="ME">Mechanical Engineering</option>
    <option value="CHE">Chemical Engineering</option>
    <option value="MME">Metallurgical and Materials Engineering</option>
     </select>
   
    </div>
	<div class="input-group">
  	  <label>10th percentage</label>
  	  <input type="text" name="tenth_per" value="<?php echo $tenth_per; ?>">
  	</div>
	<div class="input-group">
      <label>10th pass year</label>
      <!--<input type="text" name="tenth_pass" value="<?php echo $tenth_pass; ?>"> -->
    <select name="tenth_pass" >
      <option value="2010">2010</option>
    <option value="2011">2011</option>
    <option value="2012">2012</option>
    <option value="2013">2013</option>
    <option value="2014">2014</option>

     </select>
    </div>
	<div class="input-group">
  	  <label>12th percentage</label>
  	  <input type="text" name="twelfth_per" value="<?php echo $twelfth_per; ?>">
  	</div>
	<div class="input-group">
      <label>12th pass year</label>
      <!--<input type="text" name="twelfth_pass" value="<?php echo $twelfth_pass; ?>">  -->
    <select name="twelfth_pass" >
    <option value="2012">2012</option>
    <option value="2013">2013</option>
    <option value="2014">2014</option>
    <option value="2015">2015</option>
    <option value="2016">2016</option>
     </select>
    </div>
	<div class="input-group">
  	  <label>CGPA</label>
  	  <input type="text" name="cgpa" value="<?php echo $cgpa; ?>">
  	</div>
	<div class="input-group">
      <label>passing year</label>
     <!-- <input type="text" name="pass" value="<?php echo $pass; ?>">  -->
    <select name="pass" >
    <option value="2019">2019</option>
    <option value="2020">2020</option>
     </select>
    </div>
	<div class="input-group">
  	  <label>Backlogs</label>
  	  <input type="text" name="backlogs" value="<?php echo $backlogs; ?>">
  	</div>
	<div class="input-group">
      <label>Apply for</label>
      <!--<input type="text" name="apply" value="<?php echo $apply; ?>">  -->
    <select name="apply" >
    <option value="Internship">Internship</option>
    <option value="Placement">Placement</option>
     </select>
    </div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="st_password1">
  	</div>
	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="st_password2">
  	</div>
    <div class="input-group">
      <label>Upload Image(Max Size 512kb)</label>
      <input type="file" name="image" id="image" required="required"/>
    </div>
	
	
	
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_student" id='submit'>Sign up</button>
  	</div>
	
	
  	<p>
  		Already registered? <a href="student.php">Sign in</a>
  	</p>
  </form>



<script>  
 $(document).ready(function(){  
      $('#submit').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script> 


</body>
</html>

 