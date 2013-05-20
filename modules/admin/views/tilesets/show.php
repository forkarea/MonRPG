<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<style type="text/css">
		.elements {
				background-image:url("<?php echo url::base().'../images/tilesets/'.$image; ?>");
		}
</style>

<article class="module width_half">
		<header><h3 class="tabs_involved"><?php echo Kohana::lang( 'form.title_default' ); ?></h3>
		</header>
		<div class="module_content">
				<h2><?php echo Kohana::lang( 'tileset.title_show' ); ?></h2>
				<p><?php echo Kohana::lang( 'tileset.modif_name' ); ?></p>
				<div style=" display:none;" id="block_action">
						<fieldset>
								<input type="text" value="" id="title_block" style="width:50%" />
								<input type="button" value="<?php echo Kohana::lang( 'form.annul' ); ?>" id="annul_block" />
								<input type="button" value="<?php echo Kohana::lang( 'form.save' ); ?>" id="save_block" />
						</fieldset>
				</div>
				<div class="clear"></div>
				<div id="contentDetail">
						<?php if( $tileset ) : ?>
								<?php foreach( $tileset as $row ) : ?>
										<?php $id = $row->x_min.'-'.$row->y_min.'-'.($row->x_max + 1).'-'.($row->y_max + 1); ?>
										<div class="listeBlock" id="<?php echo $id; ?>"><span id="<?php echo $row->id_drag; ?>" class="jedit"><?php echo $row->title ? $row->title : Kohana::lang('form.no_title'); ?></span>
												<div class="deleteTileset"><a href="javascript:;" class="delete-tileset" id="delete_<?php echo $id; ?>"><?php echo Kohana::lang( 'form.delete' ); ?></a></div>
										</div>
								<?php endforeach ?>
						<?php endif ?>
				</div>
		</div>
</article>
<article class="module width_half">
		<header><h3><?php echo Kohana::lang( 'form.info_sup' ); ?></h3></header>
		<div class="module_content">
				<div class="contentMenu" id="contentMenu">
						<div class="menu">
								<?php for( $y = 0; $y < $height; $y++ ) : ?>
										<?php for( $x = 0; $x < $width; $x++ ) : ?>
												<div id="<?php echo $x.'_'.$y; ?>" class="elements" style="background-position:<?php echo '-'.($x * 32).'px -'.($y * 32).'px'; ?>;"></div>
										<?php endfor ?>
								<?php endfor ?>
								<div class="clear"></div>
						</div>
				</div>
		</div>
		<footer>
				<div class="submit_link">
						<input type="button" id="change" title="<?php echo Kohana::lang( 'editeur.title_modif_img' ); ?>" value="<?php echo Kohana::lang( 'editeur.change_tileset' ); ?>" class="alt_btn" />
						<input type="hidden" value="<?php echo $optionTilesets; ?>" id="listTilesets"/>
				</div>
		</footer>
</article>
<input type="hidden" id="image" value="<?php echo $image; ?>" />
<script>
		var lang_delete = '<?php echo Kohana::lang( 'form.delete' ); ?>',
		file_image = '<?php echo $image; ?>',
		sauv_edit = '<?php echo Kohana::lang( 'form.save' ); ?>',
		annul_edit = '<?php echo Kohana::lang( 'form.annul' ); ?>',
		laoding_edit = '<?php echo Kohana::lang( 'form.loading' ); ?>';
</script> 