<?php
    if ($visiteur == 9)
    {
if(isset($_GET['ordre']))
$ordre = htmlentities(addslashes($_GET['ordre']));
else
$odre = "";
if($ordre === 'saved')
{
		
			$ressource_fichier = fopen('kg_adm/cfg/slide.txt', 'w');		
		     if($ressource_fichier AND is_writable('kg_adm/cfg/slide.txt')) 
		     {

			 
			//Enumeration des blocks
				$url1     = addslashes($_POST['url1']);
				$title1   = htmlspecialchars($_POST['title1']);
				$desc1    = htmlspecialchars($_POST['desc1']);
				$link1    = htmlspecialchars($_POST['link1']);

				$url2     = addslashes($_POST['url2']);
				$title2   = htmlspecialchars($_POST['title2']);
				$desc2    = htmlspecialchars($_POST['desc2']);
				$link2    = htmlspecialchars($_POST['link2']);
				
				$url3     = addslashes($_POST['url3']);
				$title3   = htmlspecialchars($_POST['title3']);
				$desc3    = htmlspecialchars($_POST['desc3'], ENT_QUOTES);
				$link3    = htmlspecialchars($_POST['link3']);
				
				$url4     = addslashes($_POST['url4']);
				$title4   = htmlspecialchars($_POST['title4']);
				$desc4    = htmlspecialchars($_POST['desc4']);
				$link4    = htmlspecialchars($_POST['link4']);
				
				$url5     = addslashes($_POST['url5']);
				$title5   = htmlspecialchars($_POST['title5']);
				$desc5    = htmlspecialchars($_POST['desc5']);
				$link5    = htmlspecialchars($_POST['link5']);
				
				if($url1)
				$cov1 = "<div class='glidecontent2'><div style='background: url($url1) no-repeat; width:550px;height:300px;'></div><div class='title_cov'><a href='$link1' title=''>$title1</a><br/><span class='cov_txt'>$desc1 .. </span></div></div>";
				if($url2)
				$cov2 = "<div class='glidecontent2'><div style='background: url($url2) no-repeat; width:550px;height:300px;'></div><div class='title_cov'><a href='$link2' title=''>$title2</a><br/><span class='cov_txt'>$desc2 .. </span></div></div>";
				if($url3)
				$cov3 = "<div class='glidecontent2'><div style='background: url($url3) no-repeat; width:550px;height:300px;'></div><div class='title_cov'><a href='$link3' title=''>$title3</a><br/><span class='cov_txt'>$desc3 .. </span></div></div>";
				if($url4)
				$cov4 = "<div class='glidecontent2'><div style='background: url($url4) no-repeat; width:550px;height:300px;'></div><div class='title_cov'><a href='$link4' title=''>$title4</a><br/><span class='cov_txt'>$desc4 .. </span></div></div>";
				if($url5)
				$cov5 = "<div class='glidecontent2'><div style='background: url($url5) no-repeat; width:550px;height:300px;'></div><div class='title_cov'><a href='$link5' title=''>$title5</a><br/><span class='cov_txt'>$desc5 .. </span></div></div>";				
				
				
				
				$donnee = '<?php
				$url1 = "'.$url1.'"; $title1 = "'.$title1.'"; $desc1 = "'.$desc1.'"; $link1 = "'.$link1.'"; 
				$cov1 = "'.$cov1.'"; 
				
				$url2 = "'.$url2.'"; $title2 = "'.$title2.'"; $desc2 = "'.$desc2.'"; $link2 = "'.$link2.'"; 
				$cov2 = "'.$cov2.'"; 
				
				$url3 = "'.$url3.'"; $title3 = "'.$title3.'"; $desc3 = "'.$desc3.'"; $link3 = "'.$link3.'"; 
				$cov3 = "'.$cov3.'"; 
	
				$url4 = "'.$url4.'"; $title4 = "'.$title4.'"; $desc4 = "'.$desc4.'"; $link4 = "'.$link4.'"; 
				$cov4 = "'.$cov4.'"; 

				$url5 = "'.$url5.'"; $title5 = "'.$title5.'"; $desc5 = "'.$desc5.'"; $link5 = "'.$link5.'"; 
				$cov5 = "'.$cov5.'"; 
				?>';
				 
		          fputs($ressource_fichier, $donnee);
		          fclose($ressource_fichier);

				 
			 
				  ?>
				  <meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=ok" />
				  <?php
	

			 }
			 else
			 {
			 echo '<meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=err06" />';
			 }
			 }
else
{

		$ressource_fichier = fopen('kg_adm/cfg/slide.txt', 'a+');

	include('./kg_adm/cfg/slide.txt');



		
?><br/><br/>
<center><img src="images/kg_admin/slide.png" alt="slide" /><br/><h1><?php echo main_coverage; ?></h1></center><br/><br /> 
<center><div style="background-image:url(images/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f;" ><b><?php echo slide_title; ?></b></div></center>
<br/><br/>
<form method="post" name="valide" action="theme_cfg.php?action=slider&amp;ordre=saved" >


<table width="90%" align="center" border="0" class="last">
<tr>
	<td width="100">Lien de l'image 1 : </td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($url1)); ?>" name="url1" /></td>
	<td rowspan="3"><textarea style='font-size:9px; 	font-family: Verdana;' name="desc1" cols="60" rows="6"><?php echo html_entity_decode(stripslashes($desc1)); ?></textarea></td>
</tr>
<tr>
	<td><?php echo slide_titre; ?></td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($title1)); ?>" name="title1" /></td>
</tr>
<tr>
	<td>Lien vers l'article :</td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($link1)); ?>" name="link1" /></td>
</tr>
<tr>
<td><br/><br/></td></tr>
<tr>
	<td width="100">Lien de l'image 2 : </td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($url2)); ?>" name="url2" /></td>
	<td rowspan="3"><textarea style='font-size:9px; 	font-family: Verdana;' name="desc2" cols="60" rows="6"><?php echo html_entity_decode(stripslashes($desc2)); ?></textarea></td>
</tr>
<tr>
	<td><?php echo slide_titre; ?></td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($title2)); ?>" name="title2" /></td>
</tr>
<tr>
	<td>Lien vers l'article :</td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($link2)); ?>" name="link2" /></td>
</tr>
<tr>
<td><br/><br/></td></tr>
<tr>
	<td width="100">Lien de l'image 3 : </td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($url3)); ?>" name="url3" /></td>
	<td rowspan="3"><textarea style='font-size:9px; 	font-family: Verdana;' name="desc3" cols="60" rows="6"><?php echo html_entity_decode(stripslashes($desc3)); ?></textarea></td>
</tr>
<tr>
	<td><?php echo slide_titre; ?></td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($title3)); ?>" name="title3" /></td>
</tr>
<tr>
	<td>Lien vers l'article :</td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($link3)); ?>" name="link3" /></td>
</tr>
<tr>
<td><br/><br/></td></tr>
<tr>
	<td width="100">Lien de l'image 4 : </td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($url4)); ?>" name="url4" /></td>
	<td rowspan="3"><textarea style='font-size:9px; 	font-family: Verdana;' name="desc4" cols="60" rows="6"><?php echo html_entity_decode(stripslashes($desc4)); ?></textarea></td>
</tr>
<tr>
	<td><?php echo slide_titre; ?></td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($title4)); ?>" name="title4" /></td>
</tr>
<tr>
	<td>Lien vers l'article :</td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($link4)); ?>" name="link4" /></td>
</tr>
<tr>
<td><br/><br/></td></tr>
<tr>
<tr>
	<td width="100">Lien de l'image 5 : </td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($url5)); ?>" name="url5" /></td>
	<td rowspan="3"><textarea style='font-size:9px; 	font-family: Verdana;' name="desc5" cols="60" rows="6"><?php echo html_entity_decode(stripslashes($desc5)); ?></textarea></td>
</tr>
<tr>
	<td><?php echo slide_titre; ?></td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($title5)); ?>" name="title5" /></td>
</tr>
<tr>
	<td>Lien vers l'article :</td>
	<td><input size="25" type="text" value="<?php echo html_entity_decode(stripslashes($link5)); ?>" name="link5" /></td>
</tr>

</table><br/><br/>
<center>
<input type="submit" name="submit"  /></center>
</form>



<br/>


<center><a href="theme_cfg.php" title="index"><b><?php echo page_mess; ?></b></a></center>
<?php
}
}
?>