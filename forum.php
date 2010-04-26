<?php
session_start();
$connect=mysql_connect(LORE_DB_HOST,LORE_DB_USER,LORE_DB_PASS);
$url=$_SERVER['REQUEST_URI'];
if($_GET['f']){
	$aid=$_GET['f'];
	$uid=$_SESSION['uid'];
	$security_x="SELECT * FROM realms WHERE aid='$aid'";
	$security_y=mysql_db_query(LORE_DB_NAME,$security_x,$connect);
	while($security_z=mysql_fetch_array($security_y)){
		$rview=$security_z['view'];
		$rsub=$security_z['subrealm'];
		$rname=$security_z['name'];
		if($rview=="T"){
			$ucolumn="r"."$aid";
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
else{ die("<html><head><META CONTENT=\"1;URL=index.php\" HTTP-EQUIV=\"REFRESH\"></head><body bgcolor=\"#000000\">&nbsp</body></html>"); }
?>

<html>
<head>
<title>The Loréan Library | <?php print("$rname");?></title>
<?php $cont="head.lore"; require $cont; ?>
</head>

<body bgcolor="#000000"><span class="standard">

<!-- TITLE / WARNING -->
<center>
<img src="images/top.jpg" width="100%"><br>
<?php
if($aid==25){
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
}else if($aid==27){
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
 print("<a href=\"index.php\"><img src=\"images/forums/$aid.jpg\" border=0></a>");
}
print("<br><a href=\"index.php\">Home</a> é <a href=\"forum.php?f=$aid\">$rname</a>");
if($_GET['e']){
	print("<br><center><font color=\"#00FF00\">");
	$warning=$_GET['e'];
	$warningtext="errors/$warning.err";
	require $warningtext;
	print("</font>");
}
?>
</center>

<!-- LOGIN -->
<?php
 $login="login.lore";
 require $login;
?>
</center>

<TABLE WIDTH="100%"><TR>

<TD VALIGN=TOP><span class="standard">

<!-- NEW THREAD -->
<?php
if($_SESSION['uid']){
	print("<div id=\"new\" style=\"display:none;\"><br><br><form action=\"control.php?c=newthread\" method=\"post\">");
	print("<table align=center><tr><td colspan=2><td valign=top><span class=\"big\"><b><u>New Thread</u></b></span><br><br>");
	print("<tr><td valign=top align=right><span class=\"standard\">Title<td width=20><td valign=top><input type=\"text\" size=30 name=\"title\">");
	if($uid=="1" || $uid=="2" || $uid=="3"){
		print("<tr><td valign=top align=right><span class=\"standard\"><img src=images/forumsticky.gif>Sticky<td><td valign=top><input type=\"checkbox\" name=\"sticky\" value=\"sticky\">");
		print("<tr><td valign=top align=right><span class=\"standard\"><img src=images/forumlocked.gif>Locked<td><td valign=top><input type=\"checkbox\" name=\"locked\" value=\"locked\">");
	}
	print("<tr><td valign=top><span class=\"standard\">Message<td><td valign=top><textarea name=\"message\" cols=\"50\" rows=\"10\"></textarea>");
	print("<input type=\"hidden\" value=\"$aid\" name=\"aid\">");
	print("<tr><td colspan=2><td valign=top><br><input type=\"submit\" value=\"Post\"> <input type=\"button\" value=\"Cancel\" onclick=\"toggleDisplay('new');\"></table>");
	print("</form></div>");
}
?>

<center><br><br>
<table width="90%" background="images/background3.jpg" style="border: 1px solid #000;" rules="all" border="2" cellpadding="2" cellspacing="2"><tr><td valign=top><span class="standard">

<!-- THREAD LIST -->
<br><table width="100%">
<tr><td>&nbsp;<td width="30%" valign=top><span class="big"><u>Threads</u><td valign=top><span class="big"><u>Author</u></span><br><span class="standard"><font color="#999999">Time<td valign=top><span class="big"><u>Replies</u></span><br><span class="standard"><font color="#999999">Views<td valign=top><span class="big"><u>Last Reply</u></span><br><span class="standard"><font color="#999999">Time<br><br>
<?php
	//STICKIES
	$threads_x="SELECT * FROM topics WHERE realm='$aid' && sticky='T' ORDER BY last_post_scan DESC";
	$threads_y=mysql_db_query(LORE_DB_NAME,$threads_x,$connect);
	while($threads_z=mysql_fetch_array($threads_y)){
		$tid=$threads_z['tid'];
		$tviews=$threads_z['veiws'];
		$tlocked=$threads_z['locked'];
		$replies=$threads_z['replies'];
		$first_x="SELECT name, author, date FROM posts where tid='$tid' && visible='T' ORDER BY date ASC LIMIT 1";
		$first_y=mysql_db_query(LORE_DB_NAME,$first_x,$connect);
		while($first_z=mysql_fetch_array($first_y)){
			$ftitle=$first_z['name'];
			$fdate=date('l - j F, Y - g.i A', strtotime($first_z['date']));
			$fuid=$first_z['author'];
		}
		$last_x="SELECT name, author, date FROM posts where tid='$tid' && visible='T' ORDER BY date DESC LIMIT 1";
		$last_y=mysql_db_query(LORE_DB_NAME,$last_x,$connect);
		while($last_z=mysql_fetch_array($last_y)){
			$ltitle=$last_z['name'];
			$ldate=date('l - j F, Y - g.i A', strtotime($last_z['date']));
			$luid=$last_z['author'];
		}
		$fname_x="SELECT name FROM users WHERE uid='$fuid'";
		$fname_y=mysql_db_query(LORE_DB_NAME,$fname_x,$connect);
		while($fname_z=mysql_fetch_array($fname_y)){
			$fname=$fname_z['name'];
		}
		$lname_x="SELECT name FROM users WHERE uid='$luid'";
		$lname_y=mysql_db_query(LORE_DB_NAME,$lname_x,$connect);
		while($lname_z=mysql_fetch_array($lname_y)){
			$lname=$lname_z['name'];
		}
		if($tlocked=="T"){
			print("<tr><td valign=top><img src=\"images/forumsticky.gif\"><img src=\"images/forumlocked.gif\"><td width=\"40%\" valign=top><span class=\"standard\"><b><a href=\"thread.php?t=$tid\">$ftitle</a></b><td valign=top><span class=\"standard\">$fname</span><br><span class=\"small\"><font color=\"#999999\">$fdate<td valign=top><span class=\"standard\">$replies</span><span class=\"small\"><font color=\"#999999\">/$tviews<td valign=top><span class=\"standard\">$lname</span><br><span class=\"small\"><font color=\"#999999\">$ldate");
		}
		else{
			print("<tr><td valign=top><img src=\"images/forumsticky.gif\"><td width=\"40%\" valign=top><span class=\"standard\"><b><a href=\"thread.php?t=$tid\">$ftitle</a></b><td valign=top><span class=\"standard\">$fname</span><br><span class=\"small\"><font color=\"#999999\">$fdate<td valign=top><span class=\"standard\">$replies</span><span class=\"small\"><font color=\"#999999\">/$tviews<td valign=top><span class=\"standard\">$lname</span><br><span class=\"small\"><font color=\"#999999\">$ldate");
		}
	}
	//PAGE
	print("<tr><td colspan=5><hr color=\"#999999\" width=\"50%\">");
	if($_GET['o']){
		$o=$_GET['o'];
	}
	else{
		$o="0";
	}
	$page=($o+20)/20;
	$nextpage=$o+20;
	$prevpage=$o-20;
	if($o > 0){
		print("<tr><td colspan=5 align=center><span class=\"small\"><a href=\"forum.php?f=$aid&o=$prevpage\">é Previous Page</a> - </span><span class=\"big\"><b>$page</b></span><span class=\"small\"> - <a href=\"forum.php?f=$aid&o=$nextpage\">Next Page é</a></span>");
	}
	else{
		print("<tr><td colspan=5 align=center><span class=\"big\"><b>$page</b></span><span class=\"small\"> - <a href=\"forum.php?f=$aid&o=$nextpage\">Next Page é</a></span>");
	}
	print("<tr><td colspan=5><hr color=\"#999999\" width=\"50%\">");
	//THREADS
	$threads2_x="SELECT * FROM topics WHERE realm='$aid' && sticky='F' ORDER BY last_post_scan DESC LIMIT $o,20";
	$threads2_y=mysql_db_query(LORE_DB_NAME,$threads2_x,$connect);
	$row="sun";
	while($threads2_z=mysql_fetch_array($threads2_y)){
		$tid2=$threads2_z['tid'];
		$tviews2=$threads2_z['veiws'];
		$tlocked2=$threads2_z['locked'];
		$replies2=$threads2_z['replies'];
		$first2_x="SELECT name, author, date FROM posts where tid='$tid2' && visible='T' ORDER BY date ASC LIMIT 1";
		$first2_y=mysql_db_query(LORE_DB_NAME,$first2_x,$connect);
		while($first2_z=mysql_fetch_array($first2_y)){
			$ftitle2=$first2_z['name'];
			$fdate2=date('l - j F, Y - g.i A', strtotime($first2_z['date']));
			$fuid2=$first2_z['author'];
		}
		$last2_x="SELECT name, author, date FROM posts where tid='$tid2' && visible='T' ORDER BY date DESC LIMIT 1";
		$last2_y=mysql_db_query(LORE_DB_NAME,$last2_x,$connect);
		while($last2_z=mysql_fetch_array($last2_y)){
			$ltitle2=$last2_z['name'];
			$ldate2=date('l - j F, Y - g.i A', strtotime($last2_z['date']));
			$luid2=$last2_z['author'];
		}
		$fname2_x="SELECT name FROM users WHERE uid='$fuid2'";
		$fname2_y=mysql_db_query(LORE_DB_NAME,$fname2_x,$connect);
		while($fname2_z=mysql_fetch_array($fname2_y)){
			$fname2=$fname2_z['name'];
		}
		$lname2_x="SELECT name FROM users WHERE uid='$luid2'";
		$lname2_y=mysql_db_query(LORE_DB_NAME,$lname2_x,$connect);
		while($lname2_z=mysql_fetch_array($lname2_y)){
			$lname2=$lname2_z['name'];
		}
		
		print("<tr");
		if($row == "moon"){ print(" background=images/black50.png"); $row="sun"; } else { $row="moon"; }
		print("><td valign=top>");
		if($tlocked2=="T"){ print("<img src=\"images/forumlocked.gif\">"); }
		print("<td width=\"40%\" valign=top><span class=\"standard\"><a href=\"thread.php?t=$tid2\">$ftitle2</a><td valign=top><span class=\"standard\">$fname2</span><br><span class=\"small\"><font color=\"#999999\">$fdate2<td valign=top><span class=\"standard\">$replies2</span><span class=\"small\"><font color=\"#999999\">/$tviews2<td valign=top><span class=\"standard\">$lname2</span><br><span class=\"small\"><font color=\"#999999\">$ldate2");
	}
?>
</table>
</table><br><br>

<TD WIDTH="150" VALIGN=TOP ALIGN=RIGHT BORDER="1" BORDERCOLOR="#999999"><span class="menu">
<br>
<?php
 if($_SESSION['uid']){
  print("<img src=images/menuforum.jpg><br>");
  print("<a onclick=\"toggleDisplay('new');\">New Thread</a><br><br>");
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