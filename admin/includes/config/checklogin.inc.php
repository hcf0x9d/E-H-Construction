<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include('config.inc.php');

$db_name="ehconstr_ehconstruction"; // Database name 
$tbl_name="tbl_users"; // Table name 

// Connect to server and select databse.
mysql_connect("$mysql_hostname", "$mysql_user", "$mysql_password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM tbl_users WHERE UserName='$myusername' and Password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
session_start();
$_SESSION["myusername"] = $myusername;

//session_register("mypassword"); 
header("location:/admin/projects/index.php");

}
else {
echo "Wrong Username or Password: " .$myusername;
}
?>