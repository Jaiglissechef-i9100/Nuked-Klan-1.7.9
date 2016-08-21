<?php
global $nuked, $op, $file, $user,$language, $bgcolor2, $page;

$sql2 = mysql_query("SELECT mid FROM " . USERBOX_TABLE . " WHERE user_for = '" . $user[0] . "' AND status = 1");
        $nb_mess_lu = mysql_num_rows($sql2);

   if (!$user) {
  $blok['content'] = '
	<form method="post" name="login"  action="index.php?file=User&amp;nuked_nude=index&amp;op=login"> 

	<div class="username"><img src="themes/EvilGame/images/'.$var_l.'/username.png" alt="username" /></div>
	<div class="input"><input class="ip"  name="pseudo" type="text" size="13" value="Username" onfocus="this.value=\'\'" /> </div>
	<div class="password"><img src="themes/EvilGame/images/'.$var_l.'/password.png" alt="password" /></div>
	<div class="input"><input class="ip" name="pass" type="password" size="13" value="Password" onfocus="this.value=\'\'" /></div>
	<div class="right"><input class="send" type="submit" /><a  onclick="login.submit()"><img src="themes/EvilGame/images/'.$var_l.'/login.png" alt="send"/></a></div>
	<div class="right"><a  onfocus="this.blur();" href="index.php?file=User&amp;op=reg_screen"><img  src="themes/EvilGame/images/'.$var_l.'/register.png" border="0" alt="" /></a></div>
</form>';
	echo $blok['content'];
}
   else { 
   $user_welcome = "" . _WELCOME . " <b>" . $user[2] . "</b>";
   $compte  = "&#8226; <a class='top_link' href=\"index.php?file=User\">". _NAVACCOUNT ."</a>";
   $logout  = "&#8226; <a class='top_link' href=\"index.php?file=User&amp;nuked_nude=index&amp;op=logout\">" . _LOGOUT . "</a>";
   $message = "&#8226; <a class='top_link' href=\"index.php?file=Userbox\">$user[5] </a>nouveaux messages "; 
   
	if($user[1] > 2)
		{
		$info_admin = ' <b>&#8226;  <a class="link_menu" href="index.php?file=Admin"> Administration</a> &#8226;  <a class="link_menu"  href="themes/EvilGame/theme_cfg.php">Admin theme</a></b> ';
		}
 
?>


<div id="logged">
<?php echo $user_welcome; ?> <?php echo $info_admin; ?><br />


<span>
<?php echo $compte; ?> <?php echo $message; ?> <?php echo $logout; ?> 
</span>
</div>

<?php
}
?>