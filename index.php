<?php
/*
*  Created on : 26-Oct-2013, 23:37:18
*  Author     : Dan Bennett
*  Website    : http://dan-bennett.me
*/
include ("config.php");

?>
<html>
	<head>
	<title>NovaFM PRS Recording System</title>
		<LINK href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body><div id="logout"><a href="admin.php">Admin Login</a></div><center>
<div id="logo"></div>
		<div id="content">
		<h2>Presenters:</h2>
	<?php

// PRESENTERS HERE

/* connect to the db */
$connection = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($db, $connection);
/* show tables */
$result = mysql_query('SHOW TABLES', $connection) or die('cannot show tables');

while ($tableName = mysql_fetch_row($result))
	{
	$table = 'presenters';
	/* Get the presenters*/
	$result2 = mysql_query('SELECT presenter FROM ' . $table) or die('cannot show data from ' . $table);
	}

if (mysql_num_rows($result2))
	{
	echo '<table cellpadding="0" cellspacing="0" class="list">';
	$columncount = 0;
	while ($row1 = mysql_fetch_row($result2))
		{
		if ($columncount == 0)
			{
			echo '<tr>';
			}

		foreach($row1 as $key => $value)
			{
			echo '<td style="cursor:hand" onclick="window.location.href=\'playlist.php?presenter=' . urlencode($value) . '\'">', $value, '</td>';
			}

		$columncount++;

		// set columncount to 3 per row

		if ($columncount == 3)
			{
			echo '</tr>';
			$columncount = 0;
			}
		}

	echo '</table><br />';
	}

?>	
			
			
			</div>
		</div>
	</center></body>
</html>
