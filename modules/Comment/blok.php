<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (eregi("blok.php", $_SERVER['PHP_SELF']))
{
    die ("You cannot open this page directly");
} 


global $nuked, $language;
translate("modules/Comment/lang/$language.lang.php");
$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);
if ($active == 1 || $active == 2)
{

    echo "<br /><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";

    $sql = mysql_query("SELECT id, im_id, module, autor, comment, date FROM " . COMMENT_TABLE . " ORDER BY date DESC LIMIT 0, 5");
    while (list($comid, $im_id, $mod, $autor, $comment, $date) = mysql_fetch_array($sql))
    {
        $date = strftime("%x à %H:%M", $date);
        $autor = stripslashes($autor);
        $comment = strip_tags($comment);

				if ( strlen($comment) > 50 ) { $comment = substr($comment, 0, 50)."..."; }

        if ($mod == "Links")$link = "Links&op=description&link_id=";	
        if ($mod == "Gallery")$link = "Gallery&op=description&sid=";	
        if ($mod == "news")$link = "news&op=index_comment&news_id=";
        if ($mod == "Sections")$link = "Sections&op=article&artid=";	
        if ($mod == "Download")$link = "Download&op=description&dl_id=";	
        if ($mod == "Survey")$link = "Survey&op=affich_res&poll_id=";
        if ($mod == "match")$link = "Wars&op=detail&war_id=";


//        echo "<tr><td>&nbsp;<b><big>&middot;</big></b>&nbsp;<a href=\"#\" onclick=\"javascript:window.open('index.php?file=Comment&nuked_nude=index&op=view_com&im_id=" . $im_id . "&module=" . $mod . "','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=340');return(false)\"";

	echo "<img src=\"modules/Comment/images/comment.png\" style=\"margin-bottom:-4px;\" />&nbsp;<b><a href=\"index.php?file=".$link."".$im_id."\" title=\"" . _VIEWCOMMENT . "\"\">" . $mod . "</b></a><br />&laquo;<i>" . $comment . "</i>&raquo;<br />" . _POSTED . "&nbsp;" . _THE . "&nbsp;" . $date . "&nbsp;" . _BY . "&nbsp;" . $autor . "</td></tr><br /><br />\n";
    } 
    echo "</table>\n";
} 

else
{
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";

	echo "<tr><td>&nbsp;" . _NOCOMMENT . "</td></tr>";
    echo "</table><br />\n";
} 

?>