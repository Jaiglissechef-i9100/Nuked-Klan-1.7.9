

//////////////////////////////////////////////////

//Module creer par Maxxi			
//
//http://Nuked-Host.tk                          
//
//  --------------------------------------------
//
//Module 1.0 par Tassin                         
//
//Module mis à jour pour la 1.7.9 par YurtY     //
//www.nkhelp.fr                                 
//
//Module V2.0 & 3.0 par Zdav 			//
//www.nuked-klan.org	              
          //
//
////////////////////////////////////////////////

****************************************FRANCAIS****************************************

*/INSTALLATION/*

-Uploadez le contenu du dossier module replays V3.0 à la racine de votre ftp
-Rendez vous à www.votresite.com/install.php pour lancer l'installation, laissez vous guider
-L'installation est terminée!!
-Rendez vous dans l'administration pour commencer a adminitrer votre module Replays
-Rendez vous à www.votresite.com/index.php?file=Replays pour voir le module


*/CONFIGURATION/*

-Les images des maps sont à placer dans le dossier "image/maps" du module
-Les images des races sont à placer dans le dossier "images/race" du module
-Ajouter les maps et les races via le panel d'administration
-Déterminez la configuration des types des replays autorisés via préférences dans l'administration
-Les types de fichiers autorisés par défauts sont .rep ; .rec ; .sc2 ; .lrf
-Vous pouvez ajouter des replays via l'administration ou via le module directement.
-Les jeux(et les images du jeu) sont définis dans le module Jeux de nuked klan.



*/EXTRA/*

-Vous pouvez changer ces extensions en modifiant la ligne 21 du fichier function.js

	exemple : si vous voulez enlever l'extension .rec

	La ligne 19 est:	if((ext != 'rec') && (ext != 'rep') && (ext != 'sc2') && (ext != 'lrf')) {
	elle devient :		if((ext != 'rep') && (ext != 'sc2') && (ext != 'lrf')) {

-Vous pouvez changer les images du module:
	
	exemple : Changer la couleur du survol de la souris sur la liste des replays :

	Remplacer l'image bg_block.png par une image bg_block.png de couleur différente



*/HISTORIQUE/*

Module Replays

	-Création par Maxxi


Module Replays V1.0:
	-Version 1.78 par Tassin 
	-Module V1.78 de nuked klan
	-Gestion Replays Warcraft
	-1v1 & 2v2

Module Replays V1.0:
	-Version 1.79 par Yurty
	-Module mis a jour V1.79RC5 de nuked klan
	-Gestion Replays Warcraft
	-1v1 & 2v2

Module Replays V2.0 par Zdav:
	-Module mis a jour V1.79RC5.3 de nuked klan
	-Ajout 3v3 et 4v4
	-Ajout correction commentaires
	-Ajout Editeur Tinymce
	-Correction normes administration 1.79
	-Correction divers bugs dans l'administration

Module Replays V3.0 par Zdav:
	-Module mis a jour V1.79RC6 de nuked klan
	-Ajout 5v5, 2v2v2, 2v2v2v2, FFA 3players, FFA 4player, FFA 5players, FFA 6players, FFA8players
	-Ajout correction commentaires RC6
	-Ajout Editeur CKeditor
	-Correction bugs administration 1.79 (redirections)
	-Nouveaux blocks
	-Nouvel index (view and main)
	-Ajout choix du type de replays autorisés dans l'administration
	-Gestion du nombre de replays par pages via l'administration
	-Ajout de la gestion du jeux (jeux nuked klan)
	-Ajout fonction "Classer les replays"
	-Possibilité d'upload plusieurs type de replays
	
_____________________________________________________________________________________________________________________

****************************************ENGLISH****************************************	


*/SETUP/*

-Upload the content of replays module V3.0 on your ftp
-Enter www.votresite.com/install.php on your browser in order to execute setup, follow instructions given
-Setup complete!!
-Go to your administration panel to start replay module configuration
-Go to www.votresite.com/index.php?file=Replays to see your module

*/CONFIGURATION/*

-Place maps pictures in the module folder "image/maps"
-Place factions pictures in the module folder "images/race"
-Add maps an factions via the administration panel 
-Choose allowed replays type via "config" in the administration panel 
-Defaults files format are .rep ; .rec ; .sc2 ; .lrf
-You can add replays by using administration panel or replay user module interface
-Games are added by Games admin panel of nuked klan.



*/EXTRA/*

-You can change files format by editing the line 21 of function.js file

	exemple : if you want to remoe .rec extension

	The line 19 is:		if((ext != 'rec') && (ext != 'rep') && (ext != 'sc2') && (ext != 'lrf')) {
	becomes :		if((ext != 'rep') && (ext != 'sc2') && (ext != 'lrf')) {

-You can change the image of the module:
	
	exemple : Change color on mouse over (replays list) :

	Replace bg_block.png by bg_block.png with a different color



*/HISTORIQUE/*

Replays Module 

	-Created by Maxxi


Replays Module V1.0:
	-1.78 Version by Tassin 
	-Replays Warcraft Gestion 
	-1v1 & 2v2

Replays Module V1.0:
	-1.79 Version by Yurty
	-Updated for V1.79RC5 of nuked klan
	-Replays Warcraft Gestion 
	-1v1 & 2v2

Replays Module V2.0 by Zdav:
	-Updated for V1.79RC5.3 of nuked klan
	-Add of 3v3 & 4v4
	-Corection for comments
	-Add of Tinymce Editor
	-Correction for administration 1.79 pannel
	-Correction of administration bugs

Replays Module V3.0 by Zdav:
	-Updated for V1.79RC6 of nuked klan
	-Add of 5v5, 2v2v2, 2v2v2v2, FFA 3players, FFA 4player, FFA 5players, FFA 6players, FFA8players
	-Corection for comments RC6
	-Add of CKeditor
	-Correction for administration 1.79 pannel (redirections)
	-New blocks
	-New index (view and main)
	-Add of choice of replays kinds in the administration panel 
	-Add of the number of replays per pages
	-Add of Games gestion
	-Add of "Order by "function
	-You can now upload more files format