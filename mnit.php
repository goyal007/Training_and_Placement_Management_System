<?php include('server.php') ?>
<!doctype html>
<html>
<head>
  
   <link rel="shortcut icon" type="image/png" href="Mnit_logo.png">
    

	<link rel="stylesheet" type="text/css" href="stl.css">
	<title>Home-T&P MNIT Jaipur</title>

</head>
<body>

<div class="page-container">

<div class="bloc bg-repeat bgc-ghost-white l-bloc" id="bloc-0">
<div class="container bloc-sm">
<div class="row">
<div class="col-sm-12">
                <div class="logo">
				<a href="mnit.php"><img src="Mnit_logo.png" alt="MNIT Jaipur"  class="head-logo" height="60"  align="left"/></a>
			    </div>
			<h4 class=" tc-black mg-sm">
					
					<a class="ltc-black" href="mnit.php">Training &amp; Placement Cell</a>
				</h4>
				<h6 class=" mg-clear tc-1">
					 <a class="pull-left" href="http://www.mnit.ac.in" target="_blank"> Malaviya National Institute of Technology Jaipur</a><br>
				</h6>
			</div>
		</div>
	</div>
</div>

<div class="bloc b-divider l-bloc bgc-white" id="bloc-1">
	<div class="container">
		<div class="row">

			<div class="col-sm-6">
				<ul class="list-unstyled list-horizontal-layout right-align">
					<div class="navi">
						<a href="company.php" >Company</a>
					</div>
					<div class="navi">
						<a href="student.php" >Student</a>
					</div>	
					<div class="navi">
		
						<a href="admin.php" >Admin</a>
					</div>
				</ul>
			</div>
		</div>
	</div>
</div>
			

<div class="bloc bg-Home-Hero-3 bg-tr-edge bgc-united-nations-blue d-bloc" id="bloc-2">
	<div class="container">
		<div class="row">
			<div class="col-sm-123">
				<h3 class=" hero-h mg-clear tc-ghost-white">

				</h3>
			</div>
		</div>
	</div>
</div>

	
<div class="slides">
<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="m6.jpg" style="width:100%" height="425">
  <div class="text">MNIT</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="a1.jpg" style="width:100%" height="425">
  <div class="text">MNIT</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="m2.jpg" style="width:100%" height="425">
  <div class="text">MNIT</div>
</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>

<script>
var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 3000); // Change image every 3 seconds
}
</script>
</div>
	




<div class="col-sm-2">
				<h4 class="mg-md bloc-mob-center-text  tc-dim-gray">
					<a href="http://mnit.ac.in/cms/uploads/2018/07/Institute_Placement_Policy-MNIT.pdf" class="a-btn a-block bloc-mob-center-text">Placement and Training Policy</a>
					
					<a href="http://mnit.ac.in/placement/downloads/Placement_Report_2017_18.pdf" class="a-btn a-block bloc-mob-center-text">Previous Placement and Internship Report</a><br>
				</h4>
			</div>

<div class="bloc b-divider bgc-ghost-white l-bloc" id="bloc-63">
	<div class="container bloc-md">
		<div class="row">
			<div class="col-sm-2">
				
			</div>
			
			<div class="col-sm-1">
				<h4 class="mg-md bloc-mob-center-text  tc-dim-gray">
				
					<a class="a-btn a-block bloc-mob-center-text" href="http://www.mnit.ac.in/placement/index.php">About Us</a>
					<a class="a-btn a-block bloc-mob-center-text" href="http://mnit.ac.in/placement/contact.php">Contact Us</a>
				</h4>
			</div>
			<div class="col-sm-44">
				<h3 class="mg-md  text-right tc-dim-gray">
					Training &amp; Placement Office
				</h3>
				<p class="text-right">
					Ground Floor,Prabha Bhawan<br>Malaviya National Institute of Technology<br>Jaipur - 302017
				</p>
				<p class="footer3">
					<strong>Phone</strong> <br><a href="tel:+911412529065">+91-141-2529065</a> <br><a href="tel:+919549654241">+91-9549654241</a> 
				</p>
				<p class="footer4">
				<strong>Email</strong> <br><a href="http://www.mnit.ac.in/placement/index.php">placements@mnit.ac.in</a>
				</p>
			</div>
		</div>
	</div>
</div>
</div>

    

</body>
<script type="text/javascript">
	$("button").click(function() {
	    $('html,body').animate({
	        scrollTop: $(".alumni").offset().top},
	        'slow');
	});
</script>
</html>