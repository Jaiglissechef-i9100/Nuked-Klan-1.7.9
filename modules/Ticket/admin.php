<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// Module Charte Pour NK 1.7.9                                              //
// Créer par Stive @ PalaceWaR.eu                                           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">Vous ne pouvez pas ouvrir cette page directement</div>");
}

global $user, $language;
translate("modules/Ticket/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");
admintop();

if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}

$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1)
{	
    function main()
	{
        global $nuked, $user;
		
	     echo "<script type=\"text/javascript\">\n"
			. "<!--\n"
			. "\n"
			. "function del_ticket(pseudo, aleatoire)\n"
			. "{\n"
			. "if (confirm('" . _DELTICKET . " '+pseudo+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Ticket&page=admin&op=del_ticket&id='+aleatoire;}\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";
		
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINTICKET . "" . _OPEN . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/ticket.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b>" . _OPENTICKET . " </b>| "
			. "<a href=\"index.php?file=Ticket&amp;page=admin&amp;op=close_ticket\">" . _CLOSEDTICKET . "</a>| "
			. "<a href=\"index.php?file=Ticket&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a><br><br />\n";	
			
		 echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _NICK . "</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _AOBJET . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _DATE . "</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _AID . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _REPONDRE . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _FERMER . "</b></td>\n"
			. "<td style=\"width: 10%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";				
			
		 $sql = mysql_query("SELECT id, author, email, objet, service, aleatoire, date, statut FROM ". $nuked['prefix'] ."_ticket_send WHERE statut = '" . _OPEN . "' ORDER BY id DESC");
		 while($row = mysql_fetch_assoc($sql))
	{
		$row['date'] = nkDate($row['date']);
		echo "<tr><td style=\"width: 20%;\" align=\"center\">" . $row['author'] . "</td>\n"
			. "<td style=\"width: 15%;\" align=\"center\">" . $row['objet'] . "</td>\n"
			. " <td style=\"width: 20%;\"align=\"center\">" . $row['date'] . "</td>\n"
			. " <td style=\"width: 15%;\"align=\"center\">" . $row['aleatoire'] . "</td>\n"
			. " <td style=\"width: 10%;\" align=\"center\">\n"
			. " <a href=\"index.php?file=Ticket&amp;page=admin&amp;op=reply&amp;id=" . $row['aleatoire'] . "\"><img style=\"border: 0;\" src=\"modules/Ticket/images/repondre.gif\" alt=\"\" title=\"" . _REPONDRE . "\" /></a></td>\n"
			. " <td style=\"width: 10%;\" align=\"center\">\n"
			. " <a href=\"index.php?file=Ticket&amp;page=admin&amp;op=fermer_ticket&amp;id=" . $row['aleatoire'] . "\"><img style=\"border: 0;\" src=\"modules/Ticket/images/close2.gif\" alt=\"\" title=\"" . _ACLOSE . "\" /></a></td>\n"
			. " <td style=\"width: 10%;\" align=\"center\"><a href=\"javascript:del_ticket('" . $row['author'] . "', '" . $row['aleatoire'] . "');\" title=\"" . _DELTICKET . "\">\n"
			. " <img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" /></a></td></tr>\n";		  
	}
		echo "</table>\n"
		
			. "<div style=\"margin: 12px\">\n"
			. "<div class=\"notification information png_bg\">\n"
			. " <a onclick=\"del();return false\" href=\"#\" class=\"close\">\n"
			. "<img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Close this notification\" alt=\"close\"></a><div>" ._INFO1. "</div></div>\n"
			. " </div>\n";
	}
		
    function reply($id, $aleatoire)
	{
        global $nuked, $user;

	    echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _REPOND . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/ticket.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><a href=\"index.php?file=Ticket&amp;page=admin\">" . _OPENTICKET . "</a> | "
			. "<a href=\"index.php?file=Ticket&amp;page=admin&amp;op=close_ticket\">" . _CLOSEDTICKET . "</a>| "
			. "<a href=\"index.php?file=Ticket&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a><br><br />\n";
			
			$sql = mysql_query("SELECT id, author, email, objet, service, aleatoire, date, statut FROM ". $nuked['prefix'] ."_ticket_send WHERE aleatoire = '" . $aleatoire . "' ORDER BY id DESC");
			while($row = mysql_fetch_assoc($sql))
			{
			$row['date'] = nkDate($row['date']);
			
		 echo "<form method=\"post\" action=\"index.php?file=Ticket&amp;page=admin&amp;op=send_repond\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ticket_texte');\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n"
			. "<tr><td><b>" . _OBJET . " </b>" . $row['objet'] . "</td></tr>\n"
			. "<tr><td><b>" . _ID . " </b>" . $row['aleatoire'] . "</td></tr>\n"
			. "<tr><td><br /><b>" . _MESSAGE . " :</b></td></tr>\n"
			. "<tr><td><textarea class=\"editor\" name=\"message\" cols=\"65\" rows=\"10\" onselect=\"storeCaret('ticket_texte');\" 
			   onclick=\"storeCaret('ticket_texte');\" onkeyup=\"storeCaret('ticket_texte');\"></textarea></td></tr>\n"
			. "<tr><td align=\"center\"><input type=\"hidden\" name=\"aleatoire\" value=\"" . $aleatoire . "\" />\n"
			. "<br /><input type=\"submit\" name=\"send\" value=\"" . _REPONDRE . "\" /></td></tr></table>\n";
	}
			$sql = mysql_query("SELECT id, author, email, objet, service, aleatoire, date, statut FROM ". $nuked['prefix'] ."_ticket_send WHERE aleatoire = '" . $aleatoire . "'");
			list($id, $authorsend, $email, $objet, $service, $aleatoire, $date, $statut) = mysql_fetch_array($sql);
			echo "<center><br /><table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
			$com = mysql_query("SELECT aleatoire, message, date, author FROM ". $nuked['prefix'] ."_ticket_msg WHERE aleatoire = '" . $aleatoire . "' ORDER BY date DESC");
			while (list($aleatoire, $message, $date, $author) = mysql_fetch_array($com))
	{
			echo "<tr>\n";

			if ($author == $authorsend)
	{   
			$date = nkDate($date);
			echo "<td align=\"left\" style=\"width: 40%;\">" . $authorsend . "<b>". _USERPOSTER ."</b>". _POSTELE ."&nbsp;" . $date . "<img src=\"modules/Ticket/images/img_user.gif\" width=\"60\" height=\"19\" align=\"right\" /></td></tr>\n";
	}
			else
	{
			$date = nkDate($date);
			echo "<td align=\"left\" style=\"width: 40%;\">". _ADMINPOSTER ."<b>". $author ."</b>". _ADMINPOSTER1 ."". _POSTELE ."&nbsp;" . $date . "<img src=\"modules/Ticket/images/img_staff.gif\" width=\"60\" height=\"19\" align=\"right\" /></td></tr>\n";
	}
			echo "<tr><td align=\"left\" >" . $message . "</td></tr>\n";
	}
			echo "</table></center>\n";
			echo "<div style=\"text-align: center;\"><br />[ <a href=\"javascript:history.back();\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";

	}
	
    function send_repond($aleatoire, $message, $date, $author)
	{
			global $nuked, $user;
			
	 		$date = time();
			$autor = $user[2];
			$message = html_entity_decode($message);
			$message = mysql_real_escape_string(stripslashes($message));

			$sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_ticket_msg (aleatoire, message, date, author) VALUES ('".$aleatoire. "' , '".$message. "' , '".$date. "' , '".$autor. "')");
			
		 echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _REPONSSEND . "\n"
			. "</div>\n"
			. "</div>\n";
 
			redirect("index.php?file=Ticket&page=admin",3);
	}
	
	    function pref()
	{
        global $nuked, $user;
		
		 echo "<link rel=\"stylesheet\" href=\"modules/Ticket/css/colorpicker.css\" type=\"text/css\" />\n"
			. "<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"modules/Ticket/css/layout.css\" />\n"
			. "<script type=\"text/javascript\" src=\"modules/Ticket/js/jquery.js\"></script>\n"
			. "<script type=\"text/javascript\" src=\"modules/Ticket/js/colorpicker.js\"></script>\n"
			. "<script type=\"text/javascript\" src=\"modules/Ticket/js/eye.js\"></script>\n"
			. "<script type=\"text/javascript\" src=\"modules/Ticket/js/utils.js\"></script>\n"
			. "<script type=\"text/javascript\" src=\"modules/Ticket/js/layout.js?ver=1.0.2\"></script>\n";
		
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINTICKET . "" . _TCLOSE . "</h3>\n"
		    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/ticket.php\" rel=\"modal\">\n"
		    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
		    . "</div></div>\n"
		    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><a href=\"index.php?file=Ticket&amp;page=admin\">" . _OPENTICKET . "</a> | "
		    . "<a href=\"index.php?file=Ticket&amp;page=admin&amp;op=close_ticket\">" . _CLOSEDTICKET . "</a>| "
		    . "<b>" . _CONFIG . "</b><br><br />\n";	
			
			$sql = mysql_query("SELECT id, backadmin, backuser FROM ". $nuked['prefix'] ."_ticket WHERE id = '1'");
			while($row = mysql_fetch_assoc($sql))
			{			
		echo "<form method=\"post\" action=\"index.php?file=Ticket&amp;page=admin&amp;op=send_pref\"\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n"
			. "<tr><td width=\"20%\"><b>" . _BACKADMIN . " </b></td><td><input name=\"backadmin\" type=\"text\" maxlength=\"6\" size=\"6\" id=\"colorpickerField1\" value=\"" . $row['backadmin'] . "\" /></td></tr>\n"
			. "<tr><td><b>" . _BACKUSER . " </b></td><td><input type=\"text\" name=\"backuser\" maxlength=\"6\" size=\"6\" id=\"colorpickerField1\" value=\"" . $row['backuser'] . "\" /></td></tr>\n"
			. "<tr><td align=\"center\"><input type=\"submit\" name=\"send\" value=\"" . _SEND . "\" /></td><td></td></tr></table>\n";
			}
	}
	
	
	    function send_pref($backadmin, $backuser)
	{
			global $nuked, $user;
			
		 $sql = mysql_query("UPDATE ". $nuked["prefix"] ."_ticket SET `backadmin` = '". $backadmin ."' , `backuser` = '". $backuser ."' WHERE id='1' ");
		 
		 $texteaction = "". _PREFSEND ."". $aleatoire ."";
		 $acdate = time();
		 $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
			
		 echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _PREFSEND1 . "\n"
			. "</div>\n"
			. "</div>\n";
 
			redirect("index.php?file=Ticket&page=admin",3);
	}
	
    function close_ticket()
	{
			global $nuked, $user;
			
	     echo "<script type=\"text/javascript\">\n"
			. "<!--\n"
			. "\n"
			. "function del_ticket(pseudo, aleatoire)\n"
			. "{\n"
			. "if (confirm('" . _DELTICKET . " '+pseudo+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Ticket&page=admin&op=del_ticket&id='+aleatoire;}\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";
		
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINTICKET . "" . _TCLOSE . "</h3>\n"
		    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/ticket.php\" rel=\"modal\">\n"
		    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
		    . "</div></div>\n"
		    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><a href=\"index.php?file=Ticket&amp;page=admin\">" . _OPENTICKET . "</a> | "
		    . "<b>" . _CLOSEDTICKET . " </b>| "
		    . "<a href=\"index.php?file=Ticket&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a><br><br />\n";	
			
	    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		   . "<tr>\n"
		   . "<td style=\"width: 20%;\" align=\"center\"><b>" . _NICK . "</b></td>\n"
		   . "<td style=\"width: 15%;\" align=\"center\"><b>" . _AOBJET . "</b></td>\n"
		   . "<td style=\"width: 20%;\" align=\"center\"><b>" . _DATE . "</b></td>\n"
		   . "<td style=\"width: 15%;\" align=\"center\"><b>" . _AID . "</b></td>\n"
		   . "<td style=\"width: 10%;\" align=\"center\"><b>" . _AVOIR . "</b></td>\n"
		   . "<td style=\"width: 10%;\" align=\"center\"><b>" . _OUVRIRE . "</b></td>\n"
		   . "<td style=\"width: 10%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";				
			
			$sql = mysql_query("SELECT id, author, email, objet, service, aleatoire, date, statut FROM ". $nuked['prefix'] ."_ticket_send WHERE statut = '" . _FERMER . "' ORDER BY id DESC");
			while($row = mysql_fetch_assoc($sql))
	{
			$row['date'] = nkDate($row['date']);
		 echo "<tr><td style=\"width: 20%;\" align=\"center\">" . $row['author'] . "</td>\n"
	  		. "<td style=\"width: 15%;\" align=\"center\">" . $row['objet'] . "</td>\n"
			. " <td style=\"width: 20%;\"align=\"center\">" . $row['date'] . "</td>\n"
			. " <td style=\"width: 15%;\"align=\"center\">" . $row['aleatoire'] . "</td>\n"
			. " <td style=\"width: 10%;\" align=\"center\">\n"
			. " <a href=\"index.php?file=Ticket&amp;page=admin&amp;op=voir_ticket&amp;id=" . $row['aleatoire'] . "\"><img style=\"border: 0;\" src=\"modules/Ticket/images/voir.gif\" alt=\"\" title=\"" . _AAVOIR . "\" /></a></td>\n"
			. " <td style=\"width: 10%;\" align=\"center\">\n"
			. " <a href=\"index.php?file=Ticket&amp;page=admin&amp;op=ouvrir_ticket&amp;id=" . $row['aleatoire'] . "\"><img style=\"border: 0;\" src=\"modules/Ticket/images/open.gif\" alt=\"\" title=\"" . _AOPEN . "\" /></a></td>\n"
			. " <td style=\"width: 10%;\" align=\"center\"><a href=\"javascript:del_ticket('" . $row['author'] . "', '" . $row['aleatoire'] . "');\" title=\"" . _DELTICKET . "\">\n"
			. " <img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" /></a></td></tr>\n";
				  
	}
		echo "</table>\n";

	}
	
	
	function del_ticket($aleatoire, $id)
	{
			global $nuked, $user;

			$sql = mysql_query("DELETE FROM ". $nuked['prefix'] ."_ticket_msg WHERE aleatoire = '" . $aleatoire . "'");
			$sql = mysql_query("DELETE FROM ". $nuked['prefix'] ."_ticket_send WHERE aleatoire = '" . $aleatoire . "'");

			$texteaction = "". _ACTIONDELTICKET ."". $aleatoire ."";
			$acdate = time();
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");

		 echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _ADELTICKET . "\n"
			. "</div>\n"
			. "</div>\n";
				
			redirect("index.php?file=Ticket&page=admin", 2);
    }

	function fermer_ticket($aleatoire, $id, $statut)
   {	 
		 global $nuked, $user;
		 	   			   	   
		 $sql = mysql_query("UPDATE ". $nuked["prefix"] ."_ticket_send SET `statut` = '"._FERMER."' WHERE aleatoire=". mysql_real_escape_string($id) ." ");
		 
		 $texteaction = "". _ACTIONFERTICKET ."". $aleatoire ."";
		 $acdate = time();
		 $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		 
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _TICKETFERMER . "\n"
			. "</div>\n"
			. "</div>\n";

		redirect("index.php?file=Ticket&page=admin", 2);
			   
    }

	function ouvrir_ticket($aleatoire, $id, $statut)
   {	 
		 global $nuked, $user;
		 	   			   	   
		 $sql = mysql_query("UPDATE ". $nuked["prefix"] ."_ticket_send SET `statut` = '"._OPEN."' WHERE aleatoire=". mysql_real_escape_string($id) ." ");
		 
		 $texteaction = "". _ACTIONOUVTICKET ."". $aleatoire ."";
		 $acdate = time();
		 $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
		 
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _OPENTICKET . "\n"
			. "</div>\n"
			. "</div>\n";

		redirect("index.php?file=Ticket&page=admin", 2);
			   
    }
	
	
	 function voir_ticket($aleatoire)
	{
		 echo "<div class=\"content-box\">\n"
			. "<div class=\"content-box-header\"><h3>" . _ADMINTICKET . "" . _TCLOSE . "</h3>\n"
		    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/ticket.php\" rel=\"modal\">\n"
		    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
		    . "</div></div>\n"
		    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><a href=\"index.php?file=Ticket&amp;page=admin\">" . _OPENTICKET . "</a> | "
		    . "<b>" . _CLOSEDTICKET . " </b>| "
		    . "<a href=\"index.php?file=Ticket&amp;page=admin&amp;op=pref\">" . _CONFIG . "</a><br><br />\n";
			
		 global $bgcolor1, $bgcolor2, $bgcolor3, $nuked, $user;
		 $number = $aleatoire;
		 $sql = mysql_query("SELECT id, author, email, objet, service, aleatoire, date, statut FROM ". $nuked['prefix'] ."_ticket_send WHERE aleatoire = '" . $aleatoire . "'");
		 list($id, $authorsend, $email, $objet, $service, $aleatoire, $date, $statut) = mysql_fetch_array($sql);
		 
	     echo "<center><br /><table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"80%\" cellpadding=\"3\" cellspacing=\"3\">\n";
         $com = mysql_query("SELECT aleatoire, message, date, author FROM ". $nuked['prefix'] ."_ticket_msg WHERE aleatoire = '" . $aleatoire . "' ORDER BY date DESC");
		 while (list($aleatoire, $message, $date, $author) = mysql_fetch_array($com))
		{
		echo "<tr style=\"background: " . $bgcolor3 . ";\">\n";

		if ($author == $authorsend)
		{   
		    $date = nkDate($date);
			echo "<td align=\"left\" style=\"width: 40%;\">". _TICKET1 ."<b>" . $objet . "</b>&nbsp;:&nbsp;<b>" . $authorsend . "</b>". _USERPOSTER ."". _POSTELE ."&nbsp;" . $date . "<img src=\"modules/Ticket/images/img_user.gif\" width=\"60\" height=\"19\" align=\"right\" /></td></tr>\n";
		}
		else
		{
			$date = nkDate($date);
			echo "<td align=\"left\" style=\"width: 40%;\">". _TICKET1 ."<b>" . $objet . "</b>". _POSTEPAR ."". _ADMINPOSTER ."<b>". $author ."</b>". _ADMINPOSTER1 ."" . $date . "<img src=\"modules/Ticket/images/img_staff.gif\" width=\"60\" height=\"19\" align=\"right\" /></td></tr>\n";
		}
			$sql = mysql_query("SELECT id, backadmin, backuser FROM ". $nuked['prefix'] ."_ticket WHERE id = '1'");
			while($row = mysql_fetch_assoc($sql))
		{
			if ($row['backuser'] == NULL)
		{ 
			$bg1 ='';
		}
			else
		{ 
			$bg1 = "bgcolor=\"#" . $row['backuser'] . "\"";
		}
			if ($row['backadmin'] == NULL)
		{
			$bg2 ='';
		}
			else
		{	
			$bg2 = "bgcolor=\"#" . $row['backadmin'] . "\"";
		}	
			if ($author == $authorsend)
		{  	
			echo "<tr><td " . $bg1 . " align=\"left\">" . $message . "</td></tr>\n";
		}
			else
		{
			echo "<tr><td " . $bg2 . " align=\"left\">" . $message . "</td></tr>\n";
		}
	
		}
		}

		 echo "<tr style=\"background: " . $bgcolor3 . ";\"><td align=\"center\">" . $aleatoire . "<input  value=\"" . _BACK . "\" type=\"submit\" onclick=\"javascript:history.back()\"/></td></tr></table></center>\n";

	}
	
		switch ($_REQUEST['op'])
	{				
            default:
            main();
            break;
			
			case "close_ticket":
		    close_ticket();
		    break;
			
			case "pref":
		    pref();
		    break;
			
			case "send_pref":
		    send_pref($_REQUEST['backadmin'], $_REQUEST['backuser']);
		    break;
			
			case "reply":
		    reply($_REQUEST['aleatoire'] ,$_REQUEST['id'] , $_REQUEST['reply']);
		    break;
			
			case "voir_ticket":
		    voir_ticket($_REQUEST['id']);
		    break;
			
			case"send_repond":
		    send_repond($_REQUEST['aleatoire'], $_REQUEST['message'], $_REQUEST['date'],  $_REQUEST['autor']);
            break;
			
			case "del_ticket":
            del_ticket($_REQUEST['id'], $_REQUEST['aleatoire']);
            break;
			
			case "fermer_ticket":
		    fermer_ticket($_REQUEST['aleatoire'], $_REQUEST['id'], $_REQUEST['statut']);
		    break;
			
			case "ouvrir_ticket":
		    ouvrir_ticket($_REQUEST['aleatoire'], $_REQUEST['id'], $_REQUEST['statut']);
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