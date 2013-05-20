<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="panel">
		<p><?php echo Kohana::lang( 'item.description_listing_item_user' ); ?></p>
		<div class="content-item-global inventaire itemDrag" ondrop="dropInventaire(this, event)" id="inventaire_0" ondragenter="return false" ondragover="return false">
				<?php if( $items ) : ?>
						<?php foreach( $items as $item ): ?>
								<div draggable="true" ondragstart="dragInventaire(this, event)" id="elementInventaire_<?php echo $item->item_id; ?>" class="element-item quick_item">
										<div class="nombre">
												<?php echo $item->nbr; ?>
										</div>
										<img src="<?php echo url::base(); ?>images/items/<?php echo $item->image; ?>" width="24" height="24" title="<?php echo $item->name; ?><br/><?php echo Kohana::lang( 'user.hp' ); ?> : <?php echo number_format( $item->hp ); ?> pt(s)<br/><?php echo Kohana::lang( 'user.mp' ); ?> : <?php echo number_format( $item->mp ); ?> pt(s)" class="imgItem" /> </div>
						<?php endforeach ?>
				<?php endif ?>
		</div>
		<div class="spacer"></div>
</div>