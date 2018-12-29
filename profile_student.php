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

//session_start();
$db = mysqli_connect('localhost', 'root', '', 'placement');

//Student Profile view
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
$status="";
$errors = array();
$vari=$_SESSION['student_id'];
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$vari' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
$student_id=$user['STUDENT_ID'];
$student_name=$user['STUDENT_NAME'];
//$father_name=$user['FATHER_NAME'] ;
//$mother_name=$user['MOTHER_NAME'] ;
$dob=$user['DOB'] ;
$gender=$user['GENDER'] ;
$st_email=$user['EMAIL'] ;
$address1=$user['ADDRESS'] ;
$contact_num=$user['CONTACT_NO'] ;
$branch=$user['BRANCH'] ;
$tenth_per=$user['TENTH_PER'] ;
$tenth_pass=$user['TENTH_PASS_YEAR'] ;
$twelfth_per=$user['TWELTH_PER'] ;
$twelfth_pass=$user['TWELTH_PASS_YEAR'] ;
$cgpa=$user['CGPA'] ;
$pass=$user['PASSING_YEAR'] ;
$backlogs=$user['BACKLOGS'] ;
$apply=$user['APPLY_FOR'] ;
$status=$user['STATUS'];
if($status=='NS')
{
  $status='-';
}
else
{
  $user_check_query = "SELECT * FROM student_internship WHERE STUDENT_ID='$vari' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  $com_name=$user['COMPANY_NAME'];
  $status=$com_name;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profile of Student</title>
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
    <h2>Student Profile</h2>
  </div>
<center>
  <div style="border-radius:60px;">
<?php 
    $varie=$_SESSION['student_id'];
    $db1 = mysqli_connect('localhost', 'root', '', 'placement');
    $user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$varie' ";
    $result = mysqli_query($db1, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    echo'<img src="data:image/jpeg;base64,'.base64_encode($user['IMAGE'] ).'" height="200" width="250" class="img-thumnail" style="border-radius:15px;margin-top:20px;margin-bottom:-30px" />' ; 
    ?>
  </div>
  <div class="container" style="width:25%;border:solid;border-radius:5px;position:relative;top:50px">

    
  <br>
  <p style="padding-right:40px;"><b>Student Name :</b> <?php echo $student_name; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Student Id :</b> <?php echo $student_id; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Status :</b> <?php echo $status; ?></p>
  <br>
  <!--
  <p style="padding-right:40px;"><b>Father Name :</b> <?php //echo $father_name; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Mother Name :</b> <?php //echo $mother_name; ?></p>
  <br>
-->
  <p style="padding-right:40px;"><b>D.O.B :</b> <?php echo $dob; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Gender :</b> <?php echo $gender; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Email :</b> <?php echo $st_email; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Address:</b> <?php echo $address1; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Conatct Number :</b> <?php echo $contact_num; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Branch:</b> <?php echo $branch; ?></p>
  <br>
  <p style="padding-right:40px;"><b>10th % :</b> <?php echo $tenth_per; ?></p>
  <br>
  <p style="padding-right:40px;"><b>10th pass year :</b> <?php echo $tenth_pass; ?></p>
  <br>
  <p style="padding-right:40px;"><b>12% :</b> <?php echo $twelfth_per; ?></p>
  <br>
  <p style="padding-right:40px;"><b>12th pass year :</b> <?php echo $twelfth_pass; ?></p>
  <br>
  <p style="padding-right:40px;"><b>CGPA :</b> <?php echo $cgpa; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Final Year :</b> <?php echo $pass; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Backlogs :</b> <?php echo $backlogs; ?></p>
  <br>
  <p style="padding-right:40px;"><b>Apply For :</b> <?php echo $apply; ?></p>
  <br>

</div>
</center>
</body>
</html>
<?php
 //header("Location: logout.php");

?>