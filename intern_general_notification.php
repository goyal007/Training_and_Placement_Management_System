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
<!DOCTYPE html>
<html>
<head>
  <title>Notification Panel</title>
  <link rel="stylesheet" type="text/css" href="1.css"> 
  <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
  <link rel="stylesheet" type="text/css" href="stl.css">
  <link rel="stylesheet" type="text/css" href="style4.css">
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
    <h2>General Notifications</h2>
  </div>
  <center>
    <br>
<div class="container-fluid" style="width:95%">
<div id="table">
<table>
<tr>
<th>Notifications</th>
</tr>
<?php
$db = mysqli_connect('localhost', 'root', '', 'placement');

$stu_id=$_SESSION['student_id'];

$user_check_query = "SELECT * FROM intern_notification";
  $result = mysqli_query($db, $user_check_query);
  //$user = mysqli_fetch_assoc($result);
  //The mysqli_fetch_assoc() function fetches a result row as an associative array.
      


while(($count=mysqli_fetch_array($result)) )
      {
      
      
      
?>
<tr >
<td><?php echo $count['noti']; ?></td>
</tr>
<?php
      }
     // mysql_close($connection);
?>

</table>
</div>

</div>

  </center>
</body>
</html>