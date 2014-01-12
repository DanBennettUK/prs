<?php
/*
*  Created on : 26-Oct-2013, 23:37:18
*  Author     : Dan Bennett
*  Website    : http://dan-bennett.me
*/

// OK lets export

include ("config.php");

$table = "data";
$filename = "PRS_Export_" . date("Y-m-d_H-i") . ".csv";

// if ( php_sapi_name() !== 'cli' ) {
// header("Content-type: text/csv; charset=UTF-8");
// header("Content-Disposition: attachment; filename=" . $filename . ".csv");
// readfile($filename);
// }
// create a file pointer connected to the output stream

$output = fopen("exports/$filename", 'w');

// output the column headings

fputcsv($output, array(
	'artist',
	'title',
	'presenter',
	'timeplayed'
));

// fetch the data

mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db('prs');
$rows = mysql_query('SELECT artist,title,presenter,timeplayed FROM ' . $table . ' WHERE timeplayed >= NOW() - INTERVAL 24 HOUR ORDER BY id DESC');

if ($rows === FALSE)
	{
	die(mysql_error());
	}

// loop over the rows, outputting them

while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

// file_put_contents("exports/" . $filename, $output);
// readfile("exports/'. $filename .'");

