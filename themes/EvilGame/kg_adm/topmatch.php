<?php
    if ($visiteur == 9)
    {
$ordre = htmlentities(addslashes($_GET['ordre']));

if($ordre === 'saved')
{
	

		     $ressource_fichier = fopen('./kg_adm/cfg/topmatch.txt', 'w');		
		
			
		     if($ressource_fichier AND is_writable('./kg_adm/cfg/topmatch.txt')) 
		     {
			
			//Enumeration des blocks
				$top_match  = htmlentities($_POST['topmatch']);
				$top_logo   = htmlentities($_POST['top_matchlogo']);
				$top_logo2  = htmlentities($_POST['utop_matchlogo']);
				$top_myname = htmlentities($_POST['top_myname']);

			 $donnee ='
			 <?php 
			 $id_topmatch  = "'.$top_match .'";
			 $top_logo   = "'.$top_logo.'";
			 $top_myname = "'.$top_myname.'";
			 $top_logo2 = "'.$top_logo2.'";
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
		
		$ressource_fichier = fopen('./kg_adm/cfg/topmatch.txt', 'a+');

		$mess = htmlentities($_GET['mess']);
		include('././kg_adm/cfg/topmatch.txt');
		




$last_m = mysql_query("SELECT * FROM " . WARS_TABLE . " INNER JOIN " . GAMES_TABLE . " 
	 ON " . WARS_TABLE . ".game = " . GAMES_TABLE . ".id  ORDER BY " . WARS_TABLE . ".date_an DESC, " . WARS_TABLE . ".date_mois DESC, " . WARS_TABLE . ".date_jour DESC ");
		 
if($id_topmatch)
$last_m2 = mysql_query("SELECT * FROM " . WARS_TABLE . " INNER JOIN " . GAMES_TABLE . " 
	 ON " . WARS_TABLE . ".game = " . GAMES_TABLE . ".id  where " . WARS_TABLE . ".warid  = '".$id_topmatch."' ");
		 



		
?><br/><br/>
<center><img src="./images/kg_admin/other.png" alt="other" /><br/><h1><?php echo main_other; ?></h1></center><br/><br /> 
<center><div style="background-image:url(images/kg_admin/back_title.jpg); width:779px; height:15px; color:#3e506f; margin-left:5px;" ><b><?php echo match_title; ?></b></div></center>
<br/><br/>
<form method="post" name="valide" action="theme_cfg.php?action=topmatch&amp;ordre=saved" >
<table width="55%" align="center" class="last">
<tr>
<td><?php echo match_titre; ?> </td>
<td><select name="topmatch">
<?php
$ret = mysql_fetch_array($last_m2);
    $name2 =  stripslashes($ret['adversaire']);
	$resultID2=$ret['warid']; 
echo '<option value="'.$resultID2.'">'.block_ac.' : '.$name2.'</option>';
 while($dodo = mysql_fetch_array($last_m))
			  {
			
    $name =  stripslashes($dodo['adversaire']);
	$resultID=$dodo['warid']; 
echo '<option value="'.$resultID.'">'.$name.'</option>';

}
?>

</select></td>
</tr>

<tr>
<td><?php echo match_logo; ?></td>
<td><input size="25" type="text" value="<?php echo $top_logo; ?>" name="top_matchlogo" /></td>
</tr>
<tr>
<td><?php echo match_ulogo; ?></td>
<td><input size="25" type="text" value="<?php echo $top_logo2 ?>" name="utop_matchlogo" /></td>
</tr>
<tr>
<td><?php echo match_myname; ?></td>
<td><input size="25" type="text" value="<?php echo $top_myname; ?>" name="top_myname" /></td>
</tr>

</table><br/><br/>
<center>
<input type="submit" name="submit"  /></center>
</form>


<br/><br/>


<br/>


<center><a href="theme_cfg.php" title="index"><b><?php echo page_mess; ?></b></a></center>
<?php
}
}
?>