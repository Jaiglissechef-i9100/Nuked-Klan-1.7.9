<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
} 

global $user, $language;
translate("modules/Annonces/lang/" . $language . ".lang.php");
include("modules/Annonces/config.php");
include("modules/Admin/design.php");
admintop();

if (!$user)
{
    $visiteur = 0;
} 
else
{
    $visiteur = $user[1];
} 
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur == $level_admin && $level_admin > -1 OR $visiteur == 9 && $level_admin > -1)
{



function main()
{
global $nuked, $language, $bgcolor3;

echo"	<script language=\"javascript\">
	function test(titre,id)
	{
	if (confirm('"._DELETEART." '+titre+' ! "._CONFIRM."'))
	{document.location.href = 'index.php?file=Annonces&page=admin&op=del&art_id='+id;}
	}</script>";

echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\"><img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._ADMINANNONCES."</h3></center>	
	<center><a href=\"index.php?file=Annonces&amp;page=admin&amp;op=add\"><b>"._ADDART."</b></a> | 
	<a href=\"index.php?file=Annonces&amp;page=admin&amp;op=main_cat\"><b>"._CATMANAGEMENT."</b></a> |
	<a href=\"index.php?file=Annonces&amp;page=admin&amp;op=pref\"><b>"._PREF."</b></a></center><br />
	<table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\"><tr> 
	<td align=\"center\" bgcolor=\"$bgcolor3\" width=\"30%\"><b>"._TITLE."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._AUTHOR."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._CATPARENT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._CAT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._DATE."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._EDIT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._DEL."</b></td></tr>";

	$sql=mysql_query("SELECT artid, title, anid, pseudo, email, date FROM " . ANNONCES_TABLE . " ORDER BY artid DESC");
	while (list($art_id, $titre, $cat, $pseudo,$email,$date) = mysql_fetch_row($sql)) {
	$titre=stripslashes($titre);
	$pseudo=stripslashes($pseudo);
	$count=mysql_numrows($sql);
	$date = strftime("%d/%m/%Y "._AT." %H:%M", $date);
	
	echo"<tr><td><b>$titre</b></td><td align=\"center\"><a href=\"MAILTO:$email\" Alt=\""._CONTACT."\">$pseudo</a></td>";	

	$sql2=mysql_query("SELECT parentid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$cat'");
	list($parentid, $namecat) = mysql_fetch_array($sql2);
	$namecat=stripslashes($namecat);
		
	if($parentid=="0"){echo"<td align=\"center\"><i>$namecat</i></td><td align=\"center\">"._NONE."</td>";
	}else{
	$sql3=mysql_query("SELECT anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$parentid'");
	list($parentcat) = mysql_fetch_array($sql3);
	$parentcat = stripslashes($parentcat);
echo"	<td align=\"center\"><i>$parentcat</i></td><td align=\"center\">$namecat</td>";}
	
echo"	<td align=\"center\">$date</td><td align=\"center\">
	<a href=\"index.php?file=Annonces&amp;page=admin&amp;op=edit&amp;art_id=$art_id\" style=\"text-decoration:none\" title=\""._EDITTHISART."\"><img src=\"images/edit.gif\" border=\"0\" alt=\"\"></a></td>
	<td align=\"center\" align=\"center\">
	<a href=\"javascript:test('".addslashes($titre)."','".$art_id."');\" style=\"text-decoration:none\" title=\""._DELTHISART."\"><img src=\"images/del.gif\" border=\"0\" alt=\"\"></a></td></tr>";
	}
if($count == 0){echo"<tr><td colspan=\"5\" align=\"center\">"._NOARTINDB."</td></tr>";}
echo"	</table><br /><center><a href=\"index.php?file=Admin\"><b>"._BACK."</b></a></center><br />";
}


function select_duree($artid)
{

$sql=mysql_query("SELECT duree FROM " . ANNONCES_TABLE . " WHERE artid = '$artid'");
list($temps) = mysql_fetch_array($sql); 

$date=time();

if($temps=="1"){$checked="selected";}else{$checked="";}
echo"  	<option value=\"1\" $checked>"._1DAY."</option>";
if($temps=="2"){$checked="selected";}else{$checked="";}
echo"  	<option value=\"2\" $checked>"._2DAYS."</option>";
if($temps=="7"){$checked="selected";}else{$checked="";}
echo"  	<option value=\"7\" $checked>"._1WEEK."</option>";
if($temps=="14"){$checked="selected";}else{$checked="";}
echo"  	<option value=\"14\" $checked>"._2WEEKS."</option>";
if($temps=="30"){$checked="selected";}else{$checked="";}
echo"  	<option value=\"30\"  $checked>"._1MONTH."</option>";

}


function add()
{
global $language, $user, $nuked, $bgcolor3, $img_size;


echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
	<img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._ADDART."</h3>";


	$sql=mysql_query("SELECT mail FROM " . USER_TABLE . " WHERE pseudo='$user[2]'");
	list($mail) = mysql_fetch_array($sql);

	$taille = ($img_size / 1000);


echo"	<script language=\"javascript\">
	function verifchamps()
	{

	if (document.formulaire.pseudo.value.length == 0)
	{
	alert('"._NONICK."');
	return false;
	}

	if (document.formulaire.email.value.indexOf('@') == -1) 
	{
	alert('"._ERRORMAIL."');
   	return false;
	}
	
	if (document.formulaire.ville.value.length == 0)
	{
	alert('"._NOTOWN."');
	return false;
	}

	if (document.formulaire.pays.value.length == 0)
	{
	alert('"._NOCOUNTRY."');
	return false;
	}

	if (document.formulaire.titre.value.length == 0)
	{
	alert('"._NOTITRE."');
	return false;
	}


	if (document.formulaire.prix.value.length == 0)
	{
	alert('"._NOPRICE."');
	return false;
	}

	
	return true;
	}
	</script>";


echo"<form name=\"formulaire\" method=\"post\" enctype=\"multipart/form-data\" action=\"index.php?file=Annonces&amp;page=admin&amp;op=do_add\" OnSubmit='return verifchamps();'>
  <table bgcolor=\"$bgcolor3\" width=\"450\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
    <tr>
      <td height=\"49\" colspan=\"3\"><div align=\"center\"><big><b><u>"._SALER."</u></b></big></div></td>
    </tr>
    <tr>
      <td width=\"35%\"><div align=\"right\">"._AUTHOR." :</div></td>
      <td width=\"1%\"></td>
      <td width=\"74%\"><p align=\"left\"><input name=\"pseudo\" type=\"text\" value=\"$user[2]\" id=\"pseudo2\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._MAIL." :</div></td>
      <td></td>
      <td><p align=\"left\"><input name=\"email\" value=\"$mail\" type=\"text\" id=\"mail2\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._VILLE." :</div></td>
      <td></td>
      <td><p align=\"left\"><input name=\"ville\" value=\"$ville\" type=\"text\" id=\"ville2\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._COUNTRY." :</div></td>
      <td></td>
      <td><p align=\"left\"><select name=\"country\"><option value=\"0\" checked>"._CHOOSELAND."</option>";
	
	if($language=="french"){$pays="France.gif";}
	$rep = @opendir("images/flags");
	while ($file = readdir($rep)) {
	if($file != ".." && $file != ".") {
	if($file==$pays){$checked="selected";}else{$checked="";} 
	list ($country,$ext) = split ('[.]', $file); 
	echo"<option value=\"$file\" $checked>$country</option>";
		}
	}	
	closedir($rep);
	clearstatcache();

echo"	</select></p>
      </td>
    </tr>
    <tr>
	<td height=\"58\" colspan=\"3\">";

echo"<p>&nbsp;</p>
    <div align=\"center\"><big><b><u>"._DETAILART."</u></b></big></div></td>
    </tr>
    <tr>
      <td height=\"27\"><div align=\"right\">"._TITLE." : 
          
    </div></td>
      <td height=\"27\"></td>
      <td height=\"27\"><p align=\"left\"><input name=\"titre\" type=\"text\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td height=\"25\"><div align=\"center\">
        <p align=\"right\">"._CATEG." : </p>
        </div></td>
      <td height=\"25\">&nbsp;</td>
      <td height=\"25\"><p align=\"left\"><select name=\"cat\">";

	select_art_cat();

echo" </select></p></td>
    </tr>
    <tr>
      <td height=\"179\" colspan=\"3\"><div align=\"center\">
        <p>&nbsp;</p>
	<p><big><b><u>"._COMMENT."</u></b></big></p>
        <p><textarea name=\"texte\" wrap=\"VIRTUAL\" cols=\"55\" rows=\"10\" ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea>
            </p>
	<p>&nbsp;</p>
    </div></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._PRIX." : </div></td>
      <td></td>
      <td><p align=\"left\"><input name=\"prix\" type=\"text\" size=\"20\" maxlength=\"20\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._DUREE." :</div></td>
      <td></td>
      <td><p align=\"left\"><select name=\"duree\">";

	select_duree();

echo"</select></p>
    </td>
    </tr><tr><td align=\"right\">"._WHERESCREEN." <i>($taille "._MAX.")</i> :</td>
	<td>&nbsp;</td>
	<td align=\"left\"><input type=\"file\" name=\"fichiernom\" />
	</td></tr><tr><td>&nbsp;</td></tr>
  </table>
  
  <p align=\"center\">
    <input type=\"submit\" name=\"Submit\" value=\""._ADDURART."\">
    <input name=\"effacer\" type=\"reset\" id=\"effacer\" value=\""._DELETEUART."\"> 
 </p></form><br />
<center><a href=\"javascript:history.back()\"><b>"._BACK."</b></a><br /><br /></center>";


}






function do_add($titre,$texte,$cat,$pseudo,$email,$ville,$date,$country,$prix,$duree,$active,$obsol,$url_screen)
{
global $user, $nuked, $img_size;

$date = time();

$fin = getdate(time()+($duree*24*60*60));
$obsol = $fin[0];

	$fichier_name=$_FILES['fichiernom']['name'];
	$fichier_tmp_name=$_FILES['fichiernom']['tmp_name']; 
	$fichier_size=$_FILES['fichiernom']['size']; 

if ($fichier_name != ""){


	$dossier_destination="upload/Annonces/";
	$file_taille_max=$img_size;

	if($fichier_size>$file_taille_max){echo "<center>"._FILETOOBIG."</center> "; adminfoot(); exit();}

	$temp=explode('.',$fichier_name);												
	$extension=strtolower($temp[count($temp)-1]);	
	
	$ext_auto="(jpeg|png|gif|jpg)";//array des extensions autorisees
	if(!ereg($ext_auto,$extension)){echo "<center>"._BADFILEFORMAT."</center> "; adminfoot(); exit();}

	$name_ss_ext=eregi_replace("[^A-Z0-9]", "",strtolower(strtr(substr($fichier_name, 0, -strlen($extension)-1),"¿¡¬√ƒ≈‡·‚„‰Â“”‘’÷ÿÚÛÙıˆ¯»… ÀÈËÍÎ«ÁÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸ˇ—Ò","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn")));
	$extension='.'.$extension	;		

							
	if(file_exists($dossier_destination.$name_ss_ext.$extension)){
		$i=0;
		while(file_exists($dossier_destination.$name_ss_ext."_".$i.$extension))$i++;
		$fichier_name=$name_ss_ext."_".$i.$extension;
			
	}else{$fichier_name=$name_ss_ext . $extension;}

	$res_copy=move_uploaded_file($fichier_tmp_name, $dossier_destination . $fichier_name);
	
$url_screen = $dossier_destination . $fichier_name;}


if($user[2]!=""){$pseudo=$user[2];
}else{
$pseudo=verif_pseudo($pseudo);
if($pseudo=="error1"){echo"<br /><center>"._PSEUDOFAILDED."</center><br />";
redirect("index.php?file=Annonces&op=add",2); CloseTable();}
else if($pseudo=="error2"){echo"<br /><center>"._RESERVNICK."</center><br />";
redirect("index.php?file=Annonces&op=add",2);}
else{$pseudo=$pseudo;}
}

$pseudo=AddSlashes($pseudo);
$ville=AddSlashes($ville);
$country=AddSlashes($country);
$titre=AddSlashes($titre);
$texte=AddSlashes($texte);

$sql=mysql_query(" INSERT INTO " . ANNONCES_TABLE . " VALUES ('','$cat','$titre','$texte','','$pseudo','$email','$ville','$date','$country','$prix','$duree','1','$obsol','$url_screen')");
echo"<br /><center>"._ARTADD."</center><br />";
redirect("index.php?file=Annonces&page=admin",2);

}



function edit($art_id)
{
global $user, $nuked, $language, $bgcolor3, $img_size;


$sql=mysql_query("SELECT artid, title, content, anid, pseudo, email, ville, date, pays, prix, duree, active, obsol, url_screen FROM " . ANNONCES_TABLE . " WHERE artid='$art_id'");
list($artid, $titre, $texte, $cat, $pseudo, $email, $ville, $date, $pays, $prix, $duree, $active, $obsol, $url_screen) = mysql_fetch_array($sql); 
$titre=stripslashes($titre);
$texte=stripslashes($texte);
$pseudo=stripslashes($pseudo);
$ville=stripslashes($ville);
$country=stripslashes($country);
$taille = ($img_size / 1000);

$sql2=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$cat'");
list($cid, $categorie) = mysql_fetch_array($sql2);
$categorie=stripslashes($categorie);


echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
	<img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._EDITANNONCES."</h3></center><br />";

echo"	<script language=\"javascript\">
	function verifchamps()
	{

	if (document.formulaire.pseudo.value.length == 0)
	{
	alert('"._NONICK."');
	return false;
	}

		
	if (document.formulaire.email.value.indexOf('@') == -1) 
	{
	alert('"._ERRORMAIL."');
   	return false;
	}
	
	if (document.formulaire.ville.value.length == 0)
	{
	alert('"._NOTOWN."');
	return false;
	}

	if (document.formulaire.pays.value.length == 0)
	{
	alert('"._NOCOUNTRY."');
	return false;
	}

	
	if (document.formulaire.titre.value.length == 0)
	{
	alert('"._NOTITRE."');
	return false;
	}


	if (document.formulaire.prix.value.length == 0)
	{
	alert('"._NOPRICE."');
	return false;
	}

	
	return true;
	}
	</script>";
	
echo"<form name=\"formulaire\" method=\"post\" enctype=\"multipart/form-data\" action=\"index.php?file=Annonces&amp;page=admin&amp;op=do_edit&amp;art_id=$art_id\" OnSubmit='return verifchamps();'>
  <table bgcolor=\"$bgcolor3\" width=\"450\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
    <tr>
      <td height=\"49\" colspan=\"3\"><div align=\"center\"><big><b><u>"._SALER."</u></b></big></div></td>
    </tr>
    <tr>
      <td width=\"35%\"><div align=\"right\">"._AUTHOR." :</div></td>
      <td width=\"1%\"></td>
      <td width=\"74%\"><p align=\"left\"><input name=\"pseudo\" type=\"text\" value=\"$pseudo\" id=\"pseudo2\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._MAIL." :</div></td>
      <td></td>
      <td><p align=\"left\"><input name=\"email\" value=\"$email\" type=\"text\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._VILLE." :</div></td>
      <td></td>
      <td><p align=\"left\"><input name=\"ville\" value=\"$ville\" type=\"text\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._COUNTRY." :</div></td>
      <td></td>
      <td><p align=\"left\"><select name=\"country\">";
	
	$rep = @opendir("images/flags");
	while ($file = readdir($rep)) {
	if($file != ".." && $file != ".") {
	if($pays==$file){$checked="selected";}else{$checked="";}
	list ($country,$ext) = split ('[.]', $file); 
	echo"<option value=\"$file\" $checked>$country</option>";
		}
	}	
	closedir($rep);
	clearstatcache();

echo"	</select></p>
      </td>
    </tr>
    <tr>
      <td height=\"58\" colspan=\"3\">
      <p>&nbsp;</p>
    <div align=\"center\"><big><b><u>"._DETAILART."</u></b></big></div></td>
    </tr>
    <tr>
      <td height=\"27\"><div align=\"right\">"._TITLE." : 
          
    </div></td>
      <td height=\"27\"></td>
      <td height=\"27\"><p align=\"left\"><input value=\"$titre\" name=\"titre\" type=\"text\" size=\"30\" maxlength=\"30\"></p></td>
    </tr>
    <tr>
      <td height=\"25\"><div align=\"center\">
        <p align=\"right\">"._CATEG." : </p>
        </div></td>
      <td height=\"25\">&nbsp;</td>
      <td height=\"25\"><p align=\"left\"><select name=\"cat\"><option value=\"$cid\">$categorie</option>";

	select_art_cat();

echo" </select></p></td>
    </tr>
    <tr>
      <td height=\"179\" colspan=\"3\"><div align=\"center\">
        <p>&nbsp;</p>
	<p><big><b><u>"._COMMENT."</u></b></big></p>
        <p><textarea name=\"texte\" wrap=\"VIRTUAL\" cols=\"55\" rows=\"10\" ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">$texte</textarea>
            </p>
	<p>&nbsp;</p>
    </div></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._PRIX." : </div></td>
      <td></td>
      <td><p align=\"left\"><input name=\"prix\" value=\"$prix\" type=\"text\" size=\"20\" maxlength=\"20\"></p></td>
    </tr>
    <tr>
      <td><div align=\"right\">"._DUREE." :</div></td>
      <td></td>
      <td><p align=\"left\"><select name=\"duree\">";

	select_duree($artid);

echo"</select></p>
    </td>
    </tr>";

if ($url_screen == "")
	{

echo"<tr><td align=\"right\">"._WHERESCREEN." <i>($taille "._MAX.")</i> :</td>
	<td>&nbsp;</td>
	<td align=\"left\"><input type=\"file\" name=\"fichiernom\" />
	</td></tr>";
	
}else{


echo"<tr><td align=\"right\">"._ACTUAL." :</td>
	<td>&nbsp;</td>
	<td align=\"left\"><img src=\"$url_screen\" width=\"50\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" class=\"checkbox\" name=\"delete\" value=\"off\" >&nbsp; "._DELETETOF." </td></tr>";
}
echo" </table>
  
  <p align=\"center\">
    <input type=\"submit\" name=\"Submit\" value=\""._MODIFTHISART."\">
    <input name=\"effacer\" type=\"reset\" id=\"effacer\" value=\""._DELETEUART."\"> 
 </p></form><br />
<center><a href=\"javascript:history.back()\"><b>"._BACK."</b></a><br /><br /></center>";


}



function do_edit($art_id, $titre, $texte, $cat, $pseudo, $email, $ville, $country, $prix, $duree, $active, $obsol, $url_screen, $delete)
{
global $nuked, $img_size;

$titre=AddSlashes($titre);
$texte=AddSlashes($texte);
$pseudo=stripslashes($pseudo);
$ville=stripslashes($ville);
$country=stripslashes($country);

$date = time();

$fin = getdate(time()+($duree*24*60*60));
$obsol = $fin[0];

	$fichier_name=$_FILES['fichiernom']['name'];
	$fichier_tmp_name=$_FILES['fichiernom']['tmp_name']; 
	$fichier_size=$_FILES['fichiernom']['size']; 

if ($fichier_name != ""){


	$dossier_destination="upload/Annonces/";
	$file_taille_max=$img_size;

	if($fichier_size>$file_taille_max){echo " <center>"._FILETOOBIG."</center> "; redirect("javascript:history.back()",5); adminfoot(); exit();}

	$temp=explode('.',$fichier_name);												
	$extension=strtolower($temp[count($temp)-1]);	
	
	$ext_auto="(jpeg|png|gif|jpg)";//array des extensions autorisees
	if(!ereg($ext_auto,$extension)){echo "<center>"._BADFILEFORMAT."</center>"; redirect("javascript:history.back()",5); adminfoot(); exit();}

	$name_ss_ext=eregi_replace("[^A-Z0-9]", "",strtolower(strtr(substr($fichier_name, 0, -strlen($extension)-1),"¿¡¬√ƒ≈‡·‚„‰Â“”‘’÷ÿÚÛÙıˆ¯»… ÀÈËÍÎ«ÁÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸ˇ—Ò","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn")));
	$extension='.'.$extension;		

							
	if(file_exists($dossier_destination.$name_ss_ext.$extension)){
		$i=0;
		while(file_exists($dossier_destination.$name_ss_ext."_".$i.$extension))$i++;
		$fichier_name=$name_ss_ext."_".$i.$extension;
			
	}else{$fichier_name=$name_ss_ext . $extension;}

	$res_copy=move_uploaded_file($fichier_tmp_name, $dossier_destination . $fichier_name);
	
$url_screen = $dossier_destination . $fichier_name;

mysql_query("UPDATE " . ANNONCES_TABLE . " SET anid='$cat', title='$titre', content='$texte', email='$email', ville='$ville', pays='$country', prix='$prix', duree='$duree', active='1', obsol='$obsol', url_screen='$url_screen' WHERE artid='$art_id'");
echo"<br /><center>"._ARTMODIF."</center><br />";
redirect("index.php?file=Annonces&;op=lister",2);

}else{

if ($_POST['delete'] != "off")
{
mysql_query("UPDATE " . ANNONCES_TABLE . " SET anid='$cat', title='$titre', content='$texte', email='$email', ville='$ville', pays='$country', prix='$prix', duree='$duree', active='1', obsol='$obsol' WHERE artid='$art_id'");
echo"<br /><center>"._ARTMODIF."</center><br />";
redirect("index.php?file=Annonces&op=lister",2);

	}else{

$del=mysql_query("SELECT url_screen FROM " . ANNONCES_TABLE . " WHERE artid='$art_id'");
list ($url_screen) = mysql_fetch_array($del);

unlink($url_screen);

mysql_query("UPDATE " . ANNONCES_TABLE . " SET anid='$cat', title='$titre', content='$texte', email='$email', ville='$ville', pays='$country', prix='$prix', duree='$duree', active='1', obsol='$obsol', url_screen='' WHERE artid='$art_id'");
echo"<br /><center>"._ARTMODIF."</center><br />";
redirect("index.php?file=Annonces&op=lister",2);

	}
    }

}

function del($art_id)
{
global $nuked;

$file=mysql_query("SELECT url_screen FROM " . ANNONCES_TABLE . " WHERE artid='$art_id'");
list ($url_screen) =  mysql_fetch_array($file);

$del=mysql_query("DELETE FROM " . ANNONCES_TABLE . " WHERE artid='$art_id'");
$del_com=mysql_query("DELETE FROM $nuked[prefix]"._comment." WHERE im_id ='$art_id' AND module='Annonces'");
if ($url_screen != ""){unlink($url_screen);}
echo"<br /><center>"._ARTDEL."</center><br />";
redirect("index.php?file=Annonces&page=admin",2);
}



function main_cat()
{
global $nuked, $language, $bgcolor3;

echo"	<script language=\"javascript\">
	function test(titre,id)
	{
	if (confirm('"._DELETEART." '+titre+' ! "._CONFIRM."'))
	{document.location.href = 'index.php?file=Annonces&page=admin&op=del_cat&cid='+id;}
	}</script>";
 
echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
	<img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._ADMINANNONCES."</h3></center>
	<table width=\"70%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" align=\"center\"><tr>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._CAT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._CATPARENT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._EDIT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._DEL."</b></td>";
	
	$sql=mysql_query("SELECT anid, anname, parentid FROM " . ANNONCES_CAT_TABLE . "");
	while (list($cid, $titre, $parentid) = mysql_fetch_row($sql)) {
 	$titre=stripslashes($titre);

echo"	<tr><td align=\"center\">$titre</td><td align=\"center\">";

	if($parentid>0){
	$sql2=mysql_query("SELECT anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$parentid'");
	list($pnomcat) = mysql_fetch_array($sql2);
	$pnomcat=stripslashes($pnomcat);
	echo"<i>$pnomcat</i>";}else{echo""._NONE."";}


echo"	<td align=\"center\"><a href=\"index.php?file=Annonces&amp;page=admin&amp;op=edit_cat&amp;cid=$cid\" style=\"text-decoration:none\" title=\""._EDITTHISCAT."\"><img src=\"images/edit.gif\" border=\"0\" alt=\"\"></a></td>
	<td align=\"center\"><a href=\"javascript:test('".addslashes($titre)."','".$cid."');\" style=\"text-decoration:none\" title=\""._DELTHISCAT."\"><img src=\"images/del.gif\" border=\"0\" alt=\"\"></a></td></tr>";
	}
echo"	</table><br /><center><b>[ <a href=\"index.php?file=Annonces&amp;page=admin&amp;op=add_cat\">"._ADDCAT."</a> ]</b></center><br /><center><a href=\"index.php?file=Annonces&amp;page=admin\"><b>"._BACK."</b></a></center><br />";
}



function add_cat()
{
global $language, $nuked;

echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
	<img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._ADMINANNONCES."</h3></center><br />
	<form method=\"post\" action=\"index.php\">
	<input type=\"hidden\" name=\"file\" value=\"Annonces\">
	<input type=\"hidden\" name=\"page\" value=\"admin\">
	<table width=\"70%\" align=\"center\"><tr><td>
	<b>"._TITLE." : </b><input type=\"text\" name=\"titre\" size=\"30\">&nbsp;
	</td></tr>
	<tr><td><b>"._CATPARENT." : </b><select name=\"parentid\"><option value=\"0\">"._NONE."</option>";

	$sql=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " where parentid='0'");
	while (list($anid, $nomcat) = mysql_fetch_array($sql)){
	$nomcat=stripslashes($nomcat);

echo"	<option value=\"$anid\" >$nomcat</option>";
	}

echo"	</select></td></tr></table><table width=\"70%\" align=\"center\"><tr><td><b>"._FOTO." :</b></td><td></b><input type=\"text\" name=\"foto\" size=\"80\">&nbsp;
	</td></tr></table><input type=\"hidden\" name=\"op\" value=\"send_cat\">
	<center><br /><input type=\"submit\" name=\"send\" value=\""._CREATECAT."\"></center></form><center><a href=\"index.php?file=Annonces&amp;page=admin&amp;op=main_cat\"><b>"._BACK."</b></a><br /><br /></center>";
}



function send_cat($parentid, $titre, $foto)
{
global $nuked;

$titre=AddSlashes($titre);
$foto=AddSlashes($foto);

$sql=mysql_query("INSERT INTO " . ANNONCES_CAT_TABLE . " VALUES ('','$parentid','$titre','$foto')");
echo"<br /><center>"._CATADD."</center><br />"; 
redirect("index.php?file=Annonces&page=admin&op=main_cat",2);
}



function edit_cat($cid)
{
global $nuked, $language;

	$sql=mysql_query("SELECT anname, parentid, foto FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$cid'");
	list($titre, $parentid, $foto) = mysql_fetch_array($sql);
	$titres=stripslashes($anname);
	$foto=stripslashes($foto);


echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
	<img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._ADMINANNONCES."</h3></center><br />
	<form method=\"post\" action=\"index.php\">
	<input type=\"hidden\" name=\"file\" value=\"Annonces\">
	<input type=\"hidden\" name=\"page\" value=\"admin\">
	<table width=\"50%\" align=\"center\"><tr><td align=\"center\">
	<b>"._TITLE." : </b><input type=\"text\" name=\"titre\" size=\"30\" value=\"$titre\">&nbsp;
	</td></tr>
	<tr><td><b>"._CATPARENT." : </b><select name=\"parentid\">";

	if($parentid>0){
	$sql2=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$parentid'");
	list($pcid, $pnomcat) = mysql_fetch_array($sql2);
	$pnomcat=stripslashes($pnomcat);
	echo"<option value=\"$pcid\">$pnomcat</option>";}

	echo"<option value=\"0\">"._NONE."</option>";

	$sql3=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE parentid='0'");
	while (list($catid, $nomcat) = mysql_fetch_array($sql3)){
	$nomcat=stripslashes($nomcat);
	if($nomcat!=$anname){echo"<option value=\"$catid\">$nomcat</option>";}
	}
echo"	</select></td></tr></table><table width=\"70%\" align=\"center\"><tr><td><b>"._FOTO." :</b></td><td></b><input type=\"text\" name=\"foto\" size=\"80\" value=\"$foto\"></td></tr></table>
	<input type=\"hidden\" name=\"cid\" value=\"$cid\">
	<input type=\"hidden\" name=\"op\" value=\"modif_cat\">
	<center><br /><input type=\"submit\" name=\"send\" value=\""._MODIFTHISCAT."\"></form>
	<center><a href=\"index.php?file=Annonces&amp;page=admin&amp;op=main_cat\"><b>"._BACK."</b></a><br /><br /></center>";
}



function modif_cat($cid,$parentid,$titre,$foto)
{
global $nuked;

$titre=AddSlashes($titre);
$foto=AddSlashes($foto);
$sql=mysql_query("UPDATE " . ANNONCES_CAT_TABLE . " SET parentid='$parentid', anname='$titre', foto='$foto' WHERE anid='$cid'");
echo"<br /><center>"._CATMODIF."</center><br />";
redirect("index.php?file=Annonces&page=admin&op=main_cat",2);
}


function select_art_cat()
{
global $nuked;

$sql=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE parentid='0' ORDER by anid");
while (list($anid, $anname) = mysql_fetch_array($sql)){
$anname=stripslashes($anname);
echo"<option value=\"$anid\">* $anname</option>";
$sql2=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE parentid='$anid' ORDER by anid");
while (list($s_anid, $s_titre) = mysql_fetch_array($sql2)){
$s_titre=stripslashes($s_titre);
echo"<option value=\"$s_anid\">&nbsp;&nbsp;&nbsp;$s_titre</option>";
		}
	}
}


function del_cat($cid)
{
global $nuked;

$sql=mysql_query("DELETE FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$cid'");
echo"<br /><center>"._CATDEL."</center><br />"; 
redirect("index.php?file=Annonces&page=admin&op=main_cat",2);
}


function pref()
    {
        global $nuked, $language;

$value=stripslashes($value);

        echo "<a href=\"#\" onclick=\"javascript:window.open('help/" . $language . "/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">\n"
	. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a><div style=\"text-align: center;\"><h3>" . _ADMINANNONCES . "</h3></div>\n"	
	. "<div style=\"text-align: center;\"><b><a href=\"index.php?file=Annonces&amp;page=admin\">" . _ADDART . "</a> | "
	. "<a href=\"index.php?file=Annonces&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a> | "
	. "</b>" . _PREFS . "</div><br />\n"
	. "<form method=\"post\" action=\"index.php?file=Annonces&amp;page=admin&amp;op=change_pref\">\n"
	. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n"
	. "<tr><td align=\"center\" colspan=\"2\"><big>" . _PREFS . "</big></td></tr>\n"
	. "<tr><td>" . _SIZEIMG . " : </td><td><input type=\"text\" name=\"img_cat\" size=\"3\" value=\"" . $nuked['img_cat'] . "\" /></td></tr>\n"
	. "<tr><td>" . _NUMBERIMG . " : </td><td><input type=\"text\" name=\"nb_img_lignes\" size=\"3\" value=\"" . $nuked['nb_img_lignes'] . "\" /></td></tr>\n"
	. "<tr><td>" . _NOFOTONAME . " : </td><td><input type=\"text\" name=\"img_none\" size=\"40\" value=\"" . $nuked['img_none'] . "\" /></td></tr>\n"
	. "</table><div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _SEND . "\" /></div>\n"
	. "<div style=\"text-align: center;\"><br />[ <a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a> ]</div></form><br />\n";
    
}


    function change_pref($img_cat, $nb_img_lignes, $img_none)
    {
        global $nuked;
	
	$value=AddSlashes($value);

        $upd1 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $img_cat . "' WHERE name = 'img_cat'");
        $upd2 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $nb_img_lignes . "' WHERE name = 'nb_img_lignes'");
        $upd3 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $img_none . "' WHERE name = 'img_none'");
        echo "<br /><br /><div style=\"text-align: center;\">" . _PREFUPDATED . "</div><br /><br />";
        redirect("index.php?file=Annonces&page=admin", 2);
}


switch($_REQUEST['op'])
 {	
	case "main":
        main();
       	break;
	
	case "add":
	add();
	break;
	
	case "do_add":
	do_add($_REQUEST['titre'], $_REQUEST['texte'], $_REQUEST['cat'], $_REQUEST['pseudo'], $_REQUEST['email'], $_REQUEST['ville'], $_REQUEST['date'], $_REQUEST['country'], $_REQUEST['prix'], $_REQUEST['duree'], $_REQUEST['active'], $_REQUEST['obsol'], $_REQUEST['url_screen']);
	break;

	case "edit":
	edit($_REQUEST['art_id']);
	break;

	case "do_edit":
	do_edit($_REQUEST['art_id'],$_REQUEST['titre'],$_REQUEST['texte'],$_REQUEST['cat'],$_REQUEST['pseudo'],$_REQUEST['email'],$_REQUEST['ville'],$_REQUEST['country'],$_REQUEST['prix'],$_REQUEST['duree'],$_REQUEST['active'],$_REQUEST['obsol'],$_REQUEST['url_screen'],$_REQUEST['delete']);
	break;

	case "del":
	del($_REQUEST['art_id']);
	break;
	
	case "send_cat":
	send_cat($_REQUEST['parentid'],$_REQUEST['titre'],$_REQUEST['foto']);
	break;

	case "add_cat":
	add_cat();
	break;

	case "main_cat":
	main_cat();
	break;

	case "edit_cat":
	edit_cat($_REQUEST['cid']);
	break;

	case "modif_cat":
	modif_cat($_REQUEST['cid'],$_REQUEST['parentid'],$_REQUEST['titre'],$_REQUEST['foto']);
	break;

	case "del_cat":
	del_cat($_REQUEST['cid']);
	break;

	case "pref":
	pref();
	break;
	
	case "change_pref":
	change_pref($_REQUEST['img_cat'], $_REQUEST['nb_img_lignes'], $_REQUEST['img_none']);
	break;
	
     	default:
       	main();
	break;
}

} 
else if ($level_admin == -1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
} 
else if ($visiteur > 1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
} 
else
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
}   

adminfoot();

?>
