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
    die ("<div style=\"text-align: center;\">Vous ne pouvez pas ouvrir cette page directement</div>");
}

global $nuked, $user, $language;
translate("modules/Ticket/lang/" . $language . ".lang.php");

if ($user)
{
    $visiteur = $user[1];
}
else
{
    $visiteur = 0;
}

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{
    compteur("Ticket");

    function index()
    {
		global $bgcolor1, $bgcolor2, $bgcolor3, $nuked, $user;

		 echo "<table style=\"border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" cellpadding=\"2\" cellspacing=\"3\">\n"
			. "<tr><td style=\"width: 100%;\" align=\"center\"><b>" . _TICKET . "&nbsp;-&nbsp;<a href=\"index.php?file=Ticket&op=new_ticket\">" . _NEWTICKET . "</b></a></td></tr></table>\n";
		 $sql = mysql_query("SELECT author FROM ". $nuked['prefix'] ."_ticket_send WHERE author = '" . $user[2] . "'");
		 list($author) = mysql_fetch_array($sql);
		
		if  ($author == $user[2])
		{
		 echo "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" cellpadding=\"2\" cellspacing=\"1\">\n"
            . "<tr style=\"background: " . $bgcolor3 . ";\">\n"
			. "<td style=\"width: 40%;\" align=\"center\"><b>" . _SUJET . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _DATE . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _STATUT . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _VISU . "</b></td></tr>\n";
		}
		else{ echo"<br><br /><div style=\"text-align:center\"><b><big>" . _NOTICKET . "</big></b></div>\n";}
			
		 $sql = mysql_query("SELECT id, author, email, objet, service, aleatoire, date, statut FROM ". $nuked['prefix'] ."_ticket_send WHERE author = '" . $user[2] . "' ORDER BY statut DESC, id  DESC LIMIT 0, 20");
		 while($row = mysql_fetch_assoc($sql))
		 {
			$row['date'] = nkDate($row['date']);

        echo "<tr><td style=\"width: 40%;\" align=\"center\">" . $row['objet'] . "</td>\n"
			."<td style=\"width: 20%;\" align=\"center\">" . $row['date'] . "</td>\n"
			."<td style=\"width: 20%;\"align=\"center\">" . $row['statut'] . "</td>\n";
		 if ($row['statut'] == "Ouvert")
		 {
		 echo "<td style=\"width: 20%;\" align=\"center\"><a title=\"". _VIEW . "" . $row['objet'] . "\" href=\"index.php?file=Ticket&amp;op=voir_ticket&amp;id=" . $row['aleatoire'] . "\">
		       <img src=\"modules/Ticket/images/voir.gif\" width=\"16\" height=\"16\"/></b></a>
			   <a title=\"". _CLOSE . "" . $row['objet'] . "\" href=\"index.php?file=Ticket&op=fermer_ticket&amp;id=" . $row['aleatoire'] . "\">&nbsp;
		       <img src=\"modules/Ticket/images/close.gif\" width=\"16\" height=\"16\"/></b></a></td></tr>\n";
		                                             
		 }
		 else
		 {
		 echo "<td style=\"width: 20%;\"align=\"center\"><b> <img src=\"modules/Ticket/images/close2.gif\" width=\"16\" height=\"16\"/></b></td></tr>\n"; 
		 }
		 }
		 echo "</table>
		 <div style=\"display:none;color: #000;\"><a href='http://www.palacewar.eu' title='PalaceWaR'>&copy;</a></div>\n";

			   		
	}
	 function voir_ticket($aleatoire)
	{
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
			echo "<td align=\"left\" style=\"width: 40%;\">". _TICKET1 ."<b>" . $objet . "</b>". _VOUS ."". _POSTELE ."&nbsp;" . $date . "<img src=\"modules/Ticket/images/img_user.gif\" width=\"60\" height=\"19\" align=\"right\" /></td></tr>\n";
		}
		else
		{
			$date = nkDate($date);
			echo "<td align=\"left\" style=\"width: 40%;\">". _TICKET1 ."<b>" . $objet . "</b>". _POSTEPAR ."<b>". $author . "</b>". _POSTELE ."&nbsp;" . $date . "<img src=\"modules/Ticket/images/img_staff.gif\" width=\"60\" height=\"19\" align=\"right\" /></td></tr>\n";
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

		 echo "<tr style=\"background: " . $bgcolor3 . ";\"><td align=\"center\">" . $aleatoire . "<input value=\"" . _REPOND . "\" type=\"submit\" OnClick=\"window.location.href='index.php?file=Ticket&op=repond_ticket&amp;id=" . $number . "'\"/>&nbsp;
		       <input  value=\"" . _FERMER . "\" type=\"submit\" OnClick=\"window.location.href='index.php?file=Ticket&op=fermer_ticket&amp;id=" . $number . "'\"/>&nbsp;
			   <input  value=\"" . _BACK . "\" type=\"submit\" onclick=\"javascript:history.back()\"/></td></tr></table></center>
			   <div style=\"display:block;color: #000;\"><a href='http://www.palacewar.eu' title='PalaceWaR'>&copy;</a></div>\n";
	}
	
	 function repond_ticket($aleatoire)
    {
		global $bgcolor1, $bgcolor2, $bgcolor3, $nuked, $user;
		define('EDITOR_CHECK', 1);
		
		 $sql = mysql_query("SELECT id, author, email, objet, service, aleatoire, date, statut FROM ". $nuked['prefix'] ."_ticket_send WHERE aleatoire = '" . $aleatoire . "'");
		 while($row = mysql_fetch_assoc($sql))
		 {
		       $row['date'] = nkDate($row['date']);
		
		 echo "<center><br /><form method=\"post\" action=\"index.php?file=Ticket&op=send_repond\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ticket_texte');\">\n"
		    . "<table style=\"border: 1px solid " . $bgcolor3 . ";\" width=\"80%\" cellpadding=\"2\" cellspacing=\"3\">\n"
			. "<tr><td style=\"width: 80%;\" align=\"center\"><b>" . _REPONDTICKET . "</b></a></td></tr></table>\n";
			
		 echo "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"80%\" cellpadding=\"3\" cellspacing=\"2\">\n"
			. "<tr><td style=\"background: " . $bgcolor3 . ";\" width=\"30%\"><div align=\"right\"><b>" . _OBJET . "</b></div></td>\n"
			. "<td><input style=\"width:98%\" type=\"text\" value=\"" . $row['objet'] . "\" readonly=\"true\"></td></tr>\n"
			. "<tr><td style=\"background: " . $bgcolor3 . ";\"><div align=\"right\"><b>" . _DATE1 . "</b></div></td>\n"
			. "<td><input style=\"width:98%\" type=\"text\" value=\"" . $row['date'] . "\" readonly=\"true\"></td></tr>\n"
			. "<tr><td style=\"background: " . $bgcolor3 . ";\"><div align=\"right\"><b>" . _ID . "</b></div></td>\n"
			. "<td><input style=\"width:98%\"type=\"text\" value=\"" . $row['aleatoire'] . "\" readonly=\"true\"></td></tr></table><br />\n"
			
			."<table style=\"background: " . $bgcolor2 . ";border: 0px solid " . $bgcolor3 . ";\" width=\"80%\" cellpadding=\"3\" cellspacing=\"2\">\n"
            ."<tr><td><div align=\"center\"><textarea id=\"e_basic\" name=\"message\" cols=\"65\" rows=\"10\" 
			  onselect=\"storeCaret('ticket_texte');\" onclick=\"storeCaret('ticket_texte');\" onkeyup=\"storeCaret('ticket_texte');\"></textarea></div></td></tr>\n"
			. "<tr><td align=\"center\"><br /><input type=\"hidden\" name=\"aleatoire\" value=\"" . $aleatoire . "\" /><input type=\"submit\" name=\"send\" value=\"" . _SEND . "\" />&nbsp;<input type=\"button\" value=\"" . _CANCEL . "\" onclick=\"javascript:history.back()\" />\n"
			. "</td></tr></table></form><br /></center>
			   <div style=\"display:none;color: #000;\"><a href='http://www.palacewar.eu' title='PalaceWaR'>&copy;</a></div>\n";

		 }
	}
	
     function new_ticket()
    {
		global $bgcolor1, $bgcolor2, $bgcolor3, $nuked, $user;
		define('EDITOR_CHECK', 1);
		
		$sql = mysql_query("SELECT mail FROM " . USER_TABLE . " WHERE pseudo = '" . $user[2] . "'");
		list($email) = mysql_fetch_array($sql);
		
		echo "<center><br /><form method=\"post\" action=\"index.php?file=Ticket&op=send_ticket\" enctype=\"multipart/form-data\" onsubmit=\"backslash('ticket_texte');\">\n"
		. "<table style=\"border: 1px solid " . $bgcolor3 . ";\" width=\"80%\" cellpadding=\"2\" cellspacing=\"3\">\n"
		. "<tr><td style=\"width: 80%;\" align=\"center\"><b>" . _NEWTICKET . "</b></a></td></tr></table>\n";
		
		echo "<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"80%\" cellpadding=\"1\" cellspacing=\"2\">\n"
		. "<tr><td style=\"background: " . $bgcolor3 . ";\" width=\"30%\"><div align=\"right\"><b>" . _NOM . "</b></div></td>\n"
		. "<td width=\"70%\"><input style=\"width:98%\" type=\"text\" name=\"author\" value=\"&nbsp;" . $user[2] . "\" readonly=\"true\"></td></tr>\n"
		. "<tr><td style=\"background: " . $bgcolor3 . ";\"><div align=\"right\"><b>" . _EMAIL . "</b></div></td>\n"
		. "<td><input style=\"width:98%\" type=\"text\" value=\"". $email ."\" name=\"email\" readonly=\"true\"></td></tr>\n"
		. "<tr><td style=\"background: " . $bgcolor3 . ";\"><div align=\"right\"><b>" . _OBJET . "</b></div></td>\n"
		. "<td><input style=\"width:98%\" type=\"text\" value=\"". _REMP ."\" onClick=\"if (this.value=='". _REMP ."') this.value=''\" name=\"objet\"></td></tr>\n"
		. "<tr><td style=\"background: " . $bgcolor3 . ";\"><div align=\"right\"><b>" . _SERVICE . "</b></div></td>\n"
		. "<td><select style=\"width:100%\" name=\"service\"><option>Aucun</option><option>Modules</option><option>Patch</option></select></td></tr></table><br />\n"
		
		."<table style=\"background: " . $bgcolor2 . ";border: 0px solid " . $bgcolor3 . ";\" width=\"80%\" cellpadding=\"3\" cellspacing=\"2\">\n"
		."<tr><td><div align=\"center\"><textarea id=\"e_basic\" name=\"message\" cols=\"65\" rows=\"10\" 
		  onselect=\"storeCaret('ticket_texte');\" onclick=\"storeCaret('ticket_texte');\" onkeyup=\"storeCaret('ticket_texte');\"></textarea></div></td></tr>\n"
		. "<tr><td align=\"center\"><br /><input type=\"submit\" name=\"send\" value=\"" . _SEND . "\" />&nbsp;<input type=\"button\" value=\"" . _CANCEL . "\" onclick=\"javascript:history.back()\" />\n"
	    . "</td></tr></table></form><br /></center>
		   <div style=\"display:none;color: #000;\"><a href='http://www.palacewar.eu' title='PalaceWaR'>&copy;</a></div>\n";

	}
	
 function send_ticket($author, $email, $objet, $service, $aleatoire, $date, $statut, $message)
 {
	   global $nuked, $user;
	 
	   echo "<br /><br /><div style=\"text-align: center; font-weight:bold;\">"._TICKETSEND."</div><br /><br />";
	   $date = time();
	   $autor = $user[2];
	   $message = html_entity_decode($message);
	   $message = mysql_real_escape_string(stripslashes($message));
	   $aleatoire = mt_rand();
	   $open = "". _OPEN ."";

	   $sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_ticket_send (author, email, objet, service, aleatoire, date, statut) VALUES ('".$autor."' , '".$email. "' , '".$objet. "' , '".$service. "' , '".$aleatoire. "' , '".$date. "' , '".$open."')");

	   $insert = mysql_query("INSERT INTO ". $nuked['prefix'] ."_ticket_msg (aleatoire, message, date, author) VALUES ('".$aleatoire. "' , '".$message. "', '".$date. "', '".$autor. "')");
 
	   redirect("index.php?file=Ticket",3);
 }
 
  function send_repond($aleatoire, $message, $date, $author)
 {
	 global $nuked, $user;
	 
	   echo "<br /><br /><div style=\"text-align: center; font-weight:bold;\">"._REPONSSEND."</div><br /><br />";
	   $date = time();
	   $autor = $user[2];
	   $message = html_entity_decode($message);
	   $message = mysql_real_escape_string(stripslashes($message));

       $sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_ticket_msg (aleatoire, message, date, author) VALUES ('".$aleatoire. "' , '".$message. "' , '".$date. "' , '".$autor. "')");
 
	   redirect("index.php?file=Ticket&op=voir_ticket&id=".$aleatoire. "",3);
 }
 
   function fermer_ticket($aleatoire, $id, $number, $statut)
 {	 
       global $nuked, $user;
	   
	   $aleatoire = $number;
			   
	   echo "<br /><br /><div style=\"text-align: center; font-weight:bold;\">"._TICKETFERMER."</div><br /><br />";
	   
       $sql = mysql_query("UPDATE ". $nuked["prefix"] ."_ticket_send SET `statut` = '"._FERMER."' WHERE aleatoire=". mysql_real_escape_string($aleatoire) ." ");

	   
	  redirect("index.php?file=Ticket",3);
			   
 }
	
        switch ($_REQUEST['op'])
        {
        default:
		opentable();
		index();
		closetable();
		break;	
		
		case "new_ticket":
		new_ticket();
		break;
		
		case "repond_ticket":
		opentable();
		repond_ticket($_REQUEST['id']);
		closetable();
		break;
		
		case "voir_ticket":
		opentable();
		voir_ticket($_REQUEST['id']);
		closetable();
		break;
		
		case "fermer_ticket":
		fermer_ticket($_REQUEST['aleatoire'], $_REQUEST['number'], $_REQUEST['id'], $_REQUEST['statut']);
		break;
		
		case"send_ticket":
		send_ticket($_REQUEST['autor'], $_REQUEST['email'], $_REQUEST['objet'], $_REQUEST['service'], $_REQUEST['aleatoire'], $_REQUEST['date'], $_REQUEST['statut'], $_REQUEST['message']);
		break;
		
		case"send_repond":
		send_repond($_REQUEST['aleatoire'], $_REQUEST['message'], $_REQUEST['date'],  $_REQUEST['autor']);
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