<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>
<style type="text/css">
		.mapTD {
				background-image:url("<?php echo url::base().'../'.$image; ?>");
		}
</style>
<div id="tableMap" class="tableMap" style="width:<?php echo $tailleMapX * ( Kohana::config( 'map.taille_case' ) + 1); ?>px; <?php if( isset( $style_table ) && $style_table )
		echo $style_table; ?>">
				 <?php for( $y = 0; $y < $tailleMapY; $y++ ) : ?>
						 <?php for( $x = 0; $x < $tailleMapX; $x++ ) : ?>
						<div class="mapTR">
								<div class="mapTD" id="TD_<?php echo $x.'-'.$y; ?>" title="<?php echo 'X : '.$x.'- Y : '.$y; ?>">
										<?php if( isset( $element[$x.'-'.$y] ) ) : ?>
												<?php for( $z = -3; $z <= 3; $z++ ) : ?>
														<?php if( isset( $element[$x.'-'.$y][$z] ) ) : ?>
																<div ondrop="dropElement(this, event)" ondragenter="return false" ondragover="return false" class="droppable elementDrop niveau_<?php echo $z; ?>" id="<?php echo $x.'-'.$y.'-'.$z; ?>" style="background: url(<?php echo url::base(); ?>../images/tilesets/<?php echo $element[$x.'-'.$y][$z]->background_map; ?>) <?php echo $element[$x.'-'.$y][$z]->position_background_map; ?>"></div>
														<?php endif ?>
												<?php endfor ?>
										<?php else : ?>
												<div ondrop="dropElement(this, event)" ondragenter="return false" ondragover="return false" class="droppable niveau_0" id="<?php echo $x.'-'.$y.'-0'; ?>"></div>
										<?php endif ?>
								</div>
						</div>
				<?php endfor ?>
		<?php endfor ?>
</div>