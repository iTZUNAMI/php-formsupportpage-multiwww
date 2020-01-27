<?php

//impostazioni db

function dbconn(){

$dbhost="localhost";
$dbuser="admin_quiaziende";
$dbpass="NT4HjQKu";
$dbname="admin_quiaziende";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Errore: connecting to mysql');
mysql_select_db($dbname);

}

$resultpage=15;


$header='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Gestione Richieste</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
</head>
<body>
	<div id="logo">
	<br><br><br>
		<h2>Gestione Richieste</h2>
	</div>
	<hr />
	<!-- end #logo -->
			';

			
function menu($var)

{
/*
				<li><a href="#" class="first">Home</a></li>
				<li class="current_page_item"><a href="#">Blog</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li>
*/

//def
$d='<div id="header">
		<div id="menu">
			<ul>
				'.$var.'
			</ul>
		</div>
		<!-- end #menu -->';
echo $d;
}


$header_2='
		<!-- end #search -->
		
		</div>
	<!-- end #header -->
	<!-- end #header-wrapper -->
		
		';

		
$cont='	<div id="page">
		<div id="content">';		
		
$cont_end='</div><!-- end #content -->';		


function side($var)

{
/*

						<li><a href="#">Eget tempor eget nonummy</a></li>
						<li><a href="#">Nec metus sed donec</a></li>
						<li><a href="#">Velit semper nisi molestie</a></li>
						<li><a href="#">Eget tempor eget nonummy</a></li>
						<li><a href="#">Nec metus sed donec</a></li>
*/
if ($var==1)
{
$lk='<li><a href="#">FAQ</a></li>';
}
else
{
$lk=$var;
}
$d='
<div id="sidebar">

		</div>
		<!-- end #sidebar -->';
echo $d;
}

		
		
$footer='<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page -->
	<div id="footer">
		<p>Right2copy (c) 2010 BY MATTIA</p>
	</div>
	<!-- end #footer -->
</body>
</html>';


?>