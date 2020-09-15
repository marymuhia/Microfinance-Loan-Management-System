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

$maxRows_dispmember = 10;
$pageNum_dispmember = 0;
if (isset($_GET['pageNum_dispmember'])) {
  $pageNum_dispmember = $_GET['pageNum_dispmember'];
}
$startRow_dispmember = $pageNum_dispmember * $maxRows_dispmember;

mysql_select_db($database_mlms, $mlms);
$query_dispmember = "SELECT id, memberId, fName, lName, phone, occupation, email, address, county, regDate FROM member";
$query_limit_dispmember = sprintf("%s LIMIT %d, %d", $query_dispmember, $startRow_dispmember, $maxRows_dispmember);
$dispmember = mysql_query($query_limit_dispmember, $mlms) or die(mysql_error());
$row_dispmember = mysql_fetch_assoc($dispmember);

if (isset($_GET['totalRows_dispmember'])) {
  $totalRows_dispmember = $_GET['totalRows_dispmember'];
} else {
  $all_dispmember = mysql_query($query_dispmember);
  $totalRows_dispmember = mysql_num_rows($all_dispmember);
}
$totalPages_dispmember = ceil($totalRows_dispmember/$maxRows_dispmember)-1;

$queryString_dispmember = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_dispmember") == false && 
        stristr($param, "totalRows_dispmember") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_dispmember = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_dispmember = sprintf("&totalRows_dispmember=%d%s", $totalRows_dispmember, $queryString_dispmember);
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
<script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("id01");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
	 
       tr[i].style.display = "none";
	  
      }
    }
  }
}
</script>
<p>All members</p>
  <table border="0" align="center">
    Search: <input type="text" placeholder="search By ID/passport No..." id="myInput" onKeyUp="myFunction()"><br><br>
    <table border="1"  cellpadding="6" width="60%" cellspacing="0" bordercolor="#000000" align="center" id="id01" class="w3-table w3-bordered w3-striped w3-margin-top w3-border">
      <tr bgcolor="#33CCFF">
      <td>sr no</td>
      <td>ID/Passport No</td>
      <td>First name</td>
      <td>Last name</td>
      <td>Phone</td>
      <td>Occupation</td>
      <td>Email</td>
      <td>Address</td>
      <td>County</td>
      <td>Registration date</td>
      <td>Update</td>
      <td>Delete</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="managemember.php?recordID=<?php echo $row_dispmember['id']; ?>"> <?php echo $row_dispmember['id']; ?>&nbsp; </a></td>
        <td><?php echo $row_dispmember['memberId']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['fName']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['lName']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['phone']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['occupation']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['email']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['address']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['county']; ?>&nbsp; </td>
        <td><?php echo $row_dispmember['regDate']; ?>&nbsp; </td>
        <td><a href="updatemember.php?memberId=<?php echo $row_dispmember['memberId']; ?>" style="text-decoration:none"><font color="#0033FF">edit</font></a></td>
      <td><a href="deletemember.php?memberId=<?php echo $row_dispmember['memberId']; ?>" style="text-decoration:none"><font color="#FF0000">delete</font></a></td>
      </tr>
      <?php } while ($row_dispmember = mysql_fetch_assoc($dispmember)); ?>
  </table>
  Records <?php echo ($startRow_dispmember + 1) ?> to <?php echo min($startRow_dispmember + $maxRows_dispmember, $totalRows_dispmember) ?> of <?php echo $totalRows_dispmember ?>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_dispmember > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_dispmember=%d%s", $currentPage, 0, $queryString_dispmember); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_dispmember > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_dispmember=%d%s", $currentPage, max(0, $pageNum_dispmember - 1), $queryString_dispmember); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_dispmember < $totalPages_dispmember) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_dispmember=%d%s", $currentPage, min($totalPages_dispmember, $pageNum_dispmember + 1), $queryString_dispmember); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_dispmember < $totalPages_dispmember) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_dispmember=%d%s", $currentPage, $totalPages_dispmember, $queryString_dispmember); ?>">Last</a>
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
mysql_free_result($dispmember);
?>
