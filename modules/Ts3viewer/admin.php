<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// Module TS3Viewer Pour NK 1.7.9                                           //
// Créer par Nexans @ nexcraft.fr                                           //
// -------------------------------------------------------------------------//

if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
} 

global $user;
$visiteur = (!$user) ? 0 : $user[1];

include("modules/Admin/design.php");

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1)
{
    function main() {
	global $bgcolor4, $bgcolor1, $bgcolor2, $nuked;
	  admintop();

    echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>Gestion Serveur TeamSpeak 3</h3>\n"
    . "<div style=\"text-align:right;\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" />\n"
	. "</div></div>\n"
	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
	. "Serveur<b> |\n" 
	. "<a href=\"index.php?file=Ts3viewer&amp;page=admin&amp;op=add_srvts\">Ajouter un Serveur</a> |\n"
	. "<a href=\"index.php?file=Ts3viewer&amp;page=admin&amp;op=main_pref\">Préférences</a></div><br />\n"
	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"70%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\"><tr>\n"
	//. "<td style=\"text-align: center;\"><b>Id</b></td>\n"
	. "<td style=\"text-align: center;\"><b>Nom</b></td>\n"
	. "<td style=\"text-align: center;\"><b>IP</b></td>\n"
	. "<td style=\"text-align: center;\"><b>Q_Port</b></td>\n"
	. "<td style=\"text-align: center;\"><b>S_Port</b></td>\n"
	. "<td style=\"text-align: center;\"><b>Supprimer</b></td></tr>\n";
	  
	  $oo=1;
	  $sql1=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer ORDER by id ASC');
	  while($req1 = mysql_fetch_object($sql1))
	  {
	    $sql2=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer WHERE id="'.$req1->id.'"');
	    $req2 = mysql_fetch_object($sql2);
	  
	    $color_font = ($oo == 1) ? $bgcolor2 : $bgcolor1;
	  
	    echo'<tr>
		<!--<td style="text-align: center;">'.$req1->id.'</td>-->
		<td style="text-align: center;">'.$req1->name.'</td>
		<td style="text-align: center;">'.$req1->ip.'</td>
		<td style="text-align: center;">'.$req1->q_port.'</td>
		<td style="text-align: center;">'.$req1->s_port.'</td>
		<td style="text-align: center;"><a href="index.php?file=Ts3viewer&amp;page=admin&amp;op=dell_srvts&amp;ts_id='.$req1->id.'"><img src="images/del.gif" alt="" style="border:none;" /></a></td>
		</tr>';
		
		$oo = ($oo == 2) ? 0 : $oo;
		$oo++;
	  }
		
	  echo "</table>\n"
	  		. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin\"><b>Retour</b></a> ]</div><br /></div></div>\n";
	  
	  adminfoot();
    }
	
	function main_pref(){
        global $nuked;
			admintop();
        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
                . "<div class=\"content-box-header\"><h3>Ajouter un Serveur</h3>\n"
    			. "<div style=\"text-align:right;\">\n"
				. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" />\n"
				. "</div></div>\n"
                . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
				. "<b><a href=\"index.php?file=Ts3viewer&amp;page=admin\">Serveur</a></b> |\n"
				. "<a href=\"index.php?file=Ts3viewer&amp;page=admin&amp;op=add_srvts\">Ajouter un Serveur<b></a> |\n"
				. "Préférences\n"
				. "</b></div><br />";
				
						$sql1=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer');
												
						$sql2=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer_pref');
	    				while($req2 = mysql_fetch_object($sql2)){
									$idsrv = $req2->srvid;
									$width_module = $req2->width_module;
									$width_blok= $req2->width_blok;
								}
						$sql3=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer WHERE id = '.$idsrv.'');
						while($req3 = mysql_fetch_object($sql3)){
									$tsipport = "$req3->name - $req3->ip:$req3->s_port";
								}
								
				echo '<form action="index.php?file=Ts3viewer&amp;page=admin&amp;op=save_pref" method="post"><table align="center">
				<tr><td><b>Largeur Module Actuelle : </b></td><td><input id="art_titre" type="text" name="srv_width_module" maxlength="100" size="10" value="'. $width_module .'" /></td></tr>
				<tr><td><b>Largeur Blok Actuelle : </b></td><td><input id="art_titre" type="text" name="srv_width_blok" maxlength="100" size="10" value="'. $width_blok .'" /></td></tr>
				<tr><td><b>Serveur Actuel Affiché : </b></td><td>'. $tsipport .'</td></tr>
				<tr><td><b>Serveur à afficher : </b></td><td><select name="srv_id">';
					
	    				while($req1 = mysql_fetch_object($sql1))
							{
		 						 //echo'<option value="'.$req1->id.'">'.stripslashes($req1->ip).':'.stripslashes($req1->s_port).'</option>';
								 echo'<option value="'.$req1->id.'">'.stripslashes($req1->name).'</option>';
							}
		
		echo'</select></td></tr><tr><td colspan="2" style="text-align:center;"><input type="submit" value="Valider" /></td></tr></table></form>';
		
	  echo'<div style="text-align: center;"><br />[ <a href="index.php?file=Admin"><b>Retour</b></a> ]</div><br /></div></div>';
			
			adminfoot();
    }
	
	function save_pref($srv_id_get,$srv_width_module_get,$srv_width_blok_get) {
	global $nuked;
	  admintop();

	   extract($_POST);
	  if(!empty($srv_id))
	  {
	    $sql1=mysql_query('SELECT * FROM '.$nuked['prefix'].'_ts3viewer WHERE id='.$srv_id_get.'');
		$req1=mysql_fetch_object($sql1);
		
		mysql_query('DELETE FROM '.$nuked['prefix'].'_ts3viewer_pref ');
	 
	    mysql_query('INSERT into '.$nuked['prefix'].'_ts3viewer_pref (srvid,width_module,width_blok) VALUES ("'.$srv_id_get.'","'. $srv_width_module_get .'","'. $srv_width_blok_get .'")');
		echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "<b>Préference modifié avec succes.</b>\n"
		. "</div>\n"
		. "</div>\n";
		redirect("index.php?file=Ts3viewer&page=admin&op=main_pref", 2);
	  }
	  else
	  {
	    mysql_query('INSERT into '.$nuked['prefix'].'_ts3viewer_pref (srvid,width_module,width_blok) VALUES ("'.$srv_id_get.'","'. $srv_width_module_get .'","'. $srv_width_blok_get .'")');
	    echo "<div class=\"notification error png_bg\">\n"
	  . "<div>\n"
	  . "<b>Une erreur ses produite : Vous n'avez pas remplis tout les champs.</b> !!!"
	  . "</div>\n"
      . "</div>\n";
	  redirect("index.php?file=Ts3viewer&page=admin&op=save_pref", 2);

	  }
	
	  adminfoot();
	}
	
	function add_srvts() {
	global $nuked;
	  admintop();
	  
	  echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>Ajouter un Serveur</h3>\n"
    . "<div style=\"text-align:right;\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" />\n"
	. "</div></div>\n"
	. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
		. "<b><a href=\"index.php?file=Ts3viewer&amp;page=admin\">Serveur</a> | </b>\n"
		. "Ajouter un Serveur<b> |\n"
		. "<a href=\"index.php?file=Ts3viewer&amp;page=admin&amp;op=main_pref\">Préférences</a>\n"
		. "</b></div><br />"
		. "<form method=\"post\" action=\"index.php?file=Ts3viewer&amp;page=admin&amp;op=save_srvts\" onsubmit=\"backslash('art_texte');\">\n"
        . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
        . "<tr><td><b>Nom : </b></td><td><input id=\"art_titre\" type=\"text\" name=\"name\" maxlength=\"100\" size=\"45\" /></td></tr>\n"
        . "<tr><td><b>IP : </b></td><td><input id=\"art_titre\" type=\"text\" name=\"ip\" maxlength=\"100\" size=\"45\" /></td></tr>\n"
        . "<tr><td><b>Query Port : </b></td><td><input id=\"art_titre\" type=\"text\" name=\"q_port\" maxlength=\"100\" size=\"45\" /></td></tr>\n"
		. "<tr><td><b>Port : </b></td><td><input id=\"art_titre\" type=\"text\" name=\"s_port\" maxlength=\"100\" size=\"45\" /></td></tr>\n";

       echo "</table>\n"
             . "<div style=\"text-align: center;\"><br /><input type=\"submit\" name=\"Submit\" value=\"Ajouter\" />"
             . "</div>\n"
             . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Ts3viewer&amp;page=admin\"><b>Retour</b></a> ]</div></form><br /></div></div>\n";
			  
	  adminfoot();
	}
	
	function save_srvts() {
	global $nuked;
	  admintop();

	  extract($_POST);
	  if(!empty($name) && !empty($ip) && !empty($q_port) && !empty($s_port))
	  {
		$verification = mysql_query('SELECT COUNT(*) FROM '.$nuked['prefix'].'_ts3viewer WHERE name="'.$name.'" && ip="'.$ip.'" && q_port="'.$q_port.'" && s_port="'.$s_port.'"') or die (mysql_error());
		$utilise = mysql_fetch_array($verification);
		
		if($utilise['COUNT(*)'] >= 1)
		{
		 echo "<div class=\"notification error png_bg\">\n"
	  . "<div>\n"
	  . "<b>Une erreur ses produite : Ce Serveur figure déja.</b> !!!"
	  . "</div>\n"
      . "</div>\n";
	  redirect("index.php?file=Ts3viewer&page=admin&op=add_srvts", 2); 
		}
		else
		{
	      mysql_query('INSERT into '.$nuked['prefix'].'_ts3viewer (id, name, ip, q_port, s_port) VALUES ("","'.$name.'","'.$ip.'","'.$q_port.'","'.$s_port.'")');
		  echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "<b>Serveur ajouté avec succes.</b>\n"
		. "</div>\n"
		. "</div>\n";
		 redirect("index.php?file=Ts3viewer&page=admin", 2);
		}
	  }
	  else
	  {
       
	  echo "<div class=\"notification error png_bg\">\n"
	  . "<div>\n"
	  . "<b>Une erreur ses produite : Vous n'avez pas remplis tout les champs.</b> !!!"
	  . "</div>\n"
      . "</div>\n";
	  redirect("index.php?file=Ts3viewer&page=admin&op=add_srvts", 2);

    
	  }
	
	  adminfoot();
	}
		
	function dell_srvts($ts_id_get) {
	global $nuked;
	  admintop();
	 
	    mysql_query('DELETE FROM '.$nuked['prefix'].'_ts3viewer WHERE id="'.$ts_id_get.'"');
		echo "<div class=\"notification success png_bg\">\n"
		. "<div>\n"
		. "<b>Serveur supprimé avec succes.</b>\n"
		. "</div>\n"
		. "</div>\n";
		redirect("index.php?file=Ts3viewer&page=admin", 2);
	 
	  adminfoot();
	} 
	
switch($_REQUEST['op'])
    {
        case 'main':
            main();
            break;
			
		case 'add_srvts':
			add_srvts();
			break;
			
		case 'save_srvts':
			save_srvts();
			break;
			
		case 'dell_srvts':
			dell_srvts($_REQUEST['ts_id']);
			break;
			
		case 'main_pref':
			main_pref();
			break;
		
		case 'save_pref':
			save_pref($_REQUEST['srv_id'] , $_REQUEST['srv_width_module'] , $_REQUEST['srv_width_blok']);
			break;
			
        default:
            main();
            break;
    } 

} 
else if ($level_admin == -1)
{
    admintop();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    adminfoot();
} 
else if ($visiteur > 1)
{
    admintop();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></div></a><br /><br />";
    adminfoot();
} 
else
{
    admintop();
    echo "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    adminfoot();
} 

?>