<?php 
  $sql_cat = mysql_query("SELECT artid,title,autor,counter FROM " . SECTIONS_TABLE . " ORDER BY  artid desc LIMIT 0,04") or die (mysql_error());
  echo'<table width="100%"  id="tableArticle" cellspacing="0" cellpadding="0">';
	while($last_article = mysql_fetch_array($sql_cat))
		{
			$art_title = stripslashes(htmlentities($last_article['title']));
			$art_title2  = stripslashes(substr($last_article['title'],0,49)); 
			if($art_title == $art_title2) { $point1 = ''; } else{ $point1 = '..';}			  
			$art_id   = $last_article['artid'];
			$art_by   = stripslashes($last_article['autor']);

			
			echo '<tr>
						<td>
							<div class="bg_articles">
								<div class="articleName">'.$art_by.'.</div>
								<div class="articleTitle"> <a class="articleLink" href="index.php?file=Sections&amp;op=article&amp;artid='.$art_id.'">'.$art_title2.$point1.'</a></div>
								<div class="articleCom">('.$last_article['counter'].')</div>
							</div>
						</td>
					</tr>';
		}
	echo'</table>';
?>
