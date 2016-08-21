<?php
    if ($visiteur == 9)
    {
	?>
<table  align="center" style="padding-top:25px; padding-left:0px;" border="0" width="90%">
	<tr align="center" valign="top">
		<td><a href="theme_cfg.php?action=preferences" title="preferences"><img src="images/kg_admin/configure.png" alt="configuration" /></a></td>
		<td><a href="theme_cfg.php?action=blocks" title="blocks"><img src="images/kg_admin/block.png" alt="block" /></a></td>
		<td><a href="theme_cfg.php?action=video" title="video"><img src="images/kg_admin/video.png" alt="video" /></a></td>
	</tr>
	<tr align="center"  valign="top"  height="50">
		<td><a href="theme_cfg.php?action=preferences" title="preferences"><b><?php echo main_gen; ?></b></a></td>
		<td><a href="theme_cfg.php?action=blocks" title="blocks"><b><?php echo main_block; ?></b></a></td>
		<td><a href="theme_cfg.php?action=video" title="video"><b><?php echo main_video; ?></b></a></td>
	</tr>
	<tr><td height="30">&nbsp;</td></tr>
	<tr align="center">
		
		<td><a href="theme_cfg.php?action=slider" title="topmatch"><img src="images/kg_admin/slide.png" alt="other" /></td>
		<td><a href="theme_cfg.php?action=topmatch" title="topmatch"><img src="images/kg_admin/other.png" alt="other" /></td>
	</tr>
	<tr align="center">
		<td><a href="theme_cfg.php?action=slider" title="topmatch"><b><?php echo main_coverage; ?></b></a></td>
		<td><a href="theme_cfg.php?action=topmatch" title="topmatch"><b><?php echo main_other; ?></b></a></td>
	</tr>
	<tr><td height="30">&nbsp;</td></tr>
	<tr><td height="30">&nbsp;</td></tr>
</table>
<br/><br/><br/>
<center><a href="../../index.php" title="index"><b><?php echo main_mess; ?></b></a></center>
<?php
}?>