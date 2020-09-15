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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "applyloan")) {
  $insertSQL = sprintf("INSERT INTO loan (memberId, loanType, income, amount, intereset, payment_term, total_paid, emi_per_month, security, posting_date,status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['memberId'], "int"),
                       GetSQLValueString($_POST['loanType'], "text"),
                       GetSQLValueString($_POST['income'], "int"),
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['intereset'], "text"),
                       GetSQLValueString($_POST['payment_term'], "int"),
                       GetSQLValueString($_POST['total_paid'], "int"),
                       GetSQLValueString($_POST['emi_per_month'], "int"),
                       GetSQLValueString($_POST['security'], "text"),
                       GetSQLValueString($_POST['posting_date'], "date"),
					      GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_mlms, $mlms);
  $Result1 = mysql_query($insertSQL, $mlms) or die(mysql_error());

  $insertGoTo = "applyloan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_mlms, $mlms);
$query_Recordset1 = "SELECT * FROM loantype ORDER BY id DESC";
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
<span class="title"   style="font-size:18px;"> MLMS | Member</span>
<center>
<h2>Microfinance Loan Management System</h2>
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
<h3>Apply loan</h3>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="applyloan"> <table>
  <tr><td> 
<div class="input-field col  s12">
<label for="loanType"><b>Loan type:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </b></label>
<select name="loanType" autocomplete="off">
      <option value="">Select loan type...</option>
    <option><?php echo $row_Recordset1['loanType']; ?></option>
   <?php do { ?>
   <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
   <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
        <?php } // Show if not first page ?>
        <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
        <?php } // Show if not first page ?>
        <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
        <?php } // Show if not last page ?>
        <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
        <?php } // Show if not last page ?>
        Records <?php echo ($startRow_Recordset1 + 1) ?> to <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> of <?php echo $totalRows_Recordset1 ?>
    </select>
 </div>
   </td>
   <td>
   <div class="input-field col m6 s12">
   <label for="income"><b>Monthly income(Ksh):
    </b></label>
    <input type="number" name="income" pattern="[0-9]*"  required/></div>
   </td></tr>
    <script>
		function loanamount()
		{
		var original=document.getElementById("original").value;	
		var interest=document.getElementById("interest").value;	
		var year=document.getElementById("payment_term").value;	
		
		var interest1=(Number(original)*Number(interest)*Number(year))/100;
		var total=Number(original)+Number(interest1);
		
		var emi=total/(year*12);
		document.getElementById("total_paid").value=total;
		document.getElementById("emi_per_month").value=emi;
		
		}
	</script><tr><td>
   <div class="input-field col m6 s12">
   <label for="amount"><b>Loan amount(Ksh):
    </b></label>
    <input type="number" id="original" name="amount" pattern="[0-9]*"  required/></div>
    </td><td>
    <div class="input-field col m6 s12">
  <label for="intereset"><b>Loan interest(%):&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" name="intereset" id="interest" value="7" pattern="[0-9]*" readonly="true"  required></div>
    </td></tr>
    <tr><td>
  <div class="input-field col m6 s12">
  <label for="payment_term"><b>Payment term(in years):</b></label>
    <select onchange="loanamount()" name="payment_term"pattern="[0-9]*" id="payment_term"  required>
      <option value="">Term of Payment</option>
      <?php
				for($i=1;$i<=10;$i++)
				{
				echo "<option value='".$i."'>".$i."</option>";
				}
			 ?>
    </select></div>
    </td><td>
    <div class="input-field col m6 s12">
    <label for="total_paid"><b>Total Amount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" id="total_paid" name="total_paid" pattern="[0-9]*"  readonly/></div>
    </td></tr>
    <tr><td>
  <div class="input-field col m6 s12">
  <label for="emi_per_month"><b>Monthly payment:&nbsp;</b></label>
    <input type="text" id="emi_per_month" pattern="[0-9]*" name="emi_per_month"  readonly/>
   </div>
   </td>
   <td>
     <div class="input-field col m6 s12">
     <label for="bankStatementPhoto"><b>Statement Photo:</b></label>
    <input type="file" name="bankStatementPhoto" autocomplete="off" required/>
    </div>
    </td></tr>
    <tr><td>
  <div class="input-field col m6 s12">
  <label for="security"><b>Loan Security:</b></label>
    <input type="file" name="security" autocomplete="off" required/>
  </div>
  </td>
  <td>
 <div class="input-field col m6 s12">
 <label for="posting_date"><b>Application date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="date" name="posting_date" min="2019-05-24"   required/></div>
    </td>
    </tr>
    <tr><td>
     <div class="input-field col m6 s12">
     <label for="memberId"><b>ID/Passport No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" name="memberId" autocomplete="off" pattern="[0-9]*"  placeholder="Enter member id"  required/>
   </div>
</td></tr>
<tr><td>
    <button type="submit" name="apply" id="apply" class="waves-effect waves-light btn indigo m-b-xs">
   Apply</td>
 </tr>
     <input type="hidden" name="MM_insert" value="applyloan" />
     <input type="hidden" name="status" value="pending" readonly="true"  required/>
        </button>
        </table>
  </form>
                                     

  </div>                                             
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
