<?php
/*------------------------------------------------------------------------
# mod_youtubeslider - Youtube Widget Slider
# ------------------------------------------------------------------------
# @author - Facebook Slider
# copyright Copyright (C) 2013 FacebookSlider.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://facebookslider.com/
# Technical Support:  Forum - http://facebookslider.com/index.php/forum
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die;
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_youtubeslider/assets/style.css');


$margintop = $params->get('margintop');
$ywidth = $params->get('ywidth');
$ybox1_width = trim($params->get( 'ywidth' )+10);

$yheight = $params->get('yheight');

?>
<div id="youtube_slider">
<?Php if($params->get('position')=='left'){ ?>
	<div id="ybox1" style="left: -<?php echo $ybox1_width;?>px; top: <?php echo $margintop;?>px; z-index: 10000;">
		<div id="yobx2" style="text-align: left;width:<?php echo $ywidth; ?>px;height:<?php echo $yheight; ?>px;">
			<a class="open" id="ytlink" href="#"></a><img style="top: 0px;right:-50px;" src="modules/mod_youtubeslider/assets/youtube-icon.png" alt="">
<?php } else { ?>	
    <div id="ybox1" style="right: -<?php echo $ybox1_width;?>px; top: <?php echo $margintop;?>px; z-index: 10000;">
	    <div id="yobx2" style="text-align: left;width:<?php echo $ywidth; ?>px;height:<?php echo $yheight; ?>px;">
			<a class="open" id="ytlink" href="#"></a><img style="top: 0px;left:-50px;" src="modules/mod_youtubeslider/assets/youtube-icon.png" alt="">
<?php } ?>
			<iframe src="https://www.youtube.com/subscribe_widget?p=<?php echo $params->get('yt_username'); ?>" class="youtube-subscribe" scrolling="no" frameborder="0"></iframe><br/>
			<iframe width="<?php echo $params->get( 'ywidth' )-10; ?>" height="<?php echo $params->get( 'yheight' )-100; ?>" src="http://www.youtube.com/embed/<?php echo $params->get( 'video_url' ); ?>" frameborder="0" allowfullscreen="yes" style="padding-top: 80px;"></iframe>

		</div>
		<div style="font-size:8px;text-align:right; position:relative;"><a href="http://www.crayfishstudios.com/" title="visit the homepage" target="_blank">crayfishstudios.com</a></div>
	</div>
			
</div>
<?php
	if (trim( $params->get( 'loadjquery' ) ) == 1){
	$document->addScript("http://code.jquery.com/jquery-latest.min.js");}
?>
	<script type="text/javascript">
		jQuery.noConflict();
		jQuery(function (){
			jQuery(document).ready(function()
				{
					jQuery.noConflict();
					jQuery(function (){
						jQuery("#ybox1").hover(function(){ 
						jQuery('#ybox1').css('z-index',101009);
						<?Php if($params->get('position')=='left'){ ?>
						jQuery(this).stop(true,false).animate({left:  0}, 500); },
						<?php } else { ?>
                        jQuery(this).stop(true,false).animate({right:  0}, 500); },
						<?php } ?>	
						function(){ 
						jQuery('#ybox1').css('z-index',10000);
						<?Php if($params->get('position')=='left'){ ?>
						jQuery("#ybox1").stop(true,false).animate({left: -<?php echo $params->get( 'ywidth' )+10; ?>}, 500); });
						<?php } else { ?>
						jQuery("#ybox1").stop(true,false).animate({right: -<?php echo $params->get( 'ywidth' )+10; ?>}, 500); });
					    <?php } ?>
						});}); });
	</script>