<?php
//----------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                   //
//  http://www.nuked-klan.org                                                 //
//----------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify      //
//  it under the terms of the GNU General Public License as published by      //
//  the Free Software Foundation; either version 2 of the License.	          //
//----------------------------------------------------------------------------//

if (!defined("INDEX_CHECK")) 
{
    die ("<center>You cannot open this page directly</center>");
}

global $language, $user;

translate("modules/Portfolio/lang/".$language.".lang.php");

echo"<script type=\"text/javascript\" src=\"modules/Portfolio/script/corner.js\"></script>";

if (!$user)
{
    $visiteur = 0;
} 
else
{
    $visiteur = $user[1];
} 
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

function index()
{

global $bgcolor3, $theme, $nuked, $niveau, $admin, $visiteur;

$i=1;

opentable();

	$sql=mysql_query("SELECT id, nom FROM ".$nuked[prefix]."_portfolio_cat ORDER BY nom");
	$nb_cat = mysql_num_rows($sql);
	
echo"	<table width=\"70%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr>
		<td align=\"center\"><big><b>Portfolio</b></big></td></tr></table><br /><table align=\"center\">";

	if($nb_cat > 0)
	{
	
		while(list($id,$nom)=mysql_fetch_array($sql))
		{
			if($i == 1)
			{

				echo"<tr><td height=\"20\"></td></tr><tr><td align=\"center\" align=\"left\" style=\"width: 116px; height: 28px; background-image:url(modules/Portfolio/images/cat.gif);\" onmouseover=\"this.style.cursor='hand'\" onclick=\"window.location='index.php?file=Portfolio&op=view&nom=".$nom."'\"><a href=\"index.php?file=Portfolio&amp;op=view&amp;nom=".$nom."\"><font color=\"#666666\" size=\"2\"><b>".$nom."</b></font></a></td><td width=\"100\"></td>";

			$i++;

			}
			elseif($i == 2)
			{

				echo"<td align=\"center\" align=\"right\" style=\"width: 116px; height: 28px; background-image:url(modules/Portfolio/images/cat.gif);\" onmouseover=\"this.style.cursor='hand'\" onclick=\"window.location='index.php?file=Portfolio&op=view&nom=".$nom."'\"><a href=\"index.php?file=Portfolio&amp;op=view&amp;nom=".$nom."\"><font color=\"#666666\" size=\"2\"><b>".$nom."</b></font></a></td></tr>";

			$i=1;
			
			}
	
		}

	}
	
	else
	{
	echo"<tr><td height=\"20\"></td></tr><tr><td align=\"center\"><b>"._NOCAT."</b></font></td></tr></table>";

	}

echo" </table>";
	
	$bali = mysql_query("SELECT id, titre, cat, date, url_vignette FROM ".$nuked[prefix]."_portfolio_crea ORDER BY date DESC");
	$balo = mysql_num_rows($bali);
	
	if($balo > 0)
	{
		list($id,$titre,$cat,$date,$url_vignette)=mysql_fetch_array($bali);
		echo "<br /><br /><table width=\"70%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr><td width=\"100%\" align=\"center\"><font style=\"font-variant: small-caps;\"><b>" . _LASTCREATION . "</b></font></td></tr><tr><td width=\"100%\" align=\"center\"><a href=\"index.php?file=Portfolio&op=view&nom=" . $cat . "\"><img src=\"" . $url_vignette . "\" class=\"corner iradius16\" width=\"113\" height=\"116\" alt=\"\" border=\"2\" /></a></td></tr></table>";
	}
	else
	{
	}

echo"<br /><br />";

CloseTable();

}

function view($nom)
{

global $bgcolor3, $theme, $nuked, $niveau, $admin, $visiteur, $p, $letter, $user;

opentable();
?>
<link rel="stylesheet" type="text/css" href="modules/Portfolio/style1.css">
<script type="text/javascript" src="modules/Portfolio/highslide/highslide.js"></script>
<script type="text/javascript">
hs.graphicsDir = 'modules/Portfolio/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.outlineWhileAnimating = true;
</script>
<?php

include("modules/Vote/index.php");

$coount = mysql_query("SELECT id FROM ".$nuked[prefix]."_portfolio_crea WHERE cat='".$nom."'");
$count = mysql_num_rows($coount);

$nbcrea = mysql_query("SELECT nb_crea FROM ".$nuked[prefix]."_portfolio_pref");
$max_crea = mysql_result($nbcrea,0,nb_crea);

if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
$start = $_REQUEST['p'] * $max_crea - $max_crea;

    echo"<table width=\"80%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr>\n" 
	. "<td align=\"center\"><big><b>Portfolio de ".$nom."</b></big></td></tr></table><br /><br />";

	$sql = mysql_query("SELECT id, titre, description, cat, date, url_site, url_apercu, url_vignette FROM ".$nuked[prefix]."_portfolio_crea WHERE cat='".$nom."' ORDER BY date DESC LIMIT ".$start.",".$max_crea."");
	$nb_crea = mysql_num_rows($sql);

	while(list($id, $titre, $description, $cat, $date, $url_site, $url_apercu, $url_vignette)=mysql_fetch_array($sql))
	{
		if($nb_crea > 0)
		{
			$description = nl2br("$description");

			echo"<center><table border=\"0\" width=\"80%\">
			<tr>
			
    		<td><a href=\"".$url_apercu."\"onclick=\"return hs.expand(this)\"title=\"".$url_apercu."\"><img class=\"corner iradius16\"width=\"113\" height=\"116\" src=\"".$url_vignette."\" /></a></td>
    	
			<td valign=\"top\" width=\"100%\">
			<table width=\"100%\" height=\"120\">
			<tr>
			<td>
			<u><b>Titre</b></u> : ".$titre." <br /><br />";
			if ($description!= ""){ echo "<u><b>Description</b></u> : ".$description." <br /><br />";}
			echo"</td>
			</tr>
			<tr valign=\"bottom\">
			<td valign=\"bottom\">
			<a href=\"".$url_apercu."\" onclick=\"return hs.expand(this)\" title=\"".$titre."\"><img src=\"modules/Portfolio/images/voir.png\" border=\"0\"></a>&nbsp; &nbsp; &nbsp;<a href=\"".$url_site."\" target=\"_blank\"><img src=\"modules/Portfolio/images/net.png\" border=\"0\"></a>
    		</td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
    		<td width=\"100%\" colspan=\"2\">";
			echo"<br>";
			vote_index("Portfolio", $id);
			echo"</td>
			</tr>
			</table></center><br /><br />";
		}
		
		else
		{
			echo"<center><table border=\"0\" width=\"80%\"><tr><td><b>"._NOCREA."</b></td></tr></table>";
		}
	}
	
	if($count > $max_crea)
	{
	$url_crea = "index.php?file=Portfolio&amp;op=view&amp;nom=" . $nom;
	number($count, $max_crea, $url_crea);
	}	
	echo"<br />";	
	CloseTable();
}
}
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
}

	switch ($_REQUEST['op'])
	{
		case"index":
		index();
		break;

		case"view":
		view($_REQUEST['nom']);
		break;

		default:
		index();
	} 

?>
