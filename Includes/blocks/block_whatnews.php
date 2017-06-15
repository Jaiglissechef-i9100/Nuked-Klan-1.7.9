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
	exit('You can\'t run this file alone.');
}
global $nuked, $language,$nuked, $user;
translate("Includes/whatnews/lang/" . $language . ".lang.php");

function count_entries($nukedtable, $datefield, $datefield1="") {
    // init variables
    $countres = array(0,0,0,0);

    // count for today
    $newDB=mktime(0,0,0,date("m"),date("d"),date("Y"));
    $result = mysql_query("select count(*) as count FROM $nukedtable WHERE $datefield > $newDB $datefield1");
//    echo "res de "."select count(*) as count FROM $nukedtable WHERE $datefield > $newDB"."pour $nukedtable ($datefield) =".$result."<br />";
    $countres[1] = mysql_result($result,0,"count");
//    echo "count 1 =".$countres[1]."<br />";
    // count for yesterday
    $newDayRaw = (time()-(86400 * 1));
    $newDB1 = $newDayRaw;
    $result = mysql_query("select count(*) as count FROM $nukedtable WHERE $datefield < $newDB and $datefield > $newDB1 $datefield1");
//    echo "res de "."select count(*) as count FROM $nukedtable WHERE $datefield < $newDB and $datefield > $newDB1"." pour $nukedtable ($datefield) =".$result."<br />";
    $countres[2] = mysql_result($result,0,"count");
//    echo "count 2 =".$countres[2]."<br />";
    // count for last 7 days (this week)
    $counter = 2;
    $countres[3] = $countres[1] + $countres[2];
    while ($counter <= 7-1){
        $newDayRaw = (time()-(86400 * $counter));
        $newDB = $newDB1;
        $newDB1 = $newDayRaw;
        $result = mysql_query("select count(*) as count FROM $nukedtable WHERE $datefield < $newDB and $datefield > $newDB1 $datefield1");
         $x=mysql_result($result,0,"count");
        $countres[3] += mysql_result($result,0,"count");
        $counter++;
    }

    // here comes something bad. If res is zero, stay as number, otherwise become a string.
    $countres[4] = $countres[3];        // remember all sum
    $counter = 1;
    while ($counter <= 3) {
        if ($countres[$counter] > 0) {
            $countres[$counter] = "<b>".$countres[$counter]."</b>";
        }
        $counter++;
    }
    return $countres;
}


function affich_block_whatnews($blok)
{
           global $nuked;
       $blok['content'] = "";
        
 	//$aline = "<tr><td class='bg2' colspan='4'><img src='". $nuked['url']."/Includes/whatnews/images/pix.gif' width='1' height='1' alt='' border='0' hspace='0' /></td></tr>";
 	
    $entry = 0;

	// title
    $blok['content']="";
    $blok['content'] .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
    $blok['content'] .= "<tr><td><font class='pn-normal'></font></td>";
    $blok['content'] .= "<td align='center'><font class='pn-menu'>&nbsp;"._WHATN_T."&nbsp;</font></td>";
    $blok['content'] .= "<td align='center'><font class='pn-menu'>&nbsp;"._WHATN_Y."&nbsp;</font></td>";
    $blok['content'] .= "<td align='center'><font class='pn-menu'>&nbsp;"._WHATN_W."&nbsp;</font></td></tr>\n";
    $blok['content'] .= "$aline\n";

	// stories
	if (nivo_mod("News") != -1){
    $stores = count_entries("".$nuked[prefix]."_news","date");
    	if ($stores[4] > 0) {
       		$blok['content'] .= "<tr><td><img src='Includes/whatnews/images/articles.gif' alt='"._WHATN_ARTICLES."' title='"._WHATN_ARTICLES."' />&nbsp;<a class='pn-menu' href='" . $nuked['url'] . "/index.php?file=News'>"._WHATN_ARTICLES."</a></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$stores[1]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$stores[2]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$stores[3]</font></td></tr>\n";
        	$blok['content'] .= "$aline\n";
        	$entry = 1;
    	}
	}

	// downloads
	if (nivo_mod("Download") != -1){
    	$downres = count_entries("".$nuked[prefix]."_downloads","date");
    	if ($downres[4] > 0) {
        	$blok['content'] .= "<tr><td><img src='Includes/whatnews/images/downloads.gif' alt='"._WHATN_DOWNLOADS."' title='"._WHATN_DOWNLOADS."' />&nbsp;<a class='pn-menu' href='".$nuked['url']."/index.php?file=Download'>"._WHATN_DOWNLOADS."</a></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$downres[1]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$downres[2]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$downres[3]</font></td></tr>\n";
        	$blok['content'] .= "$aline\n";
        	$entry = 1;
    	}
	}

	// web links
	if (nivo_mod("Links") != -1){
    	$linkres = count_entries("".$nuked[prefix]."_liens","date");
    	if ($linkres[4] > 0) {
        	$blok['content'] .= "<tr><td><img src='Includes/whatnews/images/links.gif' alt='"._WHATN_LINKS."' title='"._WHATN_LINKS."' />&nbsp;<a class='pn-menu' href='".$nuked['url']."/index.php?file=Links'>"._WHATN_LINKS."</a></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$linkres[1]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$linkres[2]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$linkres[3]</font></td></tr>\n";
        	$blok['content'] .= "$aline\n";
        	$entry = 1;
    	}
	}

	// newbb_plus posts
	if (nivo_mod("Forum") != -1){
		$postbb = count_entries("".$nuked[prefix]."_forums_messages","date");
    	if ($postbb[4] > 0) {
        	$blok['content'] .= "<tr><td><img src='Includes/whatnews/images/posts.gif' alt='"._WHATN_POSTFORUMS."' title='"._WHATN_POSTFORUMS."' />&nbsp;<a class='pn-menu' href='".$nuked['url']."/index.php?file=Forum'>"._WHATN_POSTFORUMS."</a></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$postbb[1]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$postbb[2]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$postbb[3]</font></td></tr>\n";
        	$blok['content'] .= "$aline\n";
        	$entry = 1;
    	}
    	// newbb_plus sujets
    	$sujets = count_entries("".$nuked[prefix]."_forums","nom");
    	if ($sujets[4] > 0) {
        	$blok['content'] .= "<tr><td><img src='Includes/whatnews/images/topics.gif' alt='"._WHATN_POSTSUJETS."' title='"._WHATN_POSTSUJETS."' />&nbsp;<a class='pn-menu' href='".$nuked['url']."/index.php?file=Forum'>"._WHATN_POSTSUJETS."</a></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$sujets[1]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$sujets[2]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$sujets[3]</font></td></tr>\n";
        	$blok['content'] .= "$aline\n";
        	$entry = 1;
    	}
	}

//	if (defined('MOD_MEMBERS_ACTIV')){
   			$stores1 = count_entries("".$nuked[prefix]."_users","date");
    	if ($stores1[4] > 0) {
        	$blok['content'] .= "<tr><td><img src='Includes/whatnews/images/membres.png' alt='"._WHATN_MBERS."' title='"._WHATN_MBERS."' />&nbsp;";
        	if (nivo_mod("Search") != -1){
			
				$blok['content'] .= "<a class='pn-menu' href='".$nuked['url']."/index.php?file=Members'>"._WHATN_MBERS."</a>";
			}elseif (defined('MOD_MEMBERSEARCH_ACTIV')){
				$blok['content'] .= "<a class='pn-menu' href='".$nuked['url']."/index.php?file=Search'>"._WHATN_MBERS."</a>";
			}else{
				$blok['content'] .= _WHATN_MBERS;
			}
			$blok['content'] .= "</td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$stores1[1]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$stores1[2]</font></td>";
        	$blok['content'] .= "<td align='center'><font class='pn-menu'>$stores1[3]</font></td></tr>\n";
        	$blok['content'] .= "$aline\n";
        	$entry = 1;
    	}




   $blok['content'] .= "</table>";
    if ($entry == 0) {  // don't we have any entries ?
        $blok['content'] .= "<center><br />"._WHATN_ENTRIES."<br /></center>";
    } else {
        $blok['content'] .= "<center><b>"._WHATN_T."</b>"._WHATN_TODAY." &middot; <b>"._WHATN_Y."</b>"._WHATN_iYESTERDAY." &middot; <b>"._WHATN_W."</b>"._WHATN_iWEEK."</center>";
    }
    return $blok;
}

function edit_block_whatnews($bid)
{
  global $nuked, $language;

    $sql = mysql_query("SELECT active, position, titre, module, content, type, nivo, page FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
    $titre = printSecuTags($titre);

    if ($active == 1) $checked1 = "selected=\"selected\"";
    else if ($active == 2) $checked2 = "selected=\"selected\"";
    else $checked0 = "selected=\"selected\"";

    echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
		. "<div class=\"content-box-header\"><h3>" . _BLOCKADMIN . "</h3>\n"
		. "<a href=\"help/" . $language . "/block.html\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div>\n"
	. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=block&amp;op=modif_block\">\n"
    . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n"
    . "<tr><td><b>" . _TITLE . "</b></td><td><b>" . _BLOCK . "</b></td><td><b>" . _POSITION . "</b></td><td><b>" . _LEVEL . "</b></td></tr>\n"
    . "<tr><td align=\"center\"><input type=\"text\" name=\"titre\" size=\"40\" value=\"" . $titre . "\" /></td>\n"
    . "<td align=\"center\"><select name=\"active\">\n"
    . "<option value=\"1\" " . $checked1 . ">" . _LEFT . "</option>\n"
    . "<option value=\"2\" " . $checked2 . ">" . _RIGHT . "</option>\n"
    . "<option value=\"0\" " . $checked0 . ">" . _OFF . "</option></select></td>\n"
    . "<td align=\"center\"><input type=\"text\" name=\"position\" size=\"2\" value=\"" . $position . "\" /></td>\n"
    . "<td align=\"center\"><select name=\"nivo\"><option>" . $nivo . "</option>\n"
    . "<option>0</option>\n"
    . "<option>1</option>\n"
    . "<option>2</option>\n"
    . "<option>3</option>\n"
    . "<option>4</option>\n"
    . "<option>5</option>\n"
    . "<option>6</option>\n"
    . "<option>7</option>\n"
    . "<option>8</option>\n"
    . "<option>9</option></select></td></tr><tr><td colspan=\"4\">&nbsp;</td></tr>\n"
    . "<tr><td colspan=\"4\" align=\"center\"><b>" . _PAGESELECT . " :</b></td></tr><tr><td colspan=\"4\">&nbsp;</td></tr>\n"
    . "<tr><td colspan=\"4\" align=\"center\"><select name=\"pages[]\" size=\"8\" multiple=\"multiple\">\n";

    select_mod2($pages);

    echo "</select></td></tr><tr><td colspan=\"4\" align=\"center\"><br />\n"
    . "<input type=\"hidden\" name=\"type\" value=\"" . $type . "\" />\n"
    . "<input type=\"hidden\" name=\"bid\" value=\"" . $bid . "\" />\n"
    . "<input type=\"submit\" name=\"send\" value=\"" . _MODIFBLOCK . "\" />\n"
    . "</td></tr></table>"
    . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=block\"><b>" . _BACK . "</b></a> ]</div></form><br /></div>\n";
}

?>