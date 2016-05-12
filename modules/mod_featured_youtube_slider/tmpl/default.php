<?php
/**
* Featured Youtube Slider - Joomla Module
* Version			: 3.1
* Created by		: RBO - http://www.rumahbelanja.com & AppsNity - http://www.appsnity.com
* Created on		: Oct 2009 (Joomla 1.5.x), Dec 2010 (Joomla 1.6.x), Sept 30th, 2011 (For Joomla 1.7.x), August 27th, 2012 (For Joomla 2.5.x), March 9th, 2013 (For Joomla 3.0.x)
* Updated			: Nov 20th, 2014 (For Joomla 3.x.x)
* Package			: Joomla 3.x.x
* License			: http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<div class="responsive modfytslider">
<div id="fytslider<?php echo $nummod; ?>" class="sliderwrapper">
	<?php for ($i=0; $i<$numyoutube; $i++) { ?>
		
		<?php //Determined AutoPlay	
		$auto_play=0;	if (($autoplay==1) and ($i==0)): $auto_play=1; endif;
		?>
		
	<div class="contentdiv">
		<div class="fyts-videoWrapper">
		
		<iframe id="ytplayer" width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $youtubelist[$i];?>?theme=<?php echo $player_ctrl_theme;?>&color=<?php echo $player_ctrl_progress;?>&autohide=<?php echo $player_ctrl;?>&showinfo=<?php echo $show_info;?>&autoplay=<?php echo $auto_play;?>" frameborder="0" <?php if($fullsc_btn):?>allowfullscreen <?php endif;?>/></iframe>
		 
		</div>
	</div>
	<?php } ?>
</div>

<div id="paginate-fytslider<?php echo $nummod; ?>" class="paginationfytslide">
	<div style="text-align: <?php echo $thumb_align; ?>;" class="paginationfytslide-inner">
	<?php for ($i=0; $i<$numyoutube; $i++) { ?>
		<a href="#" class="toc">
			<img src="https://i3.ytimg.com/vi/<?php echo $youtubelist[$i];?>/default.jpg" width="<?php echo $width_thumb; ?>%" height="auto"></img>
		</a>
	<?php } ?>
	</div>
	<div style="text-align: right; font-size:8px; padding-right:3px; font-family:fantasy; color:#800000;"><a href="http://showlands.com" target="_blank" title="Video System by Featured YouTube Slider">YouTube Slider</a></div>
</div>
</div>
<script type="text/javascript">

featuredcontentslider.init({
	id: "fytslider<?php echo $nummod; ?>",  //id of main slider DIV
	contentsource: ["inline", ""],  
	toc: "markup",  //Valid values: "#increment", "markup", ["label1", "label2", etc]
	nextprev: ["Previous", "Next"],  //labels for "prev" and "next" links. Set to "" to hide.
	revealtype: "click", //Behavior of pagination links to reveal the slides: "click" or "mouseover"
	enablefade: [true, 0.2],  //[true/false, fadedegree]
	autorotate: [false, 3000],  //[true/false, pausetime]
	onChange: function(previndex, curindex){  //event handler fired whenever script changes slide
		//previndex holds index of last slide viewed b4 current (1=1st slide, 2nd=2nd etc)
		//curindex holds index of currently shown slide (1=1st slide, 2nd=2nd etc)
	}
})

</script>