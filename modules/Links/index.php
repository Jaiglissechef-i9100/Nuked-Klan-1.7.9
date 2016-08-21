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

global $nuked, $language, $user, $bgcolor2, $bgcolor1, $bgcolor3;
translate('modules/Links/lang/' . $language . '.lang.php');

$visiteur = ($user) ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1){
    include ('modules/Vote/index.php');
    compteur('Links');

					?>
					<style type="text/css">
					.boutonhaut {
						
						font-family:times new roman,times,serif;
						text-align: center;
						padding: 10px 20px 10px 20px;
						-moz-box-shadow: 5px 5px 10px <?php echo $bgcolor2; ?>;
                        -webkit-box-shadow: 5px 5px 10px <?php echo $bgcolor2; ?>;
                        -o-box-shadow: 5px 5px 10px <?php echo $bgcolor2; ?>;
                        box-shadow: 5px 5px 10px <?php echo $bgcolor2; ?>;
                        -moz-border-radius: 5px;
                        -webkit-border-radius: 5px;
                        border-radius: 5px;
                        border: 1px solid <?php echo $bgcolor3; ?>;
                        background:<?php echo $bgcolor1; ?>;
                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="<?php echo $bgcolor1; ?>", endColorstr="<?php echo $bgcolor3; ?>"); /* Pour IE seulement et mode gradient � linear */
                        background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $bgcolor1; ?>), to(<?php echo $bgcolor3; ?>));
                        background: -webkit-linear-gradient(<?php echo $bgcolor1; ?>, <?php echo $bgcolor3; ?>);
                        background: -moz-linear-gradient(<?php echo $bgcolor1; ?>, <?php echo $bgcolor3; ?>);
                        background: -o-linear-gradient(<?php echo $bgcolor1; ?>, <?php echo $bgcolor3; ?>); 
                        background: -ms-linear-gradient(<?php echo $bgcolor1; ?>, <?php echo $bgcolor3; ?>); 
                        background: linear-gradient(<?php echo $bgcolor1; ?>, <?php echo $bgcolor3; ?>); 
                        text-decoration: none;
					}
                        .boutonhaut:hover {
                        background:<?php echo $bgcolor3; ?>;
                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="<?php echo $bgcolor3; ?>", endColorstr="<?php echo $bgcolor1; ?>"); /* Pour IE seulement et mode gradient � linear */
                        background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $bgcolor3; ?>), to(<?php echo $bgcolor1; ?>));
                        background: -webkit-linear-gradient(<?php echo $bgcolor3; ?>, <?php echo $bgcolor1; ?>);
                        background: -moz-linear-gradient(<?php echo $bgcolor3; ?>, <?php echo $bgcolor1; ?>);
                        background: -o-linear-gradient(<?php echo $bgcolor3; ?>, <?php echo $bgcolor1; ?>); 
                        background: -ms-linear-gradient(<?php echo $bgcolor3; ?>, <?php echo $bgcolor1; ?>); 
                        background: linear-gradient(<?php echo $bgcolor3; ?>, <?php echo $bgcolor1; ?>); 
                        text-decoration: none;

					}
					</style>
					<?php
					
    function index(){
        global $nuked;

        opentable();

        echo '<br /><div style="text-align: center"><big><b>' . _WEBLINKS . '</b></big></div>'."\n"
		. '<div style="text-align: center"><br />'."\n"
		. '<b class="boutonhaut">' . _INDEXLINKS . '</b>  '
		. '<a class="boutonhaut" href="index.php?file=Links&amp;op=classe&amp;orderby=news">' . _NEWSLINK . '</a>  '
		. '<a class="boutonhaut" href="index.php?file=Links&amp;op=classe&amp;orderby=count">' . _TOPLINKS . '</a>  '
		. '<a class="boutonhaut" href="index.php?file=Suggest&amp;module=Links">' . _SUGGESTLINK . '</a> </div>'."\n";

        $sql = mysql_query('SELECT id FROM ' . LINKS_TABLE);
        $nb_links = mysql_num_rows($sql);

        $sql_nbcat = mysql_query('SELECT cid FROM ' . LINKS_CAT_TABLE);
        $nb_cat = mysql_num_rows($sql_nbcat);
        if ($nb_cat > 0){
            echo '<table style="margin: auto" cellspacing="15" cellpadding="5">'."\n";

            $sql_cat = mysql_query('SELECT cid, titre, description FROM ' . LINKS_CAT_TABLE . ' WHERE parentid = 0 ORDER BY position, titre');
            $test = 0;
            while (list($cid, $titre, $description) = mysql_fetch_array($sql_cat)){
                $description = icon($description);

                if ($cid != $last_cid){
                    $test++;
                    if ($test == 1) echo '<tr>';

                    echo '<td valign="top"><img src="modules/Links/images/fleche.gif" alt="" /><a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $cid . '"><b>' . printSecuTags($titre) . '</b></a>';

                    $sql2 = mysql_query('SELECT cat FROM ' . LINKS_TABLE . ' WHERE cat = ' . $cid);
                    $nb_lk = mysql_num_rows($sql2);

                    if ($nb_lk > 0) echo '<small>&nbsp;(' . $nb_lk . ')</small>'."\n";
                    if (!empty($description)) echo '<div>' . $description . '</div>'."\n";
                    else echo '<br />';

                    $t = 0;
                    $sql_subcat = mysql_query('SELECT cid, titre FROM ' . LINKS_CAT_TABLE . ' WHERE parentid = ' . $cid . ' ORDER BY position, titre LIMIT 0, 4');
                    while (list($sub_cat_id, $sub_cat_titre) = mysql_fetch_array($sql_subcat)){
                        $sub_cat_titre = printSecuTags($sub_cat_titre);
                        $t++;
                        if ($t <= 3) echo '<small><a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $sub_cat_id . '">' . $sub_cat_titre . '</a></small>&nbsp;&nbsp;';
                        else echo '<a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $cid . '"><small>...</small></a>';
                    }

                    echo '</td>',"\n";

                    if ($test == 2){
                        $test = 0;
                        echo '</tr>'."\n";
                    }

                    $last_cid = $cid;
                }
            }

            if ($test == 1) echo '</tr>'."\n";
            echo '</table>'."\n";
        } 
        else{
            echo '<br />'."\n";
		}

        classe('0', '0');

        if ($nb_cat > 0 || $nb_links > 0) echo '<div style="text-align: center"><br /><small><i> ( ' . _THEREIS . '&nbsp;' . $nb_links . '&nbsp;' . _LINKS . ' &amp; ' . $nb_cat . '&nbsp;' . _NBCAT . '&nbsp;' . _INDATABASE . ' )</i></small></div><br />'."\n";
        else echo '<div style="text-align: center"><br />' . _NOLINKINDB . '</div><br /><br />'."\n";

        closetable();
    }

    function categorie($cat){
        global $nuked;

        opentable();

        $sql = mysql_query('SELECT titre, description, parentid FROM ' . LINKS_CAT_TABLE . ' WHERE cid = ' . $cat);
        if(mysql_num_rows($sql) <= 0){
            redirect('index.php?file=404', 0);
            exit();
        }

        list($cat_titre, $cat_desc, $parentid) = mysql_fetch_array($sql);

        $cat_titre = printSecuTags($cat_titre);
        $cat_desc = icon($cat_desc);

        if ($parentid > 0){
            $sql_parent = mysql_query('SELECT titre FROM ' . LINKS_CAT_TABLE . ' WHERE cid = ' . $parentid);
            list($parent_titre) = mysql_fetch_array($sql_parent);

            echo '<br /><div style="text-align: center"><a href="index.php?file=Links" style="text-decoration:none"><big><b>' . _WEBLINKS . '</b></big></a> &gt; <a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $parentid . '" style="text-decoration:none"><big><b>' . htmlentities($parent_titre) . '</b></big></a> &gt; <big><b>' . $cat_titre . '</b></big></div><br />'."\n";
        } 
        else{
            echo '<br /><div style="text-align: center"><a href="index.php?file=Links" style="text-decoration:none"><big><b>' . _WEBLINKS . '</b></big></a> &gt; <big><b>' . $cat_titre . '</b></big></div><br />'."\n";
        } 

        $sql3 = mysql_query('SELECT cid, titre, description  FROM ' . LINKS_CAT_TABLE . ' WHERE parentid = ' . $cat . ' ORDER BY position, titre');
        $nb_subcat = mysql_num_rows($sql3);
        $count = 0;

		if ($nb_subcat > 0){
			echo '<table style="margin: auto" cellspacing="15" cellpadding="5">'."\n";

			while (list($catid, $parentcat, $parentdesc) = mysql_fetch_array($sql3)){
				$parentdesc = icon($parentdesc);

				$sql_nbcat = mysql_query('SELECT id FROM ' . LINKS_TABLE . ' WHERE cat = ' . $catid);
				$nb_lkcat = mysql_num_rows($sql_nbcat);

				if ($catid != $last_catid){
					$count++;

					if ($count == 1) echo '<tr>';

					echo '<td valign="top">'."\n"
					. '<img src="modules/Links/images/fleche.gif" alt="" /><a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $catid . '"><b>' . printSecuTags($parentcat) . '</b></a> <small>(' . $nb_lkcat . ')</small><br />' . $parentdesc . ''."\n"
					. '</td>';

					if ($count == 2){
						$count = 0;
						echo '</tr>'."\n";
					} 

					$last_catid = $catid;
				}
			}

			if ($count == 1) echo '</tr>'."\n";
			echo '</table>'."\n";

		}
		else{
			echo '<div style="text-align: center">' . $cat_desc . '</div><br />'."\n";
		}

        classe($cat, $nb_subcat);

        echo '<br />'."\n";

        closetable();
    }

    function do_link($link_id){
        global $nuked;

        $sql = mysql_query('SELECT url, count FROM ' . LINKS_TABLE . ' WHERE id = ' . $link_id);
        if(mysql_num_rows($sql) <= 0){
            header('location: index.php?file=404');
        }
		else{
			list($link_url, $count) = mysql_fetch_array($sql);
			$new_count = $count + 1;

			$upd = mysql_query('UPDATE ' . LINKS_TABLE . ' SET count = ' . $new_count . ' WHERE id = ' . $link_id);

		//	header('location: ' . $link_url);
		echo '<script language="Javascript">
             <!--
             document.location.replace("'.$link_url.'");
             // -->
             </script>';
		}
    }

    function broken($link_id){
        global $nuked;

        $sql = mysql_query('UPDATE ' . LINKS_TABLE . ' SET broke = broke + 1 WHERE id = ' . $link_id);
        opentable();
        echo '<br /><br /><div style="text-align: center">' . _THXBROKENLINK . '</div><br /><br />'."\n";
        closetable();
        redirect('index.php?file=Links', 2);
    }

    function description($link_id){
        global $nuked, $user, $visiteur, $bgcolor1, $bgcolor2, $bgcolor3;

        $sql = mysql_query('SELECT id, date, titre, description, webmaster, country, cat, count, url FROM ' . LINKS_TABLE . ' WHERE id = ' . $link_id);
        if(mysql_num_rows($sql) <= 0){
            redirect('index.php?file=404', 0);
        }
		else{
			list($link_id, $date, $titre, $description, $webmaster, $country, $cat, $count, $url) = mysql_fetch_array($sql);

			$titre = printSecuTags($titre);
			$description = icon($description);

			$sql2 = mysql_query('SELECT titre, parentid FROM ' . LINKS_CAT_TABLE . ' WHERE cid = ' . $cat);
			list($cat_name, $parentid) = mysql_fetch_array($sql2);
			$cat_name = printSecuTags($cat_name);

			if ($cat == 0) $category = _NONE;
			else if ($parentid > 0){
				$sql3 = mysql_query('SELECT titre FROM ' . LINKS_CAT_TABLE . ' WHERE cid = ' . $parentid);
				list($parent_name) = mysql_fetch_array($sql3);
				$parent_name = printSecuTags($parent_name);

				$category = '<a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $parentid . '">' . $parent_name . '</a> -&gt; <a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $cat. '">' . $cat_name . '</a>';
			}
			else $category = '<a href="index.php?file=Links&amp;op=categorie&amp;cat=' . $cat . '">' . $cat_name . '</a>';

			if (!empty($country) && file_exists('images/flags/' . $country)){
				list ($pays, $ext) = explode ('.', $country);
				$link_pays = '<img src="images/flags/' . $country . '" alt="" title="' . $pays . '" />';
			}
			else{
				$pays = '';
				$link_pays = '&nbsp;';
			}

			opentable();

			if ($visiteur >= admin_mod('Links')){
				echo '<script type="text/javascript">'."\n"
				. '<!--'."\n"
				. "\n"
				. 'function del_link(titre, id)'."\n"
				. '{'."\n"
				. 'if (confirm(\'' . _DELETELINK . ' \'+titre+\' ! ' . _CONFIRM . '\'))'."\n"
				. '{document.location.href = \'index.php?file=Links&page=admin&op=del&link_id=\'+id;}'."\n"
				. '}'."\n"
				. "\n"
				. '// -->'."\n"
				. '</script>'."\n";

				echo '<div style="text-align: right"><a href="index.php?file=Links&amp;page=admin&amp;op=edit_link&amp;link_id=' . $link_id . '"><img style="border: 0" src="images/edition.gif" alt="" title="' . _EDIT . '" /></a>'
				. '&nbsp;<a href="javascript:del_link(\'' . mysql_real_escape_string(stripslashes($titre)) . '\', \'' . $link_id . '\');"><img style="border: 0" src="images/delete.gif" alt="" title="' . _DEL . '" /></a></div>'."\n";
			}

			echo '<br /><div style="text-align: center"><a href="index.php?file=Links" style="text-decoration:none"><big><b> ' . _WEBLINKS . ' </b></big></a></div><br />'."\n"
			. '<table style="margin: auto" width="80%" border="0" cellspacing="3" cellpadding="3">'."\n"
			. '<tr><td style="background: ' . $bgcolor2 . ';border: 1px solid ' . $bgcolor3 . '" align="center">'."\n"
			. '<table width="100%" border="0" cellspacing="0" cellpadding="0">'."\n"
			. '<tr><td style="width: 5%">&nbsp;</td>'."\n"
			. '<td style="width: 90%" align="center"><big><b>' . $titre . '</b></big>'."\n"
			. '&nbsp;<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://www.facebook.com/plugins/like.php?href='.$url.'&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;font=verdana&amp;colorscheme=light&amp;height=21" style="vertical-align:middle;color: rgb(100, 30, 63); font-family: Verdana; font-size: small; text-align: -webkit-center; border-style: none; overflow: hidden; width: 100px; height: 21px;"></iframe>
			</td>'."\n"
			. '<td style="width: 5%" align="center">' . $link_pays . '</td></tr></table></td></tr>'."\n"
			. '<tr><td style="background: ' . $bgcolor1 . ';border: 1px dashed ' . $bgcolor3 . ';width: 100%" align="center"><img alt="'.$titre.'" src="http://www.robothumb.com/src/?url='.$url.'&size=320x240" style="margin-top:2px;margin-bottom:2px;width: 320px; height: 240px;" /></td></tr>'."\n";


			if (!empty($description)){
				echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '">' . $description . '</td></tr>'."\n"
				. '<tr style="background: ' . $bgcolor2 . '"><td>&nbsp;</td></tr>'."\n";
			}

			echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '"><b>' . _CAT . ' :</b> ' . $category . '</td></tr>'."\n" 
			. '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '"><b>' . _ADDTHE . ' :</b> ' . nkDate($date) . '</td></tr>'."\n";

			if (!empty($webmaster)){
				echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '"><b>' . _WEBMASTER . ' :</b> ' . printSecuTags($webmaster) . '</td></tr>'."\n";
			}

			if (!empty($country) && !empty($pays)){
				echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '"><b>' . _COUNTRY . ' :</b> ' . $pays . '</td></tr>'."\n";
			}

			echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '"><b>' . _VISIT . ' :</b> ' . $count . '&nbsp;' . _TIMES . '</td></tr>'."\n";
			echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '"><b>PageRank actuel :</b>'."\n";
            echo '&nbsp;<img style="vertical-align:middle;" src="http://www.test-pagerank.com/pagerankCurrent.php?url='.$url.'&color=g" title="PageRank de '.$titre.'"/></a></td></tr>'."\n";	
            echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '">Merci � <a href="http://www.robothumb.com/">Robothumb</a>&nbsp;et&nbsp;<a href="http://www.test-pagerank.com/">PageRank</a></td></tr>'."\n";


			if($visiteur >= nivo_mod('Vote') && nivo_mod('Vote') > -1){
				echo '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '">';
				vote_index('Links', $link_id);
				echo '</td></tr>'."\n";
			}

			if ($visiteur > 0) echo '<tr style="background: ' . $bgcolor2 . '"><td>&nbsp;</td></tr>'."\n"
			. '<tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '"><img src="modules/Links/images/warning.gif" alt="" /> [ <a href="index.php?file=Links&amp;op=broken&amp;link_id=' . $link_id . '">' . _INDICATELINK . '</a> ]</td></tr>';
			echo '</table>'."\n"
			. '<div style="text-align: center"><br /><input type="button" value="' . _VISITTHISSITE . '" onclick="window.open(\'index.php?file=Links&amp;nuked_nude=index&amp;op=do_link&amp;link_id=' . $link_id . '\')" /></div><br />';
			
			$sql = mysql_query('SELECT active FROM ' . $nuked['prefix'] . '_comment_mod WHERE module = \'links\'');
			list($active) = mysql_fetch_array($sql);

			if($active == 1 && $visiteur >= nivo_mod('Comment') && nivo_mod('Comment') > -1){
				echo '<table style="margin: auto" width="80%" border="0" cellspacing="3" cellpadding="3"><tr style="background: ' . $bgcolor1 . '"><td style="border: 1px dashed ' . $bgcolor3 . '">';

				include ('modules/Comment/index.php');
				com_index('Links', $link_id);

				echo '</td></tr></table>'."\n";
			}

			closetable();
		}
    }

    function classe($cat, $nb_subcat){
        global $nuked, $theme, $bgcolor1, $bgcolor2, $bgcolor3, $visiteur;

        if ($_REQUEST['op'] == 'classe'){
            echo '<br /><div style="text-align: center"><big><b>' . _WEBLINKS . '</b></big></div>'."\n"
            . '<div style="text-align: center"><br />'."\n"
            . ' <a class="boutonhaut" href="index.php?file=Links">' . _INDEXLINKS . '</a>  ';

            if ($_REQUEST['orderby'] == 'news')
				echo '<b class="boutonhaut">' . _NEWSLINK . '</b>  ';
            else
                echo '<a class="boutonhaut" href="index.php?file=Links&amp;op=classe&amp;orderby=news">' . _NEWSLINK . '</a>  ';

            if ($_REQUEST['orderby'] == 'count')
                echo '<b class="boutonhaut">' . _TOPLINKS . '</b>  ';
            else
                echo '<a class="boutonhaut" href="index.php?file=Links&amp;op=classe&amp;orderby=count">' . _TOPLINKS . '</a>  ';

            echo '<a class="boutonhaut" href="index.php?file=Suggest&amp;module=Links">' . _SUGGESTLINK . '</a> </div><br />'."\n";
        }

        $nb_liens = $nuked['max_liens'];
        if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_liens - $nb_liens;

        $where = isset($cat) ? 'WHERE L.cat = ' . $cat : '';

        if ($_REQUEST['orderby'] == 'name')
            $order = 'ORDER BY L.titre';
        else if ($_REQUEST['orderby'] == 'count')
            $order = 'ORDER BY L.count DESC';
        else if ($_REQUEST['orderby'] == 'note')
            $order = "ORDER BY note DESC";
        else{
            $_REQUEST['orderby'] = 'news';
            $order = 'ORDER BY L.id DESC';
        }

        $sql = mysql_query('SELECT L.id, L.date, L.titre, L.description, L.count, L.country, L.url, L.webmaster, L.cat, AVG(V.vote) AS note  FROM ' . LINKS_TABLE . ' AS L LEFT JOIN ' . VOTE_TABLE . ' AS V ON L.id = V.vid AND V.module = \'Links\' ' . $where . ' GROUP BY L.id ' . $order);
        $nb_lk = mysql_num_rows($sql);

        if ($nb_lk > 1 && !empty($cat)){
            echo '<table style="margin: auto" width="90%">'."\n"
            . '<tr><td align="right"><small>' . _ORDERBY . ' : ';

            if ($_REQUEST['orderby'] == 'news') echo '<b>' . _DATE . '</b> | ';
            else echo '<a href="index.php?file=Links&amp;op=' . $_REQUEST['op'] . '&amp;orderby=news&amp;cat=' . $cat . '">' . _DATE . '</a> | ';
            if ($_REQUEST['orderby'] == 'count') echo '<b>' . _TOPFILE . '</b> | ';
            else echo '<a href="index.php?file=Links&amp;op=' . $_REQUEST['op'] . '&amp;orderby=count&amp;cat=' . $cat . '">' . _TOPFILE . '</a> | ';
            if ($_REQUEST['orderby'] == 'name') echo '<b>' . _NAME . '</b> | ';
            else echo '<a href="index.php?file=Links&amp;op=' . $_REQUEST['op'] . '&amp;orderby=name&amp;cat=' . $cat . '">' . _NAME . '</a> | ';
            if ($_REQUEST['orderby'] == 'note') echo '<b>' . _NOTE . '</b>';
            else echo '<a href="index.php?file=Links&amp;op=' . $_REQUEST['op'] . '&amp;orderby=note&amp;cat=' . $cat . '">' . _NOTE . '</a>';

            echo '</small></td></tr></table>'."\n";
        }

        if ($nb_lk > 0){
            if ($nb_lk > $nb_liens){
                echo '<table style="margin: auto" width="90%"><tr><td>';
                $url_page = 'index.php?file=Links&amp;op='. $_REQUEST['op'] . '&amp;cat=' . $cat . '&amp;orderby=' . $_REQUEST['orderby'];
                number($nb_lk, $nb_liens, $url_page);
                echo '</td></tr></table>'."\n";
            } 

            echo '<br />';

            $sqlhot = mysql_query('SELECT id FROM ' . LINKS_TABLE . ' ORDER BY count DESC LIMIT 0, 10');

            $seek = mysql_data_seek($sql, $start);
            for($i = 0;$i < $nb_liens;$i++){
                if (list($link_id, $date, $titre, $description, $count, $country, $url, $webmaster, $cat) = mysql_fetch_array($sql)){
                    $titre = printSecuTags($titre);
                    $newsdate = time() - 604800;
                    $att = '';

        $sqlcattitre = mysql_query('SELECT titre FROM ' . LINKS_CAT_TABLE . ' WHERE cid = '.$cat.'');
        list($namecat) = mysql_fetch_array($sqlcattitre);
        
                    if (!empty($date) && $date > $newsdate) $att = '&nbsp;&nbsp;' . _NEW;

                    if (!empty($description)){
                        $description = str_replace('\r', '', $description);
                        $description = str_replace('\n', ' ', $description);
                        $texte = strip_tags($description);

                        if (strlen($texte) > 150){
                            $texte = substr($texte, 0, 150) . '...';
                        }                         
                    } 
                    else
                        $texte = ''; 

                    mysql_data_seek($sqlhot, 0);
                    while (list($id_hot) = mysql_fetch_array($sqlhot)){
                        if ($link_id == $id_hot && $nb_lk > 1 && $count > 9) $att .= '&nbsp;&nbsp;' . _HOT;
                    } 

                    if (!empty($date)) $alt = 'title="' . _ADDTHE . '&nbsp;' . nkDate($date) . '"';
                    else $alt = '';

                    if (file_exists('themes/' . $theme . '/images/liens.gif'))
                        $img = '<img src="themes/' . $theme . '/images/liens.gif" alt="" ' . $alt . '/>';
                    else
                        $img = '<img src="modules/Links/images/liens.gif" alt="" ' . $alt . '/>';

                    if (!empty($country) && file_exists('images/flags/' . $country)){
                        list ($pays, $ext) = explode ('.', $country);
                        $link_pays = '<img src="images/flags/' . $country . '" alt="" title="' . $pays . '" />';
                    }
                    else
                        $link_pays = '&nbsp;';           
   
				                        // ----- Affiche le nombre de commentaires -----
                    $sql_com_links = mysql_query("SELECT id FROM " . COMMENT_TABLE . " WHERE im_id = '" . $link_id . "' AND module = 'Links'");
                    $nb_comment = mysql_num_rows($sql_com_links);
                    
					                    
                    $box = "<img style=\"cursor: pointer; overflow: auto; max-width: 160px; max-height: 120px; width: expression(this.scrollWidth >= 160? '160px' : 'auto'); height: expression(this.scrollHeight >= 120? '120px' : 'auto');\" src=\"http://www.robothumb.com/src/".$url."@160x120.jpg\" onclick=\"document.location='index.php?file=Links&amp;op=description&amp;link_id=" . $link_id . "'\" border=\"0\" title=\"" . $titre . "\" alt=\"" . $titre . "\" />";
           
                    echo "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
                       . "<tr style=\"background: " . $bgcolor3 . ";\"><td colspan=\"2\">" . $img . "&nbsp;<a href=\"index.php?file=Links&amp;op=description&amp;link_id=" . $link_id . "\"><big><b>" . $titre . "</b></big></a>" . $att . "<xx style=\"float: right;\">\n";
                       
                        vote_index('Links', $link_id);
                        
                    echo "</xx></td></tr>\n"
                       . "<tr style=\"background: " . $bgcolor1 . ";height: 140px;text-align: center;\"><td style=\"width: 170px;vertical-align: middle;\">" . $box . "</td><td style=\"vertical-align: top;\">\n"
                       . "<table style=\"text-align: left;\" width=\"100%\" cellspacing=\"1\" cellpadding=\"1\">\n"
                       . "<tr style=\"background: " . $bgcolor1 . ";\"><td>&nbsp;</td></tr>\n"
                       . "<tr style=\"background: " . $bgcolor1 . ";\"><td>&nbsp;&nbsp;�&nbsp;<b>" . _ADDTHE . " :</b> " . nkDate($date) . "</td></tr>\n"
                       . "<tr style=\"background: " . $bgcolor1 . ";\"><td>&nbsp;&nbsp;�&nbsp;<b>" . _CAT . " :</b> " . $namecat . "</td></tr>\n"
                       . "<tr style=\"background: " . $bgcolor1 . ";\"><td>&nbsp;&nbsp;�&nbsp;<b>Webmaster :</b> " . $webmaster . "</td></tr>\n"
                       . "<tr style=\"background: " . $bgcolor1 . ";\"><td>&nbsp;&nbsp;�&nbsp;<b>Commentaires :</b> " . $nb_comment . "</td></tr>\n"
                       . "<tr style=\"background: " . $bgcolor1 . ";\"><td>&nbsp;&nbsp;�&nbsp;<b>" . _HITS . " :</b> " . $count . "&nbsp;" . _TIMES . "</td></tr>\n"
					   . "<tr style=\"background: " . $bgcolor1 . ";\"><td>&nbsp;&nbsp;�&nbsp;<i>" . $texte . "</i></td></tr>\n"             
                       . "</td></tr></table>\n"
                       . "</td></tr></table><br />\n";                       

                } 
            } 

            if ($nb_lk > $nb_liens){
                echo '<table style="margin: auto" width="90%"><tr><td>';
                $url_page = 'index.php?file=Links&amp;op='. $_REQUEST['op'] . '&amp;cat=' . $cat . '&amp;orderby=' . $_REQUEST['orderby'];
                number($nb_lk, $nb_liens, $url_page);
                echo '</td></tr></table>'."\n";
            } 
        } 
        else{
            if ($nb_subcat == 0 && $cat > 0) echo '<div style="text-align: center"><br />' . _NOLINKS . '</div><br /><br />'."\n";
            if ($_REQUEST['op'] == 'classe') echo '<div style="text-align: center"><br />' . _NOLINKINDB . '</div><br /><br />'."\n";
        }
	echo '<div style="text-align: center;">
	<span style="font-family:times new roman,times,serif;">Patch par <a href="http://kotshiro.free.fr">InconnueTeam</a> Miniatures par <a href="http://www.robothumb.com/">Robothumb</a>&nbsp;</span><span style="font-family: \'times new roman\', times, serif;">&copy;2013</span></div>';
       
    } 

    switch ($_REQUEST['op']){
        case 'categorie':
            categorie($_REQUEST['cat']);
            break;
        case 'classe':
            opentable();
            classe($_REQUEST['cat'], $_REQUEST['nb_subcat']);
            closetable();
            break;
        case 'do_link':
            do_link($_REQUEST['link_id']);
            break;
        case 'broken':
            broken($_REQUEST['link_id']);
            break;
        case 'description':
            description($_REQUEST['link_id']);
            break;
        default:
            index();
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
    echo '<div style="text-align: center; margin: 10px 0">' . _USERENTRANCE . '<br /><br /><b><a href="index.php?file=User&amp;op=login_screen">' . _LOGINUSER . '</a> | <a href="index.php?file=User&amp;op=reg_screen">' . _REGISTERUSER . '</a></b>/div>';
    closetable();
} 
else{
    opentable();
    echo '<br /><br /><div style="text-align: center">' . _NOENTRANCE . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a><br /><br /></div>';
    closetable();
} 
?>