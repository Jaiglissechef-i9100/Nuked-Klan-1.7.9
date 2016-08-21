<?php
    $sql = mysql_query("SELECT sid, titre, url, url2,description FROM " . GALLERY_TABLE . " ORDER BY sid DESC LIMIT 0, 6");
    $num_rows = mysql_num_rows($sql);
	
	if($num_rows > 0) {
	while(list($sid, $titre, $url, $url2,$description) = mysql_fetch_array($sql))
    {
    $titre = htmlentities($titre);

    if ($url2 != "")
    {
        $img = $url2;
    }
    else
    {
        $img = $url;
    }

    if (!preg_match("`%20`i", $img)) list($w, $h, $t, $a) = @getimagesize($img);
    if ($w != "" && $w <= $img_screen1) $width = "width=\"" . $w . "\"";
    else $width = "width=\"" . $img_screen1 . "\"";
    $image = "<img src=\"" . $img . "\"  width='68' height='71' alt=\"" . $titre . "\" title=\"" .  _CLICTOSCREEN . "\" />";
    $description1  = stripslashes(substr($description,0,100));
	 if($description === $description1) { $point = ''; } else{ $point = '..';}
	 if($lang1 === '1') $viewed = "Voir"; else $viewed = "View";
	if ( $img != "")
	{
        echo '
	<div class="contentdiv">
		<div class="bTitle">'.$titre.'</div>
		<div class="bContent">
			<div class="bContentLeft"><a href="index.php?file=Gallery&amp;op=description&amp;sid=' . $sid . '">'.$image.'</a></div>
			<div class="bContentRight">
				'.$description1.$point.'
			</div>
			<div class="bContentView">
		<div class="viewMore"><a href="index.php?file=Gallery&amp;op=description&amp;sid=' . $sid . '">'.$viewed.'</a></div>
			</div>
		</div>
	</div>';
	}
    }
	} 
	else echo '<div class="contentdiv"></div>';
	

?>
				