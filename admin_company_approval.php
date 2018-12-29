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
<?php
$company_id="";
$company_name="";
$company_type="";
$website="";
$address2="";
$coming_date="";
$errors = array();
$positives=array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
if (isset($_POST['approve_company'])) 
{
  // receive all input values from the form
  $company_name = mysqli_real_escape_string($db, $_POST['company_name']);

   if ($company_name=='Company Name') 
  { 
    array_push($errors, "Select company or No company with Pending Approval"); 
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) 
  {
    $query = "update company set APPROVAL='approved' where COMPANY_NAME='$company_name'";
    mysqli_query($db, $query);

//if we want to empty all the entered details   then again initialize all the$variable_name to ""; 

    array_push($positives, "Successfully approved the company");
    //header('location: index_company.php');
  }
  
}

if (isset($_POST['disapprove_company'])) //??????????????//
{
  // receive all input values from the form
  $company_name = mysqli_real_escape_string($db, $_POST['company_name']);

   if ($company_name=='Company Name') 
  { 
    array_push($errors, "Select company or No company to reject"); 
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) 
  {
    $query = "update company set APPROVAL='rejected' where COMPANY_NAME='$company_name'";
    mysqli_query($db, $query);

    $query = "delete from companybranch where COMPANY_NAME='$company_name'";
    mysqli_query($db, $query);
    array_push($positives, "Successfully rejected the company");
    
  }
  
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Admin Change Status of Company</title>
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
    <h2>Company Approval</h2>
  </div>
<!--/*The PHP superglobals $_GET and $_POST are used to collect form-data.-->  

  <form method="post" action="admin_company_approval.php">
  <?php include('wrong.php'); ?>
  <?php include('positive.php'); ?>
 <div class="input-group">
      <label>Companies Visiting</label>
      <!-- <input type="text" name="gender" value="<?php echo $gender; ?>"> -->
    <select name="company_name" >
    	<option>Company Name</option>
      <?php
      $db1 = mysqli_connect('localhost', 'root', '', 'placement');
       $user_check_query1 = " SELECT COMPANY_NAME FROM company where STATUS='visiting' and APPROVAL='not approved' and APPROVAL<>'rejected'";
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
      <button type="submit" class="btn" name="approve_company">Approve</button>
      <button type="submit" class="btn" name="disapprove_company">Reject</button>
    </div>
    <p>
      Approved the company? <a href="index_admin.php">Go Back</a>
    </p> 
  </form>
</body>
</html>