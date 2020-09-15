<?php
include('Connections/mlms.php');//Start session
session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['id']) || ($_SESSION['id'] == '')) {
    header("location: index.php");
    exit();
}
$session_id=$_SESSION['id'];
$user_query = $conn->query("select * from member where memberId = '$session_id'");
$user_row = $user_query->fetch();
$name = $user_row['fName']."  ".$user_row['lName'];
?>