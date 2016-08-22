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
translate("modules/Email/lang/" . $language . ".lang.php");


$visiteur = $user ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

    	function select_user()
    	{
        	global $nuked;
		opentable();

        	$sql = mysql_query("SELECT id, pseudo, niveau FROM " . USER_TABLE . " WHERE niveau > 0 ORDER BY niveau DESC,date ,pseudo");
        	while (list($id_user, $pseudo, $niveau) = mysql_fetch_array($sql))
        	{
	    		$pseudo = stripslashes($pseudo);
            		echo "<option value=\"" . $id_user . "\">" . $pseudo . " ( " . $niveau . " )</option>\n";
        	} 
		closetable();
    	} 

	function main()
	{
		global $user;
		opentable();
		
		define('EDITOR_CHECK', 1);

		echo"	<br /><table style=\"background:transparent url(modules/Email/images/title.png) no-repeat top left; border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -webkit-border-radius: 10px 10px 0 0;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr style=\"height: 27px;\">
						<td>&nbsp;</td>
					</tr>
				</table>\n";
		
		echo "<form method=\"post\" action=\"index.php?file=Email&amp;op=send_message\">\n"
		. "<table width=\"96%\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\" style=\"margin-left:auto; margin-right:auto; text-align: center; border: 2px solid #c3c3c3\" align=\"center\">\n"
		. "  <tr>\n"
		. "    <td align=\"left\"><b>" . _AUTHOR . " :</td><td align=\"left\"></b> " . $user[2] . "</td>\n"
		. "  </tr>\n"
		. "  <tr>\n"
		. "    <td align=\"left\"><b>"._USERFOR."</b> : </td><td align=\"left\"><select name=\"niveau\" onchange=\"javascript:showorhide(this.value, 'perso');\">\n"
		. "      <option value=\"0\">"._ALLMEMBERS."</option>\n"
		. "      <option value=\"11\">"._TEAMMEMBERS."</option>\n"
		. "      <option value=\"1\">"._SITEMEMBERS."</option>\n"
		. "      <option value=\"2\">"._NIVOMEMBERS."2)</option>\n"
		. "      <option value=\"3\">"._NIVOMEMBERS."3)</option>\n"
		. "      <option value=\"4\">"._NIVOMEMBERS."4)</option>\n"
		. "      <option value=\"5\">"._NIVOMEMBERS."5)</option>\n"
		. "      <option value=\"6\">"._NIVOMEMBERS."6)</option>\n"
		. "      <option value=\"7\">"._NIVOMEMBERS."7)</option>\n"
		. "      <option value=\"8\">"._NIVOMEMBERS."8)</option>\n"
		. "      <option value=\"9\">"._ADMINMEMBERS."</option></select>\n"
		. "    </td>\n"
		. "  </tr>\n"
		. "  <tr>\n"
		. "    <td align=\"left\"><b>"._SUBJECT."</b> : </td><td align=\"left\"><input type=\"text\" id=\"subject\" name=\"subject\" maxlength=\"100\" size=\"43\" /></td>\n"
		. "  </tr>\n"
		. "  <tr>\n"
		. "    <td align=\"left\" valign=\"top\"><b>"._USERMESS." :</b></td><td align=\"center\"><textarea id=\"e_basic\" name=\"corps\" cols=\"70\" rows=\"15\"></textarea></td>\n"
		. "  </tr>\n"
		. "</table>\n";


		echo"	<table style=\"background:transparent url(modules/Email/images/title_bas.jpg) no-repeat top left; border-radius: 0 0 10px 10px; -moz-border-radius: 0 0 10px 10px; -webkit-border-radius: 0 0 10px 10px;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr style=\"height: 27px;\">
						<td style=\"text-align: center;\"><input type=\"submit\" value=\""._SEND."\" /></td>
					</tr>
				</table></form>\n";
		closetable();
	}
	
    	function send_message($subject, $corps, $niveau)
    	{
        	global $user, $nuked;
		opentable();

		$date = time();

        	
		if ($subject == "" || $corps == "")
        {
			echo"	<br />\n"
						. "<table style=\"background:transparent url(modules/Email/images/title.png) no-repeat top left; border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -webkit-border-radius: 10px 10px 0 0;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
						. "<tr style=\"height: 27px;\">\n"
						. "<td>&nbsp;</td>\n"
						. "</tr>\n"
						. "</table>\n"
						. "<table width=\"96%\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\" style=\"margin-left:auto; margin-right:auto; border: 2px solid #c3c3c3\">\n"
						. "<tr>\n"
						. "<td style=\"text-align: center;\" align=\"center\" valign=\"top\" width=\"50%\">" . _EMPTYFIELD . "</td>\n"
						. "</tr></table>\n"
						. "<table style=\"background:transparent url(modules/Email/images/title_bas.jpg) no-repeat top left; border-radius: 0 0 10px 10px; -moz-border-radius: 0 0 10px 10px; -webkit-border-radius: 0 0 10px 10px;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
						. "<tr style=\"height: 27px;\">\n"
						. "<td style=\"text-align: center;\"><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></td>\n"
						. "</tr>\n"
						. "</table>\n";
        }
	 	else
        {

				if ($niveau == 0)
				{
					$sql=mysql_query("SELECT mail FROM $nuked[prefix]"._users."");
				}

				if ($niveau > 0 && $niveau < 10)
				{
					$sql=mysql_query("SELECT mail FROM $nuked[prefix]"._users." WHERE niveau = '" . $niveau . "'");
				}

				if ($niveau == 11)
				{
					$sql=mysql_query("SELECT mail FROM $nuked[prefix]"._users." WHERE team > 0");
				}

				if ($niveau == 9)
				{
					$sql=mysql_query("SELECT mail FROM $nuked[prefix]"._users." WHERE niveau = '9'");
				}

				$corps =  $corps . "\r\n" . $nuked['name'] . "\r\n" . $nuked['slogan'] . "\r\nLe " . date('Y-m-d');
				$message = $corps;
				$titre = $subject;
				$from = "From: " . $nuked['name'] . " <" . $nuked['mail'] . ">\r\nReply-To: " . $nuked['mail'];

				while (list($mail) = mysql_fetch_array($sql))
				{
					$mail = @mail($mail, $titre, stripslashes($message), $from);
				}
		
				if($mail)
				{
				echo"	<br />\n"
						. "<table style=\"background:transparent url(modules/Email/images/title.png) no-repeat top left; border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -webkit-border-radius: 10px 10px 0 0;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
						. "<tr style=\"height: 27px;\">\n"
						. "<td>&nbsp;</td>\n"
						. "</tr>\n"
						. "</table>\n"
						. "<table width=\"96%\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\" style=\"margin-left:auto; margin-right:auto; border: 2px solid #c3c3c3\">\n"
						. "<tr>\n"
						. "<td style=\"text-align: center;\" align=\"center\" valign=\"top\" width=\"50%\">" . _MESSSEND . "</td>\n"
						. "</tr></table>\n"
						. "<table style=\"background:transparent url(modules/Email/images/title_bas.jpg) no-repeat top left; border-radius: 0 0 10px 10px; -moz-border-radius: 0 0 10px 10px; -webkit-border-radius: 0 0 10px 10px;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
						. "<tr style=\"height: 27px;\">\n"
						. "<td style=\"text-align: center;\">&nbsp;</td>\n"
						. "</tr>\n"
						. "</table>\n";
						redirect("index.php?file=Email", 2);
				}
				else
				{
				echo"	<br />\n"
						. "<table style=\"background:transparent url(modules/Email/images/title.png) no-repeat top left; border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -webkit-border-radius: 10px 10px 0 0;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
						. "<tr style=\"height: 27px;\">\n"
						. "<td>&nbsp;</td>\n"
						. "</tr>\n"
						. "</table>\n"
						. "<table width=\"96%\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\" style=\"margin-left:auto; margin-right:auto; border: 2px solid #c3c3c3\">\n"
						. "<tr>\n"
						. "<td style=\"text-align: center;\" align=\"center\" valign=\"top\" width=\"50%\">" . _MESSSNOEND . "</td>\n"
						. "</tr></table>\n"
						. "<table style=\"background:transparent url(modules/Email/images/title_bas.jpg) no-repeat top left; border-radius: 0 0 10px 10px; -moz-border-radius: 0 0 10px 10px; -webkit-border-radius: 0 0 10px 10px;\" align=\"center\" width=\"96%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
						. "<tr style=\"height: 27px;\">\n"
						. "<td style=\"text-align: center;\">[ <a href=\"javascript:history.back()\"><b>"._BACK."</b></a> ]</td>\n"
						. "</tr>\n"
						. "</table>\n";		
				}
		}
		closetable();
	}
	


  switch ($_REQUEST['op'])
   {
     case"send_message":
	 send_message($_REQUEST['subject'],$_REQUEST['corps'],$_REQUEST['niveau']);
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
