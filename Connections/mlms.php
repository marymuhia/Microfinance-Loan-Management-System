<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mlms = "localhost";
$database_mlms = "lms";
$username_mlms = "root";
$password_mlms = "";
$mlms = mysql_pconnect($hostname_mlms, $username_mlms, $password_mlms) or trigger_error(mysql_error(),E_USER_ERROR); 
?>