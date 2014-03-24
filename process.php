<?php

/*
 *  Created on : 26-Oct-2013, 23:37:18
 *  Author     : Dan Bennett
 *  Website    : http://dan-bennett.me
 */
include ("config.php");

$artist=$_POST['artist'];
$title=$_POST['title'];
$presenter=$_POST['presenter'];
$file='nowplaying.txt';

if (empty($artist)) {
    echo "You've not set an artist!";
    }
elseif (empty($title)) {
    echo "You've not set a title!";
}
else {
    mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
    mysql_select_db("prs") or die(mysql_error());
    mysql_query("INSERT INTO `data` (artist, title, presenter) VALUES ('$artist', '$title', '$presenter')");
    echo "Your information has been successfully added to the database.";
    //file_put_contents($file, $artist, $title, FILE_APPEND | LOCK_EX);

}




 ?>
