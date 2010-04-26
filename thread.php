<?php
session_start();
$connect=mysql_connect(LORE_DB_HOST,LORE_DB_USER,LORE_DB_PASS);
$url=$_SERVER['REQUEST_URI'];
if($_GET['t']){
	$tid=$_GET['t'];
	$ep=$_GET['ep'];
	$uid=$_SESSION['uid'];
	$security_x="SELECT * FROM topics WHERE tid='$tid'";
	$security_y=mysql_db_query(LORE_DB_NAME,$security_x,$connect);
	while($security_z=mysql_fetch_array($security_y)){
		$raid=$security_z['realm'];
		$tlocked=$security_z['locked'];
		$tsticky=$security_z['sticky'];
		$tviews=$security_z['veiws'];
		$security2_x="SELECT * FROM realms WHERE aid='$raid'";
		$security2_y=mysql_db_query(LORE_DB_NAME,$security2_x,$connect);
		while($security2_z=mysql_fetch_array($security2_y)){
			$rview=$security2_z['view'];
			$rname=$security2_z['name'];
			if($rview=="T"){
				$ucolumn="r"."$raid";
				$uauth_x="SELECT $ucolumn FROM users WHERE uid='$uid'";
				$uauth_y=mysql_db_query(LORE_DB_NAME,$uauth_x,$connect);
				while($uauth_z=mysql_fetch_array($uauth_y)){
					$uauth=$uauth_z['0'];
				}
				if($uauth=="F"){
					die("<html><head><META CONTENT=\"1;URL=index.php?e=forum1denied\" HTTP-EQUIV=\"REFRESH\"></head><body bgcolor=\"#000000\">&nbsp</body></html>");
				}
			}	
		}
	}
	$name_x="SELECT name FROM posts WHERE tid='$tid' && visible='T' ORDER BY date LIMIT 1";
	$name_y=mysql_db_query(LORE_DB_NAME,$name_x,$connect);
	while($name_z=mysql_fetch_array($name_y)){
		$tname=$name_z['name'];
	}
}
else{ die("<html><head><META CONTENT=\"1;URL=index.php\" HTTP-EQUIV=\"REFRESH\"></head><body bgcolor=\"#000000\">&nbsp</body></html>"); }
?>

<html>
<head>
<title><?php print("$tname");?> | The Loréan Library</title>
<?php
 $head="head.lore";
 require $head;
?>
</head>

<body bgcolor="#000000"><span class="standard">

<center>
<img src="images/top.jpg" width="100%"><br>
<?php
if($raid==25){
 $imgindex=0;
 $dir='images/forums/aevum';
 if(is_dir($dir)){
  if($handle=opendir($dir)){
   while(($file=readdir($handle)) !== false){
    if($file!="." && $file!=".."){
     $fimglist[$imgindex]=$file;
     $imgindex++;
    }
   }
  closedir($handle);
  }
 }
 $imgindex--;
 $file=$fimglist[rand(0,$imgindex)];
 print("<a href=\"index.php\"><img src=\"images/forums/aevum/$file\" border=0></a>");
}else if($raid==27){
 $imgindex=0;
 $dir='images/forums/hex';
 if(is_dir($dir)){
  if($handle=opendir($dir)){
   while(($file=readdir($handle)) !== false){
    if($file!="." && $file!=".."){
     $fimglist[$imgindex]=$file;
     $imgindex++;
    }
   }
  closedir($handle);
  }
 }
 $imgindex--;
 $file=$fimglist[rand(0,$imgindex)];
 print("<a href=\"index.php\"><img src=\"images/forums/hex/$file\" border=0></a>");
}else{
 print("<a href=\"index.php\"><img src=\"images/title.jpg\" border=0></a>");
}
 print("<center><span class=\"big\"><h3><b>$tname</b></h3></span><a href=\"index.php\">Home</a> é <a href=\"forum.php?f=$raid\">$rname</a> é <a href=\"#\">$tname</a></center>");
 if($_GET['e']){
	print("<br><center><font color=\"#00FF00\">");
	$warning=$_GET['e'];
	$warningtext="errors/$warning.err";
	require $warningtext;
	print("</font></center>");
 }
 ?>
 </center>
 
<!-- LOGIN -->
 <?php 
 $login="login.lore";
 require $login;
?>

<TABLE WIDTH="100%"><TR>

<TD VALIGN=TOP><span class="standard">

<!-- REPLY / WARNING-->
<?php
if($_SESSION['uid']){
	if($tlocked=="F" || $uid=="1" || $uid=="2" || $uid=="3"){
		print("<div id=\"new\" style=\"display:none;\"><br><br><form action=\"control.php?c=reply\" method=\"post\">");
		print("<table align=center><tr><td colspan=2><td valign=top><span class=\"big\"><b><u>Reply</u></b></span><br><br>");
		print("<tr><td valign=top><span class=\"standard\">Message<td><td valign=top><textarea name=\"message\" cols=\"50\" rows=\"10\"></textarea>");
		if($uid=="1" || $uid=="2" || $uid=="3"){
			print("<tr><td valign=top align=right><span class=\"standard\"><img src=images/forumsticky.gif>Stickify<td><td valign=top><input type=\"checkbox\" name=\"sticky\" value=\"sticky\"");
			if($tsticky == "T"){
				print(" checked");
			}
			print(">");
			print("<tr><td valign=top align=right><span class=\"standard\"><img src=images/forumlocked.gif>Lock<td><td valign=top><input type=\"checkbox\" name=\"locked\" value=\"locked\"");
			if($tlocked == "T"){
				print(" checked");
			}
			print(">");
		}
		print("<input type=\"hidden\" value=\"$raid\" name=\"aid\"><input type=\"hidden\" value=\"$tid\" name=\"tid\"><input type=\"hidden\" value=\"$tname\" name=\"title\">");
		print("<tr><td colspan=2><td valign=top><br><input type=\"submit\" value=\"Post\"> <input type=\"button\" value=\"Cancel\" onclick=\"toggleDisplay('new');\"></table>");
		print("</form><br><br></div>");
	}
}
?>

<!-- POSTS -->
<!-- <table width="100%" frame="border" rules="all" border="2" cellpadding="2" cellspacing="2"><tr><td valign=top><span class="standard"> --><span class="standard">
<center><br><br>
<?php
	$tviews=$tviews+1;
	$view_x="UPDATE topics SET veiws='$tviews' where tid='$tid'";
	$view_y=mysql_db_query(LORE_DB_NAME,$view_x,$connect);
	if($view_y){
		$number="-1";
		$posts_x="SELECT * FROM posts WHERE tid='$tid' && visible='T' ORDER BY date ASC";
		$posts_y=mysql_db_query(LORE_DB_NAME,$posts_x,$connect);
		while($posts_z=mysql_fetch_array($posts_y)){
			$pid=$posts_z['pid'];
			$pauthor=$posts_z['author'];
			$pedited=$posts_z['edited'];
			$pdate=date('l - j F, Y - g.i A', strtotime($posts_z['date']));
			$pmessage=$posts_z['message'];
			$pmessage2=nl2br("$pmessage");
			$author_x="SELECT * from users where uid='$pauthor'";
			$author_y=mysql_db_query(LORE_DB_NAME,$author_x,$connect);
			while($author_z=mysql_fetch_array($author_y)){
				$uname=$author_z['name'];
				$uicon=$author_z['icon'];
				$uposts=$author_z['posts'];
				$usig=$author_z['sig'];
				$utitles=$author_z['titles'];
			}
			$number=$number+1;
			if($raid==27){
				$bg="/hex/images/bgimage.png";
			}else{
				$bg="images/background4.jpg";
			}
			print("<table width=\"90%\" style=\"border: 1px solid #000;\" rules=\"all\" border=2 cellpadding=2 cellspacing=2 background=$bg>");
			print("<tr><td colspan=2 valign=top background=images/black75.png><table width=\"100%\"><tr><td><span class=\"small\"><a name=\"$pid\">$pdate</a><td align=right><span class=\"small\">");
			if($number=="0"){
				print("<a href=\"#bottom\">To Bottom</a>");
			} else {
				print("<a href=\"#\">To Top</a> - $number");
			}
			print("</table>");
			print("<tr><td valign=\"top\" width=130 background=images/black50.png><span class=\"standard\"><center><br><img src=\"$uicon\"><br>$uname</center><br><font color=\"#999999\">$utitles</font>");
			print("<td valign=top><span class=\"standard\"><br><div id=\"show$pid\">");
			if($pid == $ep){
				print("<font color=\"#00FF00\">Post edited.</font><br><br>");
			}
			print("$pmessage2</div><div id=\"edit$pid\" style=\"display:none;\"><form action=\"control.php?c=edit\" method=\"post\">");
			if($number=="0"){
				print("<input type=\"text\" size=30 name=\"title\" value=\"$tname\"><br>");
			} else {
				print("<input type=\"hidden\" name=\"title\" value=\"$tname\">");
			}
			print("<textarea name=\"message\" cols=50 rows=10>$pmessage</textarea><input type=\"hidden\" name=\"pid\" value=\"$pid\"><input type=\"hidden\" name=\"tid\" value=\"$tid\"><br><input type=\"submit\" value=\"Edit\"> <input type=\"button\" value=\"Cancel\" onclick=\"toggleDisplay('edit$pid');toggleDisplay('show$pid');\"></form></div><br><br>");
			if($uid==$pauthor){
				print("<tr><td colspan=2 background=images/black75.png><span class=\"small\"><a href=\"#$pid\" onclick=\"toggleDisplay('edit$pid');toggleDisplay('show$pid');\">Edit</a> - <a href=\"control.php?c=delete&p=$pid\">Delete</a> - Posts: $uposts - <font color=\"#999999\">$usig</font>");
			}else if($uid=="1"||$uid=="2"||$uid=="3"){
				print("<tr><td colspan=2 background=images/black75.png><span class=\"small\"><a href=\"#$pid\" onclick=\"toggleDisplay('edit$pid');toggleDisplay('show$pid');\">Edit</a> - <a href=\"control.php?c=delete&p=$pid\">Delete</a> - <a href=\"pmsend.php?p=$uname\">Message</a> - <a href=\"person.php?p=$uname\">Profile</a> - Posts: $uposts - <font color=\"#999999\">$usig</font>");
			}else{
				print("<tr><td colspan=2 background=images/black75.png><span class=\"small\"><a href=\"person.php?p=$uname\">Profile</a> - <a href=\"pmsend.php?p=$uname\">Message</a> - Posts: $uposts - <font color=\"#999999\">$usig</font>");
			}
			print("</table><br><br>");
		}
		print("<a name=\"bottom\"></a>");
	}

?>
<!-- </table> -->

<TD WIDTH="150" VALIGN=TOP ALIGN=RIGHT BORDER="1" BORDERCOLOR="#999999"><span class="menu">
<br>
<?php
 if($_SESSION['uid']){
  if($tlocked=="F" || $uid=="1" || $uid=="2" || $uid=="3"){
   print("<img src=images/menuthread.jpg><br>");
   print("<a onclick=\"toggleDisplay('new');\">Reply</a><br><br>");
  }
 }
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