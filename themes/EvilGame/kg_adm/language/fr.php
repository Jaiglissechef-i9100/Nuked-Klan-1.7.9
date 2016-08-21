<?php
define('main_gen', 'Preferences Generales');
define('main_block', 'Gestion des Blocks');
define('main_coverage', 'Blocks Coverage');
define('main_video', 'Modules video');
define('main_html', 'Block HTML');
define('main_article', 'Block League');
define('main_other', 'Block TopMatch');
define('main_mess', 'Retour sur le site');

define('mess_ok', 'Votre action à ete realisee avec succes.');
define("mess_err01","Erreur : Impossible d'ecrire dans le fichier <br/><br/><b>kg_adm/preferences.php</b><br/><b>kg_adm/cfg</b><br/><b>kg_adm/cfg/pref.txt</b>, <br/><br/>verifiez les droits en ecriture (CHMOD 777) !");
define("mess_err02","Erreur : Impossible d'ecrire dans le fichier : <br/><br/><b>kg_adm/blocks.php</b><br/> <b>kg_adm/cfg</b><br/> <b>kg_adm/cfg/blocks.txt</b> <br/><br/>verifiez les droits en ecriture (CHMOD 777) !");
define('mess_err03', 'Erreur : Impossible d\'ecrire dans le fichier : <br/><br/><b>kg_adm/video.php</b><br/> <b>kg_adm/cfg</b><br/> <b>kg_adm/cfg/video.txt</b> <br/><br/> verifiez les droits en ecriture (CHMOD 777) !');
define('mess_err04', 'Erreur : Impossible d\'ecrire dans le fichier : <br/><br/><b>kg_adm/html.php</b><br/> <b>kg_adm/cfg</b><br/> <b>kg_adm/cfg/html.txt</b> <br/><br/> verifiez les droits en ecriture (CHMOD 777) !');
define('mess_err05', 'Erreur : Impossible d\'ecrire dans le fichier : <br/><br/><b>kg_adm/article.php</b><br/> <b>kg_adm/cfg</b><br/> <b>kg_adm/cfg/article.txt</b> <br/><br/> verifiez les droits en ecriture (CHMOD 777) !');
define('mess_err06', 'Erreur : Impossible d\'ecrire dans le fichier : <br/><br/><b>kg_adm/topmatch.php</b><br/> <b>kg_adm/cfg</b><br/> <b>kg_adm/cfg/topmatch.txt</b> <br/><br/> verifiez les droits en ecriture (CHMOD 777) !');
define('mess_err07', 'Erreur : Impossible d\'ecrire dans le fichier : <br/><br/><b>kg_adm/coverage.php</b><br/> <b>kg_adm/cfg</b><br/> <b>kg_adm/cfg/coverage.txt</b> <br/><b>dewslider.xml</b> <br/><br/> verifiez les droits en ecriture (CHMOD 777) !');

define('comm_title', 'Communaute');
define('comm_fb', 'URL Facebook :');
define('comm_steam', 'URL Steam :');
define('comm_tw', 'URL Twitter :');
define('comm_help', 'Si aucun lien n\'est rentree alors le logo en question ne s\'affichera pas');

define('match_ulogo', 'Indiquer le lien du logo de votre adversaire :');

define('league', 'Emplacement de l\'image ');
define('league2', 'Site de la league :');

define('page_mess', 'Retour');
define('lang', 'Langage');
define("pref_color","Couleurs du site (STYLES)");
define("pref_color2", "Installer les couleurs du theme :");
define("pref_install", "Installer");
define("pref_tag","Meta Tags");
define("pref_key","Mots Clefs");
define("pref_desc","Description du site");


define("block_show","Afficher");
define("block_hide","Cacher");
define('block_ac', 'Actuellement');
define("block_title", "Afficher, Masquer les blocks suivants");
define('block_display', 'Info : Affichage des <b>blocks droite</b>  lors de la navigation');

define("video_title", "Choisissez votre player");
define('video_compa', 'Compatibilite :');
define('video_for', 'Pour');
define('video_youtube', 'le lien de la page');
define('video_flv', 'indiquer l\'endroit où il se situe');
define('video_daily', 'Prendre uniquement la ligne surlignee');


define('html_title', 'Information sur le block');
define('html_title2', 'Titre du block :');
define('html_source', 'Code HTML :');

define('article_title', 'Choisissez votre type de block');
define('article_tuto1', '<center><h4>Ajouter une image au block « Article Preview »</h2></a>(Cliquer pour afficher)</center>');
define('article_tuto', '
<br/><br/>
<table width="80%" align="center">
<tr>
<td>
Pour ajouter une image à votre article, il suffit de cliquer sur « Upload images » :<br/><br/>
<img src="images/kg_admin/tuto/article1.jpg" alt="article" /><br/><br/>
La premiere image saura automatiquement placee dans le block, les autres ne seront pas affichees. <br/><br/>
<img src="images/kg_admin/tuto/article2.jpg" alt="article" /><br/><br/>
Information : Elle n’a pas besoin d’être placee dans le contenu pour être affichee.
</td>
</tr></table>
');


define('match_title', 'Informations sur le block Topmatch');
define('match_titre', 'Selectionner le match qui sera affiche :');
define('match_logo', 'Indiquer le lien de votre logo :');
define('match_myname', 'Le nom de votre team :');
define('match_tuto1', '<center><h4>Ajouter une image au block « Topmatch »</h2></a>(Cliquer pour afficher)</center>');
define('match_tuto', '
<br/><br/>
<table width="80%" align="center">
<tr>
<td>
Pour ajouter une image à votre block topmatch, il suffit de cliquer sur « Upload screens » :<br/><br/>
<img src="images/kg_admin/tuto/clanwar1.jpg" alt="article" /><br/><br/>
La premiere image saura automatiquement placee dans le block, les autres dans les details des matchs. <br/><br/>
<img src="images/kg_admin/tuto/clanwar2.jpg" alt="article" /><br/><br/>
Informations: <br/>- L\'image doit avoir un fond blanc.<br/>- L\'image doit faire : 78 px x 72 px.
</td>
</tr></table>
');

define('slide_title', 'Informations sur le block Coverage');
define('slide_url', 'Le lien de l\'image ');
define('slide_titre', 'Titre :');

define('lang1', 'Francais');
define('lang2', 'Anglais');

define('news_titre', 'Selectionner une news : ');
define('news_ulogo', 'Lien image du block : ');