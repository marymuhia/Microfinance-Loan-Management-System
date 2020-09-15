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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_viewpay = 10;
$pageNum_viewpay = 0;
if (isset($_GET['pageNum_viewpay'])) {
  $pageNum_viewpay = $_GET['pageNum_viewpay'];
}
$startRow_viewpay = $pageNum_viewpay * $maxRows_viewpay;

mysql_select_db($database_mlms, $mlms);
$query_viewpay = "SELECT * FROM payment";
$query_limit_viewpay = sprintf("%s LIMIT %d, %d", $query_viewpay, $startRow_viewpay, $maxRows_viewpay);
$viewpay = mysql_query($query_limit_viewpay, $mlms) or die(mysql_error());
$row_viewpay = mysql_fetch_assoc($viewpay);

if (isset($_GET['totalRows_viewpay'])) {
  $totalRows_viewpay = $_GET['totalRows_viewpay'];
} else {
  $all_viewpay = mysql_query($query_viewpay);
  $totalRows_viewpay = mysql_num_rows($all_viewpay);
}
$totalPages_viewpay = ceil($totalRows_viewpay/$maxRows_viewpay)-1;

$queryString_viewpay = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewpay") == false && 
        stristr($param, "totalRows_viewpay") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewpay = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewpay = sprintf("&totalRows_viewpay=%d%s", $totalRows_viewpay, $queryString_viewpay);
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
<h2>Microfinance Loan management system</h2>
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
<div class="container">
  <table border="0" align="center">
 <h3> All payments</h3>
    <tr bgcolor="#33CCFF">
          <td>Payment Id</td>
      <td>ID/Passport No</td>
      <td>First name</td>
      <td>Second name</td>
      <td>Amount</td>
      <td>Phone number</td>
      <td>Payment date</td>
      <td>Update</td>
       <td>Delete</td>
    </tr>
    <?php do { ?>
      <tr>
     
        <td><a href="paymentsview.php?recordID=<?php echo $row_viewpay['paymentId']; ?>"> <?php echo $row_viewpay['paymentId']; ?>&nbsp; </a></td>
        <td><?php echo $row_viewpay['memberId']; ?>&nbsp; </td>
        <td><?php echo $row_viewpay['fName']; ?>&nbsp; </td>
        <td><?php echo $row_viewpay['lName']; ?>&nbsp; </td>
        <td><?php echo $row_viewpay['amount']; ?>&nbsp; </td>
        <td><?php echo $row_viewpay['phone']; ?>&nbsp; </td>
        <td><?php echo $row_viewpay['payment_date']; ?>&nbsp; </td>
        <td><a href="updatepayment.php?paymentId=<?php echo $row_viewpay['paymentId']; ?>" style="text-decoration:none"><font color="#0033FF">edit</font></a></td>
      <td><a href="deletepayment.php?paymentId=<?php echo $row_viewpay['paymentId']; ?>" style="text-decoration:none"><font color="#FF0000">delete</font></a></td>
      </tr>
      <?php } while ($row_viewpay = mysql_fetch_assoc($viewpay)); ?>
  </table>
  Records <?php echo ($startRow_viewpay + 1) ?> to <?php echo min($startRow_viewpay + $maxRows_viewpay, $totalRows_viewpay) ?> of <?php echo $totalRows_viewpay ?>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewpay > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewpay=%d%s", $currentPage, 0, $queryString_viewpay); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewpay > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewpay=%d%s", $currentPage, max(0, $pageNum_viewpay - 1), $queryString_viewpay); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewpay < $totalPages_viewpay) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewpay=%d%s", $currentPage, min($totalPages_viewpay, $pageNum_viewpay + 1), $queryString_viewpay); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewpay < $totalPages_viewpay) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewpay=%d%s", $currentPage, $totalPages_viewpay, $queryString_viewpay); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
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
</html>
<?php
mysql_free_result($viewpay);
?>
