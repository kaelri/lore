<?php
session_start();
$connect=mysql_connect(LORE_DB_HOST,LORE_DB_USER,LORE_DB_PASS);
$url=$_SERVER['REQUEST_URI'];
if($_GET['p']){
	$page=$_GET['p'];
}
else{
	$page="about";
}
?>

<html>

<head>
<?php
print("<title>The Loréan Library | ");
$pagetitle="about/".$page."1.txt";
require $pagetitle;
print("</title>");
$head="head.lore";
require $head;
?>
</head>

<body bgcolor="#000000"><span class="standard">

<!-- TITLE -->
<center>
<img src="images/top.jpg" width="100%"><br><img src="images/title.jpg"></center>
</center>

<!-- LOGIN -->
<?php
$pagehead="about/".$page."2.txt";
require $pagehead;
$login="login.lore";
require $login;
?>

<TABLE WIDTH="100%"><TR>

<!-- MAIN PANE -->
<TD VALIGN=TOP>
	<center><br><br>
	<table width="90%" background="images/background2.jpg" frame="border" rules="all" border="2" cellpadding="2" cellspacing="2"><tr>
	<td valign=top><span class="standard">
		<?php
		$pagebody="about/".$page."3.txt";
		require $pagebody;
		?>
	</table>
	<br><br></center>

<!-- MENU -->
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