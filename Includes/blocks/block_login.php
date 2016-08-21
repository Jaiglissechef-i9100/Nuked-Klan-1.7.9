<?php
// ------------------------------------------------------------------------ //
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// ------------------------------------------------------------------------ //
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// ------------------------------------------------------------------------ //
// Patch block login v2                                                     //
// Update 02/01/2013                                                        //
// ------------------------------------------------------------------------ //

if(!defined("INDEX_CHECK")){
	exit('You can\'t run this file alone.');
}

global $language;

# Traduction
if($language == 'french')
{
    define('_INFO', 'Informations');
    define('_IP', 'Adresse IP');
    define('_LOCAL', 'Localisation');
    define('_INSCRIPTION', 'Inscription');
    define('_OPEN', 'Ouverte');
    define('_CLOSE', '<span style="color: #f00">Fermée</span>');
    define('_OPTION', 'Options');
    define('_SHOWIP', 'Information IP');
    define('_NBCONNECTED', 'Statistiques de connexion');
    define('_RECORD', 'Record');
    define('_YESDAY', 'Hier');
    define('_TODAYC', 'Aujourd\'hui');
    define('_CONNECT', 'Connectés');
    define('_HIDDEN', 'Cacher');
    define('_AFFCONNECT', 'Afficher les connectés dans');
    define('_BULLE', 'Infobulle');
    define('_GBOOK', 'Livre d\'or');
    define('_NBSIGN', 'Signature');
    define('_LASTSIGN', 'Dernière signature');
    define('_BY', 'Par');
    define('_SIGNGUESTBOOK', 'Signer le livre d\'or');
}
else if($language == 'english')
{
    define('_INFO', 'Data');
    define('_IP', 'Address IP');
    define('_LOCAL', 'Location');
    define('_INSCRIPTION', 'Registration');
    define('_OPEN', 'Open');
    define('_CLOSE', '<span style="color: #f00">Close</span>');
    define('_OPTION', 'Options');
    define('_SHOWIP', 'IP information');
    define('_NBCONNECTED', 'Connection statistics');
    define('_RECORD', 'Record');
    define('_YESDAY', 'Yesterday');
    define('_TODAYC', 'Today');
    define('_CONNECT', 'Connected');
    define('_HIDDEN', 'Hide');
    define('_AFFCONNECT', 'Show logged in');
    define('_BULLE', 'Tooltip');
    define('_GBOOK', 'Guestbook');
    define('_NBSIGN', 'Signature');
    define('_LASTSIGN', 'Last signature');
    define('_BY', 'By');
    define('_SIGNGUESTBOOK', 'Sign the guestbook');
}

function affich_block_login($blok)
{
    global $user, $nuked, $bgcolor3, $bgcolor1 ;

    list($login, $messpv, $members, $online, $avatar, $info_ip, $nb_connected, $aff, $guestbook) = explode('|', $blok['content']);
    $blok['content'] = '';

	$c = 0;

	if($login != 'off')
	{
		if (!$user)
		{
			$blok['content'] = '<form action="index.php?file=User&amp;nuked_nude=index&amp;op=login" method="post">'."\n"
			. '<table style="margin-left: auto;margin-right: auto;text-align: left;">'."\n"
			. '<tr><td>' . _NICK . ' :</td><td><input type="text" name="pseudo" size="10" maxlength="250" /></td></tr>'."\n"
			. '<tr><td>' . _PASSWORD . ' :</td><td><input type="password" name="pass" size="10" maxlength="15" /></td></tr>'."\n"
			. '<tr><td colspan="2" align="center"><input type="checkbox" class="checkbox" name="remember_me" value="ok" checked="checked" />&nbsp;' . _SAVE . '</td></tr>'."\n"
			. '<tr><td colspan="2" align="center"><input type="submit" value="' . _BLOGIN . '" /></td></tr>'."\n"
			. '<tr><td colspan="2" align="center"><a href="index.php?file=User&amp;op=reg_screen">' . _REGISTER . '</a><br />'."\n"
			. '<a href="index.php?file=User&amp;op=oubli_pass">' . _FORGETPASS . '</a> ?</td></tr></table></form>'."\n";
		}
		else
		{
			$blok['content'] = '<div style="text-align: center;">' . _WELCOME . ', <b>' . $user[2] . '</b><br /><br />';

			if ($avatar != 'off')
			{
				$sql_avatar=mysql_query('SELECT avatar FROM ' . USER_TABLE . ' WHERE id = \'' . $user[0] . '\' ');
				list($avatar_url) = mysql_fetch_array($sql_avatar);

				if($avatar_url) $blok['content'] .= '<img src="' . $avatar_url . '" style="border:1px ' . $bgcolor3 . ' dashed; width:100px; background:' . $bgcolor1 . '; padding:2px;" alt="' . $user[2] . ' avatar" /><br /><br />';
                # Rajout du noavatar
                else if($avatar_url == NULL) $blok['content'] .= '<img src="modules/User/images/noavatar.png" style="border: 1px ' . $bgcolor3 . ' dashed;padding:5px" alt="' . $user[2] . ' avatar" /><br /><br />';
			}

			$blok['content'] .= '<a href="index.php?file=User">' . _ACCOUNT . '</a> / <a href="index.php?file=User&amp;nuked_nude=index&amp;op=logout">' . _LOGOUT . '</a></div>'."\n";
		}
		$c++;
	}

    if($messpv != 'off' && $user[0] != '')
	{
		if ($c > 0) $blok['content'] .= '<hr style="height: 1px;" />';

		$sql2 = mysql_query('SELECT mid FROM ' . USERBOX_TABLE . ' WHERE user_for = \'' . $user[0] . '\' AND status = 1');
		$nb_mess_lu = mysql_num_rows($sql2);

		$blok['content'] .= '&nbsp;<img src="images/report.gif" alt="" />&nbsp;<span style="text-decoration: underline"><b>' . _MESSPV . '</b></span><br />';

		if ($user[5] > 0)
		{
			$blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _NOTREAD . ' : <a href="index.php?file=Userbox"><b>' . $user[5] . '</b></a>'."\n";
		}
		else
		{
			$blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _NOTREAD . ' : <b>' . $user[5] . '</b>'."\n";
		}

		if ($nb_mess_lu > 0)
		{
			$blok['content'] .= '<br />&nbsp;<b><big>·</big></b> ' . _READ . ' : <a href="index.php?file=Userbox"><b>' . $nb_mess_lu . '</b></a>'."\n";
		}
		else
		{
			$blok['content'] .= '<br />&nbsp;<b><big>·</big></b> ' . _READ . ' : <b>' . $nb_mess_lu . '</b>'."\n";
		}

		$c++;
    }

    # Information IP + Localisation
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip_user = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_CLIENT_IP'])) $ip_user = $_SERVER['HTTP_CLIENT_IP'];
    else $ip_user = $_SERVER['REMOTE_ADDR'];

    $inetaddr = ip2long($ip_user);
    $ip_user = long2ip($inetaddr);

    if($info_ip != 'off')
    {
        if($c > 0) $blok['content'] .= '<hr style="height: 1px" />';

         $blok['content'] .= '&nbsp;<img src="images/report.gif" alt="" /> <span style="text-decoration: underline"><b>' . _INFO . '</b></span><br />' . "\n"
        . '&nbsp;<b><big>·</big></b> ' ._IP . ' : <b>' .$ip_user . '</b>' . "\n";
//        . '<br />&nbsp;<b><big>·</big></b> ' . _LOCAL . ' : <b><script  type="text/javascript" src="http://map.geoup.com/geoup?template=CountryName"></script></b>';

        $c++;
    }

    # Statistiques de connexion
    if($nb_connected != 'off')
    {
        if ($c > 0) $blok['content'] .= '<hr style="height: 1px;" />';

        $nom = $user[2];

        if($_SERVER['HTTP_CLIENT_IP']) $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if ($_SERVER['HTTP_X_FORWARDED_FOR']) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else $ip = $_SERVER['REMOTE_ADDR'];

        if($nom == '') $nom = 'visiteur';

        $sql = mysql_query('SELECT temps, record FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE nom = \'\'');
        list($temps, $record) = mysql_fetch_row($sql);

        if(time() >= $temps)
        {
            $sql3 = mysql_query('SELECT * FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE nom != \'\'');
            $con_hier = mysql_num_rows($sql3);

            $temps = $temps + (3600*24);

            $sql2 = mysql_query('DELETE FROM ' . $nuked['prefix'] . '_nbconnect_jour');

            if($con_hier > $record)
            {
                $sql1 = mysql_query('INSERT INTO ' . $nuked['prefix'] . '_nbconnect_jour VALUES (\'\',\'\',\'' . $temps . '\',\'' . $con_hier . '\',\'' . $con_hier . '\',\'\')');
            }
            else
            {
                $sql1 = mysql_query('INSERT INTO ' . $nuked['prefix'] . '_nbconnect_jour VALUES (\'\',\'\',\'' . $temps . '\',\'' . $con_hier . '\',\'' . $record . '\',\'\')');
            }

            $sql = mysql_query('INSERT INTO '. $nuked['prefix'] . '_nbconnect_jour VALUES (\'\',\'' . $nom . '\',\'\',\'\',\'\',\'' . $ip .'\')');
        }

        if($nom != 'visiteur')
        {
            $sql = mysql_query('SELECT nom, ip FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE nom = \'' . $nom . '\' OR ip =\'' . $ip . '\'');
            $count = mysql_num_rows($sql);
            list($visiteur, $Vist_ip) = mysql_fetch_row($sql);

            if($count == 1)
            {
                if($Vist_ip == $ip && $nom != $visiteur) $sql = mysql_query('UPDATE ' . $nuked['prefix'] . '_nbconnect_jour SET nom = \'' . $nom . '\' WHERE ip = \'' . $ip . '\'');
                if($Vist_ip != $ip && $nom == $visiteur) $sql = mysql_query('UPDATE ' . $nuked['prefix'] . '_nbconnect_jour SET ip = \'' . $ip . '\' WHERE nom = \'' . $nom . '\'');
            }
        }
        else
        {
            $sql = mysql_query('SELECT nom FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE ip = \'' . $ip . '\'');
            list($visiteur) = mysql_fetch_row($sql);
            $count = mysql_num_rows($sql);

            if($visiteur == 'visiteur') $sql = mysql_query("UPDATE " . $nuked['prefix'] . "_nbconnect_jour SET nom = '" . $nom . "' WHERE ip = '" . $ip . "'");
        }

        if($count == 0) $sql = mysql_query('INSERT INTO ' . $nuked['prefix'] . '_nbconnect_jour VALUES (\'\',\'' . $nom . '\',\'' . $temps . '\',\'\',\'\',\'' . $ip . '\')');

        $blok['content'] .= '&nbsp;<img src="images/report.gif" alt="" />&nbsp;<span style="text-decoration: underline"><b>' . _NBCONNECTED . '</b></span><br />';

        $sql = mysql_query('SELECT hier, record FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE nom = \'\'');
        list($con_hier, $record) = mysql_fetch_row($sql);

        $blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _RECORD . ' : <b>' . $record . '</b>
        <br />&nbsp;<b><big>·</big></b> ' . _YESDAY . ' : <b>' . $con_hier . '</b><br />';

        $sql = mysql_query('SELECT * FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE nom != \'\'');
        $today = mysql_num_rows($sql);

        $blok['content'] .= '&nbsp;<b><big>·</big></b> ' ._TODAYC . ' : <b>' . $today . '</b>';

        $sql = mysql_query('SELECT nom FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE nom != \'\' AND nom != \'visiteur\'');
        while(list($nom_vist) = mysql_fetch_row($sql))
        {
			$list_vist .= '&nbsp;&nbsp;-&nbsp;' . $nom_vist .'<br />';
        }

        $sql = mysql_query('SELECT nom FROM ' . $nuked['prefix'] . '_nbconnect_jour WHERE nom = \'visiteur\'');
        $visite = mysql_num_rows($sql);

        if($visite > 0)
        {
            if($visite > 1) $s = 's';
            $list_vist .= '&nbsp;&nbsp;-&nbsp;' . $visite . '&nbsp;visiteur' . $s;
        }

        if($aff == 'div')
        {
            echo "<script type=\"text/javascript\">\n"
	        . "<!--\n"
	        . "function cacherDiv(id,div)\n"
	        . "{\n"
  	        . "	if(document.getElementById(id).style.visibility == 'hidden')\n"
  	        . " {\n"
  	        . " 	document.getElementById(id).style.visibility = 'visible';\n"
  	        . "   document.getElementById(id).style.position = 'relative';\n"
  	        . "   document.getElementById(id).style.width = '100%';\n"
  	        . "   document.getElementById(div).innerHTML = '". _HIDDEN ."';\n"
  	        . "	}\n"
  	        . " else\n"
  	        . " {\n"
  	        . " 	document.getElementById(id).style.visibility = 'hidden';\n"
  	        . "   document.getElementById(id).style.position = 'absolute';\n"
  	        . "   document.getElementById(id).style.width = '';\n"
  	        . "   document.getElementById(div).innerHTML = '". _LIST ."';\n"
  	        . "	}\n"
  	        . "}\n"
  	        . "// -->\n"
  	        . "</script>\n";

            $blok['content'] .= '&nbsp;[<a href="javascript:cacherDiv(\'listVist\', \'cacherSpan\');"><span id="cacherSpan">' . _LIST . '</span></a>]';
        }
        else
        {
            $blok['content'] .= '&nbsp;[<a href="#" onmouseover="AffBulle(\'&nbsp;&nbsp;' . _CONNECT . '\', \'' . htmlentities(addslashes($list_vist)). '\', 120)" onmouseout="HideBulle()">' . _LIST . '</a>]';
        }

        $blok[content] .= '<br/ ><div id="listVist" style="visibility:hidden;position:absolute;">' . $list_vist . '</div>';

        $c++;
    }

    # Livre d'or
	if($guestbook != 'off')
	{
		if ($c > 0) $blok['content'] .= '<hr style="height: 1px;" />';

    	$blok['content'] .= '&nbsp;<img src="images/report.gif" alt="" />&nbsp;<span style="text-decoration: underline"><b>' . _GBOOK . '</b></span><br />';

		$sql_1 = mysql_query('SELECT name, date FROM ' . GUESTBOOK_TABLE . ' ORDER BY id DESC');
		list($name, $date) = mysql_fetch_array($sql_1);

		$sql_2 = mysql_query('SELECT country FROM ' . USER_TABLE. ' WHERE pseudo = \'' . $nom . '\'');
		list($country) = mysql_fetch_array($sql_2);
		list($pays, $ext) = explode ('.', $country);

        if($country == NULL) $country = 'france.gif';
		$pays = 'France';

		if(mysql_num_rows($sql_1) > 1) $s = 's';

    	$blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _NBSIGN . $s . ' : <b>' . mysql_num_rows($sql_1) . '</b><br />';

		if(mysql_num_rows($sql_1) > 0)
		{
		    $blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _LASTSIGN . ' : <b>' . nkDate($date) . '</b><br />
		    &nbsp;<b><big>·</big></b> ' . _BY . ' : <img src="images/flags/' . $country . '" alt="" title="' . $pays . '" /> <a href="?file=Members&amp;op=detail&amp;autor=' . urlencode($name) . '">' . $name . '</a>';
		}
		else
		{
		    $blok['content'] .= '<div style="padding-top: 5px;text-align: center">[<a href="?file=Guestbook&amp;op=post_book">' . _SIGNGUESTBOOK . '</a>]</div>';
		}

		$c++;
	}

    # Membres
	if($members != 'off')
	{
		if ($c > 0) $blok['content'] .= '<hr style="height: 1px;" />';

    	$blok['content'] .= '&nbsp;<img src="images/report.gif" alt="" />&nbsp;<span style="text-decoration: underline"><b>' . _MEMBERS . '</b></span><br />';

    	$sql_users = mysql_query('SELECT id FROM ' . USER_TABLE . ' WHERE niveau < 3');
    	$nb_users = mysql_num_rows($sql_users);

    	$sql_admin = mysql_query('SELECT id FROM ' . USER_TABLE . ' WHERE niveau > 2');
    	$nb_admin = mysql_num_rows($sql_admin);

    	$blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _ADMINS . ' : <b>' . $nb_admin . '</b>
        <br />&nbsp;<b><big>·</big></b> ' . _MEMBERS . ' : <b>' . $nb_users . '</b> [<a href="index.php?file=Members">' . _LIST . '</a>]<br />';

        # Détail inscription
		if($nuked['inscription'] == 'on') $detail_inscription = '<a href="?file=User&amp;op=reg_screen">' . _OPEN . '</a>';
		else if($nuked['inscription'] == 'off') $detail_inscription = _CLOSE;

		$blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _INSCRIPTION . ' : ' . $detail_inscription . ''."\n";

		$c++;
	}

    # Online
	if($online != 'off')
	{
		if ($c > 0) $blok['content'] .= '<hr style="height: 1px;" />';

    	$blok['content'] .= '&nbsp;<img src="images/report.gif" alt="" />&nbsp;<span style="text-decoration: underline"><b>' . _WHOISONLINE . '</b></span><br />';

    	$nb = nbvisiteur();

    	if ($nb[1] > 0)
		{
			$sql4 = mysql_query('SELECT username FROM ' . NBCONNECTE_TABLE . ' WHERE type BETWEEN 1 AND 2 ORDER BY date');
			while (list($nom) = mysql_fetch_array($sql4))
			{
				   $user_online .= '&nbsp;<b><big>·</big></b>&nbsp;<b>' . $nom . '</b><br />';
			}

			$user_list = '&nbsp;[<a href="#" onmouseover="AffBulle(\'&nbsp;&nbsp;' . _WHOISONLINE . '\', \'' . htmlentities(mysql_real_escape_string($user_online), ENT_NOQUOTES) . '\', 150)" onmouseout="HideBulle()">' . _LIST . '</a>]';
		}
    	else
		{
			$user_list = '';
    	}

		if ($nb[2] > 0)
		{
			$sql5 = mysql_query('SELECT username FROM ' . NBCONNECTE_TABLE . ' WHERE type > 2 ORDER BY date');
			while (list($name) = mysql_fetch_array($sql5))
			{
				$admin_online .= '&nbsp;<b><big>·</big></b>&nbsp;<b>' . $name . '</b><br />';
			}

			$admin_list = '&nbsp;[<a href="#" onmouseover="AffBulle(\'&nbsp;&nbsp;' . _WHOISONLINE . '\', \'' . htmlentities(mysql_real_escape_string($admin_online), ENT_NOQUOTES) . '\', 150)" onmouseout="HideBulle()">' . _LIST . '</a>]';
		}
		else{
			$admin_list = '';
		}

		$blok['content'] .= '&nbsp;<b><big>·</big></b> ' . _VISITOR;
		if ($nb[0] > 1) $blok['content'] .= 's';
		$blok['content'] .= ' : <b>' . $nb[0] . '</b><br />&nbsp;<b><big>·</big></b> ' . _MEMBER;
		if ($nb[1] > 1) $blok['content'] .= 's';
		$blok['content'] .= ' : <b>' . $nb[1] . '</b>' . $user_list . '<br />&nbsp;<b><big>·</big></b> ' . _ADMIN;
		if ($nb[2] > 1) $blok['content'] .= 's';
		$blok['content'] .= ' : <b>' . $nb[2] . '</b>' . $admin_list . '<br />'."\n";

		$c++;
    }

    return $blok;
}

function edit_block_login($bid)
{
    global $nuked, $language;

    $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
    list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
    $titre = printSecuTags($titre);
    list($login, $messpv, $members, $online, $avatar, $info_ip, $nb_connected, $aff, $guestbook) = explode('|', $content);

    if($active == 1) $checked1 = 'selected="selected"';
    else if ($active == 2) $checked2 = 'selected="selected"';
    else $checked0 = 'selected="selected"';

    if($login == 'off') $checked3 = 'selected="selected"'; else $checked3 = '';
    if($messpv == 'off') $checked4 = 'selected="selected"'; else $checked4 = '';
    if($members == 'off') $checked5 = 'selected="selected"'; else $checked5 = '';
    if($online == 'off') $checked6 = 'selected="selected"'; else $checked6 = '';
	if($avatar == 'off') $checked7 = 'selected="selected"'; else $checked7 = '';

	# Information IP / Localisation
	if($info_ip == 'off') $checked8 = 'selected="selected"'; else $checked8 = '';

	# Statistiques de connexion
	if($nb_connected == 'off') $checked9 = 'selected="selected"'; else $checked9 = '';
    if($aff == 'div') $checked10 = 'checked="checked"'; else $checked11 = 'checked="checked"';

	# Livre d'or
	if($guestbook == 'off') $checked12 = 'selected="selected"'; else $checked12 = '';

    # Start Content Box
    echo '<div class="content-box">
	<div class="content-box-header"><h3>' . _BLOCKADMIN . '</h3>
	<div style="text-align:right"><a href="help/' . $language . '/block.php" rel="modal"><img style="border: 0;" src="help/help.gif" alt="" title="' . _HELP . '" /></a>
	</div></div>
	<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">
	<table style="margin: 0 auto" cellspacing="0" cellpadding="2" border="0">
	<tr><td><b>' . _TITLE . '</b></td><td><b>' . _BLOCK . '</b></td><td><b>' . _POSITION . '</b></td><td><b>' . _LEVEL . '</b></td></tr>
	<tr><td align="center"><input type="text" name="titre" size="40" value="' . $titre . '" /></td>
	<td align="center"><select name="active">
	<option value="1" ' . $checked1 . '>' . _LEFT . '</option>
	<option value="2" ' . $checked2 . '>' . _RIGHT . '</option>
	<option value="0" ' . $checked0 . '>' . _OFF . '</option></select></td>
	<td align="center"><input type="text" name="position" size="2" value="' . $position . '" /></td>
	<td align="center"><select name="nivo"><option>' . $nivo . '</option>
	<option>0</option>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6</option>
	<option>7</option>
	<option>8</option>
    <option>9</option></select></td></tr>
	<tr><td colspan="4"><b>' . _OPTION . ' :</b></td></tr>
	<tr><td colspan="4">
	<span style="display: inline-block;width: 15%">' . _LOGIN . ' : <select name="login"><option value="on">' . _YES . '</option><option value="off" ' . $checked3 . '>' . _NO . '</option></select></span>
	<span style="display: inline-block;width: 15%">' . _MESSPV . '  : <select name="messpv"><option value="on">' . _YES . '</option><option value="off" ' . $checked4 . '>' . _NO . '</option></select></span>
	<span style="display: inline-block;width: 15%">' . _MEMBERS . ' : <select name="members"><option value="on">' . _YES . '</option><option value="off" ' . $checked5 . '>' . _NO . '</option></select></span>
	</td></tr><tr><td colspan="4">
	<span style="display: inline-block;width: 15%">' . _WHOISONLINE . ' : <select name="online"><option value="on">' . _YES . '</option><option value="off" ' . $checked6 . '>' . _NO . '</option></select></span>
	<span style="display: inline-block;width: 15%">' . _SHOWAVATAR . ' : <select name="avatar"><option value="on">' . _YES . '</option><option value="off" ' . $checked7 . '>' . _NO . '</option></select></span>';

    # Information IP / Localisation
	echo '<span style="display: inline-block;width: 15%">' . _SHOWIP . ' : <select name="info_ip"><option value="on">' . _YES . '</option><option value="off" ' . $checked8 . '>' . _NO . '</option></select></span>
    </td></tr><tr><td colspan="4">';

    # Statistiques de connexion
    echo '<span style="display: inline-block;width: 20%">' . _NBCONNECTED . ' : <select name="nb_connected"><option value="on">' . _YES . '</option><option value="off" ' . $checked9 . '>' . _NO . '</option></select></span>
    <span style="display: inline-block;width: 25%">' . _AFFCONNECT . ' : <input type="radio" name="aff" value="div" ' . $checked10 . ' /> Div <input type="radio" name="aff" value="bulle" ' . $checked11 . ' /> ' . _BULLE . '</span>';

    # Livre d'or
    echo '<span style="display: inline-block;width: 20%">' . _GBOOK . ' : <select name="guestbook"><option value="on">' . _YES . '</option><option value="off" ' . $checked12 . '>' . _NO . '</option></select></span>
	</td></tr>
	<tr><td colspan="4" align="center"><b>' . _PAGESELECT . ' :</b></td></tr><tr><td colspan="4"></td></tr>
	<tr><td colspan="4" align="center"><select name="pages[]" size="8" multiple="multiple">';

    select_mod2($pages);

    echo '</select></td></tr><tr><td colspan="4" align="center"></td></tr></table>
	<div style="text-align: center;"><br />
    <input type="hidden" name="type" value="' . $type . '" />
	<input type="hidden" name="bid" value="' . $bid . '" />
	<input type="submit" name="send" value="' . _MODIFBLOCK . '" class="button" />&nbsp;
	<a href="?file=Admin&amp;page=block" class="button">' . _BACK . '</a></div></form><br /></div></div>';
}

function modif_advanced_login($data)
{
	$data['content'] = $data['login'] . '|' . $data['messpv'] . '|' . $data['members'] . '|' . $data['online']. '|' . $data['avatar'] . '|' . $data['info_ip'] . '|' . $data['nb_connected'] . '|' . $data['aff'] . '|' . $data['guestbook'];
	return $data;
}
?>