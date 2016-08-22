<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die;

$lifetime = $nuked['sess_days_limit'] * 86400;
$timesession = $nuked['sess_inactivemins'] * 60;
$time = time();
$timelimit = $time + $lifetime;
$sessionlimit = $time + $timesession;

$cookie_session = $nuked['cookiename'] . '_sess_id';
$cookie_theme = $nuked['cookiename'] . '_user_theme';
$cookie_langue = $nuked['cookiename'] . '_user_langue';
$cookie_visit = $nuked['cookiename'] . '_last_visit';
$cookie_admin = $nuked['cookiename'] . '_admin_session';
$cookie_forum = $nuked['cookiename'] . '_forum_read';
$cookie_userid = $nuked['cookiename'] . '_userid';
$cookie_userip = $nuked['cookiename'] . '_userip';

// Création d'un cookie captcha
$cookie_captcha = $nuked['cookiename'] . '_captcha';
setcookie($cookie_captcha, 1);

// Recherche de l'adresse IP
$uip = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$uip = explode(',',$uip); // Au cas où X_FORWARDED_FOR rend plusieurs ip on prend la 1er qui est la vrai client ip

// Validité adresse IP v4 / v6
if(isset($uip) && !empty($uip)) {
    if(preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $uip[0])) $user_ip = $uip[0];
    elseif(preg_match('/^(([A-Fa-f0-9]{1,4}:){7}[A-Fa-f0-9]{1,4})$|^([A-Fa-f0-9]{1,4}::([A-Fa-f0-9]{1,4}:){0,5}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){2}:([A-Fa-f0-9]{1,4}:){0,4}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){3}:([A-Fa-f0-9]{1,4}:){0,3}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){4}:([A-Fa-f0-9]{1,4}:){0,2}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){5}:([A-Fa-f0-9]{1,4}:){0,1}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){6}:[A-Fa-f0-9]{1,4})$/', $uip[0])) $user_ip = $uip[0];
    else $user_ip = '';
}

function checkproxy() {
    global $user_ip;

// Système anti-proxy
$ports = array(80, 88, 443, 554, 808, 1080, 3124, 3127, 3128, 3246, 6588, 8000, 8008, 8080, 8085, 8088, 8118, 9188, 36673);
$hosts = array('mobistar.be', 'videotron.ca');
$user_host = strtolower(@gethostbyaddr($user_ip));

if ($user_host == $user_ip) $host = '';
else{
    if (preg_match('`([^.]{1,})((\.(co|com|net|org|edu|gov|mil))|())((\.(ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|fi|fj|fk|fm|fo|fr|fx|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zr|zw))|())$`', $user_host, $res))
    $host = $res[0];
    }

if (!in_array($host, $hosts)) {
foreach($ports as $port) {

    if(@fsockopen($user_ip, $port, $errstr, $errno, 1))
		die("Proxy or vpn access not allowed while you are connected as user");
}
}
}

function secure(){
    global $nuked, $user_ip, $time, $cookie_visit, $cookie_session, $cookie_userid, $cookie_userip, $cookie_forum, $sessionlimit, $timesession, $timelimit;

    $id_user = '';
    $user_type = 0;
    $user_name = '';
    $last_visite = 0;
    $nb_mess = 0;
    $id_de_session = '';

    if (isset($_COOKIE[$cookie_session]) && !empty($_COOKIE[$cookie_session]))
        $id_de_session = $_COOKIE[$cookie_session];
    if (isset($_COOKIE[$cookie_userid]) && !empty($_COOKIE[$cookie_userid]))
        $id_user = $_COOKIE[$cookie_userid];

    if ($id_de_session != null && $id_user != null) {
        $sql = mysql_query("SELECT date, ip, last_used FROM " . SESSIONS_TABLE . " WHERE id = '" . $id_de_session . "' AND user_id = '" . $id_user . "'");
        $secu_user = mysql_num_rows($sql);
        $row = mysql_fetch_assoc($sql);
        if ($row['date'] > $time - $timesession && $row['ip'] != $user_ip)
            $secu_user = 0;
        if ($secu_user  == 1) {
			if ($row['ip'] != $user_ip) $check_proxy = checkproxy(); // Si pas la même ip on check
            $last_used = $row['last_used'];
            $sql2 = mysql_query("SELECT niveau, pseudo FROM " . USER_TABLE . " WHERE id = '" . $id_user . "'");
            list($user_type, $user_name) = mysql_fetch_array($sql2);
            
            $last_visite = $last_used;
            // Yoken : On update également l'ip qui aura été vérifier juste avant
            $upd = mysql_query("UPDATE " . SESSIONS_TABLE . "  last_used = '" . $time . "', ip = '" . $user_ip . "' WHERE id = '" . $id_de_session . "'");

            if (isset($_REQUEST['file']) && isset($_REQUEST['thread_id']) && $_REQUEST['file'] == 'Forum' && is_numeric($_REQUEST['thread_id']) && $_REQUEST['thread_id'] > 0 && $secu_user > 0) {
                $select_thread = "SELECT MAX(id) FROM " . FORUM_MESSAGES_TABLE . " WHERE date > '" . $last_used . "' AND thread_id = '" . $_REQUEST['thread_id'] . "' ";
                $sql_thread = mysql_query($select_thread);
                list($max_mess_id) = mysql_fetch_array($sql_thread);

                if ($max_mess_id > 0) {
                    if (isset($_REQUEST[$cookie_forum]) && !empty($_REQUEST[$cookie_forum])){
                        $id_read_forum = $_REQUEST[$cookie_forum];
                        if (preg_match("`[^0-9,]`i", $id_read_forum)) $id_read_forum = '';
                        $table_read_forum = explode(',',$id_read_forum);
                        if (!in_array($max_mess_id, $table_read_forum)) setcookie($cookie_forum, $id_read_forum.",".$max_mess_id, $timelimit);
                    }
                    else setcookie($cookie_forum, $max_mess_id, $timelimit);
                }
            }
        }
        // Incorect session information
        else {
			// On crée un cookie ip pour ne ne pas revérifier à chaque session expirée
			setcookie($cookie_userip, $user_ip, $sessionlimit);
            mysql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE id = '" . $id_de_session."'");
            mysql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE user_id = '" . $id_user . "'");
        }

    }
    //Not connected
    else {
        $secu_user = 0;
    }

    if ($secu_user == 1) {
        $sql_mess = mysql_query("SELECT mid FROM " . USERBOX_TABLE . " WHERE user_for = '" . $id_user . "' AND status = 0");
        $nb_mess = mysql_num_rows($sql_mess);
        $user = array($id_user, $user_type, mysql_real_escape_string($user_name), $user_ip, $last_visite, $nb_mess);
    }
    else {
        $user = array();
    }
    return $user;
}

function admin_check() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] == true ? 1 : 0;
}


function session_check() {
    global $nuked, $user_ip, $cookie_session, $time, $timesession;

    if (isset($_COOKIE[$cookie_session]) && !empty($_COOKIE[$cookie_session])) {
        $session = 1;
    }
    else {
        $id_de_session = '';
        $session = 0;
        $user = array();
    }
    return $session;
}

// initialise avec les microsecondes
function make_seed() {
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function init_cookie() {
    global $cookie_session, $cookie_userid, $cookie_userip, $cookie_theme, $cookie_langue, $cookie_forum;
    $test = setcookie($cookie_session, '');
    setcookie($cookie_userid, '');
    setcookie($cookie_theme, '');
    setcookie($cookie_langue, '');
    setcookie($cookie_forum, '');
	setcookie($cookie_userip, ''); // On vide le cookie ip durant la session (sécurité pour les users)
    return($test);
}

function session_new($userid, $remember_me) {
    global $nuked, $cookie_session, $cookie_userid, $cookie_theme, $cookie_langue, $cookie_forum, $user_ip, $cookie_userip, $timelimit, $sessionlimit, $time;

    //On prend un ID de session unique
    do {
        $session_id = md5(uniqid());
    }
    while($sql = mysql_query('SELECT id FROM ' . SESSIONS_TABLE . 'WHERE id = \'' . $session_id . '\'') && mysql_num_rows($sql) != 0);

	// Si ip cookie différente, on vérifie
	if($_COOKIE[$cookie_userip] != $user_ip || ($_COOKIE[$cookie_userip] == '' && $user_ip == '')) $check_proxy = checkproxy();
	
    $test = init_cookie();

    $upd = mysql_query("UPDATE " . SESSIONS_TABLE . " SET `id` = '" . $session_id . "', last_used = date, `date` =  '" . $time . "', `ip` = '" . $user_ip . "' WHERE user_id = '" . $userid . "'");
    if (mysql_affected_rows() == 0)
        $ins = mysql_query("INSERT INTO " . SESSIONS_TABLE . " ( `id` , `user_id` , `date` , `ip` , `vars` ) VALUES( '" . $session_id . "' , '" . $userid . "' , '" . $time . "' , '" . $user_ip . "', '' )");
    if ($upd !== FALSE && $ins !== FALSE) {
        if ($remember_me == "ok") {
            setcookie($cookie_session, $session_id, $timelimit);
            setcookie($cookie_userid, $userid, $timelimit);
        }
        else {
            setcookie($cookie_session, $session_id);
            setcookie($cookie_userid, $userid);
        }
    }
    else {
        mysql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE `user_id` = '" . $userid . "'");
    }
}
?>