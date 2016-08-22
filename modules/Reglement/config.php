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

define('REGLEMENT_TABLE', $nuked['prefix'] . '_reglement');
define('REGLEMENT_DETAILS_TABLE', $nuked['prefix'] . '_reglement_details');



// ----------------------------------------------------------------------//
//      Fonctions qui sécurisent les variables avant envoi en BDD        //
// ----------------------------------------------------------------------//
// appel de la fonction chkAndSec(valeur, type, notnull, valeur, type, notnull,...)
// exemple chkAndSec($nom, 'text', true, $email, 'mail', false,...)
// valeur = variable
// type = text, num, longtext, mail, checkbox
// notnull = true ou false

define ('_NULL' , 'Champs obligatoire manquant !');
define ('_NUMERIC' , 'Format non numérique !');
define ('_OUPS' , 'Caractère non autorisé !');
define ('_BADMAIL' , 'Format d\'email non correct !');

function chkAndSec() {
	$numargs = func_num_args();
	$arg_list = func_get_args();
	$j = 0; $k = 1; $l = 0;
			
	for ($i = 1; $i <= $numargs; $i++){			
		if ($k == 1) $valeur[] = $arg_list[$j];
		else if ($k == 2) $type[] = 'chkAndSec_' . $arg_list[$j];
		else {
			$bool = ($arg_list[$j] == true) ? true : false;
			$notnull[] = $bool;
			$k = 0;
		}
		$j++; $k++;
	}	
	foreach ($valeur AS $value) {
		call_user_func($type[$l], $value, $notnull[$l]);
		$l++;
	}		
}
// texte
function chkAndSec_text($value, $notnull) {
	if (!empty($value))	$value = mysql_real_escape_string (stripslashes ($value));		
	else {
		if ($notnull == true) msg_error(_NULL);
		else{}
	}
}
// numerique
function chkAndSec_num($value, $notnull) {
	if (!empty($value))	{		
		if (!is_numeric($value)) msg_error(_NUMERIC);
		else $value = $value;
	} else {
		if ($notnull == true) msg_error(_NULL);
		else{}
	}
}
// textarea
function chkAndSec_longtext($value, $notnull)
{
	if (!empty($value))	{
		$value = html_entity_decode($value);
		
		// Balises HTML non autorisées
		$value = str_replace(array('&lt;', '&gt;', '&quot;'), array('<', '>', '"'), $value);
		$value = stripslashes($value);
		$value = htmlspecialchars($value);
		$value = str_replace('&amp;', '&', $value);
		
		// Balises autorisées
		$value = preg_replace('/&lt;([^ &]+)[[:blank:]]?((.(?<!&gt;))*)&gt;/', 'secu_args', $value);

		preg_match_all('`<(/?)([^/ >]+)(| [^>]*([^/]))>`', $value, $Tags, PREG_SET_ORDER);

		$TagList = array();
		$bad = false;
		$size = count($Tags);
		for($i=0; $i<$size; $i++) {
			$TagName = ($Tags[$i][3] == '') ? $Tags[$i][2].$Tags[$i][4] : $Tags[$i][2];
			
			if ($Tags[$i][1] == '/') $bad = $bad | array_pop($TagList) != $TagName;
			else array_push($TagList, $TagName);
		}
		$bad = $bad | count($TagList) > 0;

		if ($bad) msg_error(_OUPS);
		else $value = mysql_real_escape_string (stripslashes ($value));		
	} else {
		if ($notnull == true)	msg_error(_NULL);
		else{}
	}
}
// email
function chkAndSec_mail($value, $notnull)
{
	if (!empty($value))	{
		if (strpos($value, '@') === false OR strpos($value, '.') === false) msg_error(_BADMAIL);
		else $value = mysql_real_escape_string (stripslashes ($value));	
	} else {
		if ($notnull == true)	msg_error(_NULL);
		else{}
	}
}
// checkbox
function chkAndSec_checkbox($value, $notnull) {
	if (isset($value) AND ($value == 'on' OR $value == '1' OR $value == true)) $value = mysql_real_escape_string (stripslashes ($value));	
	else {
		if ($notnull == true OR $notnull == 'on' OR $notnull == '1') msg_error(_NULL);
		else{}
	}
}
// affiche le message d'erreur
function msg_error($message) {
	echo '<div class="notification error png_bg"><div>' . $message . '</div></div>';
	back(1);
	exit();
}
// ---------------------------------//
//      Fin de ces fonctions        //
// ---------------------------------//


// fonction retour
function back($where)
{
	if ( empty($where) ) $lien = 'javascript:history.go(-1);';
	else if ( is_numeric($where) ) $lien = 'javascript:history.go(-' . $where . ');';  
	else $lien = $where;
	
	echo '<div class="center"><a href="' . $lien . '">[ ' . _BACK . ' ]</a></div>';
}


?>