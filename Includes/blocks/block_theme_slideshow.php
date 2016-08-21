<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

function affich_block_theme_slideshow($blok){
    global $nuked, $language;
	
	translate("modules/Admin/lang/" . $language . ".lang.php");
	
	$sql = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE titre='SlideShow' ");
    list($active) = mysql_fetch_array($sql);
	
	if($active == "1"){
		echo'	<link rel="stylesheet" href="media/css/slide_left.css">';
	}else{	
		echo'	<link rel="stylesheet" href="media/css/slide_right.css">';
	}

echo'	<script src="media/js/jquery.js"></script>';
?>		<script>

			$(function(){
			$.getScript("media/js/slides.jquery.js", function(data, textStatus, jqxhr) {
				$('#slides').slides({
						preload: true,
						preloadImage: '../../images/loading.gif',
						play: 5000,
						pause: 2500,
						hoverPause: true,
						animationStart: function(current){
							$('.caption').animate({
								bottom:-35
							},100);
							if (window.console && console.log) {
								// example return of current slide number
								console.log('animationStart on slide: ', current);
							};
						},
						animationComplete: function(current){
							$('.caption').animate({
								bottom:0
							},200);
							if (window.console && console.log) {
								// example return of current slide number
								console.log('animationComplete on slide: ', current);
							};
						},
						slidesLoaded: function() {
							$('.caption').animate({
								bottom:0
							},200);
						}
					});
				});
			});
		</script>
<?php	
	
	echo '<script type="text/javascript"><!--'."\n"
		. 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
		. '--></script>'."\n"
		. '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
		. '<script type="text/javascript">'."\n"
		. 'Shadowbox.init();'."\n"
		. '</script>'."\n";
	
	$img_screen = "220";
	
	$blok['content'] .= '	<div id="container">';
	$blok['content'] .= '	<div id="slides">';
	$blok['content'] .= '	<div class="slides_container">';

    $sql = mysql_query("SELECT id, titre, url, img FROM " . $nuked['prefix'] . "_themes_slide ORDER BY id DESC LIMIT 0, 5");
    while (list($id, $titre, $url, $img) = mysql_fetch_array($sql))
	{ 

		if ($img != "")
        {
            $img = $img;
        }
        else
        {
            $img = "";
        }

        if (!preg_match("`%20`i", $img)) list($w, $h, $t, $a) = @getimagesize($img);
        if ($w != "" && $w <= $img_screen) $width = "width=\"" . $w . "\"";
        else $width = "width=\"" . $img_screen . "\"";
        $image = "<img src=\"" . $img . "\" " . $width . " alt=\"' . _CLICTOSCREEN . '&nbsp;" . $titre . "\" title=\"" .  _CLICTOSCREEN . "&nbsp;" . $titre . "\" />";
		
		
        $blok['content'] .= '<div id="img" class="slide" style="text-align: center;"><a href="' . $img . '" rel="shadowbox" title="' . $titre . '">' . $image . '</a><a href="' . $url . '" title="' . _CLICTOVIEW . '&nbsp;' . $titre . '" ><div class="caption" style="bottom:0">' . $titre . '</div></a></div>';
	} 
	
	$blok['content'] .= '</div>';
	$blok['content'] .= '<a href="#" class="next"><img src="images/next.gif" width="15" height="15" alt="Arrow Next"></a>';
	$blok['content'] .= '<a href="#" class="prev"><img src="images/prev.gif" width="15" height="15" alt="Arrow Prev"></a>';
	$blok['content'] .= '</div>';
	$blok['content'] .= '</div>';
	
    return $blok;
} 

function edit_block_theme_slideshow($bid){
    global $nuked, $language;

    $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
    
    $titre = printSecuTags($titre);

    if ($active == 1) $checked1 = "selected=\"selected\"";
    else if ($active == 2) $checked2 = "selected=\"selected\"";
    else $checked0 = "selected=\"selected\"";

    echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
			, '<div class="content-box-header"><h3>' , _BLOCKADMIN , '</h3>',"\n"
			, '<a href="help/' , $language , '/block.html" rel="modal">',"\n"
			, '<img style="border: 0;" src="help/help.gif" alt="" title="' , _HELP , '" /></a>',"\n"
			, '</div>',"\n"
			, '<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">',"\n"
			, '<table style="margin-left: auto;margin-right: auto;text-align: left;" cellspacing="0" cellpadding="2" border="0">',"\n"
			, '<tr><td><b>' , _TITLE , '</b></td><td><b>' , _BLOCK , '</b></td><td><b>' , _POSITION , '</b></td><td><b>' , _LEVEL , '</b></td></tr>',"\n"
			, '<tr><td align="center"><input type="text" name="titre" size="40" value="' , $titre , '" /></td>',"\n"
			, '<td align="center"><select name="active">',"\n"
			, '<option value="1" ' , $checked1 , '>' , _LEFT , '</option>',"\n"
			, '<option value="2" ' , $checked2 , '>' , _RIGHT , '</option>',"\n"
			, '<option value="0" ' , $checked0 , '>' , _OFF , '</option></select></td>',"\n"
			, '<td align="center"><input type="text" name="position" size="2" value="' , $position , '" /></td>',"\n"
			, '<td align="center"><select name="nivo"><option>' , $nivo , '</option>',"\n"
			, '<option>0</option>',"\n"
			, '<option>1</option>',"\n"
			, '<option>2</option>',"\n"
			, '<option>3</option>',"\n"
			, '<option>4</option>',"\n"
			, '<option>5</option>',"\n"
			, '<option>6</option>',"\n"
			, '<option>7</option>',"\n"
			, '<option>8</option>',"\n"
			, '<option>9</option></select></td></tr>',"\n"
            , '<tr><td colspan="4" align="center"><br /><input type="button" value="' , _EDITSLIDE , '" onclick="javascript:window.location=\'index.php?file=Admin&amp;page=themes_slide&amp;bid=' , $bid , '\'" /></td></tr>',"\n"
			. '<tr><td colspan="4" style="text-align:left;"><b>' . _PAGESELECT . ' :</b></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
			. '<tr><td colspan="4" style="text-align:left;"><select name="pages[]" size="8" multiple="multiple">',"\n";

    select_mod2($pages);

    echo '</select></td></tr><tr><td colspan="4" align="center"><br />',"\n"
		, '<input type="hidden" name="type" value="' , $type , '" />',"\n"
		, '<input type="hidden" name="bid" value="' , $bid , '" />',"\n"
		, '<input type="submit" name="send" value="' , _MODIFBLOCK , '" />',"\n"
		, '</td></tr></table>',"\n"
		, '<div style="text-align: center;"><br />[ <a href="index.php?file=Admin&amp;page=block"><b>' , _BACK , '</b></a> ]</div></form><br /></div></div>',"\n";

}


?>