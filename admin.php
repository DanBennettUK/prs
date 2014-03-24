<?php
/*
*  Created on : 26-Oct-2013, 23:37:18
*  Author     : Dan Bennett
*  Website    : http://dan-bennett.me
*/
?>
<?php
include ("config.php");

// Start session

session_start();

// Check whether the session variable SESS_MEMBER_ID is present or not

if (!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == ''))
	{
	header("location: login.php");
	exit();
	}

?>
<html>
	<head>
	<title>NovaFM PRS Recording System</title>
		<LINK href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body><div id="logout"><a href="logout.php">Logout</a></div><center>
	<div id="logo"></div>
	<h1>Welcome, <?php
echo $_SESSION["sess_username"] ?></h1>
	<hr>
	<br /><br />
	<div id="option"><a href="export.php">Export all data</a> (CSV)</div>
	<br /><br />
	<!--
Export <form action="">
<select name="exportpres">
<option value="">All Presenters</option>
</select>
</form>
 -->
 <hr>
<br /><br /><br />
<div id="presenters">
 <?php

// Connect to server and select database.

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die("cannot connect");
mysql_select_db("$db") or die("cannot select DB");

// select record from mysql

$sql = "SELECT * FROM presenters";
$result = mysql_query($sql);
?>
<table width="500" border="0" cellpadding="1" cellspacing="1" class="pres-table">
<tr>
<td colspan="2" bgcolor="#FFFFFF"><h3>Current Presenters</h3><font size="1">Click presenter to export data</font></td>
</tr>


<?php

while ($rows = mysql_fetch_array($result))
	{

	// echo $rows['presenter'];

?>

<tr>
<!-- <td bgcolor="#FFFFFF"><a href="exportpres.php?presenter='.urlencode($rows['presenter']).'\'" onclick="return confirm('Export data for this presenter?')"><?php
	echo $rows['presenter']; ?></a></td> -->
<?php
	echo '<td style="cursor:hand" bgcolor="#FFFFFF" onclick="window.location.href=\'exportpres.php?presenter=' . urlencode($rows['presenter']) . '\'">', $rows['presenter'], '</td>'; ?>

<td bgcolor="#FFFFFF"><a href="delete.php?id=<?php
	echo $rows['presenter']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
</tr>


<?php

	// close while loop

	}

?>

</table>

<?php

// close connection;

mysql_close();
?>
</div>
<div id="presenteradd">
<h4>Add new presenter</h4>

<form method="post" class="presaddform" action="<?php
$_PHP_SELF ?>">
                <table width="400" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                        <td class="heading">Presenter:</td>
                        <td><input name="presenter" type="text" id="presenter" maxlength="254"></td>
                    </tr>
                    <tr>
                        <td width="100"> </td>
                        <td><input name="submit" type="submit" id="submit" value="Submit" class="input" >
                        </td>
                    </tr>
                </table>
            </form>

            <?php

// $presenter = "324";

if (empty($_POST['presenter']))
	{

	// echo "<center><p><p><a href=admin.php>Go Back</a><p>";
	// die("No Presenter Set");
	// echo $presenter;

	}
  else
	{
	$presenter = $_POST['presenter'];
	}

if (isset($_POST['submit']))
	{
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	if (!$conn)
		{
		die('Could not connect: ' . mysql_error());
		}

	$sql = "INSERT INTO presenters (presenter) VALUES('" . $presenter . "')";
	mysql_select_db($db);

	// Say no to blank entries!

	if (empty($presenter))
		{
		echo "<div id='submitted'><p><p>You did not type a presenter</div>";

		//         echo "<p>";
		//         echo "<a href=admin.php>Go Back</A>";

		die();
		}
	  else
		{
		$retval = mysql_query($sql, $conn);
		if (!$retval)
			{
			die('Could not enter data, does ' . $presenter . ' exist already?');
			}

		echo "<div id='submitted'>Submitted!</div>";
		mysql_close($conn);
?><meta http-equiv="refresh" content="0"><?php
		}
	}

?>

	<div id="changepass">
<h4>Change Admin Password</h4>

	<form method="POST" action="changepass.php">
 <table>
 <tr>
 <td>Enter username:</td>
 <td><input type="text" size="10" name="username"></td>
 </tr>
 <tr>
 <td>Enter your password:</td>
 <td><input type="password" size="10" name="password"></td>
 </tr>
 </table>
 <p><input type="submit" value="Update Password">
 </form>

</div>
</div>
