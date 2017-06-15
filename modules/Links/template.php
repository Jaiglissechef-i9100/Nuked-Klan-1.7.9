<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// New look by kotshiro http://kotshiro.free.fr Octobre 2013                //
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//

defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $bgcolor1, $bgcolor2, $bgcolor3;
// Definition des 3 couleurs, par defaut ceux de nuked-klan, vous pouvez les remplacer par un code couleur.
// Exemple : $color1 = "#FFFFFF";

$color1 = $bgcolor1;
$color2 = $bgcolor2;
$color3 = $bgcolor3;

// Largeur maximal du screen
$avatar_width = 150;
//style pour le bloc en position central
?>
<style type="text/css">
figure {
  display: block;
  position: relative;
  float: left;
  /*overflow: hidden;
  margin: 0 10px 10px 0;*/
}
figcaption {
  position: absolute;
  background: black;
  background: rgba(0,0,0,0.75);
  color: white;
  padding: 10px 20px;
  opacity: 0;
  -webkit-transition: all 0.6s ease;
  -moz-transition:    all 0.6s ease;
  -o-transition:      all 0.6s ease;
}
figure:hover figcaption {
  opacity: 1;
}
figure:before {
  content: "?";
  position: absolute;
  font-weight: 800;
  background: black;
  background: rgba(255,255,255,0.75);
  text-shadow: 0 0 5px white;
  color: black;
  width: 24px;
  height: 24px;
  -webkit-border-radius: 12px;
  -moz-border-radius:    12px;
  border-radius:         12px;
  text-align: center;
  font-size: 14px;
  line-height: 24px;
  -moz-transition: all 0.6s ease;
  opacity: 0.75;
}
figure:hover:before {
  opacity: 0;
}

.cap-left:before {  bottom: 10px; left: 10px; }
.cap-left figcaption { bottom: 0; left: -30%; }
.cap-left:hover figcaption { left: 0; }

.cap-right:before { bottom: 10px; right: 10px; }
.cap-right figcaption { bottom: 0; right: -30%; }
.cap-right:hover figcaption { right: 0; }

.cap-top:before { top: 10px; left: 10px; }
.cap-top figcaption { left: 0; top: -30%; }
.cap-top:hover figcaption { top: 0; }

.cap-bot:before { bottom: 10px; left: 10px; }
.cap-bot figcaption { left: 0; bottom: -30%;}
.cap-bot:hover figcaption { bottom: 0; }

.boutonvisites {
  background: <?php echo $bgcolor3; ?>;
  background-image: -webkit-linear-gradient(top, <?php echo $bgcolor3; ?>, <?php echo $bgcolor2; ?>);
  background-image: -moz-linear-gradient(top, <?php echo $bgcolor3; ?>, <?php echo $bgcolor2; ?>);
  background-image: -ms-linear-gradient(top, <?php echo $bgcolor3; ?>, <?php echo $bgcolor2; ?>);
  background-image: -o-linear-gradient(top, <?php echo $bgcolor3; ?>, <?php echo $bgcolor2; ?>);
  background-image: linear-gradient(to bottom, <?php echo $bgcolor3; ?>, <?php echo $bgcolor2; ?>);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  text-shadow: 3px 3px 3px <?php echo $bgcolor1; ?>;
  -webkit-box-shadow: 3px 3px 3px <?php echo $bgcolor1; ?>;
  -moz-box-shadow: 3px 3px 3px <?php echo $bgcolor1; ?>;
  box-shadow: 3px 3px 3px <?php echo $bgcolor1; ?>;
  font-family: Georgia;
  /*color: #ffffff;*/
  /*font-size: 20px;*/
  padding: 5px 10px 5px 10px;
    display: block;
  position: relative;
  float: left;
  border: solid #2c373d 2px;
  text-decoration: none;
}

.boutonvisites:hover {
  background: <?php echo $bgcolor2; ?>;
  background-image: -webkit-linear-gradient(top, <?php echo $bgcolor2; ?>, <?php echo $bgcolor3; ?>);
  background-image: -moz-linear-gradient(top, <?php echo $bgcolor2; ?>, <?php echo $bgcolor3; ?>);
  background-image: -ms-linear-gradient(top, <?php echo $bgcolor2; ?>, <?php echo $bgcolor3; ?>);
  background-image: -o-linear-gradient(top, <?php echo $bgcolor2; ?>, <?php echo $bgcolor3; ?>);
  background-image: linear-gradient(to bottom, <?php echo $bgcolor2; ?>, <?php echo $bgcolor3; ?>);
  text-decoration: none;
}

/*style pour le bloc en position droite ou gauche*/


/* Image Box Style */
#mainwrapper .box {
	border: 3px solid <?php echo $bgcolor3; ?>;
	cursor: pointer;
	height: 182px;
	/*float: left;*/
	margin: 5px;
	position: relative;
	overflow: hidden;
	width: 200px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    -webkit-box-shadow: 0px 2px 15px <?php echo $bgcolor3; ?>;
    -moz-box-shadow:    0px 2px 15px <?php echo $bgcolor3; ?>;
    box-shadow:         0px 2px 15px <?php echo $bgcolor3; ?>;
}
#mainwrapper .box img {
	position: absolute;
	left: 0;
		-webkit-transition: all 300ms ease-out;
		-moz-transition: all 300ms ease-out;
		-o-transition: all 300ms ease-out;
		-ms-transition: all 300ms ease-out;	
	transition: all 300ms ease-out;
}

/* Caption Common Style */
#mainwrapper .box .caption {
	background-color: rgba(0,0,0,0.5);
	position: absolute;
	/*color: #fff;*/
	color: <?php echo $bgcolor2; ?>;
	z-index: 100;
		-webkit-transition: all 300ms ease-out;
		-moz-transition: all 300ms ease-out;
		-o-transition: all 300ms ease-out;
		-ms-transition: all 300ms ease-out;	
		transition: all 300ms ease-out;
	left: 0;
}


/** Caption 1: Simple **/
#mainwrapper .box .simple-caption {
	height: 30px;
	width: 200px;
	display: block;
	bottom: -30px;
	line-height: 25pt;
	text-align: center;
}

/** Caption 2: Full Width & Height **/
#mainwrapper .box .full-caption {
	width: 170px;
	height: 170px;	
	top: -200px;
	/*text-align: left;*/
	padding: 15px;
}

/** Caption 3: Fade **/
#mainwrapper .box .fade-caption, #mainwrapper .box .scale-caption  {
	opacity: 0;
	width: 170px;
	height: 170px;
	/*text-align: left;*/
	padding: 15px;
}

/** Caption 4: Slide **/
#mainwrapper .box .slide-caption {
	width: 170px;
	height: 170px;	
	/*text-align: left;*/
	padding: 15px;
	left: 200px;
}

/** Caption 5: Rotate **/
#mainwrapper #box-5.box .rotate-caption {
	width: 170px;
	height: 170px;	
	/*text-align: left;*/
	padding: 15px;
	top: 200px;
	-moz-transform: rotate(-180deg);
	-o-transform: rotate(-180deg);
	-webkit-transform: rotate(-180deg);
	transform: rotate(-180deg);
}

#mainwrapper .box .rotate {
	width: 200px;
	height: 400px;
	-webkit-transition: all 300ms ease-out;
	-moz-transition: all 300ms ease-out;
	-o-transition: all 300ms ease-out;
	-ms-transition: all 300ms ease-out;	
	transition: all 300ms ease-out;
}

/** Caption 6: Scale **/
#mainwrapper .box .scale-caption h3, #mainwrapper .box .scale-caption p {
	position: relative;
	left: -200px;
	width: 170px;
	-webkit-transition: all 300ms ease-out;
	-moz-transition: all 300ms ease-out;
	-o-transition: all 300ms ease-out;
	-ms-transition: all 300ms ease-out;	
	transition: all 300ms ease-out;
}

#mainwrapper .box .scale-caption h3 {
	-webkit-transition-delay: 300ms;
	-moz-transition-delay: 300ms;
	-o-transition-delay: 300ms;
	-ms-transition-delay: 300ms;	
	transition-delay: 300ms;
}

#mainwrapper .box .scale-caption p {
	-webkit-transition-delay: 500ms;
	-moz-transition-delay: 500ms;
	-o-transition-delay: 500ms;
	-ms-transition-delay: 500ms;	
	transition-delay: 500ms;
}

/** Simple Caption :hover Behaviour **/
#mainwrapper .box:hover .simple-caption {
	-moz-transform: translateY(-100%);
	-o-transform: translateY(-100%);
	-webkit-transform: translateY(-100%);
	opacity: 1;
	transform: translateY(-100%);
}

/** Full Caption :hover Behaviour **/
#mainwrapper .box:hover .full-caption {
	-moz-transform: translateY(100%);
	-o-transform: translateY(100%);
	-webkit-transform: translateY(100%);
	opacity: 1;
	transform: translateY(100%);
}

/** Fade Caption :hover Behaviour **/
#mainwrapper .box:hover .fade-caption, #mainwrapper .box:hover .scale-caption  {
	opacity: 1;
}

/** Slide Caption :hover Behaviour **/
#mainwrapper .box:hover .slide-caption {
	background-color: rgba(0,0,0,1) !important;
	-moz-transform: translateX(-100%);
	-o-transform: translateX(-100%);
	-webkit-transform: translateX(-100%);
	opacity: 1;
	transform: translateX(-100%);
}
#mainwrapper .box:hover img#image-4 {
	-moz-transform: translateX(-100%);
	-o-transform: translateX(-100%);
	-webkit-transform: translateX(-100%);
	transform: translateX(-100%);
	opacity: 1;
}

/** Rotate Caption :hover Behaviour **/
#mainwrapper .box:hover .rotate {
	background-color: rgba(0,0,0,1) !important;
	-moz-transform: rotate(-180deg);
	-o-transform: rotate(-180deg);
	-webkit-transform: rotate(-180deg);
	transform: rotate(-180deg);
}

/** Scale Caption :hover Behaviour **/
#mainwrapper .box:hover #image-6 {
	-moz-transform: scale(2);
	-o-transform: scale(2);
	-webkit-transform: scale(2);
	transform: scale(2);
}

#mainwrapper .box:hover .scale-caption h3, #mainwrapper .box:hover .scale-caption p {
	-moz-transform: translateX(200px);
	-o-transform: translateX(200px);
	-webkit-transform: translateX(200px);
	transform: translateX(200px);
}

</style>