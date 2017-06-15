<?php
/**
 * @version     1.8
 * @link http://www.nuked-klan.org Clan Management System for Gamers
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright 2001-2015 Nuked-Klan (Registred Trademark)
 */
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

function affich_block_survey($blok){
    global $file, $nuked, $user,$language;
    translate('modules/Survey/lang/' . $language . '.lang.php');

    if ($file != 'Survey'){
        $survey_id = $blok['content'];
        $blok['content'] = '';
    
        if ($survey_id != '') $where = 'WHERE sid = \'' . $survey_id . '\' ';
        else $where = 'ORDER BY sid DESC LIMIT 0, 1';

        $sql = mysql_query('SELECT sid, titre FROM ' . SURVEY_TABLE . ' ' . $where);
        list($poll_id, $titre) = mysql_fetch_array($sql);
        $titre = htmlentities($titre);
            $sql = mysql_query('SELECT titre FROM ' . SURVEY_TABLE . ' WHERE sid=' . $poll_id);
            list($titre) = mysql_fetch_array($sql);
            $titre = htmlentities($titre);
            
            global $bgcolor2,$bgcolor3,$bgcolor1;
            
            $blok['content'] .= "\n"
               . "<div style=\"text-align: center;\"><b>$titre</b></div><br />\n"
               . "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . "; margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">\n";

            $sql2 = mysql_query('SELECT optionCount FROM ' . SURVEY_DATA_TABLE . ' WHERE sid = ' . $poll_id);
            $nbcount = 0;
            while (list($option_count) = mysql_fetch_array($sql2)) {
                $nbcount = $nbcount + $option_count;
            } 

            $sql3 = mysql_query('SELECT optionCount, optionText FROM ' . SURVEY_DATA_TABLE . ' WHERE sid = ' . $poll_id . ' ORDER BY voteID ASC');
            while (list($optioncount, $optiontext) = mysql_fetch_array($sql3)) {
                $optiontext = htmlentities($optiontext);

                if ($nbcount <> 0) {
                    $etat = ($optioncount * 100) / $nbcount;
                } else {
                    $etat = 0;
                } 
                $pourcent_arrondi = round($etat);
                global $bgcolor2,$bgcolor3,$bgcolor1;
            if ($j == 0) {
                $bg = $bgcolor2;
                $j++;
            } else {
                $bg = $bgcolor1;
                $j = 0;
            } 
                $blok['content'] .= '<tr><td>' . $optiontext . '</td><td>';

                if ($etat < 1) {
                    $width = 2;
                } else {
                    $width = $etat * 2;
                    $width = round($width);
                } 
                if (is_file('themes/" . $theme . "/images/bar.gif')) {
                    $img = 'themes/" . $theme . "/images/bar.gif';
                } else {
                    $img = 'modules/Survey/images/bar.gif';
                } 

                $blok['content'] .= '<img src="' . $img . '" width="' . $width . '" height="10" alt="" />&nbsp;' . $pourcent_arrondi . '% (' . $optioncount . ')</td></tr>';
            }

            $blok['content'] .= "</table><table style=\"margin-left: auto;margin-right: auto;text-align: left;width:90%;\" border=\"0\">\n"
               . "<tr><td>&nbsp;</td></tr><tr><td><b>" . _TOTALVOTE . " : </b>" . $nbcount . "</td></tr>\n";
            

            $blok['content'] .= '</table><div style="text-align: center;"><br />[ <a href="index.php?file=Survey&amp;op=sondage&amp;poll_id=' . $poll_id . '">' . _SENDVOTE . '</a> | <a href="index.php?file=Survey">' . _OTHERPOLL . '</a> ]</div><br />';
    }

    return $blok;
}

function edit_block_survey($bid){
    global $nuked, $language;

    $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);

    $titre = htmlentities($titre);

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
            , '<option>9</option></select></td></tr><tr><td colspan="4"><b>' , _POLL , ' :</b>&nbsp;<select name="content">',"\n";

    $sql2 = mysql_query('SELECT sid, titre FROM ' . SURVEY_TABLE . ' ORDER BY sid DESC');
    while (list($survey_id, $survey_title) = mysql_fetch_array($sql2)){
        $survey_title = htmlentities($survey_title);

        if ($survey_id == $content) $checked3 = "selected=\"selected\"";
        else $checked3 = "";

        echo '<option value="' . $survey_id . '" ' . $checked3 . '>' . $survey_title . '</option>'."\n";
    }

    echo '</select></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
            , '<tr><td colspan="4" align="center"><b>' , _PAGESELECT , ' :</b></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
            , '<tr><td colspan="4" align="center"><select name="pages[]" size="8" multiple="multiple">',"\n";

    select_mod2($pages);

    echo '</select></td></tr><tr><td colspan="4" align="center"><br />',"\n"
            , '<input type="hidden" name="type" value="' , $type , '" />',"\n"
            , '<input type="hidden" name="bid" value="' , $bid , '" />',"\n"
            , '<input type="submit" name="send" value="' , _MODIFBLOCK , '" />',"\n"
            , '</td></tr></table>',"\n"
            , '<div style="text-align: center;"><br />[ <a href="index.php?file=Admin&amp;page=block"><b>' , _BACK , '</b></a> ]</div></form><br /></div></div>',"\n";

}
?>