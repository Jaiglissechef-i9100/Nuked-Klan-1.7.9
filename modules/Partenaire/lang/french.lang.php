<?php
if (!defined("INDEX_CHECK"))
{
	exit('You can\'t run this file alone.');
}

///// Block /////

define("_BANNIERE","Bannière");
define("_SITE","Site");
define("_DESCRIPTION","Description");
define("_PROPOSER"," Proposer ");
define("_PROPOSERU","[ Proposer un partenariat ]");

///// Voir + /////

define("_AUTHOR","Auteur");
define("_ADDTHE","Ajouté le");
define("_SITEWEB","Site Web");
define("_DESC","Description");
define("_LOGO","Bannière");

//// Proposer un partenariat /////

define("_PROPO","Proposer un partenariat");
define("_NOMSITE","Nom du site");
define("_WEBSITE","Adresse du site");
define("_URLLOGO","Adresse de la bannière au format 460 sur 60px");
define("_URLLOGO1","Adresse de la bannière au format 80 sur 31px");
define("_DESCRSIMPLE","Description Simple");
define("_UPLOGO","Upload Logo");
define("_UPLOGO1","Upload Logo");
define("_REST1","Il vous reste");
define("_REST2","caractères.");
define("_NOTRE","Notre code xHTML pour la bannière");
define("_PROPOPART"," Proposer ");
define("_NOTIFFAIL","Vous n'avez pas remplie tous les champs.");
define("_NOSITE","Le nom du site n'est pas rempli !");
define("_NOLIENS","Url du site n'est pas remplie !");
define("_PARTESEND","Demande de partenariat envoyé");
define("_NOTIFNEWPART"," a demande un partenariat");

///// Administration /////

define("_ADMINPARTENAIRE","Administration Des Partenaires");
define("_INFO1","En cas de problème, veuillez-le signaler sur <a href=\"http://www.nk-create.com\">www.nk-create.com</a> dans le forum prévu à cet effet ou sur le forum officiel NK");
define("_SUITE","Lire la suite");
define("_COPYPART","<a href='http://www.nk-create.com' title='Nk-Create'>&copy;</a>");
define("_ADMINVALID","Bannière validée");
define("_ADMINAVALIDE","Bannière en attente");
define("_NOM","Nom");
define("_OUI","Oui");
define("_NON","Non");
define("_EDITER","Editer");
define("_VALIDE","Valider");
define("_NOPART","Il n’y a pas de partenaire valide.");
define("_NOPART1","Il n'y a pas de partenaire.");
define("_NOPARTA","Il n'y a pas de partenaire en attente.");
define("_MODIFPREF","Modifier la configuration");
define("_TAILLE460","Format 460*60px");
define("_TAILLE80","Format 80*31px");
define("_POSITIONX","Position X");
define("_POSITIONXHELP","Vous pouvez déplacer bannière gauche, droite ( 0 = centrer )");
define("_POSITIONY","Position Y");
define("_POSITIONYHELP","Vous pouvez déplacer bannière haut, bas ( 0 = centrer )");
define("_TAILLEHELP460","Activer la taille affichage 468*60px");
define("_TAILLEHELP80","Activer la taille affichage 80*31px");
define("_UPLOAD","Upload");
define("_UPLOADHELP","Autorisé upload de logo");
define("_EASINGIN","EasingIn");
define("_EASINGOUT","EasingOut");
define("_EASINGINHELP","Transition de l’entrer ( Linear.easeNone conseillez )");
define("_EASINGOUTHELP","Transition de sortie");
define("_TRANSTYPE","Transition Type");
define("_ALERTMAJ","Une mise à jour est disponible visitez le site <a href=\"http://www.nk-create.com\">www.nk-create.com</a> pour la télécharger. Version actuel : ");
define("_ALERTMAJ1"," ,Version disponible : ");
define("_TRANSTYPEHELP","Définit l’effet");
define("_BLUREFFET","Effet Blur");
define("_BLUREFFETHELP","Augmenter la valeur pour augmenter l'effet de flou.");
define("_OPENHTML","Clic lien");
define("_OPENHTMLHELP","Self : Même page – New : Nouvelle page");
define("_TEMPS","Temps");
define("_ATTENTE","Mètre en attente");
define("_TEMPSHELP","Temps affichage");
define("_TWEENTIME","Temps de cache");
define("_TWEENTIMEIN","Temps qui montre");
define("_TWEENTIMEHELP","Déterminent le temps qui cache la bannière");
define("_TWEENTIMEINHELP","Déterminent le temps qui montre la bannière");
define("_PREFSENDOK","Préférence modifié avec succès.");
define("_ALERTMAJ","Une mise à jour est disponible visitez le site <a href=\"http://www.nk-create.com\">www.nk-create.com</a> pour la télécharger. Version actuel : ");
define("_ALERTMAJ1"," ,Version disponible : ");
define("_VALIDOK","Validé ce partenaire");
define("_EDITTHISPART","Editer ce partenaire");
define("_DELPART","Effacer ce partenaire");
define("_ADDPART","Ajouter ce partenaire");
define("_NOMHELP","Nom du partenaire");
define("_WEB","URL");
define("_WEBHELP","Lien du site");
define("_WEBMASTER","Administrateur");
define("_WEBMASTERHELP","Administrateur du site");
define("_LOGOPART","Logo Block centre-bas");
define("_UPLOGO","Upload Logo");
define("_LOGOPART1","Logo Block gauche-droite");
define("_DESCR","Description");
define("_NOTIFFAILURL","Le champ <b>URL</b> doit être rempli.");
define("_NOTIFFAILNOM","Le champ <b>Nom</b> doit être rempli.");
define("_NOTIFFAILLOGO","Un <b>Logo</b> doit être uploadé ou mis en liens");
define("_PARTSEND","A ajouter un partenaire : ");
define("_NOTIFSEND","Partenaire ajouté avec succès. ");
define("_REPLACE","Ecraser si déjà présent.");
define("_FAILEDUP","Upload raté, réessaye svp.");
define("_FAILEDUP1","L'extension de upload est incorrecte uniquement : jpeg, png, gif");
define("_DELETEPART","Effacer le partenaire : ");
define("_ACTIONDELPART","A efface le partenaire : ");
define("_PARTDELOK","Le partenaire a étais efface avec succès.");
define("_DESCRSIMPLEHELP","Petite description de l'index");
define("_TAILLETEXTEDESC","Taille description");
define("_TAILLETEXTEDESCHELP","Taille de la petite description de l'index");
define("_VALIDSENDOK","Partenaire validée avec succès");
define("_VALIDSENDNOK","Partenaire mis en attente avec succès");
define("_NONVALIDE","Attente");
define("_MODIFPART","Modifier ce partenaire");
define("_PARTMODIF","a modifier le partenaire ");
define("_NOMBREBAN","Nombre de partenaire");
define("_NOMBREBANHELP","Nombre de partenaire par page");
define("_MYLOGO","Logo grand format");
define("_MYLOGOHELP","Liens de votre logo au format 460 sur 60px.");
define("_MYLOGO1","Logo petit format");
define("_MYLOGOHELP1","Liens de votre logo au format 80 sur 31px.");
?>