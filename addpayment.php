<?php require_once('Connections/mlms.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO payment (paymentId, memberId, fName, lName, amount, phone, payment_date) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['paymentId'], "text"),
                       GetSQLValueString($_POST['memberId'], "int"),
                       GetSQLValueString($_POST['fName'], "text"),
                       GetSQLValueString($_POST['lName'], "text"),
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['payment_date'], "date"));

  mysql_select_db($database_mlms, $mlms);
  $Result1 = mysql_query($insertSQL, $mlms) or die(mysql_error());

  $insertGoTo = "addpayment.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="Assets/css/body.css">
<link rel="stylesheet" type="text/css" href="Assets/css/sidebar.css">
<link rel="stylesheet" type="text/css" href="Assets/css/dropdown.css" />
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css" />
</head>
<body><div class="nav">
<div class="header" class="responsive">
<span class="title"   style="font-size:18px;">MLMS | Admin!</span>
<center>
<h2>Microfinance loan management system</h2>
</center>
</div>
</div>

<div id="mySidebar" class="sidebar" class="responsive">
  <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">×</a>
   <a href="memberdash.php">Change password</a>
  <a href="updateprofile.php">Profile</a>
  
  <button class="dropdown-btn">Loan
    <i class="fa fa-caret-down"></i>
</button>
  <div class="dropdown-container">
    <a href="applyloan.php">Apply loan</a>
    <a href="loanhistory.php">Loan history</a>
      </div>
       <button class="dropdown-btn">Payment
    <i class="fa fa-caret-down"></i>
</button>
  <div class="dropdown-container">
    <a href="addpayment.php">Add payment</a>
    <a href="viewpayment.php">Payment history</a>
      </div>
      <a href="logout.php" style="text-decoration:none"><img src="Photos/logout.png" height="25px" width="25px"/><font color="#CC0000"><b>Logout</b></font></a>
    
</div>
<div id="main">
  <button class="openbtn"  onClick="openNav()">☰</button> </div>
<center>
<div class="mainn">
<div class="container">
<h3 >Add payment</h3>
   <form name="form" method="POST" class="form" action="<?php echo $editFormAction; ?>"> 
   <table>  
  <tr><td>
  <label for="paymentId"><b>Payment Id: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter payment id" name="paymentId" maxlength="20"required></td>
      <td> 
<label for="memberId"><b>ID No/Passport No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter Member id" pattern="[0-9]*" name="memberId" maxlength="20"required></td></tr>
    <tr><td>   
     
    <label for="fName"><b>First name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter First name" pattern="[a-z A-Z]*" name="fName" maxlength="20" required></td>
 <td>
          <label for="lName"><b>Second name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter second Name" pattern="[a-z A-Z]*" name="lName" maxlength="20"required>
 </td></tr><tr><td>  
     <label for="amount"><b>Amount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter amount" name="amount" maxlength="20"required></td>
    <td>
    
     <label for="phone"><b>Phone Number: &nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter Phone number" name="phone" required maxlength="20"/ required="required">
</td></tr><tr><td>
         <label for="payment_date"><b>Payment date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="date"name="payment_date" maxlength="20"required>
</td></tr><tr><td>
     <button type="submit" class="registerbtn">Add payment</button></td><td>
    
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="reset" class="registerbtn">Reset</button></td></tr>
    <input type="hidden" name="MM_insert" value="form" />   </table>
    </form>
 
   </div>

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
</html>nce