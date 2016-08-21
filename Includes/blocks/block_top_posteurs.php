<?php
// ------------------------------------------------------------------------ //
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// ------------------------------------------------------------------------ //
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// ------------------------------------------------------------------------ //
// Update 30/12/2012                                                        //
// ------------------------------------------------------------------------ //

if(!defined('INDEX_CHECK')) die(header('HTTP/1.0 404 Not Found'));

# Affichage du bloc
function affich_block_top_posteurs($blok)
{
    global $nuked, $language;

    if($language == 'french') define('_VIEWPROFIL', 'Voir le profil');
    elseif($language == 'english') define('_VIEWPROFIL', 'View Profil');

    list($nb) = explode('|', $blok['content']);
    $blok['content'] = '';

    # Début affichage du tableau
    $blok['content'] .= '<table style="margin: 0 auto" width="100%">';

    $sql = mysql_query("SELECT pseudo, country, count FROM ". USER_TABLE ." ORDER BY count DESC LIMIT 0, " . $nb . "");
    while(list($pseudo, $country, $count)= mysql_fetch_array($sql))
    {
	    list ($pays, $ext) = explode ('.', $country);
        $blok['content'] .= '<tr><td style="vertical-align: middle;width: 10%"><img src="images/flags/' . $country . '" alt="" title="' . $pays . '" /></td><td style="width: 80%"><a href="?file=Members&amp;op=detail&amp;autor=' . urlencode($pseudo) . '" title="' . _VIEWPROFIL . '"><b>' . $pseudo . '</b></a><td><td style="width: 10%" align="right">' . $count . '</td></tr>';
    }

    # Fin du tableau
    $blok['content'] .= '</table>';

    return $blok;
}

# Edition du bloc
function edit_block_top_posteurs($bid)
{
    global $nuked, $language;

    if($language == 'french') define('_TOP_NOMBRE', 'Nbre à afficher');
    elseif($language == 'english') define('_TOP_NOMBRE', 'Nb to display');

    $sql = mysql_query("SELECT active, position, titre, module, content, type, nivo, page FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
    $titre = stripslashes($titre);
    $titre = htmlentities($titre);
    list($nb) = explode('|', $content);

    if($active == 1) $checked1 = 'selected="selected"';
    else if($active == 2) $checked2 = 'selected="selected"';
    else $checked0 = 'selected="selected"';

    # Initialise une valeur par défaut à $nb
    if(!$nb) $nb = 10;

    # <!-- Start Content Box -->
    echo '<div class="content-box">
    <div class="content-box-header"><h3>' . _BLOCKADMIN . '</h3>
    <div style="text-align:right"><a href="help/' . $language . '/block.php" rel="modal"><img style="border: 0" src="help/help.gif" alt="" title="' . _HELP . '" /></a></div></div>
    <div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">
    <table style="margin: 0 auto" cellspacing="0" cellpadding="2" border="0">
    <tr><td><b>' . _TITLE . '</b></td><td><b>' . _BLOCK . '</b></td><td><b>' . _POSITION . '</b></td><td><b>' . _LEVEL . '</b></td><td><b>' . _TOP_NOMBRE . '</b></td></tr>
    <tr><td align="center"><input type="text" name="titre" size="40" value="' . $titre . '" /></td>
    <td align="center"><select name="active">
    <option value="1" ' . $checked1 . '>' . _LEFT . '</option>
    <option value="2" ' . $checked2 . '>' . _RIGHT . '</option>
    <option value="0" ' . $checked0 . '>' . _OFF . '</option></select></td>
    <td align="center"><input type="text" name="position" size="2" value="' . $position . '" /></td>
    <td align="center"><select name="nivo"><option>' . $nivo . '</option>
    <option>0</option><option>1</option><option>2</option>
    <option>3</option><option>4</option><option>5</option>
    <option>6</option><option>7</option><option>8</option><option>9</option></select></td>';

    # Option d'affichage du nombre de pseudo à afficher
    echo '<td align="center"><select name="nb"><option>' . $nb . '</option>
    <option>5</option><option>6</option><option>7</option>
    <option>8</option><option>9</option><option>10</option></select></td></tr>';

    # Selection de la page
    echo '<tr><td colspan="5"></td></tr>
    <tr><td colspan="5" align="center\"><b>' . _PAGESELECT . ' :</b></td></tr><tr><td colspan="5"></td></tr>
    <tr><td colspan="5" align="center"><select name="pages[]" size="8" multiple="multiple">';

    select_mod2($pages);

    echo '</select></td></tr><tr><td colspan="5"></td></tr></table>
    <div style="text-align: center"><br />
    <input type="hidden" name="type" value="' . $type . '" />
    <input type="hidden" name="bid" value="' . $bid . '" />
    <input type="submit" name="send" value="' . _MODIFBLOCK . '" class="button" />&nbsp;
	<a href="?file=Admin&amp;page=block" class="button">' . _BACK . '</a></div></form><br /></div></div>';
}

# Gestion des options avancées
function modif_advanced_top_posteurs($data)
{
    $data['content'] = $data['nb'];
    return $data;
}

?>