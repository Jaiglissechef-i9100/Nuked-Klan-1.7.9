<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined("INDEX_CHECK") or die ("<div class=\"centre\">You cannot open this page directly</div>");

translate("modules/FileEditor/lang/" . $language . ".lang.php");

?>
<style type="text/css">
  @import url('modules/FileEditor/css/style.css');
</style>

<script type="text/javascript">
function fsubmit(dossier, fichier, supprime, renomme, newfolder, newfile, save)
{
	if (dossier != '')
	{
		document.forms['formulaire'].NOM_DOSSIER.value=dossier;
	}
	if (fichier != '')
	{
		document.forms['formulaire'].NOM_FICHIER.value=fichier;
	}
	if (supprime != '')
	{
		document.forms['formulaire'].SUPPR.value=supprime;
	}
	if (renomme != '')
	{
		var name = prompt('<?php echo _RENAMEFILE; ?>',renomme)
		document.forms['formulaire'].RENOM_FICHIER.value=name;
	}
	if (newfolder != '')
	{
		var name = prompt('<?php echo _NEWFOLDER; ?>',newfolder)
		if (name) document.forms['formulaire'].NEW_FOLDER.value=name;
		else return false;
	}
	if (newfile != '')
	{
		var name = prompt('<?php echo _NEWFILE; ?>',newfile)
		if (name) document.forms['formulaire'].NEW_FILE.value=name;
		else return false;
	}
	if (save != '')
	{
		alert('<?php echo _SAVEFOLDER; ?>');
		document.forms['formulaire'].SAVE.value=name;
	}
	document.forms['formulaire'].submit();
}
</script>

<?php
echo '<script type="text/javascript">';
include('modules/FileEditor/js/scripts.js');
echo '</script>';

$visiteur = $user ? $user[1] : 0;

include 'modules/Admin/design.php';
admintop();

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1) {


function index()
{
	global $nuked;
	
	include('modules/FileEditor/config.php');
	
	$max_root = $root . '..';
	
	// si je modifie un fichier
	if ( $_REQUEST['edit'] == 'yes' AND !empty($_POST['editeur']) AND !empty($_POST['NOM_FICHIER']) AND $_POST['NOM_FICHIER'] != 'conf.inc.php' )
	{
		$ext = str_replace('.','',strrchr($_POST['NOM_FICHIER'], '.'));	
		
		if (in_array($ext, $autor_ext))
		{
			if ( strstr($_POST['editeur'], 'textarae') )
			{
				$_POST['editeur'] = preg_replace('#textarae#i', 'textarea', $_POST['editeur']);
			}
			$content = trim(html_entity_decode(stripslashes($_POST['editeur'])));
			file_put_contents($_POST['NOM_FICHIER'], $content, LOCK_EX);
			$preview = 1;
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _UNAUTOEXT . '</div></div>';
			redirect('index.php?file=FileEditor&page=admin', 3);
			exit();
		}
	}
	
	// si je parcoure l'arborescence
	if(isset($_POST['NOM_DOSSIER']) AND $_POST['NOM_DOSSIER'] != $max_root )
	{          
		$temp = strlen($_POST['NOM_DOSSIER']);  
		$temp2 = substr($_POST['NOM_DOSSIER'],-2);
		if ($temp2 == '..')
		{
			$temp2 = substr($_POST['NOM_DOSSIER'],0,($temp-3));
			$ou = strrpos($temp2,'/');
			$dossier = substr($temp2,0,($ou+1));
		}
		else
		{
			if ( isset ($_POST['NOM_FICHIER']) AND $_POST['NOM_FICHIER'] != '' ) $dossier = $_POST['NOM_DOSSIER'];
			else $dossier = $_POST['NOM_DOSSIER'] . '/';
		}
	}
	else
	{
		$dossier=$root;
	}     
	
	// si je supprime un fichier
	if(isset($_POST['SUPPR']) AND $_POST['SUPPR'] != '')
	{
		$ext = str_replace('.','',strrchr($_POST['SUPPR'], '.'));	
		
		if (in_array($ext, $autor_ext_del))
		{
			unlink($_POST['SUPPR']);
			$temp = strlen($dossier);
			$dossier = substr($dossier,0,($temp-1));
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _UNAUTOEXT . '</div></div>';
			redirect('index.php?file=FileEditor&page=admin', 3);
			exit();
		}
	} 
	
	// si je renomme un fichier
	if(isset($_POST['RENOM_FICHIER']) AND $_POST['RENOM_FICHIER'] != '')
	{
		$ext = str_replace('.','',strrchr($_POST['NOM_FICHIER'], '.'));	
		
		if (in_array($ext, $autor_ext_rename) AND $_POST['NOM_FICHIER'] != 'conf.inc.php')
		{
			rename($_POST['NOM_FICHIER'], $_POST['NOM_DOSSIER'] . $_POST['RENOM_FICHIER']); 
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _UNAUTOEXT . '</div></div>';
			redirect('index.php?file=FileEditor&page=admin', 3);
			exit();
		}
	}
	
	// si je sauvegarde un fichier
	if(isset($_POST['SAVE']) AND $_POST['SAVE'] != '')
	{
		
		$date = date('dmY_His');
		$tab = explode("/", $dossier);
		$folder = 'themes/' . $tab[1] . '/saves';		
		$newname = $date . '_' . $_POST['NOM_FICHIER'];
		$path1 = $_POST['NOM_DOSSIER'] . $_POST['NOM_FICHIER'];
		$path2 = $folder . '/' . $newname;
		
		if ( !is_dir ( $folder ) ) mkdir($folder, 0755);
		
		copy($path1, $path2);
	}
	
	// si je crée un nouveau dossier
	if(isset($_POST['NEW_FOLDER']) AND $_POST['NEW_FOLDER'] != '' AND $_POST['NEW_FOLDER'] != 'FileEditor')
	{
		$dossier = $_POST['NOM_DOSSIER'];
		mkdir($_POST['NOM_DOSSIER'] . $_POST['NEW_FOLDER'], 0755);
	}
	
	// si je crée un nouveau fichier
	if( isset($_POST['NEW_FILE']) AND $_POST['NEW_FILE'] != '' AND $_POST['NEW_FILE'] != 'conf.inc.php')
	{
		$ext = str_replace('.','',strrchr($_POST['NEW_FILE'], '.'));	
		
		if (in_array($ext, $autor_ext_new))
		{
			$dossier = $_POST['NOM_DOSSIER'];
			$f = fopen($_POST['NOM_DOSSIER'] . $_POST['NEW_FILE'], "x+");
			fputs($f, '');
			fclose($f);
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _UNAUTOEXT . '</div></div>';
			redirect('index.php?file=FileEditor&page=admin', 3);
			exit();
		}
	}

	// si j'uploade un fichier
	if(isset($_FILES['userfile']))
	{
		$dossier = $_POST['NOM_DOSSIER'];
		
		if($_FILES['userfile']['size'] > 0)
		{
			$ext = str_replace('.','',strrchr($_FILES['userfile']['name'], '.'));	
			
			if (in_array($ext, $autor_ext_upload) AND $_FILES['userfile']['name'] != 'conf.inc.php')
			{
				$nom_fichier = strtr($_FILES['userfile']['name'], ' ', '_');
				$nom_fichier = strtr($_FILES['userfile']['name'], '  ', '_');
				$nom_fichier = strtr($_FILES['userfile']['name'], '$', '-');

				$savefile = $dossier.$nom_fichier;
				$temp = $_FILES['userfile']['tmp_name'];
				move_uploaded_file($temp, $savefile);
			}
			else
		{
			echo '<div class="notification error png_bg"><div>' . _UNAUTOEXT . '</div></div>';
			redirect('index.php?file=FileEditor&page=admin', 3);
			exit();
		}
		}
	}
	?>
	<div class="content-box"><!-- Start Content Box -->
		<div class="content-box-header"><h3><?php echo _ADMINFILE; ?></h3></div>
		<div id="loading" style="display:none;"></div>
		<div id="arborescence">
			<div id="file"><?php echo _FILE; ?></div>
			<div id="size"><?php echo _SIZE; ?></div>
			<div id="date"><?php echo _DATE; ?></div>
			<div id="oper"><?php echo _OPER; ?></div>

			<div class="clear"></div>

			<div id="folderon"><img alt="" src="modules/FileEditor/img/FolderOn.png" /> <?php echo $dossier; ?></div>

			<?php
			if($dossier != '../' AND $dossier != $root)
			{
			?>		
				<div id="folder">
					<img onclick="javascript:fsubmit('<?php echo $dossier; ?>..','','','','','','');" alt="" src="modules/FileEditor/img/Folder.png" class="pointer" />
					..
				</div>
			<?php
			}

			if ($rep = opendir($dossier))
			{
				$taille_totale = 0;
				$i=0;$j=0;

				while(false !== ($nom = readdir($rep))) 
				{
					if (($nom != '.') AND ($nom != '..') AND ($nom != 'conf.inc.php') AND ($nom != 'FileEditor'))
					{
						$chemin = $dossier.$nom;
						if (is_dir($chemin))
						{
							$tab_dossier[$i] = $nom;
							$i++;
						}
						else
						{
							$tab_fichier[$j]=$nom;
							$j++;
						}
					}
				}

				if(isset($tab_dossier)) sort($tab_dossier);      
				if(isset($tab_fichier)) sort($tab_fichier);

				$temp_taille = (isset($tab_dossier)) ? sizeof($tab_dossier) : '';
				for ($i=0;$i<$temp_taille;$i++)
				{
					$nom = $tab_dossier[$i];
					$chemin = $dossier.$nom;
				?>
					<div id="folder">
					<img onclick="javascript:fsubmit('<?php echo $chemin; ?>','','','','','','');" alt="" src="modules/FileEditor/img/Folder.png" class="pointer" />
					<?php echo $nom; ?></div>
				<?php
				}

				$temp_taille = (isset($tab_fichier)) ? sizeof($tab_fichier) : '';
				for ($j=0;$j<$temp_taille;$j++)
				{
					$nom = $tab_fichier[$j];
					$chemin = $dossier.$nom;
					$nom_bis = taille_nom($nom);
					$taille_fichier = filesize($chemin);
					$taille_totale += $taille_fichier;
					$taille_fichier = taille($taille_fichier);
					$date_ = date("d/m/Y  H:i",filectime($chemin));
					
					$ext = str_replace('.','',strrchr($nom, '.'));
					
					if (in_array($ext, $autor_ext))
					{
						$edit = 'Edit.png';
						$onedit = 'javascript:fsubmit(\'' . $dossier . '\',\'' . $chemin . '\',\'\',\'\',\'\',\'\',\'\');';
					}
					else
					{
						$edit = 'EditOff.png';
						$onedit = 'javascript:alert(\'' . _UNAUTOEXT . '\');';
					}					
					
					if (in_array($ext, $autor_ext_del))
					{
						$del = 'Trash.png';
						$ondel = 'javascript:if(confirm(\'Supprimer le fichier : ' . $nom . ' ?\')){fsubmit(\'' . $dossier . '\',\'\',\'' . $chemin . '\',\'\',\'\',\'\',\'\');}';
					}
					else
					{
						$del = 'TrashOff.png';
						$ondel = 'javascript:alert(\'' . _UNAUTOEXT . '\');';
					}				
					
					if (in_array($ext, $autor_ext_rename))
					{
						$rename = 'Rename.png';
						$onrename = 'javascript:fsubmit(\'' . $dossier . '\',\'' . $chemin . '\',\'\',\'' . $nom . '\',\'\',\'\',\'\');';
					}
					else
					{
						$rename = 'RenameOff.png';
						$onrename = 'javascript:alert(\'' . _UNAUTOEXT . '\');';
					}
				?>
					<div id="doc">
						<img src="modules/FileEditor/img/Doc.png" alt="<?php echo $nom; ?>" />
						<?php echo $nom_bis; ?>
					</div>
					<div id="taille"><?php echo $taille_fichier; ?></div>
					<div id="date2"><?php echo $date_; ?></div>
					<div id="actions">
						<img src="modules/FileEditor/img/<?php echo $edit; ?>" alt="<?php echo _EDITTHISFILE; ?>" title="<?php echo _EDITTHISFILE; ?>" class="pointer" onclick="<?php echo $onedit; ?>" />&nbsp;
						<img src="modules/FileEditor/img/<?php echo $rename; ?>" alt="<?php echo _RENAMETHISFILE; ?>" title="<?php echo _RENAMETHISFILE; ?>" class="pointer" onclick="<?php echo $onrename; ?>" />&nbsp;
						<img src="modules/FileEditor/img/Save.png" alt="<?php echo _SAVETHISFILE; ?>" title="<?php echo _SAVETHISFILE; ?>" class="pointer" onclick="javascript:fsubmit('<?php echo $dossier; ?>','<?php echo $nom; ?>','','','','','1');" />&nbsp;
						<img src="modules/FileEditor/img/<?php echo $del; ?>" alt="<?php echo _DELTHISFILE; ?>" title="<?php echo _DELTHISFILE; ?>" class="pointer" onclick="<?php echo $ondel; ?>" />
					</div>
					<div class="clear"></div>
				<?php
				}
				closedir($rep);

				$taille_totale = taille($taille_totale);
				
				if ( $taille_totale > 0 ) echo '<div id="totalsize"><b>' . _TOTALSIZE . '</b> ' . $taille_totale . '</div>';
				?>

				<div id="form1">
					<form method="POST" name="formulaire" enctype="multipart/form-data">
						<input type="hidden" name="NOM_DOSSIER" value="">
						<input type="hidden" name="NOM_FICHIER" value="">
						<input type="hidden" name="RENOM_FICHIER" value="">
						<input type="hidden" name="NEW_FILE" value="">
						<input type="hidden" name="NEW_FOLDER" value="">
						<input type="hidden" name="SAVE" value="">
						<input type="hidden" name="SUPPR" value="">
					</form>
				</div>
				<?php 
				echo '</div>';
				
				echo '<div id="buttons">'
				. '<p><img src="modules/FileEditor/img/NewFolder.png" alt="' . _CREATEFOLDER . '" title="' . _CREATEFOLDER . '" class="pointer30" onclick="javascript:fsubmit(\'' . $dossier . '\',\'\',\'\',\'\',\'' . _NEWFOLDERNAME . '\',\'\',\'\');" /></p>'
				. '<p><img src="modules/FileEditor/img/NewFile.png" alt="' . _CREATEFILE . '" title="' . _CREATEFILE . '" class="pointer30" onclick="javascript:fsubmit(\'' . $dossier . '\',\'\',\'\',\'\',\'\',\'' . _NEWFILENAME . '\',\'\');" /></p>'
				. '<p><a href="#?w=450" rel="popup_name" class="poplight"><img src="modules/FileEditor/img/UploadFile.png" alt="' . _UPLOADFILE . '" title="' . _UPLOADFILE . '" class="pointer30" /></a></p>'
				. '<p><a href="index.php?file=FileEditor&amp;page=admin&amp;op=deconex"><img src="modules/FileEditor/img/Deconex.png" alt="' . _DECONEX . '" title="' . _DECONEX . '" class="pointer30" /></a></p>'
				. '</div>';
				?>
				<div id="popup_name" class="popup_block">
					<form method="POST" enctype="multipart/form-data" action="index.php?file=FileEditor&amp;page=admin">
						Uploader un fichier : <input type="file" name="userfile" onfocus="document.getElementById('send').style.display='block'">
						<input type="hidden" name="NOM_DOSSIER" value="<?php echo $dossier; ?>">
						<input type="submit" id="send" value="Envoyer" class="submit">
					</form>
				</div>
				<?php
				if ( isset ($_POST['NOM_FICHIER']) AND $_POST['NOM_FICHIER'] != '' AND empty($_POST['RENOM_FICHIER']) AND empty($_POST['SAVE']) ) editor($_POST['NOM_FICHIER'], $_POST['NOM_DOSSIER']); 
				
				echo '<div class="clear"></div>';
				
				if ( $preview == 1 ) 
				{
					echo '<div id="prevcont"><div id="prev">' . _PREVIEW . '</div>';
					
					$tab = explode("/", $dossier);
					
					if (in_array('themes', $tab))
					{						
						$key = array_search('themes', $tab);
						$posi = $key + 1;
						setcookie('kenza_user_theme', $tab[$posi]);
						echo '<iframe src="index.php" width="100%" height="100%" />';
					}
					else if (in_array('modules', $tab))
					{					
						$key = array_search('modules', $tab);
						$posi = $key + 1;
						echo '<iframe src="index.php?file=' . $tab[$posi] . '" width="100%" height="100%" />';
					}
					else
					{
						echo '<iframe src="index.php" width="100%" height="100%" />';
					}
					
					echo '</div>';
				}
			}
	echo '</div>';	
}

function editor($chemin, $dossier)
{
	$monfichier = fopen($chemin, 'r+');
	 
	if ($monfichier)
	{
		while (!feof($monfichier))
		{
			$ligne[] = fgets($monfichier);
		}
	}	
	fclose($monfichier);	
	
	$ext = str_replace('.','',strrchr($chemin, '.'));
	
	if ( $ext == 'php' ) $code = 'php';
	else if ( $ext == 'css' ) $code = 'css';
	else if ( $ext == 'html' OR $ext == 'htm' ) $code = 'html';
	else if ( $ext == 'js' ) $code = 'js';
	else if ( $ext == 'sql' ) $code = 'sql';
	else $code = 'basic';
?>	
<!-- script pour l'éditeur -->
<script language="javascript" type="text/javascript" src="modules/FileEditor/edit_area/edit_area_full.js"></script>
<script language="javascript" type="text/javascript">
editAreaLoader.init({
	id : "editeur"							// textarea id
	,syntax: "<?php echo $code; ?>"			// type de coloration selon l'extension
	,start_highlight: true					// active la coloration par défaut
	,language: "fr"							// langue french
	,min_width: "640"						// largeur minimale de l'éditeur
	,min_height: "350"						// hauteur minimale de l'éditeur
});
</script>
<!-- fin du script -->
<?php	
	echo '<div id="formcont">' 
	. '<form method="POST" action="index.php?file=FileEditor&amp;page=admin&amp;edit=yes" onsubmit="document.getElementById(\'formcont\').style.visibility=\'hidden\';document.getElementById(\'prevcont\').style.visibility=\'hidden\';document.getElementById(\'loading\').style.display=\'block\';">'
	. '<p><textarea id="editeur" name="editeur">';
	
	foreach ($ligne AS $line)
	{
		if ( strstr($line, '/textarea') )
		{
			$line = preg_replace('#/textarea#i', '/textarae', $line);
		}
		echo $line;
	}
	
	echo '</textarea>'
	. '<input type="hidden" name="NOM_FICHIER" value="' . $chemin . '" />'
	. '<input type="hidden" name="NOM_DOSSIER" value="' . $dossier . '" /></p>'
	. '<div class="centre"><input type="submit" value="' . _SAVEFILE . '" /></div>'
	. '</form>'
	. '</div>';	
}

function deconex()
{
	setcookie('FileEditor', '0');
	setcookie('kenza_user_theme', '');
	ob_end_clean();
	redirect('index.php?file=Admin',0);
}

function taille_nom($nom)
{
	$temp=$nom;
	if (strlen($nom) > 30)
	{
		$nom = substr($temp,0,27);
		$nom = $nom . '...';
	}
	return $nom;
}

function taille($taillett)
{
	$taillett = $taillett/1024;
	if ($taillett > 1024)
	{
		$taillett = $taillett/1024;
		$taillett = round($taillett*100)/100;
		$taillett = $taillett . ' Mo';
	}
	else
	{
		$taillett=round($taillett*100)/100;
		$taillett=$taillett . ' Ko';
	}
	return $taillett;
}	
	
	
	switch ($_REQUEST['op']) {

		case "index":
			index();
			break;
			
		case "deconex":
			deconex();
			break;
			
		case "chk":
			chk($_REQUEST['mdp']);
			break;

		default:
			index();
			break;
	}

} else if ($level_admin == -1) {
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div class=\"centre\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
} else if ($visiteur > 1) {
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div class=\"centre\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
} else {
	echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div class=\"centre\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
}

adminfoot();

?>