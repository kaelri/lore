<?php
	session_start();
	$connect=mysql_connect(LORE_DB_HOST,LORE_DB_USER,LORE_DB_PASS);
	$url=$_SERVER['REQUEST_URI'];
	if($_GET['c']){
		$c=$_GET['c'];
		require "control/$c.con";
	}
	else { die("<html><head><META CONTENT=\"1;URL=index.php?e=control0\" HTTP-EQUIV=\"REFRESH\"></head><body bgcolor=\"#000000\">&nbsp</body></html>"); }
?>

<html>

<head>
<title>The Loréan Library | working</title>
<?php
 $head="head.lore";
 require $head;
?>
</head>

<body bgcolor="#000000">
