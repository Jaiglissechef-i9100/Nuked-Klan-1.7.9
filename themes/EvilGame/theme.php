<?php

// *****************************************************************//
// ** Theme EvilGame NukedKlan version 1.0           									   
// **													          
// ** Template provided by Kit-gaming.org    
// ** Powered by NukedKlan           	    	              
// **            				           							    
// ** http://www.kit-gaming.org  	     
// ** http://www.nuked-klan.eu/                   						 
// *****************************************************************//

defined("INDEX_CHECK") or die ("<div style=\"text-align: center;\">Accès interdit</div>");


function top()
{
global $nuked, $op, $file, $user, $bgcolor2, $page;
include("themes/EvilGame/kg_adm/cfg/blocks.txt");
include("themes/EvilGame/kg_adm/cfg/pref.txt");
if($lang1 === '1')  $var_l = 'fr';  else $var_l = 'en';


	 echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n"
     . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\"><head>\n"
     . "<meta name=\"keywords\" content=\"" . $nuked['keyword'] . "\" />\n"
     . "<meta name=\"Description\" content=\"" . $nuked['description'] . "\" />\n"
     . "<title>" . $nuked['name'] . " - " . $nuked['slogan'] . "</title>\n";

?>
<meta name="description" content="<?php echo  stripslashes($desc); ?>" />
<link rel="stylesheet" media="screen" type="text/css" title="templates_kg" href="themes/EvilGame/css/index.css" />
<link rel="stylesheet" media="screen" type="text/css" title="templates_kg" href="themes/EvilGame/css/style_color.css" />
<link rel="stylesheet" media="screen" type="text/css" title="templates_kg" href="themes/EvilGame/css/glide.css" />
<!--[if lt IE 8]>
<link rel="stylesheet" media="screen" type="text/css" title="templates_kg" href="themes/EvilGame/css/ie.css" />
<![endif]-->

<script src="themes/EvilGame/modules/video/swfobject.js" type="text/javascript"></script>
<script src="themes/EvilGame/modules/js/jquery.js" type="text/javascript"></script>
<script src="themes/EvilGame/modules/js/featuredcontentglider.js"type="text/javascript"></script>
<script type="text/javascript" src="themes/EvilGame/modules/js/jquery-1.2.3.min.js"></script>
<script src="themes/EvilGame/js/bbcode.js" language="jscript" type="text/javascript"></script>
<script src="themes/EvilGame/modules/js/contentslider.js" type="text/javascript"></script>
</head>
<body>

<div id="main">

	<!-- HEADER -->
	<div id="header">
		<div class="fire"></div>
		<div id="community">
			<ul id="social">
			<?php 	if($tw != '') { ?><li><a href="<?php echo stripslashes($tw); ?>" id="twitter">Twitter</a></li><?php } 
			if($fb != '') { ?><li><a href="<?php echo stripslashes($fb); ?>" id="facebook">Facebook</a></li><?php } 
			if($steam != '') { ?><li><a href="<?php echo stripslashes($steam); ?>" id="steam">Twitter</a></li><?php } ?>
			</ul>
		</div><img  src="themes/EvilGame/images/header.png" alt="header" />
	</div>	

	<!-- LOGIN AREA -->	
	<div id="login">
		<?php include("themes/EvilGame/blocks/kg_login.php"); ?>
		<?php include("themes/EvilGame/blocks/kg_quicksearch.php"); ?>
	</div>
	
	<!-- MENU -->
	<div id="menu">
		<div class="fire"></div><?php include("themes/EvilGame/blocks/kg_menu.php"); ?>
	</div>

	
	<!-- COVERAGE -->
	<div id="coverage"><div class="fire"></div>
		<div  id="p-select2">
			<div class="cov_next"><a href="#" onfocus="this.blur();" class="next"><img class="next_cov" src="themes/EvilGame/images/next.png" width="49" height="39" alt="next" /></a></div>
			<div class="cov_preview" ><a href="#" onfocus="this.blur();" class="prev"><img  class="prev_cov" src="themes/EvilGame/images/prev.png" width="49" height="39" alt="prev" /></a></div>
			<div id="canadaprovinces2" class="glidecontentwrapper2">
			<?php include_once("kg_adm/cfg/slide.txt"); 
			echo stripslashes($cov1.$cov2.$cov3.$cov4.$cov5); 
			?> </div>
		</div>
		<script type="text/javascript">
		featuredcontentglider.init({gliderid: "canadaprovinces2",contentclass: "glidecontent2", togglerid: "p-select2", remotecontent: "", selected: 0, persiststate: true, speed: 400, direction: "rightleft", autorotate: true, autorotateconfig: [20000, 10] })
		</script>	
	</div>
	
	<!-- HEADLINES -->
	<div id="headlines">
		<div class="titlex"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/headlines.png" alt="headlines" /></div>
		<div  id="p-select3">
		<div class="up"><a href="#" onfocus="this.blur();" class="next"><img  src="themes/EvilGame/images/bank.gif" width="85" height="17" alt="next" /></a></div>
		<div class="body">
			<div id="canadaprovinces3" class="glidecontentwrapper3">
				<?php include("themes/EvilGame/blocks/kg_headlines.php"); ?>
			</div>
		</div>
		<div class="down"><a href="#" onfocus="this.blur();" class="prev"><img   src="themes/EvilGame/images/bank.gif" width="85" height="17" alt="prev" /></a></div>
		</div>
		<script type="text/javascript">
		featuredcontentglider.init({gliderid: "canadaprovinces3",contentclass: "glidecontent3",	togglerid: "p-select3",	remotecontent: "", 	selected: 0, persiststate: true, 	speed:800, 	direction: "downup", autorotate: true, 	autorotateconfig: [20000, 10] 	})
		</script>
	</div>	
	
	
<?php 

$file = mysql_real_escape_string(addslashes(htmlentities($_GET['file'])));
if(($file != '')) $type_affichage = '2';
	
	//Affichage pendant la navigation 
	 if($type_affichage === '2') {
		 //Navigation en plein écran sans blocks
		 if(($activeBlock === '0') or ($file === 'Forum')) 		
		  include_once('./themes/EvilGame/blocks/navigation_full.php');
		  
		  //Navigation avec les blocks à droite
		 else
		  include_once('./themes/EvilGame/blocks/navigation_nk.php');
		 
	}
	 else
	 //Affichage page acceuil
	  include_once('./themes/EvilGame/blocks/navigation_block.php');
}


	function footer()
{
    global $nuked, $theme;
    include("themes/EvilGame/kg_adm/cfg/pref.txt");
	include("themes/EvilGame/kg_adm/cfg/blocks.txt");


$file = mysql_real_escape_string(addslashes(htmlentities($_GET['file'])));
if(($file != '')) $type_affichage = '2';
 if($type_affichage === '2') {
		 if(($activeBlock === '0') or ($file === 'Forum')) 
		 echo '</div></div></div>';
		
		 else
		  include_once('./themes/EvilGame/blocks/navigation_nk_end.php');
		
	}
	
?>
	<!-- FOOTER -->
	<div id="copyright">		
	<?php include('./themes/EvilGame/blocks/stage.php'); ?>
	<div id="footer"></div>		
	<div id="index_r11_c1"></div></div>


<?php 
} 


/* OPEN TABLE */
function opentable() {
$file = mysql_real_escape_string(addslashes(htmlentities($_GET['file'])));
 if(($file == '')) 
	echo "<div id='opentableOff'>";
else
	echo "<div id='opentable'>";
} 
function closetable() {
	echo "</div>"; 
}


/* NEWS */
$file = mysql_real_escape_string(addslashes(htmlentities($_GET['file'])));
 if(($file != '')) {
function news($data)
{ 
	include("themes/EvilGame/kg_adm/cfg/pref.txt");
	if($lang1 === '1')  $var_l = 'fr';  else $var_l = 'en';

		$posted  = _NEWSPOSTBY . "&nbsp;&nbsp;" . _THE . "&nbsp;". $data['date']. "&nbsp;" . _AT . "&nbsp;" . $data['heure'];
		$comment = $data['nb_comment'];
		$suite   = "<a  href=\"index.php?file=News&amp;op=index_comment&amp;news_id=".$data['id'] . "\">" ;
		$date_newss = $data['date'];
		$idnew1 = $data['id'];
	?>
	<br/><br/><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="title"><?php echo $data['titre']; ?></td>
  </tr>
    </tr>
  <tr><td style="background-color:#0d0d0d; padding-top:5px; padding-left: 15px;height:3px;" >Ecrit par <a  class="last" href="index.php?file=Members&amp;op=detail&amp;autor=<?php echo urlencode($data['auteur']);  ?>"><b><?php echo $data['auteur']  ?></b></a> le <?php echo $date_newss; ?> &agrave; <?php echo $data['heure']; ?><p style="float:right;"> Commentaires (<?php echo  $comment; ?>)</p></div></td>
  </tr>
  <tr><td></td></tr>
  <tr bgcolor="#161616">
    <td bgcolor="$bg1" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" align="justify" bgcolor="#161616">
		<div class="bg_pic_news"><?php echo $data['image']; ?></div>
		<?php echo stripslashes($data['texte']); ?>		
		</td>
      </tr>
    </table>
    </td>


</table>
<br /><br />
	<?php
	}
}
else { function news() {} }



/* BLOCK GAUCHE */
function block_gauche($block)
{} 

/* BLOCK DROITE */
function block_droite($block)
{
echo 	'<div class="titleBlockNk"><img src="themes/EvilGame/images/arrow.png" alt="" /><span class="titleNk"> '.htmlentities($block['titre']).'</span></div>
		<div class="content">
		'.$block['content'].'
		</div>';

} 


/* BLOCK  CENTRE */
	function block_centre($block)
{
	echo '<div class="nkCentral" style="padding-top:10px;">
	<img src="themes/EvilGame/images/arrow.png" alt="" /><span class="titleNk"> '.htmlentities($block['titre']).'</span>
	<br/>'. $block['content'] .'</div>';
} 

/* BLOCK BAS */
	function block_bas($block)
{
	echo '<div class="nkCentral" style="padding-top:10px;">
	<img src="themes/EvilGame/images/arrow.png" alt="" /><span class="titleNk"> '.htmlentities($block['titre']).'</span>
	<br/>'. $block['content'] .'</div>';
} 
?>
