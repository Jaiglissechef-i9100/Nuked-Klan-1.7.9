<?php
    if ($visiteur == 9)
    {
if(isset($_GET['ordre']))
$ordre = htmlentities(addslashes($_GET['ordre']));
else
$odre = "";
if($ordre === 'saved')
{
		

		     $ressource_fichier = fopen('kg_adm/cfg/video.txt', 'w');		
		
			
		     if($ressource_fichier AND is_writable('kg_adm/cfg/video.txt')) 
		     {
			
			//Enumeration des video
				$jw_play       = htmlentities($_POST['play']);
				$jw_code       = addslashes($_POST['jw_code']);
				$daily_code    = addslashes($_POST['daily_code']);
	
		    //Var
			 $donnee ='
			 <?php 
			 $play  = "'.$jw_play.'";
			 $jw_code  = "'.$jw_code.'";
			 $daily_code  = "'.$daily_code.'";
			 ?>';
			 
		     fputs($ressource_fichier, $donnee);
		     fclose($ressource_fichier); ?>
				  <meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=ok" />
			<?php
			 }
			 else
			 {
			 echo '<meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=err03" />';
			 }
			 }
else
{

		$ressource_fichier = fopen('kg_adm/cfg/video.txt', 'a+');
		if(isset($_GET['mess']))
		$mess = htmlentities($_GET['mess']);
		else
		$mess = "";
		include('./kg_adm/cfg/video.txt');
		
		function verif($block, $nom)
{
if($block === '0' or $block  === '1')
{
if($block === '1')  $nom = block_ac.' : '.block_show;
elseif($block === '0')  $nom = block_ac.' : '.block_hide;

echo $block1 = '<option value="'.$block.'">'. $nom.'</option>';
}
}
		
?><br/><br/>
<center><img src="images/kg_admin/video.png" alt="video" /><br/><h1><?php echo main_video; ?></h1></center><br/><br /> 
<div style="background-image:url(images/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f; margin-left:12px;" >
<center><b><?php echo video_title; ?></b></center></div>
<br/><br/>
<form method="post" name="valide" action="theme_cfg.php?action=video&amp;ordre=saved" >


<table style='padding-left:40px;'align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
<tr>
<td width="60%" style="padding-left:70px; font-size:13px;"  ><b>JW Player</b></td>
<td style="padding-left:40px; font-size:13px;"  ><b>Dailymotion Player</b></td>
</tr>
<tr>
<td><img src="images/kg_admin/img/exemple_video1.jpg" alt="jsplayer" /></td>
<td><img src="images/kg_admin/img/exemple_video2.jpg" alt="dailymotion" /></Td>
</tr>
<tr valign="top">
<td><?php echo video_compa; ?> <br/> - Youtube<br/> - Flash(flv)<br/> - Stream(rtmp)
<td><?php echo video_compa; ?> <br/> - Dailymotion 
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<?php
if($play === '1')
$check = 'checked';
elseif($play === '2')
$check2 = 'checked';
else
{
$check = '';
}
?>
<td style="padding-left:70px;"><input type="radio" value="1" name="play" <?php echo $check; ?>> JW Player</td>
<td style="padding-left:50px;"><input type="radio" value="2" name="play" <?php echo $check2; ?>> Dailymotion Player</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>Code source:</td>
<td>Code source:</td>
</tr>
<tr>
<td><textarea style='font-size:9px; 	font-family: Verdana;' name="jw_code" cols="50" rows="3"><?php echo $jw_code; ?></textarea></td>
<td><textarea style='font-size:9px; 	font-family: Verdana;' name="daily_code" cols="50" rows="3"><?php echo $daily_code; ?></textarea></td>
</tr>
<tr valign="top">
<td>Exemple :<br/><br/>
- <?php echo video_for; ?> <b>Youtube</b> (<?php echo video_youtube; ?>):<br/>
<span style="font-size:10px;">http://fr.youtube.com/watch?v=woaT43oWCkA</span><br/><br/>
- <?php echo video_for; ?> <b>Flash</b>(<?php echo video_flv; ?>) :<br/>
<span style="font-size:10px;">http://content.bitsontherun.com/videos/3ta6fhJQ.flv</span><br/><br/>


</td>
<td>Exemple :<br/><br/>
 <span style="font-size:9px;"><?php echo htmlentities('<embed src="'); ?><span style='background-color:#82a2d8' ><?php echo htmlentities('http://www.dailymotion.com/swf/k75KOmsPhGtIo34qxK&related=1'); ?></span><?php echo htmlentities('" type="application/x-shockwave-flash" width="420" height="257" allowFullScreen="true" allowScriptAccess="always"></embed>'); ?>
 </span><br/>
 <br/><?php echo video_daily; ?>
</span>
</td>
</tr>
</table><br/>
<br/><br/>
<center>
<input type="submit" name="submit" /></center>
</form>


<br/>

<center><a href="theme_cfg.php" title="index"><b><?php echo page_mess; ?></b></a></center>
<?php
} }
$page = ob_get_contents();
ob_clean();
echo utf8_encode($page);
?>