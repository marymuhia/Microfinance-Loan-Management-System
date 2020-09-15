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
  $updateSQL = sprintf("UPDATE loan SET memberId=%s, loanType=%s, total_paid=%s, posting_date=%s, status=%s, adminRemark=%s, adminRemarkDate=%s WHERE loanId=%s",
                       GetSQLValueString($_POST['memberId'], "int"),
                       GetSQLValueString($_POST['loanType'], "text"),
                       GetSQLValueString($_POST['total_paid'], "int"),
                       GetSQLValueString($_POST['posting_date'], "date"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['adminRemark'], "text"),
                       GetSQLValueString($_POST['adminRemarkDate'], "date"),
                       GetSQLValueString($_POST['loanId'], "int"));

  mysql_select_db($database_mlms, $mlms);
  $Result1 = mysql_query($updateSQL, $mlms) or die(mysql_error());

  $updateGoTo = "approveloan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_mlms, $mlms);
$query_Recordset1 = "SELECT * FROM loan";
$Recordset1 = mysql_query($query_Recordset1, $mlms) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
       
     <button class="dropdown-btn">
     Loan type
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
        <td nowrap="nowrap" align="right">ID/passport No:</td>
        <td><input type="text" name="memberId" value="<?php echo htmlentities($row_Recordset1['memberId'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Loan type:</td>
        <td><input type="text" name="loanType" value="<?php echo htmlentities($row_Recordset1['loanType'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Amount:</td>
        <td><input type="text" name="total_paid" value="<?php echo htmlentities($row_Recordset1['total_paid'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Application date:</td>
        <td><input type="text" name="posting_date" value="<?php echo htmlentities($row_Recordset1['posting_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Status:</td>
        <td><select name="status">
        <option value="Approved">Approved</option>
        <option value="Unapproved">Unapproved</option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">AdminRemark:</td>
        <td><input type="text" name="adminRemark" value="" size="32" required/ ></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">AdminRemarkDate:</td>
        <td><input type="date" name="adminRemarkDate" value="" size="32" required/></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Update record" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="loanId" value="<?php echo $row_Recordset1['loanId']; ?>" />
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
mysql_free_result($Recordset1);
?>
