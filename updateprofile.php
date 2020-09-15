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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE member SET fName=%s, lName=%s, phone=%s, occupation=%s, email=%s, address=%s, county=%s, photo=%s WHERE memberId=%s",
                       GetSQLValueString($_POST['fName'], "text"),
                       GetSQLValueString($_POST['lName'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['occupation'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['photo'], "text"),
                       GetSQLValueString($_POST['memberId'], "int"));

  mysql_select_db($database_mlms, $mlms);
  $Result1 = mysql_query($updateSQL, $mlms) or die(mysql_error());

  $updateGoTo = "updateprofile.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_mlms, $mlms);
$query_updprof = "SELECT memberId, fName, lName, phone, occupation, email, address, county, photo FROM member";
$updprof = mysql_query($query_updprof, $mlms) or die(mysql_error());
$row_updprof = mysql_fetch_assoc($updprof);
$totalRows_updprof = mysql_num_rows($updprof);
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
<span class="title"   style="font-size:18px;">MLMS | Member</span>
<center>
<h2>Microfinance Loan Management system</h2>
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
      <form action="<?php echo $editFormAction; ?>" method="post" class="form" name="form1" id="form1">
      <table align="center">
      <h3>Update profile</h3>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><b>ID No/Passport No:&nbsp;&nbsp;<b></td>
          <td><?php echo $row_updprof['memberId']; ?></td>
       
          <td nowrap="nowrap" align="left"><b>First name:<b>&nbsp;&nbsp;</td>
          <td><input type="text" name="fName" readonly value="<?php echo htmlentities($row_updprof['fName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><b>Last name:&nbsp;&nbsp;<b></td>
          <td><input type="text" name="lName"  readonly value="<?php echo htmlentities($row_updprof['lName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
       
          <td nowrap="nowrap" align="left"t"><b>Phone:&nbsp;&nbsp;<b></td>
          <td><input type="text" name="phone" value="<?php echo htmlentities($row_updprof['phone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><b>Occupation:&nbsp;&nbsp;<b></td>
          <td><input type="text" name="occupation" value="<?php echo htmlentities($row_updprof['occupation'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        
          <td nowrap="nowrap" align="left"><b>Email:&nbsp;&nbsp;<b></td>
          <td><input type="text" name="email" value="<?php echo htmlentities($row_updprof['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><b>Address:&nbsp;&nbsp;<b></td>
          <td><input type="text" name="address" value="<?php echo htmlentities($row_updprof['address'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        
          <td nowrap="nowrap" align="left"><b>County:&nbsp;&nbsp;<b></td>
          <td><input type="text" name="county"  readonly value="<?php echo htmlentities($row_updprof['county'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><b>Photo:&nbsp;&nbsp;<b></td>
          <td><input type="file" name="photo" required value="<?php echo htmlentities($row_updprof['photo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
       
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Update profile" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="memberId" value="<?php echo $row_updprof['memberId']; ?>" />
    </form>
    <p>&nbsp;</p>

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
mysql_free_result($updprof);
?><?php
mysql_free_result($updprof);
?>