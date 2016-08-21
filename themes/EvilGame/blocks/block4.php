	<div id="bottom">
		<div class="left">
			<div class="viewAll"><a href="index.php?file=Gallery" title="" ><img src="themes/EvilGame/images/<?php echo $var_l; ?>/view.png" alt="view" /></a></div>
			<div class="titleBlock"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/demos.png" alt="videos" /></div>
			<div class="bg_bottom">
				<div id="slider3" class="bottomE">
                    	<?php include_once("themes/EvilGame/blocks/kg_gallery.php"); ?>
					</div>
					<div class="bNumber">
						<div id="paginate-slider3" class="paginationBox">
						<a href="#1" class="toc">01</a> <a href="#2" class="toc anotherclass">02</a> <a href="#3" class="toc">03</a>	
						<a href="#1" class="toc">04</a> <a href="#2" class="toc anotherclass">05</a> <a href="#3" class="toc">06</a>										
						</div>				
					</div>
				
			</div>			
		</div>
		<div class="center">
			<div class="viewAll"><a href="index.php?file=Download" title="" ><img src="themes/EvilGame/images/<?php echo $var_l; ?>/view.png" alt="view" /></a></div>
			<div class="titleBlock"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/downloads.png" alt="videos" /></div>
			<div class="bg_bottom">
				<div id="sliderD" class="bottomE">
					<?php include_once("themes/EvilGame/blocks/kg_downloads.php"); ?>
					</div>						
					<div class="bNumber">
						<div id="paginate-sliderD" class="paginationBox">
						<a href="#1" class="toc">01</a> <a href="#2" class="toc anotherclass">02</a> <a href="#3" class="toc">03</a>	
						<a href="#1" class="toc">04</a> <a href="#2" class="toc anotherclass">05</a> <a href="#3" class="toc">06</a>										
						</div>				
					</div>
				
			</div>			
		</div>	
		<div class="right">
			<div class="viewAll"><a href="index.php?file=Members" title="" ><img src="themes/EvilGame/images/<?php echo $var_l; ?>/view.png" alt="view" /></a></div>
			<div class="titleBlock"><img src="themes/EvilGame/images/<?php echo $var_l; ?>/members.png" alt="videos" /></div>
			<div class="bg_bottom">
				<div id="sliderM" class="bottomE">
					<?php include_once("themes/EvilGame/blocks/kg_members.php"); ?>
					</div>						
					<div class="bNumber">
						<div id="paginate-sliderM" class="paginationBox">
						<a href="#1" class="toc">01</a> <a href="#2" class="toc anotherclass">02</a> <a href="#3" class="toc">03</a>	
						<a href="#1" class="toc">04</a> <a href="#2" class="toc anotherclass">05</a> <a href="#3" class="toc">06</a>										
						</div>				
					</div>
				
			</div>			
		</div>	
	<script type="text/javascript">
	featuredcontentslider.init({id: "slider3", contentsource: ["inline", ""], toc: "markup", nextprev: ["Previous", "Next"], revealtype: "click", enablefade: [true, 0.2], autorotate: [false, 3000], onChange: function(previndex, curindex){ }})
	featuredcontentslider.init({id: "sliderD", contentsource: ["inline", ""], toc: "markup", nextprev: ["Previous", "Next"], revealtype: "click", enablefade: [true, 0.2], autorotate: [false, 3000], onChange: function(previndex, curindex){ }})
	featuredcontentslider.init({id: "sliderM", contentsource: ["inline", ""], toc: "markup", nextprev: ["Previous", "Next"], revealtype: "click", enablefade: [true, 0.2], autorotate: [false, 3000], onChange: function(previndex, curindex){ }})
	</script>
	</div>