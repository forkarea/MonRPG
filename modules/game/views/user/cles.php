<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="panel">
		<p><?php echo Kohana::lang( 'item.description_listing_cle_user' ); ?></p>
		<div class="content-item-global inventaire">
				<?php if( $cles ) : ?>
						<?php foreach( $cles as $item ): ?>
								<div class="content-item" id="elementInventaire_<?php echo $item->item_id; ?>"> <img src="<?php echo url::base(); ?>images/items/<?php echo $item->image; ?>" width="24" height="24" class="imgItem" /></div>
								<?php endforeach ?>
						<?php endif ?>
		</div>
</div>