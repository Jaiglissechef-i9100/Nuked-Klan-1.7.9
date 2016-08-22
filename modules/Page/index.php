<?php
//-------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal                                                //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify   //
//  it under the terms of the GNU General Public License as published by   //
//  the Free Software Foundation; either version 2 of the License.         //
//-------------------------------------------------------------------------//

if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
} 

global $nuked, $user, $language;
translate("modules/Page/lang/" . $language . ".lang.php");

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
    function index($name)
    {
	global $nuked, $visiteur;

	opentable();

	if ($name != "")
	{
	    $sql = mysql_query("SELECT niveau, content, url, type FROM " . PAGE_TABLE . " WHERE titre = '" . $name . "'");
	    $count = mysql_num_rows($sql);
	}
	else if ($nuked['index_page'] != "")
	{
	    $sql = mysql_query("SELECT niveau, content, url, type FROM " . PAGE_TABLE . " WHERE titre = '" . $nuked['index_page'] . "'");
	    $count = mysql_num_rows($sql);
	}
	else
	{
	    $count = 0;	
	}

	if ($count > 0)
	{
	    list($niveau, $content, $url, $type) = mysql_fetch_array($sql);
	    $content = stripslashes($content);
		
	    if ($visiteur >= $niveau)
	    {
	        if ($content != "")
	        {
	            if ($type == "php")
	            {
			ob_start();
			$content_php = eval($content);
			$content_php = ob_get_contents();
			ob_end_clean();
			echo $content_php;
	            }
	            else
	            {
			$content = str_replace("&lt;", "<", $content);
			$content = str_replace("&gt;", ">", $content);
			echo $content;
	            }
	        }	            

	        if ($url != "")
	        {
	            if ($type == "php" && is_file("modules/Page/php/" . $url))			
	            {
			ob_start();
			$page_php =  eval(' include ("modules/Page/php/" . $url); ');
			$page_php = ob_get_contents();
			ob_end_clean();
			echo $page_php;
	            }
	            else if (is_file("modules/Page/html/" . $url))
	            {
			ob_start();
			$html = eval(' include ("modules/Page/html/" . $url); ');
			$html = ob_get_contents(); 
			ob_end_clean();

			if (ereg("<body", $html) && ereg("</body>", $html))
			{
			    preg_match_all("=<body[^>]*>(.*)</body>=siU", $html, $a); 
			    $html_page = $a[1][0];
			    echo $html_page;
			}
			else
			{
			    echo $html;
			}		
	            }
	        }		

	    }
	    else if ($niveau == 1 && $visiteur == 0)
	    {
	        echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b><br /><br /></div>";
	    }
	    else
	    {
	        echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
	    }

	}
	else
	{
	    echo "<br /><br /><div style=\"text-align: center;\">" . _NOEXIST . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a><br /><br /></div>";
	}

	closetable();
    }

    switch($_REQUEST['op'])
    {
	case "index":
    	index($_REQUEST['name']);
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
