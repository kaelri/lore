<?php
session_start();
$connect=mysql_connect(LORE_DB_HOST,LORE_DB_USER,LORE_DB_PASS);
$url=$_SERVER['REQUEST_URI'];
?>

<html>
<head>
<title>The Loréan Library | Icons</title>
<?php
 $cont="head.lore";
 require $cont;
?>
</head>

<body bgcolor="#000000"><center><span class="small">

These icons are yours to choose.<br><br>
<input type="button" class="input" value="Close Window" onClick="window.close()"><br><br>
<table cellpadding="2" cellspacing="2">
<?php
	$icons_x="SELECT name,url FROM icons ORDER BY name";
	$icons_y=mysql_db_query(LORE_DB_NAME,$icons_x,$connect);
	$col="1";
	while($icons_z=mysql_fetch_array($icons_y)){
		$iid=$icons_z['iid'];
		$name=$icons_z['name'];
		$url=$icons_z['url'];
		$url="images/icons/$url";
		if($col=="5"){
			print("<td align=center valign=top width=128><span class=\"small\"><img src=\"$url\" alt=\"$iid\"><br>$name<br><br><tr>");
			$col="1";
		}
		else{
			print("<td align=center valign=top width=128><span class=\"small\"><img src=\"$url\" alt=\"$iid\"><br>$name<br><br>");
			$col=$col+1;
		}
	}
?>
</table><br><br>
<img src=images/bottom.jpg>
</center></span></body>