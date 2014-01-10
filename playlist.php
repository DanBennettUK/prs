<?php
/*
*  Created on : 26-Oct-2013, 23:37:18
*  Author     : Dan Bennett
*  Website    : http://dan-bennett.me
*/
include ("include.php");

?>

<html>
    <head>
        <title>NovaFM PRS Recording System</title>
        <LINK href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <center>
    <div id="logout">
				<a href="index.php">Logout</a><p>
				
			</div>
		<div id="export">
			<?php
echo '<table cellpadding="0" cellspacing="0" class="export"><td style="cursor:hand" onclick="window.location.href=\'exportme.php?presenter=' . urlencode($presenter) . '\'">Export List</td></table>'; ?>
		</div>
    <div id="logo"></div>
        <!-- The Form! -->
            <form method="post" class="plform" action="<?php
$_PHP_SELF ?>">
                <table width="400" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                        <td class="heading">Artist</td>
                        <td><input class="inputpl" name="artist" type="text" id="artist" maxlength="254"></td>
                    </tr>
                    <tr>
                        <td class="heading">Title</td>
                        <td><input class="inputpl" name="title" type="text" id="title" maxlength="254"></td>
                    </tr>
                    <tr>
                        <td class="heading">Presenter</td>
                        <td><div class="inputpres" name="presenter" id="presenter" class="input"> <?php
echo $presenter; ?></select></td>
                    </tr>
                    <tr>
                        <td width="100"> </td>
                       
                        <td><input name="timeplayed" type="hidden" id="timeplayed" class="input"></td>
                    </tr>
                    <tr>
                        <td width="100"> </td>
                        <td>
                            <?php

if ($presenter == "No Presenter Set")
	{

	// Don't show submit button

	}
  else
	{
?><input name="submit" type="submit" id="submit" value="Submit" class="input">
                            	<?php
	} ?>
                        </td>
                    </tr>
                </table>
            </form>
        <?php

// GRID HERE

/* connect to the db */
$connection = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($db, $connection);
/* show tables */
$result = mysql_query('SHOW TABLES', $connection) or die('cannot show tables');
echo '<h2>History:</h2>';

while ($tableName = mysql_fetch_row($result))
	{
	$table = 'data';
	/* Get the data and pagse it hopefully*/
	if (isset($_GET["page"]))
		{
		$page = $_GET["page"];
		}
	  else
		{
		$page = 1;
		}

	$start_from = ($page - 1) * 50;
	if (isset($_POST['submitnumberentries']))
		{

		// $numberofentries = $_POST['numberofentries'];
		// $result2 = mysql_query('SELECT artist, title, presenter, timeplayed FROM '.$table.' ORDER BY id DESC LIMIT '.$start_from.','.$numberofentries.'')
		// or die('cannot show data from '.$table.'with '.$numberofentries.' enrties');

		}
	  else
		{
		$result2 = mysql_query('SELECT artist, title, timeplayed FROM ' . $table . ' WHERE presenter = "' . $presenter . '" ORDER BY id DESC LIMIT ' . $start_from . ',50') or die('cannot show data from ' . $table);
		}
	}

if (mysql_num_rows($result2))
	{
	echo '<table cellpadding="0" cellspacing="0" class="db-table">';
	echo '<tr><th>Artist</th><th>Title</th><th>Time Played</th></tr>';
	while ($row1 = mysql_fetch_row($result2))
		{
		echo '<tr>';
		echo '<td>', $row1[0], '</td>';
		echo '<td>', $row1[1], '</td>';
		echo '<td>' . date('H:i:sa | d-m-Y', strtotime($row1[2])) . '</td>';
		echo '</tr>';
		}

	echo '</table><br />';
	}
  else
	{
	echo "No Data. Get recording!";
	}

?>  
     
<!--    AMOUNT SELECTOR HERE!!!!!!!!!!
  
		<form method="post" action="<?php
$_PHP_SELF ?>">
        <select name="numberofentries" id="numbertoshow" class="input">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
        </select>
        <input name="submitnumberentries" type="submit" id="submit" value="Submit" class="input">
        </form>-->
        
        
    </center>
    </body>
</html>