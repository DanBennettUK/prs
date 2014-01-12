<?php
/*
*  Created on : 26-Oct-2013, 23:37:18
*  Author     : Dan Bennett
*  Website    : http://dan-bennett.me
*/
?>
<html>
	<head>
		<LINK href="style.css" rel="stylesheet" type="text/css">
	</head>
</html>
<?php
include ("config.php");

if (isset($_SERVER['HTTP_REFERER'])) {
	$previous = $_SERVER['HTTP_REFERER'];
}
	

// Set presenter get
$presenter = "";

if (empty($_REQUEST['presenter']))
	{
	echo "<center><p><p><a href=index.php>Go Back</a><p>";
	die("No Presenter Set");
	}
  else
	{
	$presenter = $_REQUEST['presenter'];
	}

// Start submitting

if (isset($_POST['submit']))
	{
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	if (!$conn)
		{
		die('Could not connect: ' . mysql_error());
		}

	if (!get_magic_quotes_gpc())
		{
		$artist = addslashes($_POST['artist']);
		$title = addslashes($_POST['title']);		
		}
	  else
		{
		$artist = $_POST['artist'];
		$title = $_POST['title'];
		//$presenter = $_POST['presenter'];
		//$timeplayed = $_POST['timeplayed'];
		}

	// $date = date(Now());

	$sql = "INSERT INTO data
               (artist, title, presenter, timeplayed)
               VALUES('$artist','$title','$presenter',now())";
	mysql_select_db($db);

	// Say no to blank entries!

	if (empty($artist) or empty($title) or ($artist == "") or ($title == "") or ($artist == " ") or ($title == " "))
		{
		echo "<div id='submitted'><p><p>You did not type an artist and/or title!</div>";
		echo "<p>";
		echo "<a href=$previous>Go Back</A>";
		die();
		}
	  else
		{
		echo "<div id='submitted'>Submitted!</div>";
		$txt = "nowplaying.txt";
		if (isset($_POST['artist']) && isset($_POST['title']))
			{ // check if both fields are set
			$fh = fopen($txt, 'w');
			$txt = $_POST['artist'] . ' - ' . $_POST['title'];
			fwrite($fh, $txt); // Write information to the file
			fclose($fh); // Close the file
			}

?>
        <script type="text/javascript"> 
			window.onload = function () { 
  			setTimeout(function () { 
   			var div = document.getElementById('submitted'); 
    		div.innerHTML = '';  
  			}, 5000); 
			} 
		</script> <?php
		}

	$retval = mysql_query($sql, $conn);
	if (!$retval)
		{
		die('Could not enter data: ' . mysql_error());
		}

	mysql_close($conn);
	}
