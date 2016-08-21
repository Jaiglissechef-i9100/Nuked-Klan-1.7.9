<?php 
$requete = mysql_query("SELECT sexe,date,avatar,pseudo,country FROM " . $nuked['prefix'] . "_users LEFT JOIN " . $nuked['prefix'] . "_users_detail ON " . $nuked['prefix'] . "_users.id = " . $nuked['prefix'] . "_users_detail.user_id order by " . $nuked['prefix'] . "_users.date DESC LIMIT 0,06");

while($sql = mysql_fetch_array($requete))
{
$sex = $sql['sexe'];
if($sex === 'male') {
	$spic = '<img src="themes/EvilGame/images/sex/m.gif" alt="male" />';
	$gender = "Homme";
}
elseif ($sex === 'female') {
	$spic = '<img src="themes/EvilGame/images/sex/f.gif" alt="femal" />';
	$gender = "Femme";
 }
else {
	$spic = '<img src="themes/EvilGame/images/sex/m.gif" alt="male" />';
	$gender = "Inconnue";
}

if($lang1 === '1') $viewed = "Voir"; else $viewed = "View";

$time_members = date("d.m.y", $sql['date']);
if($sql['avatar'] == '') { $sql['avatar'] = "themes/EvilGame/images/nopic.gif"; }
echo '
	<div class="contentdiv">
		<div class="bTitle">'.stripslashes(htmlentities($sql['pseudo'])).'</div>
		<div class="bContent">
			<div class="bContentLeft"><a href="index.php?file=Team&amp;op=detail&amp;autor=' . urlencode($sql['pseudo']) . '"><img class="picture"  src="'.$sql['avatar'].'" width="68" height="71" border="0" alt="Userpic" /></a></div>
			<div class="bContentRight">
				Sex : '.$spic.' '.$gender.'<br/>
				Pays : <img src="themes/EvilGame/images/flags/'.$sql['country'].'" alt="flags"/> '.str_replace ( ".gif" , " " ,$sql['country']).'<br/>
				Inscrit le : '.$time_members.'<br/>				
			</div>
			<div class="bContentView">
		<div class="viewMore"><a href="index.php?file=Team&amp;op=detail&amp;autor=' . urlencode($sql['pseudo']) . '">'.$viewed .'</a></div>
			</div>
		</div>
	</div>';
}
?>




