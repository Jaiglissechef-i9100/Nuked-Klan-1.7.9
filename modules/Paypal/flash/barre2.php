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

				$sql = mysql_query("SELECT flaw, flah FROM ". $nuked['prefix'] ."_paypal_flash WHERE id='2'");
				list($flaw, $flah ) = mysql_fetch_array($sql);
		
		 echo "<div style=\"text-align:center\">
			   <object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"".$flaw."\" height=\"".$flah."\>
			   <param name=\"movie\" value=\"/Paypal/flash/barre2.swf?demande=".$demande."&recu=".$recu."\">
			   <param name=\"quality\" value=\"high\" />
			   <param name=\"wmode\" value=\"transparent\" />
			   <param name=\"salign\" value=\"T\" />
			   <param name=\"salign\" value=\"center\" />
			   <param name=\"SCALE\" value=\"autohigh\">\n";
		echo "<!--[if !IE]>-->
			   <object type=\"application/x-shockwave-flash\" data=\"/modules/Paypal/flash/barre2.swf?demande=".$demande."&recu=".$recu."&pourcent=".$var1."\" width=\"".$flaw."\" height=\"".$flah."\">
			   <param name=\"movie\" value=\"/modules/Paypal/flash/barre2.swf?demande=".$demande."&recu=".$recu." width=\"".$flaw."\" height=\"".$flah." \">				
			   <param name=\"quality\" value=\"high\" />
			   <param name=\"wmode\" value=\"transparent\" />
			   <param name=\"salign\" value=\"T\" />
			   <param name=\"salign\" value=\"center\" />
			   <param name=\"SCALE\" value=\"autohigh\">\n";
		 echo "<!--<![endif]-->
			   <a href=\"http://www.adobe.com/go/getflash\">
			   <img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Obtenir Adobe Flash Player\" /></a>\n";
		echo "<!--[if !IE]>-->
			  </object>\n";
		echo "<!--<![endif]-->
			  </object></div><br />\n";

?>
				