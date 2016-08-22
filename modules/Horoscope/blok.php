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

global $nuked, $language;
translate("modules/Horoscope/lang/" . $language . ".lang.php");

$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);
if ($active == 3 || $active == 4)
{
    echo'    <br />
    <table align="center" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Belier"><img src="modules/Horoscope/images/belier.gif" title="'.BELIER.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Taureau"><img src="modules/Horoscope/images/taureau.gif" title="'.TAUREAU.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Gemeaux"><img src="modules/Horoscope/images/gemeaux.gif" title="'.GEMEAUX.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Cancer"><img src="modules/Horoscope/images/cancer.gif" title="'.CANCER.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Lion"><img src="modules/Horoscope/images/lion.gif" title="'.LION.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Vierge"><img src="modules/Horoscope/images/vierge.gif" title="'.VIERGE.'" alt="" border="0" height="60" width="60"></a></td>
      </tr>
      <tr>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Balance"><img src="modules/Horoscope/images/balance.gif" title="'.BALANCE.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Scorpion"><img src="modules/Horoscope/images/scorpion.gif" title="'.SCORPION.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Sagittaire"><img src="modules/Horoscope/images/sagittaire.gif" title="'.SAGITTAIRE.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Capricorne"><img src="modules/Horoscope/images/capricorne.gif" title="'.CAPRICORNE.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Verseau"><img src="modules/Horoscope/images/verseau.gif" title="'.VERSEAU.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Poissons"><img src="modules/Horoscope/images/poissons.gif" title="'.POISSON.'" alt="" border="0" height="60" width="60"></a></td>
      </tr>
    </table>
    <br />';

    echo'<div style="text-align: center;"><a href="index.php?file=Horoscope">'.SEEALL.'</a></div>';
}
else
{
    echo'    <br />
    <table align="center" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Belier"><img src="modules/Horoscope/images/belier.gif" title="'.BELIER.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Taureau"><img src="modules/Horoscope/images/taureau.gif" title="'.TAUREAU.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Gemeaux"><img src="modules/Horoscope/images/gemeaux.gif" title="'.GEMEAUX.'" alt="" border="0" height="60" width="60"></a></td>
      </tr>
      <tr>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Cancer"><img src="modules/Horoscope/images/cancer.gif" title="'.CANCER.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Lion"><img src="modules/Horoscope/images/lion.gif" title="'.LION.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Vierge"><img src="modules/Horoscope/images/vierge.gif" title="'.VIERGE.'" alt="" border="0" height="60" width="60"></a></td>
      </tr>
      <tr>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Balance"><img src="modules/Horoscope/images/balance.gif" title="'.BALANCE.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Scorpion"><img src="modules/Horoscope/images/scorpion.gif" title="'.SCORPION.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Sagittaire"><img src="modules/Horoscope/images/sagittaire.gif" title="'.SAGITTAIRE.'" alt="" border="0" height="60" width="60"></a></td>
      </tr>
      <tr>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Capricorne"><img src="modules/Horoscope/images/capricorne.gif" title="'.CAPRICORNE.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Verseau"><img src="modules/Horoscope/images/verseau.gif" title="'.VERSEAU.'" alt="" border="0" height="60" width="60"></a></td>
        <td align="center"><a href="index.php?file=Horoscope&op=signe&signe=Poissons"><img src="modules/Horoscope/images/poissons.gif" title="'.POISSON.'" alt="" border="0" height="60" width="60"></a></td>
      </tr>
    </table>
    <br />';

    echo'<div style="text-align: center;"><a href="index.php?file=Horoscope">'.SEEALL.'</a></div>';
}

?>