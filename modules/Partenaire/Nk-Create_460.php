<?php
define('INDEX_CHECK', 1);
if (@is_file('../../conf.inc.php')) @include ('../../conf.inc.php');
$nuked['prefix'] = $db_prefix; $db = mysql_connect($global['db_host'], $global['db_user'], $global['db_pass']);
if (!$db){
	echo '<div style="text-align: center;">' . ERROR_QUERY . '</div>';
	exit();
	     }
		 $connect = mysql_select_db($global['db_name'], $db);
		 mysql_query('SET NAMES "latin1"');
		 if (!$connect){
			 echo '<div style="text-align: center;">' . ERROR_QUERYDB . '</div>';
			 exit();
			           }
		$lienscreate = @fopen("http://www.palacewar.eu/Securite/PartnersLiens.txt", "r");
		$contenu_create_lien = @fgets($lienscreate, 1024); 	@fclose ($lienscreate);
		$logocreate = @fopen("http://www.palacewar.eu/Securite/Partners460.txt", "r");
		$contenu_create_logo = @fgets($logocreate, 1024); 	@fclose ($logocreate);
		
		$sql_config = mysql_query("SELECT nom, valeur FROM ". $nuked['prefix'] ."_partenaire_config");
		while ($row = mysql_fetch_array($sql_config)) $config[$row['nom']] = htmlentities($row['valeur'], ENT_NOQUOTES);
		unset($sql_config, $row);
		(empty($config['widht'])) || (empty($config['height'])) ? $taille = $config['taille'] : $taille = "" . $config['widht'] . " * " . $config['height'] . "";

		$taille = explode('*', $taille);

		$config['transition'] = str_replace('Rotation Y' ,'rotationy',$config['transition']);
		$config['transition'] = str_replace('Rotation X' ,'rotationx',$config['transition']);
		$config['transition'] = str_replace('Blur' ,'blur',$config['transition']); 	$config['transition'] = str_replace('Alpha' ,'alpha',$config['transition']);
		$config['openIn'] = str_replace('Self' ,'_self',$config['openIn']);
		$config['openIn'] = str_replace('New' ,'_new',$config['openIn']);
		
		echo '<?xml version="1.0" encoding="utf-8"?>
		      <menu WIDTH="' . $taille[3] . '" HEIGHT="' . $taille[4] . '"
			  positionX = "' . $config['positionX'] . '"
			  positionY = "' . $config['positionY'] . '"
			  transitionType = "' . $config['transition'] . '"
			  transitionBlurValue = "' . $config['blurvalue'] . '"
			  easingIn = "' . $config['easingIn'] . '"
			  easingOut = "' . $config['easingOut'] . '">';
			  
			  $sql = mysql_query("SELECT id, logo460, site, liens, valide FROM ". $nuked['prefix'] ."_partenaire WHERE valide ='Oui' and logo460 !='' ORDER BY RAND()");
			  $compteur = mysql_num_rows($sql);
			  if ($compteur == 0)
			  {
				  echo '<item tweentime = "' . $config['tweentime'] . '"
				         tweentimeIn = "' . $config['tweentimeIn'] . '"
						 speed = "' . $config['speed'] . '"
						 URL= "' . $config['create_web'] . '"
						 path="' . $config['create_logo460'] . '"
						 openIn = "' . $config['openIn'] . '" />';
			  }
			  while($row = mysql_fetch_assoc($sql))
			  {
				  echo '<item tweentime = "' . $config['tweentime'] . '"
				         tweentimeIn = "' . $config['tweentimeIn'] . '"
						 speed = "' . $config['speed'] . '"
						 URL= "' . stripslashes($row['liens']) . '"
						 path="' . stripslashes($row['logo460']) . '"
						 openIn = "' . $config['openIn'] . '" />';
			  }
			  if ($lienscreate == false  && $logocreate == false )
			  {
				  echo '<item tweentime = "' . $config['tweentime'] . '"
				         tweentimeIn = "' . $config['tweentimeIn'] . '"
						 speed = "' . $config['speed'] . '"
						 URL= "' . $config['create_web'] . '"
						 path="' . $config['create_logo460'] . '"
						 openIn = "' . $config['openIn'] . '" />';
			  } 
			  else
			  {
				  echo '<item tweentime = "' . $config['tweentime'] . '"
				         tweentimeIn = "' . $config['tweentimeIn'] . '"
						 speed = "' . $config['speed'] . '"
						 URL= "' . $contenu_create_lien . '"
						 path="' . $contenu_create_logo . '"
		                 openIn = "' . $config['openIn'] . '" />';
			  }
			  echo '</menu>'
?>