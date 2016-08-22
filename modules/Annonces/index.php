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

global $nuked, $language, $user;
translate("modules/Annonces/lang/" . $language . ".lang.php");
include("modules/Annonces/config.php");

if (!$user)
{
    $visiteur = 0;
} 
else
{
    $visiteur = $user[1];
} 
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

compteur(Annonces);


function maj()
{
global $nuked;

$sql_maj=mysql_query("SELECT artid, obsol FROM " . ANNONCES_TABLE . "");
while(list($artid, $obsol) = mysql_fetch_array($sql_maj))
   {

$now=time();

if ($obsol < $now)
	{

$upd=mysql_query("UPDATE " . ANNONCES_TABLE . " SET active='0' WHERE artid = '$artid'");
	}

   }
}

function del()
{
global $nuked;

$sql_del=mysql_query("SELECT artid, obsol, url_screen FROM " . ANNONCES_TABLE . " WHERE active = '0'");
while(list($artid, $obsol, $url_screen) = mysql_fetch_array($sql_del))
   {

$now=time();
$out=(30*24*60*60);

if (($obsol + $out) < $now)
	{

$del=mysql_query ("DELETE FROM " . ANNONCES_TABLE . " WHERE artid = '$artid'");

if ($url_screen != ""){unlink($url_screen);}

	}
   }
}

maj();
del();


function index() 
{
global $user, $nuked, $bgcolor3, $img_none, $nb_img_lignes, $img_cat;


OpenTable();

echo "	<br /><center><big><b>"._ANNONCES."</b></big><br />
	<br /><center><small><img src=\"modules/Annonces/images/new.gif\" border=\"0\" alt=\"\" align=\"absmiddle\"> <a href=\"index.php?file=Annonces&amp;op=classe&amp;orderby=news\">"._NEWSART."</a> | <a href=\"index.php?file=Annonces&amp;op=classe&amp;orderby=count\">"._TOPART."</a> <img src=\"modules/Annonces/images/top10.gif\" border=\"0\" alt=\"\" align=\"absmiddle\"><br />| <a href=\"index.php?file=Annonces&amp;op=tout\">"._SEEALL."</a> |</small></center><br /><br />
    	<table width=\"60%\" align=\"center\" cellspacing=\"15\" cellpadding=\"15\">";
	
	$sql=mysql_query("SELECT artid FROM " . ANNONCES_TABLE . "");
	$nb_art=mysql_num_rows($sql);

	$sql_nbcat=mysql_query("SELECT anid, anname, foto FROM " . ANNONCES_CAT_TABLE . " WHERE parentid=0");
	$cb_cat=mysql_num_rows($sql_nbcat);
	$counter=0;
	while (list($anid, $anname, $foto) = mysql_fetch_array($sql_nbcat)){
	
	$anname = stripslashes($anname);

	$nb_img_cat = $nuked['img_cat'];
	$nb_img_line = $nuked['nb_img_lignes'];
	$no_foto = $nuked['img_none'];

	
 if ($anid!=$last_anid)
		{
$counter++;
if ($counter == 1) {echo"<TR>";}

if ($foto == ''){$foto=$no_foto;}

echo" <td align=\"center\">
<a href=\"index.php?file=Annonces&amp;op=categorie&amp;anid=$anid\">
<img src=\"$foto\" width=\"$nb_img_cat\" border=\"0\" align=\"absmiddle\" alt=\"\"></a><br />
<a href=\"index.php?file=Annonces&amp;op=categorie&amp;anid=$anid\"><b>$anname</b></a>";


	$sql2=mysql_query("SELECT anid FROM " . ANNONCES_TABLE . " WHERE anid='$anid' AND active='1'");
	$nb_dl=mysql_num_rows($sql2);

if($nb_dl>0){echo"<small>&nbsp;($nb_dl)</small>";}

echo"</td>";


if($counter == $nb_img_line)
	{
	$counter=0;
	echo"</tr>";
	}	
    $last_anid=$anid;
	}

}

	$sql3=mysql_query("SELECT anid FROM " . ANNONCES_TABLE . " WHERE active='1'"); 
	$nb_articles=mysql_num_rows($sql3);

	$sql_wait=mysql_query("SELECT anid FROM " . ANNONCES_TABLE . " WHERE active='0'"); 
	$nb_wait=mysql_num_rows($sql_wait);

	$sql4=mysql_query("SELECT anid FROM " . ANNONCES_CAT_TABLE . "");
	$nb_rubrique=mysql_num_rows($sql4);
	
echo"	</table><form method=\"post\" action=\"index.php?file=Annonces&amp;op=add\" name=\"Insertion\">
<input type=\"submit\" name=\"Submit\" value=\""._INSERTION."\"></form>";

if ($user[1] > 0){
echo" <center><a href=\"index.php?file=Annonces&amp;op=lister\"><b>"._LISTURANNONCES." </b></a> - <a href=\"index.php?file=User&amp;op=edit_account\"><b> "._EDITURPROFIL."</b></a></center>";
}

echo" <br /><br /><center><small><i>( "._THEREIS." $nb_articles "._ARTDB." & $nb_wait "._WAIT." "._INDATABASE." )</i></small></center><br />";
CloseTable();

}


function lister()
{
global $user, $nuked, $language, $bgcolor3;
OpenTable();

echo"	<script language=\"javascript\">
	function test(titre,id)
	{
	if (confirm('"._DELETEART." '+titre+' ! "._CONFIRM."'))
	{document.location.href = 'index.php?file=Annonces&amp;op=user_del&amp;art_id='+id;}
	}</script>";

echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\"><img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._ADMINURANNONCES."</h3><br /><img src=\"modules/Annonces/images/statusok.gif\" border=\"0\" align=\"absmiddle\" alt=\""._ACTIVE."\"> <small><i>"._ACTIVE." - "._WAITING." </i></small><img src=\"modules/Annonces/images/statusno.gif\" border=\"0\" align=\"absmiddle\" alt=\""._WAITING."\"><br /><font color=\"#FF0000\"><small><i>"._WARNING."</i></small></font><br /></center><br />
	<table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\"><tr> 
	<td align=\"center\" bgcolor=\"$bgcolor3\" width=\"30%\"><b>"._TITLE."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._CATEG."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._INSER."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._DAYSLEFT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._EDIT."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._DEL."</b></td>
	<td align=\"center\" bgcolor=\"$bgcolor3\"><b>"._ETAT."</b></td></tr>";

	$sql=mysql_query("SELECT artid, title, anid, pseudo, email, date, active, obsol FROM " . ANNONCES_TABLE . " WHERE pseudo='$user[2]' ORDER BY active, date ASC");
	while (list($art_id, $titre, $cat, $pseudo, $email, $date, $active, $obsol) = mysql_fetch_row($sql)) {
	$titre=stripslashes($titre);
	$pseudo=stripslashes($pseudo);
	$cat=stripslashes($cat);
	$count=mysql_numrows($sql);

$now=time();
$compte=($obsol-$now);

if ($compte < 0){

$left=round(($compte)/86400);
if ($left=="-0"){$decompte="<font color=\"red\">-1</font>";}else{$decompte="<font color=\"red\">" . $left . "</font>";}

}else{

  //combien de jours ?
  $jours = floor($compte / 86400);
  
  //combien d'heures ?
  $hours = floor(($compte - ($jours * 86400)) / 3600);

  //combien de minutes ?
  $min = floor(($compte - ($hours * 3600) - ($jours * 86400)) / 60);
  if ($min < 10)
    $min = "0".$min;

if ($jours == '0'){$decompte = ($hours." "._H." ".$min." "._M."");

}elseif ($jours == '1'){$decompte = ($jours." "._DAY." ".$hours." "._H." ".$min." "._M."");}

else {$decompte = ($jours." "._DAYS." ".$hours." "._H." ".$min." "._M."");}
}


	$date = strftime("%d/%m/%Y ", $date);
	
	echo"<tr><td><b>$titre</b></td>";	

	$sql2=mysql_query("SELECT parentid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$cat'");
	list($parentid, $namecat) = mysql_fetch_array($sql2);
	$namecat=stripslashes($namecat);
		
	if($parentid=="0"){echo"<td align=\"center\"><i>$namecat</i></td><td align=\"center\">$date</td>";
	}else{
	$sql3=mysql_query("SELECT anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$parentid'");
	list($parentcat) = mysql_fetch_array($sql3);
	$parentcat = stripslashes($parentcat);
echo"	<td align=\"center\"><i>$parentcat > $namecat</i></td><td align=\"center\">$date</td>";}

			
echo"	<td align=\"center\">$decompte</td><td align=\"center\">
	<a href=\"index.php?file=Annonces&amp;op=user_edit&amp;art_id=$art_id\" style=\"text-decoration:none\" title=\""._EDITTHISART."\"><img src=\"images/edit.gif\" border=\"0\" alt=\"\"></a></td>
	<td align=\"center\" align=\"center\">
	<a href=\"javascript:test('".addslashes($titre)."','".$art_id."');\" style=\"text-decoration:none\" title=\""._DELTHISART."\"><img src=\"images/del.gif\" border=\"0\" alt=\"\"></a></td>";

if ($active == "0"){echo" <td align=\"center\"><img src=\"modules/Annonces/images/statusno.gif\" border=\"0\" alt=\""._WARNING."\"></td></tr>";}
else{echo" <td align=\"center\"><img src=\"modules/Annonces/images/statusok.gif\" border=\"0\" alt=\""._ACTIVE."\"></td></tr>";}

	}
if($count == 0){echo"<tr><td colspan=\"7\" align=\"center\">"._NOARTINDB."</td></tr>";}
echo"	</table><br /><center><form method=\"post\" action=\"index.php?file=Annonces&amp;op=add\" name=\"Insertion\">
<input type=\"submit\" name=\"Submit\" value=\""._INSERTION."\"></form><br /><a href=\"index.php?file=Annonces\"><b>"._BACK."</b></a><br /><br />";

CloseTable();
}


function add()
{
global $language, $user, $nuked, $bgcolor3, $img_size;


OpenTable();

echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
	<img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._ADDART."</h3>";

if ($user[1] < 1){

echo"<form name=\"login\" method=\"post\" action=\"index.php?file=User&amp;nuked_nude=index&amp;op=login\">
  <table width=\"450\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"$bgcolor3\">
    <tr>
      <td height=\"31\" colspan=\"2\"><div align=\"center\"><font color=\"red\"><b>"._ALERTLOGIN."<br />"._NOMODIF."</b><br /></font></div></td>
    </tr>
    <tr>
      <td width=\"35%\" align=\"right\">"._NICK." :</td>
      <td width=\"65%\" align=\"left\"> <input name=\"pseudo\" type=\"text\" size=\"25\" maxlength=\"25\"></td>
    </tr>
    <tr>
      <td align=\"right\">"._PASSWORD." :</td>
      <td align=\"left\"> <input name=\"pass\" type=\"password\" size=\"25\" maxlength=\"25\"><input type=\"hidden\" name=\"remember_me\" value=\"ok\">
      </td>
    </tr>
    <tr>
      <td colspan=\"2\"><div align=\"center\"><input type=\"submit\" value=\""._LOGIN."\"></div></td>
    </tr>
    <tr>
      <td colspan=\"2\"><div align=\"center\"><a href=\"index.php?file=User&amp;op=reg_screen\"><b>"._NOTYETREG."</b></a></div></td>
    </tr>
  </table>
</form>";

}else{
	$sql=mysql_query("SELECT mail FROM " . USER_TABLE . " WHERE pseudo='$user[2]'");
	list($mail) = mysql_fetch_array($sql);}

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

	if (document.formulaire.country.value == 0)
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


echo"<form name=\"formulaire\" method=\"post\" enctype=\"multipart/form-data\" action=\"index.php?file=Annonces&amp;op=do_add\" OnSubmit='return verifchamps();'>
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
      <td><p align=\"left\"><input name=\"ville\" type=\"text\" id=\"ville2\" size=\"30\" maxlength=\"30\"></p></td>
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
    </tr>";

if ($user[1] > 0)
	{

echo"<tr><td align=\"right\">"._WHERESCREEN." <i>($taille "._MAX.")</i> :</td>
	<td>&nbsp;</td>
	<td align=\"left\"><input type=\"file\" name=\"fichiernom\" />
	</td></tr>";
	}


echo"<tr><td>&nbsp;</td></tr></table>
  
  <p align=\"center\">
    <input type=\"submit\" name=\"Submit\" value=\""._ADDURART."\">
    <input name=\"effacer\" type=\"reset\" id=\"effacer\" value=\""._DELETEUART."\"> 
 </p></form><br />
<center><a href=\"index.php?file=Annonces&amp;page=index\"><b>"._BACK."</b></a><br /><br /></center>";

CloseTable();
}




function do_add($titre,$texte,$cat,$pseudo,$email,$ville,$date,$country,$prix,$duree,$active,$obsol,$fichiernom)
{
global $user, $nuked, $img_size;

OpenTable();

$date = time();

$fin = getdate(mktime()+($duree*24*60*60));
$obsol = $fin[0];

	
	$fichier_name=$_FILES['fichiernom']['name'];
	$fichier_tmp_name=$_FILES['fichiernom']['tmp_name']; 
	$fichier_size=$_FILES['fichiernom']['size']; 

if ($fichier_name != ""){


	$dossier_destination="upload/Annonces/";
	$file_taille_max=$img_size;

	if($fichier_size>$file_taille_max){echo "<center>"._FILETOOBIG."</center> "; redirect("javascript:history.back()",3); closetable(); footer(); exit();}

	$temp=explode('.',$fichier_name);												
	$extension=strtolower($temp[count($temp)-1]);	
	
	$ext_auto="(jpeg|png|gif|jpg)";//array des extensions autorisees
	if(!ereg($ext_auto,$extension)){echo "<center>"._BADFILEFORMAT."</center> "; redirect("javascript:history.back()",3); closetable(); footer(); exit();}
	$extension = '.'.$extension;	
	$fichier_name = time() . $extension;

	$res_copy=move_uploaded_file($fichier_tmp_name, $dossier_destination . $fichier_name);
	
$url_screen = $dossier_destination . $fichier_name;}



if($user[2]!=""){$pseudo=$user[2];
}else{
$pseudo=verif_pseudo($pseudo);
if($pseudo=="error1"){echo"<br /><center>"._PSEUDOFAILDED."</center><br />";
redirect("index.php?file=Annonces&amp;op=add",2); CloseTable();}
else if($pseudo=="error2"){echo"<br /><center>"._RESERVNICK."</center><br />";
redirect("index.php?file=Annonces&amp;op=add",2);}
else{$pseudo=$pseudo;}
}


$ville = htmlentities($ville, ENT_QUOTES);
$country = htmlentities($country, ENT_QUOTES);
$titre = htmlentities($titre, ENT_QUOTES);
$texte = htmlentities($texte, ENT_QUOTES);
$pseudo=AddSlashes($pseudo);
$ville=AddSlashes($ville);
$country=AddSlashes($country);
$titre=AddSlashes($titre);
$texte=AddSlashes($texte);

$sql=mysql_query(" INSERT INTO " . ANNONCES_TABLE . " ( `artid`,`anid`,`title`,`content`,`counter`,`pseudo`,`email`,`ville`,`date`,`pays`,`prix`,`duree`,`active`,`obsol`,`url_screen` ) VALUES ('','$cat','$titre','$texte','','$pseudo','$email','$ville','$date','$country','$prix','$duree','1','$obsol','$url_screen')");
echo"<br /><center>"._ARTADD."</center><br />";

if ($user[1] > 0){redirect("index.php?file=Annonces&amp;op=lister",2);}
else{redirect("index.php?file=Annonces",2);}
CloseTable();
}


function user_edit($art_id)
{
global $user, $nuked, $language, $bgcolor3, $img_size;
OpenTable();

$sql=mysql_query("SELECT artid, title, content, anid, pseudo, email, ville, date, pays, prix, duree, active, obsol, url_screen FROM " . ANNONCES_TABLE . " WHERE artid='$art_id'");
list($artid, $titre, $texte, $cat, $pseudo, $email, $ville, $date, $pays, $prix, $duree, $active, $obsol, $url_screen) = mysql_fetch_array($sql); 
$titre=stripslashes($titre);
$texte=stripslashes($texte);
$pseudo=stripslashes($pseudo);
$ville=stripslashes($ville);
$country=stripslashes($country);
$taille = ($img_size / 1000);

if ($user && $pseudo==$user[2]){

$sql2=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$cat'");
list($cid, $categorie) = mysql_fetch_array($sql2);
$categorie=stripslashes($categorie);


echo"	<A HREF=# onClick=\"javascript:window.open('help/".$language."/Annonces.html','Help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=300');return(false)\">
	<img src=\"help/help.gif\" border=\"0\" alt=\""._HELP."\"></a><center><H3>"._EDITURANNONCES."</h3></center><br />";

echo"	<script language=\"javascript\">
	function verifchamps()
	{


		
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
	
echo"<form name=\"formulaire\" method=\"post\" enctype=\"multipart/form-data\"  action=\"index.php?file=Annonces&amp;op=userdo_edit&amp;art_id=$art_id\" OnSubmit='return verifchamps();'>
  <table bgcolor=\"$bgcolor3\" width=\"450\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
    <tr>
      <td height=\"49\" colspan=\"3\"><div align=\"center\"><big><b><u>"._SALER."</u></b></big></div></td>
    </tr>
    <tr>
      <td width=\"35%\"><div align=\"right\">"._AUTHOR." :</div></td>
      <td width=\"1%\"></td>
      <td width=\"74%\"><p align=\"left\">$pseudo</td>
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

echo"	</select></td>
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

if ($user[1] > 0 && $url_screen == "")
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

echo"     </table><p align=\"center\">
    <input type=\"submit\" name=\"Submit\" value=\""._MODIFTHISART."\">
    <input name=\"effacer\" type=\"reset\" id=\"effacer\" value=\""._DELETEUART."\"> 
 </p></form><br />
<center><a href=\"index.php?file=Annonces&amp;page=index\"><b>"._BACK."</b></a><br /><br /></center>";
}
else{echo" <center>"._NICETRY."</center>"; redirect("index.php?file=Annonces",3);}

CloseTable();
}



function userdo_edit($art_id, $titre, $texte, $cat, $email, $ville, $country, $prix, $duree, $active, $obsol, $url_screen, $delete)
{
global $nuked, $img_size;
OpenTable();

$ville = htmlentities($ville, ENT_QUOTES);
$country = htmlentities($country, ENT_QUOTES);
$titre = htmlentities($titre, ENT_QUOTES);
$texte = htmlentities($texte, ENT_QUOTES);
$titre=AddSlashes($titre);
$texte=AddSlashes($texte);
$pseudo=stripslashes($pseudo);
$ville=stripslashes($ville);
$country=stripslashes($country);

$date = time();

$fin = getdate(mktime()+($duree*24*60*60));
$obsol = $fin[0];


	$fichier_name=$_FILES['fichiernom']['name'];
	$fichier_tmp_name=$_FILES['fichiernom']['tmp_name']; 
	$fichier_size=$_FILES['fichiernom']['size']; 

if ($fichier_name != ""){


	$dossier_destination="upload/Annonces/";
	$file_taille_max=$img_size;

	if($fichier_size>$file_taille_max){echo "<center>"._FILETOOBIG."</center> "; redirect("javascript:history.back()",3); closetable(); footer(); exit();}

	$temp=explode('.',$fichier_name);												
	$extension=strtolower($temp[count($temp)-1]);	
	
	$ext_auto="(jpeg|png|gif|jpg)";//array des extensions autorisees
	if(!ereg($ext_auto,$extension)){echo "<center>"._BADFILEFORMAT."</center>"; redirect("javascript:history.back()",3); closetable(); footer(); exit();}

	$extension = '.' . $extension;		
	$fichier_name = time() . $extension;

	$res_copy = move_uploaded_file($fichier_tmp_name, $dossier_destination . $fichier_name);
	
$url_screen = $dossier_destination . $fichier_name;

mysql_query("UPDATE " . ANNONCES_TABLE . " SET anid='$cat', title='$titre', content='$texte', email='$email', ville='$ville', pays='$country', prix='$prix', duree='$duree', active='1', obsol='$obsol', url_screen='$url_screen' WHERE artid='$art_id'");
echo"<br /><center>"._ARTMODIF."</center><br />";
redirect("index.php?file=Annonces&amp;op=lister",2);

}else{

if ($_POST['delete'] != "off")
{
mysql_query("UPDATE " . ANNONCES_TABLE . " SET anid='$cat', title='$titre', content='$texte', email='$email', ville='$ville', pays='$country', prix='$prix', duree='$duree', active='1', obsol='$obsol' WHERE artid='$art_id'");
echo"<br /><center>"._ARTMODIF."</center><br />";
redirect("index.php?file=Annonces&amp;op=lister",2);

	}else{

$del=mysql_query("SELECT url_screen FROM " . ANNONCES_TABLE . " WHERE artid='$art_id'");
list ($url_screen) = mysql_fetch_array($del);

unlink($url_screen);

mysql_query("UPDATE " . ANNONCES_TABLE . " SET anid='$cat', title='$titre', content='$texte', email='$email', ville='$ville', pays='$country', prix='$prix', duree='$duree', active='1', obsol='$obsol', url_screen='' WHERE artid='$art_id'");
echo"<br /><center>"._ARTMODIF."</center><br />";
redirect("index.php?file=Annonces&amp;op=lister",2);

	}
    }

CloseTable();
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



function user_del($art_id)
{
global $nuked, $user;
OpenTable();

$verif = mysql_query("SELECT pseudo, url_screen FROM " . ANNONCES_TABLE . " WHERE artid = '$art_id'");
list($pseudo, $url_screen) = mysql_fetch_array($verif);

if ($user[2] == $pseudo){

if ($urlfoto != ""){unlink($urlfoto);}
$del=mysql_query("DELETE FROM " . ANNONCES_TABLE . " WHERE artid='$art_id'");
$del_com=mysql_query("DELETE FROM $nuked[prefix]"._comment." WHERE im_id ='$art_id' AND module='Annonces'");
if ($url_screen != ""){unlink($url_screen);}
echo"<br /><center>"._ARTDEL."</center><br />";
redirect("index.php?file=Annonces&amp;op=lister",2);}
else{echo" <center>"._NICETRY."</center>"; redirect("index.php?file=Annonces",3);}

CloseTable();
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


function categorie($anid) 
{
global $nuked, $bgcolor3, $img_none;

OpenTable();   

$sql=mysql_query("SELECT anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$anid'");
list($anname) = mysql_fetch_row($sql);
$anname=stripslashes($anname);

$i=0;
$sql_top=mysql_query("SELECT counter FROM " . ANNONCES_TABLE . " WHERE anid='$anid' ORDER by counter DESC LIMIT 10");
while (list($count) = mysql_fetch_row($sql_top)) {
$i++;
if($i==1){$maxcount=$count;}
}

$sql2=mysql_query("SELECT artid, title, counter, prix, ville, pays, date, obsol, url_screen FROM " . ANNONCES_TABLE . " WHERE anid='$anid' AND active='1' ORDER by artid DESC");
$nb_art=mysql_num_rows($sql2);


echo"	<br /><center><a href=\"index.php?file=Annonces\" style=\"text-decoration:none\"><big><b>"._ANNONCES."</a> - $anname </b></big></center><br />";

	

echo"    <table border=\"0\" width=\"95%\" align=\"center\" cellspacing=\"1\" cellpadding=\"3\">";
    		
echo"	<tr><td align=\"center\" bgcolor=\"$bgcolor3\" align=\"left\" width=\"35%\"> <b>"._ART."</b></td><td align=\"center\" bgcolor=\"$bgcolor3\" width=\"10%\"><b>"._PRICE."</b></td><td align=\"center\" bgcolor=\"$bgcolor3\" width=\"20%\"><b>"._VILLE."</b></td><td align=\"center\" bgcolor=\"$bgcolor3\" width=\"15%\"><b>"._COUNTRY."</b></td><td bgcolor=\"$bgcolor3\" align=\"center\" width=\"20%\"><b>"._DAYSLEFT."</b></tr>";    
    	    
echo"	</table>";

if($nb_art==0  && $nb_subcat==0){echo"<br /><center>"._NOART."</center>";}


echo "<table width=\"95%\" align=\"center\" cellspacing=\"1\" cellpadding=\"3\">";

    	while (list($artid, $title, $counter,$prix,$ville,$country,$date,$obsol, $url_screen) = mysql_fetch_row($sql2)) {
       $title=stripslashes($title);	
	$ville=stripslashes($ville);
	$country=stripslashes($country);
	$date = strftime("%d/%m/%Y "._AT." %H:%M", $date);

$now=time();
$compte=($obsol-$now);

if ($compte < 0){

$left=round(($compte)/86400);
if ($left=="-0"){$decompte="<font color=\"red\">-1</font>";}else{$decompte="<font color=\"red\">" . $left . "</font>";}

}else{

  //combien de jours ?
  $jours = floor($compte / 86400);
  
  //combien d'heures ?
  $hours = floor(($compte - ($jours * 86400)) / 3600);

  //combien de minutes ?
  $min = floor(($compte - ($hours * 3600) - ($jours * 86400)) / 60);
  if ($min < 10)
    $min = "0".$min;

if ($jours == '0'){$decompte = ($hours." "._H." ".$min." "._M."");

}elseif ($jours == '1'){$decompte = ($jours." "._DAY." ".$hours." "._H." ".$min." "._M."");}

else {$decompte = ($jours." "._DAYS." ".$hours." "._H." ".$min." "._M."");}
}

	
echo"	<tr><td align=\"left\" width=\"35%\"><li><a href=\"index.php?file=Annonces&amp;op=article&amp;artid=$artid\"><b>$title</b>&nbsp;&nbsp;";

if ($url_screen != ""){echo" <img src=\"modules/Annonces/images/foto.gif\" border=\"0\" align=\"absmiddle\" alt=\""._FOTOON."\">";}

if($counter>=$maxcount){echo"&nbsp;<img src=\"modules/Annonces/images/top10.gif\" border=\"0\" alt=\"\" align=\"absmiddle\">";}

list ($country,$ext) = split ('[.]', $country);

echo"  </a></td><td align=\"center\" width=\"10%\"><i>$prix</i></td><td align=\"center\" width=\"20%\"><i>$ville</i></td><td align=\"center\" width=\"15%\"><i>$country</i></td><td align=\"center\" width=\"20%\"><b>$decompte</b></td></tr></table>";    
    	}

$rep = 0;
$nb_img_line = $nuked['nb_img_lignes'];
$nb_img_cat = $nuked['img_cat'];
$sql_sub_cat=mysql_query("SELECT anid, anname, foto FROM " . ANNONCES_CAT_TABLE . " WHERE parentid='$anid'");
$nb_sub_cat = mysql_num_rows($sql_sub_cat);
if (!empty($nb_sub_cat)) echo "<table cellspacing=\"20\" cellpadding=\"0\" style=\"margin-left: auto;margin-right: auto;text-align: center;\"><tr><td>&nbsp;</td></tr><tr>";
while (list($id_subcat, $nom_subcat, $foto_subcat) = mysql_fetch_row($sql_sub_cat))
{
if ($foto_subcat == ''){$foto_subcat=$img_none;}
$nom_subcat = stripslashes($nom_subcat);
$nom_subcat = htmlentities($nom_subcat);

echo" <td>
<a href=\"index.php?file=Annonces&amp;op=categorie&amp;anid=$id_subcat\">
<img src=\"$foto_subcat\" width=\"".$nb_img_cat."\" border=\"0\" align=\"absmiddle\" alt=\"\"></a><br />
<a href=\"index.php?file=Annonces&amp;op=categorie&amp;anid=$id_subcat\"><b>$nom_subcat</b></a></td>";

$rep = $rep + 1;
if ($rep >= $nb_img_line) {echo "</tr><tr>"; $rep = 0;}
}
if (!empty($nb_sub_cat)) {echo "</tr>";}
    
echo "</table><br /><br /><center><a href=\"javascript:history.back()\"><b>[&nbsp;"._BACK."&nbsp;]</b></a></center><br />";

CloseTable();
}

function tout() 
{
global $nuked, $bgcolor3;

OpenTable();   

$i=0;
$sql_top=mysql_query("SELECT counter FROM " . ANNONCES_TABLE . " ORDER by counter DESC LIMIT 10");
while (list($count) = mysql_fetch_row($sql_top)) {
$i++;
if($i==1){$maxcount=$count;}
}

echo"	<br /><center><big><b>"._ALLANNONCES."</big></center><br />";	

echo"    <table border=\"0\" width=\"95%\" align=\"center\" cellspacing=\"1\" cellpadding=\"3\">";
    		
echo"	<tr><td align=\"center\" bgcolor=\"$bgcolor3\" align=\"left\" width=\"35%\"> <b>"._ART."</b></td><td align=\"center\" bgcolor=\"$bgcolor3\" width=\"20%\"><b>"._CATEG."</b></td><td align=\"center\" bgcolor=\"$bgcolor3\" width=\"10%\"><b>"._PRICE."</b></td><td align=\"center\" bgcolor=\"$bgcolor3\" width=\"15%\"><b>"._VILLE."</b></td><td align=\"center\" bgcolor=\"$bgcolor3\" width=\"10%\"><b>"._COUNTRY."</b></td><td bgcolor=\"$bgcolor3\" align=\"center\" width=\"10%\"><b>"._DAYSLEFT."</b></tr>";    
    	    
echo"	</table>";



$sql2=mysql_query("SELECT artid, anid, title, counter, prix, ville, pays, date, obsol, url_screen FROM " . ANNONCES_TABLE . " WHERE active='1' ORDER by artid DESC");
$nb_art=mysql_num_rows($sql2);

if($nb_art==0  && $nb_subcat==0){echo"<br /><center>"._NOART."</center>";}


echo"    <table width=\"95%\" align=\"center\" cellspacing=\"1\" cellpadding=\"3\">";

    	while (list($artid, $anid, $title, $counter,$prix,$ville,$country,$date,$obsol, $url_screen) = mysql_fetch_row($sql2)) {

$sql3=mysql_query("SELECT anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid=$anid");
list($cat) = mysql_fetch_row($sql3);

       $title=stripslashes($title);	
	$ville=stripslashes($ville);
	$country=stripslashes($country);
	$date = strftime("%d/%m/%Y "._AT." %H:%M", $date);

$now=time();
$compte=($obsol-$now);

if ($compte < 0){

$left=round(($compte)/86400);
if ($left=="-0"){$decompte="<font color=\"red\">-1</font>";}else{$decompte="<font color=\"red\">" . $left . "</font>";}

}else{

  //combien de jours ?
  $jours = floor($compte / 86400);
  
  //combien d'heures ?
  $hours = floor(($compte - ($jours * 86400)) / 3600);

  //combien de minutes ?
  $min = floor(($compte - ($hours * 3600) - ($jours * 86400)) / 60);
  if ($min < 10)
    $min = "0".$min;

if ($jours == '0'){$decompte = ($hours." "._H." ".$min." "._M."");

}elseif ($jours == '1'){$decompte = ($jours." "._DAY." ".$hours." "._H." ".$min." "._M."");}

else {$decompte = ($jours." "._DAYS." ".$hours." "._H." ".$min." "._M."");}

}
	
echo"	<tr><td align=\"left\" width=\"35%\"><li><a href=\"index.php?file=Annonces&amp;op=article&amp;artid=$artid\"><b>$title</b>&nbsp;&nbsp;";

if ($url_screen != ""){echo" <img src=\"modules/Annonces/images/foto.gif\" border=\"0\" align=\"absmiddle\" alt=\""._FOTOON."\">";}

if($counter>=$maxcount){echo"&nbsp;<img src=\"modules/Annonces/images/top10.gif\" border=\"0\" alt=\"\" align=\"absmiddle\">";}

list ($country,$ext) = split ('[.]', $country);

echo"  </a></td><td align=\"center\" width=\"20%\"><i>$cat</i></td><td align=\"center\" width=\"10%\"><i>$prix</i></td><td align=\"center\" width=\"15%\"><i>$ville</i></td><td align=\"center\" width=\"10%\"><i>$country</i></td><td align=\"center\" width=\"10%\"><b>$decompte</b></tr>";    
    	}
    
echo"	</table><br /><br /><center><a href=\"javascript:history.back()\"><b>"._BACK."</b></a></center><br />";

CloseTable();
}


function article($artid) 
{
global $nuked, $user, $bgcolor3;
    
OpenTable();

echo"	<table align=\"center\" width=\"90%\" border=\"0\"><tr><td><table width=\"100%\"><tr><td>";
    
	$upd=mysql_query("UPDATE " . ANNONCES_TABLE . " SET counter=counter+1 WHERE artid='$artid'");

    	$sql=mysql_query("SELECT artid, anid, title, content, counter, pseudo, email, ville, date, pays, prix, duree, obsol, url_screen FROM " . ANNONCES_TABLE . " WHERE artid='$artid'");
    	list($artid, $anid, $title, $content, $counter, $pseudo, $email, $ville, $date, $country, $prix, $duree, $obsol, $url_screen) = mysql_fetch_row($sql);
        
    	$sql2=mysql_query("SELECT anid, anname FROM " . ANNONCES_CAT_TABLE . " WHERE anid='$anid'");
    	list($anid, $anname) = mysql_fetch_row($sql2);
	
	$title=stripslashes($title);
	$pseudo=stripslashes($pseudo);
	$ville=stripslashes($ville);
	$country=stripslashes($country);
	$content=stripslashes($content);
	$date = strftime("%d/%m/%Y "._AT." %H:%M", $date);
	$content=nl2br($content);

$now=time();
$compte=($obsol-$now);

if ($compte < 0){

$left=round(($compte)/86400);
if ($left=="-0"){$decompte="<font color=\"red\">-1</font>";}else{$decompte="<font color=\"red\">" . $left . "</font>";}

}else{

  //combien de jours ?
  $jours = floor($compte / 86400);
  
  //combien d'heures ?
  $hours = floor(($compte - ($jours * 86400)) / 3600);

  //combien de minutes ?
  $min = floor(($compte - ($hours * 3600) - ($jours * 86400)) / 60);
  if ($min < 10)
    $min = "0".$min;

if ($jours == '0'){$decompte = ($hours." "._H." ".$min." "._M."");

}elseif ($jours == '1'){$decompte = ($jours." "._DAY." ".$hours." "._H." ".$min." "._M."");}

else {$decompte = ($jours." "._DAYS." ".$hours." "._H." ".$min." "._M."");}

}


	if ($user[1]>=admin_mod(Annonces)){
	echo"<script language=\"javascript\">
	function delart(titre,id)
	{
	if (confirm('"._DELETEART." '+titre+' ! "._CONFIRM."'))
	{document.location.href = 'index.php?file=Annonces&amp;page=admin&amp;op=del&amp;art_id='+id;}
	}</script>";

echo"	<p align=\"right\"><a href=\"index.php?file=Annonces&amp;page=admin&amp;op=edit&amp;art_id=$artid\"><img src=\"images/edition.gif\" border=\"0\" alt=\""._EDIT."\"></a><a href=\"javascript:delart('".addslashes($title)."','".$artid."');\"><img src=\"images/delete.gif\" border=\"0\" alt=\""._DEL."\"></a>&nbsp;</p>";
}

   	elseif ($user[2]==$pseudo){
	echo"<script language=\"javascript\">
	function delart(titre,id)
	{
	if (confirm('"._DELETEART." '+titre+' ! "._CONFIRM."'))
	{document.location.href = 'index.php?file=Annonces&amp;op=user_del&amp;art_id='+id;}
	}</script>";

echo"	<p align=\"right\"><a href=\"index.php?file=Annonces&amp;op=user_edit&amp;art_id=$artid\"><img src=\"images/edition.gif\" border=\"0\" alt=\""._EDIT."\"></a><a href=\"javascript:delart('".addslashes($title)."','".$artid."');\"><img src=\"images/delete.gif\" border=\"0\" alt=\""._DEL."\"></a>&nbsp;</p>";
}


$sql_pseudo=mysql_query("SELECT pseudo FROM " . ANNONCES_TABLE . " WHERE artid='$artid'");
    	list($pseudo) = mysql_fetch_row($sql_pseudo);

echo"	<center><big><b>$title</b></big><br /><small>("._SEE." $counter "._TIMES." "._SINCE." $date)</small></center><br /><br /><br />";

    	    	
echo"	&nbsp;<b><i>"._CATEG."</i></b> : <a href=\"index.php?file=Annonces&amp;op=categorie&amp;anid=$anid\">$anname</a><br /><br />";
	


echo"<table border=\"0\" width=\"100%\" align=\"center\" cellspacing=\"2\" cellpadding=\"2\">
  <tr><td width=\"19%\"><b>"._DESCR." :</b></td>
    <td width=\"33%\">&nbsp;</td>
    <td width=\"48%\">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor=\"$bgcolor3\" colspan=\"3\">$content</td>
  </tr>
  <tr>
    <td colspan=\"2\" height=\"24\">&nbsp;</td>
    <td rowspan=\"9\"><div align=\"center\">";

if ($url_screen != ''){echo" <img src=\"$url_screen\" width=\"200\" border=\"0\" alt=\"$title\">";}

echo"</div></td>
  </tr>
  <tr>
    <td bgcolor=\"$bgcolor3\">"._PRIX." : </td>
    <td bgcolor=\"$bgcolor3\">$prix</td>
  </tr>
  <tr>
    <td bgcolor=\"$bgcolor3\">"._DAYSLEFT." :</td>
    <td bgcolor=\"$bgcolor3\"><font color=\"red\">$decompte</font></td>
  </tr>
  <tr>
    <td height=\"24\">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"2\"><b>"._SALER." :</b> </td>
  </tr>
  <tr>
    <td bgcolor=\"$bgcolor3\">"._NICK." :</td>
    <td bgcolor=\"$bgcolor3\">$pseudo</td>
  </tr>
  <tr>
    <td bgcolor=\"$bgcolor3\">"._MAIL." :</td>
    <td bgcolor=\"$bgcolor3\">$email</td>
  </tr>
  <tr>
    <td bgcolor=\"$bgcolor3\">"._VILLE." : </td>
    <td bgcolor=\"$bgcolor3\">$ville</td>
  </tr>";

list ($country,$ext) = split ('[.]', $country);

echo"  <tr>
    <td bgcolor=\"$bgcolor3\">"._COUNTRY." :</td>
    <td bgcolor=\"$bgcolor3\">$country</td>
  </tr></table><br />";


	include ("modules/Comment/index.php");
	com_index("Annonces",$artid);

echo"</td></tr></table><br /><br /><center><a href=\"javascript:history.back()\"><b>"._BACK."</b></a></center><br /><br /></td></tr></table>";

CloseTable();

}



function classe()
{
global $nuked, $orderby;

if($orderby=="news"){$classe=""._NEWSART."";}
else if($orderby=="count"){$classe=""._TOPART."";}

OpenTable();

echo"	<br /><center><a href=\"index.php?file=Annonces\"><big><b>"._ANNONCES."</a> - $classe</b></big><br />
	<br /><center><small><img src=\"modules/Annonces/images/new.gif\" border=\"0\" alt=\"\" align=\"absmiddle\"> <a href=\"index.php?file=Annonces&amp;op=classe&amp;orderby=news\">"._NEWSART."</a> | <a href=\"index.php?file=Annonces&amp;op=classe&amp;orderby=count\">"._TOPART."</a> <img src=\"modules/Annonces/images/top10.gif\" border=\"0\" alt=\"\"></small></center>
	<br /><table border=\"0\" align=\"center\">";

if ($orderby=="news")
{$sql=mysql_query("SELECT artid, title, counter, date FROM " . ANNONCES_TABLE . " WHERE active ='1' ORDER BY artid DESC LIMIT 10");}

else if ($orderby=="count")
{$sql=mysql_query("SELECT artid, title, counter, date FROM " . ANNONCES_TABLE . " WHERE active ='1' ORDER BY counter DESC LIMIT 10");}

$nb_art=mysql_num_rows($sql);

if($nb_art>0){
while (list($artid, $title, $counter, $date) = mysql_fetch_row($sql)) {
$title=stripslashes($title);

$date = date("d-m-Y");

echo"	<tr><td align=\"left\">
        <li><a href=\"index.php?file=Annonces&amp;op=article&amp;artid=$artid\"><b>$title</b></a><i><small> ("._INSER." $date - $counter "._READS.")</small></i></td></tr>"; 
	}
}else{echo"<br /><center>"._NOARTINDB."</center>";}
echo"	</table><br /><br /><form method=\"post\" action=\"index.php?file=Annonces&amp;op=add\" name=\"Insertion\">
<input type=\"submit\" name=\"Submit\" value=\""._INSERTION."\"></form>";

CloseTable();
}




switch($_REQUEST['op']) {

	

    case "article":
    article($_REQUEST['artid']);
    break;

    case "refresh":
    delete();
    break;

    case "lister":
    lister();
    break;

	case "user_edit":
	user_edit($_REQUEST['art_id']);
	break;

	case "userdo_edit":
	userdo_edit($_REQUEST['art_id'], $_REQUEST['titre'], $_REQUEST['texte'], $_REQUEST['cat'], $_REQUEST['email'], $_REQUEST['ville'], $_REQUEST['country'], $_REQUEST['prix'], $_REQUEST['duree'], $_REQUEST['active'], $_REQUEST['obsol'], $_REQUEST['url_screen'], $_REQUEST['delete']);
	break;

	case "user_del":
	user_del($_REQUEST['art_id']);
	break;

    case "classe":
    classe();
    break;

    case "categorie":
    categorie($_REQUEST['anid']);
    break;

    case "printpage":
    printpage($_REQUEST['artid']);
    break;

  case "add":
	add();
	break;

	case "tout":
	tout();
	break;
	
	case "do_add":
	do_add($_REQUEST['titre'],$_REQUEST['texte'],$_REQUEST['cat'],$_REQUEST['pseudo'],$_REQUEST['email'],$_REQUEST['ville'],$_REQUEST['date'],$_REQUEST['country'],$_REQUEST['prix'],$_REQUEST['duree'],$_REQUEST['active'],$_REQUEST['obsol'],$_REQUEST['url_screen']);
	break;
        
    default:
    index();
    break;

}
} 
else if ($level_access == -1)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
} 
else if ($level_access == 1 && $visiteur == 0)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b><br /><br /></div>";
    closetable();
} 
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
    closetable();
} 

?>
