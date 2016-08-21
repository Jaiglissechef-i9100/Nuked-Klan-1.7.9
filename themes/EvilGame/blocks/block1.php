	<div id="top">
		<div class="videos">
			<div class="viewAll">
				<?php 
				include_once("themes/EvilGame/kg_adm/cfg/video.txt");			
				if($play === '1') { ?>
				<a href="<?php echo $jw_code; ?>" title="" ><img src="themes/EvilGame/images/<?php echo $var_l; ?>/view.png" alt="view" /></a>
				<?php } ?></div>				
			<div class="titleBlock"><img src="themes/EvilGame/images/en/videos.png" alt="videos" /></div>
			<div class="bgvideo"><?php  if($play === '1') include_once('./themes/EvilGame/blocks/video.php'); else include_once('./themes/EvilGame/blocks/video2.php');  ?></div>
		</div>
		<div class="thread">
			<div class="viewAll"><a href="index.php?file=Forum" title="" ><img src="themes/EvilGame/images/<?php echo $var_l; ?>/view.png" alt="view" /></a></div>
			<div class="titleBlock"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/threads.png" alt="videos" /></div>
			<div class="bgthread"><?php include_once("themes/EvilGame/blocks/kg_latesttopics.php"); ?></div>
		</div>
		<div class="squads">
			<div class="viewAll" style="padding-left:260px;"><a href="index.php?file=Team" title="" ><img src="themes/EvilGame/images/<?php echo $var_l; ?>/view.png" alt="view" /></a></div>
			<div class="titleBlock" style="width:310px;"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/team.png" alt="videos" /></div>
			<div class="squads_pic"><div class="squads_fire"></div>
			<?php include_once("themes/EvilGame/blocks/kg_squads.php"); ?>			
			<script type="text/javascript">
			featuredcontentslider.init({id: "slider4", contentsource: ["inline", ""],toc: "markup", nextprev: ["Previous", "Next"], revealtype: "click", enablefade: [true, 0.06],  autorotate: [false, 3000], onChange: function(previndex, curindex){ }})
			</script>		
		</div>
		</div>
	</div>
