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
$st_password="";
$password="";
$st_mail="";
$errors = array();
$positives=array();
$db = mysqli_connect('localhost', 'root', '', 'placement');
if (isset($_POST['place_forgot']))
{
 
  $student_id = mysqli_real_escape_string($db, $_POST['student_id']);
  if (empty($student_id)) 
  {
    array_push($errors, "Student Id is required");
  }
  $user_check_query = "SELECT * FROM student WHERE STUDENT_ID='$student_id'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
  $user = mysqli_fetch_assoc($result);
  $st_mail=$user['EMAIL'];
  $student_name=$user['STUDENT_NAME'];

  function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
  }

  $st_password = random_password(8);
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

        $mail->Subject = 'Hello '.$student_name.'!';
        $mail->Body    = 'Your New Password is '."<br>".$st_password."<br>".
        'You can update password in the Update profile section after login';
        $mail->AltBody = 'New Password for non-HTML mail clients';

        if(!$mail->send()) {
           // echo 'Message could not be sent.';
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
            } 
    else {
          // echo 'Message has been sent';
               //header('location: index_student_intern.php');                   
      }





  if (count($errors) == 0 ) 
  {
    $password = md5($st_password);
    $query = "UPDATE student set S_PASSWORD='$password' where STUDENT_ID='$student_id'";
  //The mysqli_query() function performs a query against the database.
    $results = mysqli_query($db, $query);
      array_push($positives, "New Password is sent to your mail");
    }
  
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Placement Forgot Password</title>
  <link rel="stylesheet" type="text/css" href="1.css">
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
</head>
<body>
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
    <h2>Forgot Password</h2>
  </div>
<!--/*The PHP superglobals $_GET and $_POST are used to collect form-data.-->  
  <form method="post" action="place_forgot.php">
  <?php include('wrong.php'); ?>
  <?php include('positive.php'); ?>
  <div class="input-group">
      <label>Student Id</label>   
      <input type="text" name="student_id" >
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="place_forgot">Enter</button>
    </div>
     <p>
      Got new password?<a href="student_login_placement.php">Login</a>
    </p> 
  </form>
 
</body>
</html>s