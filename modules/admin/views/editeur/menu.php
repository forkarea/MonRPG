<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<style type="text/css">
		.elements {
				background-image:url("<?php echo url::base().'../'.$image; ?>");
				float:left;
		}
</style>
<div class="contentMenu" id="contentMenu">
		<?php for( $y = 0; $y < $height; $y++ ) : ?>
				<?php for( $x = 0; $x < $width; $x++ ) : ?>
						<div id="<?php echo $x.'_'.$y; ?>" title="<?php echo $x.'-'.$y; ?>" draggable="true" ondragstart="dragElement(this, event)" ondragend="init_img(this)" class="elements" style="background-position:<?php echo '-'.($x * 32).'px -'.($y * 32).'px'; ?>;">
								<?php if( isset( $bloc_tileset[$x.'-'.$y] ) ) : ?>
										<img src="<?php echo url::base(); ?>images/editeur/more.png" alt="+" title="<?php echo!empty( $bloc_tileset[$x.'-'.$y]->title ) ? $bloc_tileset[$x.'-'.$y]->title : Kohana::lang( 'editeur.select_block' ); ?>" class="multiDrag" id="<?php echo $x.'-'.$y.'-'.($bloc_tileset[$x.'-'.$y]->x_max + 1).'-'.($bloc_tileset[$x.'-'.$y]->y_max + 1); ?>" />
								<?php endif ?>
						</div>
				<?php endfor ?>
		<?php endfor ?>
		<div class="spacer"></div>
</div>
