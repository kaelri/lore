<?php
session_start();
$connect=mysql_connect(LORE_DB_HOST,LORE_DB_USER,LORE_DB_PASS);
$url=$_SERVER['REQUEST_URI'];
?>

<html>

<head>
<title>The Loréan Library</title>
<?php
$head="head.lore";
require $head;
?>
</head>

<body bgcolor="#000000"><span class="standard">

<!-- TITLE -->
<center>
<!-- The site is undergoing top-down reconstruction. You can still use the current forum pages <a href="forum/index.php">here</a>.<br><br> -->
<img src="images/top.jpg" width="100%"><br><img src="images/title.jpg"></center>
</center>

<!-- LOGIN -->
<?php
$login="login.lore";
require $login;
?>

<TABLE WIDTH="100%"><TR>

<TD VALIGN=TOP>
	<center><br><br>
	<table width="90%" background="images/background2.jpg" bgcolor="#000000" style="border: 1px solid #000;" rules="all" border="2" cellpadding="2" cellspacing="2"><tr>

    <!-- FIRST PANE (FORUMS) -->
    <td width=400 valign=top style="border: 1px solid #000;"><span class="standard">
		<h3><b><u>Public Forums</u></b></h3>
		<ul>
		<?php
		$realms1_x="SELECT * FROM realms WHERE type='1' && subrealm='0' && aid<25 ORDER BY aid";
		$realms1_y=mysql_db_query(LORE_DB_NAME,$realms1_x,$connect);
		while($realms1_z=mysql_fetch_array($realms1_y)){
			$rname=$realms1_z['name'];
			$rview=$realms1_z['view'];
			$raid=$realms1_z['aid'];
			$rdescription=$realms1_z['description'];
			$last1_x="SELECT * FROM topics WHERE realm='$raid' ORDER BY last_post_scan DESC LIMIT 1";
			$last1_y=mysql_db_query(LORE_DB_NAME,$last1_x,$connect);
			while($last1_z=mysql_fetch_array($last1_y)){
				$tid=$last1_z['tid'];
			}
			$post_x="SELECT * FROM posts WHERE tid='$tid' && visible='T' ORDER BY date DESC LIMIT 1";
			$post_y=mysql_db_query(LORE_DB_NAME,$post_x,$connect);
			while($post_z=mysql_fetch_array($post_y)){
				$pid=$post_z['pid'];
				$pauthor=$post_z['author'];
				$pdate=date('j F, Y - g.i A', strtotime($post_z['date']));
				$pname=$post_z['name'];
			}
			$author_x="SELECT * FROM users WHERE uid='$pauthor'";
			$author_y=mysql_db_query(LORE_DB_NAME,$author_x,$connect);
			while($author_z=mysql_fetch_array($author_y)){
				$uname=$author_z['name'];
			}
			print("<li><a href=\"forum.php?f=$raid\">$rname</a><br><span class=\"small\">Last post on $pdate<br><a href=\"thread.php?t=$tid#$pid\">$pname</a> by <a href=\"person.php?p=$uname\">$uname</a><br><font color=\"#999999\">$rdescription</font></span><br><br>");
		}
		?>
		</ul>
		
		<h3><b><u>Roleplaying Forums</u></b></h3>
		<ul>
		<?php
		$realms1_x="SELECT * FROM realms WHERE type='1' && subrealm='0' && aid>24 ORDER BY aid";
		$realms1_y=mysql_db_query(LORE_DB_NAME,$realms1_x,$connect);
		while($realms1_z=mysql_fetch_array($realms1_y)){
			$rname=$realms1_z['name'];
			$rview=$realms1_z['view'];
			$raid=$realms1_z['aid'];
			$rdescription=$realms1_z['description'];
			$last1_x="SELECT * FROM topics WHERE realm='$raid' ORDER BY last_post_scan DESC LIMIT 1";
			$last1_y=mysql_db_query(LORE_DB_NAME,$last1_x,$connect);
			while($last1_z=mysql_fetch_array($last1_y)){
				$tid=$last1_z['tid'];
			}
			$post_x="SELECT * FROM posts WHERE tid='$tid' && visible='T' ORDER BY date DESC LIMIT 1";
			$post_y=mysql_db_query(LORE_DB_NAME,$post_x,$connect);
			while($post_z=mysql_fetch_array($post_y)){
				$pid=$post_z['pid'];
				$pauthor=$post_z['author'];
				$pdate=date('j F, Y - g.i A', strtotime($post_z['date']));
				$pname=$post_z['name'];
			}
			$author_x="SELECT * FROM users WHERE uid='$pauthor'";
			$author_y=mysql_db_query(LORE_DB_NAME,$author_x,$connect);
			while($author_z=mysql_fetch_array($author_y)){
				$uname=$author_z['name'];
			}
			print("<li><a href=\"forum.php?f=$raid\">$rname</a><br><span class=\"small\">Last post on $pdate<br><a href=\"thread.php?t=$tid#$pid\">$pname</a> by <a href=\"person.php?p=$uname\">$uname</a><br><font color=\"#999999\">$rdescription</font></span><br><br>");
		}
		?>
		</ul>

	<!-- SECOND PANE -->
	<td valign=top style="border: 1px solid #000;"><span class="standard">

		<!-- NEWS POST -->
		<?php
		$news_x="SELECT * FROM topics WHERE realm='11' ORDER BY last_post_scan DESC LIMIT 2";
		$news_y=mysql_db_query(LORE_DB_NAME,$news_x,$connect);
		while($news_z=mysql_fetch_array($news_y)){
			$tid=$news_z['tid'];
			$comments=$news_z['replies'];
			$newspost_x="SELECT * FROM posts WHERE tid='$tid' && visible='T' ORDER BY date ASC LIMIT 1";
			$newspost_y=mysql_db_query(LORE_DB_NAME,$newspost_x,$connect);
			while($newspost_z=mysql_fetch_array($newspost_y)){
				$pid=$newspost_z['pid'];
				$pauthor=$newspost_z['author'];
				$pdate=date('l - j F, Y - g.i A', strtotime($newspost_z['date']));
				$pname=$newspost_z['name'];
				$pmessage=$newspost_z['message'];
			}
			$newsauthor_x="SELECT * FROM users WHERE uid='$pauthor'";
			$newsauthor_y=mysql_db_query(LORE_DB_NAME,$newsauthor_x,$connect);
			while($newsauthor_z=mysql_fetch_array($newsauthor_y)){
				$uname=$newsauthor_z['name'];
				$uicon=$newsauthor_z['icon'];
			}
			$pmessage = nl2br("$pmessage");
			print("<table width=\"100%\" background=images/black50.png align=center>");
			print("<tr><td colspan=\"2\" background=images/black50.png><span class=\"standard\"><b><u>News:</u> <a href=\"thread.php?t=$tid\">$pname</a></b></span><span class=\"small\"><br>$pdate</span>");
			print("<tr><td width=\"150\" align=center valign=top><br><img src=\"$uicon\" width=45><span class=\"standard\"><br>$uname<br><br></span><span class=\"small\"><a href=\"person.php?p=$uname\">Profile</a><br><a href=\"pmsend.php?p=$uname\">Message</a><td valign=top><span class=\"standard\"><br>$pmessage");
			print("<tr><td align=center valign=bottom><span class=\"standard\"><br><a href=\"thread.php?t=$tid#bottom\">$comments comments</a><td align=right valign=bottom><span class=\"small\"><a href=\"forum.php?f=11\">More news...</a>");
			print("</table><br><br>");
		}
		?>

		<!-- WARNING -->
		<?php
		if($_GET['e']){
			print("<table width=\"100%\" background=images/black50.png><tr><td background=images/black50.png><span class=\"standard\"><b>!<tr><td><span class=\"standard\"><font color=\"#00FF00\">");
			$warning = $_GET['e'];
			$warningtext="errors/$warning.err";
			require $warningtext;
			print("</font></table><br><br>");
		}
		?>

		<!-- LOGIN/CONTROL PANEL -->
		<?php
		if($_SESSION['uid']){
			$controls_x="SELECT * FROM users where uid='$uid'";
			$controls_y=mysql_db_query(LORE_DB_NAME,$controls_x,$connect);
			while($tools_z=mysql_fetch_array($controls_y)){
				$cpass=$tools_z['pass'];
				$cposts=$tools_z['posts'];
				$cpoints=$tools_z['points'];
				$csig=$tools_z['sig'];
				$cicon=$tools_z['icon'];
				$cnotepad=$tools_z['notepad'];
				$ctitles=$tools_z['titles'];
			}
			$chost=$_SERVER['HTTP_HOST'];
			$cadd=$_SERVER['SERVER_ADDR'];
			$cremote=$_SERVER['REMOTE_ADDR'];
			print("<table width=\"100%\" background=images/black50.png><tr>");
			print("<td colspan=3 background=images/black50.png><span class=\"standard\"><b><u>Identity</u></b><br></span><span class=\"small\">Connected to $chost ($cadd) from $cremote<br><font color=\"#999999\">$csig</font></span>");
			print("<tr><td width=150 valign=top align=center><span class=\"standard\"><br><img src=\"$cicon\"><br>$name");
			print("<td width=200 valign=top><span class=\"standard\"><br>You have <a href=\"pm.php\">$new new PMs.</a><br>You have $cposts posts.<br>You have $cpoints points.");
			print("<td valign=top><span class=\"standard\"><br><u>You are</u>:<br>Rank of <a href=\"about.php?p=rules#ranks\">$ranking</a><br>$ctitles");
			print("<tr><td colspan=3><br>");
			print("<table width=\"90%\" align=center><tr>");
			print("<td width=\"50%\" valign=top><input type=\"button\" value=\"Notepad\" height=10 width=20 onclick=\"toggleDisplay('notepad');\"><div id=\"notepad\" style=\"display:none;\"><br><form action=\"control.php?c=notepad\" method=\"post\"><textarea name=\"notepad\" cols=\"40\" rows=\"9\">$cnotepad</textarea><br><input type=\"submit\" value=\"Save\"></form></div>");
			print("<td valign=top align=right><span class=\"standard\"><input type=\"button\" value=\"Options\" height=10 width=20 onclick=\"toggleDisplay('change');\"><div id=\"change\" style=\"display:none;\"><br><form action=\"control.php?c=options\" method=\"post\"><input type=\"password\" name=\"pass\" size=30 value=\"$cpass\"><br>Password<br><br><input type=\"text\" name=\"sig\" size=30 value=\"$csig\"><br>Signature<br><br><select name=\"icon\"><option value=\"$cicon\">[Keep current icon.]</option>");
			$icons_x="SELECT * FROM icons ORDER BY name";
			$icons_y=mysql_db_query(LORE_DB_NAME,$icons_x,$connect);
			while($icons_z=mysql_fetch_array($icons_y)){
				$iname=$icons_z['name'];
				$iurl=$icons_z['url'];
				print("<option value=\"$iurl\">$iname</option>");
			}
			print("</select><br><span class=\"small\"><a onClick=\"window.open('icons.php','icons','width=680,height=480,scrollbars=yes,status=no')\"><font color=\"#80C0FF\">See all icons</font></a> - </span>Icon<br><br><input type=\"Submit\" value=\"Update\"></form></div>");
			print("</table></table>");
		}
		//LOGIN
		else{
			print("<form action=\"control.php?c=login\" method=\"POST\"><table align=center>");
			print("<tr><td width=100><span class=\"standard\"><a name=\"login\">Name</a><td><input type=\"text\" name=\"name\" size=26>");
			print("<tr><td colspan=2><hr color=\"#999999\">");
			print("<tr><td><span class=\"standard\">Password<td><input type=\"password\" name=\"pass\" size=26>");
			print("<input type=\"hidden\" name=\"url\" value=\"$url\">");
			print("<tr><td colspan=2><hr color=\"#999999\">");
			print("<tr><td><input type=\"submit\" value=\"Login\">");
			print("</table></form>");
		}
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