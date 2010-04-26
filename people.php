<?php
session_start();
$connect=mysql_connect(LORE_DB_HOST,LORE_DB_USER,LORE_DB_PASS);
$url=$_SERVER['REQUEST_URI'];
?>

<html>
<head>
<title>The Loréan Library | People</title>
<?php
 $head="head.lore";
 require $head;
?>
</head>

<body bgcolor="#000000"><span class="standard">

<!-- TITLE -->
<center>
<img src="images/top.jpg" width="100%"><br><a href="index.php"><img src="images/title.jpg" border=0></a></center>
</center>

<!-- NAV / LOGIN -->
<?php
 print("<center><span class=\"big\"><h3><b>People</b></h3></span><a href=\"index.php\">Home</a> é <a href=\"people.php\">People</a></center>");
 $login="login.lore";
 require $login;
?>

<TABLE WIDTH="100%"><TR>

<!-- MAIN PANE -->
<TD VALIGN=TOP>
	<center><br><br>
	<table width="90%" background="images/background2.jpg" frame="border" rules=rows border="2" cellpadding="2" cellspacing="2">
	<tr background=images/black75.png><td align=center><a href="people.php"><span class="standard">Rank</span></a><td><a href="people.php?o=name"><span class="standard">Name</span></a><td><a href="people.php?o=titles"><span class="standard">Titles</span></a><td><a href="people.php?o=posts DESC, name"><span class="standard">Posts</span></a><td><a href="people.php?o=points DESC, name"><span class="standard">Points</span></a>
		<?php
		if($_GET['o']){
			$o=$_GET['o'];
		} else { $o="ranking DESC, name"; }
		$people_x="SELECT uid,ranking,name,titles,posts,points,icon FROM users WHERE posts>'0' ORDER BY $o";
		$people_y=mysql_db_query(LORE_DB_NAME,$people_x,$connect);
		$row="sun";
		while($people_z=mysql_fetch_array($people_y)){
			$uid=$people_z['uid'];
			$rank=$people_z['ranking'];
			$name=$people_z['name'];
			$titles=$people_z['titles'];
			$posts=$people_z['posts'];
			$points=$people_z['points'];
			$icon=$people_z['icon'];
			print("<tr");
			if($row=="sun"){ $row="moon"; } else { print(" background=images/black50.png"); $row="sun"; }
			print("><td align=center><span class=\"small\">$rank<td><span class=\"standard\"><img src=\"$icon\" height=16> <a href=\"person.php?p=$name\">$name</a><td><span class=\"small\">$titles<td><span class=\"small\">$posts<td><span class=\"small\">$points");
		}
		?>
	</table><br><br>

<TD WIDTH="150" VALIGN=TOP ALIGN=RIGHT BORDER="1" BORDERCOLOR="#999999"><span class="menu">
<br>
<?php
 $menu="menu.lore";
 require $menu;
?>
  
</TABLE>

<!-- COPYRIGHT -->
<?php
$footer="footer.lore";
require $footer;
?>

<!-- TRACKER -->
<center>
<?php
//$tracker="tracker.lore";
//require $tracker;
?>
</center>

</body>