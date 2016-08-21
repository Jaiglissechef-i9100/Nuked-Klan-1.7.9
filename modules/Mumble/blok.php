<link rel="stylesheet" href="modules/Mumble/mumbleChannelViewer.css" type="text/css" />
<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');

global $nuked, $language, $user;
translate("modules/Search/lang/" . $language . ".lang.php");
?>
<div id="mumbleViewer" class="mumbleViewerIconsDefault mumbleViewerColorBlack">
		<?php
			require_once( 'mumbleChannelViewer.php' );
			$sql=mysql_query("SELECT mumble_jsonurl FROM " . $nuked['prefix'] . "_mumble");
			list($dataUrl) = mysql_fetch_array($sql);
			echo MumbleChannelViewer::render( $dataUrl, 'json' );
		?>
	</div>
