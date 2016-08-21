<?php  
   
	$nb_squads = 0;
	echo '<div id="slider4" class="squadsBox">';	
    $sql_team = mysql_query("SELECT cid,titre FROM " . TEAM_TABLE);
     while($sql2 = mysql_fetch_array($sql_team)) 
	 {
	 echo '<div class="contentdiv">';	
    $sql = mysql_query("SELECT pseudo, mail, country,avatar FROM " . USER_TABLE . " WHERE team= " . htmlentities($sql2['cid']) . " OR team2 = " . htmlentities($sql2['cid']) . " OR team3= " . htmlentities($sql2['cid']) . " ORDER BY ordre, pseudo limit 0,04");
		
    while (list($pseudo, $mail, $country, $avatar) = mysql_fetch_array($sql))
    {
	if($avatar == '') { $avatar = "themes/EvilGame/images/nopic.gif"; }
				echo '			
			<table style="float:left;" border="0" width="80" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="index.php?file=Team&amp;op=detail&amp;autor=' . urlencode($pseudo) . '"><img class="picture"  src="'.$avatar.'" width="68" height="71" border="0" alt="Userpic" /></a></td>
				</tr>
				<tr>
					<td class="name"><a href="index.php?file=Team&amp;op=detail&amp;autor=' . urlencode($pseudo) . ' "><b>' . $pseudo . '</b></a></td>
				</tr>
			</table>';
    }
	echo '</div>';
	$nb_squads++;
	if (!isset($teamName[$nb_squads])) $teamName[$nb_squads] = NULL;	
	$squadname = htmlentities($sql2['titre']);
	$teamName[$nb_squads] = '<span><a class="toc" href="#'.$nb_squads.'">'.$squadname.'</a></span> ';
	}
  	echo '</div>';
	
	?>
<div class="foot_squads"><div id="paginate-slider4" class="paginaSquads"><?php 
				foreach ($teamName as $dba) {						
	echo $dba; 					
	
	} ?></div></div>