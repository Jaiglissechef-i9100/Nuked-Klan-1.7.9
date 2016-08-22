<?php
if ( !defined("INDEX_CHECK") )
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $nuked, $language, $user, $cookie_captcha;

translate("modules/" . $_REQUEST['file'] . "/lang/" . $language . ".lang.php");
include("modules/Formulaires/config.php");

// Inclusion système Captcha
include_once("Includes/nkCaptcha.php");

// On determine si le captcha est actif ou non
if ( _NKCAPTCHA == 'off' ) $captcha = 0;
else if ( _NKCAPTCHA == 'auto' && $user[1] > 0 )  $captcha = 0;
else $captcha = 1;

$visiteur = (!$user) ? 0 : $user[1];
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ( $visiteur >= $level_access && $level_access > -1 )
{	

// choix du type de form et de la table
function index() 
	{
		global $nuked, $visiteur, $user, $bgcolor1, $bgcolor2, $bgcolor3;
		
		if ( _PASSLIST === false )
		{
			echo '<div class="nothing">' . _404 . '</div>';
			back(1);
			closetable();
			footer();
			exit();
		}
		else
		{
			?>		
			<div id="form_user">
			<h3><?php echo _FORMSLIST; ?></h3>
			<table>
					<tr class="champs" style="background-color:<?php echo $bgcolor3; ?>">
						<td style="width:80%"><?php echo _INTIT; ?></td>
						<td style="width:10%"><?php echo _VIEWTHIS; ?></td>
						<td style="width:10%"><?php echo _RESP; ?></td>
					</tr>
			<?php			
			$i = 1;		
			$sql = mysql_query("SELECT id, titre, niveau, nivresp FROM " . FORMS_TABLE . " WHERE etat = 1 AND niveau <= '" . $visiteur . "' ORDER BY id DESC");
			while (list($id, $titre, $niv, $nivresp) = mysql_fetch_array($sql))
			{
				if ( $i % 2 == 0 ) $bgc = $bgcolor1;
				else $bgc = $bgcolor2;
				echo '<tr style="background-color:' . $bgc . '">'
				. '<td>' . $titre . '</td><td>';
				
				if ( $niv <= $visiteur )
				{
					echo '<a href="index.php?file=' . $_REQUEST['file'] . '&amp;op=see&amp;id=' . $id . '" title="' . _VIEWTHIS . '"><img src="modules/' . $_REQUEST['file'] . '/images/see.png" alt="' . _VIEWTHIS . '" /></a>';
				}
				else
				{
					echo '<img title="' . _LEVEL2LOW . '" class="opaq" src="modules/' . $_REQUEST['file'] . '/images/see.png" alt="' . _VIEWTHIS . '" />';
				}
				echo '</td><td>';
				
				if ( $nivresp <= $visiteur )
				{
					echo '<a href="index.php?file=' . $_REQUEST['file'] . '&amp;op=view&amp;id=' . $id . '" title="' . _VIEWRESP . '"><img src="modules/' . $_REQUEST['file'] . '/images/send.png" alt="' . _VIEWRESP . '" /></a>';
				}
				else
				{
					echo '<img title="' . _LEVEL2LOW . '" class="opaq" src="modules/' . $_REQUEST['file'] . '/images/send.png" alt="' . _VIEWRESP . '" />';
				}
				
				echo '</td></tr>';
				$i++;
			}
			echo '</table></div>';
		}
	}	
	
// affiche un formulaire (permet de les tester coté admin)
    function see($id)
    {
        global $nuked, $visiteur, $user, $max_size;
		
		if ( is_numeric ( $id ) )
		{		
			// vérifie si id existe
			$sql_chk = mysql_query("
			SELECT F.titre, F.descr, F.captch, F.etat, D.id, D.label, D.type, D.defaut, D.requis
			FROM " . FORMS_TABLE . " F 
			LEFT JOIN " . FORMS_DETAILS_TABLE . " D 
			ON F.id = D.idform 
			WHERE F.id = '" . $id . "' AND F.niveau <= '" . $visiteur . "' AND F.etat = '1' 
			ORDER BY D.position ASC") or die(mysql_error());
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{			
				echo '<div id="see_user"><form id="form1" method="post" action="index.php?file=Formulaires&amp;op=rec&amp;id=' . $id . '" enctype="multipart/form-data" onsubmit="return verifChps();">';
				$i = 0;
				while ( list ( $titre, $descr, $captch, $etat, $id_details, $label, $type, $defaut, $requis ) = mysql_fetch_array ( $sql_chk ) )
				{
					$req = ( $requis == 'on' ) ? 'on' : 'off';
					$requis = ( $requis == 'on' ) ? ' style="color:red"' : '';
					$valid = ( $etat == 0 ) ? '<h5>' . _NOTVALID . '</h5>': '';
					
					if ( $i == 0 ) 
					{
						echo '<h3>' . $titre . '</h3><div class="descr">';
						if ( !empty( $descr ) ) echo $descr;
						echo '</div>';
						echo $valid;
					}
					if ( !empty( $id_details ) )
					{
						if ( $type == 'input' OR $type == 'numeric' OR $type == 'mail' ) 
						{
							$genre = '<input type="text" id="' . $type . '_' . $req . '_' . $id_details . '" name="' . $type . '_' . $req . '_' . $id_details . '" value="' . $defaut . '" onfocus="this.style.borderColor=\'\';" />';
						}
						else if ( $type == 'select' )
						{
							$defaut = explode ( ';', $defaut );
							$genre = '<select id="' . $type . '_' . $req . '_' . $id_details . '" name="' . $type . '_' . $req . '_' . $id_details . '" onfocus="this.style.borderColor=\'\';">';
							foreach ( $defaut AS $option )
							{
								if ( !empty( $option ) ) $genre .= '<option value="' . $option . '">' . $option . '</option>';
							}
							$genre .= '</select>';
						}
						else if ( $type == 'textarea' )
						{
							$genre = '<textarea id="' . $type . '_' . $req . '_' . $id_details . '" name="' . $type . '_' . $req . '_' . $id_details . '" cols="30" rows="5" onfocus="this.style.borderColor=\'\';">' . $defaut . '</textarea>';
						}
						else if ( $type == 'upld' ) 
						{
							$maxsize = $max_size / 1000000;
							$genre = '<input type="file" id="' . $type . '_' . $req . '_' . $id_details . '" name="' . $type . '_' . $req . '_' . $id_details . '" /> <small><i>(' . _MAXSIZE . ' ' . $maxsize . 'Mo)</i></small>';
						}
						else 
						{
							$check = ( $defaut == 'on' ) ? 'checked="checked"' : ''; 
							$genre = '<input type="hidden" name="' . $type . '_' . $req . '_' . $id_details . '" ' . $check . ' value="off" />';
							$genre .= '<input type="checkbox" id="' . $type . '_' . $req . '_' . $id_details . '" name="' . $type . '_' . $req . '_' . $id_details . '" ' . $check . ' value="on" />';
						}					
						
						echo '<p>'
						. '<span class="label" ' . $requis . '>' . $label . '</span> : '
						. '<span class="champs">' . $genre . '</span>'
						. '</p>';
						
						$i++;		
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
				
				echo '<p id="button"><input type="submit" value="' . _SEND . '" /></p>';
				echo '</form>';
			}
			else
			{
				echo '<div class="nothing">' . _PROBLEM . '</div>';
				closetable();
				footer();
				exit();
			}
		}
		else
		{
			echo '<div class="nothing">' . _PROBLEM . '</div>';
			closetable();
			footer();
			exit();
		}
		back(1);
		
		echo '</div>';	
    } 
			
// traitement des réponses
	function rec($id) 
	{
        global $nuked, $visiteur, $user, $user_ip, $upload_dir, $file_extensions, $max_size;
				
		if ( !is_numeric ( $id ) ) 
		{
			echo '<div class="nothing">' . _PROBLEM . '</div>';
			closetable();
			footer();
			exit();		
		}
		
        // Verification code captcha
        if ( isset( $_REQUEST['code_confirm'] ) && ( strtolower( $GLOBALS['nkCaptchaCache'] ) != strtolower( $_REQUEST['code_confirm'] ) ) )
        {            
            echo '<div class="nothing">' . _BADCODECONFIRM . '</div>';
            closetable();
            footer();
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
				
		foreach ( $reponse AS $cle => $value )
		{
			$id_form_details = explode ('_', $cle);
			
			$type = $id_form_details[0];
			$requis = $id_form_details[1];
			$index = $id_form_details[2];
			
			// si le champs REQUIS est vide		
			if ( $requis == 'on' AND empty($value) )
			{
				echo '<div class="nothing">' . _PROBLEM . '</div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");	
				closetable();
				footer();
				exit();		
			}
			// si l'index renvoyé n'est pas numérique
			if ( !is_numeric( $index ) )
			{
				echo '<div class="nothing">' . _PROBLEM . '</div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");	
				closetable();
				footer();
				exit();		
			}
			// si le type est num et que la valeur renvoyée ne l'est pas
			if ( $type == 'numeric' AND ( !empty($value) AND !is_numeric( $value ) ) )
			{
				echo '<div class="nothing">' . _PROBLEM . '</div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");	
				closetable();
				footer();
				exit();		
			}
			// si le type est mail et que la valeur ne contient ni arobase ni point
			if ( $type == 'mail' AND strpos($value, '@') === false AND strpos($value, '.') === false )
			{
				echo '<div class="nothing">' . _PROBLEM . '</div>';
				$sqldel = mysql_query("DELETE FROM " . FORMS_REC_TABLE . " WHERE id = '" . $id_rec . "'");	
				closetable();
				footer();
				exit();		
			}
			// si le type est textarea on sécurise
			if ( $type == 'textarea' AND !empty($value) )
			{				
				$value = secu_html(html_entity_decode($value));	
			}			
					
			$values .= "( '" . $id_rec . "', '" . $index. "', '" . mysql_real_escape_string($value) . "')";
			
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
		echo '<div class="nothing"><div>' . _SUCCES . '</div></div>';
		
		$sql_chkmail = mysql_query("SELECT id, titre, chkmail, mail, nivresp FROM " . FORMS_TABLE . " WHERE id = '" . $id . "'");
		list ( $fid, $title, $chkmail, $mail, $nivresp ) = mysql_fetch_row( $sql_chkmail );
					
		if ( $chkmail == 'on' )
		{
			sendmail($title, $mail, $id_rec);
		}
		
		if ( $visiteur >= $nivresp )
		{
			redirect("index.php?file=" . $_REQUEST['file'] . "&op=view&id=" . $fid, 3);		
		}
		else if ( _PASSLIST === true )
		{
			redirect("index.php?file=" . $_REQUEST['file'], 3);	
		}
		else
		{
			redirect("index.php", 3);	
		}
	}
	
	
// liste toutes les reponses
    function view($id)
    {
        global $nuked, $visiteur, $user;
		
		echo '<div id="form_user"><h3>' . _VIEWRESP . '</h3>';
		
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
			WHERE FRM.id = '" . $id . "' AND FRM.niveau <= '" . $visiteur . "' AND FRM.nivresp <= '" . $visiteur . "' AND FRM.etat <= '1'
			ORDER BY F.date") or die(mysql_error());
			
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{		
				echo '<table><tr class="champs"><td>' . _IDFORM . '</td><td>' . _SENDER. '</td><td>' . _DATE . '</td><td>' . _SEE . '</td></tr>';
				$i = 0;
				while ( list ( $rid, $id_form, $ip, $date, $user, $titre ) = mysql_fetch_array ( $sql_chk ) )
				{
					$sender = ( empty($user) ) ? _VISITEUR : $user;
					$date = date( 'd-m-Y ' . _AT . ' H:i', $date );
				
					echo '<tr><td>' . $titre . '</td>'
					. '<td>' . $sender . '</td>'
					. '<td>' . $date . '</td>'					
					. '<td><a href="index.php?file=' . $_REQUEST['file'] . '&amp;op=details&amp;id=' . $rid . '" title="' . _VIEWDETAILS . '"><img src="modules/' . $_REQUEST['file'] . '/images/publish.png" alt="' . _VIEWDETAILS . '" /></a>'
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
			echo '<div class="nothing">' . _PROBLEM . '</div>';	
			closetable();
			footer();
			exit();
		}
		back(1);
		
		echo '</div>';	
    } 
	
// affiche les détails d'une réponse
    function details($id)
    {
        global $nuked, $visiteur, $user, $upload_dir;
		
		echo '<div id="see_user"><h3>' . _VIEWDETAILSREC . '</h3>';
		
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
			WHERE R.id_rec = '" . $id . "' AND F.niveau <= '" . $visiteur . "' AND F.nivresp <= '" . $visiteur . "' AND F.etat <= '1'
			ORDER BY D.id") or die(mysql_error());
			if ( mysql_num_rows ( $sql_chk ) > 0 )
			{		
				echo '<form method="post" action="index.php?file=Formulaires&amp;op=del_resp&amp;id=' . $id . '">';
				$i = 0;
				while ( list ( $valeur, $label, $type, $fid, $titre ) = mysql_fetch_array ( $sql_chk ) )
				{	
					if ( $i == 0 ) echo '<h4>' . _FORM . ' : "' . $titre . '"</h4>';
					
					if ( $type == 'textarea' )
					{
						$reponse = '<textarea cols="30" rows="5" disabled="disabled">' . $valeur . '</textarea>';
					}
					else if ( $type == 'checkbox' )
					{
						$check = ( $valeur == 'on' ) ? 'checked="checked"' : '';
						$reponse = '<input type="checkbox" ' . $check . ' disabled="disabled" />';
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
					
					
					echo '<p><span class="label">' . $label . '</span> : <span class="champs">' . $reponse . '</span></p>';
					
					$i++;
				}
				echo '</form>';
			}
			else
			{
				echo '<div class="nothing">' . _NORESPSYET . '</div>';					
			}
		}
		else
		{
			echo '<div class="nothing">' . _PROBLEM . '</div>';	
			closetable();
			footer();
			exit();
		}
		back(1);
		
		echo '</div>';
    } 
	
    switch ($_REQUEST['op'])
    {
        case "index":
			opentable();
            index();
			closetable();
            break;

        case "see":
			opentable();
            see($_REQUEST['id']);
			closetable();
            break;

        case "rec":
			opentable();
            rec($_REQUEST['id']);
			closetable();
            break;

        case "resp":
			opentable();
            resp($_REQUEST['id']);
			closetable();
            break;

        case "view":
			opentable();
            view($_REQUEST['id']);
			closetable();
            break;

        case "details":
			opentable();
            details($_REQUEST['id']);
			closetable();
            break;

        default:
            index();
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