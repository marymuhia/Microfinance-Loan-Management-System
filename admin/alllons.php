<?php require_once('../Connections/comm.php'); ?><?php
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

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_comm, $comm);
$query_DetailRS1 = sprintf("SELECT * FROM loan WHERE loanId = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $comm) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../Assets/css/body.css">
</head>
<center>
<body bgcolor="#CCCCCC" marginheight=""="60%" marginwidth="40%">
<div class="container">
<script> 
function printdocument(){
a=document.getElementById("alllons").innerHTML;
document.write(a);
window.print();}
</script>
<div id="alllons">
<center>Community based organization loan management system</center>
<p align="left">ID/passport Number of applicant:<font color="#0066FF"><?php echo $row_DetailRS1['memberId']; ?></font></p><br />
  <p align="left">loan type applied:<font color="#0066FF"><?php echo $row_DetailRS1['loanType']; ?></font></p><br />
<p align="left"> income per month:<font color="#0066FF"><?php echo $row_DetailRS1['income']; ?></font></p><br />
   <p align="left">income statement Photo:<font color="#0066FF"><?php echo $row_DetailRS1['bankStatementPhoto']; ?></font></p><br />
  <p align="left">security in case of not paying:<font color="#0066FF"><?php echo $row_DetailRS1['security']; ?></font></p><br />
  <p align="left">Application date:<font color="#0066FF"><?php echo $row_DetailRS1['posting_date']; ?></font></p><br />
  <p align="left">Status:<font color="#0066FF"><?php echo $row_DetailRS1['status']; ?></font></p><br />
  <p align="right"><input type="button" value="Print" onclick="printdocument()"/> 
  </div>
</body>
</center>
</html><?php
mysql_free_result($DetailRS1);
?>