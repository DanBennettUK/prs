<?php
/*
 *  Created on : 26-Oct-2013, 23:37:18
 *  Author     : Dan Bennett
 *  Website    : http://dan-bennett.me
 */


include("config.php");


ob_start();
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($db, $conn);

$username = mysql_real_escape_string($username);
$query = "SELECT id, username, password
        FROM login
        WHERE username = '$username';";

$result = mysql_query($query);

if(mysql_num_rows($result) == 0) // User not found. So, redirect to login_form again.
{
    header('Location: login.php');
}

$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$password = md5($_REQUEST['password']);

if($password != $userData['password']) // Incorrect password. So, redirect to login_form again.
{
    //header('Location: login.php');
}else{ // Redirect to home page after successful login.
	session_regenerate_id();
	$_SESSION['sess_user_id'] = $userData['id'];
	$_SESSION['sess_username'] = $userData['username'];
	session_write_close();
	header('Location: admin.php');
}
?>
