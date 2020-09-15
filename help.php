<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home page</title>
<link rel="stylesheet" type="text/css" href="Assets/css/alpha.css">
<link rel="stylesheet" type="text/css" href="Assets/css/sidebar.css">
</head>

<body>
<div class="nav">
<div class="header" class="responsive">
<span class="title"   style="font-size:18px;">MLMS | Member</span>
<center>
<h2>Microfinance Loan Management system</h2>
</center>
</div>
</div>

<div id="mySidebar" class="sidebar" class="responsive">
  <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">×</a>
  <a href="index.php">Member Login</a>
   <a href="admin/adminlogin.php">Admin Login</a>
  <a href="help.php">Help&nbsp;<b>?</b></a>
   </div>
   <div id="main">
  <button class="openbtn"  onClick="openNav()">☰</button> </div>
<center>
<div class="mainn">
  <fieldset><center><label><b>Register<b></label></center>
  <p>Click on the link below "Dont have an account?Register" to create your account. </p><p>After entering your information click on the sisgn in link to login with your provided details.</p>
  <fieldset><center><label><b>Apply loan<b></label></center>
  <p>If you want to apply for the loan. First login to you account then go to the navigation sidebar and click the loan button and then click the apply loan link.</p>
  <p>Then enter the requested requirements for loan required and click apply</p>
  <fieldset><center><label><b>Check loan status</b></label></center>
  <p>To check on the status of the loan click the loan link and go to loan history to check on your loan status</p>
  <p>If you see on the status 'pending', your loan request has not yet been approved.</p>
  <p>If you see on the status 'Approved', your loan request has been approved.</p>
  <p>If you see on the status 'Not approved', your loan request has not been approved.</p>
  <fieldset><center><label><b>Payment</b></label></center>
  <p>To make payment click on the payment on the navigation bar to make payment.</p>
  <p>Also check on all payments by clicking on the payment history to check your history and print the report.</p>
  </fieldset>
  </fieldset>
  
  
  
  </fieldset>
  
  
  
  </fieldset>
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
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>

<div class="footer" align="center">
 &copy; COPYRIGHT &nbsp;<?php echo date("Y"); ?>. All Rights Reserved
  </div>
     </body>
</html>