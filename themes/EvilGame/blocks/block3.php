	<div id="left">
		<div class="fire"></div>
		<div class="titleBlockCenter"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/matches.png" alt="matches" /></div>
			<?php 
			include_once('themes/EvilGame/kg_adm/cfg/topmatch.txt');
			include_once('./themes/EvilGame/blocks/kg_topmatch.php'); 
			?>
	</div>		
	<div id="right">
		<div class="titleBlockCenter" style="width:495px;"><img src="themes/EvilGame/images/en/articles.png" alt="articles" /></div>
		<div style="height:110px;"><?php 
			include_once('themes/EvilGame/blocks/kg_articles.php');
		?></div>
		<div class="titleBlockCenter" style="width:495px;padding-bottom:8px;"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/matchs.png" alt="articles" /></div>
		
		<div id="bg_matchs">
		<div id="paginate-slider2" class="pagination">
			<div class="recent"><a href="#1" class="toc">Recent matches</a></div>
			<div class="upcoming"><a href="#2" class="toc">Upcoming matches</a></div>
		</div>

		<div id="slider2" class="sliderwrapper">
			<div class="contentdiv"><?php include_once("themes/EvilGame/blocks/kg_result.php"); ?></div>
			<div class="contentdiv"><?php include_once("themes/EvilGame/blocks/kg_nextresultat.php"); ?></div>
		</div>	
		<script type="text/javascript">
		featuredcontentslider.init({id: "slider2", contentsource: ["inline", ""],	toc: "markup",nextprev: ["Previous", "Next"],	revealtype: "click",enablefade: [false, 0.06], autorotate: [false, 3000], onChange: function(previndex, curindex){ }})
		</script>			
		</div>
	</div>
