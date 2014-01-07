<?php
/* 
 *  Created on : 26-Oct-2013, 23:37:18
 *  Author     : Dan Bennett
 *  Website    : http://dan-bennett.me
 */

session_start();
session_unset();
session_destroy();

header("location:index.php");
exit();

?>