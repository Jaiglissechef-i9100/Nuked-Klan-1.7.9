<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die('<div style="text-align: center;">You cannot open this page directly</div>');

global $language, $nuked;
translate("modules/Wow_recrutement/lang/". $language .".lang.php");
define("WOW_RECRUTERMENT_TABLE", $nuked['prefix'] . "_Wow_recrutement");

echo '<script type="text/javascript" src="modules/Wow_recrutement/css.js"></script>'
. '<table style="width:98%;margin:auto;" cellpadding="0" cellspacing="0">';
$sql = mysql_query("SELECT classes, statut, role, color FROM " . WOW_RECRUTERMENT_TABLE . " ORDER BY classes DESC ");
while ($RR = mysql_fetch_array($sql, MYSQL_ASSOC)) {

	switch ($RR['classes']) {
 		case '_DRUID':
                $c_n = _DRUID;$c_d = '4';
                break;

                case '_HUNT':
                $c_n = _HUNT;$c_d = '1';
                break;

                case '_MAGE':
                $c_n = _MAGE;$c_d = '6';
                break;

                case '_DK':
                $c_n = _DK;$c_d = '2';
                break;

                case '_PALADIN':
                $c_n = _PALADIN;$c_d = '7';
                break;

                case '_PRIEST':
                $c_n = _PRIEST;$c_d = '8';
                break;

                case '_ROGUE':
                $c_n = _ROGUE;$c_d = '9';
                break;

                case '_SHAMAN':
                $c_n = _SHAMAN;$c_d = '0';
                break;

                case '_WARLOCK':
                $c_n = _WARLOCK;$c_d = '3';
                break;

                case '_WARRIOR':
                $c_n = _WARRIOR;$c_d = '5';
                break;

                case '_PANDAREN':
                $c_n = _PANDAREN;$c_d = '10';
                break;

                default:
                $c_n = '';
                break;
   	}

    	if($RR['statut'] == "on") {
     		$r_1 = explode('|', $RR['role']);
                if ($r_1[0] != '0') $aff_spe_1 = '<div class="frame_16 recrutement r_'. $c_d .'_0"></div>&nbsp;';
      		else $aff_spe_1 = '';
		if ($r_1[1] != '0') $aff_spe_2 = '<div class="frame_16 recrutement r_'. $c_d .'_1"></div>&nbsp;';
      		else $aff_spe_2 = '';
      		if ($r_1[2] != '0') $aff_spe_3 = '<div class="frame_16 recrutement r_'. $c_d .'_2"></div>&nbsp;';
      		else $aff_spe_3 = '';
		echo '<tr>'
     		. "<td style=\"width:5%;padding-right:12px;padding-bottom:5px;\"><div class=\"frame_16 recrutement r_". $c_d ."\"></div></td>"
     		. "<td style=\"width:60%;text-align:left;padding-bottom:5px;\"><span style=\"color:#". $RR['color'] .";\">". $c_n ."</span></td>"
     		. "<td style=\"width:35%;text-align:right;padding-bottom:5px;\">". $aff_spe_1 . $aff_spe_2 . $aff_spe_3 ."</td>"
     		. "</tr>";
        }
}
echo '</table>'

?>