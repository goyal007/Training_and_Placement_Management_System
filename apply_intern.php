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
$company_id="";
$company_name="";
$company_type="";
$branch1="";
$branch2="";
$cgpa1="";
$cgpa2="";
$backlogs1="";
$backlogs2="";
$website="";
$address2="";
$coming_date="";
$absent="";
$status="";

$branch_st="";
$errors = array();
$positives=array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
if (isset($_POST['apply_intern']))
{
  // receive all input values from the form
  $company_name = mysqli_real_escape_string($db, $_POST['company_name']);
  $vari=$_SESSION['student_id'];

   if ($company_name=='Company Name') 
  { 
    array_push($errors, "No Company is Coming"); 
  }

  $user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$vari'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  $student_name=$user['STUDENT_NAME'];
  $branch1=$user['BRANCH'];
  $cgpa1=$user['CGPA'];
  $cgpa1=(double)$cgpa1;
  $backlogs1=$user['BACKLOGS'];
  $backlogs1=(int)$backlogs1;
  $absent=$user['ABSENT'];
  $absent=(int)$absent;
  $status=$user['STATUS'];
  $apply_count=$user['APPLY_COUNT'];

  if($status=='NS')
  {
  $user_check_query = "SELECT * FROM companybranch inner join company on companybranch.COMPANY_NAME=company.COMPANY_NAME where company.APPROVAL='approved' and companybranch.C_TYPE='Internship' AND companybranch.BRANCH='$branch1' AND company.STATUS='visiting' and company.COMPANY_NAME='$company_name' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  //$branch2=$user['BRANCH'];
  $cgpa2=$user['MIN_CGPA'];
  $cgpa2=(double)$cgpa2;
  $backlogs2=$user['MAX_BACKLOGS'];
  $backlogs2=(int)$backlogs2;
  //echo $cgpa2.'               ';
  //echo $cgpa1;
  if($cgpa1>=$cgpa2)
  {

  }
  else
  {
    array_push($errors, "CGPA is less than company requirment"); 
  }
  if($backlogs1<=$backlogs2)
  {

  }
  else
  {
    array_push($errors, "Backlogs are more than company requirment"); 
  }
  if($absent<=2)
  {

  }
  else
  {
    array_push($errors, "Absent reached its maximum limit"); 
  }
 

 
  $user_check_query = "SELECT * FROM registered_interns WHERE STUDENT_ID='$vari' AND COMPANY_NAME='$company_name' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  
        if ($user)
        { // if user exists
          array_push($errors, "Already Applied"); 
        }
  }
  else
  {
    array_push($errors, "Already Got Internship"); 
  }


  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) 
  {
    $query = "INSERT INTO registered_interns (STUDENT_ID,STUDENT_NAME,COMPANY_NAME)VALUES('$vari', '$student_name', '$company_name')";
    mysqli_query($db, $query);
    $query = "UPDATE student set APPLY_COUNT=APPLY_COUNT+1 where STUDENT_ID='$vari'";
    mysqli_query($db, $query);
    //$disp="Successfully applied for the company";
   // echo "company Successfully enter the detail";

//if we want to empty all the entered details   then again initialize all the$variable_name to ""; 

    array_push($positives, "Successfully applied for the company");
    //header('location: index_company.php');
  }
  
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Student Apply for Intern</title>
  <link rel="stylesheet" type="text/css" href="1.css">
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body>
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
    <h2>Apply For Intern</h2>
  </div>
<!--/*The PHP superglobals $_GET and $_POST are used to collect form-data.-->  

  <form method="post" action="apply_intern.php">
  <?php include('wrong.php'); ?>
  <?php include('positive.php'); ?>
 <div class="input-group">
      <label>Company For Intern</label>
      <!-- <input type="text" name="gender" value="<?php echo $gender; ?>"> -->
    <select name="company_name" >
      <option>Company Name</option>
      <?php
      $stid=$_SESSION['student_id'];
      $db1 = mysqli_connect('localhost', 'root', '', 'placement');
      $user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$stid'  LIMIT 1";
      $result = mysqli_query($db1, $user_check_query);
      //The mysqli_fetch_assoc() function fetches a result row as an associative array.
      $user = mysqli_fetch_assoc($result);
      $branch_st=$user['BRANCH'];
       $user_check_query1 = " SELECT DISTINCT company.COMPANY_NAME FROM companybranch inner join company on companybranch.COMPANY_NAME=company.COMPANY_NAME where companybranch.C_TYPE='Internship' and company.STATUS='visiting' and company.APPROVAL='approved' and companybranch.BRANCH='$branch_st' ";
       $result1 = mysqli_query($db1, $user_check_query1);
        //The mysqli_fetch_assoc() function fetches a result row as an associative array.
       // $count=mysql_num_rows($result);

       while($count=mysqli_fetch_array($result1))
       {
         // $user = mysqli_fetch_assoc($result);
        //  $ans=$user['COMPANY_NAME'] ;
        //  $count--;
        ?>
              <option> <?php echo $count["COMPANY_NAME"];  ?> </option>
      <?php

      }

      ?>

     </select>
    </div>


    <div class="input-group">
      <button type="submit" class="btn" name="apply_intern">Apply</button>
    </div>
    <p>
      Applied for the company? <a href="index_student_intern.php">Go Back</a>
    </p> 
  </form>
</body>
</html>