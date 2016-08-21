<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $user, $language;
translate('modules/Mumble/lang/' . $language . '.lang.php');
include('modules/Admin/design.php');
admintop();

$visiteur = ($user) ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1){

    function main()
    {
        global $nuked, $language;
	$sql=mysql_query("SELECT mumble_jsonurl FROM " . $nuked['prefix'] . "_mumble ");
	list($dataUrl) = mysql_fetch_array($sql);

       echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
        . '<div class="content-box-header"><h3>Mumble</h3>',"\n"
        . '<div style="text-align:right"><a href="help/' . $language . '/Mumble.php" rel="modal">',"\n"
        . '<img style="border: 0" src="help/help.gif" alt="" title="' . _HELP . '" /></a>',"\n"
        . '</div></div>',"\n"
        . '<form method="post" action="index.php?file=Mumble&amp;page=admin&amp;op=change_pref">',"\n"
        . '<table style="margin: auto;text-align: left" border="0" cellspacing="0" cellpadding="3">',"\n"
        . '<tr><td align="center"><big>' . _PREFS . '</big></td></tr>',"\n"
        . '<tr><td>' . _LINKJSON . ' : <input type="text" name="linkjson" size="40" value="' . $dataUrl . '" /></td></tr></table>',"\n"
	. '<td style="width: 100%;text-align:center;" >' . _JSONKESAKO1 . ' <a href="http://mumble.sourceforge.net/Channel_Viewer_Protocol">Mumble Channel Protocol</a> ' . _JSONKESAKO2 . '</td>'."\n"
        . '<div style="text-align: center"><br /><input type="submit" value="' . _SEND . '" /><br />',"\n"
        . '<br />[ <a href="index.php?file=Mumble&amp;page=admin"><b>' . _BACK . '</b></a> ]</div></form><br /></div></div>',"\n";
    } 

    function change_pref($url){
        global $nuked, $user;

        $upd1 = mysql_query("UPDATE ". $nuked['prefix'] ."_mumble SET mumble_jsonurl = '" . $url . "' LIMIT 1");
        // Action
        $texteaction = _ACTIONPREFCONT;
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action

        echo '<div class="notification success png_bg">'."\n"
        . '<div>' . _PREFUPDATED . '</div>'."\n"
        . '</div>'."\n";

        redirect('index.php?file=Mumble&page=admin', 2);
    } 

    switch($_REQUEST['op']){
        case 'view':
        view($_REQUEST['mid']);
        break;
    
        case 'del':
        del($_REQUEST['mid']);
        break;
    
        case 'main_pref':
        main_pref();
        break;
    
        case 'change_pref':
        change_pref($_REQUEST['linkjson']);
        break;
    
        default:
        main();
        break;
    }

} 
else if ($level_admin == -1){
    echo '<div class="notification error png_bg">'."\n"
    . '<div>'."\n"
    . '<br /><br /><div style="text-align: center">' . _MODULEOFF . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a></div><br /><br />'."\n"
    . '</div>'."\n"
    . '</div>'."\n";
}
else if ($visiteur > 1){
    echo '<div class="notification error png_bg">'."\n"
    . '<div>'."\n"
    . '<br /><br /><div style="text-align: center">' . _NOENTRANCE . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a></div><br /><br />'."\n"
    . '</div>'."\n"
    . '</div>'."\n";
}
else{
    echo '<div class="notification error png_bg">'."\n"
    . '<div>'."\n"
    . '<br /><br /><div style="text-align: center">' . _ZONEADMIN . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a></div><br /><br />'."\n"
    . '</div>'."\n"
    . '</div>'."\n";
}

adminfoot();
?>