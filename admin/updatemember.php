<?php require_once('../Connections/mlms.php'); ?>
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

  $updateGoTo = "updatemember.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_mlms, $mlms);
$query_updmemb = "SELECT memberId, fName, lName, phone, occupation, email, address, county, photo FROM member";
$updmemb = mysql_query($query_updmemb, $mlms) or die(mysql_error());
$row_updmemb = mysql_fetch_assoc($updmemb);
$totalRows_updmemb = mysql_num_rows($updmemb);
?>
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
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table align="center">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">MemberId:</td>
        <td><?php echo $row_updmemb['memberId']; ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">FName:</td>
        <td><input type="text" name="fName" readonly value="<?php echo htmlentities($row_updmemb['fName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">LName:</td>
        <td><input type="text" name="lName" readonly value="<?php echo htmlentities($row_updmemb['lName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Phone:</td>
        <td><input type="text" name="phone" required value="<?php echo htmlentities($row_updmemb['phone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Occupation:</td>
        <td><input type="text" name="occupation" required value="<?php echo htmlentities($row_updmemb['occupation'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Email:</td>
        <td><input type="text" name="email" required value="<?php echo htmlentities($row_updmemb['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Address:</td>
        <td><input type="text" name="address" required value="<?php echo htmlentities($row_updmemb['address'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">County:</td>
        <td><input type="text" name="county" readonly value="<?php echo htmlentities($row_updmemb['county'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Photo:</td>
        <td><input type="file" name="photo" required value="<?php echo htmlentities($row_updmemb['photo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Update" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="memberId" value="<?php echo $row_updmemb['memberId']; ?>" />
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
mysql_free_result($updmemb);
?>
