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
	
		  echo "<div style=\"text-align:center\">
			    <object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"150\" height=\"110\">
                <param name=\"movie\" value=\"/modules/Paypal/flash/barre3.swf?pourcent=".$var1."\">
				<param name=\"quality\" value=\"high\">
				<param name=\"wmode\" value=\"transparent\">
                <param name=\"salign\" value=\"T\"> 
				<param name=\"salign\" value=\"center\"> 
				<param name=\"SCALE\" value=\"autohigh\">\n";
		  echo "<!--[if !IE]>-->
				<object type=\"application/x-shockwave-flash\" data=\"/modules/Paypal/flash/barre3.swf?pourcent=".$var1."\" width=\"150\" height=\"110\"> 
                <param name=\"movie\" value=\"/modules/Paypal/flash/barre3.swf?pourcent=".$var1."\"\">				
				<param name=\"quality\" value=\"high\"> 
				<param name=\"wmode\" value=\"transparent\"> 
				<param name=\"salign\" value=\"T\"> 
				<param name=\"salign\" value=\"center\"> 
				<param name=\"SCALE\" value=\"autohigh\">\n";
		 echo "<!--<![endif]-->
				<a href=\"http://www.adobe.com/go/getflash\"> 
				<img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Obtenir Adobe Flash Player\" /></a>\n";		
		 echo "<!--[if !IE]>-->
			   </object>\n";
		 echo "<!--<![endif]-->
			   </object></div><br />\n";
?>