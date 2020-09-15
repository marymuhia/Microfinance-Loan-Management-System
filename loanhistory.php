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

$maxRows_lonhist = 10;
$pageNum_lonhist = 0;
if (isset($_GET['pageNum_lonhist'])) {
  $pageNum_lonhist = $_GET['pageNum_lonhist'];
}
$startRow_lonhist = $pageNum_lonhist * $maxRows_lonhist;

mysql_select_db($database_mlms, $mlms);
$query_lonhist = "SELECT * FROM loan";
$query_limit_lonhist = sprintf("%s LIMIT %d, %d", $query_lonhist, $startRow_lonhist, $maxRows_lonhist);
$lonhist = mysql_query($query_limit_lonhist, $mlms) or die(mysql_error());
$row_lonhist = mysql_fetch_assoc($lonhist);

if (isset($_GET['totalRows_lonhist'])) {
  $totalRows_lonhist = $_GET['totalRows_lonhist'];
} else {
  $all_lonhist = mysql_query($query_lonhist);
  $totalRows_lonhist = mysql_num_rows($all_lonhist);
}
$totalPages_lonhist = ceil($totalRows_lonhist/$maxRows_lonhist)-1;

$queryString_lonhist = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_lonhist") == false && 
        stristr($param, "totalRows_lonhist") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_lonhist = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_lonhist = sprintf("&totalRows_lonhist=%d%s", $totalRows_lonhist, $queryString_lonhist);
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

    <table border="0" align="center">
    <tr><td><center><h3>Loan History</h3></center></td></tr>
          <tr bgcolor="#33CCFF" bordercolordark="#000000">
         
      <td>Id</td>
        <td width="40px">ID/Passport No</td>
        <td>Amount</td>
        <td>Monthly pay</td>
        
        <td>Application date</td>
        <td>Status</td>
        <td>Admin Remark</td>
        
      </tr>
      <?php do { ?>
        <tr>
       
          <td><a href="loanhist.php?recordID=<?php echo $row_lonhist['loanId']; ?>"> <?php echo $row_lonhist['loanId']; ?>&nbsp; </a></td>
          <td><?php echo $row_lonhist['memberId']; ?>&nbsp; </td>
          <td><?php echo $row_lonhist['total_paid']; ?>&nbsp; </td>
          <td><?php echo $row_lonhist['emi_per_month']; ?>&nbsp; </td>
          <td><?php echo $row_lonhist['posting_date']; ?>&nbsp; </td>
          <td><font color="#0066FF"><?php echo $row_lonhist['status'];?></font>&nbsp;</td>
             <td><?php echo $row_lonhist['adminRemark']; ?>&nbsp; </td>
                  </tr>
        <?php } while ($row_lonhist = mysql_fetch_assoc($lonhist)); ?>
    </table>
    Records <?php echo ($startRow_lonhist + 1) ?> to <?php echo min($startRow_lonhist + $maxRows_lonhist, $totalRows_lonhist) ?> of <?php echo $totalRows_lonhist ?> 
    <br />
    <table border="0">
      <tr>
        <td><?php if ($pageNum_lonhist > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_lonhist=%d%s", $currentPage, 0, $queryString_lonhist); ?>">First</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_lonhist > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_lonhist=%d%s", $currentPage, max(0, $pageNum_lonhist - 1), $queryString_lonhist); ?>">Previous</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_lonhist < $totalPages_lonhist) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_lonhist=%d%s", $currentPage, min($totalPages_lonhist, $pageNum_lonhist + 1), $queryString_lonhist); ?>">Next</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_lonhist < $totalPages_lonhist) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_lonhist=%d%s", $currentPage, $totalPages_lonhist, $queryString_lonhist); ?>">Last</a>
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
mysql_free_result($lonhist);
?>
