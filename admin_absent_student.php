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

$student_id="";
$status="";
$errors = array();
$positives=array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
//session_start();
if (isset($_POST['admin_absent_student'])) 
{
  // receive all input values from the form
  $student_id = mysqli_real_escape_string($db, $_POST['student_id']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($student_id)) 
  { 
    array_push($errors, "Student Id is required"); 
  }
  $user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$student_id'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);


  if($user)
  {
    $status=$user['STATUS'];

if($status=='NS')
{
  $query = "UPDATE student set ABSENT=ABSENT+1 where STUDENT_ID='$student_id'  ";
      mysqli_query($db, $query);

      array_push($positives, "Successfully updated the absent of the student");
}
else
{
  array_push($errors, "Student Already got Placed/Intern"); 
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
  <title>Admin-Student Absent</title>
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
  	<h2>Enter Id of Absenty</h2>
  </div>

	<form method="post" action="admin_absent_student.php">
  	<?php include('wrong.php'); ?>
    <?php include('positive.php'); ?>
  	<div class="input-group">
  	  <label>Student Id</label>
  	  <input type="text" name="student_id" value="<?php echo $student_id; ?>">
  	</div>
	
  	<div class="input-group">
  	  <button type="submit" class="btn" name="admin_absent_student">Enter Details</button>
  	</div>
  	<p>
      Added the Absenties? <a href="index_admin.php">Go Back</a>
    </p> 
  </form>
</body>
</html>