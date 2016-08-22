<?php 
// -------------------------------------------------------------------------//
// Tournament Module written by L@pinViolent from ArSeNaL (2006) - V1.4     //
// http://www.team-arsenal.com                                              //
// Contact me at lapinviolent@hotmail.fr                                    //
//                                                                          //
// Edit by Grillon69 from V1.4 to V1.4.1                                    //
// http://la-team-69.verygames.net                                          //
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

global $user, $language, $rep_img;
translate("modules/Tournament/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");


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
    define("TOURNAMENT_TEAM_TABLE", $nuked['prefix'] . "_tournament_team");
    define("TOURNAMENT_INTRO_TABLE", $nuked['prefix'] . "_tournament_intro");
    define("TOURNAMENT_MATCH_TABLE", $nuked['prefix'] . "_tournament_match");
    define("_DEMANDETOTALPOST","Nombre de demandes postées au total");
    define("_STATSDEMANDE","Statistiques des Matchs");
    define("_REMETTREAZERO","Remettre les Stats à Zéro");
    define("_STATSZEROOK","Statistiques remises à zéro avec succès");
    define("_SURZERO","Etês vous sur de vouloir remettre les Stats à Zéro ?");
	
    $rep_img = "upload/Tournament/";

// -------------------------------------------------------------------------//
// List of the Tournament's matches                                             //
// -------------------------------------------------------------------------//
    function main()
    {
        global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3;
     echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>" . _ADMINTOURNAMENT . "</h3>\n"
    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Tournament.html\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">" . _MATCHES . "<b> | "
	. "<a href=\"index.php?file=Tournament&amp;page=admin&amp;op=main_team\">" . _TEAMS . "</a> | "
	. "<a href=\"index.php?file=Tournament&amp;page=admin&amp;op=main_pref\">" . _TOURNAMENTPREFS . "</a></b></div><br />\n"
    . "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
	. "<tr>\n"
	. "<td style=\"width: 30%;\" align=\"center\"><b>" . _MATCHTITLE . "</b></td>\n"
	. "<td style=\"width: 30%;\" align=\"center\"><b>" . _TOURNAMENTDATE . "</b></td>\n"
	. "<td style=\"width: 30%;\" align=\"center\"><b>" . _WINNER . "</b></td>\n"
	. "<td style=\"width: 10%;\" align=\"center\"><b>" . _MATCHEDIT . "</b></td></tr>\n";

	$bgcolor = $bgcolor2;
        $sql = mysql_query("SELECT id, title, date, winner FROM " . TOURNAMENT_MATCH_TABLE );
        while(list($matchid, $title, $date, $winner) = mysql_fetch_row($sql))
        {
          if($winner == 0)
          {
            $windispl = _TOPLAY;
          }
          else
          {
            $sql2 = mysql_query("SELECT name FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = " . $winner);
            list($name) = mysql_fetch_row($sql2);
            $windispl = $name;
          }
           $date = strftime("%x", $date);
          echo"	<tr>
        	<td><a href=\"index.php?file=Tournament&amp;page=admin&amp;op=edit_match&matchid=".$matchid."\">" . constant($title) . "</a></td>\n
        	<td align=\"center\">" . $date . "</td>\n
        	<td align=\"center\">" . $windispl . "</td>\n
        	<td align=\"center\"><a href=\"index.php?file=Tournament&amp;page=admin&amp;op=edit_match&matchid=".$matchid."\"><img src=\"images/edit.gif\" border=\"0\"></<a></td></tr>\n";
        	
          //if($bgcolor == $bgcolor1) { $bgcolor = $bgcolor2; } else { $bgcolor = $bgcolor1; }
        }
        
        echo "</table>\n";
        echo "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Admin\"><b>" . _TOURNAMENTBACK . "</b></a> ]</div><br /></div></div>";
    } 
    

// -------------------------------------------------------------------------//
// List of the Tournament's teams                                               //
// -------------------------------------------------------------------------//
    function main_team()
    {
        global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3;

        echo"<script type=\"text/javascript\">\n"
	."<!--\n"
	."\n"
	. "function del_team(name, id)\n"
	. "{\n"
	. "if (confirm('" . _DELETETEAM . " '+name+' ! " . _TOURNAMENTCONFIRM . "'))\n"
	. "{document.location.href = 'index.php?file=Tournament&page=admin&op=do_removeteam&teamid='+id;}\n"
	. "}\n"
    	. "\n"
	. "// -->\n"
	. "</script>\n";
    
	 echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>" . _ADMINTOURNAMENT . "</h3>\n"
    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Tournament.html\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Tournament&amp;page=admin\">" . _MATCHES . "</a> | </b>"
	. _TEAMS . "<b> | "
	. "<a href=\"index.php?file=Tournament&amp;page=admin&amp;op=main_pref\">" . _TOURNAMENTPREFS . "</a></b></div><br />\n"
    . "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
	. "<tr>\n"
	. "<td style=\"width: 20%;\" align=\"center\"><b>" . _TEAMS . "</b></td>\n"
	. "<td style=\"width: 15%;\" align=\"center\"><b>" . _LEADER . "</b></td>\n"
	. "<td style=\"width: 20%;\" align=\"center\"><b>" . _MAIL . "</b></td>\n"
	. "<td style=\"width: 15%;\" align=\"center\"><b>" . _INSCRIPTION . "</b></td>\n"
	. "<td style=\"width: 10%;\" align=\"center\"><b>" . _MATCHEDIT . "</b></td>\n"
	. "<td style=\"width: 10%;\" align=\"center\"><b>" . _TEAMDEL . "</b></td></tr>\n";

	$bgcolor = $bgcolor2;
        $sql = mysql_query("SELECT id, name, leader, mail, validated FROM " . TOURNAMENT_TEAM_TABLE );
        while(list($id, $name, $leader, $mail, $validated) = mysql_fetch_row($sql))
        {
          echo"	<tr>
        	<td>" . $name . "</td>\n
        	<td align=\"center\">" . $leader . "</td>\n
        	<td align=\"center\">" . $mail . "</td>\n";
        	
          if($validated == 1)
          {
            echo"	<td align=\"center\">" . _CONFIRMED . "</td>\n";
          }
          else
          {
            echo"	<td align=\"center\">" . _TOBECONFIRMED . "</td>\n";
          }
          
          echo"	<td align=\"center\"><a href=\"index.php?file=Tournament&page=admin&op=edit_team&teamid=".$id."\"><img src=\"images/edit.gif\" border=\"0\"></a></td>\n";
          echo"	<td align=\"center\"><a href=\"javascript:del_team('".$name."', '".$id."');\"><img src=\"images/del.gif\" border=\"0\"></a></td></tr>\n";
        	
          //if($bgcolor == $bgcolor1) { $bgcolor = $bgcolor2; } else { $bgcolor = $bgcolor1; }
        }
        
        echo "</table>\n";
        echo "<br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Admin\"><b>" . _TOURNAMENTBACK . "</b></a> ]</div><br /></div></div>";
    } 
    
    
// -------------------------------------------------------------------------//
// Remove a team                                                            //
// -------------------------------------------------------------------------//
    function do_removeteam($teamid)
    {
        global $nuked;

        $upd = mysql_query("DELETE FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = " . $teamid);
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _TEAMREMOVED . "\n"
			. "</div>\n"
			. "</div>\n";
        redirect("index.php?file=Tournament&page=admin&op=main_team", 2);
    } 

    
// -------------------------------------------------------------------------//
// Modify Tournament's preferences                                          //
// -------------------------------------------------------------------------//
    function main_pref()
    {
        global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3;
      
	echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>" . _ADMINTOURNAMENT . "</h3>\n"
	. "</div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Tournament&amp;page=admin\">" . _MATCHES . "</a> | "
	. "<a href=\"index.php?file=Tournament&amp;page=admin&amp;op=main_team\">" . _TEAMS . "</a> | "
	. "</b>" . _TOURNAMENTPREFS . " | "
	. "<a href=\"index.php?file=Tournament&amp;page=admin&amp;op=raz\"><b>Remise à zero des tables</b></a></div><br>\n"
	. "<form method=\"post\" action=\"index.php?file=Tournament&amp;page=admin&amp;op=do_edit\" onsubmit=\"backslash('intro_texte');BBcode_close('intro_texte');\">\n"
	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";

        $sql = mysql_query("SELECT intro, type FROM " . TOURNAMENT_INTRO_TABLE );
        list($intro, $type) = mysql_fetch_row($sql);

	echo" <tr><td align=\"left\">"._MATCHTYPE."<SELECT name=type>";
	
	for($i=0; $i<5; $i++)
	{
		if($type == $i)
		{
			echo" <OPTION value=".$i." selected>".($i+1)."vs".($i+1)."</OPTION>";
		}
		else
		{
			echo" <OPTION value=".$i.">".($i+1)."vs".($i+1)."</OPTION>";
		}
		
	}
        
        echo" </select></td></tr>";
        
        $intro = stripslashes($intro);

       
        echo" <tr><td align=\"center\"><b>" . _TEXT . " :</b><br /><textarea class=\"editor\" id=\"intro_texte\" name=\"texte\" cols=\"70\" rows=\"15\">".$intro."</textarea></td></tr>\n"
	. "</table>\n"
	. "<div style=\"text-align: center;\"><br /><input type=\"submit\" name=\"Submit\" value=\"" . _EDITINTRO . "\" />"
	. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Tournament&amp;page=admin\"><b>" . _TOURNAMENTBACK . "</b></a> ]</div></form><br /></div></div>\n";

	}
	
function raz()
    {
        global $nuked;
		
	echo "<script type=\"text/javascript\">\n"
			."<!--\n"
			. "\n"
			. "	function zero()\n"
			. "	{\n"
			. "		if (confirm('" . _SURZERO . "'))\n"
			. "		{document.location.href = 'index.php?file=Tournament&page=admin&op=stats_zero';}\n"
			. "	}\n"
			. "// -->\n"
			. "</script>\n";
   echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>Remise à zero des tables</h3>\n"
    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Tournament.html\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"	
. "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
. "<form action=\"javascript:zero()\" style=\"margin: 0px; padding: 0px;\">\n"
. "				<tr>\n"
. "					<td colspan=\"2\" align=\"center\">\n"
. "						<b>" . _STATSDEMANDE . " :</b>\n"
. "					</td>\n"
. "				</tr>\n"
. "				<tr>\n"
. "					<td colspan=\"2\" align=\"center\">\n"
. "						<input type=\"submit\" value=\"" . _REMETTREAZERO . "\" />\n"
. "					</td>\n"
. "				</tr>\n"
. "				<tr>\n"
. "					<td colspan=\"2\">\n"
. "						&nbsp;<br/>\n"
. "					</td>\n"
. "				</tr>\n"
. "			</form></table></div></div>\n"
. "<div style=\"text-align: center;\">[ <a href=\"index.php?file=Tournament&amp;page=admin\"><b>" . _TOURNAMENTBACK . "</b></a> ]</div><br />";
}	

	
// -------------------------------------------------------------------------//
// Edit Tournament's preferences                                            //
// -------------------------------------------------------------------------//
    function do_edit($type, $texte)
    {
        global $nuked;

        $texte = secu_html(html_entity_decode($texte));
        $texte = mysql_real_escape_string(stripslashes($texte));

        $upd = mysql_query("UPDATE " . TOURNAMENT_INTRO_TABLE . " SET intro = '" . $texte . "', type = " . $type);
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _INTROMODIF . "\n"
			. "</div>\n"
			. "</div>\n";
        redirect("index.php?file=Tournament&page=admin", 2);
    } 
   
// -------------------------------------------------------------------------//
// Edit Tournament's matches                                                //
// -------------------------------------------------------------------------//
    function edit_match($matchid)
    {
        global $nuked, $language, $bgcolor1, $bgcolor2, $bgcolor3;
    
  	echo"	<script type=\"text/javascript\">\n"
	."<!--\n"
	. "function verifchamps()\n"
	. "{"
	. "return true;\n"
	. "}\n"
	. "// -->\n"
	. "</script>";
    echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>" . _ADMINTOURNAMENT . "</h3>\n"
    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Tournament.html\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">" . _MATCHES . "<b> | "
	. "<a href=\"index.php?file=Tournament&amp;page=admin&amp;op=main_team\">" . _TEAMS . "</a> | "
	. "<a href=\"index.php?file=Tournament&amp;page=admin&amp;op=main_pref\">" . _TOURNAMENTPREFS . "</a></b></div><br />\n"
	. "<form method=\"post\" action=\"index.php?file=Tournament&amp;page=admin&amp;op=do_edit_match&amp;matchid=".$matchid."\" enctype=\"multipart/form-data\" onsubmit=\"return verifchamps();\">\n"
	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";

	$req = "SELECT title, date, winner, score1, score2, report, screen1, screen2, screen3, screen4, status1, status2 FROM " . TOURNAMENT_MATCH_TABLE . " WHERE id = ". $matchid;
        $sql = mysql_query($req);
        list($title, $date, $winner, $score1, $score2, $report, $screen1, $screen2, $screen3, $screen4, $status1, $status2) = mysql_fetch_row($sql);

	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._MATCHNAME."</td>
  		<td>".constant($title)."</td></tr>";
  	
	//echo"<tr><td>&nbsp;</td>
  		//<td align=\"left\">"._MATCHDATE."</td>
  		//<td><input type=text size=20 name=matchdate value=".$date."></td></tr>";
		echo "<tr><td>&nbsp;</td><td align=\"left\"><b>Date :</b>&nbsp;</td>
  		<td><select id=\"news_jour\" name=\"jour\">\n";

        $day = 1;
        while ($day < 32)
        {
            if ($day == date("d", $date))
            {
                echo "<option value=\"" . $day . "\" selected=\"selected\">" . $day . "</option>\n";
            } 
            else
            {
                echo "<option value=\"" . $day . "\">" . $day . "</option>\n";
            } 
            $day++;
        } 

        echo "</select>&nbsp;<select id=\"news_mois\" name=\"mois\">\n";

        $month = 1;
        while ($month < 13)
        {
            if ($month == date("m", $date))
            {
                echo "<option value=\"" . $month . "\" selected=\"selected\">" . $month . "</option>\n";
            } 
            else
            {
                echo "<option value=\"" . $month . "\">" . $month . "</option>\n";
            } 
            $month++;
        } 

        echo "</select>&nbsp;<select id=\"news_annee\" name=\"annee\">\n";

        $prevprevprevyear = date("Y", $date) -3;
        $prevprevyear = date("Y", $date) -2;
        $prevyear = date("Y", $date) -1;
        $year = date("Y", $date) ;
        $nextyear = date("Y", $date) + 1;
        $nextnextyear = date("Y", $date) + 2;
        $check = "selected=\"selected\"";
    
        echo "<option value=\"" . $prevprevprevyear . "\">" . $prevprevprevyear . "</option>\n"
	. "<option value=\"" . $prevprevyear . "\">" . $prevprevyear . "</option>\n"
	. "<option value=\"" . $prevyear . "\">" . $prevyear . "</option>\n"
	. "<option value=\"" . $year . "\" " . $check . ">" . $year . "</option>\n";

        $heure = date("H:i", $date);

        echo "<option value=\"" . $nextyear . "\">" . $nextyear . "</option>\n"
	. "<option value=\"" . $nextnextyear . "\">" . $nextnextyear . "</option>\n"
	. "</select>&nbsp;<b>" . _AT . " :</b>&nbsp;<input type=\"text\" id=\"news_heure\" name=\"heure\" size=\"5\" maxlength=\"5\" value=\"" . $heure . "\" /></td></tr>\n";		
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._MATCHWINNER."</td>";
  	
  	if(constant($title) == _TOURNAMENTWIN)
  	{
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTHALFWIN1'";
          $sql = mysql_query($req);
          list($winner1) = mysql_fetch_row($sql);
  	  
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTHALFWIN2'";
          $sql = mysql_query($req);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTHALFWIN1)
  	{
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTQUARTER1'";
          $sql = mysql_query($req);
          list($winner1) = mysql_fetch_row($sql);
  	  
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTQUARTER2'";
          $sql = mysql_query($req);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTHALFWIN2)
  	{
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTQUARTER3'";
          $sql = mysql_query($req);
          list($winner1) = mysql_fetch_row($sql);
  	  
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTQUARTER4'";
          $sql = mysql_query($req);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTQUARTER1)
  	{
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER1'";
          $sql = mysql_query($req);
          list($winner1) = mysql_fetch_row($sql);
  	  
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER2'";
          $sql = mysql_query($req);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTQUARTER2)
  	{
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER3'";
          $sql = mysql_query($req);
          list($winner1) = mysql_fetch_row($sql);
  	  
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER4'";
          $sql = mysql_query($req);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTQUARTER3)
  	{
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER5'";
          $sql = mysql_query($req);
          list($winner1) = mysql_fetch_row($sql);
  	  
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER6'";
          $sql = mysql_query($req);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTQUARTER4)
  	{
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER7'";
          $sql = mysql_query($req);
          list($winner1) = mysql_fetch_row($sql);
  	  
  	  $req = "SELECT winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '_TOURNAMENTEIGHTER8'";
          $sql = mysql_query($req);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER1)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 0,2");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER2)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 2,4");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER3)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 4,6");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER4)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 6,8");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER5)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 8,10");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER6)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 10,12");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER7)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 12,14");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	else if(constant($title) == _TOURNAMENTEIGHTER8)
  	{
  	  $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id LIMIT 14,16");
          list($winner1) = mysql_fetch_row($sql);
          list($winner2) = mysql_fetch_row($sql);
  	}
  	
  	echo"	<td><select name=matchwinner>";
  	
  	$selected = FALSE;
  	if($winner1 != 0)
  	{
  	  $req = "SELECT name FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = ". $winner1;
          $sql = mysql_query($req);
          list($name1) = mysql_fetch_row($sql);
          
          if($name1 != "")
          {
            if($winner1 == $winner)
            {
              echo"	<option value=".$winner1." selected>".$name1."</option>";
              $selected = TRUE;
            }
            else
            {
              echo"	<option value=".$winner1.">".$name1."</option>";
            }
          }
  	}
  	
  	if($winner2 != 0)
  	{
  	  $req = "SELECT name FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = ". $winner2;
          $sql = mysql_query($req);
          list($name2) = mysql_fetch_row($sql);
          
          if($name2 != "")
          {
            if($winner2 == $winner)
            {
              echo"	<option value=".$winner2." selected>".$name2."</option>";
              $selected = TRUE;
            }
            else
            {
              echo"	<option value=".$winner2.">".$name2."</option>";
            }
          }
  	}
  	
        if($selected == TRUE)
        {
  	  echo"	<option value=0>"._TOPLAY."</option>";
  	}
  	else
  	{
  	  echo"	<option value=0 selected>"._TOPLAY."</option>";
  	}
  	
  	echo"	</select></td></tr>";
        
  	if(($winner1 != 0)&&($winner2 != 0))
  	{ 
	  echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">". _MATCHSCORE . $name1 ." :</td>
  		<td><input type=text size=2 name=matchscore1 value=".$score1."></td></tr>";
  		
	  echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">". _MATCHSCORE . $name2 ." :</td>
  		<td><input type=text size=2 name=matchscore2 value=".$score2."></td></tr>";
  	}
  	else
  	{
  	  echo "<input type=hidden name=matchscore1 value=".$score1.">";
  	  echo "<input type=hidden name=matchscore2 value=".$score2.">";
  	}
  	
//  	if($screen1 == "") $screen1 = "http://";
//  	if($screen2 == "") $screen2 = "http://";
//  	if($screen3 == "") $screen3 = "http://";
//  	if($screen4 == "") $screen4 = "http://";
//  	if($status1 == "") $status1 = "http://";
//  	if($status2 == "") $status2 = "http://";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._MATCHSCREEN1."</td>
  		<td><input type=text size=20 name=matchscreen1 value=".$screen1."></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">&nbsp;</td>
  		<td><input type=\"file\" name=\"filename1\" /></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._MATCHSCREEN1."</td>
  		<td><input type=text size=20 name=matchscreen2 value=".$screen2."></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">&nbsp;</td>
  		<td><input type=\"file\" name=\"filename2\" /></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._MATCHSCREEN2."</td>
  		<td><input type=text size=20 name=matchscreen3 value=".$screen3."></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">&nbsp;</td>
  		<td><input type=\"file\" name=\"filename3\" /></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._MATCHSCREEN2."</td>
  		<td><input type=text size=20 name=matchscreen4 value=".$screen4."></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">&nbsp;</td>
  		<td><input type=\"file\" name=\"filename4\" /></td></tr>";
		
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._STATUS1."</td>
  		<td><input type=text size=20 name=matchstatus1 value=".$status1."></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">&nbsp;</td>
  		<td><input type=\"file\" name=\"filename5\" /></td></tr>";
		
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._STATUS2."</td>
  		<td><input type=text size=20 name=matchstatus2 value=".$status2."></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">&nbsp;</td>
  		<td><input type=\"file\" name=\"filename6\" /></td></tr>";
        
	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\" valign=\"top\">"._MATCHREPORT."</td>
  		<td><textarea class=\"editor\" id=\"matchreport\" name=\"matchreport\" cols=\"50\" rows=\"4\">".$report."</textarea></td></tr>";
  		
        echo "</table>"
	. "<div style=\"text-align: center;\"><br /><input type=\"submit\" name=\"Submit\" value=\"" . _EDITMATCH . "\" /></div>\n"
	. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Tournament&amp;page=admin\"><b>" . _TOURNAMENTBACK . "</b></a> ]</div></form><br /></div></div>\n";
    } 


// -------------------------------------------------------------------------//
// Execute match's edition                                                  //
// -------------------------------------------------------------------------//
    function do_edit_match($id, $winner, $score1, $score2, $report, $matchscreen1, $matchscreen2, $matchscreen3, $matchscreen4, $matchstatus1, $matchstatus2, $filename1, $filename2, $filename3, $filename4, $filename5, $filename6, $jour, $mois, $annee, $heure)
    {
        global $nuked, $rep_img;
        $table = explode(':', $heure, 2);
        $date = mktime ($table[0], $table[1], 0, $mois, $jour, $annee) ;
//        $screen1 = addslashes($screen1);
//        $screen2 = addslashes($screen2);
//        $screen3 = addslashes($screen3);
//        $screen4 = addslashes($screen4);
//        $status1 = addslashes($status1);
//        $status2 = addslashes($status2);
        $report = secu_html(html_entity_decode($report));
        $report = mysql_real_escape_string(stripslashes($report));



        $filename_screen1 = $_FILES['filename1']['name'];
        if ($filename_screen1 != "") {
          $ext = pathinfo($filename_screen1 , PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_screen1 = "upload/Tournament/" . $filename_screen1;
            move_uploaded_file($_FILES['filename1']['tmp_name'], $url_screen1) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_screen1, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=Tournament&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_screen1 = $matchscreen1;
        }

        $filename_screen2 = $_FILES['filename2']['name'];
        if ($filename_screen2 != "") {
          $ext = pathinfo($filename_screen2 , PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_screen2 = "upload/Tournament/" . $filename_screen2;
            move_uploaded_file($_FILES['filename2']['tmp_name'], $url_screen2) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_screen2, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=Tournament&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_screen2 = $matchscreen2;
        }

        $filename_screen3 = $_FILES['filename3']['name'];
        if ($filename_screen3 != "") {
          $ext = pathinfo($filename_screen3 , PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_screen3 = "upload/Tournament/" . $filename_screen3 ;
            move_uploaded_file($_FILES['filename3']['tmp_name'], $url_screen3) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_screen3, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=Tournament&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_screen3 = $matchscreen3;
        }

        $filename_screen4 = $_FILES['filename4']['name'];
        if ($filename_screen4 != "") {
          $ext = pathinfo($filename_screen4 , PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_screen4 = "upload/Tournament/" . $filename_screen4 ;
            move_uploaded_file($_FILES['filename4']['tmp_name'], $url_screen4) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_screen4, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=Tournament&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_screen4 = $matchscreen4;
        }

        $filename_screen5 = $_FILES['filename5']['name'];
        if ($filename_screen5 != "") {
          $ext = pathinfo($filename_screen5 , PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_screen5 = "upload/Tournament/" . $filename_screen5 ;
            move_uploaded_file($_FILES['filename5']['tmp_name'], $url_screen5) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_screen5, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=Tournament&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_screen5 = $matchstatus1;
        }

        $filename_screen6 = $_FILES['filename6']['name'];
        if ($filename_screen6 != "") {
          $ext = pathinfo($filename_screen6 , PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_screen6 = "upload/Tournament/" . $filename_screen6 ;
            move_uploaded_file($_FILES['filename6']['tmp_name'], $url_screen6) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_screen6, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=Tournament&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_screen6 = $matchstatus2;
        }


      $req = mysql_query("UPDATE " . TOURNAMENT_MATCH_TABLE . " SET date = '" . $date . "', winner = '" . $winner . "', score1 = '" . $score1 . "', score2 = '" . $score2 . "', report = '" . $report . "', screen1 = '" . $url_screen1 . "', screen2 = '" . $url_screen2 . "', screen3 = '" . $url_screen3 . "', screen4 = '" . $url_screen4 . "', status1 = '" . $url_screen5 . "', status2 = '" . $url_screen6 . "' WHERE id = '" . $id . "'");

        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _INTROMODIF . "\n"
			. "</div>\n"
			. "</div>\n";
        redirect("index.php?file=Tournament&page=admin", 2);
    } 


// -------------------------------------------------------------------------//
// Edit form for a Tournament's team                                        //
// -------------------------------------------------------------------------//
  function edit_team($teamid)
  {
    global $bgcolor2, $bgcolor3, $theme, $nuked, $user;
  
    $req = "SELECT name, tag, url, picture, leader, leadersteam, leaderid, mail, member1, steam1, member2, steam2, member3, steam3, member4, steam4, validated FROM ".TOURNAMENT_TEAM_TABLE." WHERE id = " . $teamid;
    $sql1=mysql_query($req);
    list($teamname, $teamtag, $teamurl, $teampict, $teamleader, $leadersteam, $leaderid, $teammail, $member[1], $steam[1], $member[2], $steam[2], $member[3], $steam[3], $member[4], $steam[4], $validated) = mysql_fetch_array($sql1);
    
    $req = "SELECT type FROM ".TOURNAMENT_INTRO_TABLE." WHERE 1";
    $sql2=mysql_query($req);
    list($type) = mysql_fetch_array($sql2);
    
    echo"	<script type=\"text/javascript\">\n"
    	. "<!--\n"
	. "function verifchamps()\n"
	. "{"
	. "if (document.getElementById('teamname').value.length < 4)"
	. "{ alert('" . _4TYPEMIN . "'); return false; }\n"
	. "if (document.getElementById('teamleader').value.length < 4)"
	. "{ alert('" . _4TYPEMIN . "'); return false; }\n"
	. "if ((document.getElementById('teammb1').value.length < 4)&&(document.getElementById('type').value > 0))"
	. "{ alert('" . _4TYPEMIN . "'); return false; }\n"
	. "if ((document.getElementById('teammb2').value.length < 4)&&(document.getElementById('type').value > 1))"
	. "{ alert('" . _4TYPEMIN . "'); return false; }\n"
	. "if ((document.getElementById('teammb3').value.length < 4)&&(document.getElementById('type').value > 2))"
	. "{ alert('" . _4TYPEMIN . "'); return false; }\n"
	. "if ((document.getElementById('teammb4').value.length < 4)&&(document.getElementById('type').value > 3))"
	. "{ alert('" . _4TYPEMIN . "'); return false; }\n"
	. "if (document.getElementById('teammail').value.indexOf('@') == -1)"
	. "{ alert('" . _MAILFAILED . "'); return false; }\n"
	. "return true;\n"
	. "}\n"
	. "// -->\n"
	. "</script>";
	echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
	. "<div class=\"content-box-header\"><h3>" . _TITREFORM . "</h3>\n"
    . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Tournament.html\" rel=\"modal\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
	. "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">\n"
    . "<form method=\"post\" action=\"index.php?file=Tournament&amp;page=admin&amp;op=updteam\" enctype=\"multipart/form-data\"onsubmit=\"return verifchamps();\">"
    . "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">\n"
   	. "<tr><td width=\"20%\">&nbsp;</td>\n"
    . "<td align=\"left\" width=\"30%\">"._TEAMNAME."</td>\n"
  	. "<td width=\"50%\"><input type=text size=30 name=teamname value=\"".$teamname."\">\n"
  	. "<input type=hidden name=teamid value=".$teamid."></td></tr>";
    
    if($type != 0)
    {
    	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMTAG."</td>
  		<td><input type=text size=10 name=teamtag value=".$teamtag."></td></tr>";
    }
    
    echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMPICT."</td>
  		<td><input type=text size=50 name=teampict value=".$teampict."></td></tr>";
    echo"<tr><td>&nbsp;</td>
  		<td align=\"left\">Upload une Image :</td>
  		<td><input type=\"file\" name=\"filename1\" /></td></tr>";
  	
    if($type != 0)
    {
    	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMURL."</td>
  		<td><input type=text size=50 name=teamurl value=".$teamurl."></td></tr>";
    }
    
    echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMLEADER."</td>
  		<td><input type=text size=30 name=teamleader value=".$teamleader."></td></tr>";
    
    echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._LEADERSTEAM."</td>
  		<td><input type=text size=30 name=leadersteam value=".$leadersteam."></td></tr>";
  
    echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMMAIL."</td>
  		<td><input type=text size=30 name=teammail value=\"".$teammail."\"></td></tr>";
    
    echo"	<input type=hidden name=type value=".$type.">";
    
    for($i=0; $i<$type; $i++)
    {
    	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMMB.($i+1)." :</td>
  		<td><input type=text size=30 name=teammb".($i+1)." value=".$member[($i+1)]."></td></tr>
		<tr><td>&nbsp;</td>
  		<td align=\"left\">"._STEAM.($i+1)." :</td>
  		<td><input type=text size=30 name=steam".($i+1)." value=".$steam[($i+1)]."></td></tr>";		
    }
  		
    if($validated == 0)
    {
      $nooption  = "selected";
      $yesoption = "";
    }
    else
    {
      $nooption  = "";
      $yesoption = "selected";
    }
    
    echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._VALIDATED."</td>
  		<td><select name=validated>
  		<option value=1 ".$yesoption.">"._YES."</option>
  		<option value=0 ".$nooption.">"._NO."</option>
  		</td></tr>";
  
    echo"	<tr><td colspan=\"3\">&nbsp;</td></tr>";
    echo"	<tr><td colspan=\"3\" align=\"center\"><input type=\"submit\" value=\"" . _EDITTEAM . "\" /></td></tr>";
    echo"	</table></form><br><br>";
    echo"	<center><a href=index.php?file=Tournament&page=admin>[ <b>"._TOURNAMENTBACK."</b> ]</a></center><br></div></div>";
  }


// -------------------------------------------------------------------------//
// Edition of a Tournament's team in database                               //
// -------------------------------------------------------------------------//
  function updteam($teamid, $teamname, $teampict, $teamurl, $teamtag, $teamleader, $leaderteam, $teammail,
                   $teammb1, $steam1, $teammb2, $steam2, $teammb3, $steam3, $teammb4, $steam4, $validated)
  {
    global $nuked, $user;
  
    $user_id  = $user[0];
    $teamname = htmlentities($teamname, ENT_QUOTES);
    $teamtag  = htmlentities($teamtag,  ENT_QUOTES);
    $teamtag  = addslashes($teamtag);

    if (strlen($teamname) > 30)
    {
        echo "<div class=\"notification error png_bg\">\n"
		. "<div>\n"
        . "<div style=\"text-align: center;\">" . _NICKTOLONG . "</div><br />\n"
		."</div></div>\n";
        redirect("index.php?file=Tournament&op=addteam", 2);
        closetable();
        footer();
        exit();
    }
    $rep_img = "upload/Tournament/";
  if((($teampict == "")||($teampict == "http://")||($teampict != ""))&&($_FILES['filename1']['name'] != ""))
        {
	  $fichier = $_FILES['filename1']['name'];
	  $fichier = str_replace(" ", "_", $fichier);
	  $teampict = $rep_img . $fichier;
	  
	  if((!is_file($teampict))&&($_FILES['filename1']['size']<1000000))
	  {
	    move_uploaded_file($_FILES['filename1']['tmp_name'], $teampict) or die ("Upload file failed !!!");
            @chmod ($teampict, 0644);
	  }
	  else
	  {
	    $teampict="http://";
	  }
}
    $req = "UPDATE " . TOURNAMENT_TEAM_TABLE . " SET name='".$teamname."', mail='".$teammail."', url='".$teamurl."', picture='".$teampict."', tag='".$teamtag."', leader='".$teamleader."', leadersteam='".$leadersteam."', member1='".$teammb1."', steam1='".$steam1."', member2='".$teammb2."', steam2='".$steam2."', member3='".$teammb3."', steam3='".$steam3."', member4='".$teammb4."', steam4='".$steam4."', validated=".$validated." WHERE id = '" . $teamid . "'";
    $upd = mysql_query($req);
    echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _VALIDEDITSUCCES . "\n"
			. "</div>\n"
			. "</div>\n";
 
    redirect("index.php?file=Tournament&page=admin&op=main_team", 5);
  } 
// -------------------------------------------------------------------------//
// Functions' Remise à zero                                                 //
// -------------------------------------------------------------------------//
   function stats_zero($statspost)
    {
        global $nuked;
		$date = time();
        $maj1 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET date = '$date'");
		$maj2 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET winner = '0'");
		$maj3 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET score1 = '0'");
		$maj4 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET score2 = '0'");
		$maj5 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET report = ''");
		$maj6 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET screen1 = ''");
		$maj7 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET screen2 = ''");
		$maj8 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET screen3 = ''");
		$maj9 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET screen4 = ''");
		$maj10 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET status1 = ''");
		$maj11 = mysql_query("UPDATE ".$nuked[prefix]."_tournament_match SET status2 = ''");
		
			echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _STATSZEROOK . "\n"
			. "</div>\n"
			. "</div>\n";
        redirect("index.php?file=Tournament&page=admin", 2);
    } 
// -------------------------------------------------------------------------//
// Functions' Switch                                                        //
// -------------------------------------------------------------------------//
    switch ($_REQUEST['op'])
    {
        case "main":
            admintop(); 
            main();
            adminfoot();
            break;

		case "raz":
            admintop(); 
            raz();
            adminfoot();
            break;	
									
        case "main_pref":
            admintop(); 
            main_pref();
            adminfoot();
            break;

        case "main_team":
            admintop(); 
            main_team();
            adminfoot();
            break;

        case "do_edit":
            admintop(); 
            do_edit($_REQUEST['type'], $_REQUEST['texte']);
            adminfoot();
            break;

        case "do_removeteam":
            admintop(); 
            do_removeteam($_REQUEST['teamid']);
            adminfoot();
            break;

        case "preview":
            preview();
            break;

        case "edit_match":
            admintop(); 
            edit_match($_REQUEST['matchid']);
            adminfoot();
            break;

        case "do_edit_match":
            admintop();
            do_edit_match($_REQUEST['matchid'], $_REQUEST['matchwinner'], $_REQUEST['matchscore1'], $_REQUEST['matchscore2'], $_REQUEST['matchreport'], $_REQUEST['matchscreen1'], $_REQUEST['matchscreen2'], $_REQUEST['matchscreen3'], $_REQUEST['matchscreen4'], $_REQUEST['matchstatus1'], $_REQUEST['matchstatus2'], $_REQUEST['filename1'], $_REQUEST['filename2'], $_REQUEST['filename3'], $_REQUEST['filename4'], $_REQUEST['filename5'], $_REQUEST['filename6'], $_REQUEST['jour'], $_REQUEST['mois'], $_REQUEST['annee'], $_REQUEST['heure']);
            adminfoot();
            break;

        case "edit_team":
            admintop(); 
            edit_team($_REQUEST['teamid']);
            adminfoot();
            break;
            
        case "updteam":
            admintop(); 
            updteam($_REQUEST['teamid'], $_REQUEST['teamname'], $_REQUEST['teampict'], $_REQUEST['teamurl'], $_REQUEST['teamtag'], $_REQUEST['teamleader'], $_REQUEST['leadersteam'], $_REQUEST['teammail'], $_REQUEST['teammb1'], $_REQUEST['steam1'], $_REQUEST['teammb2'], $_REQUEST['steam2'], $_REQUEST['teammb3'], $_REQUEST['steam3'], $_REQUEST['teammb4'], $_REQUEST['steam4'], $_REQUEST['validated'], $_REQUEST['$filename1']);
            adminfoot();
            break;

        default:
            admintop();
            main();
            adminfoot();
            break;
			
		case "stats_zero":
            admintop();		
            stats_zero($_REQUEST['statspost']);
            adminfoot();
            break;
    } 

} 
else if ($level_admin == -1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _TOURNAMENTBACK . "</b></a></div><br /><br />";
} 
else if ($visiteur > 1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _TOURNAMENTBACK . "</b></div></a><br /><br />";
} 
else
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _TOURNAMENTBACK . "</b></a></div><br /><br />";
} 

?>