<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('<div style="text-align: center;">You cannot open this page directly</div>'); 

translate('modules/Horoscope/lang/' . $language . '.lang.php');
opentable();

    function index(){
      global $nuked, $bgcolor1, $bgcolor2;

    $bgcolor1 = str_replace('#', '', $bgcolor1);
    $bgcolor2 = str_replace('#', '', $bgcolor2);    

      echo "<br />\n"
          . "<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\">\n"
          . "<tr>\n"
          . "<td align=\"center\"><big><b>".HOROSCOPE."</b></big></td>\n"
          . "</tr>\n"
          ."</table>\n";


      echo "<br /><table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\">\n"
          . "<tr><td align=\"center\">\n"
          . "<script type=\"Text/Javascript\" src=\"http://www.lhoroscope.com/partenaires/Auto/csd.asp?belier=1&taureau=1&gemeaux=1&cancer=1&lion=1&vierge=1&balance=1&scorpion=1&sagittaire=1&capricorne=1&verseau=1&poissons=1&Url_Image=".$nuked['url']."/modules/Horoscope/images/&CouleurTexte=" . $bgcolor2 . "&CouleurTitre=" . $bgcolor1 . "\"></script>\n"
          . "</td></tr></table>\n";
    }

    function signe($signe){
      global $nuked, $bgcolor1, $bgcolor2;

    $bgcolor1 = str_replace('#', '', $bgcolor1);
    $bgcolor2 = str_replace('#', '', $bgcolor2);  

      echo "<br />\n"
          . "<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\">\n"
          . "<tr>\n"
          . "<td align=\"center\"><big><b>".YOURHOROSCOPE."</b></big></td>\n"
          . "</tr>\n"
          ."</table>\n";


      echo "<br /><table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\">\n"
          . "<tr><td align=\"center\">\n"
          . "<script type=\"Text/Javascript\" src=\"http://www.lhoroscope.com/partenaires/Auto/csd.asp?".$signe."=1&Url_Image=".$nuked['url']."/modules/Horoscope/images/&CouleurTexte=" . $bgcolor2."&CouleurTitre=" . $bgcolor1 . "\"></script>\n"
          . "</td></tr></table>\n";
    }

    switch ($_REQUEST['op'])
    {

        case"signe":
            signe($_REQUEST['signe']);
            break;

        default:
            index();
            break;
    }


CloseTable()
?>