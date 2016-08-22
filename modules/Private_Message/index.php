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

global $nuked, $language, $user;
translate("modules/Userbox/lang/" . $language . ".lang.php");
translate("modules/Private_Message/lang/" . $language . ".lang.php");

$visiteur = $user ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

    function select_team($team_for)
    {
       	global $nuked;
		
		/*$sql = mysql_query('SELECT id, pseudo FROM '.USER_TABLE.' WHERE team = '.$team_for.' || team2 = '.$team_for.' || team3 = '.$team_for.' ORDER BY niveau DESC, pseudo');
		while($row = mysql_fetch_assoc($sql))
		{				
			echo '<option value="'.$row['id'].'">'.$row['pseudo'].'</option>';
		}
		
		echo'<option value="">' . _TEAM . '</option>';*/
		$sql = mysql_query('SELECT id, pseudo FROM '.USER_TABLE.' WHERE game = '.$team_for.' ORDER BY pseudo ASC');
		while($row = mysql_fetch_assoc($sql))
		{				
			echo '<option value="'.$row['id'].'">'.$row['pseudo'].'</option>';
		}
    } 
	
    function select()
    {
       	global $nuked;
		
		/*echo'<option value="" style="text-align:center;">' . _TEAM . '</option>';
		$sql2 = mysql_query('SELECT cid, titre FROM '.TEAM_TABLE.' ORDER BY titre ASC');
		while($row = mysql_fetch_assoc($sql2))
		{				
			echo ' <option value="'.$row['cid'].'" style="text-align:left;">'.$row['titre'].'</option>';
		}
		
		echo'<option value="">' . _GAME . '</option>';*/
		$sql3 = mysql_query('SELECT id, name FROM '.GAMES_TABLE.' ORDER BY name ASC');
		while($row = mysql_fetch_assoc($sql3))
		{				
			echo ' <option value="'.$row['id'].'" style="text-align:left;">'.$row['name'].'</option>';
		}
    } 

    function main()
    {
       	global $nuked;
		opentable();
				
	echo"	<br />
			<table style=\"background:transparent url(modules/Email/images/title.png) no-repeat top left; border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -webkit-border-radius: 10px 10px 0 0;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				<tr style=\"height: 27px;\">
					<td>&nbsp;</td>
				</tr>
			</table>\n";
			
	echo "<form method=\"post\" action=\"index.php?file=Private_Message&amp;op=message\" name =\"onglet\">\n"
		. "<table width=\"96%\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\" style=\"margin-left:auto; margin-right:auto; border: 2px solid #c3c3c3\" align=\"center\">\n"
		. "  <tr>\n"
		. "    	<td align=\"center\"><b>" . _SELECT . " :</td><td align=\"left\"></b>\n"
		. "			<select name=\"team_for\" onchange=\"onglet.submit()\" style=\"text-align:center;\"><option>" . _CHOOSE . "</option>\n";
							select();	
		echo "		</select>\n"
		. "		</td>\n"
		. "  </tr>\n"
		. "</table></form>\n";

	echo"	<table style=\"background:transparent url(modules/Email/images/title_bas.jpg) no-repeat top left; border-radius: 0 0 10px 10px; -moz-border-radius: 0 0 10px 10px; -webkit-border-radius: 0 0 10px 10px;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				<tr style=\"height: 27px;\">
					<td style=\"text-align: center;\">[ <a href=\"index.php\"><b>"._BACK."</b></a> ]</td>
				</tr>
			</table>\n";		
			
		closetable();
   	} 

	function message($team_for)
	{
		global $user;
		opentable();
		
		define('EDITOR_CHECK', 1);
				
	 echo "<script type=\"text/javascript\">\n"
	    . "<!--\n"
	    . "\n"
	    . "function verifchamps()\n"
	    . "{\n"
	    . "if (document.getElementById('subject').value.length == 0)\n"
	    . "{\n"
	    . "alert('". _NOSUBJECT ."');\n"
	    . "return false;\n"
	    . "}\n"
	    . "if (document.getElementById('corps').value.length == 0)\n"
	    . "{\n"
	    . "alert('". _NOTEXTMAIL ."');\n"
	    . "return false;\n"
	    . "}\n"
	    . "return true;\n"
	    . "}\n"
	    . "\n"
	    . "// -->\n"
	    . "</script>\n";

		echo"	<br /><table style=\"background:transparent url(modules/Email/images/title.png) no-repeat top left; border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -webkit-border-radius: 10px 10px 0 0;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr style=\"height: 27px;\">
						<td>&nbsp;</td>
					</tr>
				</table>\n";
		
		echo "<form method=\"post\" action=\"index.php?file=Private_Message&amp;op=send_message\" onsubmit=\"return verifchamps()\">\n"
		. "<table width=\"96%\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\" style=\"margin-left:auto; margin-right:auto; border: 2px solid #c3c3c3\">\n"
		. "  <tr>\n"
		. "    <td align=\"left\" width=\"15%\"><b>" . _AUTHOR . " :</td><td align=\"left\"></b> " . $user[2] . "</td>\n"
		. "  </tr>\n"
		. "  <tr>\n"
		. "		<td align=\"left\" valign=\"top\"><b>"._USERFOR."</b> : </td><td align=\"left\">\n"
		. "			<select name=\"user_for[]\" multiple >\n";
							select_team($team_for);	
		echo "		</select>\n"
		. "		</td>\n"
		. "  </tr>\n"
		. "  <tr>\n"
		. "    <td align=\"left\"><b>"._SUBJECT."</b> : </td><td align=\"left\"><input type=\"text\" id=\"subject\" name=\"subject\" maxlength=\"100\" size=\"43\" /></td>\n"
		. "  </tr>\n"
		. "  <tr>\n"
		. "    <td align=\"left\" valign=\"top\"><b>"._USERMESS." :</b></td><td align=\"center\"><textarea id=\"e_basic\" name=\"corps\" cols=\"70\" rows=\"15\"></textarea></td>\n"
		. "  </tr>\n"
		. "  <tr>\n"
		. "    <td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" value=\""._SEND."\" />&nbsp;<input type=\"button\" value=\"" . _CANCEL . "\" onclick=\"javascript:history.back()\" /></td>\n"
		. "  </tr>\n"
		. "</table></form>\n";


		echo"	<table style=\"background:transparent url(modules/Email/images/title_bas.jpg) no-repeat top left; border-radius: 0 0 10px 10px; -moz-border-radius: 0 0 10px 10px; -webkit-border-radius: 0 0 10px 10px;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr style=\"height: 27px;\">
						<td style=\"text-align: center;\">&nbsp;</td>
					</tr>
				</table>\n";
		closetable();
	}

	
   	function send_message($subject, $user_for, $corps)
   	{
       	global $user, $nuked;
		opentable();

		if (empty($subject) || empty($user_for) || empty($corps))
		{
				echo '<br /><br /><div style="text-align:center;">'._EMPTYFIELD.'<br /><br /><a href="javascript:history.back()"><b>'._BACK.'</b></a></div><br /><br />';
		}
		else
		{			
			$flood = mysql_query("SELECT date FROM " . USERBOX_TABLE . " WHERE user_from = '" . $user[0] . "' ORDER BY date DESC LIMIT 0, 1");
			list($flood_date) = mysql_fetch_array($flood);
			$anti_flood = $flood_date + $nuked['post_flood'];
			$date = time();
				
			if ($date < $anti_flood)
			{
				echo '<br /><br /><div style="text-align:center;">'._NOFLOOD.'</div><br /><br />';
				redirect('index.php?file=Userbox', 2);
				closetable();
				footer();
				exit();
			}
			
			echo"<br />\n"
				. "<table style=\"background:transparent url(modules/Email/images/title.png) no-repeat top left; border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -webkit-border-radius: 10px 10px 0 0;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
				. "	<tr style=\"height: 27px;\">\n"
				. "		<td>&nbsp;</td>\n"
				. "	</tr>\n"
				. "</table>\n"
				. "<table width=\"96%\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\" style=\"margin-left:auto; margin-right:auto; border: 2px solid #c3c3c3\">\n"
				. "  <tr>\n"
				. "    <td align=\"left\" valign=\"top\" width=\"50%\">" . _MESSSEND . ": </td><td align=\"left\" style=\"color: green;\">\n";
			
			foreach ($_POST['user_for'] as $i=>$user_for) 
			{				
				$corps = secu_html(html_entity_decode($corps));
				$subject = mysql_real_escape_string(stripslashes($subject));
				$corps = mysql_real_escape_string(stripslashes($corps));
				$user_for = mysql_real_escape_string(stripslashes($user_for));
				$subject = htmlentities($subject);
				
				$sql = mysql_query("INSERT INTO " . USERBOX_TABLE . " ( `mid` , `user_from` , `user_for` , `titre` , `message` , `date` , `status` ) VALUES ( '' , '{$user[0]}' , '$user_for' , '$subject' , '$corps' , '$date' , '0' )");
				
				$sq = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $user_for . "'");
				list($pseudo) = mysql_fetch_array($sq);
				echo $pseudo. "<br />";
			}	
			
		echo"	</td></tr></table><table style=\"background:transparent url(modules/Email/images/title_bas.jpg) no-repeat top left; border-radius: 0 0 10px 10px; -moz-border-radius: 0 0 10px 10px; -webkit-border-radius: 0 0 10px 10px;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr style=\"height: 27px;\">
						<td style=\"text-align: center;\">[ <a href=\"index.php\"><b>"._BACK."</b></a> ]</td>
					</tr>
				</table>\n";
				
			redirect("index.php?file=Private_Message", 3);
		}		
		closetable();
	}


  switch ($_REQUEST['op'])
   {
     case"send_message":
	 send_message($_REQUEST['subject'],$_REQUEST['user_for'],$_REQUEST['corps']);
	 break;
	 
     case"message":
	 message($_REQUEST['team_for']);
	 break;
	
   	 default :
	 main();
	 break;
   } 

	
}
else if ($level_access == -1)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    closetable();
}
else if ($level_access == 1 && $visiteur == 0)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | "
    . "<a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b></div><br /><br />";
    closetable();
}
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    closetable();
}

?>
