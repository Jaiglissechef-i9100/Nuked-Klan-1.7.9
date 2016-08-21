<?php
echo'<table id="tableWar" width="100%" cellspacing="0" cellpadding="0">';
$etat='1';			
$last_mx = mysql_query("SELECT * FROM " . WARS_TABLE . " INNER JOIN " . GAMES_TABLE . " 
ON " . WARS_TABLE . ".game = " . GAMES_TABLE . ".id WHERE " . WARS_TABLE . ".etat = 1 ORDER BY " . WARS_TABLE . ".date_an DESC, " . WARS_TABLE . ".date_mois DESC, " . WARS_TABLE . ".date_jour DESC LIMIT 0, 03");
 while($sql4 = mysql_fetch_array($last_mx))
{

	$idwars1= $sql4['warid']; 
	$versus1= stripslashes($sql4['adversaire']);
	$score1 = stripslashes($sql4['score_team']); 
	$score2 = stripslashes($sql4['score_adv']); 
	if($score1>$score2) {
	//WIN
	$light="<span style='color:#37b437;'>WIN</span>";
	}
	elseif($score1<$score2) {
	//LOOSE
	$light="<span style='color:#ff7200;'>LOSS</span>";
	}
	else {
	//DRAW
	$light="<span style='color:#0036ff;'>DRAW</span>";		
	}


		$d2_l = $sql4['date_jour'];
		$m2_l = $sql4['date_mois'];
		$y2_l = $sql4['date_an'];
		$pays_adv = $sql4['pays_adv'];
		$leagueInfo = $sql4['type'];
		if(mb_strlen($leagueInfo)>20) {
			$leagueInfo=mb_substr($leagueInfo, 0, 20);
			$leagueInfo.='..';
		}
		if(mb_strlen($versus1)>13) {
		$versus1=mb_substr($versus1, 0, 13);
		$versus1.='..';
		}
		echo '
				<tr>
				  <td>
						<div class="matchStat">'.$light.'</div>
						<div class="matchVersus">vs. &nbsp; <img src="themes/EvilGame/images/flags/'.$pays_adv.'"  alt="flags" title="flags" /> &nbsp;<a href="index.php?file=Wars&amp;op=detail&amp;war_id='.$idwars1.'" class="link_last">'.$versus1.'</a></div>
						<div class="matchType">'.$leagueInfo.'</div>
						<div class="matchDate">'.$d2_l.'.'.$m2_l.'.'.$y2_l.'</div>	
				  
					</td>
				</tr> ';

} 
		echo'</table>';
?>