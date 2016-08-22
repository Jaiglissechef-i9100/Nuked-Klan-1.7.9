<?php

if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');

//réglage captcha (auto | on | off)
define("_NKCAPTCHA","auto");
if (isset($_SESSION['captcha']))
	$GLOBALS['nkCaptchaCache'] = $_SESSION['captcha'];

function create_captcha(){

include("keys.php");

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

echo '<tr><td>&nbsp;</td></tr><tr><td><b>' , _SECURITYCODE , ' :</b><br/><br/>';

echo recaptcha_get_html($publickey, $error);

	return($error);
}

?>