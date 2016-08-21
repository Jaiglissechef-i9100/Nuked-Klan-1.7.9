<?php 
	$requete = mysql_query("SELECT id,cat,titre FROM " . NEWS_TABLE . " ORDER BY id DESC LIMIT 0,15");
	$o = 0;
	 while($sql = mysql_fetch_array($requete))
	{
		$o++;
		$t = ceil($o/5);
		$news = htmlentities($sql['titre']);
		$news1  = stripslashes(substr($sql['titre'],0,35)); 
		if($news === $news1) { $point = ''; } else{ $point = '..';}
		$idnew   = $sql['id'];
		
		$sql3 = mysql_query("SELECT titre, image FROM " . NEWS_CAT_TABLE . " WHERE nid = '" . $sql['cat'] . "'");
        list($categorie, $image) = mysql_fetch_array($sql3);
		
	     if ($image != "")
            $game = "<a href=\"index.php?file=News&amp;op=categorie&amp;cat_id=" . $sql['cat'] . "\"><img style=\"float: right;border: 0;\" src=\"" . $image . "\" alt=\"\" title=\"" . $categorie . "\" /></a>";
         else
            $game = "";
	
	$lignes[$t] .= '<div class="head1"><div class="games">'.$game.'</div><div class="head1_pos"><a href="index.php?file=News&amp;op=suite&amp;news_id='.$idnew.'" class="link_news">'.$news1.$point.'</a></div></div>';
	}
 	foreach ($lignes as $db) {						
	echo '<div class="glidecontent3">',$db,'</div>'; 					
	}
?>

