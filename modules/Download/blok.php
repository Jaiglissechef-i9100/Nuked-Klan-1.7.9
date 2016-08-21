<?php
// -------------------------------------------------------------------------//
// Patch Block Téléchargement avec miniature, pour Nk v1.7.9.                               //
// Peut se placer dans les blocks gauche, droite, centre et bas             //
// Créé par Queytou24 sur l'idée de Ridik90.                                //
// Entraide Pour Tous - Soutien Informatique                                //
// http://www.entraide-pour-tous.fr.                                        //        
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
	die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $language, $nuked, $user, $theme;
translate("modules/Download/lang/" . $language . ".lang.php");

if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}

$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid='$bid'");
list($active) = mysql_fetch_array($sql2);
if ($active == 3 || $active == 4)
{

    if (is_file("themes/" . $theme . "/images/files.gif"))
    {
	$img = "<img src=\"themes/" . $theme . "/images/files.gif\" alt=\"\" />";
    }
    else
    {
	$img = "<img src=\"modules/Download/images/files.gif\" alt=\"\" />";
    }

    $i = 0;
}
    $sql = mysql_query("SELECT id, titre, screen FROM " . DOWNLOAD_TABLE . " WHERE " . $visiteur . " >= level ORDER BY date DESC LIMIT 0, 1");
    while (list($dl_id, $titre, $screen) = mysql_fetch_array($sql))
    {
        $titre = htmlentities($titre);
		
// Début valeur de votre miniature //

	if ($screen != "")
					{
					    $box = "<img style=\"cursor: pointer; overflow: auto; max-width: 160px; max-height: 120px; width: expression(this.scrollWidth >= 160? '160px' : 'auto'); height: expression(this.scrollHeight >= 120? '120px' : 'auto');\" src=\"" . checkimg($screen) . "\" onclick=\"document.location='index.php?file=Download&op=description&dl_id=" . $dl_id . "'\" border=\"0\" title=\"" . $titre . "\" alt=\"" . $titre . "\" />";
					}
					else
					{
					    $box = "<img style=\"cursor: pointer; overflow: auto; max-width: 160px; max-height: 120px; width: expression(this.scrollWidth >= 160? '160px' : 'auto'); height: expression(this.scrollHeight >= 120? '120px' : 'auto');\" src=\"" . checkimg('images/noimagefile.gif') . "\" onclick=\"document.location='index.php?file=Download&op=description&dl_id=" . $dl_id . "'\" border=\"0\" title=\"" . $titre . "\" alt=\"" . $titre . "\" />";
					}	

// Fin valeur de votre miniature //
					
        echo "<div style=\"text-align:center;\"><b><a href=\"index.php?file=Download&amp;op=description&amp;dl_id=" . $dl_id . "\">" . $titre . "</a></b></div><br/>\n";
        echo "<center><div>" . $box . "</div></center><br/>\n";
		echo "<div style=\"text-align:center;\"><a href=\"index.php?file=Download&amp;op=classe&amp;orderby=news\"><small>+ " . __INDEXTODL . "</small></a></div>\n";
    }

?>