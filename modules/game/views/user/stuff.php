<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="panel">
		<p><?php echo Kohana::lang( 'item.description_listing_stuff_user' ); ?></p>
		<div class="content-item-global inventaire itemDrag">
				<?php if( $stuffs ) : ?>
						<?php foreach( $stuffs as $item ): ?>
								<div class="content-item <?php echo isset( $arrayStuff[$item->item_id] ) ? 'element_equipe' : FALSE; ?> <?php echo 'position_equipe_'.$item->position; ?>" id="elementInventaire_<?php echo $item->item_id; ?>"> <img src="<?php echo url::base(); ?>images/items/<?php echo $item->image; ?>" width="24" height="24" title="<?php echo $item->name; ?><br/><?php echo Kohana::lang( 'user.attack' ); ?> : <?php echo number_format( $item->attaque ); ?> pt(s)<br/><?php echo Kohana::lang( 'user.defense' ); ?> : <?php echo number_format( $item->defense ); ?> pt(s)" class="imgItem" /></div>
						<?php endforeach ?>
				<?php endif ?>
		</div>
		<div class="spacer"></div>
</div>
