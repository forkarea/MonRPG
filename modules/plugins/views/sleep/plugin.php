<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<?php if( $data->image ) : ?>
		<div class="avatarAction" id="avatarAction" style="background-image:url('<?php echo url::base(); ?>images/modules/<?php echo $data->image; ?>');"></div>
<?php endif ?>
<div class="contenerActionStat">
		<h1><?php echo Kohana::lang( 'sleep.title_view' ); ?></h1>
		<?php if( !$valide ) : ?>
				<b class="rouge"><?php echo Kohana::lang( 'sleep.no_sleep' ); ?></b>
		<?php endif ?>
		<p><?php echo Kohana::lang( 'sleep.desc_sleep' ); ?>
				<?php if( $data->prix ) : ?>
						<?php echo Kohana::lang( 'sleep.price_sleep' ); ?> <strong class="rouge"><?php echo number_format( $data->prix ).' '.Kohana::config( 'game.money' ); ?></strong>
				<?php endif ?>
		</p>
</div>
<div class="spacer"></div>
<div class="bontonActionRight">
		<?php if( $valide ) : ?>
				<input type="button" class="button button_vert show_sleep" value="<?php echo Kohana::lang( 'sleep.action_sleep' ); ?>"/>
		<?php endif ?>
</div>
<div class="spacer"></div>
<script>
		$(function(){ $('.show_sleep').click(function() {  $('#commandActionContent').load( url_script+'actions/sleep/show' ) }); });
</script> 
