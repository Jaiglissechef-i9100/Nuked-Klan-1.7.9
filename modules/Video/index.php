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

global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3, $theme, $user;
translate('modules/Video/lang/' . $language . '.lang.php');
/* COnstante table */
	define('VIDEO_TABLE', $nuked['prefix'] . '_video');
	define('VIDEO_CAT_TABLE', $nuked['prefix'] . '_video_cat');

$visiteur = ($user) ? $user[1] : 0;
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

compteur("Video");

//correction par Zdav
function index()
    {
    echo '<br /><br /><div style="text-align: center">' . _SELECTCAT . '</div>';
    }
//Fin correction par Zdav

function categorie($idcat)
    {

        global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked, $idcat;
		$nb_video = $nuked['max_video'];
		$idcat = $_GET["idcat"];
		if ($_REQUEST['letter'] == "Autres"){
            $and = "AND titre NOT REGEXP '^[a-zA-Z].'";
        } 
        else if ($_REQUEST['letter'] != "" && preg_match("`^[A-Z]+$`", $_REQUEST['letter'])){
            $and = "AND titre LIKE '" . $_REQUEST['letter'] . "%'";
        } 
        else{
            $and = "";
        }
		$sql = mysql_query("SELECT id, cat_id, type, titre, description, image, status, lien, vue FROM " . VIDEO_TABLE . " WHERE cat_id = '".$idcat."' AND status = '1' GROUP BY id")or die(mysql_error()."\n".$sql);
		$count = mysql_num_rows($sql);
		if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_video - $nb_video;
		
		echo "<div style=\"background: " . $bgcolor2 . ";\">\n"
			. "<div style=\"background: " . $bgcolor3 . ";\">\n";
		$sql = mysql_query("SELECT id, cat_id, type, titre, description, image, status, lien, vue FROM " . VIDEO_TABLE . " WHERE cat_id = '".$idcat."' AND status = '1' ORDER BY id DESC LIMIT " . $start . ", " . $nb_video)or die(mysql_error()."\n".$sql);
		while (list($id, $cat_id, $type, $titre, $description, $image, $status, $lien, $vue) = mysql_fetch_array($sql)){
        
        $description = html_entity_decode($description);
        
        if ($j == 0){
                $bg = $bgcolor2;
                $j++;
            } 
        else{
                $bg = $bgcolor1;
                $j = 0;
            }
        $commentaires = mysql_query("SELECT * FROM " . COMMENT_TABLE . " WHERE im_id='".$id."'")or die(mysql_error()."\n".$commentaires);
        $nb_com = mysql_num_rows($commentaires);
		echo "<div style=\"background: " . $bg . ";\">\n"
		    . "<div style=\"width: 100%;text-align:center;color:silver; \"><br></br><h1>" .$titre. "</h1></div>\n"
			. "<div style=\"width: 100%;text-align:center;color:green;font-size:medium;\"><br></br>Vue ".$vue." fois</div><br></br>\n"
			. "<div style=\"width: 100%;text-align:center;\"><img style=\"max-width: 100px; border: 2px solid #e7e7e7; margin-top:10px;\" title=\"\" alt=\"\" src=\"".$image."\" ></img><br></br><a href=\"index.php?file=Video&amp;op=view&amp;id=".$id."\"><img style=\"max-width: 100px; margin-top:10px;\" title=\"Voir la vidéo\" alt=\"lire la video\" src=\"\modules\Video\bouton.png\" ></img></a></div>\n"
			. "<div style=\"width: 100%;text-align:center;color:yellow; \"><br></br>".$nb_com." Commentaires </div><br></br>\n"
			. "<div style=\"width: 100%;text-align:center \"><a href=\"index.php?file=Video&amp;op=view&amp;id=".$id."\"></a><br></br>" .strip_tags(substr($description, 0, 200)). "<br></br></div>\n"
			. "<div style=\"width: 100%;\"><hr></hr></div>\n"
			. "</div><br></br>\n";
			}
		echo "</div></div><br></br>";
		if ($count > $nb_video){
		$url_video ="index.php?file=Video&amp;op=categorie&amp;idcat=".$idcat."" . $_REQUEST['letter'];
            number($count, $nb_video, $url_video);
        }
		

    }
function view($id)
    {
        global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked, $id, $user, $visiteur;
		$id = $_GET["id"];
		$sql = mysql_query("SELECT id, cat_id, type, titre, description, image, status, lien, vue FROM " . VIDEO_TABLE . " WHERE id = '".$id."' AND status = '1'")or die(mysql_error()."\n".$sql);
		$count = mysql_num_rows($sql);
		while (list($id, $cat_id, $type, $titre, $description, $image, $status, $lien, $vue) = mysql_fetch_array($sql)){
		$titre = printSecuTags($titre);
		$description = html_entity_decode($description);
		$tubeinfo = getVideoInfo($lien);
		$upd = mysql_query("UPDATE " . VIDEO_TABLE . " SET vue=vue+1 WHERE id = '".$id."'");
		echo"" .$tubeinfo["code"]. "";
		echo "<table style=\"margin: 5px;\" width=\"98%\">\n"
            . "<tr style=\"background:". $bgcolor3 ."\">\n";
		
		echo "<td><a href=\"index.php?file=Video&amp;op=view&amp;id=".$id."\"><span style=\"color:yellow\">" .$titre. "</span></a></td>\n"
		    . "<td>" .strip_tags(substr($description, 0, 2000)). "</td></tr>\n";
		echo "</table>";
		if ($nuked['cat_idem'] == "1"){
		echo "<div style=\"text-align:center\"><h3>Dans la même catégorie</h3></div>";
		$sql = mysql_query("SELECT id, titre, image FROM " . VIDEO_TABLE . " WHERE cat_id = '".$cat_id."' AND id != '".$id."' ORDER BY RAND() LIMIT 5")or die(mysql_error()."\n".$sql);
		$count = mysql_num_rows($sql);
		while (list($id, $titre, $image) = mysql_fetch_array($sql)){
		$image = printSecuTags($image);
		
		echo "<a href=\"index.php?file=Video&amp;op=view&amp;id=".$id."\" title=\"".$titre."\"><img style=\"margin-left:15px; border: 3px solid #9C9C9C;\" src=\"".$image."\" width=\"100\" height=\"70\" alt=\"\"></img></a>\n";
		}}
		echo "<br></br><br></br>";
		$sql = mysql_query("SELECT active FROM ".$nuked['prefix']."_comment_mod WHERE module = 'Video'")or die(mysql_error()."\n".$sql);
		list($active) = mysql_fetch_array($sql);
		if ($active == 1 && $visiteur >= nivo_mod('Comment') && nivo_mod('Comment') > -1) {
            include ("modules/Comment/index.php");
            com_index('Video', $_GET["id"]);
        }}
    }

function getVideoInfo($lien)
	{
        global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked, $idcat;
		$type = "";
		$id = -1;
		$titre = ""._NOTITRE."";
		$description = ""._NODESC."";
		$img = ""._NOIMG."";
		//Détermination du "type" de vidéo : 
		if(eregi("youtube",$lien))			$type="youtube";
		else if(eregi("dailymotion",$lien))	$type="dailymotion";
		else if(eregi("google",$lien))		$type="google";
		else if(eregi("vimeo",$lien))		$type="vimeo";
		else return false;

		//Détermination de l'"ID" de la vidéo :
		if($type=="youtube")
		{
		$debut_id = explode("v=",$lien,2);
		$id_et_fin_url = explode("&",$debut_id[1],2);
		$id = $id_et_fin_url[0];
		}
		else if($type=="dailymotion"){
		$debut_id = explode("/video/",$lien,2);
		$id_et_fin_url = explode("_",$debut_id[1],2);
		$id = $id_et_fin_url[0];
		}
		else if($type=="google"){
		$debut_id =  explode("docid=",$lien,2);
		$id_et_fin_url = explode("&",$debut_id[1],2);
		$id = $id_et_fin_url[0];
		}
		else if($type=="vimeo"){
		$l_id= eregi("([0-9]+)$",$lien,$lid);
		$id = $lid[0];
		}
	
		//Analyse et stockage des informations de la vidéo
		if($type=="youtube"){
		$xml = @file_get_contents("https://gdata.youtube.com/feeds/api/videos/".$id);
		//titre
		preg_match('#<title(.*?)>(.*)<\/title>#is',$xml,$resultTitre);
		$titre = $resultTitre[count($resultTitre)-1];
		//description
		preg_match('#<content(.*?)>(.*)<\/content>#is',$xml,$resultDescription);
		$description = $resultDescription[count($resultDescription)-1];
		//Image
		$img = "https://img.youtube.com/vi/".$id."/1.jpg/";
		//Code HTML		
		$code = '<object type="application/x-shockwave-flash" width="100%" height="350" data="https://www.youtube.com/v/'.$id.'&amp;hl=fr">
        <param name="movie" value="https://www.youtube.com/v/'.$id.'&amp;hl=fr" />
        <param name="wmode" value="transparent" /></object>';		
		}
		else if ($type=="dailymotion"){
		$tags = json_decode(file_get_contents("https://www.dailymotion.com/services/oembed?format=json&url=https://www.dailymotion.com/embed/video/".$id.""), true);
		//titre
		$titre = htmlspecialchars(trim(str_replace("Dailymotion -","",$tags["title"])));
		$tags2 = get_meta_tags("https://www.dailymotion.com/video/".$id);
		//description
		$description = ($tags2['description']);
		//image 
		$img = "https://www.dailymotion.com/thumbnail/160x120/video/".$id;
		// code HTML		
		$code = '<object type="application/x-shockwave-flash" width="100%" height="350" data="https://www.dailymotion.com/swf/'.$id.'&amp;v3=1&amp;related=1">
        <param name="movie" value="https://www.dailymotion.com/swf/'.$id.'&amp;v3=1&amp;related=1" />
        <param name="wmode" value="transparent" /></object>';		
		}
		else if ($type=="vimeo"){
		$xml_string = @file_get_contents("https://vimeo.com/api/v2/video/".$id.".xml");
		//titre
		$xml_title_debut = explode("<tags>",$xml_string,2);
		$xml_title_fin = explode("</tags>",$xml_title_debut[1],2);
		$titre = $xml_title_fin[0];
		//description
		$xml_description_debut = explode("<description>",$xml_string,2);
		$xml_description_fin = explode("</description>",$xml_description_debut[1],2);
		$description = $xml_description_fin[0];
		//image
		$xml_image_debut = explode("<thumbnail_small>",$xml_string,2);
		$xml_image_fin = explode("</thumbnail_small>",$xml_image_debut[1],2);
		$img = $xml_image_fin[0];
		//code HTML
		$xml_code = @file_get_contents("https://vimeo.com/api/oembed.xml?url=https//vimeo.com/".$id);
		$xml_code_debut = explode("<html>",$xml_code,2);
		$xml_code_fin = explode("</html>",$xml_code_debut[1],2);		
		$code = '<object type="application/x-shockwave-flash" width="100%" height="350" data="https://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;color=00adef&amp;fullscreen=1">
        <param name="movie" value="https://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com&amp;color=00adef&amp;fullscreen=1" />
        <param name="wmode" value="transparent" /></object>';		
		}
	
		return array("id"=>$id,"type"=>$type,"titre"=>$titre,"description"=>$description,"img"=>$img,"code"=>$code, "lien"=>$lien);
	}
    switch($_REQUEST['op'])
	{ 
		case"categorie":
	    opentable();		
			categorie($_REQUEST['idcat']);
      closetable();			
			break;
			
		case"view":
      opentable();		
			view($_REQUEST['id']);
      closetable();			
			break;

		default:
	    opentable();		
			index();
      closetable();			
			break;
    }

} 
else if ($level_access == -1){
    opentable();
    echo '<br /><br /><div style="text-align: center">' . _MODULEOFF . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a><br /><br /></div>';
    closetable();
} 
else if ($level_access == 1 && $visiteur == 0){
    opentable();
    echo '<div style="text-align: center; margin: 10px 0">' . _USERENTRANCE . '<br /><br /><b><a href="index.php?file=User&amp;op=login_screen">' . _LOGINUSER . '</a> | <a href="index.php?file=User&amp;op=reg_screen">' . _REGISTERUSER . '</a></b></div>';
    closetable();
} 
else{
    opentable();
    echo '<br /><br /><div style="text-align: center">' . _NOENTRANCE . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a><br /><br /></div>';
    closetable();
} 
?>