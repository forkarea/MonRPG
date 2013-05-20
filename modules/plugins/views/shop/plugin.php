<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<?php if( $data->image ) : ?>

		<div class="avatarAction" id="avatarAction" style="background-image:url('<?php echo url::base(); ?>images/modules/<?php echo $data->image; ?>');"></div>
<?php endif ?>
<div class="contenerActionStat">
		<h1><?php echo $data->nom; ?>
				<?php if( $admin ) : ?>
						<a href="<?php echo url::base(); ?>admin/index.php/elements/show/<?php echo $data->id_module; ?>"  title="<?php echo Kohana::lang( 'form.edit' ); ?>" target="blank"><img src="<?php echo url::base(); ?>images/orther/edit.png"  alt="<?php echo Kohana::lang( 'form.edit' ); ?>"/></a>
				<?php endif; ?></h1>
		<p><?php echo Kohana::lang( 'shop.desc_shop' ); ?></p>
</div>
<div class="spacer"></div>
<div class="bontonActionRight">
		<input type="button" class="button button_vert" id="show_shop" value="<?php echo Kohana::lang( 'shop.button_look' ); ?>"/>
		<input type="button" class="button button_vert" id="sale_shop" value="<?php echo Kohana::lang( 'shop.button_sale' ); ?>"/>
</div>
<div class="spacer"></div>
<script>
		$(function(){ 
				$('#show_shop').click(function() {  $('#commandActionContent').load( url_script+'actions/shop/show' ); }); 
				$('#sale_shop').click(function() {  $('#commandActionContent').load( url_script+'actions/shop/sale' ); }); 
		});
</script> 
