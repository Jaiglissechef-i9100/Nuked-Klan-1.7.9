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

// Titre personalisé de la Faqs
$faqs_title = "";

// Description de la Faqs
$faqs_desc = "";

// Classement des Questions (id | questions)
$faqs_orderby = "id";

?>