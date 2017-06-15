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


global $bgcolor1, $bgcolor2, $bgcolor3;
// Definition des 3 couleurs, par defaut ceux de nuked-klan, vous pouvez les remplacer par un code couleur.
// Exemple : $color1 = "#FFFFFF";

$color1 = $bgcolor1;
$color2 = $bgcolor2;
$color3 = $bgcolor3;

?>


<style type="text/css">

.noti_bubble {

	    position: absolute;
        width:12px;
        height:12px;
        text-align: center;
        margin-top:-2px;
        margin-left:-5px;
        background-color:red;
        color:white;
        font-weight:bold;
        font-size:0.55em;
        border-radius:50px;
        box-shadow:1px 1px 1px gray;
}

</style>