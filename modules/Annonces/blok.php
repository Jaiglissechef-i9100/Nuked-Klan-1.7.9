<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//

if (eregi("blok.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
	}

global $nuked, $language,$bgcolor2,$bgcolor3;
include("modules/Annonces/lang/".$language.".lang.php");
include("modules/Annonces/config.php");

function maj_block_a()
{
global $nuked;

$sql_maj=mysql_query("SELECT artid, obsol FROM " . ANNONCES_TABLE . "");
while(list($artid, $obsol) = mysql_fetch_array($sql_maj))
   {

$now=time();

if ($obsol < $now)
	{

$upd=mysql_query("UPDATE " . ANNONCES_TABLE . " SET active='0' WHERE artid = '$artid'");
	}

   }
}

function del_block_a()
{
global $nuked;

$sql_del=mysql_query("SELECT artid, obsol, url_screen FROM " . ANNONCES_TABLE . " WHERE active = '0'");
while(list($artid, $obsol, $url_screen) = mysql_fetch_array($sql_del))
   {

$now=time();
$out=(30*24*60*60);

if (($obsol + $out) < $now)
	{

$del=mysql_query ("DELETE FROM " . ANNONCES_TABLE . " WHERE artid = '$artid'");

if ($url_screen != ""){unlink($url_screen);}

	}
   }
}

maj_block_a();
del_block_a();


$sql2=mysql_query("SELECT active FROM $nuked[prefix]"._block." WHERE module='Annonces'");
list($active) = mysql_fetch_array($sql2);
if ($active==3){

$nbsql=mysql_query("SELECT artid FROM " . ANNONCES_TABLE . " WHERE active = 1");
$nb_annonces=mysql_num_rows($nbsql); 

if ($nb_annonces==0){echo" <br /><table width=\"100%\" align=\"center\" cellspacing=\"3\"><tr><td bgcolor=\"$bgcolor3\" width=\"100%\" align=\"center\" valign=\"top\"><font color=\"$bgcolor2\"><b>"._NOANNONCES."</b></font></td><tr><td>";}
else {
echo"	<br /><table width=\"100%\" align=\"center\" cellspacing=\"3\"><tr><td bgcolor=\"$bgcolor3\" width=\"50%\" align=\"center\" valign=\"top\"><font color=\"$bgcolor2\"><b>"._LAST10ART."</b></font></td><td bgcolor=\"$bgcolor3\" width=\"50%\" align=\"center\" valign=\"top\"><font color=\"$bgcolor2\"><b>"._TOP10ART."</b></font></td><tr><td>";
}


$sql=mysql_query("SELECT artid, title, counter FROM " . ANNONCES_TABLE . " WHERE active = 1 ORDER BY artid DESC LIMIT 10");
while (list($artid, $titre, $count) = mysql_fetch_row($sql)) {
$nb_annonces=mysql_num_rows($sql);
$titre = stripslashes($titre);


echo"	<li><a href=\"index.php?file=Annonces&amp;op=article&amp;artid=$artid\">$titre</a> ( $count "._READS." )";
	}

echo" </td><td>";

$sql3=mysql_query("SELECT artid, title, counter FROM " . ANNONCES_TABLE . " WHERE active = 1 ORDER BY counter DESC LIMIT 10");
while (list($tartid, $ttitre, $tcount) = mysql_fetch_row($sql3)) { 
$ttitre = stripslashes($ttitre);

echo" 	<li><a href=\"index.php?file=Annonces&amp;op=article&amp;artid=$tartid\">$ttitre</a> ( $tcount "._READS." )";
	}
echo"</td></tr></table><br /><center><form method=\"post\" action=\"index.php?file=Annonces&amp;op=add\" name=\"insert\">
<input type=\"submit\" name=\"Submit\" value=\""._INSERTION."\"></form></center>";
}


else{

echo" 	<A name= \"scrollingCode\"></A>
	<MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"80\" scrollamount= \"1\" scrolldelay= \"10\" onmouseover='this.stop()' onmouseout='this.start()'>
	<table border=\"0\" width=\"100%\">";
	
	$sql=mysql_query("SELECT artid, title, counter FROM " . ANNONCES_TABLE . " WHERE active = 1 ORDER BY artid DESC LIMIT 0,10");
	while (list($artid, $titre, $count) = mysql_fetch_row($sql)) { 
	$titre = stripslashes($titre);
	
echo "	<tr><td><li><a href=\"index.php?file=Annonces&amp;op=article&amp;artid=$artid\">$titre</a> ( $count "._READS." )</td></tr>";
	}
echo"</table></marquee>";
}

?>