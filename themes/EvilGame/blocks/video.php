<script type='text/javascript' src='themes/EvilGame/modules/video/jwplayer.js'></script>
  <div id='preview'>This div will be replaced</div>
  <script type='text/javascript'>
  var s1 = new SWFObject('themes/EvilGame/modules/video/player.swf','ply','283','175','9','#ffffff');
  s1.addParam('allowfullscreen','true');
  s1.addParam('allowscriptaccess','always');
  s1.addParam('wmode','opaque');
  s1.addParam('image','preview.jpg');
s1.addParam('flashvars','&amp;file=<?php echo $jw_code; ?>&amp;backcolor=142a40&amp;frontcolor=999999&amp;lightcolor=000000&amp;screencolor=000000');
  s1.write('preview');
</script>
