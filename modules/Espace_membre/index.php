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

    global $language, $user, $nuked;

    /* inclusion du fichier langue */
    translate('modules/Espace_membre/lang/' . $language . '.lang.php');

    /* Constant pour les tables */
	define('ESPACE_MEMBRE_TABLE', $nuked['prefix'] . '_espace_membre');
	define('ESPACE_MEMBRE_PREFS_TABLE', $nuked['prefix'] . '_espace_membre_prefs');
	define('ESPACE_MEMBRE_COMMUN_TABLE', $nuked['prefix'] . '_espace_membre_commun');
	define('ESPACE_MEMBRE_STATU_TABLE', $nuked['prefix'] . '_espace_membre_statu');
	define('ESPACE_MEMBRE_GALERY_TABLE', $nuked['prefix'] . '_espace_membre_galerie');

$visiteur = (!$user) ? 0 : $user[1];
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{ 
	$repertoire = 'upload/Espace_membre/Perso/';
	$rep_comun = 'upload/Espace_membre/Commun/';
	$rep = $repertoire.$user[0]."/";

	$sql_prefs = mysql_query("SELECT * FROM " . ESPACE_MEMBRE_PREFS_TABLE);
	while ($row = mysql_fetch_array($sql_prefs)){$prefs[$row['nom']] = $row['value'];} 

	$nb_quotas = $prefs[nb_quotas];
	$nb_quotas_commun = $prefs[nb_quotas_commun];
	$nb_fichier = $prefs[nb_fichier];
	$nb_membre = $prefs[nb_membre];
	$nb_img = $prefs[nb_img];
	$galerie_adm = $prefs[galerie];
	$niveau_upload = $prefs[niveau_upload];
	$max_upload = $prefs[max_upload];


	function main($membre)
	{
		global $nuked, $user, $language, $bgcolor3, $bgcolor2, $bgcolor1, $repertoire, $p, $nb_fichier, $rep_comun, $niveau_upload, $galerie_adm;
		

		echo '<script type="text/javascript"><!--'."\n"
		. 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
		. '--></script>'."\n"
		. '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
		. '<script type="text/javascript">'."\n"
		. 'Shadowbox.init();'."\n"
		. '</script>'."\n";

		/////////////// AFFICHAGE DU MENU SI NIVEAU = NIVEAU UPLOAD AUTORISER ///////////////////////
		if($galerie_adm == 'on' && $user[1] >= $niveau_upload){ 
			$pref = '| <a href="index.php?file=Espace_membre&amp;op=prefs"><b>'._PREFMEMBRE.'</b></a><br />'; 
			$compte = '| <a href="index.php?file=Espace_membre&amp;op=compte"><b>'._COMPTE.'</b></a>';
		}

		///////////////// AFFICHAGE DU MENU DEROULANT SI GALERIE AUTORISER PAR ADMIN ////////////////////
		if ($rep = @opendir($repertoire)){
			while ($file = readdir($rep)) {
				if($file != "..") {
					if($file != ".") {  
						$file_name= str_replace("/", "", $file);
						$sql=mysql_query("SELECT user_id FROM ".ESPACE_MEMBRE_GALERY_TABLE." WHERE user_id ='".$file_name."' AND  value ='on' AND user_id !='".$user[0]."' ");
						while(list($id_galerie) = mysql_fetch_array($sql))
						{
							$sql=mysql_query("SELECT pseudo FROM ". USER_TABLE . " WHERE  id='" . $id_galerie . "' ");
							while(list($pseu) = mysql_fetch_array($sql))
							{
								$content="<option value=\"".$pseu."\">".$pseu."</option>";
							}
						}
					}
				}
			}
		}

		if($galerie_adm == "on" && $file_name !="" && $file_name != $user[0])
		{
			$menuselect='	<div align="center"><b>'._SELECTMEMBRE2.'</b></div>
							<form method="post" action="index.php?file=Espace_membre" enctype="multipart/form-data" />
							<table style="width: 100%;" cellspacing="0" cellpadding="2">
								<tr>
									<td style="text-align: center;"><select name="membre" onchange="submit();"><option value="">'._COMMUN.'</option>'.$content.'</select></td>
								</tr>
							</table>
							</form><br />';
		}
		/////////////////////////////////////////////////////////// FIN AFFICHAGE MENU DEROULANT //////////////////////////////////////

		//********************************************************//
		//           GALERIE COMMUNE		  //
		//********************************************************//
		if($membre == "")
		{
			echo"	<script type=\"text/javascript\">
			<!--
			function del(id_img,fichier)
			{
				if (confirm('"._DELETEFICHIER." '+fichier+' ?   '))
				{
					document.location.href ='index.php?file=Espace_membre&op=delete_commun&id_img='+id_img;
				}
			}
			// -->
			</script>";

			$sql_nbnews = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_COMMUN_TABLE);
			$nb_news = mysql_num_rows($sql_nbnews);
			$url = "index.php?file=Espace_membre&amp;membre=".$membre;

			if (!$p) $p = 1;
			$start = $p * $nb_fichier - $nb_fichier;

			$sql_membre = mysql_query("SELECT id FROM ". USER_TABLE . " WHERE pseudo='".$membre."' ");
			list($id) = mysql_fetch_array($sql_membre);
			
			if($nb_news != "")
			{
				$where = "ORDER BY date AND pseudo DESC LIMIT ".$start." ,  ".$nb_fichier;
			}

			echo "	<span style=\"float: right\"><a href=\"#\" onclick=\"javascript:window.open('help/" . $language . "/Espace_membre.php','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\"><img style=\"border: 0;\" src=\"modules/Espace_membre/images/help.png\" alt=\"\" onmouseover=\"AffBulle('" . _HELP . "', '" . _OUVRIRHELP."', 180)\" onmouseout=\"HideBulle()\" /></a></span>
				<div style=\"text-align: center;\"><big><b>"._UPLOAD."</b></big><br /><br /><small><i>"._FILELIST."</i></small><br /><br /></div>
				<div style=\"text-align: center;\">" . _INDEX . " " . $view_galerie . " " . $compte . " " . $pref . "</b><br /><br /></div>
				".$menuselect."
				<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
					<tr style=\"background-color: $bgcolor3;\">
						<td style=\"text-align: center;\"><b>" . _TYPE . "</b></td>
						<td style=\"text-align: center;\"><b>"._FILENAME."</b></td>
						<td style=\"text-align: center;\"><b>"._DATEUPLOAD."</b></td>
						<td style=\"text-align: center;\"><b>". _POIDS . "</b></td>
						<td style=\"text-align: center;\"><b>"._BY."</b></td>
					</tr>";

			$sql = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_COMMUN_TABLE);
			while(list($id_img) = mysql_fetch_array($sql))

			if($nb_news != 0)
			{
				$sql_id = mysql_query("SELECT id, user_id, pseudo, fichier, date FROM ".ESPACE_MEMBRE_COMMUN_TABLE." WHERE id='".$id_img."' ");
				list($id, $user_id, $pseudo, $fichier, $date) = mysql_fetch_array($sql_id);

				$date = nkDate($date);
				$ext = substr(strrchr($fichier,"."),1);
				$fichier_split = eregi_replace("." . $ext, "", $fichier);
					
				$id_fichier = $rep_comun."/".$fichier;
				$filesize = filesize($id_fichier)/1024;
				$poids=ceil($filesize);

				if (eregi("jpg", $ext) || eregi("png", $ext) || eregi("gif", $ext) || eregi("bmp", $ext))
				{
					$links = "<a href=\"".$rep_comun.$fichier."\" rel=\"shadowbox\" onmouseover=\"AffBulle('" . _HELP . "', '"._VIEWFILE2." " . $fichier . "', 180)\" onmouseout=\"HideBulle()\">".$fichier_split."</a>";
				}else{
					$links = "<a href=# onclick=\"javascript:window.open('".$rep_comun.$fichier."','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0');return(false)\" onmouseover=\"AffBulle('" . _HELP . "', '"._DOWNFILE." " . $fichier . "', 180)\" onmouseout=\"HideBulle()\">".$fichier_split."</a>";
				}	

				$typename = "<img src=\"modules/Espace_membre/images/" . $ext . ".gif\" alt=\"\"  onmouseover=\"AffBulle('" . _HELP . "', '" . _FICHIER . " " . $ext . "', 100)\" onmouseout=\"HideBulle()\" style=\"border: 0px;\" />";
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
				echo "<tr style=\"background: " . $bg . ";\">
						<td style=\"text-align: center;\">" . $typename . "</td>
						<td style=\"text-align: center;\">" . $links . "</td>
						<td style=\"text-align: center;\">" . $date . "</td>
						<td style=\"width: 25%;\" align=\"center\"> ~ " . $poids . " ko</td>
						<td style=\"text-align: center;\">" . $pseudo . "</td>
					</tr>";
			}
			echo "	</table><br />";
			if($id == ""){echo"<div style=\"text-align: center;\">" . _NOFICHIERINDB . "</div>";}
			if ($nb_news > $nb_fichier){number($nb_news, $nb_fichier, $url); echo"<br />";}
			
		echo "	<br /><div style=\"text-align: center;\">
			<br /><input type=\"button\" onclick=\"document.location='index.php?file=Espace_membre&amp;op=post_fichier'\" value=\"" . _POSTFILE . "\" /><br /><br /></div>";

		//********************************************************//
		//           GALERIE PERSO			  //
		//********************************************************//
		}else{
			echo"	<script type=\"text/javascript\">
				<!--
				function del(id_img,fichier)
				{
					if (confirm('"._DELETEFICHIER." '+fichier+' ?   '))
					{
						document.location.href ='index.php?file=Espace_membre&op=delete&id_img='+id_img;
					}
				}
				// -->
				</script>";

			if($galerie_adm == "on")
			{
				$sql_nbnews = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_TABLE." WHERE pseudo='" . $membre . "'  ");
				$nb_news = mysql_num_rows($sql_nbnews);
				$url = "index.php?file=Espace_membre&amp;membre=" . $membre;
				
				if (!$p) $p = 1;
				$start = $p * $nb_fichier - $nb_fichier;

				if($nb_news != "")
				{
					$where = "ORDER BY date DESC LIMIT ".$start." ,  ".$nb_fichier."";
				}
					$members ="WHERE pseudo='" . $membre . "' ";

				echo "<span style=\"float: right\"><a href=\"#\" onclick=\"javascript:window.open('help/" . $language . "/Espace_membre.php','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\"><img style=\"border: 0;\" src=\"modules/Espace_membre/images/help.png\" alt=\"\" onmouseover=\"AffBulle('" . _HELP . "', '" . _OUVRIRHELP."', 180)\" onmouseout=\"HideBulle()\" /></a></span>				
						<div style=\"text-align: center;\"><big><b>"._GALERIEDE." " . $membre . "</b></big><br /><br /></div>
						<div style=\"text-align: center;\"><b><a href=\"index.php?file=Espace_membre\">" . _INDEX . "</a></b> " . $compte . " " . $pref . "<br /><br /></div>
						".$menuselect."
						<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
							<tr style=\"background-color: $bgcolor3;\">
								<td style=\"text-align: center;\"><b>" . _TYPE . "</b></td>
								<td style=\"text-align: center;\"><b>" . _FILENAME . "</b></td>
								<td style=\"text-align: center;\"><b>" . _DATEUPLOAD . "</b></td>
								<td style=\"text-align: center;\"><b>" . _POIDS . "</b></td>
							</tr>";

					$sql = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_TABLE." " . $members . " " . $where . "");
					while(list($id_img) = mysql_fetch_array($sql))

					if($nb_news != 0)
					{

					$sql_id = mysql_query("SELECT id, user_id, pseudo, fichier, date FROM ".ESPACE_MEMBRE_TABLE." WHERE id='" . $id_img . "' ");
					list($id,$user_id,$pseudo,$fichier,$date) = mysql_fetch_array($sql_id);

					$date = nkDate($date);
					$ext = substr(strrchr($fichier,"."),1);
					$fichier_split = eregi_replace("." . $ext, "", $fichier);
						
						$id_fichier = $repertoire.$user_id."/".$fichier;
						$filesize = filesize($id_fichier)/1024;
						$poids=ceil($filesize);


						if (eregi("jpg", $ext) || eregi("png", $ext) || eregi("gif", $ext) || eregi("bmp", $ext))
						{
							$links = "<a href=\"".$repertoire.$user_id."/".$fichier."\" rel=\"shadowbox\" onmouseover=\"AffBulle('" . _HELP . "', '"._VIEWFILE2." " . $fichier . "', 180)\" onmouseout=\"HideBulle()\">".$fichier_split."</a>";
						}else{
							$links = "<a href=# onclick=\"javascript:window.open('".$repertoire.$user_id."/".$fichier."','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0');return(false)\"  onmouseover=\"AffBulle('" . _HELP . "', '"._DOWNFILE." " . $fichier . "', 180)\" onmouseout=\"HideBulle()\">".$fichier_split."</a>";
						}

						$typename = "<img src=\"modules/Espace_membre/images/" . $ext . ".gif\" alt=\"\"  onmouseover=\"AffBulle('" . _HELP . "', '" . _FICHIER . " " . $ext . "', 100)\" onmouseout=\"HideBulle()\" style=\"border: 0px;\" />";

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

						echo "	<tr style=\"background: " . $bg . ";\">
								<td style=\"text-align: center;\">" . $typename . "</td>
								<td style=\"text-align: center;\">" . $links . "</td>
								<td style=\"text-align: center;\">" . $date . "</td>
								<td style=\"width: 25%;\" align=\"center\"> ~ " . $poids . " ko</td>
							</tr>";
					}
				echo "	</table><br />";
					if($id == ""){
						echo"<div style=\"text-align: center;\">" . _NOFICHIERINDB . "</div>";
					}

					if ($nb_news > $nb_fichier){
						number($nb_news, $nb_fichier, $url); 
						echo"<br />";
					}
				}else{
					echo"	<div style=\"text-align: center;\"><br /><br /><big>" . _GALERIEFERMER . "</big></div>";
				}
			echo"	<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Espace_membre\"><b>" . _BACK . "</b></a> ]<br /><br /></div>";
		}
	}

	///////////////////////////////////////////// POST FICHIER  /////////////////////////////////////////////
	function post_fichier($mog)
	{
		global $rep_comun, $user, $nuked, $language, $niveau_upload, $galerie_adm, $max_upload;

		if($user[1] < $niveau_upload)
		{
			echo" <div style=\"text-align: center;\">"._NOTACCES."</div>";
		}
		else if($galerie_adm ="on")
		{

			if(isset($max_filesize) && $max_filesize != "" && $max_upload >= $max_size){
				$max_size = str_replace("M", "", $max_filesize);
				$max_file_size = $max_size * 1000000; 
			}else{
				$max_size = $max_upload;
				$max_file_size = $max_upload * 1000000; 
			}

			if($mog == "")
			{
			 	$doss = ""; 
			} else {
			 	$doss = "<input type=\"hidden\" name=\"dossier\" value=\"1\" />";
			}

		echo"	<div style=\"text-align: center;\"><br /><big><b>"._POSTFILE." ".$dossier."</big></b><br /><br />
			<small><i>"._MAXSIZE." ".$max_size." Mo</i></small><br /><br />
			<form name=\"input\" action=\"index.php?file=Espace_membre&amp;op=do_post\" method=\"post\" enctype=\"multipart/form-data\"> 
			<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$max_file_size."\" /> 
			<input type=\"file\" name=\"userfile\" size=\"40\" maxlength=\"80\" />
			<br /><br />
			".$doss."
			<br /><br /><input type=\"submit\" value=\""._SEND."\" /><input type=\"button\" value=\""._CANCEL."\" onclick=\"javascript:history.back()\" />
			</form><br /></div>";
		}else{

		echo"	<div style=\"text-align: center;\"><br /><br /><big>" . _GALERIEFERMER . "</big></div>";

		}
	}

	///////////////////////////////////////////// ENVOI FICHIER ////////////////////////////////////////
	function do_post($userfile, $dossier)
	{
	global $nuked, $user, $repertoire, $language, $rep_comun, $rep, $nb_quotas, $nb_quotas_commun, $max_upload;

	$date = time();
	if($dossier != "1"){ $fichier = $rep_comun; }else{ $fichier = $rep; }
	if($dossier == "1"){ $quot = $nb_quotas; }else{ $quot = $nb_quotas_commun; }

	////////////////// REQUETE QUOTAS //////////
	$repert = $repertoire .$user[0] . "/";
	$handle = @opendir($repert);
	while (false != ($file = @readdir($handle)))
	{
		$path = $repert . $file;
		$total += ceil(filesize($path)/1024);
	} 

	$nb_quot = $quot * 1000;
	$quotas = $nb_quot - $total;
	$quotas_mo = $quotas / 1000;
	$maxsize = $_FILES['userfile']['size'] / 1000;
	//////////// FIN REQUETE QUOTAS ///////////

	//////////////////// REMPLACEMENT LETTRE NON AUTORISER ///////////////////////
	$filename = $_FILES['userfile']['name'];
	$a = "¿¡¬√ƒ≈‡·‚„‰Â“”‘’÷ÿÚÛÙıˆ¯»… ÀËÈÍÎ«ÁÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸ˇ—Ò";
	$b = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	$filename = str_replace(" ", "_", $filename);
	$filename = strtr($filename, $a, $b);
	$filename = strtolower($filename); 
	$f = explode(".", $filename);
	$end = count($f) - 1;
	$ext = $f[$end];
	$fichier_split = eregi_replace("." . $ext, "", $filename);
	$fichier_split = str_replace(".", "_", $fichier_split);
	/////////////////////////////////// FIN DE REMPLACEMET ///////////////////////////////////////

	$sql = mysql_query("SELECT statu FROM ".ESPACE_MEMBRE_STATU_TABLE." WHERE nom='" . $ext . "'  ");
	list($statu) = mysql_fetch_array($sql);

	if($dossier == "1")
	{
		$who = ESPACE_MEMBRE_TABLE;
	}else{
		$who = ESPACE_MEMBRE_COMMUN_TABLE;
	}

	$sql_fich = mysql_query("SELECT fichier FROM ".$who." WHERE fichier = '" . $filename . "'  ");
	$existe_fichier = mysql_num_rows($sql_fich);

	if($_FILES['userfile']['name'] != "" && $quotas_mo < $nb_quot)
	{
		if($statu == 1)
		{
			if($existe_fichier == 0)
			{
				if(isset($userfile)) 
				{ 
					$html = "modules/Espace_membre/images/index.html";
					$htm = "$fichier/index.html";
					if (eregi("php", $ext) || eregi("htm", $ext) || eregi("vb", $ext)) $ext = "txt";
					
					@mkdir("$fichier",0777);				
					copy($html, $htm);
					move_uploaded_file($_FILES['userfile']['tmp_name'], $fichier . $fichier_split.".".$ext);
					$add=mysql_query("INSERT INTO $who VALUES ('' , '".$user[0]."' , '".$user[2]."' , '".$fichier_split.".".$ext."' , '".$date."')");

					echo "	<div style=\"text-align: center;\"><br /><br />" . _FILESENT . "<br /><br /></div>";
					if($dossier != "1"){redirect("index.php?file=Espace_membre",2);}else{redirect("index.php?file=Espace_membre&op=compte",2);}
				}else{
					echo"<div style=\"text-align: center;\">" . _UPLOADFAILED . "</div>";
				}
			}else{
				echo"	<div style='width: 100%; text-align: center;'>" . _ALREADYEXIST . " " . $fichier_split . "." . $ext . " " . _ALREADYEXIST2 . "<br />" . _ALREADYEXIST3 . "<br /><br /><a href='javascript:history.back()'><b>"._BACK."</b></a></div>";
			}
		}else{
			echo"	<div style='width: 100%; text-align: center;'>"._UPLOADOFF." $ext <br /> "._UPLOADOFF2."<br /><br /><a href='javascript:history.back()'><b>"._BACK."</b></a></div>";
		}
	}else{
		echo"	<div style=\"text-align: center;\">" . _FICHIERNOADD . "<br />" . _TAILLEDEPASSER . "<br />" . _QUOTASDEPASSER . "<br /></div>
			<div style=\"text-align: center;\"><br /><a href='javascript:history.back()'><b>"._BACK."</b></a></div>";
	}
	}

	////////////////////////////////////////////// COMPTE PERSO //////////////////////////////////////////////
	function compte()
	{
		global $nuked, $user, $bgcolor3, $bgcolor2, $bgcolor1, $language, $repertoire, $rep, $p, $niveau_upload, $galerie_adm, $nb_quotas, $nb_fichier;
		
		echo '<script type="text/javascript"><!--'."\n"
		. 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
		. '--></script>'."\n"
		. '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
		. '<script type="text/javascript">'."\n"
		. 'Shadowbox.init();'."\n"
		. '</script>'."\n";

		$repert = $repertoire .$user[0] . "/";
		$handle = @opendir($repert);

		while (false != ($file = @readdir($handle)))
		{
			$path = $repert . $file;
			$total += ceil(filesize($path)/1024);
		} 

		$nb_quot = $nb_quotas * 1000;
		$quotas = $nb_quot - $total;
		$quotas_mo = $quotas / 1000;

		if($user[1] >= $niveau_upload)
		{
			echo"	<script type=\"text/javascript\">
				<!--
				function del(id_img,fichier)
				{
					if (confirm('"._DELETEFICHIER." '+fichier+' ?   '))
					{
						document.location.href ='index.php?file=Espace_membre&op=delete&id_img='+id_img;
					}
				}
				// -->
				</script>";

			$sql_nbnews = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_TABLE." WHERE user_id='" . $user[0] . "' ");
			$nb_news = mysql_num_rows($sql_nbnews);
			$url = "index.php?file=Espace_membre";

			if (!$p) $p = 1;
			$start = $p * $nb_fichier - $nb_fichier;

			if($nb_news != "")
			{
				$where = " DESC LIMIT " . $start . " ,  " . $nb_fichier . "";
			}

			if($galerie_adm == "on" && $user[1] >= "$niveau_upload"){$pref = "| <a href=\"index.php?file=Espace_membre&amp;op=prefs\">" . _PREFMEMBRE . "</a>";}
			if($galerie_adm == "on" && $user[1] >= "$niveau_upload"){$compte = "| " . _COMPTE . "";}

		echo"	<span style=\"float:right;\"><a href=\"#\" onclick=\"javascript:window.open('help/" . $language . "/Espace_membre.php','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
			<img style=\"border: 0px;\" src=\"modules/Espace_membre/images/help.png\" alt=\"\" onmouseover=\"AffBulle('" . _HELP . "', '" . _OUVRIRHELP."', 180)\" onmouseout=\"HideBulle()\" /></a></span>
			<div style=\"text-align: center;\"><big><b>"._GESTIONCOMPTEUPLOAD."</b></big><br /><br /></div>
			<div style=\"text-align: center;\"><b><a href=\"index.php?file=Espace_membre\">" . _INDEX . "</a> " . $view_galerie . " </b>" . $compte . "<b> " . $pref . "</b><br /><br /></div>
			<div style=\"text-align: center;\">" . _QUOTAS . " : " . $quotas_mo . " " . _MO . "<br /><br /></div>
			<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
				<tr style=\"background-color: $bgcolor3;\">
					<td style=\"text-align: center;\"><b>"._TYPE."</b></td>
					<td style=\"text-align: center;\"><b>" . _FILENAME . "</b></td>
					<td style=\"text-align: center;\"><b>"._DATEUPLOAD."</b></td>
					<td style=\"text-align: center;\"><b>" . _POIDS . "</b></td>
					<td style=\"text-align: center;\"><b>"._DELETETHISFILE ."</b></td>
				</tr>";

			$sql = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_TABLE." WHERE user_id='".$user[0]."' ORDER BY date ".$where);
			while(list($id_img) = mysql_fetch_array($sql))

				if($nb_news != 0)
				{
				$sql_id = mysql_query("SELECT id,fichier,date FROM ".ESPACE_MEMBRE_TABLE." WHERE id='" . $id_img . "' ");
				list($id,$fichier,$date) = mysql_fetch_array($sql_id);

				$date = nkDate($date);
				$ext = substr(strrchr($fichier,"."),1);
				$fichier_split = eregi_replace("." . $ext, "", $fichier);
				
				$id_fichier = $rep."/".$fichier;
				$filesize = filesize($id_fichier)/1024;
				$poids=ceil($filesize);

				if($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "bmp" || $ext == "BMP" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG")
				{
					$links = "<a href=\"".$repertoire . "" . $user[0] . "/" . $fichier."\" rel=\"shadowbox\" onmouseover=\"AffBulle('" . _HELP . "', '"._VIEWFILE2." " . $fichier . "', 180)\" onmouseout=\"HideBulle()\">".$fichier_split."</a>";
				}else{
				  	$links = "<a href=# onclick=\"javascript:window.open('" . $repertoire . "" . $user[0] . "/" . $fichier_sp . "','popup','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0');return(false)\" alt=\"\" onmouseover=\"AffBulle('" . _HELP . "', '"._DOWNFILE." " . $fichier . "', 180)\" onmouseout=\"HideBulle()\">" . $fichier_split . "</a>";
				}
						
				$typename = "<img src=\"modules/Espace_membre/images/" . $ext . ".gif\" alt=\"\"  onmouseover=\"AffBulle('" . _HELP . "', '" . _FICHIER . " " . $ext . "', 100)\" onmouseout=\"HideBulle()\" style=\"border: 0px;\" />";

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

			echo "	<tr style=\"background: " . $bg . ";\">
					<td style=\"text-align: center;\">" . $typename . "</td>
					<td style=\"text-align: center;\">" . $links . "</td>
					<td style=\"text-align: center;\">" . $date . "</td>
					<td style=\"width: 25%;\" align=\"center\"> ~ " . $poids . " ko</td>
					<td style=\"text-align: center;\"><a href=\"javascript:del('" . $id_img . "','" . $fichier . "');\"><img src=\"modules/Espace_membre/images/del.png\" style=\"border: 0px;\" alt=\"\" onmouseover=\"AffBulle('" . _HELP . "', '"._DEL." " . $fichier . " ?', 150)\" onmouseout=\"HideBulle()\" /></a></td>
				</tr>";
				}
			echo "	</table>";
				if($id == ""){echo"<div style=\"text-align: center;\">" . _NOFICHIERINDB . "</div>";}
				if ($nb_news > $nb_fichier){echo "&nbsp;";number($nb_news, $nb_fichier, $url);

				echo "<br />";
			}
		echo "	<br /><div style=\"text-align: center;\">
			<br /><input type=\"button\" onclick=\"document.location='index.php?file=Espace_membre&amp;op=post_fichier&mog=perso'\" value=\"" . _POSTFILE . "\" /></div>";

		echo"	<div style=\"text-align: center;\"><br /><br />[ <a href=\"index.php?file=Espace_membre\"><b>" . _BACK . "</b></a> ]</div>";

		}else{
			echo"	<div style=\"text-align: center;\"><br /><br /><b>" . _NOTACCES . "</b><br /><br /></div>";
			redirect("index.php?file=Espace_membre", 3);
		}
	}

	///////////////////////////// SUPPRESSION IMAGE PERSO DANS DOSSIER PERSO ////////////////////////////
	function delete($id_img)
	{
		global $nuked, $user, $language, $repertoire, $niveau_upload, $galerie_adm, $nb_quotas;

		if($user[1] >= $niveau_upload)
		{
			$sql=mysql_query("SELECT fichier FROM ".ESPACE_MEMBRE_TABLE." WHERE id = '".$id_img."' ");
			list($fichier) = mysql_fetch_array($sql);

			$img = $repertoire."/".$user[0]."/".$fichier;

			$del=mysql_query("DELETE FROM ".ESPACE_MEMBRE_TABLE." WHERE  id='".$id_img."' ");
			@unlink($img);
			echo"	<div style=\"text-align: center;\"><br /><br /><b>"._IMGDELETE."</b><br /><br /></div>";

			redirect("index.php?file=Espace_membre&op=compte",3);
		}else{
			echo"	<div style=\"text-align: center;\"><br /><br /><b>" . _NOTACCES . "</b><br /><br /></div>";
			redirect("index.php?file=Espace_membre", 3);
		}
	}

	///////////////////////////// SUPPRESSION IMAGE PERSO DANS DOSSIER COMMUN ////////////////////////////
	function delete_commun($id_img)
	{
		global $nuked, $user, $language, $rep_comun, $niveau_upload, $galerie_adm, $nb_quotas;

		$sql = mysql_query("SELECT fichier FROM ".ESPACE_MEMBRE_COMMUN_TABLE." WHERE id = '" . $id_img . "' ");
		list($fichier) = mysql_fetch_array($sql);

		$img = $rep_comun.$fichier;
	echo $id_img;
		$del=mysql_query("DELETE FROM ".ESPACE_MEMBRE_COMMUN_TABLE." WHERE  id='".$id_img."' ");
		@unlink($img);
		echo"	<div style=\"text-align: center;\"><br /><br /><b>"._IMGDELETE."</b><br /><br /></div>";

		redirect("index.php?file=Espace_membre",3);
	}

	////////////////////////////////////////////////// PREFERENCES COMPTE PERSO //////////////////////////////////////////////
	function prefs()
	{
		global $nuked, $user, $language, $repertoire, $niveau_upload, $galerie_adm, $nb_quotas;

		if($user[1] >= "$niveau_upload")
		{
			echo"	<script type=\"text/javascript\">
				<!--
				function del_compte(qui,fichier)
				{
				if (confirm('"._DELETEYOURCOMPTE." '+fichier+' ?   '))
				{document.location.href ='index.php?file=Espace_membre&op=del_compte';}
				}
				// -->
				</script>";

			$sql = mysql_query("SELECT value FROM ".ESPACE_MEMBRE_GALERY_TABLE." WHERE user_id='" . $user[0] . "'  ");
			list($nb_img) = mysql_fetch_array($sql);

			$sql_nbnews = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_TABLE." WHERE pseudo='" . $membre . "'  ");
			$nb_news = mysql_num_rows($sql_nbnews);
				
			if($galerie_adm == "on" && $user[1] >= $niveau_upload){$pref = "| " . _PREFMEMBRE . "";}
			if($galerie_adm == "on" && $user[1] >= $niveau_upload){$compte = "| <a href=\"index.php?file=Espace_membre&amp;op=compte\">" . _COMPTE . "</a>";}

			if($nb_img == "on"){$selected = "selected";}
			if($nb_img == "off"){$selected2 = "selected";}

			$repert = $repertoire.$user[0] . "/";
			$handle = @opendir($repert);
			while (false != ($file = @readdir($handle)))
			{
			$path = $repert . $file;
			$total += ceil(filesize($path)/1024);
			} 
			$nb_quot = $nb_quotas * 1000;
			$quotas = $nb_quot - $total;
			$quotas_mo = $quotas / 1000;

			if (function_exists('rmdir') && $nb_news != 0) {$rmdir="<tr><td style=\"text-align: right;\">" . _DELCOMPTE . " :</td><td> <input type=\"button\" value=\"" . _DELETE . "\" onclick=\"javascript:del_compte('".$qui."','".$fichier."');\" /></td></tr>";}

			echo" 	<span style=\"float:right;\"><a href=\"#\" onclick=\"javascript:window.open('help/" . $language . "/Espace_membre.php','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
				<img style=\"border: 0;\" src=\"modules/Espace_membre/images/help.png\" alt=\"\" onmouseover=\"AffBulle('" . _HELP . "', '" . _OUVRIRHELP."', 180)\" onmouseout=\"HideBulle()\" /></a></span>
				<div style=\"text-align: center;\"><big><b>"._MEMBREPREF."</b></big><br /><br /></div>
				<div style=\"text-align: center;\"><b><a href=\"index.php?file=Espace_membre\">" . _INDEX . "</a> " . $compte . "</b> " . $pref . "<br /><br /></div>
				<form method=\"post\" action=\"index.php?file=Espace_membre&amp;op=add_prefs\" enctype=\"multipart/form-data\" />\n"
				. "<br /><table style=\"margin-left: auto;margin-right: auto; border: 0px; width: 100%;\" cellspacing=\"0\" cellpadding=\"5\">\n"
				. "<tr><td style=\"text-align: right; width: 35%;\">" . _QUOTAS2 . " :</td><td style=\"text-align: left; width: 65%;\">" . $quotas_mo . " " . _MO . " " . _LIBRE . " " . _SUR . " " . $nb_quotas . " " . _MO . " " . _AUTORISER . "</td>\n"
				. "</table><table style=\"margin-left: auto;margin-right: auto; border: 0px; width: 100%;\" cellspacing=\"0\" cellpadding=\"5\">\n"
				. "<tr><td style=\"text-align: right; width: 50%;\">" . _NBGALERIE2 . " :</td><td style=\"text-align: left; width: 50%;\"> <select name=\"galerie\"><option value=\"\" />"._CHOOSEOPTION."</option><option value=\"on\" $selected />"._ACTIVER."</option><option value=\"off\" $selected2 />"._DESACTIVER."</option></td></tr>\n"
				. "$rmdir\n"
				. "</table><div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _SEND . "\" /></div>\n"
				. "</form><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Espace_membre\"><b>" . _BACK . "</b></a> ]<br /><br /></div>\n";
		}else{
			echo"	<div style=\"text-align: center;\"><br /><br /><b>" . _NOTACCES . "</b><br /><br /></div>";
			redirect("index.php?file=Espace_membre", 3);
		}
	}

	////////////////////////////////////////////// AJOUT DES PREFERENCES PERSO ////////////////////////////////////////
	function add_prefs($galerie)
	{
		global $nuked, $user, $language, $niveau_upload;
		if($user[1] >= $niveau_upload)
		{
			$sql = mysql_query("SELECT id FROM ".ESPACE_MEMBRE_GALERY_TABLE." WHERE user_id='" . $user[0] . "'  ");
			$test = mysql_num_rows($sql);
			if($test == 0)
			{
				$add=mysql_query("INSERT INTO ".ESPACE_MEMBRE_GALERY_TABLE." VALUES ('' , '" . $user[0] . "' , '" . $galerie . "' )");
			}else{
				$upd1 = mysql_query("UPDATE ".ESPACE_MEMBRE_GALERY_TABLE." SET value = '" . $galerie . "' WHERE user_id = '" . $user[0] . "' ");
			}
			echo "	<div style=\"text-align: center;\"><br /><br />" . _PREFUPDATED . "<br /><br /></div>";
			redirect("index.php?file=Espace_membre&op=compte", 2);
		}else{
			echo"	<div style=\"text-align: center;\"><br /><br /><b>" . _NOTACCES . "</b><br /><br /></div>";
			redirect("index.php?file=Espace_membre", 3);
		}
	}

	///////////////////////////////////////////// SUPPRESSION DU COMPTE PERSO ///////////////////////////////////////////
	function del_compte()
	{
		global $nuked, $user, $language, $repertoire;

		if($user[1] >= "1")
		{
			$del=mysql_query("DELETE FROM ".ESPACE_MEMBRE_TABLE." WHERE  user_id='".$user[0]."' ");
			$del=mysql_query("DELETE FROM ".ESPACE_MEMBRE_GALERY_TABLE." WHERE  user_id='".$user[0]."' ");

			if ($rep = @opendir($repertoire.$user[0]))
			{
				while ($file = readdir($rep)) 
				{
					if($file != "..") 
					{
						if($file != ".") 
						{  
							@unlink($repertoire.$user[0]."/".$file);
						}
					}
				}
			}
			@rmdir($repertoire.$user[0]);
			echo"<div style=\"text-align: center;\"><br /><br /><b>"._COMTPEDELETE."</b><br /><br /></div>";
			redirect("index.php?file=Espace_membre",3);
		}else{
			echo"	<div style=\"text-align: center;\"><br /><br /><b>" . _NOTACCES . "</b><br /><br /></div>";
			redirect("index.php?file=Espace_membre", 3);
		}
	}

	///////////////////////////// SWITCH OP /////////////////////////////

	switch ($_REQUEST['op'])
	{
		case "post_fichier":
			opentable();
				post_fichier($_REQUEST['mog']);
			closetable();
		break;	

		case "compte":
			opentable();
				compte();
			closetable();
		break;

		case "main":
			opentable();
				main($_REQUEST['membre']);
			closetable();
		break;

		case "do_post":
			opentable();
				do_post($_FILES['userfile'],$_REQUEST['dossier']);
			closetable();
		break;

		case "prefs":
			opentable();
				prefs();
			closetable();
		break;         
		
		case "add_prefs":
			opentable();
				add_prefs($_REQUEST['galerie']);
			closetable();
		break;

		case "delete":
			opentable();
				delete($_REQUEST['id_img']);
			closetable();
		break;

		case "delete_commun":
			opentable();
				delete_commun($_REQUEST['id_img']);
			closetable();
		break;

		case "del_compte":
			opentable();
				del_compte();
			closetable();
		break;
	                       
		default:
			opentable();
				main($_REQUEST['membre']);
			closetable();
		break;
	      }

}
else if ($level_access == -1)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
}
else if ($level_access == 1 && $visiteur == 0)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b><br /><br /></div>";
    closetable();
}
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
}

?>