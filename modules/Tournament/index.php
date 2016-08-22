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
if (!defined("INDEX_CHECK")) {
         die ("<center>You cannot open this page directly</center>");
}

global $language, $user;
include("modules/Tournament/lang/".$language.".lang.php");

if(!$user){$visiteur="0";}
else{$visiteur=$user[1];}
$ModName = basename( dirname( __FILE__ ) );
$rep_img = "upload/Tournament/";
if ($visiteur>=nivo_mod($ModName)){

  define("TOURNAMENT_TEAM_TABLE", $nuked['prefix'] . "_tournament_team");
  define("TOURNAMENT_INTRO_TABLE", $nuked['prefix'] . "_tournament_intro");
  define("TOURNAMENT_MATCH_TABLE", $nuked['prefix'] . "_tournament_match");

  compteur(Team);

// -------------------------------------------------------------------------//
// Array of the Tournament's matches                                        //
// -------------------------------------------------------------------------//
  function index()
  {
    global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked, $user;
  
    opentable();
   
    $req = "SELECT intro FROM " . TOURNAMENT_INTRO_TABLE ;
    $sql = mysql_query($req);
    list($texte) = mysql_fetch_array($sql);
     $_REQUEST['texte'] = secu_html(html_entity_decode($_REQUEST['texte']));
     $_REQUEST['texte'] = mysql_real_escape_string(stripslashes($_REQUEST['texte']));
    
    if ($smileyoff == 0)
    {
      $texte = icon($texte);
    } 
  
    echo"<div style=\"text-align: center;\"><h3>" . _TITLETOURNAMENT . "</h3></div>";
    echo"	 <div style=\"text-align: center;\"><br>". $texte . "</div><br><br><br>";
    echo"<table style=\"background: " . $bgcolor2 . ";border: 1px solid " . $bgcolor3 . ";\" width=\"100%\" cellpadding=\"2\" cellspacing=\"1\"><tr>";
    echo"<td bgcolor=\"".$bgcolor3."\" colspan=\"10\" align=\"center\"><big><b>"._TITRETEAMS."</b></big></td></tr>";
	 
    $sql = mysql_query("SELECT id, name, picture FROM " . TOURNAMENT_TEAM_TABLE . " WHERE validated = 1 ORDER BY id");

    for($i=0;$i<16;$i++)
    {
      if (list($teamid, $teamname, $teampict) = mysql_fetch_array($sql))
      {
        if(($teampict == "http://")||($teampict == "")){ $teampict = "modules/Tournament/images/noimagefile.png"; }
        echo"<tr><td style=\"border: 1px solid " . $bgcolor3 . ";\" width=\"10%\"align=\"center\"><img src=\"".$teampict."\" border=\"1\" width=\"40\" height=\"40\"></td>
    	     <td style=\"background: " . $bgcolor1 . ";border: 1px solid " . $bgcolor3 . ";\" align=\"center\"><a href=\"index.php?file=Tournament&op=infoteam&teamid=".$teamid."\"><b>".$teamname."</b></a></td>";
      }
      else
      {
        echo"<tr><td style=\"border: 1px solid " . $bgcolor3 . ";\" width=\"10%\"align=\"center\"><img src=\"modules/Tournament/images/noimagefile.png\" border=\"1\" width=\"40\" height=\"40\"></td>";
    	 echo" 	<td style=\"background: " . $bgcolor1 . ";border: 1px solid " . $bgcolor3 . ";\" align=\"center\" width=\"10%\"><a href=\"index.php?file=Tournament&op=addteam\"><b>"._DEFAULTTEAM."</b></a></td>";
      }
    
      if($i%2==0)
      {
        $matchtitle = "_TOURNAMENTEIGHTER".($i+2)/2;
        $req = "SELECT id, winner, date FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '".$matchtitle."'";
        $sql2 = mysql_query($req);
        list($matchid, $matchwinner, $date) = mysql_fetch_array($sql2);
        $date = strftime("%x", $date);
        if($matchwinner == 0)
        {
          $name = _NORESULT;
          $picture = "modules/Tournament/images/noimagefile.png";
          $title = constant($matchtitle);
        }
        else
        {
          $sql2 = mysql_query("SELECT name, picture FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = '".$matchwinner."'");
          list($name, $picture) = mysql_fetch_array($sql2);
          if(($picture == "http://")||($picture == "")){ $picture = "modules/Tournament/images/noimagefile.png"; }
          $title = _MATCHRESULT . constant($matchtitle);
        }

        echo"<td style=\"border: 1px solid " . $bgcolor3 . ";\" rowspan=\"2\" width=\"10%\" align=\"center\" ><img src=\"".$picture."\" border=\"1\" width=\"45\" height=\"45\" bgcolor=\"".$bgcolor2."\"></td>";
    	echo"	 <td style=\"background: " . $bgcolor1 . ";border: 1px solid " . $bgcolor3 . ";\" rowspan=\"2\" align=\"center\" width=\"10%\">";
    	echo"	 <a href=\"index.php?file=Tournament&op=infomatch&matchid=".$matchid."\">".$title."</a>";
    	echo"	 <br><br>".$date."<br><br><b>".$name."</b></td>";
      }
    
      if($i%4==0)
      {
        $matchtitle = "_TOURNAMENTQUARTER".($i+4)/4;
        $req = "SELECT id, winner, date FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '".$matchtitle."'";
        $sql2 = mysql_query($req);
        list($matchid, $matchwinner, $date) = mysql_fetch_array($sql2);
        $date = strftime("%x", $date);
        if($matchwinner == 0)
        {
          $name = _NORESULT;
          $picture = "modules/Tournament/images/noimagefile.png";
          $title = constant($matchtitle);
        }
        else
        {
          $sql2 = mysql_query("SELECT name, picture FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = '".$matchwinner."'");
          list($name, $picture) = mysql_fetch_array($sql2);
          if(($picture == "http://")||($picture == "")){ $picture = "modules/Tournament/images/noimagefile.png"; }
          $title = _MATCHRESULT . constant($matchtitle);
        }

        echo"<td style=\"border: 1px solid " . $bgcolor3 . ";\" rowspan=\"4\" width=\"10%\" align=\"center\" ><img src=\"".$picture."\" border=\"1\" width=\"50\" height=\"50\"></td>";
    	echo"	 <td style=\"background: " . $bgcolor1 . ";border: 1px solid " . $bgcolor3 . ";\"  rowspan=\"4\" align=\"center\" width=\"10%\">";
    	echo"	 <a href=\"index.php?file=Tournament&op=infomatch&matchid=".$matchid."\">".$title."</a>";
    	echo"	 <br><br>".$date."<br><br><b>".$name."</b></td>";
      }
    
      if($i%8==0)
      {
        $matchtitle = "_TOURNAMENTHALFWIN".($i+8)/8;
        $req = "SELECT id, date, winner FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '".$matchtitle."'";
        $sql2 = mysql_query($req);
        list($matchid, $date, $matchwinner) = mysql_fetch_array($sql2);
        $date = strftime("%x", $date);
        if($matchwinner == 0)
        {
          $name = _NORESULT;
          $picture = "modules/Tournament/images/noimagefile.png";
          $title = constant($matchtitle);
        }
        else
        {
          $sql2 = mysql_query("SELECT name, picture FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = ".$matchwinner);
          list($name, $picture) = mysql_fetch_array($sql2);
          if(($picture == "http://")||($picture == "")){ $picture = "modules/Tournament/images/noimagefile.png"; }
          $title = _MATCHRESULT . constant($matchtitle);
        }

        echo"<td style=\"border: 1px solid " . $bgcolor3 . ";\" rowspan=\"8\" width=\"10%\" align=\"center\"><img src=\"".$picture."\" border=\"1\" width=\"55\" height=\"55\"></td>";
    	echo"	 <td style=\"background: " . $bgcolor1 . ";border: 1px solid " . $bgcolor3 . ";\"  rowspan=\"8\" align=\"center\" width=\"10%\">";
    	echo"	 <a href=\"index.php?file=Tournament&op=infomatch&matchid=".$matchid."\">".$title."</a>";
    	echo"	 <br><br>".$date."<br><br><b>".$name."</b></td>";
      }
    
      if($i%16==0)
      {
        $matchtitle = "_TOURNAMENTWIN";
        $sql2 = mysql_query("SELECT id, winner, date FROM " . TOURNAMENT_MATCH_TABLE . " WHERE title = '".$matchtitle."'");
        list($matchid, $matchwinner, $date) = mysql_fetch_array($sql2);
        $date = strftime("%x", $date);
        if($matchwinner == 0)
        {
          $name = _NORESULT;
          $picture = "modules/Tournament/images/noimagefile.png";
          $title = constant($matchtitle);
        }
        else
        {
          $sql2 = mysql_query("SELECT name, picture FROM " . TOURNAMENT_TEAM_TABLE . " WHERE id = '".$matchwinner."'");
          list($name, $picture) = mysql_fetch_array($sql2);
          if(($picture == "http://")||($picture == "")){ $picture = "modules/Tournament/images/noimagefile.png"; }
          $title = _MATCHRESULT . constant($matchtitle);
        }

        echo"<td style=\"border: 1px solid " . $bgcolor3 . ";\" rowspan=\"16\" width=\"10%\" align=\"center\"><img src=\"".$picture."\" border=\"1\" width=\"60\" height=\"60\"></td>";
    	echo"	 <td style=\"background: " . $bgcolor1 . ";border: 1px solid " . $bgcolor3 . ";\" rowspan=\"16\" align=\"center\" width=\"10%\">";
    	echo"	 <a href=\"index.php?file=Tournament&op=infomatch&matchid=".$matchid."\">".$title."</a>";
    	echo"	 <br><br>".$date."<br><br><b>".$name."</b></td>";
      }
      echo"</tr>";
    }
  
    echo"</table><br / ><br />";
    echo"<center><a href=index.php?file=Tournament><b>"._HAUTPAGE."</b></a></center><br>";
  
    CloseTable();
  }

// -------------------------------------------------------------------------//
// Information on a Tournament's match                                      //
// -------------------------------------------------------------------------//
  function infomatch($matchid)
  { 
    global $bgcolor2, $bgcolor3, $theme, $nuked, $user;

    opentable();

    echo"	<center><br>";

    $req = "SELECT title, winner, date, score1, score2, report, screen1, screen2, screen3, screen4, status1, status2 FROM ".TOURNAMENT_MATCH_TABLE." WHERE id = " . $matchid;
    $sql = mysql_query($req);
    list($title, $winner, $date, $score1, $score2, $report, $screen1, $screen2, $screen3, $screen4, $status1, $status2) = mysql_fetch_array($sql);
       
    if($screen1 == "http://") { $screen1 = ""; }
    if($screen2 == "http://") { $screen2 = ""; }
    if($screen3 == "http://") { $screen3 = ""; }
    if($screen4 == "http://") { $screen4 = ""; }
    if($status1 == "http://") { $status1 = ""; }
    if($status2 == "http://") { $status2 = ""; }
    $date = strftime("%x", $date);
    echo"	<table width=\"100%\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">";
    
    echo"	<tr><td bgcolor=\"".$bgcolor3."\" colspan=\"2\" align=\"center\">
    		<big><b>" . constant($title) . "</b></big>
    		</td></tr>";
	if($winner==0)
	{	
    $name = _NORESULT;
	echo"	<tr><td colspan=\"2\" align=center>
    		<br><b>Match " . $name . " le</b><br><br>
    		</td></tr>";
	}		
    echo"	<tr><td colspan=\"2\" align=center>
    		<br>" . $date . "<br><br>
    		</td></tr>";
           
    if(($score1 != 0)||($score2 != 0))
    {
      echo"	<tr><td align=\"right\" valign=\"top\" width=\"15%\"><b>" . _MATCHSCORES . "</b>&nbsp;</td>
      		<td align=\"left\" valign=\"top\">" .$score1. " - " .$score2. "<br><br></td></tr>";
    }
          
    if($report != "")
    {
      echo"	<tr><td align=\"right\" valign=\"top\" width=\"15%\"><b>" . _MATCHREPORT . "</b>&nbsp;</td>
      		<td align=\"left\" valign=\"top\">" . $report . "<br><br><br></td></tr>";
    }
          
    echo"<tr><td colspan=\"2\" align=\"center\">\n";
  
    if($screen1 != "") { echo"	<a href=\"".$screen1."\" target=ScreenShot><img src=\"".$screen1."\" width=200></a>&nbsp;\n"; }
    if($screen2 != "") { echo"	<a href=\"".$screen2."\" target=ScreenShot><img src=\"".$screen2."\" width=200></a><br><br>\n"; }
    if($screen3 != "") { echo"	<a href=\"".$screen3."\" target=ScreenShot><img src=\"".$screen3."\" width=200></a>&nbsp;\n"; }
    if($screen4 != "") { echo"	<a href=\"".$screen4."\" target=ScreenShot><img src=\"".$screen4."\" width=200></a><br><br>\n"; }
    if($status1 != "") { echo"	<a href=\"".$status1."\" target=ScreenShot><img src=\"".$status1."\" width=200></a>&nbsp;\n"; }
    if($status2 != "") { echo"	<a href=\"".$status2."\" target=ScreenShot><img src=\"".$status2."\" width=200></a><br><br>\n"; }
  
    echo"	</td></tr></table><br><br>";
    echo"	<center><a href=index.php?file=Tournament><b>"._HAUTPAGE."</b></a></center><br>";

    CloseTable();
  }


// -------------------------------------------------------------------------//
// Register & Edit form for a Tournament's team                             //
// -------------------------------------------------------------------------//
  function addteam($teamid)
  {
    global $bgcolor2, $bgcolor3, $theme, $nuked, $user, $rep_img;
  
    if (!$user)
    {
      echo "<br><br><div style=\"text-align: center;\">" . _LOGINTEAM . "</div>" ;
      return;
    } 
  
    if($teamid != 0)
    {
      $req = "SELECT name, tag, url, picture, leader, leadersteam, leaderid, mail, member1, steam1, member2, steam2, member3, steam3, member4, steam4 FROM ".TOURNAMENT_TEAM_TABLE." WHERE id = " . $teamid;
      $sql1 = mysql_query($req);
      list($teamname, $teamtag, $teamurl, $teampict, $teamleader, $leadersteam, $leaderid, $teammail, $member[1], $steam[1], $member[2], $steam[2], $member[3], $steam[3], $member[4], $steam[4]) = mysql_fetch_array($sql1);
    
      if($leaderid != $user[0])
      {
        echo "<br><br><div style=\"text-align: center;\">" . _NOACCESS . "</div>" ;
        return;
      }
    }
    else
    {
      $teamurl  = "http://";
      $teampict = "http://";
    }
    
    $req = "SELECT type FROM ".TOURNAMENT_INTRO_TABLE." WHERE 1";
    $sql2 = mysql_query($req);
    list($type) = mysql_fetch_array($sql2);
      
    opentable();
  
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
	
    if($teamid != 0)
    {
      echo"<form method=\"post\" action=\"index.php?file=Tournament&amp;op=updteam\" enctype=\"multipart/form-data\"onsubmit=\"return verifchamps();\">";
    }
    else
    {
      echo"<form method=\"post\" action=\"index.php?file=Tournament&amp;op=regteam\" enctype=\"multipart/form-data\"onsubmit=\"return verifchamps();\">";
    }

    echo"	<br /><table width=\"100%\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">
    		<tr>
	 	<td bgcolor=\"".$bgcolor3."\" colspan=\"3\" align=\"center\"><big><b>"._TITREFORM."</b></big></td></tr>
	 	<tr><td colspan=\"3\">&nbsp;</td></tr>";
	 
    if($teamid != 0)
    {  
      echo"	<tr><td width=\"20%\">&nbsp;</td>
    		<td align=\"left\" width=\"30%\">"._TEAMNAME."</td>
  		<td width=\"50%\">".$teamname."<input type=hidden name=teamid value=".$teamid."></td></tr>";
    }
    else
    {
      echo"	<tr><td width=\"20%\">&nbsp;</td>
    		<td align=\"left\" width=\"30%\">"._TEAMNAME."</td>
  		<td width=\"50%\"><input type=text size=30 name=teamname></td></tr>";
    }
 
    if($type > 0)
    {
    	echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMTAG."</td>
  		<td><input type=text size=10 name=teamtag value=".$teamtag."></td></tr>";
    }
    
    echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMPICT."</td>
  		<td><input type=text size=50 name=teampict value=".$teampict."></td></tr>";
		echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">&nbsp;</td>
  		<td><input type=\"file\" name=\"filename1\" /></td></tr>";
  	
    if($type > 0)
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
  	
    if($teamid != 0)
    {  
      echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMMAIL."</td>
  		<td>".$teammail."</td></tr>";
    }
    else
    {
      echo"	<tr><td>&nbsp;</td>
  		<td align=\"left\">"._TEAMMAIL."</td>
  		<td><input type=text size=30 name=teammail></td></tr>";
    }
  
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
  	
    echo"	<tr><td colspan=\"3\">&nbsp;</td></tr>";
    echo"	<tr><td colspan=\"3\" align=\"center\"><input type=\"submit\" value=\"" . _TEAMREGISTER . "\" /></td></tr>";
    echo"	</table></form><br><br>";
    echo"	<center><a href=index.php?file=Tournament>[ <b>"._TOURNAMENTBACK."</b> ]</a></center><br>";
  
    CloseTable();
  }

// -------------------------------------------------------------------------//
// Registration or edition of a Tournament's team in database               //
// -------------------------------------------------------------------------//
  function regteam($teamid, $teamname, $teampict, $teamurl, $teamtag, $teamleader, $leadersteam, $teammail, $teammb1, $steam1, $teammb2, $steam2, $teammb3, $steam3, $teammb4, $steam4, $filename1)
  {
    global $nuked, $user, $rep_img;
	$teampict = addslashes($teampict);
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
    if (!$user)
    {
      echo "<br><br><div style=\"text-align: center;\">" . _LOGINTEAM . "</div>" ;
      return;
    } 
  
    opentable();
  
    $user_id  = $user[0];
    $teamname = htmlentities($teamname, ENT_QUOTES);
    $teamtag  = htmlentities($teamtag,  ENT_QUOTES);
    $teamtag  = addslashes($teamtag);

    if (strlen($teamname) > 30)
    {
        echo "<br /><br /><div style=\"text-align: center;\">" . _NICKTOLONG . "</div><br /><br />";
        redirect("index.php?file=Tournament&op=addteam", 2);
        closetable();
        footer();
        exit();
    } 

    if($teamid != 0)
    {
      $req = "SELECT leaderid FROM ".TOURNAMENT_TEAM_TABLE." WHERE id = '".$teamid."'";
      $sql=mysql_query($req);
      list($leaderid) = mysql_fetch_array($sql);
     
      if($leaderid != $user[0])
      {
        echo "<br><br><div style=\"text-align: center;\">" . _NOACCESS . "</div>" ;
        return;
      } 
      $upd = mysql_query("UPDATE " . TOURNAMENT_TEAM_TABLE . " SET url='".$teamurl."', picture='".$teampict."', tag='".$teamtag."', leader='".$teamleader."', leadersteam='".$steamleader."', member1='".$teammb1."', steam1='".$steam1."', member2='".$teammb2."', steam2='".$steam2."', member3='".$teammb3."', steam3='".$steam3."', member4='".$teammb4."', steam4='".$steam4."' WHERE id = '" . $teamid . "'");
      //$req = "UPDATE " . TOURNAMENT_TEAM_TABLE . " SET url='".$teamurl."', picture='".$teampict."', tag='".$teamtag."', leader='".$teamleader."', steamleader='".$steamleader."', member1='".$teammb1."', steam1='".$steam1."', member2='".$teammb2."', steam2='".$steam2."', member3='".$teammb3."', steam3='".$steam3."', member4='".$teammb4."', steam4='".$steam4."' WHERE id = '" . $teamid . "'";
      //$upd = mysql_query($req);
      
      echo "<br /><br /><div style=\"text-align: center;\">" . _VALIDEDITSUCCES . "</div><br /><br />";
    }
    else
    {
      $req = "SELECT id FROM ".TOURNAMENT_TEAM_TABLE." WHERE name = '".$teamname."'";
      $sql=mysql_query($req);
      list($teambdd) = mysql_fetch_array($sql);
      
      if($teambdd == $teamname)
      {
        echo "<br /><br /><div style=\"text-align: center;\">" . _TEAMEXISTS . "</div><br /><br />";
        redirect("index.php?file=Tournament&op=addteam", 2);
        closetable();
        footer();
        exit();
      }
    
      $add = mysql_query("INSERT INTO " . TOURNAMENT_TEAM_TABLE . " ( `id`, `name`, `url`, `picture`, `tag`, `leader`, `leadersteam`, `leaderid`, `mail`, `member1`, `steam1`, `member2`, `steam2`, `member3`, `steam3`, `member4`, `steam4`) VALUES( '' , '".$teamname."' , '".$teamurl."' , '".$teampict."' , '".$teamtag."' , '".$teamleader."' , '".$leadersteam."' , '".$user_id."', '".$teammail."' , '".$teammb1."' , '".$steam1."' , '".$teammb2."' , '".$steam2."' , '".$teammb3."' , '".$steam3."' , '".$teammb4."' , '".$steam4."' )");
    
      $sql = mysql_query("SELECT id FROM " . TOURNAMENT_TEAM_TABLE . " WHERE name = '" . $teamname . "'");
      list($teamid) = mysql_fetch_array($sql);
    
      $subject = _MAILSUBJECT . $teamname ;
      $corps = _TEAMVALID . "\r\n" . $nuked['url'] . "/index.php?file=Tournament&op=validation&teamid=" . $teamid . "\r\n\r\n\r\n" . $nuked['name'] . " - " . $nuked['slogan'];
      $from = "From: " . $nuked['name'] . " <" . $nuked['mail'] . ">\r\nReply-To: " . $nuked['mail'];

      $subject = @html_entity_decode($subject);
      $corps = @html_entity_decode($corps);
      $from = @html_entity_decode($from);
	
      mail($teammail, $subject, $corps, $from);
  
      echo "<br /><br /><div style=\"text-align: center;\">" . _VALIDMAILSUCCES . "&nbsp;" . $teammail . "</div><br /><br />";
    }
    
    closeTable();
    redirect("index.php?file=Tournament", 5);
  } 

// -------------------------------------------------------------------------//
// Validate the registration of a Tournament's team                         //
// -------------------------------------------------------------------------//
  function validation($teamid)
  {
    global $nuked, $user;
  
    if (!$user)
    {
      echo "<br><br><div style=\"text-align: center;\">" . _LOGINTEAM . "</div>" ;
      return;
    } 
  
    opentable();
    
    $sql = "UPDATE " . TOURNAMENT_TEAM_TABLE . " SET validated = 1 WHERE id = ".$teamid;
    $add = mysql_query($sql);
    
    echo "<br /><br /><div style=\"text-align: center;\">" . _VALIDTEAM . "</div><br /><br />" ;
    closeTable();
    redirect("index.php?file=Tournament", 5);
  }
    
    
// -------------------------------------------------------------------------//
// Display the information on a Tournament's team                           //
// -------------------------------------------------------------------------//
  function infoteam($teamid)
  { 
    global $bgcolor2, $bgcolor3, $theme, $nuked, $user;

    opentable();

    echo"	<center><br>";

    $req = "SELECT name, tag, url, picture, leader, leadersteam, leaderid, member1, steam1, member2, steam2, member3, steam3, member4, steam4 FROM ".TOURNAMENT_TEAM_TABLE." WHERE id = " . $teamid;
    $sql1 = mysql_query($req);
    list($teamname, $teamtag, $teamurl, $teampict, $teamleader, $leadersteam, $leaderid, $member[1], $steam[1], $member[2], $steam[2], $member[3], $steam[3], $member[4], $steam[4]) = mysql_fetch_array($sql1);
       
    $req = "SELECT type FROM ".TOURNAMENT_INTRO_TABLE." WHERE 1";
    $sql2 = mysql_query($req);
    list($type) = mysql_fetch_array($sql2); 
  
    echo"<table width=\"100%\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">";
        	echo"<tr><td bgcolor=\"".$bgcolor3."\" colspan=\"3\" align=\"center\"><big><b>" . _INFOTEAM . $teamname . "</b></big></td></tr>";
			
	if(($teampict == "http://")or($teampict == ""))
    {
      echo"<tr><td width=\"100\"><img src=\"modules/Tournament/images/noimagefile.png\" width=\"50\" height=\"50\"></td>"; 
    }
	else
	{
     echo"<tr><td width=\"100\"><img src=\"" . $teampict . "\" width=\"100\" height=\"100\"></td>";
	}
        echo"<td align=center>" . _INFOTEAM . $teamname . "<br><br>";
        
    if($teamurl != "http://")
    {  
      echo"	<a href=\"" . $teamurl . "\">" . _INFOSITE . "</a><br><br>";
    }
	        
    if($user)
    {
      if($leaderid == $user[0])
      {
    	echo"	<a href=\"index.php?file=Tournament&op=editteam&teamid=".$teamid."\">" . _EDITTEAM . "</a>";
      }
    }
    echo"	</td><td align=left>". $teamtag . "&nbsp;" . $teamleader . "<br>";
    
    for($i=0; $i<$type; $i++)
    {
	echo	$teamtag . "&nbsp;" . $member[($i+1)] . "<br>";
    }
	
    echo"	</td></tr></table><br><br>";
    echo"	<center><a href=index.php?file=Tournament><b>"._HAUTPAGE."</b></a></center><br>";

    CloseTable();
  }

// -------------------------------------------------------------------------//
// Functions' Switch                                                        //
// -------------------------------------------------------------------------//
  switch ($_REQUEST['op'])
  {
	case"index":
	index();
	break;
	
	case"addteam":
	addteam(0);
	break;
	
	case"editteam":
	addteam($_REQUEST['teamid']);
	break;
	
	case"regteam":
	regteam(0, $_REQUEST['teamname'], $_REQUEST['teampict'], $_REQUEST['teamurl'], $_REQUEST['teamtag'], $_REQUEST['teamleader'], $_REQUEST['leadersteam'], $_REQUEST['teammail'], $_REQUEST['teammb1'], $_REQUEST['steam1'], $_REQUEST['teammb2'], $_REQUEST['steam2'], $_REQUEST['teammb3'], $_REQUEST['steam3'], $_REQUEST['teammb4'], $_REQUEST['steam4'], $_REQUEST['$filename1']);
	break;
	
	case"updteam":
	regteam($_REQUEST['teamid'], $_REQUEST['teamname'], $_REQUEST['teampict'], $_REQUEST['teamurl'], $_REQUEST['teamtag'], $_REQUEST['teamleader'], $_REQUEST['leadersteam'], $_REQUEST['teammail'], $_REQUEST['teammb1'], $_REQUEST['steam1'], $_REQUEST['teammb2'], $_REQUEST['steam2'], $_REQUEST['teammb3'], $_REQUEST['steam3'], $_REQUEST['teammb4'], $_REQUEST['steam4'], $_REQUEST['$filename1']);
	break;
	
	case"validation":
	validation($_REQUEST['teamid']);
	break;
	
	case"infoteam":
	infoteam($_REQUEST['teamid']);
	break;

	case"infomatch":
	infomatch($_REQUEST['matchid']);
	break;

	default: 
	index();

  }

}else{opentable();echo"<br><br><center>"._NOENTRANCE."<br><br><a href=\"javascript:history.back()\"><b>"._BACK."</b></a><br><br></center>";closetable();}

?>