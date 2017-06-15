<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined("INDEX_CHECK") or die ('You can\'t run this file alone.');

global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3;
translate('modules/Calendar/lang/' . $language . '.lang.php');

?>
<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
<style>
#calendar *{
	margin: 0;
	padding: 0;
}

.clasp {
	background: #aaaaaa;
	border: 1px solid #999999;
	border-radius: 4px;
	box-shadow: 0 -1px 5px rgba(0,0,0,0.4), inset -1px 1px 2px white;
	display: block;
	height: 16px;
	position: absolute;
	top: -5px;
	width: 4px;
	z-index: 2000;
}
.clasp.hole-left {
	left: 9px;
}
.clasp.hole-right {
	right: 9px;
}

.hole {
	background: #99ccff;
	border-radius: 8px;
	box-shadow: 0 -1px 0 black, inset 0 0 20px #878787;
	display: block;
	height: 8px;
	position: absolute;
	top: 8px;
	width: 8px;
}

.hole-left {
	left: 8px;
}
.hole-right {
	right: 8px;
}

#calendar {
	background: #e4e0e7;
	box-shadow: 0 0 20px <?php echo $bgcolor3; ?>;
	height: auto;
	margin: 20px auto;
	position: relative;
	text-align: center;
	width: 100%
	
}
#eventscal {
    height: auto;
	margin: 20px auto;
	position: relative;
	text-align: center;
	width: 100%
}
#eventscal .titreevents{
    font-family: 'Poiret One', cursive;
	/*color: <?php echo $bgcolor1; ?>;*/
    background: <?php echo $bgcolor3; ?>; 
    border-top: 1px <?php echo $bgcolor2; ?>;	
	border-left: 1px <?php echo $bgcolor2; ?>;	
	border-right: 1px <?php echo $bgcolor2; ?>;	
	-webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
	padding: 5px;
	
}
#month {
	background: linear-gradient(<?php echo $bgcolor3; ?>, <?php echo $bgcolor2; ?>);
	font-family: 'Poiret One', cursive;
	font-size: 16px;
	/*color: <?php echo $bgcolor1; ?>;*/
	height: 30px;
	line-height: 30px;
	text-shadow: 0 -1px 0 <?php echo $bgcolor3; ?>;
	width: 100%
}
#month a {
    text-decoration:none;
	/*color: <?php echo $bgcolor1; ?>;*/
}
#days {
	background: linear-gradient(#f4f4f4, #ebebeb);
	-webkit-box-shadow: 0 1px 0 #aaaaaa;
}

table.days {
	color: #888888;
	font-size: 14px;
	width: 100%
}

table.day td, table.days td {
	width: 47px;
	
}

table.day td {
	background: #f4f0f7;
	color: #878787;
	height: 29px;
	box-shadow: 0 -1px 0 white;
}

table.day td.old-month {
	color: #aaaaaa;
	background: <?php echo $bgcolor1; ?>;
}

table.day td:hover {
  background: #e9e9ee;
  cursor: pointer;
}

table.day span.selected {
	/*background: linear-gradient(<?php echo $bgcolor3; ?>, <?php echo $bgcolor1; ?>);*/
	color: #C00000;
	font-size: 14px;
	text-shadow: 0 -1px 0 <?php echo $bgcolor2; ?>;
	-webkit-border-radius: 90px;
    -moz-border-radius: 90px;
    border-radius: 90px;
	padding:3px;
}

table.day td#appoint {
	border-bottom: 3px solid #99ccff;
}
p#vtip { display: none; 
position: absolute; 
padding: 10px; 
left: 5px; 
font-size: 0.8em; 
background-color: <?php echo $bgcolor2; ?>; 
border: 1px solid <?php echo $bgcolor3; ?>; 
-moz-border-radius: 5px; 
-webkit-border-radius: 5px; 
z-index: 9999 }

p#vtip #vtipArrow { position: absolute; top: -10px; left: 5px }
</style>
<script type="text/javascript" src="Includes/blocks/js/vTip_v2/jquery.js"></script>
<script type="text/javascript" src="Includes/blocks/js/vTip_v2/vtip.js"></script>
<?php
function affich_block_event($blok){
// Patch calendar fr
    global $nuked, $bgcolor1, $bgcolor2, $bgcolor3, $file, $language;
// Fin patch calendar fr

    define ('ADAY', (61 * 60 * 24));
    $datearray = getdate();

    if (empty($_REQUEST['mo']) && empty($_REQUEST['ye'])){
        $month = $datearray['mon'];
        $year = $datearray['year'];
        $nextmonth = $month + 1;
        $prevmonth = $month-1;

        if ($nextmonth > 12){
            $nextmonth = 1;
            $nextyear = $year + 1;
        }
        else $nextyear = $year;

        if ($prevmonth < 1){
            $prevmonth = 12;
            $prevyear = $year-1;
        }
        else $prevyear = $year;

    }
    else{
        $month = $_REQUEST['mo'];
        $year = $_REQUEST['ye'];
        $nextmonth = $_REQUEST['mo'] + 1;
        $prevmonth = $_REQUEST['mo']-1;
		
        if ($nextmonth > 12){
            $nextmonth = 1;
            $nextyear = $year + 1;
        }
        else $nextyear = $year;

        if ($prevmonth < 1){
            $prevmonth = 12;
            $prevyear = $year - 1;
        }
        else $prevyear = $year;

    }
// Patch calendar fr
    if ($language == "french")
	{
		$start = mktime(0, 0, 0, $month, 1, $year);
		$days = Array(_MON, _TUE, _WEN, _THR, _FRI, _SAT, _SUN);
		$start2 = mktime(0, 0, 0, $month, 7, $year);
		$firstdayarray = getdate($start2);
	}
	else	
	{
		$start = mktime(0, 0, 0, $month, 1, $year);
		$days = Array(_SUN, _MON, _TUE, _WEN, _THR, _FRI, _SAT);
		$firstdayarray = getdate($start);
	}
// Fin patch calendar fr	

    //$start = mktime(0, 0, 0, $month, 1, $year);
    //$firstdayarray = getdate($start);

    $months = Array(_JAN, _FEB, _MAR, _APR, _MAY, _JUN, _JUL, _AUG, _SEP, _OCT, _NOV, _DEC);
    $this_month = $month - 1;
    //$days = Array(_SUN, _MON, _TUE, _WEN, _THR, _FRI, _SAT);

    $blok['content'] .= '<div id="calendar">
	                     <div class="clasp hole-left"></div><div class="clasp hole-right"></div>
	                     <div class="hole hole-left"></div><div class="hole hole-right"></div>
	                     <div id="month"><a href="index.php?file='.$file.'&amp;mo=' . $prevmonth . '&amp;ye='.$prevyear.'" title="'._PREVMONTH.'">&laquo;&nbsp;</a>'.$months[$this_month].'&nbsp;'.$year.'<a href="index.php?file='.$file.'&amp;mo='.$nextmonth.'&amp;ye='.$nextyear.'" title="'._NEXTMONTH.'">&nbsp;&raquo;</a></div>'."\n"					 
					  . '<div id="days"><table class="days"><tr>'."\n";

	$size = count($days);
	for($i=0; $i<$size; $i++){
		$blok['content'] .= '<td><b>' . $days[$i] . '</b></td>';
	}

    for($count = 0;$count < (6 * 7);$count++){
        $dayarray = getdate($start);

        if ((($count) % 7) == 0){
            $blok['content'] .= '</tr></table><table class="day"><tr>';
        }

        if ($count < $firstdayarray['wday'] || $dayarray['mon'] != $month){
            $blok['content'] .= '<td class="old-month">&nbsp;</td>';
        }
        else{
            if ($dayarray['mday'] == $datearray['mday'] && $dayarray['mon'] == $datearray['mon']){
                $bd = '<span class="selected"><b>';
                $bf = '</b></span>';
            }
            else{
                $bd = '';
                $bf = '';
            }

            $event_date = $dayarray['mday'];
            $txt = '';
            $heure2 = '';

            $sql1 = mysql_query('SELECT titre, date_jour, date_mois, date_an, heure, auteur FROM ' . CALENDAR_TABLE . ' WHERE date_an = \'' . $year . '\' AND date_mois = \'' . $month . '\' AND date_jour = \'' . $event_date . '\' ORDER BY heure');
            $nb_event = mysql_num_rows($sql1);

            if (defined("WARS_TABLE")){
                $sql2 = mysql_query('SELECT * FROM ' . WARS_TABLE . ' WHERE date_an = \'' . $year . '\' AND date_mois = \'' . $month . '\' AND date_jour = \'' . $event_date . '\' ');
                $nb_match = mysql_num_rows($sql2);
            }
            else{
                $nb_match = 0;
            }

            $nb_birthday = 0;
            if ($nuked['birthday'] != 'off'){
                $sql3 = mysql_query('SELECT user_id, age FROM ' . USER_DETAIL_TABLE);
                while (list($tuid, $tage) = mysql_fetch_array($sql3)){
                    list ($tjour, $tmois, $tan) = explode ('/', $tage);

                    if ($nuked['birthday'] == 'team'){
                        $and = 'AND team > 0';
                    }
                    else if ($nuked['birthday'] == 'admin'){
                        $and = 'AND niveau > 1';
                    }
                    else{
                        $and = '';
                    }

                    $sql_test = mysql_query('SELECT pseudo FROM ' . USER_TABLE . ' WHERE id = \'' . $tuid . '\' '. $and);
                    $test = mysql_num_rows($sql_test);

                    if ($tmois == $month && $tjour == $event_date && $test > 0){
                        $nb_birthday++;
                    }
                }
            }

            if ($nb_match > 0 || $nb_event > 0 || $nb_birthday > 0){
                while (list($titre1, $jour1, $mois1, $an1, $heure1, $auteur1) = mysql_fetch_array($sql1)){
                        $titre1 = printSecuTags($titre1);

                    if (defined("WARS_TABLE")){
                        $sql = mysql_query('SELECT etat, adversaire, type, date_jour, date_mois, date_an, heure, style, tscore_team, tscore_adv FROM ' . WARS_TABLE . ' WHERE date_an = \'' . $year . '\' AND date_mois = \''. $month . '\' AND date_jour = \'' . $event_date . '\' AND heure >= \'' . $heure2 . '\' AND heure < \'' . $heure1 . '\' ORDER BY heure');
                        while (list($etat, $adv_name, $type_match, $jour, $mois, $an, $heure, $style, $score_team, $score_adv) = mysql_fetch_array($sql)){
                            if ($etat == 1){
                                if ($score_team < $score_adv){
                                    $scores = _RESULT . ' : <span style="color: #900"><b>' . $score_team . ' - ' . $score_adv . '</b></span>';
                                }
                                else if ($score_team > $score_adv){
                                    $scores = _RESULT . ' : <span style="color: #090"><b>' . $score_team . ' - ' . $score_adv . '</b></span>';
                                }
                                else{
                                    $scores = _RESULT . ' : <span style="color: #009"><b>' . $score_team . ' - ' . $score_adv . '</b></span>';
                                }
                            }
                            else{
                                $scores = "";
                            }

                            if ($heure) $txt .= '<b>' . $heure . '</b><br />';
                            $txt .= _MATCH . '&nbsp:' . $type_match;
                            if ($adv_name) $txt .= _VS . '&nbsp;' . $adv_name;
                            if ($scores)$txt .= '<br />' . $scores;
                            $txt .= '<br />';
                        }
                    }

                    if ($heure1) $txt .= '<br />&agrave;&nbsp;<b>' . $heure1 . '</b>&nbsp;';
                    $txt .= $titre1;
                    //$txt .= '<br />';
					$txt .= '';

                    $heure2 = $heure1;
                }

                if (defined("WARS_TABLE")){
                    $sql = mysql_query('SELECT etat, adversaire, type, date_jour, date_mois, date_an, heure, style, tscore_team, tscore_adv FROM ' . WARS_TABLE . ' WHERE date_an = \'' . $year . '\' AND date_mois = \'' . $month . '\' AND date_jour = \'' . $event_date . '\' AND heure >= \'' . $heure2 . '\' ORDER BY heure');
                    while (list($etat, $adv_name, $type_match, $jour, $mois, $an, $heure, $style, $score_team, $score_adv) = mysql_fetch_array($sql)){
                        if ($etat == 1 && $score_team != "" && $score_adv != ""){
                            if ($score_team < $score_adv){
                                $scores = _RESULT . ' : <span style="color: #900;"><b>' . $score_team . ' - ' . $score_adv . '</b></span>';
                            }
                            else if ($score_team > $score_adv){
                                $scores = _RESULT . ' : <span style="color: #090;"><b>' . $score_team . ' - ' . $score_adv . '</b></span>';
                            }
                            else{
                                $scores = _RESULT . " : <span style='color: #000099;'><b>" . $score_team . "&nbsp;-&nbsp;" . $score_adv . "</b></span>";
                            }
                        }
                        else{
                            $scores = '';
                        }

                        if ($heure) $txt .= '<br />&agrave;&nbsp;<b>' . $heure . '</b>&nbsp;';
                        $txt .= _MATCH . '&nbsp;' . $type_match;
                        if ($adv_name) $txt .= '&nbsp;' . _VS . '&nbsp;' . $adv_name;
                        if ($scores)$txt .= '<br />' . $scores;
                        //$txt .= '<br /><br />';
						$txt .= '';
                    }
                }

                if ($nb_birthday > 0){
                    $sql4 = mysql_query('SELECT user_id, prenom, age FROM ' . USER_DETAIL_TABLE);
                    while (list($id_user, $prenom, $birthday) = mysql_fetch_array($sql4)){

                        if ($birthday != ""){
                            list ($ajour, $amois, $aan) = explode ('/', $birthday);

                            if ($amois == $month && $ajour == $event_date){
                                $age = $year - $aan;
								
                                if ($month < $amois){
                                    $age = $age - 1;
                                }
								
                                if ($event_date < $ajour && $month == $amois){
                                    $age = $age-1;
                                }
								
                                $sql5 = mysql_query('SELECT pseudo FROM ' . USER_TABLE . ' WHERE id = \'' . $id_user . '\' ' . $and);
                                list($pseudo) = mysql_fetch_array($sql5);

                                if ($prenom != ""){
                                    $nom = $prenom;
                                }
                                else{
									$nom = $pseudo;
                                }

                                $txt .= '<br />' . _BIRTHDAY . ' : <b>' . $pseudo . '</b><br />' . _BIRTHDAYTEXT . '&nbsp;<b>' . $nom . '</b>&nbsp;' . _BIRTHDAYTEXTSUITE . '&nbsp;<b>' . $age . '</b>&nbsp;' . _YEARSOLD . '';
                            }
                        }
                    }
                }

                $blok['content'] .= '<td style"cursor:crosshair;" class="vtip" id="appoint" title="' . $event_date . '&nbsp;' . $months[$this_month] . '&nbsp;' . $year . '<br /> ' . $txt . '">'."\n"
				
                . '<a href="index.php?file=Calendar&amp;m=' . $month . '&amp;y=' . $year . '">'. $bd . $dayarray['mday'] . $bf . '</a></td>'."\n";
            }
            else{
                $blok['content'] .= '<td align="center"><span style="text-align: center;">' . $bd . $dayarray[mday] . $bf . '</span></td>'."\n";
            }

            $start += ADAY;
        }
    }

    $blok['content'] .= '</tr></table></div></div>'."\n";
	
	// listes événements 
    $today = date("d");  	
    $dbsEvents = '    SELECT titre, date_jour, date_mois, date_an, heure, auteur
                        FROM '.CALENDAR_TABLE.'
                        WHERE date_an = ' . $year . ' AND date_mois = ' . $month . ' AND '.$today.' < date_jour 
						ORDER by date_jour
                        ';
    $dbeEvents = mysql_query($dbsEvents);
    $nbEvents  = mysql_num_rows($dbeEvents); 
	
	if ($nbEvents != 0):
   
	
    $blok['content'] .= '<div id="eventscal"><div class="titreevents">Ev&eacute;nements du mois</div>'."\n"
	                 . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;width:100%;\" border=\"0\" cellspacing=\"3\" cellpadding=\"3\">\n";
	
    while ($dataEvents  = mysql_fetch_assoc($dbeEvents)):
	
	$blok['content'] .= '<tr style="background: ' . $bgcolor1 . ';\"><td style="border: 1px dashed ' . $bgcolor3 . ';\">le '.$dataEvents['date_jour'].' : <i>'.$dataEvents['titre'].'</i></td></tr>'."\n";
	
    endwhile;   
	
	$blok['content'] .= '</table></div>'."\n";
	                  //. 'le 11 &agrave; 16h: Salon de l\'auto'."\n";
    endif;					  
    return $blok;
}

function edit_block_event($bid){
    global $nuked, $language;

    $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
    $titre = printSecuTags($titre);

    if ($active == 1) $checked1 = 'selected="selected"';
    else if ($active == 2) $checked2 = 'selected="selected"';
    else $checked0 = 'selected="selected"';

    echo '<div class="content-box">'."\n" //<!-- Start Content Box -->
	   . '<div class="content-box-header"><h3>'._BLOCKADMIN.'</h3>'."\n"
	   . '<a href="help/'.$language.'/block.html" rel="modal">'."\n"
	   . '<img style="border: 0;" src="help/help.gif" alt="" title="'._HELP.'" /></a>'."\n"
	   . '</div>'."\n"
	   . '<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">'."\n"
	   . '<table style="margin:0 auto;text-align: left;" cellspacing="0" cellpadding="2" border="0">'."\n"
	   . '<tr><td><b>'._TITLE.'</b></td><td><b>'._BLOCK.'</b></td><td><b>'._POSITION.'</b></td><td><b>'._LEVEL.'</b></td></tr>'."\n"
	   . '<tr><td style="text-align:center;" ><input type="text" name="titre" size="40" value="'.$titre.'" /></td>'."\n"
	   . '<td style="text-align:center;"><select name="active">'."\n"
			, '<option value="1" ' , $checked1 , '>' , _LEFT , '</option>',"\n"
			, '<option value="2" ' , $checked2 , '>' , _RIGHT , '</option>',"\n"
			, '<option value="3" ' , $checked3 , '>' , _CENTERBLOCK , '</option>',"\n"
			, '<option value="4" ' , $checked4 , '>' , _FOOTERBLOCK , '</option>',"\n"
			, '<option value="0" ' , $checked0 , '>' , _OFF , '</option></select></td>',"\n"
	   . '<td style="text-align:center;" ><input type="text" name="position" size="2" value="'.$position.'" /></td>'."\n"
	   . '<td style="text-align:center;" ><select name="nivo"><option>'.$nivo.'</option>'."\n"
	   . '<option>0</option>'."\n"
	   . '<option>1</option>'."\n"
	   . '<option>2</option>'."\n"
	   . '<option>3</option>'."\n"
	   . '<option>4</option>'."\n"
	   . '<option>5</option>'."\n"
	   . '<option>6</option>'."\n"
	   . '<option>7</option>'."\n"
	   . '<option>8</option>'."\n"
	   . '<option>9</option></select></td></tr><tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4" style="text-align:center;" ><b>'._PAGESELECT.' :</b></td></tr><tr><td colspan="4">&nbsp;</td></tr>'."\n"
	   . '<tr><td colspan="4" align="center"><select name="pages[]" size="8" multiple="multiple">'."\n";

    select_mod2($pages);

    echo '</select></td></tr><tr><td colspan="4" style="text-align:center;" ><br />'."\n"
	   . '<input type="hidden" name="type" value="'.$type.'" />'."\n"
	   . '<input type="hidden" name="bid" value="'.$bid.'" />'."\n"
	   . '<input type="submit" name="send" value="'._MODIFBLOCK.'" />'."\n"
	   . '</td></tr></table>'
	   . '<div style="text-align: center;"><br />[ <a href="index.php?file=Admin&amp;page=block"><b>'._BACK.'</b></a> ]</div></form><br /></div></div>'."\n";

}
?>
