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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE member SET password=%s WHERE memberId=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['password'], "int"));

  mysql_select_db($database_mlms, $mlms);
  $Result1 = mysql_query($updateSQL, $mlms) or die(mysql_error());

  $updateGoTo = "memberdash.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_mlms, $mlms);
$query_Recordset1 = "SELECT memberId, password FROM member";
$Recordset1 = mysql_query($query_Recordset1, $mlms) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member</title>
<link rel="stylesheet" type="text/css" href="Assets/css/body.css">
<link rel="stylesheet" type="text/css" href="Assets/css/sidebar.css">
<link rel="stylesheet" type="text/css" href="Assets/css/dropdown.css" />
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css" />       
</head>
<body>

<div class="nav">
<div class="header" class="responsive">
<span class="title"   style="font-size:18px;"MLMS | Member</span>
<center>
<h2>Microfinance Loan Management system</h2>
</center>
</div>
</div>


<div id="mySidebar" class="sidebar" class="responsive">
  <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">×</a>

  
  <a href="updateprofile.php">Profile</a>
  <a href="memberdash.php">Change password</a>
  
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
  <h3>Change Password</h3>
   <form name="form" method="POST" action="<?php echo $editFormAction; ?>" class="fom">
    <table>
    <tr>
        <td><label for="memberId"><b>Member Id:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
   <input type="number" placeholder="Enter your member id" pattern="[0-9]*"size="8" name="newpassword"></td>
    </tr>
    <tr>
   <td> <label for="password"><b>Enter new password:&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
   <input type="password" placeholder="Enter new password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="password"></td>
    </tr>
    </table>
    <p><input type="submit" value="Change password">
      <input type="hidden" name="MM_update" value="form" />
    </form>
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
<?php
mysql_free_result($Recordset1);
?>
