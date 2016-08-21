<?php 
$requete = mysql_query("SELECT id,titre,hit,description FROM " . DOWNLOAD_TABLE . " ORDER BY id DESC LIMIT 0,06");
$num_rows = mysql_num_rows($requete);	
if($num_rows > 0) {
while($sql = mysql_fetch_array($requete))
{
 
$demos  = htmlentities($sql['titre']);
$demos1  = stripslashes(substr($demos,0,49)); 
$idem   = $sql['id'];
$hit = $sql['hit'];
if($demos === $demos1) { $point = ''; } else{ $point = '...';}
$idnew  = $sql['id'];
$desc = $sql['description'];
$desc1  = stripslashes(substr($desc,0,145)); 
if($desc === $desc1) { $point = ''; } else{ $point = '..';}
if($lang1 === '1') { $viewed = "Voir"; $dll = "Téléchargés"; } else { $viewed = "View"; $dll = "Downloads"; }
echo '
<div class="contentdiv">
	<div class="bTitle">'.$demos1.$point.' </div>
	<div class="bContent">
		<div class="bCenter">'.$desc1.$point.'
		</div>
		<div class="bContentView2" style="float:right;">
		<p style="float:left;">'.$dll.' <img src="themes/EvilGame/images/icon_dl.png" alt="download" /> (<span style="font-size:10px;">'.$hit.'</span>)</p> <div class="viewMore"> <a href="index.php?file=Download&amp;op=description&amp;dl_id='.$idnew.'">'.$viewed.'</a></div>
		</div>
	</div>
</div>';
}
} 
	else echo '<div class="contentdiv"></div>';
 ?>


