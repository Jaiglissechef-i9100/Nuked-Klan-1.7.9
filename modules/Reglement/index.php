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

global $language, $user;
translate("modules/Reglement/lang/" . $language . ".lang.php");
@include('modules/Reglement/config.php');

$visiteur = (!$user) ? 0 : $user[1];
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{   		
	global $user, $nuked;
		
	if (isset($_REQUEST['id']) AND is_numeric($_REQUEST['id'])) $id = "AND id = '" . $_REQUEST['id'] . "'";
	else $id = '';
	
	$sql = mysql_query("SELECT id, titre, lien, largeur, valeur FROM " . REGLEMENT_TABLE . " WHERE niveau <= '" . $user[1] . "' " . $id . " ORDER BY id ASC LIMIT 0,1");
	
	if(mysql_num_rows($sql) > 0){
		list($rid, $nom, $lien, $width, $valeur) = mysql_fetch_row($sql); 
		if($valeur == 1){ $valeur = 'px'; }
		else{ $valeur = '%'; }
	?>		
		<div id="regle">
			<h2><?php echo $nom; ?></h2>
			<div id="accordion" style="width:<?php echo $width . $valeur; ?>">
		<?php
			$i=0;
			$sql_details = mysql_query("SELECT titre, contenu, ordre FROM " . REGLEMENT_DETAILS_TABLE . " WHERE id_reglement = '" . $rid . "' ORDER BY ordre ASC");
			while(list($titre, $contenu, $ordre) = mysql_fetch_array($sql_details))	{
				if(!empty($titre) AND !empty($contenu))	{
					$order = ($ordre == 0) ? '' : $ordre . '.';
				?>
					<h3><a href="#"><?php echo $order . ' ' . $titre; ?></a></h3>
					<div>
						<p><?php echo nl2br($contenu); ?></p>
					</div>
				<?php
				}
			}
		?>
			</div>
			<div class="center"><input type="button" onclick="window.location.href='<?php echo $lien; ?>';" value="<?php echo _IGOTIT; ?>" /></div>
		</div>
		
		<!-- tous les scripts js -->
			<script type="text/javascript">
				<!-- insere le css entre les balises head -->
				var link = document.createElement("link");
				link.type = "text/css";
				link.href = "modules/Reglement/css/style.css";
				link.rel = "stylesheet";
				document.getElementsByTagName("head")[0].appendChild(link);
			</script>
			<script type="text/javascript" src="modules/Reglement/js/jquery-1.7.2.min.js"></script>
			<script type="text/javascript" src="modules/Reglement/js/jquery.ui.core.js"></script>
			<script type="text/javascript" src="modules/Reglement/js/jquery.ui.widget.js"></script>
			<script type="text/javascript" src="modules/Reglement/js/jquery.ui.accordion.js"></script>
			<script type="text/javascript">
				$(function() {
					$( "#accordion" ).accordion({
						autoHeight: false,
						navigation: true,
						collapsible: true
					});
				});
			</script>
		<!-- fin des scripts -->
	<?php }else{ ?>
		<div style="text-align:center;margin:20px;"><?php echo _NOREG; ?></div>
	<?php
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