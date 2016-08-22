<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// Module Dons Paypal Pour NK 1.7.9 RC6                                     //
// Créer par Stive @ PalaceWaR.eu                                           //
// -------------------------------------------------------------------------//

echo "<style type=\"text/css\">
#copyleft-paypal {
    margin-top: 85%;
	text-align:center;;
	cursor: text;
	width: 100%;
}
</style>\n";

if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $nuked, $user, $language, $bgcolor1, $bgcolor3;

translate("modules/Paypal/lang/" . $language . ".lang.php");

opentable();

if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{
error_reporting(0);	
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

$header  = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);


if (!$fp) {

} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {

echo "Votre Statue est : <b>" .$res ."</b><br><br>";


 foreach ($_POST as $key => $value) {

$value = urlencode(stripslashes($value));

$req .= "&amp;$key=$value";

   }
		  $montant = $_POST['mc_gross']; 
		  $autor = $_POST['option_name1'];
		  $autor_id = $_POST['custom'];
		  $date = $_POST['payment_date']; 
		  $nomdons = $_POST['item_name'];

	      $sql = mysql_query("SELECT ok FROM ". $nuked['prefix'] ."_paypal");
		  list($messageok) = mysql_fetch_array($sql);
		  			  

				echo '<table style="margin: auto" width="80%" border="0" cellspacing="3" cellpadding=\"3\">'."\n"
				   . '<tr style="background: " . $bgcolor1 . ""><td style="border: 1px dashed " . $bgcolor3 . "">'."\n" ;
				      $messcorrige = ''. $messageok .'';
					  $messcorrige = str_replace('%donateur%' ,''. $autor . '',$messcorrige);
					  $messcorrige = str_replace('%donner%' ,''. $montant . '',$messcorrige);
					  $messcorrige = str_replace('%date%' ,''. $date . '',$messcorrige); 
					  $messcorrige = str_replace('%nomdudons%' ,''. $nomdons . '',$messcorrige);
			    echo ' '. $messcorrige .' </td></tr></table>'."\n";


}
else if (strcmp ($res, "INVALID") == 0) {

echo "Clef frauduleuse: <b>" .$res ."</b>";

  }

}
fclose ($fp);
}

}
else if ($level_access == -1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
}
else if ($level_access == 1 && $visiteur == 0)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b></div><br /><br />";
}
else
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
}
echo "<div id=\"copyleft-paypal\">" . _COPYLEFT . "</div> ";
closetable();
redirect("" . $nuked[url] . "/index.php?file=Paypal",6);

?>

