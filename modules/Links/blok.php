<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// New look by kotshiro http://kotshiro.free.fr Octobre 2013                //
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//

defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $language, $nuked, $theme, $bgcolor2, $bgcolor3, $bgcolor1;
translate('modules/Links/lang/' . $language . '.lang.php');

include('modules/Links/template.php');

$sql2 = mysql_query('SELECT active FROM ' . BLOCK_TABLE . ' WHERE bid = ' . $bid);
list($active) = mysql_fetch_array($sql2);
if ($active == 3 || $active == 4){


    $i = 0;
    echo '<table style="margin: auto; padding: 0px; border: 0px; color: rgb(150, 26, 26); font-family: Arial, Helvetica, sans-serif; font-size: 11px;rgb(240, 240, 240);" width="90%">
	<tbody style="margin: 0px; padding: 0px; border: none;"><tr>'."\n";
    $sql = mysql_query('SELECT id, titre, date, url, country, count, description, cat FROM ' . LINKS_TABLE . ' ORDER BY rand() DESC LIMIT 0, 3');
    while (list($link_id, $titre, $date, $url, $country, $count, $description, $tcat) = mysql_fetch_array($sql)){
    	
    	$sql4 = mysql_query('SELECT titre, parentid FROM ' . LINKS_CAT_TABLE . ' WHERE cid = ' . $tcat);
        list($tcat_name, $tparentid) = mysql_fetch_array($sql4);
        $tcat_name = printSecuTags($tcat_name);
        $i++;
        $titre = printSecuTags($titre);
        if (strlen($description) > 180){
        $description = substr($description, 0, 180) . '...';
        } 
        $register_date = date("d.m.y", $date);
        $description = str_replace('<p>', '', $description);
        $description = str_replace('</p>', '', $description);
        $description = str_replace('<br />', '', $description);
        
                        if (!empty($country) && file_exists('images/flags/' . $country)){
                        list ($pays, $ext) = explode ('.', $country);
                        if ( $pays == 'France' ) { $languepays = "Langue fran&ccedil;aise"; }
                        if ( $pays == 'Belgium' ) { $languepays = "Langue belge"; }
                        $link_pays = '&nbsp;<img src="images/flags/' . $country . '" alt="" title="' . $languepays . '" />';
                    }
                    else
                        $link_pays = '&nbsp;';
                         

	  
         echo '<td><a title="'. html_entity_decode($description).'" href="index.php?file=Links&amp;op=description&amp;link_id='.$link_id.'" style="text-decoration: none;">
		 <div style="font-family: ‘Trebuchet MS’, Helvetica, sans-serif;
	font-size:14px;font-weight:normal;text-shadow: 0px 0px 3px #333;">'.$titre.'</div>
		 <img alt="site" src="http://www.robothumb.com/src/?url='.$url.'&size=320x240" style="border: 1px solid '.$bgcolor3.';border-top-left-radius: 4px; border-top-right-radius: 4px; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px;width: 140px; height: 105px;" /></a>

		 <xx class="boutonvisites">'.$count.' Visites&nbsp;'.$link_pays.'</xx>
		 <br /></td>';
         
	}
         echo '		</tr>
	</tbody>
</table><a href="http://kotshiro.free.fr" style="text-decoration:none;"><span style="color:'.$bgcolor3.';">&copy;</span></a>';
}

else{

    $i = 0;
    echo '<table style="margin: auto; border: 0" width="90%">'."\n";
       echo '<div id="mainwrapper">';
    $sql = mysql_query('SELECT id, titre, date, url, country, count, description, cat FROM ' . LINKS_TABLE . ' ORDER BY rand() DESC LIMIT 0, 3');
    while (list($link_id, $titre, $date, $url, $country, $count, $description, $tcat) = mysql_fetch_array($sql)){
    	
    	$sql4 = mysql_query('SELECT titre, parentid FROM ' . LINKS_CAT_TABLE . ' WHERE cid = ' . $tcat);
        list($tcat_name, $tparentid) = mysql_fetch_array($sql4);
        $tcat_name = printSecuTags($tcat_name);
        $i++;
        $titre = printSecuTags($titre);
       
        if (strlen($description) > 180){
        $description = substr($description, 0, 180) . '...';
        } 
        $register_date = date("d.m.y", $date);
        $description = str_replace('<p>', '', $description);
        $description = str_replace('</p>', '', $description);
        $description = str_replace('<br />', '', $description);
        
                        if (!empty($country) && file_exists('images/flags/' . $country)){
                        list ($pays, $ext) = explode ('.', $country);
                        if ( $pays == 'France' ) { $languepays = "Langue fran&ccedil;aise"; }
                        if ( $pays == 'Belgium' ) { $languepays = "Langue belge"; }
                        $link_paysnono = '&nbsp;<img src="images/flags/' . $country . '"/>';
                    }
                    else
                        $link_paysnono = '&nbsp;'; 
                        
         echo '<a href="index.php?file=Links&amp;op=description&amp;link_id='.$link_id.'"><div id="box-6" class="box">
		      <img id="image-6" src="http://www.robothumb.com/src/?url='.$url.'&size=320x240"/>'.$link_paysnono.'
		      <span class="caption scale-caption">
			  <h3>'.$titre.'</h3><p>'. html_entity_decode($description).'</p><br />
			  <p><strong>Visit&eacute;</strong> :&nbsp;'.$count.' fois.&nbsp;</p></span>
		      </div></a><br />
		';                        
	}
    echo '</div></table><a href="http://kotshiro.free.fr" style="text-decoration:none;"><span style="color:'.$bgcolor3.';">&copy;</span></a>';
}
?>