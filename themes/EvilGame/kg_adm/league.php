<?php

$odre = htmlentities(addslashes($_GET['ordre']));
if($ordre === 'colors')
{
		{
		$requete = mysql_query("UPDATE `".PREFIX."styles` SET `styleID` = 1, `bgpage` = '#232323', `border` = '#161616', `bghead` = '#232323', `bgcat` = '#161616', `bg1` = '#161616', `bg2` = '#202020', `bg3` = '#161616', `bg4` = '#202020' WHERE  `styleID` = 1") or die (mysql_error());
?>
			  <meta http-equiv="refresh" content="0; url=theme_cfg.php?mess=ok" />
<?php			  
		
		}
}
elseif($ordre === 'saved')
{
		

		     $ressource_fichier = fopen('kg_adm/cfg/league.txt', 'w');		
		
			
		     if($ressource_fichier AND is_writable('kg_adm/cfg/league.txt')) 
		     {
				$pic1     = addslashes($_POST['league_pic1']);
				$pic2     = addslashes($_POST['league_pic2']);
				$pic3     = addslashes($_POST['league_pic3']);
				$pic4     = addslashes($_POST['league_pic4']);			
				$pic5     = addslashes($_POST['league_pic5']);
				$pic6     = addslashes($_POST['league_pic6']);
				$pic7     = addslashes($_POST['league_pic7']);
				$pic8     = addslashes($_POST['league_pic8']);
				$pic9     = addslashes($_POST['league_pic9']);
				$pic10    = addslashes($_POST['league_pic10']);
				
				$url1     = addslashes($_POST['league_url1']);
				$url2     = addslashes($_POST['league_url2']);
				$url3     = addslashes($_POST['league_url3']);
				$url4     = addslashes($_POST['league_url4']);			
				$url5     = addslashes($_POST['league_url5']);
				$url6     = addslashes($_POST['league_url6']);
				$url7     = addslashes($_POST['league_url7']);
				$url8     = addslashes($_POST['league_url8']);
				$url9     = addslashes($_POST['league_url9']);
				$url10    = addslashes($_POST['league_url10']);
	
				
				if($pic1){
				$link1 = "<a href='$url1' title='league'><img src='$pic1' alt='league' /></a><br/>";
				$url11 = $url1;
				$pic11 = $pic1;
				}
				if($pic2) {
				$link2 = "<a href='$url2' title='league'><img src='$pic2' alt='league' /></a><br/>";
				$url22 = $url2;
				$pic22 = $pic2;
				}
				if($pic3){
				$link3 = "<a href='$url3' title='league'><img src='$pic3' alt='league' /></a><br/>";
				$url33 = $url3;
				$pic33 = $pic3;
				}
				if($pic4){
				$link4 = "<a href='$url4' title='league'><img src='$pic4' alt='league' /></a><br/>";
				$url44 = $url4;
				$pic44 = $pic4;
				}
				if($pic5){
				$link5 = "<a href='$url5' title='league'><img src='$pic5' alt='league' /></a><br/>";
				$url55 = $url5;
				$pic55 = $pic5;
				}
				if($pic6){
				$link6 = "<a href='$url6' title='league'><img src='$pic6' alt='league' /></a><br/>";
				$url66 = $url6;
				$pic66 = $pic6;
				}
				if($pic7){
				$link7 = "<a href='$url7' title='league'><img src='$pic7' alt='league' /></a><br/>";
				$url77 = $url7;	
				$pic77 = $pic7;				
				}
				if($pic8){
				$link8 = "<a href='$url8' title='league'><img src='$pic8' alt='league' /></a><br/>";
				$url88 = $url8;
				$pic88 = $pic8;
				}
				if($pic9){
				$link9 = "<a href='$url9' title='league'><img src='$pic9' alt='league' /></a><br/>";
				$url99 = $url9;
				$pic99 = $pic9;
				}
				if($pic10)
				{
				$link10 = "<a href='$url10' title='league'><img src='$pic10' alt='league' /></a><br/>";
				$url10 = $url10;
				$pic10 = $pic10;
				}

				
				
			 $donnee ='
			 <?php 
					 $league1  = "'.$url11.'";
					 $league2  = "'.$url22.'";
					 $league3  = "'.$url33.'";
					 $league4  = "'.$url44.'";
					 $league5  = "'.$url55.'";
					 $league6  = "'.$url66.'";
					 $league7  = "'.$url77.'";
					 $league8  = "'.$url88.'";
					 $league9  = "'.$url99.'";
					 $league10 = "'.$url10.'";
					 
					 $league_i1 = "'.$pic11.'";
					 $league_i2 = "'.$pic22.'";
					 $league_i3 = "'.$pic33.'";
					 $league_i4 = "'.$pic44.'";
					 $league_i5 = "'.$pic55.'";
					 $league_i6 = "'.$pic66.'";
					 $league_i7 = "'.$pic77.'";
					 $league_i8 = "'.$pic88.'";
					 $league_i9 = "'.$pic99.'";
					 $league_i10 = "'.$pic10.'";
					 
					 $league_pic1 = "'.$link1.'";
					 $league_pic2 = "'.$link2.'";
					 $league_pic3 = "'.$link3.'";
				     $league_pic4 = "'.$link4.'";
				     $league_pic5 = "'.$link5.'";
					 $league_pic6 = "'.$link6.'";
					 $league_pic7 = "'.$link7.'";
					 $league_pic8 = "'.$link8.'";
					 $league_pic9 = "'.$link9.'";
					 $league_pic10 = "'.$link10.'";
	 

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

		$ressource_fichier = fopen('kg_adm/cfg/league.txt', 'a+');

		$mess = htmlentities($_GET['mess']);
		include('kg_adm/cfg/league.txt');
?><br/><br/>
<center><h1><img src="images/kg_admin/cup.png" alt="configuration" /><br/>Block League</h1></center><br/><br />
<div style="background-image:url(images/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f; margin-left:12px;" >
<center><b>League</b></center></div>

<br/><br/>
<form method="post" name="valide" action="theme_cfg.php?action=league&amp;ordre=saved" >
<table align="center" border="0" cellpadding="5" cellspacing="0" width="100%" style="padding-left:10px;">
<tr>
<td><?php echo league; ?> n&#176;1 :</td>
<td><input size="40" type="text" value="<?php echo $league_i1; ?>" name="league_pic1" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league1; ?>" name="league_url1" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;2 :</td>
<td><input size="40" type="text" value="<?php echo $league_i2; ?>" name="league_pic2" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo  $league2;?>" name="league_url2" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;3 :</td>
<td><input size="40" type="text" value="<?php echo $league_i3;?>" name="league_pic3" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league3; ?>" name="league_url3" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;4 :</td>
<td><input size="40" type="text" value="<?php echo $league_i4; ?>" name="league_pic4" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league4;  ?>" name="league_url4" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;5 :</td>
<td><input size="40" type="text" value="<?php echo $league_i5; ?>" name="league_pic5" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league5; ?>" name="league_url5" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;6 :</td>
<td><input size="40" type="text" value="<?php echo $league_i6; ?>" name="league_pic6" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league6; ?>" name="league_url6" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;7 :</td>
<td><input size="40" type="text" value="<?php echo  $league_i7;?>" name="league_pic7" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league7; ?>" name="league_url7" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;8 :</td>
<td><input size="40" type="text" value="<?php echo $league_i8; ?>" name="league_pic8" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league8; ?>" name="league_url8" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;9 :</td>
<td><input size="40" type="text" value="<?php echo $league_i9; ?>" name="league_pic9" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league9; ?>" name="league_url9" /></td>
</tr>
<tr>
<td><?php echo league; ?> n&#176;10 :</td>
<td><input size="40" type="text" value="<?php echo $league_i10; ?>" name="league_pic10" /></td>
<td><?php echo league2; ?> </td>
<td><input size="40" type="text" value="<?php echo $league10; ?>" name="league_url10" /></td>
</tr>
</table><br/><br/><center>
<input type="submit" name="submit" /></center>
</form>


<br/>

<center><a href="theme_cfg.php" title="index"><b><?php echo page_mess; ?></b></a></center>
<?php

}

?>