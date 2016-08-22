<?php
//--------------------------------------------------------------------------//
//  Module Forum Sous Catégorie	                                            //
//  For nuked-klan                                                          //
//  http://www.nuked-klan.org                                               //
//  By Maxxi                                                                //
//--------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify    //
//  it under the terms of the GNU General Public License as published by    //
//  the Free Software Foundation; either version 2 of the License.          //
//--------------------------------------------------------------------------//
define ("INDEX_CHECK", 1);

if (is_file('globals.php')) include ("globals.php");
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php must be near globals.php</b></div>');
if (is_file('conf.inc.php')) @include ("conf.inc.php");
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php must be near conf.inc.php</b></div>');
if (is_file('nuked.php')) include('nuked.php');
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php must be near nuked.php</b></div>');

function style()
{
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n"
    . "<head>\n"
	. "<meta charset=\"windows-1252\" />\n"
	. "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">\n"
    . "<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n"
    . "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n"
	. "<!-- IE Mode Compatibility -->\n"
    . "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=8\" />\n"
    . "<title>Nuked-KlaN 1.7.9 Module Email</title>\n"
    . "<style>\n"
    . "h3{color:#666666;font-size:18px;font-weight:bold;font-family:Arial, verdana, Sans serif;line-height:0px;}\n"
    . "a:link,a:visited,a:hover,a:active{color:#666666;font-size:12px;font-weight:bold;font-family:Arial, verdana, Sans serif;}\n"
    . "body{background-color:#CCCCCC;color:#333333;font-family:arial,verdana, sans serif;}\n"
    . "input{background-color:#999999;color:#FFFFFF;border: solid 1 rgb( 0 0 0);}\n"
    . "select{background-color:#999999;color:#FFFFFF;border: solid 1 rgb( 0 0 0);}\n"
    . ".barre{width:1px;background-color:white;align:left;}\n"
    . "</style>\n"
    . "<script type=\"text/javascript\">\n"
    . "<!--\n"
    . "var progr = 20;\n"
    . "function show_progress(val, msg){\n"
    . "if (msg == 'upgrade'){progr= progr+34;}\n"
    . "else{\n"
    . "progr+=2;"
    . "Bw = document.getElementById('barre').innerHTML;\n"
    . "var  Nw = Bw + val;\n"
    . "document.getElementById('barre').innerHTML = Nw;\n"
    . "document.getElementById('infos').innerHTML = msg;\n"
    . "//alert(Nw+' - '+msg);\n"
    . "}\n"
    . "}\n"
    . "//-->\n"
    . "</script>\n"
    . "</head>\n"
    . "<body>\n";
}



function index(){

style();

echo"	<br /><br /><div style=\"text-align: center;\"><b>Voulez vous installer le module Facebook ?</b><br/><br />
	<input type=\"button\" name=\"yes\" onclick=\"document.location.href='install.php?op=table';\" value=\"Oui\" />
	<input type=\"button\" name=\"No\" onclick=\"document.location.href='install.php?op=non';\" value=\"Non\" />
	</div>";

}



function table()
{
global $nuked,$db_prefix;

style();

  $sql = "DROP TABLE IF EXISTS $db_prefix" . _facebook;
  $req = mysql_query($sql);

  $sql = "CREATE TABLE $db_prefix" . _facebook . "(
  `id` int(11) NOT NULL auto_increment,
  `id_facebook` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;";

$req = mysql_query($sql);

$sql = mysql_query("SELECT nom FROM $nuked[prefix]"._modules." WHERE nom='Facebook'");
$test = mysql_num_rows($sql);
if($test == 0){
$sql = mysql_query("INSERT INTO $db_prefix" . _modules." (id, nom, niveau, admin) VALUES ('', 'Facebook', 1, 9);");
}

echo"	<div style=\"text-align: center;\"><br /><br /><b>Installation réussie! le fichier install.php va être supprimé de votre FTP..</b><br /><br /></div>";
	if (is_file("install.php"))
    {
	$path="install.php";
	$filesys = str_replace("/", "\\", $path);
	@chmod ($path, 0775);
	@unlink($path);
	@system("del $filesys");
    }
	
	redirect('index.php',2);
}

function non(){

style();

echo"<div style=\"text-align: center;\"><br /><b>Installation annulée...<br /><br /></div>";
if (is_file("install.php"))
    {
	$path="install.php";
	$filesys = str_replace("/", "\\", $path);
	@chmod ($path, 0775);
	@unlink($path);
	@system("del $filesys");
    }
redirect('index.php',2);
}



switch ($_REQUEST['op']){
	case"index":
	index();
	break;

	case"table":
	table();
	break;

	case"non":
	non();
	break;

	default:
	index();
	break;
}


?>