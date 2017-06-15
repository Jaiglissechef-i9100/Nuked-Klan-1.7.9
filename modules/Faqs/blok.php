<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined('INDEX_CHECK')) die('<div style="text-align:center;">You cannot open this page directly</div>');

global $nuked, $language, $theme, $bgcolor3, $bgcolor2, $bgcolor1;
translate("modules/Faqs/lang/" . $language . ".lang.php");
include("modules/Faqs/config.php");


$sql2 = mysql_query("SELECT active FROM " . BLOCK_TABLE . " WHERE bid = '" . $bid . "'");
list($active) = mysql_fetch_array($sql2);
if ($active == 3 || $active == 4){
	
    if (is_file("themes/" . $theme . "/images/articles.gif")){
        $img = "<img src=\"themes/" . $theme . "/images/articles.gif\" alt=\"\" />";
    }
    else{
        $img = "<img src=\"modules/Sections/images/articles.gif\" alt=\"\" />";
    }

    echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"100%\">\n";
     //. "<tr><td style=\"width: 45%;\" valign=\"top\">" . $img . "&nbsp;<a href=\"index.php?file=Faqs\"><big><b>Derniers Q/R</b></big></a><br /><br />\n";

    $i = 0;
    $sql = mysql_query("SELECT id, questions, reponses, cat, date FROM " . $nuked['prefix'] . "_faqs ORDER BY rand() DESC LIMIT 0, 10");
    while (list($id, $questions, $reponses, $cat, $date) = mysql_fetch_array($sql)){
    	
    	$reponses = stripslashes($reponses);
        $reponses = html_entity_decode($reponses);  
        /*$questions = html_entity_decode($questions);*/
        //$date = nkDate($date);

             $newsdate = time() - 84400;
             $att = "";

             if ($date!="" && $date > $newsdate) $att = "&nbsp;<img alt=\"new\" src=\"/modules/Faqs/images/new.png\" style=\"vertical-align: middle;\" />";
       
 
        $sql4 = mysql_query("SELECT cid, titre, image FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $cat . "'");
        list($cid, $cat_name, $image) = mysql_fetch_array($sql4);
        $cat_name = printSecuTags($cat_name);

		if ( $image ) { $afficheimagecat = $image; } else { $afficheimagecat = 'modules/Faqs/images/no_screenshot.gif'; }
		
        if ($cat == 0){
            $category = "";
        }
        else if ($parentid > 0){
            $sql5 = mysql_query("SELECT titre FROM " . $nuked['prefix'] . "_faqs_cat WHERE cid = '" . $parentid . "'");
            list($parent_name) = mysql_fetch_array($sql5);
            $parent_name = printSecuTags($parent_name);

            $category = $parent_name . " - " . $cat_name;
        }
        else{
            $category = $cat_name;
        }

        //$i++;
		$imageok = '<img title="'.$cat_name.'" style="padding:2px;outline: none; border: 1px solid #E06E2B;border-top-left-radius: 45px; border-top-right-radius: 45px; border-bottom-right-radius: 45px; border-bottom-left-radius: 45px; padding: 2px; width: 20px; height: 20px; margin-right: 5px; background: '.$bgcolor3.';vertical-align:middle;" src="' . $afficheimagecat . '" alt="'.$cat_name.'" />';
        $reponses = preg_replace("`<br />`i", "", $reponses);
        echo "<div>" . $imageok . "&nbsp;<a href=\"index.php?file=Faqs&amp;op=categorie&cat=" . $cid . "#faq-" . $id . "\" style=\"text-decoration: underline\">" . $questions . "</a></b>". $att ."<br style=\"padding-left:22px;\"/>".couper_texte_propre($reponses,80)."</div>\n";

        //if ($category != "") echo $category . "<br />\n";
    }
    echo "</td>\n";
    /*
    echo "</td><td style=\"width: 10%;\">&nbsp;</td><td style=\"width: 45%;\" align=\"left\" valign=\"top\">" . $img . "&nbsp;<a href=\"index.php?file=Sections&amp;op=classe&amp;orderby=count\"><big><b>" . _TOP10ART . "</b></big></a><br /><br />\n";

    $l = 0;
    $sql3 = mysql_query("SELECT artid, title, counter, secid FROM " . SECTIONS_TABLE . " ORDER BY counter DESC LIMIT 0, 10");
    while (list($tartid, $ttitre, $tcount, $tcat) = mysql_fetch_array($sql3)){
        $sql4 = mysql_query("SELECT secname, parentid FROM " . SECTIONS_CAT_TABLE . " WHERE secid = '" . $tcat . "'");
        list($tcat_name, $tparentid) = mysql_fetch_array($sql4);
        $tcat_name = printSecuTags($tcat_name);

        if ($tcat == 0){
            $tcategory = "";
        }
        else if ($tparentid > 0){
            $sql5 = mysql_query("SELECT secname FROM " . SECTIONS_CAT_TABLE . " WHERE secid = '" . $tparentid . "'");
            list($tparent_name) = mysql_fetch_array($sql5);
            $tparent_name = printSecuTags($tparent_name);

            $tcategory = $tparent_name . " - " . $tcat_name;
        }
        else{
            $tcategory = $tcat_name;
        }

        $l++;
        echo "<b>" . $l . " . <a href=\"index.php?file=Sections&amp;op=article&amp;artid=" . $tartid . "\" style=\"text-decoration: underline\">" . $ttitre . "</a></b><br />\n";

        if ($tcategory != "") echo $tcategory . "<br />\n";
    }

    echo "</td></tr><tr><td style=\"width: 45%;\" align=\"right\"><a href=\"index.php?file=Sections&amp;op=classe&amp;orderby=news\"><small>+ " . _MORELAST . "</small></a></td>\n"
            . "<td style=\"width: 10%;\"></td><td style=\"width: 45%;\" align=\"right\"><a href=\"index.php?file=Sections&amp;op=classe&amp;orderby=count\"><small>+ " . _MORETOP . "</small></a></td></tr></table>\n";
*/
    echo "</tr></table>\n";
}
else{
	echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\">\n";
    $i = 0;
    $sql = mysql_query("SELECT id, questions, reponses, cat, date FROM " . $nuked['prefix'] . "_faqs ORDER BY date DESC LIMIT 0, 10");
    while (list($id, $questions, $reponses, $cat, $date) = mysql_fetch_array($sql)){
    	    
    	    /*
    		if (strlen($content) > 65){ 
	        $content = substr($content, 0, 65)."..."; }
	        */
	      /*		  
	    $reponses = stripslashes($reponses);
        $reponses = html_entity_decode($reponses);   
        /*$questions = printSecuTags($questions);*/
        $reponses = html_entity_decode($reponses);
        $questions = html_entity_decode($questions); 
        $questions = stripslashes($questions);  		
        $i++;
             $newsdate = time() - 432000;
             $att = "";

             if ($date!="" && $date > $newsdate) $att = "&nbsp;<img alt=\"new\" src=\"/modules/Faqs/images/new.png\" style=\"vertical-align: middle;\" />";
       
 
        echo "<div><b>" . $i . " . <a href=\"index.php?file=Faqs&op=categorie&cat=".$cat."#faq-".$id."\">" . $questions . "</a>" . $att . "</b><br />
		".couper_texte_propre($reponses,55)."</div>\n";
    }
}
echo '</table>';
?>