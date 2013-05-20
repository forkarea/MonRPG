<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<div class="avatarAction" id="avatarAction" style="background-image:url('<?php	echo	url::base();	?>images/map/<?php echo $data->id_region; ?>_global_90.png');"></div>
<div class="contenerActionStat">
		<h1><?php echo Kohana::lang( 'plg_map.look_map' ); ?></h1>
		<p><?php echo Kohana::lang( 'plg_map.look_desc' ); ?></p>
</div>
<div class="bontonActionRight">
		<input type="button" class="button button_vert show_map" id="show_map" value="<?php echo Kohana::lang( 'plg_map.look_map' ); ?>"/>
</div>
<div class="spacer"></div>
<script>
		$(function(){ $('#show_map').click(function() {  $('#commandActionContent').load( url_script+'actions/map/show' ); }); });
</script> 