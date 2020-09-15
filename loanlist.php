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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_mlms, $mlms);
$query_Recordset1 = "SELECT memberId, loanType, income, amount, intereset, payment_term, total_paid, emi_per_month, posting_date, status, adminRemark FROM loan";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $mlms) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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
<span class="title"   style="font-size:18px;">CBOLMS | Member</span>
<center>
<h2>Community-Based organization loan management system</h2>
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
  <table border="1" align="center">
    <tr>
      <td>memberId</td>
      <td>loanType</td>
      <td>income</td>
      <td>amount</td>
      <td>intereset</td>
      <td>payment_term</td>
      <td>total_paid</td>
      <td>emi_per_month</td>
      <td>posting_date</td>
      <td>status</td>
      <td>adminRemark</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="lonlist.php?recordID=<?php echo $row_Recordset1['memberId']; ?>"> <?php echo $row_Recordset1['memberId']; ?>&nbsp; </a></td>
        <td><?php echo $row_Recordset1['loanType']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['income']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['amount']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['intereset']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['payment_term']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['total_paid']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['emi_per_month']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['posting_date']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['status']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['adminRemark']; ?>&nbsp; </td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_Recordset1 + 1) ?> to <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> of <?php echo $totalRows_Recordset1 ?> </div>
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
