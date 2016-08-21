<table width="100%" id="lastTopic" border="0" cellspacing="0" cellpadding="0">
<?php 
			   $requete = mysql_query("SELECT id,forum_id,titre,last_post FROM " . FORUM_THREADS_TABLE . " ORDER BY id DESC LIMIT 0,05");
			    while($sql = mysql_fetch_array($requete))
			  {
			  
			  $topic = stripslashes(htmlentities($sql['titre']));
			  $topic1  = stripslashes(substr($sql['titre'],0,30)); 
			  if($topic === $topic1) { $point = ''; } else{ $point = '..';}
			  $idtop  = $sql['id'];
			  $forum_id = $sql['forum_id'];		  
			  $day = date('d', $sql['last_post']);
			  $month = date('M', $sql['last_post']);
			  $sql4 = mysql_query("SELECT file FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $idtop . "'");
              $nb_rep = mysql_num_rows($sql4) - 1;
			  ?>
<tr>
<td class="date">
		<span class="month"><?php echo $month ?></span><br/>
		<span class="jour"><?php echo $day ?></span>
</td>
	<td class="message"><a href="index.php?file=Forum&amp;page=viewtopic&amp;forum_id=<?php echo $forum_id; ?>&amp;thread_id=<?php echo $idtop; ?>" class="link_news"><?php echo $topic1.$point; ?></a></td>
	<td class="comment"><img src="themes/EvilGame/images/comment.png" alt="" style="vertical-align:middle" /> <?php echo $nb_rep; ?></td>
</tr>
			  <?php }
			  ?>
				</table>
				
				