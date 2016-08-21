<?php
if(isset($_GET['action'])) 
$get_action = htmlentities(addslashes($_GET['action']));
else
$get_action = "";
if(isset($_GET['lang'])) 
$get_lang = strtoupper(htmlentities(addslashes($_GET['lang'])));
else
$get_lang = "";

if ($get_action === 'set_lang') {
	$_SESSION['lang'] = $get_lang;
	}
if (!isset($_SESSION['lang'])) { $_SESSION['lang'] = 'FR'; }
define('LANGUE',  $_SESSION['lang']);

if (LANGUE !== 'FR' && LANGUE !== 'EN') {
			$_SESSION['lang'] = 'FR';
			
}
if (LANGUE === 'FR') require('kg_adm/language/fr.php');
elseif (LANGUE === 'EN') require('kg_adm/language/en.php');
else require('kg_adm/language/fr.php');

?>