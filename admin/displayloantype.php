<?php require_once('../Connections/mlms.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_disploantype = 10;
$pageNum_disploantype = 0;
if (isset($_GET['pageNum_disploantype'])) {
  $pageNum_disploantype = $_GET['pageNum_disploantype'];
}
$startRow_disploantype = $pageNum_disploantype * $maxRows_disploantype;

mysql_select_db($database_mlms, $mlms);
$query_disploantype = "SELECT id, loanType, `description` FROM loantype";
$query_limit_disploantype = sprintf("%s LIMIT %d, %d", $query_disploantype, $startRow_disploantype, $maxRows_disploantype);
$disploantype = mysql_query($query_limit_disploantype, $mlms) or die(mysql_error());
$row_disploantype = mysql_fetch_assoc($disploantype);

if (isset($_GET['totalRows_disploantype'])) {
  $totalRows_disploantype = $_GET['totalRows_disploantype'];
} else {
  $all_disploantype = mysql_query($query_disploantype);
  $totalRows_disploantype = mysql_num_rows($all_disploantype);
}
$totalPages_disploantype = ceil($totalRows_disploantype/$maxRows_disploantype)-1;

$queryString_disploantype = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_disploantype") == false && 
        stristr($param, "totalRows_disploantype") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_disploantype = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_disploantype = sprintf("&totalRows_disploantype=%d%s", $totalRows_disploantype, $queryString_disploantype);
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
  
  
    <a href="<?php echo $logoutAction ?>" style="text-decoration:none"><img src="../Photos/logout.png" height="25px" width="25px"/><font color="#CC0000"><b>Logout</b></font></a>
    
</div>
<div id="main">
  <button class="openbtn"  onClick="openNav()">☰</button> </div>
<center>
<div class="mainn">
<h3>Loan types</h3>
  <table border="0" align="center">
    <tr bgcolor="#33CCFF">
      <td>sr no</td>
      <td>Loan type</td>
      <td>Description</td>
      <td>Update</td>
      <td>Delete</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="manageloantype.php?recordID=<?php echo $row_disploantype['id']; ?>"> <?php echo $row_disploantype['id']; ?>&nbsp; </a></td>
        <td><?php echo $row_disploantype['loanType']; ?>&nbsp; </td>
        <td><?php echo $row_disploantype['description']; ?>&nbsp; </td>
         <td><a href="updateloantype.php?loanType=<?php echo $row_disploantype['loanType']; ?>" style="text-decoration:none"><font color="#0033FF">edit</font></a></td>
      <td><a href="deleteloantype.php?loanType=<?php echo $row_disploantype['loanType']; ?>" style="text-decoration:none"><font color="#FF0000">delete</font></a></td>
      </tr>
      <?php } while ($row_disploantype = mysql_fetch_assoc($disploantype)); ?>
  </table>
  Records <?php echo ($startRow_disploantype + 1) ?> to <?php echo min($startRow_disploantype + $maxRows_disploantype, $totalRows_disploantype) ?> of <?php echo $totalRows_disploantype ?>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_disploantype > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_disploantype=%d%s", $currentPage, 0, $queryString_disploantype); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_disploantype > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_disploantype=%d%s", $currentPage, max(0, $pageNum_disploantype - 1), $queryString_disploantype); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_disploantype < $totalPages_disploantype) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_disploantype=%d%s", $currentPage, min($totalPages_disploantype, $pageNum_disploantype + 1), $queryString_disploantype); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_disploantype < $totalPages_disploantype) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_disploantype=%d%s", $currentPage, $totalPages_disploantype, $queryString_disploantype); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
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
mysql_free_result($disploantype);
?>
