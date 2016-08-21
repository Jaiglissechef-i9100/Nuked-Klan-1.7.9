<?php

define ("INDEX_CHECK", 1);
global $language, $user;
include ("../../conf.inc.php");
include ("../../nuked.php");

$session = session_check();
if ($session == 1) $user = secure();
else $user = "";

$session_admin = admin_check();

   if (!$user) {
       $visiteur = 0;
 header('location: index.php');
	 exit;
	 }
	 else
	 {
	  $visiteur = $user[1];
	
    if ($visiteur == 9)
    {
session_start();	
include_once('./kg_adm/language/language.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	
	<title>Administration block, style, video - Powered by Kit-Gaming.org</title>
    <link rel="stylesheet" media="screen" type="text/css" title="amazing" href="css/style_video.css" />
	<script src="modules/js/navi.js" type="text/JavaScript" ></script>

</head>
<body bgcolor="#1e1e1e">
<table align="center" width="798" border="0" cellpadding="0" cellspacing="0" >
<tr valign="top" >
<td  style="background-image:url(images/kg_admin/top_bg.png); background-repeat: no-repeat; " width="798" height="100" class="last">
<div style="padding-top:30px; padding-left:15px;">
<img src="images/en/lang.png" alt="" /> 
<a href="theme_cfg.php?action=set_lang&amp;lang=fr" title="Francais"><img src="images/flags/fr.gif" alt="francais" /></a>
<a href="theme_cfg.php?action=set_lang&amp;lang=en" title="English"><img src="images/flags/uk.gif" alt="English" /></a>
</div>
</td>
</tr>
<tr >
<td   style="background-image:url(images/kg_admin/bg.png);" width="798" height="1"><br/>
<br/><center>
	 </center>


<?php
if(isset($_GET['ordre'])) 
$ordre = htmlentities(addslashes($_GET['ordre']));
else $ordre = "";
if(isset($_GET['mess'])) 
$mess  = htmlentities(addslashes($_GET['mess']));
else $mess = "";


include_once('./kg_adm/error.php');
if(isset($_GET['action']))
$action = htmlentities($_GET['action']);
else $action = "";
if($action == 'preferences')
include_once('./kg_adm/preferences.php');
elseif($action == 'blocks')
include_once('./kg_adm/blocks.php');
elseif($action == 'video')
include_once('./kg_adm/video.php');
elseif($action == 'html')
include_once('./kg_adm/html.php');
elseif($action == 'league')
include_once('./kg_adm/league.php');
elseif($action == 'topmatch')
include_once('./kg_adm/topmatch.php');
elseif($action == 'slider')
include_once('./kg_adm/slider.php');
elseif($action == 'topnews')
include_once('./kg_adm/topnews.php');
elseif($action == 'roster')
include_once('./kg_adm/roster.php');
else
include_once('./kg_adm/main.php');
?>



<br/><br/>
</td>
<tr>
<td  style="background-image:url(images/kg_admin/bas_bg.png); background-repeat: no-repeat; " width="798" height="11" align="center"></td>
</tr>
</table>

</body>
<?php


}
else {
	 header('location: index.php');
	 exit;
}

}
?>