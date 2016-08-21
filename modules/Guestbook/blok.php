<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (eregi("blok.php", $_SERVER['PHP_SELF']))
{
    die ("You cannot open this page directly");
} 

global $nuked, $theme, $language, $bgcolor3, $bgcolor1;
translate("modules/Guestbook/lang/" . $language . ".lang.php");

$sql = mysql_query("SELECT id FROM " . GUESTBOOK_TABLE);
include ("modules/Guestbook/template.php"); 
	    
    

        $sql2 = mysql_query("SELECT id, name, comment, email, url, date, host FROM " . GUESTBOOK_TABLE . " ORDER BY rand() DESC LIMIT  0,1");
        while (list($id, $name, $comment, $email, $url, $date, $ip) = mysql_fetch_array($sql2))
        {
        		$select_avatar="SELECT avatar FROM " . USER_TABLE . " WHERE pseudo = '" . $name . "'";
				$sql_avatar=mysql_query($select_avatar);
				list($avatar_url) = mysql_fetch_array($sql_avatar);
    	
    	if($avatar_url == "") $avatar_url = "modules/Guestbook/images/anonyme.png";
    	
            $email = htmlentities($email);
	        $name = stripslashes($name);
             $url = htmlentities($url);
            $url = nk_CSS($url);
            $email = nk_CSS($email);
        
		if ($url != "")
            {
                $website = "&nbsp;<a href=\"" . $url . "\" onclick=\"window.open(this.href); return false;\"><img style=\"border: 0;\" src=\"modules/Forum/images/website.gif\" alt=\"\" title=\"" . $url . "\" /></a>";
            } 
            else
            {
                $website = "";
            } 
            if ($email != "")
            {
                $usermail = "<a href=\"mailto:" . $email . "\"><img style=\"border: 0;\" src=\"modules/Forum/images/email.gif\" alt=\"\" title=\"" . $email . "\" /></a>";
            } 
            else
            {
                $usermail = "";
            } 
   
   echo '<center><div class="view view-tenth"><img src="'.$avatar_url.'" />
         <div class="mask"><h2>Dédicasse de '.$name.'</h2>
         <p>'.$comment.'</p>
         <a href="index.php?file=Guestbook" class="info">Signez le livre</a>
         </div></div></center>';

         ?>
         <?php
	}

?>