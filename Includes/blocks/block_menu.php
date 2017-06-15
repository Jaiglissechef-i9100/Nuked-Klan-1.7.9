<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');

function affich_block_menu($blok){
    $blok['content'] = block_link($blok['content']);
    return $blok;
}

function block_link($content){
    global $user, $nuked;

    include('Includes/blocks/template.php');

    //patch notifications Juin 2013
    $date=mktime(date("m"),date("d"),date("Y"));
    
    //guestbook
    $sqlguestbook = mysql_query("SELECT COUNT(*) FROM ".GUESTBOOK_TABLE." WHERE date > '".$date."' ");
    list($countguest) = mysql_fetch_array($sqlguestbook);    
    if ($countguest) { $afficheguest = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" style=\"width: 34px; height: 9px;\" /><xx class=\"noti_bubble\">".$countguest."</xx>"; }
   
    //fofo
    $sqlfofofofof = mysql_query("SELECT COUNT(*) FROM ".FORUM_MESSAGES_TABLE." WHERE date > '".$date."' ");
    list($countfofo) = mysql_fetch_array($sqlfofofofof);    
    if ($countfofo) { $affichefofo = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" /><xx class=\"noti_bubble\">".$countfofo."</xx>"; }
    
    //news
    $sqlnews = mysql_query("SELECT COUNT(*) FROM ".NEWS_TABLE." WHERE date > '".$date."' ");
    list($countnews) = mysql_fetch_array($sqlnews);    
    if ($countnews) { $affichenews = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" style=\"width: 34px; height: 9px;\" /><xx class=\"noti_bubble\">".$countnews."</xx>"; }
   
    //Ressources
    $sqldownlo = mysql_query("SELECT COUNT(*) FROM ".DOWNLOAD_TABLE." WHERE date > '".$date."' ");
    list($countdownloads) = mysql_fetch_array($sqldownlo);    
    if ($countdownloads) { $affichedownloads = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" style=\"width: 34px; height: 9px;\" /><xx class=\"noti_bubble\">".$countdownloads."</xx>"; }
    
    //Liens
    $sqlliens = mysql_query("SELECT COUNT(*) FROM ".LINKS_TABLE." WHERE date > '".$date."' ");
    list($countliens) = mysql_fetch_array($sqlliens);    
    if ($countliens) { $affichelinks = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" style=\"width: 34px; height: 9px;\" /><xx class=\"noti_bubble\">".$countliens."</xx>"; }
    
    //membres
    $sqlmembre = mysql_query("SELECT COUNT(*) FROM ".USER_TABLE." WHERE date > '".$date."' ");
    list($countusers) = mysql_fetch_array($sqlmembre);    
    if ($countusers) { $afficheusers = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" style=\"width: 34px; height: 9px;\" /><xx class=\"noti_bubble\">".$countusers."</xx>"; }
    
    //wars
    $sqldefy = mysql_query("SELECT COUNT(*) FROM ".DEFY_TABLE." WHERE date > '".$date."' ");
    list($countdefy) = mysql_fetch_array($sqldefy);    
    if ($countdefy) { $affichedefy = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" style=\"width: 34px; height: 9px;\" /><xx class=\"noti_bubble\">".$countdefy."</xx>"; }
 
    //sections
    $sqlsections = mysql_query("SELECT COUNT(*) FROM ".SECTIONS_TABLE." WHERE date > '".$date."' ");
    list($countsections) = mysql_fetch_array($sqlsections);    
    if ($countsections) { $affichesections = "&nbsp;<img alt=\"Update\" src=\"".$nuked['url']."/Includes/blocks/images/maj.gif\" style=\"width: 34px; height: 9px;\" /><xx class=\"noti_bubble\">".$countsections."</xx>"; }
 
    $content = html_entity_decode($content);
    $link = explode('NEWLINE', $content);
    $screen = '<ul style="list-style: none; padding: 0">';
    $size = count($link);
    
    for($i=0; $i<$size; $i++){
        list($url, $title, $comment, $nivo, $blank) = explode('|', $link[$i]);
        $url = preg_replace("/\[(.*?)\]/si", "index.php?file=\\1", $url);
        $nivuser = $user[1];
        $title = preg_replace("`&amp;lt;`i", "<", $title);
        $title = preg_replace("`&amp;gt;`i", ">", $title);
        $comment = htmlentities($comment);
        $url = htmlentities($url);

        if (!$nivuser)$nivuser = 0;
        
        if ($nivuser >= $nivo){
        	
        	if ($url == 'index.php?file=Forum') {$afficheff = $affichefofo;} else {$afficheff = '';}
        	if ($url == 'index.php?file=News') {$affichenews = $affichenews;} else {$affichenews = '';}
        	if ($url == 'index.php?file=Download') {$affichedd = $affichedownloads;} else {$affichedd = '';}
        	if ($url == 'index.php?file=Members') {$afficheuu = $afficheusers;} else {$afficheuu = '';}
        	if ($url == 'index.php?file=Links') {$affichell = $affichelinks;} else {$affichell = '';}
        	if ($url == 'index.php?file=Guestbook') {$affichebook = $afficheguest;} else {$affichebook = '';}
        	if ($url == 'index.php?file=Defy') {$affichedef = $affichedefy;} else {$affichedef = '';}
        	if ($url == 'index.php?file=Sections') {$affichesec = $affichesections;} else {$affichesec = '';}
        	
            if ($url <> '' && $title <> '' && $blank == 0)
                $screen .= '<li><a href="' . $url . '" title="' . $comment . '" style="padding-left: 10px" class="menu">' . $title . '</a>'.$afficheff.''.$affichenews.''.$affichedd.''.$afficheuu.''.$affichell.''.$affichebook .''.$affichedef.''.$affichesec.'</li>';

            if ($url <> '' && $title <> '' && $blank == 1)
                $screen .= '<li><a href="' . $url . '" title="' . $comment . '" class="menu" style="padding-left: 10px" onclick="window.open(this.href); return false;">' . $title . '</a></li>';

            if ($url == '' && $title <> '' && $comment == '')
                $screen .= '<li style="padding-left: 20px" class="titlemenu">' . $title . '</li>';
        }
    }
    $screen .= '</ul>';
    return $screen;
}
function edit_block_menu($bid){
    global $nuked, $language;

    $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);

    $content = htmlentities($content);

    if ($active == 1) $checked1 = 'selected="selected"';
    else if ($active == 2) $checked2 = 'selected="selected"';
    else $checked0 = 'selected="selected"';

    echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
            , '<div class="content-box-header"><h3>' , _BLOCKADMIN , '</h3>',"\n"
            , '<a href="help/' , $language , '/block.html" rel="modal">',"\n"
            , '<img style="border: 0;" src="help/help.gif" alt="" title="' , _HELP , '" /></a>',"\n"
            , '</div>',"\n"
            , '<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">',"\n"
            , '<table style="margin-left: auto;margin-right: auto;text-align: left;" cellspacing="0" cellpadding="2" border="0">',"\n"
            , '<tr><td><b>' , _TITLE , '</b></td><td><b>' , _BLOCK , '</b></td><td><b>' , _POSITION , '</b></td><td><b>' , _LEVEL , '</b></td></tr>',"\n"
            , '<tr><td align="center"><input type="text" name="titre" size="40" value="' , $titre , '" /></td>',"\n"
            , '<td align="center"><select name="active">',"\n"
            , '<option value="1" ' , $checked1 , '>' , _LEFT , '</option>',"\n"
            , '<option value="2" ' , $checked2 , '>' , _RIGHT , '</option>',"\n"
            , '<option value="0" ' , $checked0 , '>' , _OFF , '</option></select></td>',"\n"
            , '<td align="center"><input type="text" name="position" size="2" value="' , $position , '" /></td>',"\n"
            , '<td align="center"><select name="nivo"><option>' , $nivo , '</option>',"\n"
            , '<option>0</option>',"\n"
            , '<option>1</option>',"\n"
            , '<option>2</option>',"\n"
            , '<option>3</option>',"\n"
            , '<option>4</option>',"\n"
            , '<option>5</option>',"\n"
            , '<option>6</option>',"\n"
            , '<option>7</option>',"\n"
            , '<option>8</option>',"\n"
            , '<option>9</option></select></td></tr>',"\n"
            , '<tr><td colspan="4" align="center"><br /><input type="button" value="' , _EDITMENU , '" onclick="javascript:window.location=\'index.php?file=Admin&amp;page=menu&amp;op=edit_menu&amp;bid=' , $bid , '\'" /></td></tr>',"\n"
            , '<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4" align="center"><b>' , _PAGESELECT , ' :</b></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
            , '<tr><td colspan="4" align="center"><select name="pages[]" size="8" multiple="multiple">',"\n";

    select_mod2($pages);

    echo '</select></td></tr><tr><td colspan="4" align="center"><br />',"\n"
        , '<input type="hidden" name="type" value="' , $type , '" />',"\n"
        , '<input type="hidden" name="bid" value="' , $bid , '" />',"\n"
        , '<input type="hidden" name="content" value="' , $content , '" />',"\n"
        , '<input type="submit" name="send" value="' , _MODIFBLOCK , '" />',"\n"
        , '</td></tr></table>',"\n"
        , '<div style="text-align: center;"><br />[ <a href="index.php?file=Admin&amp;page=block"><b>' , _BACK , '</b></a> ]</div></form><br /></div></div>',"\n";

}
?>