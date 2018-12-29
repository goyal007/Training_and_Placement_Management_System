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
    if($_SESSION['user']=='admin')
    {
      header("Location: index_admin.php");
    }

?>

<?php
$company_id="";
$company_name="";
$company_type="";
$website="";
$address2="";
$coming_date="";
$c_type="";
$branch1="";
$min_cgpa="";
$max_backlogs="";
$max_salary="";
$max_stipend="";
$job_profile="";
$place_of_posting="";
$disp="";
$errors = array();
$positives=array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
//session_start();
if (isset($_POST['reg_company_details'])) 
{
  // receive all input values from the form
  $company_name = mysqli_real_escape_string($db, $_POST['company_name']);
  $c_type = mysqli_real_escape_string($db, $_POST['c_type']);
  $branch1 = mysqli_real_escape_string($db, $_POST['branch1']);
  $min_cgpa = mysqli_real_escape_string($db, $_POST['min_cgpa']);
  $max_backlogs = mysqli_real_escape_string($db, $_POST['max_backlogs']);
  $max_salary = mysqli_real_escape_string($db, $_POST['max_salary']);
  $max_stipend = mysqli_real_escape_string($db, $_POST['max_stipend']);
  $job_profile = mysqli_real_escape_string($db, $_POST['job_profile']);
  $place_of_posting = mysqli_real_escape_string($db, $_POST['place_of_posting']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
if($_SESSION['company_name']==$company_name)
{
    if (empty($company_name)) 
  { 
    array_push($errors, "Company name is required"); 
  }
  if (empty($c_type)) 
  { 
    array_push($errors, "company type is required"); 
  }
  if (empty($branch1)) 
  { 
    array_push($errors, "Branch is required"); 
  }
  if (empty($min_cgpa)) 
  { 
    array_push($errors, "Min CGPA is required"); 
  }
 /* if (empty($max_backlogs)) 
  { 
    array_push($errors, "Max Backlogs is required"); 
  }*/
  if (empty($job_profile)) 
  { 
    array_push($errors, "Job_Profile is required"); 
  }
  if (empty($place_of_posting)) 
  { 
    array_push($errors, "Place_of_Posting is required"); 
  }
  if (empty($max_stipend) &&(($c_type=='internship') or ($c_type=='Internship') or($c_type=='intern') or ($c_type=='Intern')))
  { 
    array_push($errors, "Stipend is required"); 
  }
  if (empty($max_salary)  &&(($c_type=='placement') or ($c_type=='Placement'))) 
  { 
    array_push($errors, "Salary is required"); 
  }

  if (!(empty($max_salary)) &&($c_type=='Internship'))
  { 
    array_push($errors, "Company is of type internship,No salary"); 
  }
  if (!(empty($max_stipend))  && ($c_type=='Placement') )
  { 
    array_push($errors, "Company is of type Placement,No Stipend"); 
  }



  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM companybranch WHERE COMPANY_NAME='$company_name' AND C_TYPE='$c_type' AND BRANCH='$branch1' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  
  if ($user)
  { // if user exists
    if ($user['COMPANY_NAME'] === $company_name) 
    {
      array_push($errors, "Company name already exists");
    }
    if ($user['C_TYPE'] === $c_type) 
    {
      array_push($errors, "Company Type already exists");
    }
    if ($user['BRANCH'] === $branch1) 
    {
      array_push($errors, "Branch already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) 
  {
    $query = "INSERT INTO companybranch (COMPANY_NAME,C_TYPE,BRANCH,MIN_CGPA,MAX_BACKLOGS,MAX_SALARY,MAX_STIPEND,JOB_PROFILE,PLACE_OF_POSTING) 
          VALUES('$company_name', '$c_type', '$branch1', '$min_cgpa', '$max_backlogs', '$max_salary', '$max_stipend', '$job_profile', '$place_of_posting')";
    mysqli_query($db, $query);
    $_SESSION['company_name'] = $company_name;
    $_SESSION['success'] = "Company Successfully updated details";
    $disp="Company Successfully Enter details";
   // echo "company Successfully enter the detail";

//if we want to empty all the entered details   then again initialize all the$variable_name to ""; 

    array_push($positives, "Company Successfully updated details");
    //header('location: index_company.php');
  }
}
else
{
    array_push($errors, "Company name is wrong"); 
}
  
  
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Information from Company</title>
  <link rel="stylesheet" type="text/css" href="1.css"> 
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body >
  <div class="list-unstyled3" >
          <ul>
           <li><a href="mnit.php"><img src="Mnit_logo.png" alt="MNIT Jaipur"  class="logo2" height="40"  align="left"/></a></li>
              <li style="float:right"><a  href="logout.php" title="<?php echo $_SESSION['company_name']; ?> ">Log Out</a></li> 
  
            <div class="para">
            <p> Training &amp; Placement,MNIT Jaipur</p>
                </div>  
                   </ul>
          
        </div>
  <div class="header">
  	<h2>Details from Company</h2>
  </div>

	<form method="post" action="index_company_details.php">
  	<?php include('wrong.php'); ?>
    <?php include('positive.php'); ?>
  	<div class="input-group">
  	  <label>Company name</label>
  	  <input type="text" name="company_name" value="<?php echo $_SESSION['company_name']; ?>" readonly>
  	</div>
	<div class="input-group">
      <label>Company Type</label>
      <!--<input type="text" name="c_type" value="<?php echo $c_type ?>">  -->
    <select name="c_type" >
    <option value="Internship">Internship</option>
    <option value="Placement">Placement</option>
     </select>
    </div>
	<div class="input-group">
      <label>Branch</label>
      <!-- <input type="text" name="branch1" value="<?php echo $branch1 ?>">  -->
    <select name="branch1" >
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
  	  <label>Minimum Cgpa</label>
  	  <input type="text" name="min_cgpa" value="<?php echo $min_cgpa ?>">
  	</div>
	<div class="input-group">
  	  <label>Max Backlogs</label>
  	  <input type="text" name="max_backlogs" value="<?php echo $max_backlogs ?>">
  	</div>
	<div class="input-group">
  	  <label>Max Salary</label>
  	  <input type="text" name="max_salary" value="<?php echo $max_salary ?>">
  	</div>
	<div class="input-group">
  	  <label>Max Stipend</label>
  	  <input type="text" name="max_stipend" value="<?php echo $max_stipend ?>">
  	</div>
	<div class="input-group">
  	  <label>Job Profile</label>
  	  <input type="text" name="job_profile" value="<?php echo $job_profile ?>">
  	</div>
	<div class="input-group">
  	  <label>Place of Posting</label>
  	  <input type="text" name="place_of_posting" value="<?php echo $place_of_posting ?>">
  	</div>

  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_company_details">Enter Details</button>
  	</div>
	 
	
	<p>
  		Added all details <a href="index_company.php">Go Back</a>
  	</p> 
  </form>
</body>
</html>