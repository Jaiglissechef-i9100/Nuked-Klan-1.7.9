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

global $user, $language;
translate("modules/Wow_recrutement/lang/" . $language . ".lang.php");
define("WOW_RECRUTERMENT_TABLE", $nuked['prefix'] . "_Wow_recrutement");
include("modules/Admin/design.php");

$visiteur = !$user ? 0 : $user[1];
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1) {

	function translate_classes($cc) {
                switch ($cc) {
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
                return $c_n.'|'.$c_d;
        }

        function color_txt_spe($txt, $classes, $spe, $c_d) {
	        global $nuked;
	        switch ($txt) {
	        	case '0':
	        	return '<div class="frame_16 recrutement r_'. $c_d .'_'. $spe .'"></div>&nbsp;<a href="index.php?file=Wow_recrutement&amp;page=admin&amp;op=change_spe&amp;spe='. $spe .'&amp;classes='. $classes .'&amp;status=1" title="'. _RECRUTOPEN .'"><img src="modules/Wow_recrutement/img/off.png" alt="" /></a>';
	        	break;

	        	case '1':
	        	return '<div class="frame_16 recrutement r_'. $c_d .'_'. $spe .'"></div>&nbsp;<a href="index.php?file=Wow_recrutement&amp;page=admin&amp;op=change_spe&amp;spe='. $spe .'&amp;classes='. $classes .'&amp;status=0" title="'. _RECRUTCLOSE .'"><img src="modules/Wow_recrutement/img/on.png" alt="" /></a>';
	        	break;
	        }
	}

    	function main() {
	        global $nuked;

	        $sql = mysql_query("SELECT classes FROM " . WOW_RECRUTERMENT_TABLE);
	        $count = mysql_num_rows($sql);
	        echo '<script type="text/javascript" src="modules/Wow_recrutement/css.js"></script>'
	        . "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	        . "<div class=\"content-box-header\"><h3>" . _ADMINWOWRECRUTEMENT . "</h3>\n"
	        . "</div>\n"
	        . "<div class=\"tab-content\" id=\"tab2\">\n"
	        . "<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
	        . "<tr>\n"
	        . "<td style=\"width: 5%;\" align=\"center\">&nbsp;</td>\n"
	        . "<td style=\"width: 25%;\" align=\"center\"><b>" . _W_CLASSES . "</b></td>\n"
	        . "<td style=\"width: 25%;\" align=\"center\"><b>" . _W_STATUT . "</b></td>\n"
	        . "<td style=\"width: 25%;\" align=\"center\"><b>" . _W_ROLE . "</b></td>\n"
	        . "<td style=\"width: 10%;\" align=\"center\"><b>" . _W_ACTION . "</b></td></tr>\n";

	        $sql = mysql_query("SELECT classes, statut, role, color FROM " . WOW_RECRUTERMENT_TABLE . " ORDER BY classes DESC ");
                while ($RR = mysql_fetch_array($sql, MYSQL_ASSOC)) {

                        $c_n_a = explode('|', translate_classes($RR['classes']));

                        if ($j == 0) {
                        	$bg = $bgcolor2;
                        	$j++;
                        } else {
                        	$bg = $bgcolor1;
                        	$j = 0;
                        }

                        if($RR['statut'] == "on") $img_recrut = '<a style="text-decoration: none;" href="index.php?file=Wow_recrutement&amp;page=admin&amp;op=statut_off&amp;classes='. $RR['classes'] .'" title="'. _RECRUTCLOSE .' : '. $c_n_a[0] .'"><img style="vertical-align:middle;" src="modules/Wow_recrutement/img/on.png" alt="" />&nbsp;<span style="color:#008000;">'. _OPEN .'</span></a>';
                        else $img_recrut = '<a style="text-decoration: none;" href="index.php?file=Wow_recrutement&amp;page=admin&amp;op=statut_ok&amp;classes='. $RR['classes'] .'" title="'. _RECRUTOPEN .' : '. $c_n_a[0] .'"><img style="vertical-align:middle;" src="modules/Wow_recrutement/img/off.png" alt="" />&nbsp;<span style="color:#F63025;">'. _CLOSE .'</span></a>';

                        $r_1 = explode('|', $RR['role']);
      			$aff_spe_1_1 = color_txt_spe($r_1[0], $RR['classes'], '0', $c_n_a[1]) .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$aff_spe_1_2 = color_txt_spe($r_1[1], $RR['classes'], '1', $c_n_a[1]) .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      			$aff_spe_1_3 = color_txt_spe($r_1[2], $RR['classes'], '2', $c_n_a[1]);

                        echo "<tr style=\"background: " . $bg . ";\">"
                        . "<td class=\"td_2_b_rt_t_l\"><div class=\"frame_16 recrutement r_". $c_n_a[1] ."\"></div></td>"
                        . "<td class=\"td_2_b_rt_t_l\">" . $c_n_a[0] . "<span style=\"background:#". $RR['color'] .";float:right;display:block;width:15px;height:15px;border:1px solid ". $bgcolor4 .";margin-right:10px;\"></span></td>"
                        . "<td class=\"td_2_b_rt_t_l\">" . $img_recrut . "</td>"
                        . "<td class=\"td_2_b_rt_t_c\">". $aff_spe_1_1 . $aff_spe_1_2 . $aff_spe_1_3 ."</td>"
                        . '<td class="td_2_b_t_t_c"><a href="index.php?file=Wow_recrutement&amp;page=admin&amp;op=edit&amp;classes='. $RR['classes'] .'"><img src="images/edit.gif" alt="" /></a></td></tr>';
                }

	        echo "</table>"
	        . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    	}

    	function statut_ok($classes) {

		$bdd = mysql_query("UPDATE " . WOW_RECRUTERMENT_TABLE . " SET statut = 'on' WHERE classes = '" . $classes . "'");
	        echo "<div class=\"notification success png_bg\">\n"
	        . "<div>\n"
	        . "" . _STATUTON . "\n"
	        . "</div>\n"
	        . "</div>\n";
	       	redirect("index.php?file=Wow_recrutement&page=admin",2);
    	}

    	function statut_off($classes) {

            	$bdd = mysql_query("UPDATE " . WOW_RECRUTERMENT_TABLE . " SET statut = 'off' WHERE classes = '" . $classes . "'");
	        echo "<div class=\"notification success png_bg\">\n"
            	. "<div>\n"
            	. "" . _STATUTOFF . "\n"
            	. "</div>\n"
            	. "</div>\n";
            	redirect("index.php?file=Wow_recrutement&page=admin",2);
    	}

    	function edit($classes) {

            	global $nuked, $language;

            	$c_n_a = explode('|', translate_classes($classes));

            	$sql = mysql_query("SELECT color, classes FROM " . WOW_RECRUTERMENT_TABLE . " WHERE classes = '" . $classes . "'");
            	list($color, $classes) = mysql_fetch_array($sql);

                echo '<link rel="stylesheet" media="screen" type="text/css" href="media/colorpicker/css/colorpicker.css" />
		<script type="text/javascript" src="media/colorpicker/js/colorpicker.js"></script>'

            	. "<div class=\"content-box\">\n" //<!-- Start Content Box -->
            	. "<div class=\"content-box-header\"><h3>" . _ADMINWOWRECRUTEMENT . "</h3>\n"
            	. "</div>\n"
            	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">" . _W_EDIT_CLASSES . " " . $c_n_a[0] . "</div><br />"
            	. "<form method=\"post\" action=\"index.php?file=Wow_recrutement&page=admin&amp;op=edit_ok\" onsubmit=\"backslash('guest_text');\">\n"
            	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"0\" cellpadding=\"2\"border=\"0\">\n"
            	. "<tr><td><b>" . _COLOR . " :</b></td><td><input type=\"text\" id=\"couleur\" name=\"color\" value=\"". $color ."\" /></td></tr>\n"
            	. "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"send\" value=\"" . _MODIF . "\" /><input type=\"hidden\" name=\"classes\" value=\"" . $classes . "\" /></td></tr></table>\n"
            	. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Wow_recrutement&page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div>\n"
            	. '<script type="text/javascript">
            	//<![CDATA[
            	$(\'#couleur\').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {$(el).val(hex);$(el).ColorPickerHide();},
		onBeforeShow: function () {$(this).ColorPickerSetColor(this.value);}})
		.bind(\'keyup\', function(){$(this).ColorPickerSetColor(this.value);});
		//]]>
		</script>';
    	}

    	function edit_ok($color, $classes) {

            	$sql = mysql_query("UPDATE ". WOW_RECRUTERMENT_TABLE ." SET color = '". $color ."'  WHERE classes = '". $classes ."'");
            	echo "<div class=\"notification success png_bg\">\n"
            	. "<div>\n"
            	. "" . _STATUTCOULEUR . "\n"
            	. "</div>\n"
            	. "</div>\n";
            	redirect("index.php?file=Wow_recrutement&page=admin",2);
    	}

        function change_spe($classes, $spe, $status) {

                if (!is_numeric($status)) $status = '1';
                else $status = $status;

                $sql = mysql_query("SELECT role FROM ". WOW_RECRUTERMENT_TABLE ." WHERE classes = '". $classes ."'");
                list($rr) = mysql_fetch_array($sql);
                $breadcrumbs_code = '';
                $displayfolders = explode('|', $rr);
                for ($i=0; $i <= sizeof($displayfolders); $i++) {
                	if (isset($displayfolders[$i]) && $displayfolders[$i] != null) {
                		if ($i == $spe) $x = $status;
                		else $x = $displayfolders[$i];
                		$breadcrumbs_code .= $x;
                		if($i<=1) $breadcrumbs_code .= '|';
                	}
                }

            	$bdd = mysql_query("UPDATE ". WOW_RECRUTERMENT_TABLE ." SET role = '". $breadcrumbs_code ."' WHERE classes = '". $classes ."'");
            	echo "<div class=\"notification success png_bg\">\n"
            	. "<div>\n"
            	. "" . _STATUTSPE . "\n"
            	. "</div>\n"
            	. "</div>\n";
            	redirect("index.php?file=Wow_recrutement&page=admin",2);
    	}

	switch($_REQUEST['op']) {
        	case "statut_ok":
            	admintop();
            	statut_ok($_REQUEST['classes']);
            	adminfoot();
            	break;

        	case "statut_off":
            	admintop();
            	statut_off($_REQUEST['classes']);
            	adminfoot();
            	break;

        	case "edit":
            	admintop();
            	edit($_REQUEST['classes']);
            	adminfoot();
            	break;

        	case "edit_ok":
            	admintop();
            	edit_ok($_REQUEST['color'], $_REQUEST['classes']);
            	adminfoot();
            	break;

        	case "change_spe":
            	admintop();
            	change_spe($_REQUEST['classes'], $_REQUEST['spe'], $_REQUEST['status']);
            	adminfoot();
            	break;

        	default:
            	admintop();
            	main();
            	adminfoot();
            	break;
    	}

} else if ($level_admin == -1) {
    	admintop();
    	echo "<div class=\"notification error png_bg\">\n"
        . "<div>\n"
        . "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
        . "</div>\n"
        . "</div>\n";
    	adminfoot();
} else if ($visiteur > 1) {
    	admintop();
    	echo "<div class=\"notification error png_bg\">\n"
        . "<div>\n"
        . "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
        . "</div>\n"
        . "</div>\n";
    	adminfoot();
} else {
    	admintop();
    	echo "<div class=\"notification error png_bg\">\n"
        . "<div>\n"
        . "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
        . "</div>\n"
        . "</div>\n";
    	adminfoot();
}

?>
