<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
	die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}
?>
<?php
	// <link rel="stylesheet" href="modules/Guestbook/styles.css" type="text/css" media="screen" />

global $nuked, $language;
translate("modules/Guestbook/lang/" . $language . ".lang.php");

$day = time();

$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);

	// Configuration général des blocks

	$nb_msg = 2;
	$max= 150;
	if ($active == 3 || $active == 4)
	{
		// centre et bas
		global $theme, $cmp_comment;
		
		$nb_mess_guest = $nuked['mess_guest_page']; // chargement du nombre de message maximum par page.
		 
		$sql = mysql_query("SELECT id, name, email, url, date, host, comment FROM ". GUESTBOOK_TABLE ." ORDER BY RAND() LIMIT 1"); // chargement du message
		$count_sql = mysql_num_rows($sql); // compte le nombre de message
		
		list($id, $name, $email, $url, $date, $host, $comment) = mysql_fetch_array($sql);
		
			
			if($count_sql >= 1)
			{
				$date = strftime("Le %A %d %B %Y à %H:%M", $date);
				compact_comment($comment, $max); // appel de la fonction extraire texte afin de réduire ce dernier.
				stripslashes($cmp_comment); // supression des doubles slashes
			
				echo"<div class=\"block_guestbook_author\"><span>". $date ."</span>&nbsp;<strong>". $name ."</strong> ". _WROTE ." :</div>";
				echo"<div class=\"block_guestbook_comment\">". $cmp_comment ."<br/></div>";
				
				$sql = mysql_query("SELECT id, name, email, url, date, host, comment FROM ". GUESTBOOK_TABLE ."  ORDER BY id DESC");
				$page=1;$count=0;
				while(list($cid) = mysql_fetch_array($sql))
				{
					$count++;
					if($id==$cid){$p=$page;}
					if($count>=$nb_mess_guest){$count == 1;$page++;}
				}
				// vérification d'une image "readmore.png" présente dans le répertoire theme.
				$data['bouton'] = (is_file('themes/' . $theme . '/images/readmore.png')) ? '<img src="themes/' . $theme . '/images/readmore.png" alt="" title="' . _READMORE . '" />' : _READMORE;
				$data['texte'] = $TabNews['texte'].'<div style="text-align:right;"><a title="'._READMORE.'" href="index.php?file=Guestbook&p='. $p .'">' . $data['bouton'] . '</a></div>';
			}
			else
			{
				$data['texte'] = "<div style=\"text-align:center;\">". _NOSIGN ."<br/><br/><a href=\"index.php?file=Guestbook&op=post_book\">". _SIGNGUESTBOOK ."</a></div>";
			}
		
		echo"<div style=\"margin:4px 0px;padding:2px;\" class=\"block_guestbook_link\">". $data['texte']	."</div>";
	}
	else
	{	
		// Gauche et droite
		global $theme, $cmp_comment;
		
		$nb_mess_guest = $nuked['mess_guest_page']; // chargement du nombre de message maximum par page.
		 
		$sql = mysql_query("SELECT id, name, email, url, date, host, comment FROM ". GUESTBOOK_TABLE ." ORDER BY RAND() LIMIT 1"); // chargement du message
		$count_sql = mysql_num_rows($sql); // compte le nombre de message
		
		list($id, $name, $email, $url, $date, $host, $comment) = mysql_fetch_array($sql);
		
			
			if($count_sql >= 1)
			{
				$date = strftime("Le %A %d %B %Y à %H:%M", $date);
				compact_comment($comment, $max); // appel de la fonction extraire texte afin de réduire ce dernier.
				stripslashes($cmp_comment); // supression des doubles slashes
			
				echo"<div class=\"block_guestbook_author\"><span>". $date ."</span>&nbsp;<strong>". $name ."</strong> ". _WROTE ." :</div>";
				echo"<div class=\"block_guestbook_comment\">". $cmp_comment ."<br/></div>";
				
				$sql = mysql_query("SELECT id, name, email, url, date, host, comment FROM ". GUESTBOOK_TABLE ."  ORDER BY id DESC");
				$page=1;$count=0;
				while(list($cid) = mysql_fetch_array($sql))
				{
					$count++;
					if($id==$cid){$p=$page;}
					if($count>=$nb_mess_guest){$count == 1;$page++;}
				}
				// vérification d'une image "readmore.png" présente dans le répertoire theme.
				$data['bouton'] = (is_file('themes/' . $theme . '/images/readmore.png')) ? '<img src="themes/' . $theme . '/images/readmore.png" alt="" title="' . _READMORE . '" />' : _READMORE;
				$data['texte'] = $TabNews['texte'].'<div style="text-align:right;"><a title="'._READMORE.'" href="index.php?file=Guestbook&p='. $p .'">' . $data['bouton'] . '</a></div>';
			}
			else
			{
				$data['texte'] = "<div style=\"text-align:center;\">". _NOSIGN ."<br/><br/><a href=\"index.php?file=Guestbook&op=post_book\">". _SIGNGUESTBOOK ."</a></div>";
			}
		
		echo"<div style=\"margin:4px 0px;padding:2px;\" class=\"block_guestbook_link\">". $data['texte']	."</div>";
		
	
	}
	
	function compact_comment($comment, $max)
	{
		global $cmp_comment;
		
		if ( strlen($comment) > $max)
		{
			$espace = strpos($comment,' ',$max);		
			$cmp_comment = substr($comment,0,$espace).'...';
		}
		else{$cmp_comment = $comment;}
		
		return $cmp_comment;
	}

?>
