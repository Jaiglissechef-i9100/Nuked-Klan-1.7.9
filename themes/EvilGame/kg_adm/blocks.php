<?php
    if ($visiteur == 9)
    {
if(isset($_GET['ordre']))
$ordre = htmlentities(addslashes($_GET['ordre']));
else
$odre = "";
if($ordre === 'saved')
{
		

		     $ressource_fichier = fopen('kg_adm/cfg/blocks.txt', 'w');		
		
			
		     if($ressource_fichier AND is_writable('kg_adm/cfg/blocks.txt')) 
		     {
			
			$block1    = htmlentities($_POST['block1']);
			$block2    = htmlentities($_POST['block2']);
			$block3    = htmlentities($_POST['block3']);
			$block4    = htmlentities($_POST['block4']);
			$center    = htmlentities($_POST['center']);
  		    $verif  = $block1.$block2.$block3.$block4;

			if(is_numeric($verif))
			{
			 $donnee ='
			 <?php 
			 $block1   = "'.$block1.'";
			 $block2   = "'.$block2.'";
			 $block3   = "'.$block3.'";
			 $block4   = "'.$block4.'";
			 $activeBlock  = "'.$center.'";
			?>';
			 
		     fputs($ressource_fichier, $donnee);
		     fclose($ressource_fichier);  ?>
			 <meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=ok" />
 <?php	   }
			 else
			 {
			 echo '<meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=err02" />';
			 }
			 }
			 else
			 {
			 echo '<meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=err02" />';
			 }
			 }
else
{

		$ressource_fichier = fopen('kg_adm/cfg/blocks.txt', 'a+');

		$mess = htmlentities($_GET['mess']);
		include('./kg_adm/cfg/blocks.txt');
		
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
<center><img src="images/kg_admin/block.png" alt="block" /><br/><h1><?php echo main_block; ?></h1></center><br/><br /> 
<div style="background-image:url(images/kg/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f; margin-left:12px;" ><center><b><?php echo block_title; ?></b></center></div>
<br/><br/>
<form method="post" name="valide" action="theme_cfg.php?action=blocks&amp;ordre=saved" >
<table  width="85%" cellspacing="0" cellpadding="0" align="center" class="last">
<tr>
<td ><?php echo block_show; ?></td>
<td align="center"><select name="center"><?php echo verif($activeBlock,$video_v); ?><option value="0"><?php echo block_hide; ?></option><option value="1"><?php echo block_show; ?></option></select></td>
</tr>
<tr>
<td colspan='2'><?php echo block_display; ?><br/><br/></td>
</tr>
</tr>
<tr>
<td colspan='2'><br/></td>
</tr>

<tr valign="top">
	<td width="400"><img src="images/kg_admin/img/blocks.jpg" alt="" /></td>
	<td>
		<div style="width:100%;height:67px;padding-top:50px;vertical-align:text-bottom;background-color:#3bc1ff; text-align:center;">
		<select name="block1"><?php echo verif($block1,$block1); ?><option value="0"><?php echo block_hide; ?></option><option value="1"><?php echo block_show; ?></option></select>
		</div>
		<div style="width:100%;height:96px;padding-top:60px;vertical-align:text-bottom;background-color:#8a00ff; text-align:center;">
		<select name="block2"><?php echo verif($block2,$block2); ?><option value="0"><?php echo block_hide; ?></option><option value="1"><?php echo block_show; ?></option></select>
		</div>
		<div style="width:100%;height:65px;padding-top:60px;vertical-align:text-bottom;background-color:#18ff00; text-align:center;">
		<select name="block3"><?php echo verif($block3,$block3); ?><option value="0"><?php echo block_hide; ?></option><option value="1"><?php echo block_show; ?></option></select>
		</div><div style="width:100%;height:38px;padding-top:25px;vertical-align:text-bottom;background-color:#ff3000; text-align:center;">
		<select name="block4"><?php echo verif($block4,$block4); ?><option value="0"><?php echo block_hide; ?></option><option value="1"><?php echo block_show; ?></option></select>
		</div>
	</td>
</tr>


</table><br/><br/>
<center>
<input type="submit" name="submit" /></center>
</form>


<br/>

<center><a href="theme_cfg.php" title="index"><b><?php echo page_mess; ?></b></a></center>
<?php
}
}
?>