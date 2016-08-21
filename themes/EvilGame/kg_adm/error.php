<?php
    if ($visiteur == 9)
    {
//Reponse des requetes :
if($mess === 'ok')
{
echo '<br/>	
	<table width="45%" align="center" class="tableaux3"><tr>
	<td><img src="images/ok.png" alt="error" /></td><td align="center">'.mess_ok.'</td></tr></table><br/>';
	
}
elseif($mess === 'err01')
{
	echo '<br/><table width="85%" align="center" class="tableaux2"><tr>
	<td><img src="images/err.png" alt="error" /></td><td align="center">'.mess_err01.'</td></tr></table><br/><br/>
	';	
}
elseif($mess === 'err02')
{
	echo '<br/><table width="85%" align="center" class="tableaux2"><tr>
	<td><img src="images/err.png" alt="error" /></td><td align="center">'.mess_err02.'</td></tr></table><br/><br/>
	';	
}
elseif($mess === 'err03')
{
	echo '<br/><table width="85%" align="center" class="tableaux2"><tr>
	<td><img src="images/err.png" alt="error" /></td><td align="center">'.mess_err03.'</td></tr></table><br/><br/>
	';	
}

elseif($mess === 'err04')
{
	echo '<br/><table width="85%" align="center" class="tableaux2"><tr>
	<td><img src="images/err.png" alt="error" /></td><td align="center">'.mess_err04.'</td></tr></table><br/><br/>
	';	
}
elseif($mess === 'err05')
{
	echo '<br/><table width="85%" align="center" class="tableaux2"><tr>
	<td><img src="images/err.png" alt="error" /></td><td align="center">'.mess_err05.'</td></tr></table><br/><br/>
	';	
}
elseif($mess === 'err06')
{
	echo '<br/><table width="85%" align="center" class="tableaux2"><tr>
	<td><img src="images/err.png" alt="error" /></td><td align="center">'.mess_err06.'</td></tr></table><br/><br/>
	';	
}
elseif($mess === 'err07')
{
	echo '<br/><table width="85%" align="center" class="tableaux2"><tr>
	<td><img src="images/err.png" alt="error" /></td><td align="center">'.mess_err07.'</td></tr></table><br/><br/>
	';	
}
}
?>