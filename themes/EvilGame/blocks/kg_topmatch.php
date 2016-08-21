<?php
if($id_topmatch === '')
{
}
else
{

$last_m = mysql_query("SELECT * FROM " . WARS_TABLE . " INNER JOIN " . GAMES_TABLE . " ON " . WARS_TABLE . ".game = " . GAMES_TABLE . ".id WHERE " . WARS_TABLE . ".warid = '".$id_topmatch."' ORDER BY " . WARS_TABLE . ".date_an DESC, " . WARS_TABLE . ".date_mois DESC, " . WARS_TABLE . ".date_jour DESC LIMIT 0, 01");
while($retour = mysql_fetch_array($last_m))
{
	//VERIF LOGO
	if(!$top_logo)
	$top_src = '';
	else
	$top_src = $top_logo;
	
		//VERIF LOGO
	if(!$top_logo2)
	$top_logo2 = '';
	else
	$top_logo2 = $top_logo2;	


		if($lang1 === '1') { $completed = 'Termin&eacute;';  $mapsTxt = 'Cartes'; $winTxt = 'Victoire'; $looseTxt = 'D&eacute;faite'; } 
		else { $completed = 'Completed';  $mapsTxt = 'Maps';  $winTxt = 'Win'; $looseTxt = 'Loose';}
		
		$etat = $retour['etat'];
		$idwars1= $retour['warid']; 
		$versus1= stripslashes($retour['adversaire']);
	
		$score1 = stripslashes($retour['tscore_team']); 
		if($score1 == '') $score1 = stripslashes($retour['score_team']); 
		$score2 = stripslashes($retour['tscore_adv']); 
		if($score2 == '') $score2 = stripslashes($retour['score_adv']); 
		$d2_l = $retour['date_jour'];
		$m2_l = $retour['date_mois'];
		$y2_l = $retour['date_an'];
		$name = $retour['name'];
		$pays_adv = $retour['pays_adv'];
		$type_w = $retour['type'];
		$maps = explode('|', $retour['map']);
	 
		$report = $retour['report'];

		$top_date2 = $top_matched['date'];															
		
	  	if(mb_strlen($report)>65) {
			$report=mb_substr($report, 0, 65);
			$report.='..';
		}
		if(mb_strlen($type_w)>20) {
			$type_w=mb_substr($type_w, 0, 20);
			$type_w.='..';
		}
	  
		if($etat === '1') 
		{
		$fullstat   = '<span style="color:#ff8a00;">'.$completed.'</span>';												
		if($score1>$score2) {
		//WIN
		$myscri = '<span class="win_color">'.$score1.'</span>';
		$adscri = '<span class="loose_color">'.$score2.'</span>';
		$stat   = '<span class="win_color">'.$winTxt.' </span>';
		$stat2  = '<span class="loose_color">'.$looseTxt.'</span>';
		}
		elseif($score1<$score2) {
		//LOOSE
		$myscri = '<span class="loose_color">'.$score1.'</span>';
		$adscri = '<span class="win_color">'.$score2.'</span>';
		$stat   = '<span class="loose_color">'.$looseTxt.'</span>';
		$stat2  = '<span class="win_color">'.$winTxt.'</span>';
		}
		else {
		//DRAW
		$myscri = '<span class="draw_color">'.$score1.'</span>';
		$adscri = '<span class="draw_color">'.$score2.'</span>';
		$stat   = '<span class="draw_color">Draw</span>';
		$stat2   = '<span class="draw_color">Draw</span>';
		}
		}
		else
		{
		$fullstat  = '<span style="color:#ff8a00;">Incoming</span>';
		$adscri = '';
		$parametreAffichage = '2';
		}										
		
?>
<div class="bg_topmatch">
<table id="top_topmatch"  cellspacing="0" cellpadding="0" border="0">
<tr>
	<td>
		<div class="tm_title">Date : </div>
		<div class="tm_dg"><?php echo $d2_l.'.'.$m2_l.'.'.$y2_l; ?></div>
		<div class="tm_title">Statut :  </div>
		<div class="tm_stat"><?php echo $fullstat; ?>  </div>
		<div class="tm_title">Event :  </div>
		<div class="tm_event"><?php echo $type_w; ?> </div>
	</td>
</tr>
<tr>
	<td class="tm_pic">
	<div class="tm_pic1"><div style='background: url(<?php echo $top_logo; ?>) no-repeat; width:190px;height:90px;float:left;'></div></div>
	<div class="tm_pic2"><div style='background: url(<?php echo $top_logo2; ?>) no-repeat; width:190px;height:90px;float:left;'></div></div>
	</td>
</tr>
<?php  if($parametreAffichage != '2') { ?>
<tr>
	<td>
		<div class="tm_bg">
			<div class="tm_left"><?php echo $stat; ?> </div>
			<div class="tm_center"><?php echo $top_myname; ?></div>
			<div class="tm_right"><?php echo  $myscri; ?></div>
			
		</div>
	</td>
</tr>
<tr>
	<td>
		<div class="tm_bg" style="margin-top:5px;">
			<div class="tm_left"><?php echo $stat2; ?> </div>
			<div class="tm_center"><?php echo $versus1; ?></div>
			<div class="tm_right"><?php echo  $adscri; ?></div>
			
		</div>
	</td>
</tr>
<?php } if($maps[0] != '') { ?>
<tr>
	<td>
		<div style="margin-top:9px;">
			<div class="tm_info"><?php echo $mapsTxt; ?></div>
			<div class="tm_infoMap"><?php   for ($nbr=1; $nbr <= count($maps); $nbr++) { echo $maps[$nbr-1].', '; }?></div>
		</div>
	</td>
</tr>
<?php } ?>
<tr>
	<td>
		<div style="margin-top:9px;">
			<div class="tm_info">Info</div>
			<div class="tm_infoMap"><?php echo $report; ?></div>
		</div>
	</td>
</tr>
</table>

		</div>
   		<div class="tm_seeMore"><a href="index.php?file=Wars&amp;op=detail&amp;war_id=<?php echo $idwars1; ?>" ><img src="themes/EvilGame/images/en/details.png" alt="detail" /></a></div>
	   
<?php
}
}?>