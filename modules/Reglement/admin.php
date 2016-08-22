<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $user, $language;
translate('modules/Reglement/lang/' . $language . '.lang.php');
include('modules/Admin/design.php');
@include('modules/Reglement/config.php');
admintop();
?>

<script type="text/javascript">
	<!-- insere le css entre les balises head -->
	var link = document.createElement("link");
	link.type = "text/css";
	link.href = "modules/Reglement/css/style.css";
	link.rel = "stylesheet";
	document.getElementsByTagName("head")[0].appendChild(link);
</script>
<script type="text/javascript">
	<!-- confirme la suppression -->
	function delReglement(id){
		if ( confirm ('<?php echo _DELCFRM; ?>'+id+' !\r\n\r\n<?php echo _CFRM; ?>') ){
			document.location.href='index.php?file=Reglement&page=admin&op=del&id='+id;
		}
	}
</script>
<script type="text/javascript">
	<!-- ajoute une ligne de détails -->
function AddOneRow(i)
{
	var where = document.getElementById('details');
	
	var newdiv2 = document.createElement('div');
	newdiv2.className = 'ordre';
	newdiv2.innerHTML = '<input type="text" name="ordre[]" />';
	
	var newdiv3 = document.createElement('div');
	newdiv3.className = 'titre';
	newdiv3.innerHTML = '<input type="text" name="titre[]>" />';
	
	var newdiv4 = document.createElement('div');
	newdiv4.className = 'contenu';
	newdiv4.innerHTML = '<textarea name="contenu[]"></textarea>';
	
	var newdiv5 = document.createElement('div');
	newdiv5.className = 'cancelFloat';
	
	where.appendChild(newdiv2);
	where.appendChild(newdiv3);
	where.appendChild(newdiv4);
	where.appendChild(newdiv5);
}
</script>

<?php
$visiteur = ($user) ? $user[1] : 0;
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1){
   
   function main(){
        global $nuked;
		?>
		<div class="content-box"><!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _ADMINREGLE; ?></h3></div>
			<table>
				<tr id="trchamps">
					<td style="width:5%;">#</td>
					<td style="width:35%;"><?php echo _TITRE; ?></td>
					<td style="width:35%;"><?php echo _LIEN; ?></td>
					<td style="width:10%;"><?php echo _LEVEL; ?></td>
					<td style="width:5%;"><?php echo _DETAILS; ?></td>
					<td style="width:5%;"><?php echo _EDITTHIS; ?></td>
					<td style="width:5%;"><?php echo _DELTHIS; ?></td>
				</tr>
		<?php
		$sql = mysql_query("SELECT id, titre, lien, niveau FROM " . REGLEMENT_TABLE . " ORDER BY id ASC");		
		if (mysql_num_rows($sql) > 0) {
			while(list($rid, $titre, $lien, $niveau) = mysql_fetch_array($sql))	{
			?>
				<tr>
					<td><?php echo $rid; ?></td>
					<td><a href="index.php?file=Reglement&amp;id=<?php echo $rid; ?>"><?php echo $titre; ?></a></td>
					<td><?php echo $lien; ?></td>
					<td><?php echo $niveau; ?></td>
					<td><a href="index.php?file=Reglement&amp;page=admin&amp;op=details&amp;id=<?php echo $rid; ?>"><img src="modules/Reglement/images/details.png" alt="" title="<?php echo _DETAILS; ?>" /></a></td>
					<td><a href="index.php?file=Reglement&amp;page=admin&amp;op=edit&amp;id=<?php echo $rid; ?>"><img src="images/edit.gif" alt="" title="<?php echo _EDITTHIS; ?>" /></a></td>
					<td><a href="#" onclick="delReglement('<?php echo $rid; ?>');"><img src="images/del.gif" alt="" title="<?php echo _DELTHIS; ?>" /></a></td>
				</tr>
			<?php
			}
		}else{
		?>
			<tr><td colspan="8"><?php echo _NOREG; ?></td></tr>
		<?php
		}
		echo '</table></div>';
		echo '<div class="center"><input class="button" type="button" value="' . _NEWONE . '" onclick="window.location.href=\'index.php?file=Reglement&amp;page=admin&amp;op=add\'" /></div>';
    } 
	
    function add(){
        global $nuked;
		?>
		<div class="content-box"><!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _ADDREGLE; ?></h3></div>
			<form method="post" action="index.php?file=Reglement&amp;page=admin&amp;op=doAdd">
				<p><span><?php echo _TITRE; ?> : </span><input type="text" name="titre" /></p>
				<p><span><?php echo _NIVEAU; ?> : </span>
					<select name="niveau" />
					<?php
					for($i=0;$i<10;$i++) {
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
					?>
					</select>
				</p>
				<p><span><?php echo _LIEN; ?> : </span><input type="text" name="lien" /></p>	
				<p>
					<span><?php echo _LARGEUR; ?> :<br /></span>
					<input type="text" name="largeur" style="width:50px;" /> 
					<select name="valeur">
						<option value="1">px</option>
						<option value="2">%</option>
					</select>
				</p>			
				<div class="center"><input class="button" type="submit" value="<?php echo _ADDTHIS; ?>" /></div>
			</form>
		</div>
	<?php
    } 
	
    function doAdd($titre, $lien, $niveau, $largeur, $valeur){
		chkAndSec($titre, 'text', true, $lien, 'text', true, $niveau, 'num', false, $largeur, 'num', true, $valeur, 'num', true);		
		$sql = mysql_query("INSERT INTO " . REGLEMENT_TABLE . " (`id`, `titre`, `lien`, `niveau`, `largeur`, `valeur`) VALUES ('', '" . $titre . "', '" . $lien . "', '" . $niveau . "', '" . $largeur . "', '" . $valeur . "')");		
		echo '<div class="notification success png_bg"><div>' . _ADDSUCCESS . '</div></div>';
		redirect('index.php?file=Reglement&page=admin', 3);
	
    } 
	
    function edit($id){		
		chkAndSec($id, 'num', true);
		$sql = mysql_query("SELECT titre, lien, niveau, largeur, valeur FROM " . REGLEMENT_TABLE . " WHERE id = '" . $id . "'");
		list($titre, $lien, $niveau, $largeur, $valeur) = mysql_fetch_row($sql);
		?>
		<div class="content-box"><!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _EDITREGLE; ?></h3></div>
			<form method="post" action="index.php?file=Reglement&amp;page=admin&amp;op=doEdit">
				<p><span><?php echo _TITRE; ?> : </span><input type="text" name="titre" value="<?php echo $titre; ?>" /></p>
				<p><span><?php echo _NIVEAU; ?> : </span>
					<select name="niveau" />
					<?php
					for($i=0;$i<10;$i++) {
						$sel = ($niveau == $i) ? 'selected="selected"' : '';
						echo '<option value="' . $i . '" ' . $sel . '>' . $i . '</option>';
					}
					?>
					</select>
				</p>
				<p><span><?php echo _LIEN; ?> : </span><input type="text" name="lien" value="<?php echo $lien; ?>" /></p>	
				<p>
					<span><?php echo _LARGEUR; ?> :<br /></span>
					<input type="text" name="largeur" style="width:50px;" value="<?php echo $largeur; ?>" /> 
					<select name="valeur">
					<?php
					if($valeur == 1){ $sel1 = 'selected="selected"'; }
					else{ $sel2 = 'selected="selected"'; }
					?>
						<option value="1" <?php echo $sel1; ?>>px</option>
						<option value="2" <?php echo $sel2; ?>>%</option>
					</select>
				</p>			
				<div class="center"><input type="hidden" value="<?php echo $id; ?>" name="id" /><input class="button" type="submit" value="<?php echo _EDITTHIS; ?>" /></div>
			</form>
		</div>
	<?php
    } 
	
    function doEdit($rid, $titre, $lien, $niveau, $largeur, $valeur){
		chkAndSec($rid, 'num', true, $titre, 'text', true, $lien, 'text', true, $niveau, 'num', false, $largeur, 'num', true, $valeur, 'num', true);		
		$sql = mysql_query("UPDATE " . REGLEMENT_TABLE . " SET titre = '" . $titre . "', lien = '" . $lien . "', niveau = '" . $niveau . "', largeur = '" . $largeur . "', valeur = '" . $valeur . "' WHERE id = '" . $rid . "'");		
		echo '<div class="notification success png_bg"><div>' . _EDITSUCCESS . '</div></div>';
		redirect('index.php?file=Reglement&page=admin', 3);
	
    } 
	
    function del($id){
		
		chkAndSec($id, 'num', true);		
		$sql = mysql_query("DELETE FROM " . REGLEMENT_TABLE . " WHERE id = '" . $id . "'");
		$sql = mysql_query("DELETE FROM " . REGLEMENT_DETAILS_TABLE . " WHERE id_reglement = '" . $id . "'");		
		echo '<div class="notification success png_bg"><div>' . _DELSUCCESS . '</div></div>';
		redirect('index.php?file=Reglement&page=admin', 3);
	
    } 
	
    function details($id){		
		chkAndSec($id, 'num', true);
		?>
		<div class="content-box"><!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _REGDETAILS . ' ' . $id; ?></h3></div>
			<div class="details_form">
				<form method="post" action="index.php?file=Reglement&amp;page=admin&amp;op=doDetails">
				<div class="ordre"><b><u><?php echo _ORDER; ?></u></b></div>
				<div class="titre"><b><u><?php echo _DETAILS_TITLE; ?></u></b></div>
				<div class="contenu"><b><u><?php echo _DETAILS_CONT; ?></u></b></div>
				<div class="cancelFloat"><br /></div>
				<?php
				$sql = mysql_query("SELECT id, titre, contenu, ordre FROM " . REGLEMENT_DETAILS_TABLE . " WHERE id_reglement = '" . $id . "' ORDER BY ordre ASC");
				if(mysql_num_rows($sql) > 0) {
					$i=0;				
					while(list($did, $titre, $contenu, $ordre) = mysql_fetch_array($sql)){
					?>
						<div class="delme" onclick="window.location.href='index.php?file=Reglement&page=admin&op=delDetails&rid=<?php echo $id; ?>&did=<?php echo $did; ?>'"></div>
						<div class="ordre"><input type="text" value="<?php echo $i; ?>" name="ordre[]" /></div>
						<div class="titre"><input type="text" value="<?php echo $titre; ?>" name="titre[]>" /></div>
						<div class="contenu"><textarea name="contenu[]"><?php echo $contenu; ?></textarea></div>
						<div class="cancelFloat"></div>
					<?php
						$i++;
					}
				} else {
				?>
					<div class="ordre"><input type="text" name="ordre[]" /></div>
					<div class="titre"><input type="text" name="titre[]>" /></div>
					<div class="contenu"><textarea name="contenu[]"></textarea></div>
					<div class="cancelFloat"></div>
				<?php
				}
				?>					
					<div id="details"></div>					
					<p><a href="#" onclick="AddOneRow();return false;"><?php echo _ADDROW; ?></a></p>				
				<?php
				echo '<div class="center"><input type="hidden" name="rid" value="' . $id . '" /><input class="button" type="submit" value="' . _VALIDTHIS . '" /></div>';
				echo '</form></div>';
				back('index.php?file=Reglement&page=admin');
				echo '</div>';	
	} 
	
    function doDetails($id, $ordre, $titre, $contenu){	
		$i = 1;
		foreach ($ordre AS $cle => $valeur) {		
			chkAndSec($id, 'num', true, $valeur, 'num', false, $titre[$cle], 'text', false, $contenu[$cle], 'longtext', false);			
			$sep = ( $i < sizeOf($ordre) ) ? ', ' : '';
			$req .= "('', '" . $id . "', '" . $titre[$cle] . "', '" . $contenu[$cle] . "', '" . $valeur . "')";
			$req .= $sep;
			$i++;
		}			
		$sql_check = mysql_query("SELECT * FROM " . REGLEMENT_DETAILS_TABLE . " WHERE id_reglement = '" . $id . "'");
		if(mysql_num_rows($sql_check) > 0) {
			$sql_del = mysql_query("DELETE FROM " . REGLEMENT_DETAILS_TABLE . " WHERE id_reglement = '" . $id . "'");
		}		
		$sql = mysql_query("INSERT INTO " . REGLEMENT_DETAILS_TABLE . " (`id`, `id_reglement`, `titre`, `contenu`, `ordre`) VALUES " . $req . "");		
		echo '<div class="notification success png_bg"><div>' . _ADDSUCCESS . '</div></div>';
		redirect('index.php?file=Reglement&page=admin', 3);	
	}
	
    function delDetails($rid, $did){		
		chkAndSec($rid, 'num', true, $did, 'num', true);
		$sql_del = mysql_query("DELETE FROM " . REGLEMENT_DETAILS_TABLE . " WHERE id = '" . $did . "'");		
		redirect('index.php?file=Reglement&page=admin&op=details&id=' . $rid, 0);	
	}

    switch($_REQUEST['op']){       
		case 'add':
        add();
        break;
       
		case 'doAdd':
        doAdd($_REQUEST['titre'], $_REQUEST['lien'], $_REQUEST['niveau'], $_REQUEST['largeur'], $_REQUEST['valeur']);
        break;
       
		case 'edit':
        edit($_REQUEST['id']);
        break;
       
		case 'doEdit':
        doEdit($_REQUEST['id'], $_REQUEST['titre'], $_REQUEST['lien'], $_REQUEST['niveau'], $_REQUEST['largeur'], $_REQUEST['valeur']);
        break;
    
        case 'del':
        del($_REQUEST['id']);
        break;
       
		case 'details':
        details($_REQUEST['id']);
        break;
        break;
       
		case 'doDetails':
        doDetails($_REQUEST['rid'], $_REQUEST['ordre'], $_REQUEST['titre'], $_REQUEST['contenu']);
        break;
    
        case 'delDetails':
        delDetails($_REQUEST['rid'], $_REQUEST['did']);
        break;
    
        default:
        main();
        break;
    }

} 
else if ($level_admin == -1){
    echo '<div class="notification error png_bg">'."\n"
    . '<div>'."\n"
    . '<br /><br /><div style="text-align: center">' . _MODULEOFF . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a></div><br /><br />'."\n"
    . '</div>'."\n"
    . '</div>'."\n";
}
else if ($visiteur > 1){
    echo '<div class="notification error png_bg">'."\n"
    . '<div>'."\n"
    . '<br /><br /><div style="text-align: center">' . _NOENTRANCE . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a></div><br /><br />'."\n"
    . '</div>'."\n"
    . '</div>'."\n";
}
else{
    echo '<div class="notification error png_bg">'."\n"
    . '<div>'."\n"
    . '<br /><br /><div style="text-align: center">' . _ZONEADMIN . '<br /><br /><a href="javascript:history.back()"><b>' . _BACK . '</b></a></div><br /><br />'."\n"
    . '</div>'."\n"
    . '</div>'."\n";
}

adminfoot();
?>