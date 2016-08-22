<?PHP
define ("INDEX_CHECK", 1);
include ("globals.php");
include ("conf.inc.php");
include("nuked.php");
include ("Includes/constants.php");
$url = $_SERVER['QUERY_STRING'];

$mors = "" . $nuked['url'] . "/index.php?file=Search&op=mod_search&main=" . $url . "" ;
$new_url = redirect($mors);
echo "$new_url";
?> 