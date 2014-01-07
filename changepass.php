<?php
/* 
 *  Created on : 26-Oct-2013, 23:37:18
 *  Author     : Dan Bennett
 *  Website    : http://dan-bennett.me
 */
 
 
include("config.php");
//Start session
session_start();
 
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
	header("location: login.php");
	exit();
}


//Connect to database

$conn = mysql_connect ( $dbhost, $dbuser, $dbpass)or die("Could not connect: ".mysql_error());
mysql_select_db($db, $conn) or die(mysql_error());

$username = $_POST['username'];
$password = $_POST['password'];

$query = sprintf("UPDATE prs.login SET password = MD5('".$password."') WHERE username='".$username."'");
$result = mysql_query($query);
if($result){
   echo "change success";
   header('Location: admin.php');
} else {
    echo "fail";
}