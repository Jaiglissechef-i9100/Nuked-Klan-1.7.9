<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// Module Créer par C.M.S - Nuked-Klan                                      //
// WWW.CMS.NILOO.FR                                                         //
// Avec les Cartes météo de MétéoConsult.fr (sources libres)                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
} 

opentable();


    function Pays()
{
	       echo'<p style="text-align: center;"><img src="modules/Meteo/images/logo-module.png" alt="Retour" /></a><br>
	   <a href="index.php?file=Meteo&pays=France"><img src="modules/Meteo/images/France.png" alt="Fr" /></a>
       <a href="index.php?file=Meteo&pays=England"><img src="modules/Meteo/images/England.png" alt="En" /></a><br>
       <a href="index.php?file=Meteo&pays=Espagne"><img src="modules/Meteo/images/Espagne.png" alt="Es" /></a>
       <a href="index.php?file=Meteo&pays=Allemagne"><img src="modules/Meteo/images/Allemagne.png" alt="De" /></a><br>
       <a href="index.php?file=Meteo&pays=Italie"><img src="modules/Meteo/images/Italie.png" alt="It" /></a>
       <a href="index.php?file=Meteo&pays=Maghreb"><img src="modules/Meteo/images/Maghreb.png" alt="Ma" /></a><br><br>
	   <img src="modules/Meteo/images/barre.png"/><br>
       <a href="Http://cms.niloo.fr/"><img src="modules/Meteo/images/copyright.png" alt="C.M.S" /></a><br></p>';
    }

    function France()
    {
       echo'<p style="text-align: center;"><a href="index.php?file=Meteo"><img src="modules/Meteo/images/logo-module.png" alt="Retour" /></a><br>
	   <img src="modules/Meteo/images/aujourd-hui.png"/><br>
	   <img src="http://www.meteoconsult.fr/image/meteodirect/md_france24h.gif"/><br>
	   <img src="modules/Meteo/images/demain.png"/><br>
	   <img src="http://www.meteoconsult.fr/image/meteodirect/md_france48h.gif"/></p>';
    }
	   function England()
    {
       echo'<p style="text-align: center;"><a href="index.php?file=Meteo"><img src="modules/Meteo/images/logo-module.png" alt="Retour" /></a><br>
		   <img src="modules/Meteo/images/aujourd-hui.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_grande_bretagne24h.gif"/><br>
		   <img src="modules/Meteo/images/demain.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_grande_bretagne48h.gif"/></p>';
    }

	function Espagne()
	{
       echo'<p style="text-align: center;"><a href="index.php?file=Meteo"><img src="modules/Meteo/images/logo-module.png" alt="Retour" /></a><br>
		   <img src="modules/Meteo/images/aujourd-hui.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_espagne24h.gif"/><br>
		   <img src="modules/Meteo/images/demain.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_espagne48h.gif"/></p>';
    }
	
		function Allemagne()
	{
       echo'<p style="text-align: center;"><a href="index.php?file=Meteo"><img src="modules/Meteo/images/logo-module.png" alt="Retour" /></a><br>
		   <img src="modules/Meteo/images/aujourd-hui.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_allemagne24h.gif"/><br>
		   <img src="modules/Meteo/images/demain.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_allemagne48h.gif"/></p>';
    }
	
	function Italie()
	{
       echo'<p style="text-align: center;"><a href="index.php?file=Meteo"><img src="modules/Meteo/images/logo-module.png" alt="Retour" /></a><br>
		   <img src="modules/Meteo/images/aujourd-hui.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_italie24h.gif"/><br>
		   <img src="modules/Meteo/images/demain.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_italie48h.gif"/></p>';
    }

		function Maghreb()
	{
       echo'<p style="text-align: center;"><a href="index.php?file=Meteo"><img src="modules/Meteo/images/logo-module.png" alt="Retour" /></a><br>
		   <img src="modules/Meteo/images/aujourd-hui.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_maghreb24h.gif"/><br>
		   <img src="modules/Meteo/images/demain.png"/><br>
		   <img src="http://www.meteoconsult.fr/image/meteodirect/md_maghreb48h.gif"/></p>';
    }
	
    // on fait appelle à ses pages "function" avec ce code
	switch($_REQUEST['pays'])
    {
        case 'France':
        France();
        break;
		
        case 'England':
        England();
        break;
		
		case 'Espagne':
        Espagne();
        break;
		
	    case 'Allemagne':
        Allemagne();
        break;
        
		case 'Italie':
        Italie();
        break;
		
		case 'Maghreb':
        Maghreb();
        break;
		
        // on indique au switch la page par défaut
        default:
        Pays();
        break;
    }
	closetable();
    ?>