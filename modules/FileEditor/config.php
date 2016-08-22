<?php
defined("INDEX_CHECK") or die ("<div class=\"centre\">You cannot open this page directly</div>");

/* -------------------------/
/ DEBUT DE LA CONFIGURATION /
/ -------------------------*/

// liste des extensions autorisées (modification)
$autor_ext = array('php', 'txt', 'html', 'css', 'tpl', 'js');
// liste des extensions autorisées (création)
$autor_ext_new = array('php', 'txt', 'html', 'css', 'tpl', 'js');
// liste des extensions autorisées (renommage)
$autor_ext_rename = array('php', 'txt', 'html', 'css', 'tpl', 'js', 'jpeg', 'jpg', 'gif', 'png');
// liste des extensions autorisées (upload)
$autor_ext_upload = array('php', 'txt', 'html', 'css', 'tpl', 'js', 'jpeg', 'jpg', 'gif', 'png');
// liste des extensions autorisées (delete)
$autor_ext_del= array('php', 'txt', 'html', 'css', 'tpl', 'js', 'jpeg', 'jpg', 'gif', 'png');

// répertoire racine
// pour autoriser la modification de tous les fichiers du site (à vos risques et périls), remplacer 'themes/' par '../'
$root = 'themes/';

// mot de passe d'accès au module
$passw = "password";

/* -------------------------/
/  FIN DE LA CONFIGURATION  /
/ -------------------------*/

if (!empty($passw))
{
	if ( $_REQUEST['mdp'] == $passw ) 
	{
		setcookie('FileEditor', '1', time()+3600);
		redirect('index.php?file=FileEditor&page=admin',0);
	} 
		
	if ( $_COOKIE['FileEditor'] != '1' )
	{
		echo '<div class="access">';
		echo '<form action="index.php?file=FileEditor&amp;page=admin" method="post">';
		echo '<h3 style="text-align:center;">' . _MODPASSW . '</h3>';
		echo '<p><input type="password" name="mdp" /></p>';
		echo '<p><input type="submit" /></p>';
		echo '</form>';	
		echo '<span>' . _EXPLPASSW . '</span>';
		echo '</div>';	
		echo '<div class="access">' . _ERROR_OB . '</div>';	
		exit();
	}
}
?>