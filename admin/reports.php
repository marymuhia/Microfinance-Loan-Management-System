<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="../Assets/css/body.css">
<link rel="stylesheet" type="text/css" href="../Assets/css/sidebar.css">
<link rel="stylesheet" type="text/css" href="../Assets/css/dropdown.css" />
<link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/css/font-awesome.min.css" />
</head>
<body><div class="nav">
<div class="header" class="responsive">
<span class="title"   style="font-size:18px;">MLMS | Admin!</span>
<center>
<h2>Microfinance Loan Management system</h2>
</center>
</div>
</div>

<div id="mySidebar" class="sidebar" class="responsive">
  <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">×</a>
   <a href="dashboard.php">Dashboard</a>
  	

    	
<a href="displaymember.php">Member</a>	
       
     <button class="dropdown-btn">Loan type
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="addloantype.php">Add loan type</a>
    <a href="displayloantype.php">Manage loan type</a>
    </div>
    	
     <button class="dropdown-btn">Loan
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container"> 
   <a href="allloans.php">All loans</a>
    <a href="pendingloans.php">Pending loans</a>
    <a href="approvedloans.php">Approved loans</a>
    <a href="unapprovedloans.php">Unapproved loans</a>
    </div>
    <a href="displaypayment.php">All payments</a>
         	
  <a href="reports.php" >Reports</a>
  
    <a href="logout.php" style="text-decoration:none"><img src="../Photos/logout.png" height="25px" width="25px"/><font color="#CC0000"><b>Logout</b></font></a>
    
</div>
<div id="main">
  <button class="openbtn"  onClick="openNav()">☰</button> </div>
<center>
<div class="mainn">
<p>Click here to print members<a href="allloanss.php">loan report</a></p>

</div>
</center>
 <script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}
</script>
 
<div class="footer" align="center">
 &copy; COPYRIGHT &nbsp;<?php echo date("Y"); ?>. All Rights Reserved
</div>
</body>
</html>