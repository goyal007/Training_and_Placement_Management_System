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
$student_id="";
$student_name="";
$apply_for="";
$branch="";
$status="";
$approval="";
$status_company="";
$stipend="";
$package="";
$st_mail="";

$errors = array();
$positives=array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
//session_start();
if (isset($_POST['admin_student_status'])) 
{
  // receive all input values from the form
  $company_name = mysqli_real_escape_string($db, $_POST['company_name']);
  $student_id = mysqli_real_escape_string($db, $_POST['student_id']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($student_id)) 
  { 
    array_push($errors, "Student Id is required"); 
  }
  if ($company_name=='Company Name') 
  { 
    array_push($errors, "Company Name is required"); 
  }
  $user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$student_id'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.



  $user = mysqli_fetch_assoc($result);
  if($user)
  {
  	$student_name=$user['STUDENT_NAME'];
  $apply_for=$user['APPLY_FOR'];
  $branch=$user['BRANCH'];
  $status=$user['STATUS'];
  $st_mail=$user['EMAIL'];
  if($status=='S' and $apply_for=='Internship')
  {
  	array_push($errors,"Student already got Interned");
  }
  else if($status=='S' and $apply_for=='Placement')
  {
  	array_push($errors,"Student already got Interned");
  }


  
  $user_check_query = "SELECT * FROM company WHERE COMPANY_NAME='$company_name' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  $approval=$user['APPROVAL'];
  $status_company=$user['STATUS'];
  $company_id=$user['COMPANY_ID'];
 // $st_mail=$user['EMAIL'];


$user_check_query = "SELECT * FROM companybranch WHERE COMPANY_NAME='$company_name' AND C_TYPE='$apply_for' AND BRANCH='$branch'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  $stipend=$user['MAX_STIPEND'];
  $package=$user['MAX_SALARY'];

  

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) 
  {
  	require 'class.smtp.php';
   require 'class.phpmailer.php';
   require 'credential.php';
   $mail = new PHPMailer;

    $mail->SMTPDebug = 4;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                 // SMTP username
    $mail->Password = PASS;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom(EMAIL, 'Placement and Training cell MNIT Jaipur');     // Add a recipient
        $mail->addAddress($st_mail);               // Name is optional
         //$mail->addReplyTo(EMAIL);

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Congratulations '.$student_name.'!';
        $mail->Body    = 'You got selected for the company:- '.$company_name;
        $mail->AltBody = 'New Password for non-HTML mail clients';

         if(!$mail->send()) {
           // echo 'Message could not be sent.';
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
            } 
		else {
          // echo 'Message has been sent';
               //header('location: index_student_intern.php');                   
			}



  	if($apply_for=='Internship')
  	{
  		 $query = "INSERT INTO student_internship (STUDENT_ID,COMPANY_ID,STUDENT_NAME,COMPANY_NAME,STIPEND) VALUES('$student_id','$company_id','$student_name','$company_name','$stipend')";
    	mysqli_query($db, $query);
    	$query = "UPDATE student set STATUS='S' where STUDENT_ID='$student_id'  ";
    	mysqli_query($db, $query);
    	$query = "UPDATE company set STATUS='visited' where COMPANY_NAME='$company_name'  ";
    	mysqli_query($db, $query);
    	array_push($positives, "Successfully updated the Status of Intern Student");
  	}
  	else
  	{
  		 $query = "INSERT INTO student_placement (STUDENT_ID,COMPANY_ID,STUDENT_NAME,COMPANY_NAME,PACKAGE)
          VALUES('$student_id','$company_id','$student_name','$company_name','$package')";
    	mysqli_query($db, $query);

    	$query = "UPDATE student set STATUS='S' where STUDENT_ID='$student_id'  ";
    	mysqli_query($db, $query);
    	$query = "UPDATE company set STATUS='visited' where COMPANY_NAME='$company_name'  ";
    	mysqli_query($db, $query);

    	array_push($positives, "Successfully updated the Status of Placed Student");
  	}
   
  }
  }
  else
  {
  	array_push($errors, "Student Does not exist"); 
  }
  
  
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin-Student Status</title>
  <link rel="stylesheet" type="text/css" href="1.css"> 
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body >
  <div class="list-unstyled3" >
          <ul>
            <li><a href="mnit.php"><img src="Mnit_logo.png" alt="MNIT Jaipur"  class="logo2" height="40"  align="left"/></a></li>
              <li style="float:right"><a  href="logout.php" title="<?php echo $_SESSION['admin_name']; ?> ">Log Out</a></li> 
  
            <div class="para">
            <p> Training &amp; Placement,MNIT Jaipur</p>
                </div>  
                   </ul>
          
        </div>
  <div class="header">
  	<h2>Enter Details of Placed/Intern Student</h2>
  </div>

	<form method="post" action="admin_student_status.php">
  	<?php include('wrong.php'); ?>
    <?php include('positive.php'); ?>
  	<div class="input-group">
  	  <label>Student Id</label>
  	  <input type="text" name="student_id" value="<?php echo $student_id; ?>">
  	</div>
	<div class="input-group">
      <label>Company Name</label>
      <!-- <input type="text" name="gender" value="<?php echo $gender; ?>"> -->
    <select name="company_name" >
    	<option>Company Name</option>
      <?php
      $db1 = mysqli_connect('localhost', 'root', '', 'placement');
       $user_check_query1 = " SELECT COMPANY_NAME FROM company where APPROVAL='approved'";
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
  	  <button type="submit" class="btn" name="admin_student_status">Submit</button>
  	</div>
  	<p>
      Changed the Status? <a href="index_admin.php">Go Back</a>
    </p> 
  </form>
</body>
</html>