<?php

include("config.php");
//Start session
session_start();
 
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
	header("location: login.php");
	exit();
} 
$tbl_name="presenters"; // Table name 
$all ="";

// Connect to server and select databse.
mysql_connect("$dbhost", "$dbuser", "$dbpass")or die("cannot connect"); 
mysql_select_db("$db")or die("cannot select DB");

// get value of id that sent from address bar 
$id=$_GET['id'];
echo $id;
echo "<br />";
// Delete data in mysql from row that has this id 
$sql="DELETE FROM $tbl_name WHERE presenter='".$id."'";
echo "<br />";
echo $sql;
echo "<br />";
$result=mysql_query($sql);

// if successfully deleted
if($result){
echo "Deleted Successfully";
echo "<BR>";
// echo "<a href='delete.php'>Back to main page</a>";
}

else {
echo "ERROR";
}
?> 

<?php
// close connection 
mysql_close();
header('Location: admin.php');
?>