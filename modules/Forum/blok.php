<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}


global $nuked, $file, $language, $user, $bgcolor3, $bgcolor2, $bgcolor1;
translate("modules/Forum/lang/" . $language . ".lang.php");
define('FORUM_PRIMAIRE_TABLE', $nuked['prefix'] . '_forums_primaire');

if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}

$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);

if ($active == 3 || $active == 4)
{
    echo "<table style=\"background: " . $bgcolor3 . ";\" border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"4\">\n"
    . "<tr style=\"background: " . $bgcolor3 . ";\">\n"
    . "<td style=\"width: 35%;\" align=\"center\"><b>" . _SUBJECTS . "</b></td>\n"
    . "<td style=\"width: 15%;\" align=\"center\"><b>" . _AUTHOR . "</b></td>\n"
    . "<td style=\"width: 10%;\" align=\"center\"><b>" . _ANSWERS . "</b></td>\n"
    . "<td style=\"width: 10%;\" align=\"center\"><b>" . _VIEWS . "</b></td>\n"
    . "<td style=\"width: 30%;\" align=\"center\"><b>" . _LASTPOST . "</b></td></tr>\n";

    $sql = mysql_query("SELECT FTT.id, FTT.titre, FTT.date, FTT.auteur, FTT.auteur_id, FTT.view, FTT.closed, FTT.forum_id FROM " . FORUM_THREADS_TABLE . " AS FTT INNER JOIN " . FORUM_TABLE . " AS FT ON FT.id = FTT.forum_id WHERE FT.niveau <= '" . $visiteur . "' ORDER BY last_post DESC LIMIT 0, 10");
    while (list($thread_id, $titre, $datepost, $auteur, $auteur_id, $nb_read, $closed, $forum_id) = mysql_fetch_row($sql))
    {
        $auteur = nk_CSS($auteur);

        $title = printSecuTags($titre);
        $title = preg_replace("`&amp;lt;`i", "&lt;", $title);
        $title = preg_replace("`&amp;gt;`i", "&gt;", $title);
        $title = nk_CSS($title);

             $newsdate = time() - 86400;
             $att = "";

             if ($datepost!="" && $datepost > $newsdate) $att = "&nbsp;<img alt=\"Update\" src=\"modules/Forum/images/new_message.png\" style=\"vertical-align: middle;\" />";
       
       
        $sql3 = mysql_query("SELECT thread_id FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "'");
        $nb_rep = mysql_num_rows($sql3) - 1;

        $sql4 = mysql_query("SELECT MAX(id) from " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "'");
        $idmax = mysql_result($sql4, 0, "MAX(id)");

        $sql5 = mysql_query("SELECT date, auteur, auteur_id, txt FROM " . FORUM_MESSAGES_TABLE . " WHERE id = '" . $idmax . "'");
        list($last_date, $last_auteur, $last_auteur_id, $txt) = mysql_fetch_array($sql5);
        $last_datefixe = ftime($last_date);

             $newsdateupdate = time() - 86400;
             $attupdate = "";

             if ($last_date!="" && $nb_rep > 0 && $last_date > $newsdateupdate) $attupdate = "&nbsp;<img alt=\"Update\" src=\"Includes/blocks/images/maj.gif\" style=\"vertical-align: middle;\" />";
    
        $last_auteur = nk_CSS($last_auteur);

        if ($auteur_id != "")
        {
            $sql6 = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $auteur_id . "'");
            $test = mysql_num_rows($sql6);
            list($autor) = mysql_fetch_array($sql6);

            if ($test > 0 && $autor != "")
            {
                $initiat = "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($autor) . "\"><b>" . $autor . "</b></a>";
            }
            else
            {
                $initiat = "<b>" . $auteur . "</b>";
            }
        }
        else
        {
            $initiat = "<b>" . $auteur . "</b>";
        }

        if ($last_auteur_id != "")
        {
            $sql7 = mysql_query("SELECT avatar, pseudo FROM " . USER_TABLE . " WHERE id = '" . $last_auteur_id . "'");
            $test1 = mysql_num_rows($sql7);
            list($avatar, $last_autor) = mysql_fetch_array($sql7);

				if($avatar) {				
				$avatarok = $avatar;
				} else { $avatarok = "modules/Members/images/pasavatar.png";
			    }
			    
            if ($test1 > 0 && $last_autor != "")
            {
                $author = "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($last_autor) . "\"><b>" . $last_autor . "</b></a>";
            }
            else
            {
                $author = "<b>" . $last_auteur . "</b>";
            }
        }
        else
        {
            $author = "<b>" . $last_auteur . "</b>";
        }

        if (strlen($titre) > 20 && $file == $nuked['index_site'])
        {
            $titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "#" . $idmax."\" title=\"" . $title. "\"><b>" . printSecuTags(substr($titre, 0, 20)) . "...</b></a>";
        }
        else if (strlen($titre) > 30)
        {
            $titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "#" . $idmax."\" title=\"" . $title. "\"><b>" . printSecuTags(substr($titre, 0, 30)) . "...</b></a>";
        }
        else
        {
            $titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "#" . $idmax."\"><b>" . $title . "</b></a>";
        }

        if (($nb_rep + 1) > $nuked['mess_forum_page'])
        {
            $topicpages = ($nb_rep + 1) / $nuked['mess_forum_page'];
            $topicpages = ceil($topicpages);
            $link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "&amp;p=" . $topicpages . "#" . $idmax;
        }
        else
        {
            $link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "#" . $idmax;
        }
        if($i2 == 0) {
                $bg = $bgcolor2;
                $i2++;
            }
            else {
                $bg = $bgcolor1;
                $i2 =0;
            }
            if($ii2 == 0) {
                $bgbord = $bgcolor1;
                $ii2++;
            }
            else {
                $bgbord = $bgcolor2;
                $ii2 =0;
            }
        /*
		$txt = printSecuTags($txt);
        $txt = preg_replace("`&amp;lt;`i", "&lt;", $txt);
        $txt = preg_replace("`&amp;gt;`i", "&gt;", $txt);
        
        */
        $txt = nk_CSS($txt);
        $txt = preg_replace("`<br />`i", "", $txt);
        if ( strlen($txt) > 30 ) { $txt = substr($txt, 0, 30)."..."; }    
        echo "<tr style=\"background: " . $bgcolor2 . ";\">\n"
        . "<td style=\"width: 35%;\">&nbsp;" . $titre_topic . "".$att."".$attupdate."<br />
		   <span style=\"font-family:colibri;\">".$txt."</span></td>\n"
        . "<td style=\"width: 15%;\" align=\"center\">" . $initiat . "</td>\n"
        . "<td style=\"width: 10%;\" align=\"center\">" . $nb_rep . "</td>\n"
        . "<td style=\"width: 10%;\" align=\"center\">" . $nb_read . "</td>\n"
        . "<td style=\"width: 30%;\">
		<img alt=\"avatar\" src=\"".$avatarok."\" style=\"-webkit-border-radius: 45px;-moz-border-radius: 45px;border-radius: 45px;padding:2px;border:1px " . $bg . " outset; background:".$bgcolor1.";width: 25px; height: 25px; float: left; margin-right: 5px;\" />
		" . $last_datefixe . "<br /><a href=\"" . $link_post . "\"><img style=\"border: 0;\" src=\"modules/Forum/images/icon_latest_reply.gif\" alt=\"\" title=\"" . _SEELASTPOST . "\" /></a>" . $author . "</td></tr>\n";
    }
    echo "</table><div style=\"text-align: right;\">&#187; <a href=\"index.php?file=Forum\"><small>" . _VISITFORUMS . "</small></a></div>\n";
}
else
{
    echo "<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">\n";

    $sql = mysql_query("SELECT FTT.id, FTT.titre, FTT.last_post, FTT.forum_id FROM " . FORUM_THREADS_TABLE . " AS FTT INNER JOIN " . FORUM_TABLE . " AS FT ON FT.id = FTT.forum_id WHERE FT.niveau <= '" . $visiteur . "' ORDER BY last_post DESC LIMIT 0, 10");
    while (list($thread_id, $titre, $last_post, $forum_id) = mysql_fetch_row($sql))
    {
        $date = ftime($last_post);

                    $newsdate = time() - 604800;
                    $att = "";

             if ($last_post!="" && $last_post > $newsdate) $att = "&nbsp;<img alt=\"Update\" src=\"modules/Forum/images/new_message.png\" style=\"vertical-align: middle;\" />";
                    
        $sql2 = mysql_query("SELECT id, auteur, auteur_id FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "' ORDER BY id DESC LIMIT 0, 1");
        list($mess_id, $auteur, $auteur_id) = mysql_fetch_array($sql2);

        $auteur = nk_CSS($auteur);

        $title = printSecuTags($titre);
        $title = nk_CSS($title);

        $sql3 = mysql_query("SELECT thread_id FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "'");
        $nb_rep = mysql_num_rows($sql3);

        if ($auteur_id != "")
        {
            $sql4 = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $auteur_id . "'");
            list($autor) = mysql_fetch_array($sql4);
        }
        else
        {
            $autor = $auteur;
        }

        if ($nb_rep > $nuked['mess_forum_page'])
        {
            $topicpages = $nb_rep / $nuked['mess_forum_page'];
            $topicpages = ceil($topicpages);
            $link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "&amp;p=" . $topicpages . "#" . $mess_id;
        }
        else
        {
            $link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "#" . $mess_id;
        }

        if (strlen($titre) > 40)
        {
            $titre_topic = "<a href=\"" . $link_post . "\" title=\"" . $title . " ( " . $autor . " )&nbsp;le&nbsp;" . $date . "\"><b>" . printSecuTags(substr($titre, 0, 40)) . "...</b></a>";
        }
        else
        {
            $titre_topic = "<a href=\"" . $link_post . "\" title=\"" . _BY . "&nbsp;" . $autor . "&nbsp;le&nbsp;" . $date . "\"><b>" . $title . "</b></a>";
        }
        echo "<tr><td><img src=\"images/posticon.gif\" alt=\"\" title=\"" . $autor . "\" />&nbsp;" . $titre_topic . "".$att."</td></tr>\n";
    }
    echo "</table><div style=\"text-align: right;\">&#187; <a href=\"index.php?file=Forum\"><small>" . _VISITFORUMS . "</small></a></div>&nbsp;\n";
}

?>
