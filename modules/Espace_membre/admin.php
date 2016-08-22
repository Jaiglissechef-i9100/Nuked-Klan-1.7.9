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

	include 'modules/Admin/design.php';
    // inclusion du fichier langue    
    translate('modules/Espace_membre/lang/' . $language . '.lang.php');

    /* Constant pour les tables */
	define('ESPACE_MEMBRE_TABLE', $nuked['prefix'] . '_espace_membre');
	define('ESPACE_MEMBRE_PREFS_TABLE', $nuked['prefix'] . '_espace_membre_prefs');
	define('ESPACE_MEMBRE_COMMUN_TABLE', $nuked['prefix'] . '_espace_membre_commun');
	define('ESPACE_MEMBRE_STATU_TABLE', $nuked['prefix'] . '_espace_membre_statu');
	define('ESPACE_MEMBRE_GALERY_TABLE', $nuked['prefix'] . '_espace_membre_galerie');


	echo '<script type="text/javascript"><!--'."\n"
	. 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
	. '--></script>'."\n"
	. '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
	. '<script type="text/javascript">'."\n"
	. 'Shadowbox.init();'."\n"
	. '</script>'."\n";

$visiteur = $user ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);

if ($visiteur >= $level_admin && $level_admin > -1)
{
	$repertoire = "upload/Espace_membre/Perso/";
	$rep_comun = "upload/Espace_membre/Commun";
	$rep = $repertoire.$user[0]."/";

	///////////////////////////// REQUETE /////////////////////////
	$sql_prefs = mysql_query("SELECT * FROM " . ESPACE_MEMBRE_PREFS_TABLE . "");
	while ($row = mysql_fetch_array($sql_prefs))
	{
	    $prefs[$row['nom']] = $row['value'];
	} 

	$nbquotas = $prefs[nb_quotas];
	$nbfichier = $prefs[nb_fichier];
	$nbimg = $prefs[nb_img];
	$nbmembre = $prefs[nb_membre];
	$galerie = $prefs[galerie];
	$niveauupload = $prefs[niveau_upload];
	$maxupload = $prefs[max_upload];
	$nbquotas_commun = $prefs[nb_quotas_commun];
	//////////////////////////////////////////////////////////////////////

	function main($qui)
	{
		global $user, $repertoire,$nuked,$p,$language,$rep_comun,$nbimg;



		echo"	<script type=\"text/javascript\">
				<!--
				function del_compte(qui,pseudo)
				{
				if (confirm('" . _DELETEHISCOMPTE . " '+qui+' ?   '))
				{document.location.href ='index.php?file=Espace_membre&page=admin&op=del_compte&user_id='+qui;}
				}
				function del_fichier(user_id,id_img)
				{
				if (confirm('" . _DELETEFICHIER . "  ?   '))
				{document.location.href ='index.php?file=Espace_membre&page=admin&op=del_ban&id_img='+id_img;}
				}
				// -->
				</script>";

		if($qui != "" && function_exists('rmdir') ){
			$del="<div style=\"text-align: center;\"><br /><input type=\"button\" value=\"" . _DELCOMPTE . "\" onclick=\"javascript:del_compte('" . $qui . "','" . $pseudo . "');\" /></div>";
		}

		$sql_nbnews = mysql_query("SELECT id,pseudo FROM ".ESPACE_MEMBRE_TABLE." WHERE pseudo='" . $qui . "'  ");
		$nb_news = mysql_num_rows($sql_nbnews);

		$url = "index.php?file=Espace_membre&amp;op=galerie&amp;page=admin&amp;qui=$qui";

		if (!$p) $p = 1;
		$start = $p * $nbimg - $nbimg;

		if($qui != "")
		{
			if($nb_news != "")
			{
				$where = "ORDER BY date DESC LIMIT $start ,  $nbimg";
			}
				
			$members ="WHERE pseudo='" . $qui . "' ";

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINUPLOAD . "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Espace.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">" . _INDEX . "<b> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs\">" . _PREFSS . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext\"> " . _PREFEXT . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext2\">" . _PREFEXT2 . "</a></b></div><br />\n";

		echo "	<form method=\"post\" action=\"index.php?file=Espace_membre&amp;page=admin\" enctype=\"multipart/form-data\" />
				<table style=\"width: 100%;\" cellspacing=\"0\" cellpadding=\"2\">
					<tr>
						<td style=\"text-align: center;\"><b>" . _SELECTMEMBRE . ":&nbsp;</b><select name=\"qui\" onchange=\"submit();\">
							<option value=\"" . $qui . "\">" . $qui . "</option>
							<option value=\"\">" . _COMMUN . "</option>";

							if ($rep1 = @opendir("$repertoire")){
								while ($file = readdir($rep1)) {
									if($file != "..") {
										if($file != ".") {  
											if ($file != "index.html" && $file != "Thumbs.db"){
												$file_name= str_replace("/", "", $file);
												$sql=mysql_query("SELECT pseudo FROM $nuked[prefix]" . _users . " WHERE  id='" . $file_name . "' ");
												list($pseudo) = mysql_fetch_array($sql);

												echo"<option value=\"" . $pseudo . "\">" . $pseudo . "</option>";
											}
										}
									}
								}
							}

		echo"			</select></td>
					</tr>
				</table></form>
				<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
					<tr>
						<td style=\"text-align: center; width: 5%;\"><b>" . _TYPE . "</b></td>
						<td style=\"text-align: center; width: 35%;\"><b>" . _FILENAME . "</b></td>
						<td style=\"text-align: center; width: 15%;\"><b>" . _POIDS . "</b></td>
						<td style=\"text-align: center; width: 35%;\"><b>" . _DATEUPLOAD . "</b></td>
						<td style=\"text-align: center; width: 5%;\"><b>" . _MP2 . "</b></td>
						<td style=\"text-align: center; width: 5%;\"><b>" . _DELETE . "</b></td>
					</tr>";

					$sql = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_TABLE." ".$members." ".$where." ");
					while(list($id_img) = mysql_fetch_array($sql))

					if($nb_news != 0)
					{
						$sql_id = mysql_query("SELECT user_id,pseudo,fichier,date FROM ".ESPACE_MEMBRE_TABLE." WHERE id='" . $id_img . "' ");
						list($user_id,$pseudo,$fichier,$date) = mysql_fetch_array($sql_id);

						$date = nkDate($date);
						$ext = substr(strrchr($fichier,"."),1);
						$fichier_split = eregi_replace("." . $ext, "", $fichier);

						if (eregi("jpg", $ext) || eregi("png", $ext) || eregi("gif", $ext) || eregi("bmp", $ext))
						{
							$links = "<a href=\"".$repertoire.$user_id."/".$fichier."\" rel=\"shadowbox\">".$fichier_split."</a>";
						}else{
							$links = "<a href=\"".$repertoire.$user_id."/".$fichier."\" alt=\"\">" . $fichier_split . "</a>";
						}

						$id_fichier = "$repertoire$user_id/$fichier";
						$filesize = filesize($id_fichier)/1024;
						$poids=ceil($filesize);
						$filecreate = date("d/m/Y "._AT." H:i ", filectime($id_fichier));

					  	if ($i == 0)
						{
							$bg = $bgcolor2;
							$i++;
						} 
						else
						{
							$bg = $bgcolor1;
							$i = 0;
						} 

						$typename = "<img src=\"modules/Espace_membre/images/" . $ext . ".gif\" alt=\"\" style=\"border: 0px;\" />";

					echo "	<tr style=\"background: " . $bg . ";\">
								<input type=\"hidden\" name=\"id\" value=\"" . $id . "\">
								<td style=\"text-align: center; width: 5%;\">" . $typename . "</td>
								<td style=\"text-align: center; width: 35%;\">" . $links . "</td>
								<td style=\"text-align: center; width: 15%;\"> ~ " . $poids . " ko</td>
								<td style=\"text-align: center; width: 35%;\">" . $filecreate . " ko</td>
								<td style=\"text-align: center; width: 5%;\"><a href=\"index.php?file=Userbox&amp;op=post_message&amp;for=" . $user_id . "\"><img src=\"modules/Espace_membre/images/mp.gif\" style=\"border: 0px;\" alt=\"\" /></a></td>
								<td style=\"text-align: center; width: 5%;\"><a href=\"javascript:del_fichier('" . $user_id . "','" . $id_img . "');\" alt=\"\"><img src=\"modules/Espace_membre/images/del.png\" style=\"border: 0px;\" alt=\"\" /></a></td>
							</tr>";		
					}

		echo "	</table><div style=\"text-align: center;\"><br />";

		if($nb_news == ""){ echo"<div style=\"text-align: center;\">" . _NOFICHIERINDB . "</div>"; }
			
		if ($nb_news > $nbimg){ number($nb_news, $nbimg, $url); echo"<br />"; }
	//////////////////////////////////////////////////////////////////////////////
	}else{
	/////////////////////////////////////////////////////////////////////////////
		$sql_nbnews = mysql_query("SELECT id,pseudo FROM ".ESPACE_MEMBRE_COMMUN_TABLE." ");
		$nb_news = mysql_num_rows($sql_nbnews);

	echo"	<script type=\"text/javascript\">
			<!--
			function del_fichier(user_id,id_img)
			{
			if (confirm('" . _DELETEFICHIER . "  ?   '))
			{document.location.href ='index.php?file=Espace_membre&page=admin&op=delete_ban&id_img='+id_img+'&user_id='+user_id;}
			}
			// -->
			</script>";

			if($nb_news != "")
			{
				$where = "ORDER BY date && pseudo DESC LIMIT $start ,  $nbimg";
			}

	        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINUPLOAD . "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Espace.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">" . _INDEX . "<b> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs\">" . _PREFSS . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext\"> " . _PREFEXT . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext2\">" . _PREFEXT2 . "</a></b></div><br />\n";

	echo "	<form method=\"post\" action=\"index.php?file=Espace_membre&amp;page=admin\" enctype=\"multipart/form-data\" />
			<table style=\"width: 100%;\" cellspacing=\"0\" cellpadding=\"2\">
				<tr>
					<td style=\"text-align: center;\"><b>" . _SELECTMEMBRE . ":&nbsp;</b>
						<select name=\"qui\" onchange=\"submit();\">
							<option value=\"\">" . _COMMUN . "</option>";

							$re_com ="upload/Espace_membre/Commun/";
							if ($rep1 = @opendir("$repertoire")){
								while ($file = readdir($rep1)) {
									if($file != "..") {
										if($file != ".") {  
							 				if ($file != "index.html" && $file != "Thumbs.db"){
												$file_name = str_replace("/", "", $file);

												$sql=mysql_query("SELECT pseudo FROM $nuked[prefix]" . _users . " WHERE  id='" . $file_name. "' ");
												list($pseudo) = mysql_fetch_array($sql);

												echo"	<option value=\"" . $pseudo . "\">" . $pseudo . "</option>";
											}
										}
									}
								}
							}
		echo"			</select>
					</td>
				</tr>
			</table></form>
			<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
					<tr>
						<td style=\"text-align: center; width: 10%;\"><b>" . _TYPE . "</b></td>
						<td style=\"text-align: center; width: 15%;\"><b>" . _BY . "</b></td>						
						<td style=\"text-align: center; width: 20%;\"><b>" . _FILENAME . "</b></td>
						<td style=\"text-align: center; width: 15%;\"><b>" . _POIDS . "</b></td>
						<td style=\"text-align: center; width: 20%;\"><b>" . _DATEUPLOAD . "</b></td>
						<td style=\"text-align: center; width: 10%;\"><b>" . _MP2 . "</b></td>
						<td style=\"text-align: center; width: 10%;\"><b>" . _DELETE . "</b></td>
				</tr>";

				$sql = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_COMMUN_TABLE . " $where ");
				while(list($id_img) = mysql_fetch_array($sql))
				if($nb_news != 0)
				{
					$sql_id = mysql_query("SELECT user_id,pseudo,fichier,date FROM ".ESPACE_MEMBRE_COMMUN_TABLE. " WHERE id='" . $id_img . "' ");
					list($user_id,$pseudo,$fichier,$date) = mysql_fetch_array($sql_id);

					$date = nkDate($date);
					$ext = substr(strrchr($fichier,"."),1);
					$fichier_split = eregi_replace("." . $ext, "", $fichier);

					if($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "bmp" || $ext == "BMP" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG"){
						$links = "<a href=\"".$rep_comun."/".$fichier."\" rel=\"shadowbox\">".$fichier_split."</a>";
					}else{
						$links = "<a href=\"".$rep_comun."/".$fichier."\" alt=\"\">".$fichier_split."</a>";
					}

					$id_fichier = "$rep_comun/$fichier";
					$filesize = filesize($id_fichier)/1024;
					$poids=ceil($filesize);
					$filecreate = date("d/m/Y "._AT." H:i ", filectime($id_fichier));

				 	if ($i == 0)
					{
						$bg = $bgcolor2;
						$i++;
					} 
					else
					{
						$bg = $bgcolor1;
						$i = 0;
					} 

					$typename = "<img src=\"modules/Espace_membre/images/" . $ext . ".gif\" alt=\"\" style=\"border: 0px;\" />";

					echo "	<tr style=\"background: " . $bg . ";\">
								<input type=\"hidden\" name=\"id\" value=\"" . $id . "\">
								<td style=\"text-align: center; width: 10%;\">" . $typename . "</td>
								<td style=\"text-align: center; width: 15%;\"><a href=\"index.php?file=Userbox&amp;op=post_message&amp;for=$user_id\">" . $pseudo . "</a></td>
								<td style=\"text-align: center; width: 20%;\">" . $links . "</td>
								<td style=\"text-align: center; width: 15%;\"> ~ " . $poids . " ko</td>
								<td style=\"text-align: center; width: 20%;\">" . $date . "</td>								
								<td style=\"text-align: center; width: 10%;\"><a href=\"index.php?file=Userbox&amp;op=post_message&amp;for=" . $user_id . "\"><img src=\"modules/Espace_membre/images/mp.gif\" style=\"border: 0px;\" alt=\"\" /></a></td>
								<td style=\"text-align: center; width: 10%;\"><a href=\"javascript:del_fichier('" . $user_id . "','" . $id_img . "');\" alt=\"\"><img src=\"modules/Espace_membre/images/del.png\" style=\"border: 0px;\"></a></td>
							</tr>";		
				}

		echo "	</table>
				<div style=\"text-align: center;\"><br />";
					if($nb_news == "" || $pseudo ==""){
						echo"<div style=\"text-align: center;\">" . _NOFICHIERINDB . "</div>";
					}
					
					if ($nb_news > $nbimg){
						number($nb_news, $nbimg, $url); 
						echo"<br />";
					}
		}

		echo"	<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Espace_membre&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}


	function del_ban($id_img,$user_id)
	{
		global $nuked,$user,$repertoire;

		$sql=mysql_query("SELECT fichier FROM ".ESPACE_MEMBRE_TABLE." WHERE id = '" . $id_img . "' ");
		list($fichier) = mysql_fetch_array($sql);

		$img = "$repertoire/$user_id/$fichier";

		$del=mysql_query("DELETE FROM ".ESPACE_MEMBRE_TABLE." WHERE  id='" . $id_img . "' ");
		@unlink("$img");
		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _IMGDELETE . "\n"
				. "</div>\n"
				. "</div>\n";		
		redirect("index.php?file=Espace_membre&page=admin&qui=$user_id",2);
	}

	function delete_ban($id_img,$user_id)
	{
		global $nuked,$user,$repertoire,$rep_comun;

		$sql=mysql_query("SELECT fichier FROM ".ESPACE_MEMBRE_COMMUN_TABLE." WHERE id = '" . $id_img . "' ");
		list($fichier) = mysql_fetch_array($sql);

		$img = "$rep_comun/$fichier";

		$del=mysql_query("DELETE FROM " . ESPACE_MEMBRE_COMMUN_TABLE . " WHERE  id='" . $id_img . "' ");
		@unlink("$img");
		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _IMGDELETE . "\n"
				. "</div>\n"
				. "</div>\n";	
		redirect("index.php?file=Espace_membre&page=admin",2);
	}

	function prefs()
	{
		global $nuked,$language,$bgcolor3,$bgcolor1,$nbquotas,$nbfichier,$nbimg,$nbmembre,$galerie,$niveauupload,$maxupload,$nbquotas_commun;

		        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINUPLOAD . "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Espace.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Espace_membre&amp;page=admin\"> " . _INDEX . "</a> | "
	           . "</b>" . _PREFSS . " | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext\"> " . _PREFEXT . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext2\">" . _PREFEXT2 . "</a></b></div><br />\n";


			if($galerie == on){$selected = "selected";}
			if($galerie == off){$selected2 = "selected";}

		echo "	<form method=\"post\" action=\"index.php?file=Espace_membre&amp;page=admin&amp;op=add_prefs\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
			. "<tr><td style=\"vertical-align: middle; text-align: center; font-size: 12px;\"><b>" . _PREF . "</b></td></tr>\n"
			. "</table><br />\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n"
			. "<tr><td>" . _NBGALERIE . " :</td><td> <select name=\"galerie\"><option value=\"on\" $selected />" . _ACTIVER . "</option><option value=\"off\" $selected2 />" . _DESACTIVER . "</option></td></tr>\n"
			. "<tr><td>" . _NBIMG . " :</td><td> <input type=\"text\" name=\"nb_img\" size=\"2\" value=\"" . $nbimg . "\" /></td></tr>\n"
			. "<tr><td>" . _NBFICHIER . " :</td><td> <input type=\"text\" name=\"nb_fichier\" size=\"2\" value=\"" . $nbfichier . "\" /></td></tr>\n"
			. "<tr><td>" . _NBMEMBRE . " :</td><td> <input type=\"text\" name=\"nb_membre\" size=\"2\" value=\"" . $nbmembre . "\" /></td></tr>\n"
			. "<tr><td>" . _MAXUPLOAD . " :</td><td> <input type=\"text\" name=\"max_up\" size=\"3\" value=\"" . $maxupload . "\" /> (" . _MO . ")</td></tr>\n"
			. "<tr><td>" . _QUOTA . " :</td><td> <input type=\"text\" name=\"nb_quotas\" size=\"3\" value=\"" . $nbquotas . "\" /> (" . _MO . ")</td></tr>\n"
			. "<tr><td>" . _QUOTACOMMUN . " :</td><td> <input type=\"text\" name=\"nb_quotas_commun\" size=\"3\" value=\"" . $nbquotas_commun . "\" /> (" . _MO . ")</td></tr>\n"
			. "<tr><td>" . _NIVEAUPLOAD . " :</td><td> <select name=\"niveau_up\">\n"
			. "<option $selected>$niveauupload</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select></td></tr>\n"
			. "</table><br />\n"
			. "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _UPDATEOPTIONS . "\" /></div></form>\n"
			. "<form method=\"post\" action=\"index.php?file=Espace_membre&amp;page=admin&amp;op=add_ext\">\n"
			. "<br />\n";


		echo"	<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Espace_membre&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}


	function prefs_ext()
	{
		global $nuked,$language,$bgcolor3,$bgcolor1;
		echo "	<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			."function setCheckboxes(checkbox, nbcheck, do_check)\n"
			."{\n"
			."for (var i = 0; i < nbcheck; i++)\n"
			."{\n"
			."cbox = checkbox + i;\n"
			."document.getElementById(cbox).checked = do_check;\n"
			."}\n"
			."return true;\n"
			."}\n"
			."\n"
			. "// -->\n"
			. "</script>\n";

		echo"	<script type=\"text/javascript\">
			<!--
			function del_extention(id,nom)
			{
			if (confirm('" . _DELETEHISEXT . "'+nom+' ?   '))
			{document.location.href ='index.php?file=Espace_membre&page=admin&op=del_extention&nom='+nom+'&id='+id;}
			}
			// -->
			</script>";


		        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINUPLOAD . "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Espace.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Espace_membre&amp;page=admin\"> " . _INDEX . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs\">" . _PREFSS . "</a> | "
	           . "</b>" . _PREFEXT . "<b> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext2\">" . _PREFEXT2 . "</a></b></div><br />\n";



		echo" <form method=\"post\" action=\"index.php?file=Espace_membre&amp;page=admin&amp;op=add_prefs_ext\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left; border: 0px;\" cellspacing=\"0\" cellpadding=\"0\">\n"
			. "<tr><td style=\"vertical-align: middle; text-align: center; font-size: 12px;\"><b>" . _PREF2 . "</b></td></tr>\n"
			. "</table><br />\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left; border: 0px; width: 100%;\" cellspacing=\"0\" cellpadding=\"3\"><tr>\n";

		$sql_box = mysql_query("SELECT id FROM " . ESPACE_MEMBRE_STATU_TABLE . " ");
		$nb_box = mysql_num_rows($sql_box);
		$i = 0;
		$s = 0;

		$sql_box2 = mysql_query("SELECT id,nom,statu FROM " . ESPACE_MEMBRE_STATU_TABLE . " ORDER BY nom");
		while(list($id,$nom_box,$statu_box) = mysql_fetch_array($sql_box2))
		{
			$check = "$checked";

			if($statu_box == "1"){$check = "checked";}

			if ($s <= 2)
			{
				echo"	<td style=\"width: 1%;\">." . $nom_box . "</td><td><input type=\"checkbox\" id=\"box" . $i . "\" name=\"nom[" . $nom_box . "]\" value=\"1\" style=\"border: 0px; background-color: " . $bgcolor1 . ";\" " . $check . " />&nbsp;<a href=\"#\"><img src=\"modules/Espace_membre/images/del.png\" alt=\"\" style=\"border: 0px;\" onclick=\"javascript:del_extention('" . $id . "','" . $nom_box . "');\" /></a></td>";
				$s++;
			}
			else
			{
				echo"	<td style=\"width: 1%;\">." . $nom_box . "</td><td><input type=\"checkbox\" id=\"box" . $i . "\" name=\"nom[" . $nom_box . "]\" value=\"1\" style=\"border: 0px; background-color: " . $bgcolor1 . ";\" " . $check . " />&nbsp;<a href=\"#\"><img src=\"modules/Espace_membre/images/del.png\" alt=\"\" style=\"border: 0px;\" onclick=\"javascript:del_extention('" . $id . "','" . $nom_box . "');\" /></a></td></tr>";
				$s = 0;
			}
			$i++;
		}
		echo"	</tr></table>";
		$s++;
		echo"	<div style=\"text-align: left; margin-left:9px;\">&nbsp;<img src=\"modules/Espace_membre/images/flech_coch.gif\" alt=\"\" />\n"
			. "<a href=\"#\" onclick=\"setCheckboxes('box', '" . $nb_box . "', true);\">" . _CHECKALL . "</a> / <a href=\"#\" onclick=\"setCheckboxes('box', '" . $nb_box . "', false);\">" . _UNCHECKALL . "</a><br /></div><br />\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _UPDATEEXT . "\" /></div>\n"
			. "</form><br />\n";


		echo"	<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Espace_membre&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}

	function prefs_ext2()
	{
		global $nuked,$language,$bgcolor3,$bgcolor1;


		        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	           . "<div class=\"content-box-header\"><h3>" . _ADMINUPLOAD . "</h3>\n"
	           . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Espace.php\" rel=\"modal\">\n"
	           . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	           . "</div></div>\n"
	           . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Espace_membre&amp;page=admin\"> " . _INDEX . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs\">" . _PREFSS . "</a> | "
	           . "<a href=\"index.php?file=Espace_membre&amp;page=admin&amp;op=prefs_ext\"> " . _PREFEXT . "</a> | "
	           . "</b>" . _PREFEXT2 . "</div><br />\n";

		echo"	<form method=\"post\" action=\"index.php?file=Espace_membre&amp;page=admin&amp;op=add_ext\">\n"
				. "<table style=\"margin-left: auto;margin-right: auto;text-align: left; border: 0px;\" cellspacing=\"0\" cellpadding=\"3\">\n"
				. "<tr>\n"
				. "<td style=\"vertical-align: middle; text-align: center;\">" . _NOMEXT . " :</td><td><input type=\"text\" name=\"nom\" value=\"\" /></td>\n"
				. "</tr>\n"
				. "<tr>\n"
				. "<td style=\"vertical-align: middle; text-align: center;\">" . _ACTIVEREXT . " :</td><td><input type=\"checkbox\" name=\"statu\" value=\"1\" style=\"border: 0px; background-color: $bgcolor3;\" checked /></td>\n"
				. "</tr>\n"
				. "</table>\n"
				. "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _ADDEXT . "\" /></div>\n"
				. "</form>\n"
				. "<br />\n";


		echo"	<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Espace_membre&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
	}


	function add_prefs($nb_img,$galerie,$nb_fichier,$nb_membre,$max_up,$niveau_up,$nb_quotas,$nb_quotas_commun)
	{
		global $nuked,$language,$bgcolor3;

		$upd1 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $nb_img . "' WHERE nom = 'nb_img' ");
		$upd2 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $galerie . "' WHERE nom = 'galerie' ");
		$upd3 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $nb_fichier . "' WHERE nom = 'nb_fichier' ");
		$upd4 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $nb_membre . "' WHERE nom = 'nb_membre' ");
		$upd5 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $max_up . "' WHERE nom = 'max_upload' ");
		$upd6 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $niveau_up . "' WHERE nom = 'niveau_upload' ");
		$upd7 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $nb_quotas . "' WHERE nom = 'nb_quotas' ");
		$upd8 = mysql_query("UPDATE " . ESPACE_MEMBRE_PREFS_TABLE . " SET value = '" . $nb_quotas_commun . "' WHERE nom = 'nb_quotas_commun' ");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _PREFUPDATED . "\n"
				. "</div>\n"
				. "</div>\n";	
		redirect("index.php?file=Espace_membre&page=admin&op=prefs", 2);
	}

	function add_prefs_ext($nom)
	{
		global $nuked,$language,$bgcolor3;

		$sql = mysql_query("SELECT nom FROM " . ESPACE_MEMBRE_STATU_TABLE . "");
		while (list($name) = mysql_fetch_array($sql))
		{
			if($nom[$name] != 1){$nom[$name] = "0";}
			$upd = mysql_query("UPDATE " . ESPACE_MEMBRE_STATU_TABLE . " SET statu = '" . $nom[$name] . "' WHERE nom = '" . $name . "'");
		}
		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _PREFUPDATED . "\n"
				. "</div>\n"
				. "</div>\n";		 
		redirect("index.php?file=Espace_membre&page=admin&op=prefs_ext", 2);
	}

	function add_ext($nom,$statu)
	{
	global $nuked;

		if($nom != "")
		{
			if($statu != 1){$statu = "0";}
			$add=mysql_query("INSERT INTO " . ESPACE_MEMBRE_STATU_TABLE . " VALUES ('' , '" . $nom . "' , '" . $statu . "')");
		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _EXTADD . "\n"
				. "</div>\n"
				. "</div>\n";			
			redirect("index.php?file=Espace_membre&page=admin&op=prefs_ext2", 2);
		}else{
		echo "<div class=\"notification error png_bg\">\n"
				. "<div>\n"
				. "" . _EXTNOADD . "\n"
				. "</div>\n"
				. "</div>\n"			
        . "<div style=\"text-align: center;\">[ <a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a> ]</div>";
		}
	}

	function del_compte($user_id)
	{
		global $nuked,$user,$repertoire;

		$sql=mysql_query("SELECT id FROM $nuked[prefix]" . _users . " WHERE  pseudo='" . $user_id . "' ");
		list($userid) = mysql_fetch_array($sql);

		$del=mysql_query("DELETE FROM " . ESPACE_MEMBRE_TABLE . " WHERE  user_id='" . $userid . "' ");
		$del=mysql_query("DELETE FROM " . ESPACE_MEMBRE_GALERY_TABLE . " WHERE  user_id='" . $userid . "' ");
		if ($rep = @opendir("$repertoire$userid"))
		{
			while ($file = readdir($rep)) 
			{
				if($file != "..") 
				{
					if($file != ".") 
					{  
						@unlink("$repertoire$userid/$file");
					}
				}
			}
		}
		@rmdir("$repertoire$userid");
		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _COMTPEDELETE . "\n"
				. "</div>\n"
				. "</div>\n";			
		redirect("index.php?file=Espace_membre&page=admin",3);
	}

	function del_extention($id,$nom)
	{
		global $nuked,$user,$repertoire;
		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _EXTENTIONDELETE . " <i>" . $nom . "</i> " . _EXTENTIONDELETE2 . "\n"
				. "</div>\n"
				. "</div>\n";			

		$del=mysql_query("DELETE FROM " . ESPACE_MEMBRE_STATU_TABLE . " WHERE id='" . $id . "' ");

		redirect("index.php?file=Espace_membre&page=admin&op=prefs",3);
	}

	switch ($_REQUEST['op'])
	{        	
		case "del_ban":
			admintop();
			del_ban($_REQUEST['id_img'], $_REQUEST['user_id']);
			adminfoot();
		break;	

		case "delete_ban":
			admintop();
			delete_ban($_REQUEST['id_img'], $_REQUEST['user_id']);
			adminfoot();
		break;
	        	
		case "prefs":
			admintop();
			prefs();
			adminfoot();
		break;      
	        	
		case "prefs_ext":
			admintop();
			prefs_ext();
			adminfoot();
		break;      
	        	
		case "prefs_ext2":
			admintop();
			prefs_ext2();
			adminfoot();
		break;   

		case "del_compte":
			admintop();
			del_compte($_REQUEST['user_id']);
			adminfoot();
		break;  

		case "del_extention":
			admintop();
			del_extention($_REQUEST['id'], $_REQUEST['nom']);
			adminfoot();
		break;  
		
		case "add_prefs":
			admintop();
			add_prefs($_REQUEST['nb_img'], $_REQUEST['galerie'], $_REQUEST['nb_fichier'], $_REQUEST['nb_membre'], $_REQUEST['max_up'], $_REQUEST['niveau_up'], $_REQUEST['nb_quotas'], $_REQUEST['nb_quotas_commun']);
			adminfoot();
		break;  
		
		case "add_prefs_ext":
			admintop();
			add_prefs_ext($_REQUEST['nom']);
			adminfoot();
		break;
		
		case "add_ext":
			admintop();
			add_ext($_REQUEST['nom'], $_REQUEST['statu']);
			adminfoot();
		break;
	                    
		default:
			admintop();
			main($_REQUEST['qui']);
			adminfoot();
		break;
	}

} else if ($level_admin == -1) {
?>
	<div class="notification error png_bg">
	<div>
	<br /><br /><div style="text-align: center;"><?php echo MODULEOFF; ?><br /><br /><a href="javascript:history.back()"><b><?php echo BACK; ?></b></a></div><br /><br />
	</div>
	</div>
<?php
} else if ($visiteur > 1) {
?>
	<div class="notification error png_bg">
	<div>
	<br /><br /><div style="text-align: center;"><?php echo NOENTRANCE; ?><br /><br /><a href="javascript:history.back()"><b><?php echo BACK; ?></b></a></div><br /><br />
	</div>
	</div>
<?php
} else {
?>
	<div class="notification error png_bg">
	<div>
	<br /><br /><div style="text-align: center;"><?php echo ZONEADMIN; ?><br /><br /><a href="javascript:history.back()"><b><?php echo BACK; ?></b></a></div><br /><br />
	</div>
	</div>
<?php
}
?>