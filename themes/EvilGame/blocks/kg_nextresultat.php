<?php
echo'<table id="tableWar" width="100%" cellspacing="0" cellpadding="0">';
$last_mt = mysql_query("SELECT * FROM " . WARS_TABLE . " INNER JOIN " . GAMES_TABLE . " 
ON " . WARS_TABLE . ".game = " . GAMES_TABLE . ".id WHERE " . WARS_TABLE . ".etat = 0 ORDER BY " . WARS_TABLE . ".date_an DESC, " . WARS_TABLE . ".date_mois DESC, " . WARS_TABLE . ".date_jour DESC LIMIT 0, 03");
 while($sql5 = mysql_fetch_array($last_mt))
{

$nextID= $sql5['warid']; 
$nextVersus= stripslashes($sql5['adversaire']);
$score1 = stripslashes($sql5['score_team']); 
$score2 = stripslashes($sql5['score_adv']); 

$d2x = $sql5['date_jour'];
$m2x = $sql5['date_mois'];
$y2x = $sql5['date_an'];
$nextFlag = $sql5['pays_adv'];
$nextLeague = $sql5['type'];
if(mb_strlen($nextLeague)>20) {
$nextLeague=mb_substr($nextLeague, 0, 20);
$nextLeague.='..';
}
if(mb_strlen($nextVersus)>13) {
$nextVersus=mb_substr($nextVersus, 0, 13);
$nextVersus.='..';
}
	echo '
	<tr>
	  <td>
	<div class="matchStat"></div>
	<div class="matchVersus">vs. &nbsp;<img src="themes/EvilGame/images/flags/'.$nextFlag.'"  alt="flags" title="flags" /> &nbsp;<a href="index.php?file=Wars&amp;op=detail&amp;war_id='.$nextID.'" class="link_last">'.$nextVersus.'</a></div>
	<div class="matchType">'.$nextLeague.'</div>
	<div class="matchDate">'.$d2x.'.'.$m2x.'.'.$y2x.'</div>
	  
	</td>
	</tr> ';

} 
echo'</table>';
?>