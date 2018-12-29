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
              <li style="float:right"><a  href="logout.php" title="<?php echo $_SESSION['admin_name']; ?> ">Log Out</a></li> 
  
            <div class="para">
            <p> Training &amp; Placement,MNIT Jaipur</p>
                </div>  
                   </ul>
          
        </div>
  

<div class="header">
    <h2>Registered-Placement</h2>
  </div>
  <center>
    <br>
    <div class="container-fluid" style="width:95%;">
<div id="table">
<table>
<tr>
<th>Student Id</th>
<th>Student Name</th>
<th>Company Name</th>
</tr>
<?php
$db = mysqli_connect('localhost', 'root', '', 'placement');


      $user_check_query = "SELECT * FROM registered_placements order by COMPANY_NAME";
      $result = mysqli_query($db, $user_check_query);
    


while(($count=mysqli_fetch_array($result))  )
      {
      
      
      
?>
<tr>
<td><?php echo $count['STUDENT_ID']; ?></td>
<td><?php echo $count['STUDENT_NAME']; ?></td>
<td><?php echo $count['COMPANY_NAME']; ?></td>
</tr>
<?php
      }
      
?>
</table>
</div>
</div>
  </center>
</body>
</html>