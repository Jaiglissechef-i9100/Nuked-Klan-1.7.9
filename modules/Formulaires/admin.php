<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.eu                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $user, $language, $cookie_captcha;
translate("modules/Formulaires/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");
include("modules/Formulaires/config.php");

// Inclusion système Captcha
include_once("Includes/nkCaptcha.php");

admintop();
 
$visiteur = (!$user) ? 0 : $user[1];

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1)
{

/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// forms ///////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////

// liste tous les formulaires
function index() 
	{
		global $nuked, $user;
		?>
		<div class="content-box"> <!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _ADMINFORMS; ?></h3></div>		
			<div id="form_index">
				<div class="purge"><p><input type="button" value="<?php echo _PURGE; ?>" onclick="window.location.href='index.php?file=Formulaires&page=admin&op=purge'" /></p></div>
				<div class="search">
					<form method="post" action="index.php?file=Formulaires&amp;page=admin&amp;op=search" onsubmit="if(document.getElementById('what').value.length < 3){ alert('<?php echo _3MIN; ?>');return false; }" >
						<div><input type="text" id="what" name="what" value="<?php echo _SEARCH; ?>" onfocus="this.value='';" />
						<input type="submit" value="Go!" /></div>
					</form>
				</div>
				<table>
					<tr class="champs">
						<td style='width:5%'><?php echo _ID; ?></td>
						<td style='width:35%'><?php echo _TITRE; ?></td>
						<td style='width:10%'><?php echo _NIVEAU; ?></td>
						<td style='width:10%'><?php echo _SENDMAIL; ?></td>
						<td style='width:10%'><?php echo _NBRCHPS; ?></td>
						<td style='width:10%'><?php echo _QTRESP; ?></td>
						<td style='width:5%'><?php echo _VALIDE; ?></td>
						<td style='width:5%'><?php echo _VIEWTHIS; ?></td>
						<td style='width:5%'><?php echo _RESP; ?></td>
						<td style='width:5%'><?php echo _VIEWDETAILS; ?></td>
						<td style='width:5%'><?php echo _EDITTHIS; ?></td>
						<td style='width:5%'><?php echo _DELTHIS; ?></td>
					</tr>
				<?php			
							
				$sql = mysql_query("SELECT id, titre, niveau, chkmail, nbr_chps, etat FROM " . FORMS_TABLE . " ORDER BY id DESC");
				while (list($id, $titre, $niveau, $chkmail, $nbr_chps, $etat) = mysql_fetch_array($sql))
				{
					$sql_resp = mysql_query("SELECT id FROM " . FORMS_REC_TABLE . " WHERE id_form = '" . $id . "'");
					$resp = mysql_num_rows( $sql_resp );
					
					$mail = ( $chkmail == 'on' ) ? _YES : _NO;
				
					if ( $etat == 1 ) 
					{
						$img = '<a href="index.php?file=Formulaires&amp;page=admin&amp;op=valid&amp;id=' . $id . '&amp;etat=' . $etat . '" title="' . _UNVALIDTHIS . '"><img src="modules/' . $_REQUEST['file'] . '/images/valid.png" alt="' . _VALID . '" /></a>';
					}
					else
					{
						$img = '<a href="index.php?file=Formulaires&amp;page=admin&amp;op=valid&amp;id=' . $id . '&amp;etat=' . $etat . '" title="' . _VALIDTHIS . '"><img src="modules/' . $_REQUEST['file'] . '/images/not_valid.png" alt="' . _NOVALID . '" /></a>';
					}
				?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $titre; ?></td>
						<td><?php echo $niveau; ?></td>
						<td><?php echo $mail; ?></td>
						<td><?php echo $nbr_chps; ?></td>
						<td><?php echo $resp; ?></td>
						<td>
						<?php 
						echo $img;
						echo '</td><td>'
						. '<a href="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=see&amp;id=' . $id . '" title="' . _VIEWTHIS . '"><img src="modules/' . $_REQUEST['file'] . '/images/see.png" alt="' . _VIEWTHIS . '" /></a>'
						. '</td><td>'
						. '<a href="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=resp&amp;id=' . $id . '" title="' . _VIEWRESP . '"><img src="modules/' . $_REQUEST['file'] . '/images/send.png" alt="' . _VIEWRESP . '" /></a>'
						. '</td><td>';
						
						if ( $resp > 0 )
						{
							echo '<img title="' . _DELRESPBEFORE . '" class="opaq" src="modules/' . $_REQUEST['file'] . '/images/publish.png" alt="' . _DELRESPBEFORE . '" onclick="alert(\'' . _DELRESPBEF . '\');" />'
							. '</td><td>'
							. '<img title="' . _DELRESPBEFORE . '" class="opaq" src="modules/' . $_REQUEST['file'] . '/images/edit.png" alt="' . _DELRESPBEFORE . '" onclick="alert(\'' . _DELRESPBEF . '\');"  />';
						}
						else
						{
							echo '<a href="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=add_details&amp;id=' . $id . '" title="' . _VIEWDETAILS . '"><img src="modules/' . $_REQUEST['file'] . '/images/publish.png" alt="' . _VIEWDETAILS . '" /></a>'
							. '</td><td>'
							. '<a href="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=edit&amp;id=' . $id . '" title="' . _EDITTHIS . '"><img src="modules/' . $_REQUEST['file'] . '/images/edit.png" alt="' . _EDITTHIS . '" /></a>';
						}
						
						echo '</td><td>'
						. '<a title="' . _DELTHIS . '" onclick="cfrmDelForm(\'' . $id . '\');"><img src="modules/' . $_REQUEST['file'] . '/images/delete.png" alt="' . _DELTHIS . '" /></a>'
						. '</td></tr>';
				}
				echo '</table></div>'
				. '<div id="button">'
				. '<form method="post" action="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=add">'
				. '<p><input type="submit" value="' . _ADDFORM . '" /></p>'
				. '</form>'
				. '</div>';
		echo '</div>'; //End Content Box
	}	
	
// ajout d'un form
	function add() 
	{
		global $nuked, $user;
		?>
		<div class="content-box"> <!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _ADDFORMS; ?></h3></div>
			<div id="form_add">
			<?php		
				echo '<form method="post" action="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=do_add" onsubmit="return verifChamps(\'add\');">'
				. '<p><span class="label" style="color:red;">' . _TITRE . ' : </span><span class="champs"><input id="titre" type="text" name="titre" size="35" /></span></p>'
				. '<p><span class="label">' . _DESCR . ' : </span><span class="champs" style="vertical-align:middle;width:600px;"><textarea name="descr" rows="" cols=""></textarea></span></p>'
				. '<p><span class="label">' . _NIVACC . ' : </span><span class="champs"><select name="niveau">';
				for ( $i = 0; $i < 10; $i++ )
				{
					echo '<option value="' . $i . '">' . $i . '</option>';
				}
				echo '</select></span></p>'
				. '<p><span class="label">' . _NIVACCRESP . ' : </span><span class="champs"><select name="nivresp">';
				for ( $k = 0; $k < 10; $k++ )
				{
					echo '<option value="' . $k . '">' . $k . '</option>';
				}
				echo '</select></span></p>'
				. '<p><span class="label">' . _SENDEMAIL . ' : </span><span class="champs"><input type="checkbox" name="chkmail" /></span></p>'
				. '<p><span class="label">' . _IFMAIL . ' : </span><span class="champs"><input id="mail" type="text" name="mail" value="' . $nuked['mail'] . '" /></span></p>'
				. '<p><span class="label">' . _NBCHPS. ' : </span><span class="champs"><select name="nbr_chps">';
				for ( $j = 1; $j < 21; $j++ )
				{
					echo '<option value="' . $j . '">' . $j . '</option>';
				}
				echo '</select></span></p>'
				. '<p><span class="label">' . _CAPTCH . ' : </span><span class="champs"><input type="checkbox" name="captch" /></span></p>'
				. '<p id="button"><input type="submit" value="' . _SEND . '" /></p>'
				. '</form>';
			echo '</div>';
			back('index.php?file=Formulaires&amp;page=admin');
			
		echo '</div>'; //End Content Box			
	}

// ajout form et redirect vers details
	function do_add($titre, $descr, $niveau, $nivresp, $chkmail, $mail, $nbre, $captch) 
	{
		global $nuked, $user;
				
		if ( $titre == '' OR !is_numeric( $niveau ) OR !is_numeric( $nivresp ) OR !is_numeric( $nbre ) OR ( $chkmail == 'on' AND ( $mail == '' OR strpos($mail, '@') === false OR strpos($mail, '.') === false ) ) ) 
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
		$descr = secu_html(html_entity_decode($descr));
		$descr = mysql_real_escape_string(stripslashes($descr));
		$titre = mysql_real_escape_string(stripslashes($titre));
		$mail = mysql_real_escape_string(stripslashes($mail));
				
		$sql = mysql_query("INSERT INTO " . FORMS_TABLE . " ( `id` , `titre` , `descr` , `niveau` , `nivresp` , `chkmail` , `mail` , `nbr_chps` , `captch` , `etat` ) VALUES ( '' , '" . $titre . "' , '" . $descr . "' , '" . $niveau . "' , '" . $nivresp . "' , '" . $chkmail . "' , '" . $mail . "' , '" . $nbre . "' , '" . $captch . "' , '0' )");	
		$id = mysql_insert_id();
		
		echo '<div class="notification success png_bg"><div>' . _SUCCES . '</div></div>';
			
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin&op=add_details&id=" . $id . "&nbre=" . $nbre, 2);		
	}	
	
	
// edit un form
	function edit($id) 
	{
		global $nuked, $user;
		?>
		
		<div class="content-box"> <!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _EDITFORMS; ?></h3></div>
		<?php		
		//verifie si numerique
		if ( is_numeric( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("SELECT id FROM " . FORMS_TABLE . " WHERE id = '" . $id . "'");
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{
				$sql = mysql_query("SELECT id, titre, descr, niveau, nivresp, chkmail, mail, nbr_chps, captch FROM " . FORMS_TABLE . " WHERE id = '" . $id . "'");
				list ( $fid, $titre, $descr, $niveau, $nivresp, $chkmail, $mail, $nbr_chps, $captch ) = mysql_fetch_array ( $sql );
				
				$check = ( $chkmail == 'on' ) ? 'checked="checked"' : '';		
				$check2 = ( $captch == 'on' ) ? 'checked="checked"' : '';		
				?>
				<div id="form_edit">
				<?php		
					echo '<form method="post" action="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=do_edit&amp;id=' . $fid . '" onsubmit="return verifChamps(\'edit\');">'
					. '<p><span class="label" style="color:red;">' . _TITRE . ' : </span><span class="champs"><input id="titre" type="text" name="titre" value="' . $titre . '" size="35" /></span></p>'
					. '<p><span class="label">' . _DESCR . ' : </span><span class="champs" style="vertical-align:middle;width:600px;"><textarea name="descr" rows="" cols="">' . $descr . '</textarea></span></p>'
					. '<p><span class="label">' . _NIVACC . ' : </span><span class="champs"><select name="niveau">';
					for ( $i = 0; $i < 10; $i++ )
					{
						$select = ( $niveau == $i ) ? 'selected="selected"' : '';
						echo '<option value="' . $i . '" ' . $select . '>' . $i . '</option>';
					}
					echo '</select></span></p>'
					. '<p><span class="label">' . _NIVACCRESP . ' : </span><span class="champs"><select name="nivresp">';
					for ( $k = 0; $k < 10; $k++ )
					{
						$select2 = ( $nivresp == $k ) ? 'selected="selected"' : '';
						echo '<option value="' . $k . '" ' . $select2 . '>' . $k . '</option>';
					}
					echo '</select></span></p>'
					. '<p><span class="label">' . _SENDEMAIL . ' : </span><span class="champs"><input type="checkbox" name="chkmail" ' . $check . ' /></span></p>'
					. '<p><span class="label">' . _IFMAIL . ' : </span><span class="champs"><input id="mail" type="text" name="mail" value="' . $mail . '" /></span></p>'
					. '<p><span class="label">' . _NBCHPS. ' : </span><span class="champs"><select name="nbr_chps">';
					for ( $j = $nbr_chps; $j < 21; $j++ )
					{
						echo '<option value="' . $j . '">' . $j . '</option>';
					}
					echo '</select></span></p>'
				. '<p><span class="label">' . _CAPTCH . ' : </span><span class="champs"><input type="checkbox" name="captch" ' . $check2 . ' /></span></p>'
					. '<p id="button"><input type="submit" value="' . _EDIT . '" /></p>'
					. '</form>';
				echo '</div>';
			}
			else
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}
			back('index.php?file=Formulaires&amp;page=admin');
		}
		echo '</div>'; //End Content Box
	}

// édit du form et redirect vers details
	function do_edit($id, $titre, $descr, $niveau, $nivresp, $chkmail, $mail, $nbre, $captch) 
	{
		global $nuked, $user;
		
		// vérifie si numérique
		if ( is_numeric( $id ) )
		{		
			if ( $titre == '' OR !is_numeric( $niveau ) OR !is_numeric( $nivresp ) OR !is_numeric( $nbre ) OR ( $chkmail == 'on' AND ( $mail == '' OR strpos($mail, '@') === false OR strpos($mail, '.') === false )  ) ) 
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}
			// vérifie si id existe
			$sql_chk = mysql_query("SELECT nbr_chps FROM " . FORMS_TABLE . " WHERE id = '" . $id . "'");
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{		
				list ( $nbr_chps ) = mysql_fetch_row ( $sql_chk );
				if ( $nbr_chps > $nbre )
				{
					echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
					exit();
				}				
				
				$descr = secu_html(html_entity_decode($descr));
				$descr = mysql_real_escape_string(stripslashes($descr));
				$titre = mysql_real_escape_string(stripslashes($titre));
				$mail = mysql_real_escape_string(stripslashes($mail));
							
				$sql = mysql_query("UPDATE " . FORMS_TABLE . " SET titre = '" . $titre . "', descr = '" . $descr . "', niveau = '" . $niveau . "', nivresp = '" . $nivresp . "', chkmail = '" . $chkmail . "', mail = '" . $mail . "', nbr_chps = '" . $nbre . "', captch = '" . $captch . "' WHERE id = '" . $id . "'");
							
				echo '<div class="notification success png_bg"><div>' . _SUCCES . '</div></div>';
			}
			else
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin&op=add_details&id=" . $id . "&nbre=" . $nbre, 2);
	}	
	
// efface un form + details + reponses + details des reponses
    function del($id)
    {
        global $nuked, $user;

		if ( is_numeric ( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("SELECT id FROM " . FORMS_TABLE . " WHERE id = '" . $id . "'");
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{		
				$sql = mysql_query("DELETE FROM " . FORMS_TABLE . " WHERE id = '" . $id . "'");
				$sql2 = mysql_query("DELETE FROM " . FORMS_DETAILS_TABLE . " WHERE idform = '" . $id . "'");
				$sql3 = mysql_query("SELECT id FROM " . FORMS_REC_TABLE . " WHERE id_form = '" . $id . "'");
				if ( mysql_num_rows( $sql3 ) > 0 )
				{
					while ( list ( $rid ) = mysql_fetch_array( $sql3 ) )
					{
						$tab[] = $rid;
					} 								
					$sql4 = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id_form = '" . $id . "'");
					$sql5 = mysql_query("DELETE FROM " . FORMS_REC_DETAILS_TABLE . " WHERE id_rec IN (" . implode(',', $tab) . ")");
				}	
				echo '<div class="notification success png_bg"><div>' . _SUCCES . '</div></div>';
				
			}
			else
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin", 1);
    } 	
	
// valide ou invalide un form
    function valid($id, $etat)
    {
        global $nuked, $user;

		if ( is_numeric ( $id ) AND is_numeric ( $etat ) )
		{				
		$value = ( $etat == 1 ) ? '0' : '1';
			$sql = mysql_query("UPDATE " . FORMS_TABLE . " SET etat = '" . $value . "' WHERE id = '" . $id . "'");
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin", 0);
    } 
		
// recherche dans les forms
    function search($what)
    {
        global $nuked, $user;
		
			if ( !empty( $what ) && strlen($what) > 2 )
			{	
				?>
				<div class="content-box"> <!-- Start Content Box -->
				<div class="content-box-header"><h3><?php echo _SEARCHFORM; ?></h3></div>
				<div id="form_search">
					<div class="search">
						<form method="post" action="index.php?file=Formulaires&amp;page=admin&amp;op=search" onsubmit="if(document.getElementById('what').value.length < 3){ alert('<?php echo _3MIN; ?>');return false; }" >
							<input type="text" id="what" name="what" value="<?php echo _SEARCH; ?>" onfocus="this.value='';" />
							<input type="submit" value="Go!" />
						</form>
					</div>
				<?php	
				$main = mysql_real_escape_string(stripslashes($main));
			
				$sql = mysql_query("SELECT id_rec, valeur FROM " . FORMS_REC_DETAILS_TABLE . " WHERE valeur LIKE '%" . $what . "%'");
				$count = mysql_num_rows( $sql );
				
				if ( $count > 0 )
				{
					$i = 1;
					echo '<div class="colonne">';
					
					while ( list ( $rid, $result ) = mysql_fetch_array ( $sql ) )
					{
						
						echo '<a title="' . _SEEREC . '" href="index.php?file=Formulaires&amp;page=admin&amp;op=resp_details&amp;id=' . $rid . '">' . _RESPNUM . $rid . '</a> - ' . $result . '<br />';
						if ( $i == $count )  echo '</div><div id="clear"></div>';
						else if ( $i % 10 == 0 ) echo '</div><div class="colonne">';
						
						$i++;
					}
				}
				else
				{
					echo '<div class="nothing">' . _NORESULT . '</div>';					
				}
				echo '</div>';
				echo '</div>'; //End Content Box	
			}
			else
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}
			back('index.php?file=Formulaires&amp;page=admin');
    }
// affiche un formulaire (permet de les tester coté admin)
    function see($id)
    {
        global $nuked, $user, $max_size;
		?>
		<div class="content-box"> <!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _VIEWFORM; ?></h3></div>
			<div id="form_see">
		<?php
		if ( is_numeric ( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("
			SELECT F.titre, F.descr, F.captch, F.etat, D.id, D.label, D.type, D.defaut, D.requis
			FROM " . FORMS_TABLE . " F 
			LEFT JOIN " . FORMS_DETAILS_TABLE . " D 
			ON F.id = D.idform 
			WHERE F.id = '" . $id . "' 
			ORDER BY D.position ASC") or die(mysql_error());
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{			
				echo '<form method="post" action="index.php?file=Formulaires&amp;page=admin&amp;op=rec&amp;id=' . $id . '" enctype="multipart/form-data">';
				$i = 0;
				while ( list ( $titre, $descr, $captch, $etat, $id_details, $label, $type, $defaut, $requis ) = mysql_fetch_array ( $sql_chk ) )
				{
					$req = ( $requis == 'on' ) ? 'on' : 'off';
					$requis = ( $requis == 'on' ) ? ' style="color:red"' : '';
					$valid = ( $etat == 0 ) ? '<h5>' . _NOTVALID . '</h5>': '';
					
					if ( $i == 0 ) 
					{
						echo '<h3>' . $titre . '</h3>';
						echo '<div class="descr">';
						if ( !empty( $descr ) ) echo $descr;
						echo '</div>';
						echo $valid;
					}
					if ( !empty( $id_details ) )
					{
						if ( $type == 'input' OR $type == 'numeric' OR $type == 'mail' ) 
						{
							$genre = '<input type="text" name="' . $type . '_' . $req . '_' . $id_details . '" value="' . $defaut . '" />';
						}
						else if ( $type == 'select' )
						{
							$defaut = explode ( ';', $defaut );
							$genre = '<select name="' . $type . '_' . $req . '_' . $id_details . '">';
							foreach ( $defaut AS $option )
							{
								if ( !empty( $option ) ) $genre .= '<option value="' . $option . '">' . $option . '</option>';
							}
							$genre .= '</select>';
						}
						else if ( $type == 'textarea' )
						{
							$genre = '<textarea name="' . $type . '_' . $req . '_' . $id_details . '" cols="30" rows="5">' . $defaut . '</textarea>';
						}
						else if ( $type == 'upld' ) 
						{
							$maxsize = $max_size / 1000000;
							$genre = '<input type="file" name="' . $type . '_' . $req . '_' . $id_details . '" /> <small><i>(' . _MAXSIZE . ' ' . $maxsize . 'Mo)</i></small>';
						}
						else 
						{
							$check = ( $defaut == 'on' ) ? 'checked="checked"' : ''; 
							$genre = '<input type="hidden" name="' . $type . '_' . $req . '_' . $id_details . '" ' . $check . ' value="off" />';
							$genre .= '<input type="checkbox" name="' . $type . '_' . $req . '_' . $id_details . '" ' . $check . ' value="on" />';
						}					
						
						echo '<p>'
						. '<span class="label" ' . $requis . '>' . $label . '</span> : '
						. '<span class="champs">' . $genre . '</span>'
						. '</p>';
										
						$i++;
						$det = $id_details;	
						$captch1 = $captch;						
					}
					else
					{
						echo '<div class="nothing">' . _NODETAILSYET . '</div>';					
					}
				}	
				
				if ( $captch1 == true ) 
				{
					echo '<div style="text-align:center;line-height:25px;">'; 
					create_captcha(0);
					echo '</div>';
				}
				
				if ( !empty( $det ) ) echo '<p id="button"><input type="submit" value="' . _SEND . '" /></p>';
				else  echo '<p id="button"><input type="button" onclick="window.location.href=\'index.php?file=Formulaires&page=admin&op=edit&id=' . $id . '\';" value="' . _EDITFORM . '" /></p>';
				echo '</form>';
			}
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
		back('index.php?file=Formulaires&amp;page=admin');
		
		echo '</div>'; //End Content Box	
    } 
	
/////////////////////////////////////////////////////////////////////////////////
//////////////////////// form_details ///////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
		
// gere les details d'un form
	function add_details($id, $nbre) 
	{
		global $nuked, $user;
		?>
		<div class="content-box"> <!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _ADDDETAILS; ?></h3></div>
			<div id="form_index">
			<?php		
				if ( !is_numeric( $id ) )
				{
					echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';	
					exit();				
				}
				
				echo '<form method="post" action="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=do_add_details">'
				. '<table><tr class="champs"><td>#</td><td>' . _LABEL . '</td><td>' . _TYPE . '</td><td>' . _DEFAUT . '</td><td>' . _REQUIRE . '</td><td>' . _POSITION . '</td><td>' . _DEL . '</td></tr>';
				
				$sqlchk = mysql_query("SELECT id, label, type, defaut, requis, position FROM " . FORMS_DETAILS_TABLE . " WHERE idform = '" . $id . "' ORDER BY position, id DESC");
				$nb_details = ( mysql_num_rows( $sqlchk ) > 0 ) ? mysql_num_rows( $sqlchk ) : '0';
				if ( $nb_details > 0 )
				{
					$i = 1;
					while ( list ( $did, $label, $type, $defaut, $requis, $position ) = mysql_fetch_array ( $sqlchk ) )
					{
						$sel1 = ( $type == 'select' ) ? 'selected="selected"' : '';
						$sel2 = ( $type == 'checkbox' ) ? 'selected="selected"' : '';
						$sel3 = ( $type == 'textarea' ) ? 'selected="selected"' : '';
						$sel4 = ( $type == 'numeric' ) ? 'selected="selected"' : '';
						$sel5 = ( $type == 'mail' ) ? 'selected="selected"' : '';
						$sel6 = ( $type == 'upld' ) ? 'selected="selected"' : '';
						$check = ( $requis == 'on' ) ? 'checked="checked"' : '';
						
						echo '<tr><td>' . $i . '</td>'
						. '<td><input onblur="yellow(\'label\', ' . $i . ');" id="label_' . $i . '" type="text" name="label[' . $i . ']" value="' . $label . '" /></td>'
						. '<td><select name="type[' . $i . ']" onchange="chktype(this, ' . $i . ');">'
						. '<option value="input">' . _INPUT . '</option>'
						. '<option value="select" ' . $sel1 . '>' . _SELECT . '</option>'
						. '<option value="checkbox" ' . $sel2 . '>' . _CHECKBOX . '</option>'
						. '<option value="textarea" ' . $sel3 . '>' . _TEXTAREA . '</option>'
						. '<option value="numeric" ' . $sel4 . '>' . _NUMERIC . '</option>'
						. '<option value="mail" ' . $sel5 . '>' . _MAIL . '</option>'
						. '<option value="upld" ' . $sel6 . '>' . _UPLOAD . '</option>'
						. '</select></td>'
						. '<td><input id="defaut_' . $i . '" type="text" name="defaut[' . $i . ']" value="' . $defaut . '" onfocus="blank(\'defaut\', ' . $i . ');" /></td>'
						. '<td><input id="requis_' . $i . '" type="checkbox" name="requis[' . $i . ']"' . $check . ' /></td>'
						. '<td><input style="text-align:center;" id="position_' . $i . '" maxlength="2" size="1" type="text" name="position[' . $i . ']" value="' . $i . '" /></td>'
						. '<td><a title="' . _DELTHIS . '" href="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=del_details&amp;id=' . $did . '"><img src="modules/' . $_REQUEST['file'] . '/images/delete.png" alt="' . _DELTHIS . '" /></a></td></tr>';
						$i++;
					}
				}
				for ( $j = $nb_details + 1; $j <= $nbre; $j++ )
				{
					echo '<tr><td>' . $j . '</td>'
					. '<td><input onfocus="blank(\'label\', ' . $j . ');" onblur="yellow(\'label\', ' . $j . ');" style="background-color:#ffffc1;" id="label_' . $j . '" type="text" name="label[' . $j . ']" /></td>'
					. '<td><select name="type[' . $j . ']" onchange="chktype(this, ' . $j . ');">'
					. '<option value="input">' . _INPUT . '</option>'
					. '<option value="select">' . _SELECT . '</option>'
					. '<option value="checkbox">' . _CHECKBOX . '</option>'
					. '<option value="textarea">' . _TEXTAREA . '</option>'
					. '<option value="numeric">' . _NUMERIC . '</option>'
					. '<option value="mail">' . _MAIL . '</option>'
						. '<option value="upld">' . _UPLOAD . '</option>'
					. '</select></td>'
					. '<td><input id="defaut_' . $j . '" type="text" name="defaut[' . $j . ']" onfocus="blank(\'defaut\', ' . $j . ');" /></td>'
					. '<td><input id="requis_' . $j . '" type="checkbox" name="requis[' . $j . ']" /></td>'
					. '<td><input id="position_' . $j . '" style="text-align:center;" maxlength="2" size="1" type="text" name="position[' . $j . ']" value="' . $j . '" /></td><td></td></tr>';
				}
				if ( $nb_details > 0 OR $nbre > 0 )
				{
					echo '</table><div><input type="hidden" name="idform" value="' . $id  . '" /><input type="hidden" name="nb_details" value="' . $nb_details  . '" /></div>'
					. '<p id="button"><input type="submit" value="' . _SEND . '" /></p>';
				}
				else
				{
					echo '</table><p id="button"><input type="button" onclick="window.location.href=\'index.php?file=Formulaires&page=admin&op=edit&id=' . $id . '\';" value="' . _EDITFORM . '" /></p>';
				}
			echo '</form></div>';
			back('index.php?file=Formulaires&amp;page=admin');
			
		echo '</div>'; //End Content Box			
	}
	
// ajout details
	function do_add_details($label, $type, $defaut, $requis, $position, $idform, $nb_details) 
	{
		global $nuked, $user;
				
		$i = 1;
	
		foreach ( $label AS $label )
		{
			if ( $label == '' OR !is_numeric( $idform ) OR !is_numeric( $position[$i] ) OR ( $type[$i] == 'select' AND !strpos( $defaut[$i], ';' ) ) ) 
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}	
			$values .= "( '', '" . mysql_real_escape_string(stripslashes($idform)) . "' , '" . mysql_real_escape_string(stripslashes($label)) . "' , '" . mysql_real_escape_string(stripslashes($type[$i])) . "' , '" . mysql_real_escape_string(stripslashes($defaut[$i])) . "' , '" . $requis[$i] . "' , '" . mysql_real_escape_string(stripslashes($position[$i])) . "' )"; 
			$values .= ( $i < sizeOf($type) ) ? ' , ' : '';	
			
			$i++;
		}
		
		if ( $nb_details > 0 )
		{
			$sqldel = mysql_query("DELETE FROM " . FORMS_DETAILS_TABLE . " WHERE idform = '" . $idform . "'");
		}
							
		$sql = mysql_query("INSERT INTO " . FORMS_DETAILS_TABLE . " ( `id` , `idform` , `label` , `type` , `defaut` , `requis` , `position` ) VALUES " . $values . "");
		
		echo '<div class="notification success png_bg"><div>' . _SUCCES . '</div></div>';
			
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin&op=details", 2);	
	}	
	
	// del un détail
    function del_details($id)
    {
        global $nuked, $user;

		if ( is_numeric ( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("SELECT idform FROM " . FORMS_DETAILS_TABLE . " WHERE id = '" . $id . "'");
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{		
				list ( $idform ) = mysql_fetch_array ( $sql_chk ); 
																	
				$sql = mysql_query("DELETE FROM " . FORMS_DETAILS_TABLE . " WHERE id = '" . $id . "'");			
				$sql2 = mysql_query("DELETE FROM " . FORMS_REC_DETAILS_TABLE . " WHERE id_frm_details = '" . $id . "'");
				$sql3 = mysql_query("UPDATE " . FORMS_TABLE . " SET nbr_chps = nbr_chps-1 WHERE id = '" . $idform . "'");	
				
				echo '<div class="notification success png_bg"><div>' . _SUCCES . '</div></div>';
			}
			else
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin&op=add_details&id=" . $idform, 1);
    } 
	
	
/////////////////////////////////////////////////////////////////////////////////
//////////////////////// form_records ///////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
		
// traitement des réponses
	function rec($id) 
	{
        global $nuked, $user, $user_ip, $upload_dir, $file_extensions, $max_size;
				
		if ( !is_numeric ( $id ) ) 
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();		
		}
		
        // Verification code captcha
        if ( isset( $_REQUEST['code_confirm'] ) && ( strtolower( $GLOBALS['nkCaptchaCache'] ) != strtolower( $_REQUEST['code_confirm'] ) ) )
        {
            echo '<div class="notification error png_bg"><div>' . _BADCODECONFIRM . '</div></div>';
            exit();
        }
		
		if ( isset( $_REQUEST['code_confirm'] ) ) unset( $_POST['code_confirm'] );
		
		$who = ( $user ) ? $user[0] : _VISITEUR;			
        $date = time();				
		$reponse = $_POST;		
		$fichiers = $_FILES;
		$nbr_rec = sizeOf( $_POST );
		$i = 1;
						
		$sql = mysql_query("INSERT INTO " . FORMS_REC_TABLE . " ( `id` , `id_form` , `id_user` , `ip` , `date` ) VALUES ( '' , '" . $id . "' , '" . $who . "' , '" . $user_ip . "' , '" . $date . "' )");
		$id_rec = mysql_insert_id();
		
		// traite chaque élément du $_POST		
		foreach ( $reponse AS $cle => $value )
		{
			$id_form_details = explode ('_', $cle);
			
			$type = $id_form_details[0];
			$requis = $id_form_details[1];
			$nombre = $id_form_details[2];
			
			// si le champs REQUIS est vide		
			if ( $requis == 'on' AND empty($value) )
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");	
				exit();		
			}
			// si l'index renvoyé n'est pas numérique
			if ( !is_numeric( $nombre ) )
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");
				exit();		
			}
			// si le type est num et que la valeur renvoyée ne l'est pas
			if ( $type == 'numeric' AND ( !empty($value) AND !is_numeric( $value ) ) )
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");
				exit();		
			}
			// si le type est mail et que la valeur ne contient ni arobase ni point
			if ( $type == 'mail' AND strpos($value, '@') === false AND strpos($value, '.') === false )
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");
				exit();		
			}
			// si le type est textarea on sécurise
			if ( $type == 'textarea' AND !empty($value) )
			{				
				$value = secu_html(html_entity_decode($value));	
			}			
					
			$values .= "( '" . $id_rec . "', '" . $nombre. "', '" . mysql_real_escape_string($value) . "')";
			
			if ( $i < $nbr_rec ) 
			{
				$values .= ', ';
			}
			$i++;
		}
		// traite chaque élément du $_FILES		
		foreach ( $fichiers AS $cle => $value )
		{
			$id_form_details = explode ('_', $cle);
			
			$type = $id_form_details[0];
			$requis = $id_form_details[1];
			$nombre = $id_form_details[2];
			
			// si le champs REQUIS est vide		
			if ( $requis == 'on' AND empty($fichiers[$cle]['name']) )
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");	
				exit();		
			}
			// si l'index renvoyé n'est pas numérique
			if ( !is_numeric( $nombre ) )
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");
				exit();		
			}			
			
			if ( !empty($reponse) )
			{
				$values .= ', ';
			}
					
			$values .= "( '" . $id_rec . "', '" . $nombre. "', '" . mysql_real_escape_string($fichiers[$cle]['name']) . "')";
			
			if ( $i < $nbr_rec ) 
			{
				$values .= ', ';
			}
			$i++;
			
			if ( !empty( $fichiers[$cle]['name'] ) )
			{						
				$file_name = $fichiers[$cle]['name']; 
				$file_name = str_replace("\\","",$file_name);
				$file_name = str_replace("'","",$file_name);
				$file_path = $upload_dir.$file_name;
				$file_ext = strtolower(substr($file_name,strrpos($file_name,".")));
				$file_type = $fichiers[$cle]['type']; 
								
				if ( $file_name == "" ) 
				{ 				
					echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
					exit();
				}
				elseif ( $fichiers[$cle]['size'] > $max_size ) 
				{				
					echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
					exit();
				}
				elseif ( !in_array( $file_ext, $file_extensions ) ) 
				{				
					echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
					exit();
				}
				else 
				{			
					$result  =  move_uploaded_file($fichiers[$cle]['tmp_name'], $file_path);
					
					if ( !$result ) 
					{		
						echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
						exit();
					}
				}
			}			
		}
				
		$sql2 = mysql_query("INSERT INTO " . FORMS_REC_DETAILS_TABLE . " ( `id_rec` , `id_frm_details` , `valeur` ) VALUES " . $values . "");
		echo '<div class="notification success png_bg"><div>' . _SUCCES . '</div></div>';
		
		$sql_chkmail = mysql_query("SELECT titre, chkmail, mail FROM " . FORMS_TABLE . " WHERE id = '" . $id . "'");
		list ( $title, $chkmail, $mail ) = mysql_fetch_row( $sql_chkmail );
					
		if ( $chkmail == 'on' )
		{
			sendmail($title, $mail, $id_rec);
		}
		
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin", 2);		
	}	

	
// liste toutes les reponses
    function resp($id)
    {
        global $nuked, $user;
		?>
		<div class="content-box"> <!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _VIEWRESP; ?></h3></div>
			<div id="form_index">
		<?php
		if ( is_numeric ( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("
			SELECT F.id, F.id_form, F.ip, F.date, U.pseudo, FRM.titre
			FROM " . FORMS_REC_TABLE . " F 
			LEFT JOIN " . USER_TABLE . " U 
			ON F.id_user = U.id 
			LEFT OUTER JOIN " . FORMS_TABLE . " FRM 
			ON F.id_form = FRM.id 
			WHERE FRM.id = '" . $id . "' 
			ORDER BY F.date") or die(mysql_error());
			
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{		
				echo '<table><tr class="champs"><td>' . _IDFORM . '</td><td>' . _SENDER. '</td><td>' . _IP . '</td><td>' . _DATE . '</td><td>' . _SEE . '</td><td>' . _DEL . '</td></tr>';
				$i = 0;
				while ( list ( $rid, $id_form, $ip, $date, $user, $titre ) = mysql_fetch_array ( $sql_chk ) )
				{
					$date = date( 'd-m-Y ' . _AT . ' H:i', $date );
					
					$sender = ( empty($user) ) ? _VISITEUR : $user;
				
					echo '<tr><td>' . $titre . '</td>'
					. '<td>' . $sender . '</td>'
					. '<td>' . $ip . '</td>'
					. '<td>' . $date . '</td>'					
					. '<td><a href="index.php?file=' . $_REQUEST['file'] . '&amp;page=admin&amp;op=resp_details&amp;id=' . $rid . '" title="' . _VIEWDETAILS . '"><img src="modules/' . $_REQUEST['file'] . '/images/publish.png" alt="' . _VIEWDETAILS . '" /></a>'
					. '</td><td>'
					. '<a title="' . _DELTHIS . '" onclick="cfrmDelResp(\'' . $rid . '\', \'' . $id . '\', \'' . $sender . '\');"><img src="modules/' . $_REQUEST['file'] . '/images/delete.png" alt="' . _DELTHIS . '" /></a>'
					. '</td></tr>';
					
					$i++;
				}
				echo '</table>';
			}
			else
			{
				echo '<div class="nothing">' . _NORESPYET . '</div>';					
			}
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
		back('index.php?file=Formulaires&amp;page=admin');
		
		echo '</div>'; //End Content Box	
    } 
	
// affiche les détails d'une réponse
    function resp_details($id)
    {
        global $nuked, $user, $upload_dir;
		?>
		<div class="content-box"> <!-- Start Content Box -->
			<div class="content-box-header"><h3><?php echo _VIEWDETAILSREC; ?></h3></div>
			<div id="form_see">
		<?php
		if ( is_numeric ( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("
			SELECT R.valeur, D.label, D.type, F.id, F.titre 
			FROM " . FORMS_REC_DETAILS_TABLE . " R 
			LEFT JOIN " . FORMS_DETAILS_TABLE . " D 
			ON R.id_frm_details = D.id 
			LEFT JOIN " . FORMS_TABLE . " F 
			ON F.id = D.idform 
			WHERE R.id_rec = '" . $id . "' 
			ORDER BY D.id") or die(mysql_error());
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{		
				echo '<form method="post" action="index.php?file=Formulaires&amp;page=admin&amp;op=del_resp&amp;id=' . $id . '">';
				$i = 0;
				while ( list ( $valeur, $label, $type, $fid, $titre ) = mysql_fetch_array ( $sql_chk ) )
				{	
					if ( $i == 0 ) echo '<h4>' . $titre . '</h4>';
					
					if ( $type == 'textarea' )
					{
						$reponse = '<textarea cols="30" rows="5" disabled="disabled">' . $valeur . '</textarea>';
					}
					else if ( $type == 'checkbox' )
					{
						$check = ( $valeur == 'on' ) ? 'checked="checked"' : '';
						$reponse = '<input type="checkbox" ' . $check . ' disabled="disabled">';
					}
					else if ( $type == 'upld' )
					{	
						if ( $valeur != '' )
						{
							if ( strrchr($valeur, ".") == '.gif' OR strrchr($valeur, ".") == '.jpg' OR strrchr($valeur, ".") == '.jpeg' OR strrchr($valeur, ".") == '.png' ) 
							{
								$reponse = '<img src="' . $upload_dir . $valeur . '" alt="" style="height:30px;" onmouseover="this.style.height=\'200px\';this.style.cursor=\'crosshair\';" onmouseout="this.style.height=\'30px\'" />';
							}
							else
							{
								$reponse = '<a href="' . $upload_dir . $valeur . '" title="' . _DLTHISFILE . '">' . $valeur . '</a>';
							}
						}
						else $reponse = '<input type="text" disabled="disabled" />';
					}
					else
					{
						$reponse = '<input type="text" value="' . $valeur . '" disabled="disabled" />';
					}
					
					echo '<div><input type="hidden" name="idform" value="' . $fid . '" /></div>';
					
					echo '<p><span class="label">' . $label . '</span> : <span class="champs">' . $reponse . '</span></p>';
					
					$i++;
				}
				echo '<p id="button"><input type="submit" value="' . _DEL . '" /></p></form>';
			}
			else
			{
				echo '<div class="nothing">' . _NORESPSYET . '</div>';					
			}
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
		back(1);
		
		echo '</div>'; //End Content Box	
    } 
		
// efface reponses + details des reponses
    function del_resp($id, $idform)
    {
        global $nuked, $user;

		if ( is_numeric ( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("SELECT id FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id . "'");
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{								
				$sql = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id . "'");
				$sql2 = mysql_query("DELETE FROM " . FORMS_REC_DETAILS_TABLE . " WHERE id_rec = '" . $id . "'");
					
				echo '<div class="notification success png_bg"><div>' . _SUCCES . '</div></div>';				
			}
			else
			{
				echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
				exit();
			}
		}
		else
		{
			echo '<div class="notification error png_bg"><div>' . _PROBLEM . '</div></div>';
			exit();
		}
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin&op=resp&id=" . $idform, 1);
    } 
	
		
// purge les détails ne correspondant à aucune réponse
    function purge()
    {
        global $nuked, $user;
	
		// liste les records
		$sql_list = mysql_query("SELECT id FROM " . FORMS_REC_TABLE . "");
		if (mysql_num_rows($sql_list) > 0)
		{
			while (list($rid) = mysql_fetch_array($sql_list)) 
			{
				$tab_ids[] .= '\'' . $rid . '\'';
			}
			
			$sql = mysql_query("DELETE FROM " . FORMS_REC_DETAILS_TABLE . " WHERE id_rec NOT IN (" . implode(',', $tab_ids) . ")");
			$aff1 = mysql_affected_rows();
		}
		
		// liste les records details
		$sql_list2 = mysql_query("SELECT id_rec FROM " . FORMS_REC_DETAILS_TABLE . " GROUP BY id_rec");
		if (mysql_num_rows($sql_list) > 0)
		{
			while (list($did) = mysql_fetch_array($sql_list2)) 
			{
				$tab_ids_details[] .= '\'' . $did . '\'';
			}
			
			$sql2 = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id NOT IN (" . implode(',', $tab_ids_details) . ")");
			$aff2 = mysql_affected_rows();	
		}
		$affect = (isset($aff1) OR isset($aff2)) ? $aff1 + $aff2 : '0';
		
		echo '<div class="notification success png_bg"><div>' . $affect . ' ' . _AFFECTED . '</div></div>';				
		
        redirect("index.php?file=" . $_REQUEST['file'] . "&page=admin", 2);
    } 
	

    switch ($_REQUEST['op'])
    {
        case "index":
            index();
            break;

        case "add":
            add();
            break;

        case "do_add":
			do_add($_REQUEST['titre'], $_REQUEST['descr'], $_REQUEST['niveau'], $_REQUEST['nivresp'], $_REQUEST['chkmail'], $_REQUEST['mail'], $_REQUEST['nbr_chps'], $_REQUEST['captch']);
            break;

        case "edit":
            edit($_REQUEST['id']);
            break;

        case "do_edit":
			do_edit($_REQUEST['id'], $_REQUEST['titre'], $_REQUEST['descr'], $_REQUEST['niveau'], $_REQUEST['nivresp'], $_REQUEST['chkmail'], $_REQUEST['mail'], $_REQUEST['nbr_chps'], $_REQUEST['captch']);
            break;

        case "del":
            del($_REQUEST['id']);
            break;

        case "valid":
            valid($_REQUEST['id'], $_REQUEST['etat']);
            break;

        case "search":
            search($_REQUEST['what']);
            break;

        case "see":
            see($_REQUEST['id']);
            break;

        case "add_details":
            add_details($_REQUEST['id'], $_REQUEST['nbre']);
            break;

        case "do_add_details":
			do_add_details($_REQUEST['label'], $_REQUEST['type'], $_REQUEST['defaut'], $_REQUEST['requis'], $_REQUEST['position'], $_REQUEST['idform'], $_REQUEST['nb_details']);
            break;

        case "del_details":
            del_details($_REQUEST['id']);
            break;

        case "rec":
            rec($_REQUEST['id']);
            break;

        case "resp":
            resp($_REQUEST['id']);
            break;

        case "resp_details":
            resp_details($_REQUEST['id']);
            break;

        case "del_resp":
            del_resp($_REQUEST['id'], $_REQUEST['idform']);
            break;

        case "purge":
            purge();
            break;

        default:
            index();
            break;
    }

}
else if ($level_admin == -1)
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
}
else if ($visiteur > 1)
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
}
else
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";

}
adminfoot();

?>