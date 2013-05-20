<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div id="user_xp" class="donnee bottom_map_user"><?php echo graphisme::BarreGraphique( $user->xp, $user->niveau_suivant(), 992, Kohana::lang( 'user.xp' )  ); ?></div>

<div class="table-line inventaire bottom_map_user">
	<?php $nbr = 1; ?>
			 <?php for( $i = 0; $i < 15; $i++ ) : ?>
		 		<div ondrop="dropInventaire(this, event)" ondragenter="return false" ondragover="return false" id="inventaire_<?php echo $nbr; ?>" class="content-item footer_inventaire">
						 <?php if( isset( $items[$nbr] ) && ( $item = $items[$nbr] ) ) : ?>
			 				<div draggable="true" ondragstart="dragInventaire(this, event)" id="elementInventaire_<?php echo $item->item_id; ?>" class="element-item">
			 					<div class="nombre"><?php echo $item->nbr; ?></div>
			 					<img src="<?php echo url::base(); ?>images/items/<?php echo $item->image; ?>" width="24" height="24" title="<?php echo $item->name; ?><br/><?php echo Kohana::lang( 'user.hp' ); ?> : <?php echo number_format( $item->hp ); ?> pt(s)<br/><?php echo Kohana::lang( 'user.mp' ); ?> : <?php echo number_format( $item->mp ); ?> pt(s)" class="imgItem" /></div>
							 <?php endif ?>
		 			</div>
				 <?php $nbr++; ?>
			 <?php endfor ?>
			 <div class="spacer"></div>
</div>
<div class="spacer"></div>