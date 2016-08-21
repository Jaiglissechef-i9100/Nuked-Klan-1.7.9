<?php
    if ($visiteur == 9)
    {
if(isset($_GET['ordre']))
$ordre = htmlentities(addslashes($_GET['ordre']));
else
$odre = "";
if($ordre === 'saved')
{
		

		     $ressource_fichier = fopen('kg_adm/cfg/pref.txt', 'w');		
		
			
		     if($ressource_fichier AND is_writable('kg_adm/cfg/pref.txt')) 
		     {
			
			//Enumeration des blocks
				$key  = htmlentities($_POST['key']);
				$desc   = addslashes($_POST['desc']);
				$lang1  = addslashes($_POST['lang1']);
				$copy_detail = htmlentities($_POST['copy_detail']);
				$copy_desc = htmlentities($_POST['copy_desc']);
				$fb =  htmlentities($_POST['fb']);
				$tw =  htmlentities($_POST['tw']);
				$steam =  htmlentities($_POST['steam']);
				
			 $donnee ='
			 <?php 
			 $key     = "'.$key.'";	
			 $desc    = "'.$desc.'";
			 $lang1   = "'.$lang1.'";
			 $copy_desc = "'.$copy_desc.'";
			 $copy_detail = "'.$copy_detail.'";
			 $fb = "'.$fb.'";
			 $tw = "'.$tw.'";
			 $steam = "'.$steam.'";
			 

			 ?>';
			 
		          fputs($ressource_fichier, $donnee);
		          fclose($ressource_fichier);
				 
				  ?>
				  <meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=ok" />
				  <?php
		
	
				 

		     }
			 else
			 {
			 echo '<meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=err01" />';
			 }
			 }
else
{

		$ressource_fichier = fopen('kg_adm/cfg/pref.txt', 'a+');

		$mess = htmlentities($_GET['mess']);
		include('./kg_adm/cfg/pref.txt');
?><br/><br/>
<center><h1><img src="images/kg_admin/configure.png" alt="configuration" /><br/><?php echo main_gen; ?></h1></center><br/><br />



<form method="post" name="valide" action="theme_cfg.php?action=preferences&amp;ordre=saved" >
<div style="background-image:url(images/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f; margin-left:12px;" >
<center>
<b>Theme <?php echo lang; ?></b></center>
</div>

<br/><br/>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="70%">
<tr>
<td width="30%"><?php echo lang; ?> :</td> <td><select name="lang1" >
<?php
if($lang1 === '1')
echo '<option value="1">'.block_ac.' : '.lang1.'</option>';
else
echo '<option value="2">'.block_ac.' : '.lang2.'</option>';
?>
<option value="1"><?php echo lang1; ?></option>
<option value="2"><?php echo lang2; ?></option>



</tr>
</table>
<br/>



<div style="background-image:url(images/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f; margin-left:12px;" >
<center><b>Copyright</b></center></div><br/><br/>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
<tr>
<td>Copyright text :</td> <td><input type="text" size="30" name="copy_detail" value="<?php echo stripslashes($copy_detail); ?>"/></td>
</tr>
<tr>
<td>Description : <br/> (170 Char MAX) </td>

<td><textarea name="copy_desc" cols="70" rows="6"><?php echo stripslashes($copy_desc); ?></textarea></td>
</tr>
</table>
<br/><br/>
<div style="background-image:url(images/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f; margin-left:12px;" >
<center><b><?php echo comm_title; ?></b></center></div><br/><br/>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
<tr>
<td width="150"><?php echo comm_fb; ?> </td> <td><input type="text" size="80" name="fb" value="<?php echo stripslashes($fb); ?>"/></td>
</tr>
<tr>
<td><?php echo comm_tw; ?> </td> <td><input type="text" size="80" name="tw" value="<?php echo stripslashes($tw); ?>"/></td>
</tr>
<tr>
<td><?php echo comm_steam; ?> </td> <td><input type="text" size="80" name="steam" value="<?php echo stripslashes($steam); ?>"/></td>
</tr>
<tr>
<td colspan="2"><?php echo comm_help; ?></td></tr>
</table><br/><br/><br/><center>
<input type="submit" name="submit" /></center>


</form>


<br/>

<center><a href="theme_cfg.php" title="index"><b><?php echo page_mess; ?></b></a></center>
<?php
}
}
?>