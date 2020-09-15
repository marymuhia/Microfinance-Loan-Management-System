<?php require_once('Connections/mlms.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO member (memberId, fName, lName, gender, phone, occupation, email, password, address, county, district, location, photo, dob, regDate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['memberId'], "int"),
                       GetSQLValueString($_POST['fName'], "text"),
                       GetSQLValueString($_POST['lName'], "text"),
                       GetSQLValueString($_POST['Gender'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['occupation'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['district'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['photo'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['regDate'], "date"));

  mysql_select_db($database_mlms, $mlms);
  $Result1 = mysql_query($insertSQL, $mlms) or die(mysql_error());
  $insertGoTo = "addmember.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="Assets/css/body.css">
<link rel="stylesheet" type="text/css" href="Assets/css/sidebar.css">
<link rel="stylesheet" type="text/css" href="Assets/css/dropdown.css" />
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css" />
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
   <a href="index.php">Member Login</a>
    <a href="admin/adminlogin.php">Admin Login</a>
  <a href="User/help.php">Help&nbsp;<b>?</b></a>  
</div>
<div id="main">
  <button class="openbtn"  onClick="openNav()">☰</button> </div>
<center>
<div class="mainn">
<h3 >Register</h3>
  <form name="form" method="POST" class="form" action="<?php echo $editFormAction; ?>"> <table>  
  <tr>
  <td>      
<label for="memberId"><b>ID No/Passport No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter Member id" pattern="[0-9]*" name="memberId" maxlength="20"required>
    <br/>   <br/>   
     </td>
     <td>
    <label for="fName"><b>First name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter First name" pattern="[a-z A-Z]*" name="fName" maxlength="20" required>
     <br/>   <br/>
     </td>
         <td>
          <label for="lName"><b>Second name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter second Name" pattern="[a-z A-Z]*" name="lName" maxlength="20"required>
     <br/>   <br/>
     </td>
     </tr>   
     <tr>
     <td>
     <label for="gender"><b>Gender:</b></label>
            <input type="radio" name="Gender" value="M" checked="checked" /><b>Male</b><input type="radio" name="Gender" value="F" maxlength="20" /><b>Female</b>
       <br/>   <br/>
     </td>
     
     <td>
     <label for="phone"><b>Phone Number: &nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter Phone number" name="phone" required maxlength="20"/>
     <br/>     <br/>
      </td>
        <td>
      <label for="occupation"><b>Occupation:</b></label>
  <select name="occupation"maxlength="20"/>
<option value="farmer">Farmer</option>
<option value="teacher">Teacher</option>
<option value="student">Student</option>
<option value="other">Other</option>
</select>
     <br/>   <br/>
     </td></tr>
      <tr>
         <td>
    
     <label for="email"><b>Email address: </b></label>
    <input type="text" placeholder="Enter Email" name="email" required maxlength="20"/>
       <br/>   <br/>
       </td>
     <td>
     <label for="password"><b>Password: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</b></label>
    <input type="password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" required maxlength="20">
          <br/>     <br/>
     </td>
    
     <td>
      <label for="address"><b>Address: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</b></label>
    <input type="text" placeholder="Enter address" name="address" required maxlength="20" required="required">
       <br/>   <br/>
         </td></tr>
    <tr>
              <td>
      <label for="county"><b>County: &nbsp;</b></label>
    <select name="county"maxlength="20"/>
<option value="mombasa">Mombasa</option>
<option value="bungoma">Bungoma</option>
<option value="nyeri">Nyeri</option>
<option value="uasin gishu">Uasin Gishu</option>
<option value="nakuru">Nakuru</option>
<option value="murang'a">Murang'a</option>
<option value="kiambu">Kiambu</option>
</select>
      <br/>   <br/>
      </td>
           <td>
      <label for="district"><b>District: </b></label>
   <select name="district" maxlength="20"/>
<option value="Kangema">Kangema</option>
<option value="kanduyi">Kanduyi</option>
<option value="Mwiki">Mwiki</option>
<option value="naivasha">Naivasha</option>
<option value="nakuru">Mathira</option>
<option value="mathioya">Mathioya</option>
<option value="kesses">Kesses</option>
</select>   <br/>   <br/>
          </td>
          
     <td>
      <label for="location"><b>Location: &nbsp;</b></label>
    <select name="location" maxlength="20"/>
<option value="githi">Githi</option>
<option value="kibabii">Kibabii</option>
<option value="butieli">Butieli</option>
<option value="konyu">Konyu</option>
<option value="free area">Free area</option>
<option value="zimmerman">Zimmerman</option>
<option value="kirigiti">Kirigiti</option>
</select>
     <br/>   <br/>
      </td>
       </tr>
        
     <tr>
      <td>
   <label for="dob"><b>Date of birth: &nbsp;&nbsp;</b></label>
    <input type="date"  name="dob" required maxlength="20" required="required">
      <br/>   <br/>
     </td>
     <td>
   <label for="photo"><b>Upload photo: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
   <input type="file" name="photo" value="" size="32" required="required">
      <br/>   <br/>
     </td>
     
     <td>
     <label for="regDate"><b>Registration date: &nbsp;</b></label>
    <input type="date"  name="regDate" min="2019-05-18" required maxlength="20"/>
      <br/>   <br/>
     </td>
     </tr>
        
     <tr>
      <td>
     <button type="submit" class="registerbtn">Register</button>
     </td>
     <td>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="reset" class="registerbtn">Reset</button>
      </td>
      <td>  <a href="index.php">Sign in</a></td>
       </tr>
        <input type="hidden" name="MM_insert" value="form" />
         
        </form>
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
