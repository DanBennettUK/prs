<?php
/* 
 *  Created on : 26-Oct-2013, 23:37:18
 *  Author     : Dan Bennett
 *  Website    : http://dan-bennett.me
 */
 


//OK lets export
include("config.php");
$table = "data";
$filename = "PRS_Export_" . date("Y-m-d_H-i");

header("Content-type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=" . $filename . ".csv");
//connection
$con = mysql_connect($dbhost,$dbuser,$dbpass);
if(!$con){
    echo "Error connection";
}
//select db
$select_db = mysql_select_db($db, $con);
if(!$select_db){
    echo "Error to select database";
}
mysql_set_charset("utf8", $con);

//Mysql query to get records from datanbase
$user_query = mysql_query('SELECT * FROM '.$table.' WHERE timeplayed >= NOW() - INTERVAL 1 DAY ORDER BY id DESC');

//While loop to fetch the records
$contents = "artist,title,presenter,time played\n";
while($row = mysql_fetch_array($user_query))
{
    $contents.=$row['artist'].",";
    $contents.=$row['title'].",";
    $contents.=$row['presenter'].",";
    $contents.=$row['timeplayed']."\n";
}

$contents_final = chr(255).chr(254).mb_convert_encoding($contents, "UTF-16LE","UTF-8");
print $contents_final;
?>