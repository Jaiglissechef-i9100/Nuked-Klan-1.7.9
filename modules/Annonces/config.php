<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (eregi("config.php", $_SERVER['PHP_SELF']))
{
    die ("You cannot open this page directly");
} 

// Tables Mysql
define("ANNONCES_TABLE", $nuked['prefix'] . "_annonces");
define("ANNONCES_CAT_TABLE", $nuked['prefix'] . "_annonces_cat");

// Image miniature par defaut des catégories
$img_none = "modules/Annonces/images/no_foto.gif";

// poids max. des images uploadées
$img_size = 150000;


?>