<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.eu                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
	die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $nuked;

// Dossier de réception des fichiers
$upload_dir = 'upload/Formulaires/';  
// Extensions autorisées
$file_extensions  = array('.jpg', 'jpeg', '.png', '.gif', '.pdf', '.txt');
// Taille max. des fichiers (en octets)
$max_size = 1000000; 

// autorise l'accès à la liste des formulaires (coté user)
DEFINE('_PASSLIST', true);

// tables
DEFINE('FORMS_TABLE', $nuked['prefix'] . '_mod_frms');
DEFINE('FORMS_DETAILS_TABLE', $nuked['prefix'] . '_mod_frms_details');
DEFINE('FORMS_REC_TABLE', $nuked['prefix'] . '_mod_frms_rec');
DEFINE('FORMS_REC_DETAILS_TABLE', $nuked['prefix'] . '_mod_frms_rec_details');

// inclusion du js du module
include ( 'modules/Formulaires/js/scripts.js' );

// fonction retour
function back($where)
{
	if ( is_numeric ( $where ) )	echo '<div id="back">[ <a href="javascript:history.go(-' . $where . ');">' . _BACK . '</a> ]</div>';  
	else echo '<div id="back">[ <a href="' . $where . '">' . _BACK . '</a> ]</div>';  
}

// envoi le mail en cas de réponse (si checké)
function sendmail($title, $mail, $id_rec)
{
	global $nuked, $user, $user_ip;
	
	$time = time();
	$date = nkDate($time);

	if ( $mail != "" ) $email = $mail;
	else $email = $nuked['mail'];    
	
	if ( $user ) $sender = $user[2];
	else $sender = _VISITEUR;
	
	$corps = '<p>' . _CORPS . ' : "' . $title . '"<br />';
	$corps .= '<a href="' . $nuked['url'] . '/index.php?file=Formulaires&amp;page=admin&amp;op=resp_details&amp;id=' . $id_rec . '">' . _CLICTHIS .'</a></p>';
	$corps .= '<p>' . _IDUSER . $sender . '<br />' . _IPUSER . $user_ip . '</p>';
	$corps .= '<p>' . _FORWEBSITE . '<br />' . $nuked['name'] . ' - ' . $nuked['slogan'] . '</p>';
	
	$mail = trim($mail);
	$sujet = trim(_SUBJECT);
	$corps = trim($corps);
	$sender = trim($sender);
	
	$subjet = stripslashes($sujet) . ", " . $date;
	$corp = secu_html(html_entity_decode($corps));
	$from = "From: " . $sender . "\r\n";
	$from .= "Content-Type: text/html\r\n\r\n";

	mail($email, $subjet, $corp, $from);
}

?>