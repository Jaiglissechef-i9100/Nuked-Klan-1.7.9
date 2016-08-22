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

global $nuked, $user, $language;
	
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

 foreach ($_POST as $key => $value) {

$value = urlencode(stripslashes($value));

$req .= "&amp;$key=$value";

   }
$montant = $_POST['mc_gross']; 
$autor = $_POST['option_name1'];
$autor_id = $_POST['custom'];
$date = time();

  $req = "INSERT INTO ". $nuked['prefix'] ."_paypal_accepte (autor, autor_id, date, montant) VALUES('".$autor."', '".$autor_id."', '".$date. "', '".$montant."')";
  mysql_query($req); 
  
}
else if (strcmp ($res, "INVALID") == 0) {

echo "Clef frauduleuse: <b>" .$res ."</b>";

  }

}
fclose ($fp);
}

?>