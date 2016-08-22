<?php
////////////////////////////////////////////////
// MyLiens by kotshiro                        //
// http://www.inconnueteam.fr 10/2011         //
////////////////////////////////////////////////
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $nuked, $user, $language;
translate("modules/myliens/lang/" . $language . ".lang.php");

if ($user)
{
    $visiteur = $user[1];
}
else
{
    $visiteur = 0;
}

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{
    compteur("myliens");
    

OpenTable();

echo"<p><div align='center'><h3>"._LI_LIENS_NAME." ". $nuked['name']."</h3></div></p>";
echo"<br><br>";
echo""._LI_LIENS_ADVERTISE." <b>". $nuked['name']."</b><br>";

echo"<br><br>";

//lien texte
echo"<b>"._LI_TXT_ONE."</b><br>";
echo""._LI_EXEMPLE."<br><b><a href='". $nuked['url']."'>". $nuked['name']."</b></a><br>";
echo""._LI_LIENS_URL." ". $nuked['url']."/ <br>";
echo""._LI_SCRIPT."<br>";

echo"<textarea name='lientxt' cols='70' rows='4' wrap='VIRTUAL'><a href='". $nuked['url']."/'>". $nuked['name']."</a></textarea>";


echo"<br><br>";


//liens bouton
echo"<b>"._LI_BT_ONE."</b><br>";
echo""._LI_EXEMPLE."<br><img src='". $nuked['url']."/modules/myliens/images/bouton.png'><br>";
echo""._LI_BTONE_ADRESSE." <b>". $nuked['url']."/modules/myliens/images/bouton.png</b><br><br>";
echo""._LI_SCRIPT."<br>";
echo"<textarea name='lienbt' cols='70' rows='4' wrap='VIRTUAL'><a href='". $nuked['url']."/'><img src='". $nuked['url']."/modules/myliens/images/bouton.png' alt='". $nuked['slogan']."'></a></textarea>";
echo"<br><br>";

//lien logo
echo"<b>"._LI_BT_TWO."</b><br>";
echo""._LI_EXEMPLE."<br><img src='". $nuked['url']."/modules/myliens/images/Logo.png'><br>";
echo""._LI_BTTWO_ADRESSE." <b>". $nuked['url']."/modules/myliens/images/Logo.png</b><br><br>";
echo""._LI_SCRIPT."<br>";
echo"<textarea name='lienlogo' cols='60' rows='4' wrap='VIRTUAL'><a href='". $nuked['url']."/'><img src='". $nuked['url']."/modules/myliens/images/logo.png' alt='". $nuked['slogan']."'></a></textarea>";
echo"<br><br>";


//lien bannière
echo"<b>"._LI_BAN_ONE."</b><br>";
echo""._LI_EXEMPLE."<br><img src='". $nuked['url']."/modules/myliens/images/banner.png'><br>";
echo""._LI_BANONE_ADRESSE." <b>". $nuked['url']."/modules/myliens/images/banner.png</b><br><br>";
echo""._LI_SCRIPT."<br>";
echo"<textarea name='baniere' cols='70' rows='4' wrap='VIRTUAL'><a href='". $nuked['url']."/'><img src='". $nuked['url']."/modules/myliens/images/banner.png' alt='". $nuked['slogan']."'></a></textarea>";
echo"<br><br>";

//lien flux
echo"<p><div align='center'><h3>"._LI_RSS." ". $nuked['name']."</h3></div></p>";
echo""._LI_RSS_NEWS."<br><a href='".$nuked['url']."/rss/news_rss.php'><img src='". $nuked['url']."/modules/myliens/images/rss_news.png'></a><br>";
echo""._LI_RSS_FORUM."<br><a href='".$nuked['url']."/rss/forum_rss.php'><img src='". $nuked['url']."/modules/myliens/images/rss_forum.png'></a><br>";
echo""._LI_RSS_LIENS."<br><a href='".$nuked['url']."/rss/links_rss.php'><img src='". $nuked['url']."/modules/myliens/images/rss_liens.png'></a><br>";
echo""._LI_RSS_DOWNLOADS."<a href='".$nuked['url']."/rss/download_rss.php'><br><img src='". $nuked['url']."/modules/myliens/images/rss_downloads.png'></a><br>";

echo""._LI_LIENS_ADVERT2."<br><br>";
CloseTable();


OpenTable();
echo "<p align=\"right\"><font face=\"tahoma\"><i>Adaptation pour <a href=\"http://www.nuked-klan.org/\" target=\"_blank\">n<font color=red>U</font>ked</a> par <a href=\"http://www.inconnueteam.fr\" target=\"_blank\">kotshiro</a></i>&nbsp;";
CloseTable();

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
