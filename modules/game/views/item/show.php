<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="titreForm">
		<?php if( $item->image ) : ?>
				<style type="text/css">
						.vignette_detail { 
								background-image:url("<?php echo url::base(); ?>images/items/<?php echo $item->image; ?>"); 
								background-position:center;
								background-repeat:no-repeat;
						}
				</style>
				<div class="vignette">
						<div class="vignette_detail" ></div>
				</div>
		<?php endif ?>
		<div class="titreCentent"><?php echo $item->name; ?></div>
		<div class="spacer"></div>
</div>
<div class="contentForm">
		<div class="detailComment"><?php echo $item->comment; ?></div>
		<?php if( $item->nbr ) : ?>
				<div class="detailNbr"><?php echo Kohana::lang( 'item.you_have' ); ?> : <?php echo number_format( $item->nbr ); ?></div>
		<?php endif ?>
		<?php if( $item->quick && !$item->cle && !$item->protect ) : ?>
				<div class="detailQucik"><?php echo Kohana::lang( 'item.object_is_quick' ); ?></div>
		<?php endif ?>
		<div class="detailContentExtra">
				<div class="<?php echo $item->niveau <= $user->niveau ? 'vert' : 'rouge'; ?>"><?php echo Kohana::lang( 'item.option_niveau', number_format( $item->niveau ) ); ?></div>
				<?php if( $item->hp ) : ?>
						<div><?php echo Kohana::lang( 'item.option_object', number_format( $item->hp ), Kohana::lang( 'user.hp' ) ); ?></div>
				<?php endif ?>
				<?php if( $item->mp ) : ?>
						<div><?php echo Kohana::lang( 'item.option_object', number_format( $item->mp ), Kohana::lang( 'user.mp' ) ); ?></div>
				<?php endif ?>
				<?php if( $item->protect ) : ?>
						<div class="detailQucik"><?php echo Kohana::lang( 'item.option_attaque', $item->attaque ); ?> pt(s)</div>
						<div class="detailQucik"><?php echo Kohana::lang( 'item.option_defense', $item->defense ); ?> pt(s)</div>
				<?php endif ?>
		</div>
</div>
<div class="footerForm" id="footerForm">
		<?php if( !$item->cle ) : ?>
				<?php if( !$using ) : ?>
						<input type="button" id="supprimer_<?php echo $item->id; ?>" class="button button_rouge close supprimer" value="<?php echo Kohana::lang( 'form.throw' ); ?>"/>
				<?php endif ?>
				<?php if( $item->protect ) : ?>
						<?php if( !$using && $user->niveau >= $item->niveau ) : ?>
								<input type="button" id="equiper_<?php echo $item->id; ?>" class="button button_vert close equiper" value="<?php echo Kohana::lang( 'form.equip' ); ?>"/>
						<?php elseif( $using ) : ?>
								<input type="button" id="retirer_<?php echo $item->id; ?>" class="button button_vert close retirer" value="<?php echo Kohana::lang( 'form.withdraw' ); ?>"/>
						<?php endif ?>
				<?php elseif( $user->niveau >= $item->niveau ) : ?>
						<input type="button" id="utiliser_<?php echo $item->id; ?>" class="button button_vert close utiliser" value="<?php echo Kohana::lang( 'form.use' ); ?>"/>
				<?php endif ?>
		<?php endif ?>
		<input type="button" class="button close" value="<?php echo Kohana::lang( 'form.close' ); ?>"/>
</div>
