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

#guestbookdeb{

width:75%;
margin: auto;

}
#guestbookdeb ul.guestbooklist {

list-style:none;

}

#guestbookdeb ul.guestbooklist ul {

list-style-type:none;

}

#guestbookdeb ul.guestbooklist li {

	border-top-left-radius:9px;
	border-top-right-radius:9px;
	border:1px solid <?php echo $color2; ?>;
	padding:10px 15px;
	background:<?php echo $color1; ?>;

}

#guestbookdeb ul.guestbooklist li .guestbook-meta {

margin-top:-36px;

}

#guestbookdeb ul.guestbooklist li .guestbook-meta span {

	font-size:11px;
	padding-top:7px;
	line-height:210%;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-style:italic;

}

#guestbookdeb ul.guestbooklist li .guestbook-meta span strong {

	font-size:14px;

}



#guestbookdeb ul.guestbooklist li .guestbookRight .text {

	padding-bottom:15px;

}

#guestbookdeb ul.guestbooklist li .Gavatar {

	border:1px solid #FFF;
	padding:5px;
	background:<?php echo $color3; ?>;
	float:left;
	margin-right:5px;

}

.view {
    width: 180px;
    height: 200px;
    /*margin: 10px;*/
    /*border: 10px solid #fff;*/
    overflow: hidden;
    position: relative;
    text-align: center;
    box-shadow: 1px 1px 2px #e6e6e6;
    cursor: default;
    background: <?php echo $color3; ?>;
    -webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	padding: 3px;
	position: relative;
	-webkit-box-shadow: inset 0px 1px 2px <?php echo $color1; ?>;
	-moz-box-shadow: inset 0px 1px 2px <?php echo $color2; ?>;
	box-shadow: inset 0px 1px 2px <?php echo $color3; ?>;
}
.view .mask, .view .content {
    width: 300px;
    height: 200px;
    position: absolute;
    overflow: hidden;
    top: 0;
    left: 0;
}
.view img {
    display: block;
      width: 179px;
    height: 190px;
    text-align: center;
}
.view h2 {
    text-transform: uppercase;
    color: #fff;
    text-align: center;
    position: relative;
    font-size: 11px;
    padding: 5px;
    background: rgba(0, 0, 0, 0.8);
    margin: 20px 0 0 0
}
.view p {
    font-family: Georgia, serif;
    font-style: italic;
    font-size: 9px;
    position: relative;
    color: #fff;
    padding: 10px 20px 20px;
    text-align: center
}
.view a.info {
    display: inline-block;
    text-decoration: none;
    padding: 7px 14px;
    background: #000;
    color: #fff;
    text-transform: uppercase;
    box-shadow: 0 0 1px #000
}
.view a.info:hover {
    box-shadow: 0 0 5px #000
}

.view-tenth img {
   -webkit-transform: scaleY(1);
   -moz-transform: scaleY(1);
   -o-transform: scaleY(1);
   -ms-transform: scaleY(1);
   transform: scaleY(1);
   -webkit-transition: all 0.7s ease-in-out;
   -moz-transition: all 0.7s ease-in-out;
   -o-transition: all 0.7s ease-in-out;
   -ms-transition: all 0.7s ease-in-out;
   transition: all 0.7s ease-in-out;
}
.view-tenth .mask {
   width: auto;
   height: 200px;
   background-color: <?php echo $color2; ?>;
   -webkit-transition: all 0.5s linear;
   -moz-transition: all 0.5s linear;
   -o-transition: all 0.5s linear;
   -ms-transition: all 0.5s linear;
   transition: all 0.5s linear;
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";
   filter: alpha(opacity=0);
   opacity: 0;
}
.view-tenth h2 {
   /*border-bottom: 1px solid rgba(0, 0, 0, 0.3);*/
   background: transparent;
   margin: 20px 40px 0px 40px;
   -webkit-transform: scale(0);
   -moz-transform: scale(0);
   -o-transform: scale(0);
   -ms-transform: scale(0);
   transform: scale(0);
   color: #333;
   -webkit-transition: all 0.5s linear;
   -moz-transition: all 0.5s linear;
   -o-transition: all 0.5s linear;
   -ms-transition: all 0.5s linear;
   transition: all 0.5s linear;
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";
   filter: alpha(opacity=0);
   opacity: 0;
}
.view-tenth p {
   color: #333;
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";
   filter: alpha(opacity=0);
   opacity: 0;
   -webkit-transform: scale(0);
   -moz-transform: scale(0);
   -o-transform: scale(0);
   -ms-transform: scale(0);
   transform: scale(0);
   -webkit-transition: all 0.5s linear;
   -moz-transition: all 0.5s linear;
   -o-transition: all 0.5s linear;
   -ms-transition: all 0.5s linear;
   transition: all 0.5s linear;
}
.view-tenth a.info {
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";
   filter: alpha(opacity=0);
   opacity: 0;
   -webkit-transform: scale(0);
   -moz-transform: scale(0);
   -o-transform: scale(0);
   -ms-transform: scale(0);
   transform: scale(0);
   -webkit-transition: all 0.5s linear;
   -moz-transition: all 0.5s linear;
   -o-transition: all 0.5s linear;
   -ms-transition: all 0.5s linear;
   transition: all 0.5s linear;
}
.view-tenth:hover img {
   -webkit-transform: scale(10);
   -moz-transform: scale(10);
   -o-transform: scale(10);
   -ms-transform: scale(10);
   transform: scale(10);
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=0)";
   filter: alpha(opacity=0);
   opacity: 0;
}
.view-tenth:hover .mask {
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";
   filter: alpha(opacity=100);
   opacity: 1;
}
.view-tenth:hover h2,.view-tenth:hover p,.view-tenth:hover a.info {
   -webkit-transform: scale(1);
   -moz-transform: scale(1);
   -o-transform: scale(1);
   -ms-transform: scale(1);
   transform: scale(1);
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";
   filter: alpha(opacity=100);
   opacity: 1;
}
/* fin */				
</style>